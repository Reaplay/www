<?php
require "include/connect.php";

dbconn();
if (get_user_class() < UC_HEAD)
	stderr("Ошибка","В доступе отказано");

if($_GET['id'] and !is_valid_id($_GET['id'])){
		stderr("Ошибка","Ошибка ID отделения");		//запись в лог
}

$REL_TPL->stdhead('Отделение');

if($_GET['action']=="disable"){
	sql_query("UPDATE `department` SET `disable` = '1' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Отделение отключен');
	
}
if($_GET['action']=="enable"){
	sql_query("UPDATE `department` SET `disable` = '0' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Отделение включен');
	
}
if($_POST['action']=="edit"){
	sql_query("UPDATE `department` SET `name` = '".$_POST['name']."', `parent` = '".$_POST['parent']."' WHERE `id` =".$_GET['id'].";");
	$REL_TPL->stdmsg('Выполнено','Название изменено');
}
if($_POST['action']=="add"){
	
	sql_query("INSERT INTO `department` (`name`,`parent`) VALUES ('".$_POST['name']."','".$_POST['id_parent']."');");
	$REL_TPL->stdmsg('Выполнено','Отделение добавлено');
}
if($_GET['action']=="edit"){
	$res=sql_query("SELECT * FROM `department` WHERE id = '".$_GET['id']."'")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Такой отделение отсутствует в базе","no");
	}
	
	$res_p=sql_query("SELECT * FROM `department` WHERE parent = '0'")  or sqlerr(__FILE__, __LINE__);
	$data_department_parents .= "<option value=\"0\">Корневой</option>";
	while ($row_p = mysql_fetch_array($res_p)){
		$data_department_parents .= "<option value=\"".$row_p['id']."\">".$row_p['name']."</option>";
	}
	$data_department = mysql_fetch_array($res);
	
	$action	="edit";
	
	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->assignByRef("id",$_GET['id']);
	$REL_TPL->assignByRef('data_department',$data_department);
	$REL_TPL->assignByRef('data_department_parents',$data_department_parents);
	$REL_TPL->output("department_add_edit","admincp");
	
}
elseif($_GET['action']=="add"){
	$res_p=sql_query("SELECT * FROM `department` WHERE parent = '0'")  or sqlerr(__FILE__, __LINE__);
	$data_department_parents .= "<option value=\"0\">Корневой</option>";
	while ($row_p = mysql_fetch_array($res_p)){
		$data_department_parents .= "<option value=\"".$row_p['id']."\">".$row_p['name']."</option>";
	}
	$action	="add";
	$REL_TPL->assignByRef("action",$action);
	$REL_TPL->assignByRef('data_department_parents',$data_department_parents);
	$REL_TPL->output("department_add_edit","admincp");
}
else {
	$res=sql_query("SELECT * FROM `department`;")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Отделениеы банка в базе не обнаружены");
	}
	$i=0;
	while ($row = mysql_fetch_array($res)){
		$data_department[]=$row;
		if($data_department[$i]['parent']){
			$sub_res=sql_query("SELECT name FROM `department` WHERE id = ".$data_department[$i]['parent'].";")  or sqlerr(__FILE__, __LINE__);
			while ($subrow = mysql_fetch_array($sub_res)){
				$data_department[$i]['n_parent'] = $subrow['name'];
			}
		}
		$i++;
	}

	
	$REL_TPL->assignByRef('data_department',$data_department);
	$REL_TPL->output("department_index","admincp");
}
$REL_TPL->stdfoot();
?>