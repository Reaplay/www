<?php

$page = (int) $_GET["page"];

if ($page < 2){
	$start_page = 0;
	$page = 1;
}
else {
	$start_page = ($page - 1)*$REL_CONFIG['per_page_clients'];
}
$cpp = $REL_CONFIG['per_page_clients'];
$limit = "LIMIT ".$start_page." , ".$cpp;


//выводим список всех пользователей, которых мы можем редактировать
// всех пользователей могут редактировать лишь принадлежащие к ОО Самарский
if(get_user_class() < UC_HEAD){
	$department = "  client.department = '".$CURUSER['department']."' AND client.manager = '".$CURUSER['id']."' ";
}
if(get_user_class() == UC_HEAD){
	$department = "  client.department = '".$CURUSER['department']."' ";
}
if(get_user_class() > UC_HEAD){
	$department = "  (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."') ";
	//$department = "  client.department = department.id ";
}
if(get_user_class() == UC_ADMINISTRATOR){
	$department = "  client.department != '0' ";
}

if($_GET['status_client']){
	$status = (int)($_GET['status_client'] - 1);
	$client = " AND client.status='".$status."'";
	$add_link .= "&client=".$_GET['status_client'];
	
	if($_GET['status_action']){
		$now_date = strtotime(date("d.m.Y"));
		$left_join="LEFT JOIN callback ON callback.id_client = client.id";
		if($_GET['status_action']=='miss'){
			$call_back .="AND callback.next_call < '".$now_date."' ";
		}
		elseif($_GET['status_action']=='next'){
			$call_back .="AND callback.next_call > '".$now_date."' ";
		}
		elseif($_GET['status_action']=='today'){
			$call_back .="AND callback.next_call = '".$now_date."' ";
		}
		$add_link .= "&status_action=".$_GET['status_action'];
		$call_back .= "AND callback.status = '0' ";
	}
	if($_GET['type']){
		if($_GET['type']=='1'){
			$call_back .="AND callback.type_contact = 1 ";
		}
		elseif($_GET['type']=='2'){
			$call_back .="AND callback.type_contact = 2 ";
		}
		$add_link .= "&type=".$_GET['type'];
	}
	
	
}

if ($client OR $department){
	$where = "WHERE";
}

$res=sql_query("
SELECT client.*, department.name as d_name, department.id as d_id, department.parent, users.name as u_name
FROM `client` 
LEFT JOIN department ON department.id = client.department
LEFT JOIN users ON users.id = client.manager
$left_join 
$where
".$department." ".$client." ".$call_back." ".$limit.";")  or sqlerr(__FILE__, __LINE__);

if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиенты не найдены","no");
}
while ($row = mysql_fetch_array($res)){
	$data_client[]=$row;
}
//необходима оптимизация 
// узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
$res = sql_query("SELECT SUM(1) FROM client LEFT JOIN department ON department.id = client.department LEFT JOIN  users ON users.id = client.manager $where ".$department." ".$client.";") or sqlerr(__FILE__,__LINE__);
$row = mysql_fetch_array($res);
//всего записей
$count = $row[0];
//всего страниц
$max_page = ceil($count / $cpp);
//print $cpp;


$REL_TPL->assignByRef('data_client',$data_client);
//$REL_TPL->assignByRef('js_add',$js_add);
$REL_TPL->assignByRef('cpp',$cpp);
$REL_TPL->assignByRef('page',$page);
$REL_TPL->assignByRef('add_link',$add_link);
$REL_TPL->assignByRef('max_page',$max_page);
//$REL_TPL->assignByRef('count',$count);
$REL_TPL->output("index","client");



?>
