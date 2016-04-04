<?php

if(get_user_class() < UC_HEAD){
	$department = "WHERE client.department = '".$CURUSER['department']."' AND client.manager = '".$CURUSER['id']."'";
}
if(get_user_class() == UC_HEAD){
	$department = "WHERE client.department = '".$CURUSER['department']."'";
}

$res=sql_query("SELECT client.*, department.name as d_name, users.name as u_name FROM `client` LEFT JOIN department ON department.id = client.department LEFT JOIN  users ON users.id = client.manager ".$department.";")  or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиенты не найдены");
}
while ($row = mysql_fetch_array($res)){
	$data_client[]=$row;
}

$REL_TPL->assignByRef('id',$_GET['id']);
$REL_TPL->output("statictic","basic");

?>