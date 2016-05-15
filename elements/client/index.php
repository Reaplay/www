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
	/*if(get_user_class() < UC_HEAD){
        $department = "  client.department = '".$CURUSER['department']."' AND client.manager = '".$CURUSER['id']."' ";
    }*/
	if(get_user_class() <= UC_HEAD){
		$department = " AND client.department = '".$CURUSER['department']."' ";
	}
	elseif(get_user_class() == UC_POWER_HEAD){
		$department = " AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."') ";
		//$department = "  client.department = department.id ";
	}
/*
	$now_date = strtotime(date("d.m.Y"));
	if($_GET['status_client']){
		$status = (int)($_GET['status_client'] - 1);
		$client = " AND client.status='".$status."'";
		$add_link .= "&status_client=".$_GET['status_client'];

		if($_GET['status_action']){
//			$now_date = strtotime(date("d.m.Y"));
		//	$add_select = "callback.next_call, callback.status, callback.type_contact";
			//$left_join="LEFT JOIN callback ON callback.id_client = client.id";
			if($_GET['status_action']=='miss'){
				$call_back .="AND callback.next_call < '".$now_date."' ";
				$call_back .= "AND callback.next_call != '0' ";
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

		if($_GET['only_my'] AND is_valid_id($_GET['only_my'])){
			$only_my = "AND client.manager = '".$CURUSER['id']."'";
			$add_link .= "&only_my=1";
		}
	if($_GET['manager'] AND is_valid_id($_GET['manager'])){
		$flt_manager = "AND client.manager = '".$_GET['manager']."'";
		$add_link .= "&manager=".$_GET['manager'];
	}
	if($_GET['department'] AND is_valid_id($_GET['department'])){
		$flt_department = "AND client.department = '".$_GET['department']."'";
		$add_link .= "&department=".$_GET['department'];
	}*/
	$filter = filter_index($_GET,"client");
	$sort = sort_index($_GET,"client");

/*	if ($client OR $department){
		$where = "WHERE";
	}*/

	$res=sql_query("
SELECT client.*, department.name AS d_name, department.id AS d_id, department.parent, users.name AS u_name, callback.next_call AS cb_next_call, callback.comment AS cb_comment,callback.id_user, (SELECT users.name FROM users WHERE users.id=callback.id_user) AS cb_manager, (SELECT result_call.text FROM result_call WHERE result_call.id=callback.id_result) AS result_call
FROM `client`
LEFT JOIN department ON department.id = client.department
LEFT JOIN users ON users.id = client.manager
LEFT JOIN callback ON callback.id = client.id_callback
$left_join
WHERE
client.delete = '0'
".$filter['add_where']." ".$sort['query']." ".$department." ".$limit.";")  or sqlerr(__FILE__, __LINE__);


	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Клиенты не найдены","no");
	}
	$i=0;
	while ($row = mysql_fetch_array($res)){
		$data_client[]=$row;
		if ($row['cb_next_call']){
			$data_client[$i]['time_callback']=mkprettytime($row['cb_next_call'],false);
		}
		$i++;
	}

	//формируем список менеджеров для фильтра
	$get_mgr = get_manager(get_user_class(),$CURUSER['department']);
	while ($mgr = mysql_fetch_array($get_mgr)) {
		$select = "";
		if ($mgr['id'] == $_GET['manager']){
			$select = "selected = \"selected\"";
		}
		$list_manager .= " <option ".$select." value = ".$mgr['id'].">".$mgr['name']."</option>";
	}

	// спиcок отделений для фильтра
	$list_department = get_department(get_user_class(),$CURUSER['department'],$_GET['department']);

	//необходима оптимизация
	// узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
	$res = sql_query("SELECT SUM(1) FROM client LEFT JOIN department ON department.id = client.department LEFT JOIN  users ON users.id = client.manager LEFT JOIN callback ON callback.id = client.id_callback $left_join WHERE
client.delete = '0' ".$filter['add_where']." ".$department.";") or sqlerr(__FILE__,__LINE__);
	$row = mysql_fetch_array($res);
	//всего записей
	$count = $row[0];
	//всего страниц
	$max_page = ceil($count / $cpp);
	//print $cpp;

	// данные по клиенту, текущая дата
	$REL_TPL->assignByRef('data_client',$data_client);
	$REL_TPL->assignByRef('now_date',$now_date);
	//формируем список для фильтров
	$REL_TPL->assignByRef('list_manager',$list_manager);
	$REL_TPL->assignByRef('list_department',$list_department);
	// формируем переход между страниц
	$REL_TPL->assignByRef('cpp',$cpp);
	$REL_TPL->assignByRef('page',$page);
	$REL_TPL->assignByRef('max_page',$max_page);
	//доп. данные для перехода сортировки и фильтров
	$REL_TPL->assignByRef('add_link',$filter['add_link']);
	$REL_TPL->assignByRef('add_sort',$sort['link']);
	$REL_TPL->assignByRef('sort',$sort);


	//$REL_TPL->assignByRef('count',$count);
	//$REL_TPL->assignByRef('js_add',$js_add);

	$REL_TPL->output("index","client");
?>
