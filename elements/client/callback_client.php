<?php

// проверка на то, что клиент существует и к нему естьт доступ
// надо поправить, что бы повер_хеад видел только те, что по корневому дсотупны
if( ($_GET['id'] AND !is_valid_id($_GET['id'])) OR ($_POST['id'] AND !is_valid_id($_POST['id']))){
	stderr("Ошибка","Ошибка ID клиента","no");		//запись в лог
}

if ($_GET['id'])
	$id_client = $_GET['id'];
elseif($_POST['id'])
	$id_client = $_POST['id'];

/*if(get_user_class() < UC_HEAD){
	$add_query = "AND client.manager ='".$CURUSER['id']."' AND client.department ='".$CURUSER['department']."'";
}*/
//если рукль, то те, кто к ним привязан
if(get_user_class() <= UC_HEAD){
	$add_query = "AND client.department ='".$CURUSER['department']."'";
}
elseif(get_user_class()==UC_POWER_HEAD){
	$add_query = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
}
	
	
	$res=sql_query("
	SELECT client.equid, department.parent, department.id
	FROM `client`
	LEFT JOIN department ON department.id = client.department
	WHERE client.delete = '0' AND client.id = '".$id_client."' ".$add_query.";")
	or sqlerr(__FILE__, __LINE__);

if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
}
$data_client = mysql_fetch_array($res);


