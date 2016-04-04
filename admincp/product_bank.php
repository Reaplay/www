<?php
require "include/connect.php";

dbconn();
if (get_user_class() < UC_HEAD)
	stderr("Ошибка","В доступе отказано");

if($_GET['id'] and !is_valid_id($_GET['id'])){
		stderr("Ошибка","Ошибка ID продукта");		//запись в лог
}

$REL_TPL->stdhead('Продукты банка');

if($_GET['action']=="disable"){
	sql_query("UPDATE `product` SET `disable` = '1', `edited` = '".time()."' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Продукт отключен');
	
}
if($_GET['action']=="enable"){
	sql_query("UPDATE `product` SET `disable` = '0', `edited` = '".time()."' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Продукт включен');
	
}
if($_POST['action']=="edit"){
	sql_query("UPDATE `product` SET `name` = '".$_POST['name']."', `edited` = '".time()."' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Название изменено');
}
if($_POST['action']=="add"){
	sql_query("INSERT INTO `product` (`name`, `added`) VALUES ('".$_POST['name']."', '".time()."');");
	$REL_TPL->stdmsg('Выполнено','Название изменено');
}
if($_GET['action']=="edit"){
	$res=sql_query("SELECT * FROM `product` WHERE id = '".$_GET['id']."'")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Такой продукт отсутствует в базе","no");
	}
	$data_product = mysql_fetch_array($res);
	$action	="edit";
	
	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->assignByRef("id",$_GET['id']);
	$REL_TPL->assignByRef('data_product',$data_product);
	$REL_TPL->output("product_bank_add_edit","admincp");
	
}
elseif($_GET['action']=="add"){
	
	$action	="add";
	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->output("product_bank_add_edit","admincp");
}
else {
	$res=sql_query("SELECT * FROM `product`;")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Продукты банка в базе не обнаружены. <a href='action_admin.php?module=product_bank&action=add'>Добавить</a>","no");
	}
	$i=0;
	while ($row = mysql_fetch_array($res)){
		$data_product[]=$row;
		//костыль для красивого времени
		$data_product[$i]['added']=mkprettytime($row['added']);
		if ($data_product[$i]['edited'] == '0')
			$data_product[$i]['edited'] = "Не изменялось";
		else
			$data_product[$i]['edited']=mkprettytime($row['edited']);
	
		$i++;
	}
	//print_r ($data_product);
	////print $data_product['0']['']['edited'];
	//die();
	
	$REL_TPL->assignByRef('data_product',$data_product);
	$REL_TPL->output("product_bank_index","admincp");
}
$REL_TPL->stdfoot();
?>