<?php

$page = (int) $_GET["page"];

if ($page < 2){
	$start_page = 0;
	$page = 1;
}
else {
	$start_page = ($page - 1)*$REL_CONFIG['per_page_users'];
}
$cpp = $REL_CONFIG['per_page_users'];
$limit = "LIMIT ".$start_page." , ".$cpp;


//выводим список всех пользователей, которых мы можем редактировать
// всех пользователей могут редактировать лишь принадлежащие к ОО Самарский
/*if(get_user_class()==UC_HEAD){
	$department = "users.department = '".$CURUSER['department']."' AND";
}
	elseif(get_user_class()==UC_POWER_HEAD){
		$department = "(department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')  AND";
		$left_join = "LEFT JOIN department ON department.id = users.department";
	}
if(get_user_class() <= UC_ADMINISTRATOR){
	//$banned = "AND users.banned = '0' ";
}*/

	$filter = filter_index($_GET,"users");


$res=sql_query("SELECT users.id, users.enable, users.banned, users.login, users.name, users.department, department.name as d_name, department.parent FROM `users` LEFT JOIN department ON department.id = users.department  WHERE `class` <= '".$CURUSER['class']."' ".$filter['add_where']."  ".$limit.";")  or sqlerr(__FILE__, __LINE__);



if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Пользователи не найдены","no");
}

while ($row = mysql_fetch_array($res)){
	$data_user[]=$row;
}

	// спиcок отделений для фильтра
	$list_department = get_department(get_user_class(),$CURUSER['department'],$_GET['department']);


//необходима оптимизация 
// узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
$res = sql_query("SELECT SUM(1) FROM users LEFT JOIN department ON department.id = users.department WHERE `class` <= '".$CURUSER['class']."' ".$filter['add_where']." ".$banned.";") or sqlerr(__FILE__,__LINE__);
$row = mysql_fetch_array($res);
//всего записей
$count = $row[0];
//всего страниц
$max_page = ceil($count / $cpp);
//print $cpp;



$REL_TPL->assignByRef('data_user',$data_user);
$REL_TPL->assignByRef('list_department',$list_department);
$REL_TPL->assignByRef('add_link',$filter['add_link']);
$REL_TPL->assignByRef('cpp',$cpp);
$REL_TPL->assignByRef('page',$page);
	$REL_TPL->assignByRef('count',$count);
//$REL_TPL->assignByRef('add_link',$add_link);
$REL_TPL->assignByRef('max_page',$max_page);

$REL_TPL->output("index","user");



?>