if($_POST['action']=='add'){
	
	//print_r ($_POST['p']);
	//Проверям ID клиента
	/*if(!is_valid_id($_POST['id'])){
		stderr("Ошибка","Ошибка ID клиента","no");		//запись в лог
	}
	// даем права добавлять отзвоны манагеру и руклю
	elseif(get_user_class() < UC_HEAD){
		$sql_add = "AND `manager` = '".$CURUSER['manager']."'"
	}
	elseif(get_user_class() == UC_HEAD){
		$sql_add = "AND `department` = '".$CURUSER['department']."'"
	}
	$res=sql_query("SELECT id FROM  `client` WHERE `id` = '".$_POST['id']."' ".$sql_add.";")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Клиент не найден или у вас не хватает прав","no");
		//запись в логи
	}*/
	// проверяем id результата
	if(!is_valid_id($_POST['result_call'])){
		stderr("Ошибка","Не правильное значение результата звонка/встречи","no");		//запись в лог
	}
	$res=sql_query("SELECT id FROM  `result_call` WHERE `id` = '".$_POST['result_call']."';")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Не правильное значение результата обзвона","no");
		//запись в логи
	}
	//проверяем ид типа контакта (звонок или встреча)
	if(!is_valid_id($_POST['type_contact'])){
		stderr("Ошибка","Не правильное значение типа контакта","no");		//запись в лог
	}
	if($_POST['type_contact']<0 OR $_POST['type_contact']>2){
		stderr("Ошибка","Некорректный ID типа контакта","no");		//запись в лог
	}
	
	//проверяем ID продуктов
	if ($_POST['id_product']){
		foreach ($_POST['id_product'] as $data) {
			
			if($i == "1"){
				$id_product .= ",";
			}
			$id_product .= $data;
			$i="1";
		}
	}
	//$id_client = $_POST['id'];
	$id_result = $_POST['result_call'];
	
	if ($_POST["next_call"]) {
		$call  = explode("/",$_POST["next_call"]);
		$next_call = mktime( 0,0,0,$call['1'],$call['0'],$call['2']);
		// проверка, на случай, если звонок /встреча перенесены на сегодняшний день.
		// нельзя добавить звоки в прошлое
		$arr_cur_time = explode("/",date("d/m/Y",time()));
		$cur_time = mktime( 0,0,0,$arr_cur_time['1'],$arr_cur_time['0'],$arr_cur_time['2']);
		if($next_call<$cur_time)	
			stderr("Ошибка","Дата следующего контакта не может быть прошедшей","no");	
		
	}
	else
		stderr("Ошибка","Должна быть введена дата контакта","no");

	$type_contact = $_POST['type_contact'];
	$comment = ((string)$_POST["comment"]);
	$equid = $_POST['equid'];
	if ($equid) {
		$update_equid = ", equid = ".sqlesc($equid)."";
	}
	if ($_POST['status'] != "---") {
		$update_status = ", status = ".$_POST['status'];
	}
	else
		$update_status = ", status = 0";

	//$id_product = "1,2,3";
	//
	sql_query("INSERT INTO `callback` (`id_client`, `id_user`, `added`, `id_result`,`type_contact`, `next_call`, `comment`,`id_product`) VALUES ('".$id_client."', '".$CURUSER['id']."', '".time()."', '".$id_result."','".$type_contact."', '".$next_call."', ". sqlesc($comment).",'".$id_product."');")  or sqlerr(__FILE__, __LINE__);
	$id_callback = mysql_insert_id();
	
	sql_query("UPDATE `callback` SET status = 1 WHERE id_client = '".$id_client."' AND status = '0' AND id !='".$id_callback."'");

	//if($update_equid OR $update_status)
		sql_query("UPDATE `client` SET `id_callback` = '".$id_callback."' ".$update_equid." ".$update_status." WHERE id = '".$id_client."'");

	


	if($_POST['return_url']){
		stdmsg("Добавлено","Контакт с клиентом добавлен. Вы будете перенаправлены обратно на список клиентов. <br /> Если вам нужно попасть в профиль клиента, нажмите <a href=\"client.php?a=view&id=".$id_client."\">здесь</a>");
		safe_redirect($_POST['return_url'],2);
	}
	else {
		stdmsg("Добавлено","Контакт с клиентом добавлен. Вы будете перенаправлены на страницу клиента через пару секунд. <br /> Если этого не произошло, нажмите <a href=\"client.php?a=view&id=".$id_client."\">здесь</a>");
		safe_redirect ("client.php?a=view&id=" . $id_client, 2);
	}
}
else{
//$url = explode('&',$_SERVER['QUERY_STRING']);
	//$s_url = stristr($_SERVER['QUERY_STRING'],"a=");
	if(!stristr($_SERVER['HTTP_REFERER'],"a=")){
		$return_url = $_SERVER['HTTP_REFERER'];
	}

	/*if(!is_valid_id($_GET['id'])){
		stderr("Ошибка","Ошибка ID клиента","no");		//запись в лог
	}
	
if(!is_valid_id($_GET['id'])){
	stderr("Ошибка","Некоректный ID клиента","no");		//запись в лог
}
if(get_user_class() < UC_HEAD){
	$add_query = "AND client.manager ='".$CURUSER['id']."' AND client.department ='".$CURUSER['department']."'";
}
//если рукль, то те, кто к ним привязан
elseif(get_user_class() == UC_HEAD){
	$add_query = "AND client.department ='".$CURUSER['department']."'";
}
elseif(get_user_class() > UC_HEAD){
	$add_query = "";
}
	
	
	$res=sql_query("
	SELECT client.id, department.parent
	FROM `client`  
	LEFT JOIN department ON department.id = client.department 
	WHERE  client.id = '".$_GET['id']."' ".$add_query.";")  
	or sqlerr(__FILE__, __LINE__);

if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
}*/

	
	
	// продукты банка
	$res=sql_query("SELECT * FROM  `product` WHERE disable = 0;")  or sqlerr(__FILE__, __LINE__);

	while ($row = mysql_fetch_array($res)) {
		$i++;
		if ($i == "1"){
			$product .='<div class="row">';
		}
		$product .= '<div class="col-md-6"><label class="checkbox" >
	<input type="checkbox" value="'.$row['id'].'" name="id_product[]">
	<i></i>'.$row['name']."</label></div>";
		if ($i == "2"){
			$product .="</div>";
			$i="0";
		}
	}
	if ($i == "1"){
		$product .="</div>";
	}

	//рехультат обзвона
	$res=sql_query("SELECT * FROM  `result_call`;")  or sqlerr(__FILE__, __LINE__);
		while ($row = mysql_fetch_array($res)) {
				$result .= " <option value = \"".$row['id']."\">".$row['text']."</option>";
		}
		
	//$data_client['id'] = (int)$_GET['id'];
		$REL_TPL->assignByRef('product',$product);
		$REL_TPL->assignByRef('result',$result);
		//$REL_TPL->assignByRef('comment',textbbcode("comment",$arr["body"]));
		$REL_TPL->assignByRef('id',$_GET['id']);
		$REL_TPL->assignByRef('data_client',$data_client);
		$REL_TPL->assignByRef('return_url',$return_url);
		
		$t = "callback";
		$REL_TPL->assignByRef("t",$t);
		
		$REL_TPL->output("tpl_view_client","client");
		$REL_TPL->output("callback_client","client");
		
	}
?>
