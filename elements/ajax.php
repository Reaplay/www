<?php

require_once("../include/connect.php");
dbconn();


if($_GET['action']=='getresultcall'){
	
	if(!is_valid_id($_GET['type']))
		return;
	$res=sql_query("SELECT * FROM  `result_call` WHERE type_contact = '".$_GET['type']."';")  or sqlerr(__FILE__, __LINE__);
		$result[0]="Выберите результат";
		
		while ($row = mysql_fetch_array($res)){
			$result[$row['id']]=$row['text'];
			//array_push ($result, $row['id']=>$row['text']);
		}
		echo json_encode($result);
		//print_r($result);
}
elseif($_GET['action']=='disableuser'){
	
	if(!is_valid_id($_GET['id']))
		die("error");
	$id = $_GET['id'];

	if($CURUSER['add_user'] != "1"){
		die("error");
	}
	
	if (get_user_class() < UC_POWER_HEAD){
		$res = sql_query("SELECT id FROM  `users` WHERE `id` = '".$id."' AND department = '".$CURUSER['department']."';")  or sqlerr(__FILE__, __LINE__);
		$row = mysql_fetch_array($res);
		if(!$row){
			die("error");
		}
	}
	elseif(get_user_class()==UC_POWER_HEAD) {
		$res = sql_query ("SELECT id FROM  `users` LEFT JOIN department ON department.id = users.department WHERE `users.id` = '" . $id . "' AND department.parent = '" . $CURUSER['department'] . "';") or sqlerr (__FILE__, __LINE__);
		$row = mysql_fetch_array ($res);
		if (!$row) {
			die("error");
		}
	}
	sql_query("UPDATE `users` SET `enable` = '2', `dis_reason` = 'Была отключена пользователем ".$CURUSER['name']."' WHERE `id` = '".$id."';") or sqlerr(__FILE__,__LINE__);
	die("success");
}
elseif($_GET['action']=='enableuser'){

	if(!is_valid_id($_GET['id']))
		die("error");
	$id = $_GET['id'];

	if($CURUSER['add_user'] != "1"){
		die("error");
	}

	if (get_user_class() < UC_POWER_HEAD){
		$res = sql_query("SELECT id FROM  `users` WHERE `id` = '".$id."' AND department = '".$CURUSER['department']."';")  or sqlerr(__FILE__, __LINE__);
		$row = mysql_fetch_array($res);
		if(!$row){
			die("error");
		}
	}
	elseif(get_user_class()==UC_POWER_HEAD) {
		$res = sql_query ("SELECT id FROM  `users` LEFT JOIN department ON department.id = users.department WHERE `users.id` = '" . $id . "' AND department.parent = '" . $CURUSER['department'] . "';") or sqlerr (__FILE__, __LINE__);
		$row = mysql_fetch_array ($res);
		if (!$row) {
			die("error");
		}
	}
	sql_query("UPDATE `users` SET `enable` = '1', `dis_reason` = '".$CURUSER['name']."' WHERE `id` = '".$id."';") or sqlerr(__FILE__,__LINE__);
	die("success");
}
elseif($_GET['action']=='search'){
	if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {

		/**
		 * PARAMS
		 * $LIMIT        = limit your query [1 - 1000]
		 * $KEYWORD    = Letters/Keywords typed by the user
		 *
		 * USE THESE PARAMS TO CREATE THE QUERY.
		 * Quick Mysql Query Example:
		 *
		 * mysql_query("SELECT * FROM my_table WHERE title LIKE '%$KEYWORK%' LIMIT $LIMIT");
		 *
		 * Add All results to an array and encode the array with JSON. Please, see below!
		 **/
		$LIMIT = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 30;
		$KEYWORD = isset($_REQUEST['search']) ? (string)$_REQUEST['search'] : null;


		/**
		 * Country Array List - Demo Purpose Only!
		 **/
		/*$data_search = array(
			"Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Anguilla", "Antigua & Barbuda",
			"Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain",
			"Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
			"Bosnia & Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria",
			"Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Cape Verde", "Cayman Islands", "Chad", "Chile",
			"China", "Colombia", "Congo", "Cook Islands", "Costa Rica", "Cote D Ivoire", "Croatia", "Cruise Ship",
			"Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador",
			"Egypt", "El Salvador", "Equatorial Guinea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands",
			"Fiji", "Finland", "France", "French Polynesia", "French West Indies", "Gabon", "Gambia", "Georgia",
			"Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guernsey",
			"Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India",
			"Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey",
			"Jordan", "Kazakhstan", "Kenya", "Kuwait", "Kyrgyz Republic", "Laos", "Latvia", "Lebanon", "Lesotho",
			"Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar",
			"Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Mauritania", "Mauritius", "Mexico", "Moldova",
			"Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nepal", "Netherlands",
			"Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway",
			"Oman", "Pakistan", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
			"Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Pierre & Miquelon",
			"Samoa", "San Marino", "Satellite", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone",
			"Singapore", "Slovakia", "Slovenia", "South Africa", "South Korea", "Spain", "Sri Lanka", "St Kitts & Nevis",
			"St Lucia", "St Vincent", "St. Lucia", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria",
			"Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor L'Este", "Togo", "Tonga", "Trinidad & Tobago",
			"Tunisia", "Turkey", "Turkmenistan", "Turks & Caicos", "Uganda", "Ukraine", "United Arab Emirates",
			"United Kingdom", "Uruguay", "Uzbekistan", "Venezuela", "Vietnam", "Virgin Islands (US)", "Yemen", "Zambia", "Zimbabwe"
		);*/
		$res = sql_query("
SELECT client.name, client.id
FROM `client`

WHERE client.name LIKE '%".$_GET['search']."%' OR client.mobile LIKE '%".$_GET['search']."%' OR client.equid LIKE '%".$_GET['search']."%' LIMIT 0 , 10")  or sqlerr(__FILE__,__LINE__);
		if(mysql_num_rows($res) == 0){
			$data_search = array("Ничего не найдено");
		}
		while ($row = mysql_fetch_array($res)){
			$data_search[]=$row['name'];
		}
		// Convert to JSON
		$json = json_encode ($data_search);

		// Print JSON
		die($json);
	}
}
	/*


// что делаем в базе
if($_GET['a'] == "d"){
	$action = "delete";
}
elseif($_GET['a'] == "e"){
	$action = "edit";
}
else
	die("error");

// проверяем c какими данными работаем и делаем нужные изменения
if($_GET['w'] == "user"){

	$table = "users";
	
	
}
elseif($_GET['w'] == "client"){
	$table = "client";
}
else
	die("error");

die("success");

$t = (int)$_GET['t'];

die();
if (!$t)
	die($t);

if($_GET['s'] == 'c'){
	print "test";
	die();
}

# Подгрузка основной инфы про клиента
elseif($t == 1){
	$id = (int)$_GET['id'];
if(get_user_class() < UC_HEAD){
		$add_query = "AND client.manager ='".$CURUSER['id']."' AND client.department ='".$CURUSER['department']."'";
		
	}
	//если рукль, то те, кто к ним привязан
	elseif(get_user_class() == UC_HEAD){
		$add_query = "AND client.department ='".$CURUSER['department']."'";
	}
	//а выше рукля - всех могут
	
	$res=sql_query("SELECT client.*, users.name as u_name, users.id as u_id  FROM `client`  LEFT JOIN users ON users.id = client.manager  WHERE  client.id = '".$_GET['id']."' ".$add_query.";")  or sqlerr(__FILE__, __LINE__);

	//	$res=sql_query("SELECT client.*, users.name as u_name, users.id as u_id  FROM `client` LEFT JOIN users ON users.id = client.manager  WHERE  id = '".$_GET['id']."' ".$add_query.";")  or sqlerr(__FILE__, __LINE__);
//$res=sql_query("SELECT users.id, users.login, users.name, users.add_client, users.add_user, department.id as d_id, department.name as d_name FROM `users`  LEFT JOIN department ON department.id = users.department  WHERE ".$department." users.id='".$_GET['id']."';")  or sqlerr(__FILE__, __LINE__);
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Клиент не найден или у вас нет доступа");
	}

	$data_client = mysql_fetch_array($res);
	
	
	
	// если рукль или выше, то можно сменить менеджера (и соответственно с ним меняется привязка к отделению)
	if(get_user_class() >= UC_HEAD){
		if(get_user_class() == UC_HEAD){
			$dep = "WHERE department = ".$CURUSER['department'];
		}
		$res=sql_query("SELECT users.id,users.name, department.name as d_name FROM  `users` LEFT JOIN department ON department.id = users.department ".$dep.";")  or sqlerr(__FILE__, __LINE__);
	
		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $data_client['u_id']){
				$select = "selected = \"selected\"";
			}
			$manager .= " <option ".$select." value = ".$row['id'].">".$row['name']." (".$row['d_name'].")</option>";
		}
	}
	$data_client['birthday'] = date("d-m-Y",$data_client['birthday']);
	$action	="edit";
	$gender = $data_client['gender'];
	
	$REL_TPL->assignByRef('manager',$manager);
	$REL_TPL->assignByRef('gender',$gender);
	$REL_TPL->assignByRef('action',$action);
	$REL_TPL->assignByRef('data_client',$data_client);
	//$REL_TPL->assignByRef('p_class',$p_class);
	$REL_TPL->output("view_client","ajax");
	

	die();
}
# редактирование
elseif($t == 2) {
	
	require_once("../elements/client/edit_client.php");
}
elseif($t == "3") {
	
	require_once("../elements/client/history_client.php");
}*/
?>


