<?php
/*
сначала проверяем данные на корректность
потом проверяем если у нас изменение
внесение измененеий в базу
*/
// если идет изменение, то сразу запрашиваем некоторые данные
if($_POST['id']){
		if(!is_valid_id($_POST['id'])){
			stderr("Ошибка","Некорретный ID","no");
			write_log("Попытка изменения поступаемого ID при добавлении изменений (специально)","edit_user");
	}
	$id = $_POST['id'];
	$res = sql_query("SELECT id FROM  `users` WHERE `id` = '".$id."';")  or sqlerr(__FILE__, __LINE__);
	$row = mysql_fetch_array($res);
	if(!$row){
		stderr("Ошибка","Такой пользователь в базе не обнаружен","no");
	}
	
}

//если этой переменной нет, значит мы просто добавляем нового пользователя
// поэтому проверяем логин на корректность
if (!$id) {
	$login = trim($_POST["login"]);
	if (strlen($login) > 9 or strlen($login)<7)
		stderr("Ошибка","Логин должен быть не длиннее 9 символов и не короче 7","no");
	//что проходит валидацию
	if (!validusername($login))
		stderr("Ошибка","Логин должен содержатьв себе только буквы лат. языка, цифр или спецсимвол '_' (нижнее подчеркивание)","no");
	//проверяем, что такого логина в базе нет
	$res=sql_query("SELECT id FROM  `users` WHERE `login` = '".$login."';")  or sqlerr(__FILE__, __LINE__);
	if(mysql_fetch_array($res)){
		stderr("Ошибка","Такой пользователь есть в базе","no");
	}
}


//общее

//проверяем фио
$name = trim($_POST["name"]);
//длину
if (strlen($name)<5)
	stderr("Ошибка","ФИО должно быть не короче 5 символов","no");

//может ли добавлять клиентов
if ($_POST['add_client'])
	$add_client = 1;
else
	$add_client = '0';
	
//может ли добавлять пользователей
if ($_POST['add_user']){
	$add_user = 1;
}
else
	$add_user = '0';

	//работает ли с картами
    if ($_POST['use_card'])
        $use_card = 1;
    else
        $use_card = '0';

// уровень доступа
$class = $_POST['class'];
// провеярем что числовой
if (!is_numeric($class)){
	stderr("Ошибка","Некорректное значение класса","no");
	write_log("Попытка изменения поступаемого ID класса ","edit_user");
}
//проверяем правильность выданных доступов
if(get_user_class() < UC_HEAD and $class > 1 ){
	stderr("Ошибка","Не хорошо так делать er1","no");
	write_log("Попытка подделки поступаемого ID класса ","edit_user");
}
elseif(get_user_class() < UC_POWER_HEAD and $class > 2){
	stderr("Ошибка","Не хорошо так делать er2","no");
	write_log("Попытка подделки поступаемого ID класса ","edit_user");
}
elseif(get_user_class() == UC_POWER_HEAD and $class >3){
	stderr("Ошибка","Не хорошо так делать er3","no");
	write_log("Попытка подделки поступаемого ID класса ","edit_user");
}

// работаем с отделениями. проверяем корректность
	if (get_user_class()<UC_POWER_HEAD){
		$department = $CURUSER["department"];
	}

if (get_user_class()>=UC_POWER_HEAD){
	$department = (int)$_POST["department"];
	//что указано отделение
	if (!$department){
		stderr("Ошибка","Не задано отделение","no");
	}
	//валидный ID отделения
	if (!is_valid_id($department)) {
		stderr("Ошибка","Не хорошо так делать err4","no");
		write_log("Попытка подделки поступаемого ID отделения ","edit_user");
	}
	// проверяем что такое отделение есть в базе
	$res=sql_query("SELECT id FROM  `department` WHERE `id` = '".$department."';")  or sqlerr(__FILE__, __LINE__);
	if(!mysql_fetch_array($res)){
		stderr("Ошибка","Не хорошо так делать err5","no");
		write_log("Попытка подставить несуществующее ID отделения ","edit_user");
	}
	
}

if (!$id and !$_POST['password']){
	stderr("Ошибка","Не задан пароль","no");
}
if ($_POST['password']){
	$secret = mksecret();
	$password = md5($secret . $_POST['password'] . $secret);
	if ($id){
		$passhash = "`passhash` = '".$password."', `secret` = '".$secret."',";

	}
}
if (!$id){
$ret = sql_query("
INSERT INTO `users`( 
`login`, `department`, `passhash`, `secret`, `name`, `add_user`, `add_client`,`use_card`, `added`, `who_added`, `class`)
VALUES (".implode(",", array_map("sqlesc", array(
$login, $department, $password, $secret, $name, $add_user, $add_client, $use_card, time(), $CURUSER['id'],$class))).");");//  or sqlerr(__FILE__, __LINE__);


}
else {

sql_query("
UPDATE `users` SET `department` = '".$department."', `class` =  '".$class."', `name` = '".$name."', `add_user` = '".$add_user."', `add_client` = '".$add_client."', `use_card`='".$use_card."', ".$passhash." `last_update` = '".time()."' WHERE `id` ='".$id."';")  or sqlerr(__FILE__, __LINE__);
	}
stdmsg("Выполнено.","Ошибок не обнаружено");
	safe_redirect("user.php",2);
?>