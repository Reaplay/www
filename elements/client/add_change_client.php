<?php

if(!$CURUSER['add_client'])
	stderr("Ошибка","У вас нет доступа к данной странице","no");
/*

Страница применения внесенных изменений

сначала проверяем данные на корректность
потом проверяем если у нас изменение
внесение измененеий в базу
*/
// если идет изменение, то сразу запрашиваем некоторые данные

// если есть эта переменная, значит мы редактируем
if($_POST['id']){
	if(!is_valid_id($_POST['id'])){
		stderr("Ошибка","Ошибка ID клиента","no");
		write_log("Попытка изменения поступаемого ID при добавлении изменений (специально)","edit_client");
	}
	$id = $_POST['id'];
	$res = sql_query("SELECT manager,department FROM `client` WHERE `delete` = '0' AND `id` = '".$id."';")  or sqlerr(__FILE__, __LINE__);
	$data_client = mysql_fetch_array($res);
	if(!$data_client){
		stderr("Ошибка","Такой клиент в базе не обнаружен","no");
	}
	
	
}

if (!$_POST['name'] or !$_POST['mobile'])
	stderr("Ошибка","Вы не написали ФИО или телефон клиента. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
	
// если пользователь меньше рукля, тогда он только себе может добавить клиента, предопределяем часть значений
if(get_user_class()<=UC_POWER_USER){
//	if (!$id) {
		$manager = $CURUSER['id'];
		$department = $CURUSER['department'];
/*	}
	else{
		$manager = "`manager` = '".$data_client['manager']."'";
		$department = "`department` =  '".$data_client['department']."'";
	}*/
}
// если рукль, тогда отделение уже определено
elseif(get_user_class() >= UC_HEAD){
	// если мы редактируем и текущее отделение и привязка не совпадают...
	if($id AND ($data_client['department'] != $CURUSER['department']) AND get_user_class() == UC_HEAD) {
		stderr("Ошибка","Ошибка проверки отделения (class dep)","no");
		write_log("Не совпадание ID отделения клиента и ID отделения менеджера (специально, рук-ль)","edit_client");
	}
	// если какой-то менеджер прописан
	if ($_POST['manager'] != "---"){
		
		// проверяем на валидность
		if (!is_valid_id($_POST['manager'])){
			stderr("Ошибка","Не выбран менеджер (class mgr)","no");
			write_log("Попытка изменения поступаемого ID менеджера при добавлении изменений (специально, рук-ль)","edit_client");
		}

		$manager = $_POST['manager'];
			
		if(get_user_class() == UC_HEAD){
			$addition_sql = "AND `department` = '".$CURUSER['department']."'";
			
		}
		elseif(get_user_class() == UC_POWER_HEAD){
			$add_select = ", department.parent";
			$left_join = "LEFT JOIN department ON department.id = users.department";
			$addition_sql = "AND department.parent = ".$CURUSER['department'];
		}

			
			//проверяем что манагер из отделения рукля
			$res=sql_query("SELECT users.department,users.id $add_select FROM  `users` $left_join WHERE users.id = '".$manager."' ".$addition_sql." ;")  or sqlerr(__FILE__, __LINE__);
			if(mysql_num_rows($res) == 0){
				stderr("Ошибка","Выбранный менеджер не привязан к вашему отделению или не существует. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
			}
			$row = mysql_fetch_array($res);
			$department = $row['department'];
			
	}	
	else {
		stderr("Ошибка","Вы не выбрали менеджера. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
	}
		
}



$email = trim($_POST["email"]);
$name = mb_convert_case(trim($_POST["name"]),MB_CASE_TITLE);

// проверяем e-mail на корректность
if ($email AND !validemail($email))
	stderr("Ошибка","Не правильный формат e-mail. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
// Проверка на длину ФИО. Минимально фамилия 3 символа + 1 на пробел + 2 на имя
if (strlen($name) < 5)
	stderr("Ошибка","Слишком короткое ФИО. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");

//проверяем номер телефона
$mobile = check_mobile($_POST['mobile']);
	if (!check_unic($mobile,'client','mobile',$id)){
		stderr("Ошибка","В базе уже есть клиент с таким номером. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
	}



if ($_POST["birthday"]) {
	$birthday = birthday_time($_POST["birthday"]);
}
//если пол указан
if ($_POST['gender'] != "---") {
	if (!is_valid_id($_POST['gender']) OR $_POST['gender']>2){
		stderr("Ошибка","Указан некорректный пол клиента","no");
		write_log("Некорректное значение пола","edit_client");
	}
	$gender = $_POST['gender'];
}

$equid = $_POST['equid'];
$comment = ((string)$_POST["comment"]);
	if ($_POST['status'] != "---" AND !$equid) {
		$status = $_POST['status'];
	}
	elseif ($equid) {
		$status = 1;
	}
	if($_POST['vip']){
		$vip = 1;
	}
	else
		$vip = 0;

	if($_POST['dont_call']){
		$dont_call = 1;
	}
	else
		$dont_call = 0;




if (!$id){
	sql_query("
INSERT INTO `client`(
`name`, `department`, `manager`, `mobile`, `email`, `birthday`, `gender`, `added`, `who_added`, `equid`, `comment`,`status`,`vip`,`dont_call`)
VALUES (".implode(",", array_map("sqlesc", array(
			$name, $department, $manager, $mobile, $email, $birthday, $gender, time(), $CURUSER['id'],$equid, $comment, $status, $vip,$dont_call))).");")  or sqlerr(__FILE__, __LINE__);
	$id_client = mysql_insert_id();
	write_log("Добавлен клиент ID:".$id_client."","client","add" );
	//дата след. звонка
	$next_call = $now_date = strtotime(date("d.m.Y"))+60*60*24;
	sql_query("INSERT INTO `callback`(`id_client`, `id_user`, `added`, `next_call`, `status`)
VALUES ('".$id_client."','0','".time()."','".$next_call."', 0);")  or sqlerr(__FILE__, __LINE__);
	$id_callback = mysql_insert_id();
	sql_query("UPDATE `client` SET `id_callback` = '".$id_callback."', `next_call`='".$next_call."'");
}
else {
sql_query("
UPDATE `client` SET `name` = '".$name."', `manager` = '".$manager."', `department` = '".$department."', `mobile` = '".$mobile."', `email` = '".$email."',`birthday` = '".$birthday."', `gender` = '".$gender."', `comment` = '".$comment."', `last_update` = '".time()."', `status` = '".$status."', `vip`='".$vip."', `dont_call` = '".$dont_call."' WHERE `id` ='".$id."';")  or sqlerr(__FILE__, __LINE__);
	write_log("Изменен клиент ID:".$id."","client","edit" );
	$id_client = $id;
}
stdmsg("Выполнено","Вы будете перенаправлены на страницу клиента через пару секунд. <br /> Если этого не произошло, нажмите <a href=\"client.php?a=view&id=".$id_client."\">здесь</a>");

	safe_redirect("client.php?a=view&id=".$id_client."",1);

?>
