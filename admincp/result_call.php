<?php

if($_GET['id'] and !is_valid_id($_GET['id'])){
		stderr("Ошибка","Ошибка ID результата","no");		//запись в лог
}

$REL_TPL->stdhead('Результат контакта');

if($_GET['action']=="disable"){
	sql_query("UPDATE `result_call` SET `disable` = '1' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Результат контакта отключен');
	
}
if($_GET['action']=="enable"){
	sql_query("UPDATE `result_call` SET `disable` = '0' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Результат контакта включен');
	
}
if($_POST['action']=="edit"){
	sql_query("UPDATE `result_call` SET `text` = '".$_POST['text']."', `type_contact` = '".$_POST['type_contact']."' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Контакт изменен');
}
if($_POST['action']=="add"){
	if(!is_valid_id($_POST['type_contact']))
		stderr("Ошибка","Ошибка типа контакта","no");
	sql_query("INSERT INTO `result_call` (`text`, `type_contact`) VALUES ('".$_POST['text']."', '".$_POST['type_contact']."');");
	$REL_TPL->stdmsg('Выполнено','Контакт добавлен');
}
if($_GET['action']=="edit"){
	$res=sql_query("SELECT * FROM `result_call` WHERE id = '".$_GET['id']."'")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Такой результат контакта отсутствует в базе","no");
	}
	$data_result_call = mysql_fetch_array($res);

	$res_p=sql_query("SELECT * FROM `type_contact` ")  or sqlerr(__FILE__, __LINE__);
	$data_contact .= "<option value=\"0\">Выберите вариант</option>";
	while ($row_p = mysql_fetch_array($res_p)){
		$select = "";
		if ($data_result_call['type_contact'] == $row_p['id']){
			$select = "selected = \"selected\"";
		}
		$data_contact .= "<option ".$select." value=\"".$row_p['id']."\">".$row_p['text']."</option>";
	}


	$action	="edit";

	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->assignByRef("id",$_GET['id']);
	$REL_TPL->assignByRef('data_result_call',$data_result_call);
	$REL_TPL->assignByRef('data_contact',$data_contact);
	$REL_TPL->output("result_call_add_edit","admincp");
	
}
elseif($_GET['action']=="add"){
	
	$res_p=sql_query("SELECT * FROM `type_contact` ")  or sqlerr(__FILE__, __LINE__);
	$data_contact .= "<option value=\"0\">Выберите вариант</option>";
	while ($row_p = mysql_fetch_array($res_p)){
		$data_contact .= "<option value=\"".$row_p['id']."\">".$row_p['text']."</option>";
	}
	
	$action	="add";
	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->assignByRef('data_contact',$data_contact);
	$REL_TPL->output("result_call_add_edit","admincp");
}
else {
	$res=sql_query("SELECT * FROM `result_call`;")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Результат контакта в базе не обнаружены. <a href=\"action_admin.php?module=result_call&action=add\">Добавить</a>","no");
	}
	$i=0;
	while ($row = mysql_fetch_array($res)){
		$data_result_call[]=$row;
	}

	
	$REL_TPL->assignByRef('data_result_call',$data_result_call);
	$REL_TPL->output("result_call_index","admincp");
}
$REL_TPL->stdfoot();
?>