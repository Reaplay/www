<?php
if(!is_valid_id($_POST['id'])){
	stderr("Ошибка","Некоретный ID клиента","no");
	write_log("Попытка изменения поступаемого ID клиента при добавлении изменений (специально)","change_user");
}
if(!is_valid_id($_POST['new_manager'])){
	stderr("Ошибка","Некорретный ID менеджера","no");
	write_log("Попытка изменения поступаемого ID менеджера при добавлении изменений (специально)","change_user");
}
if($_POST['action'] == 'change_mgr'){
	if(get_user_class() < UC_POWER_USER){
		stderr("Ошибка","Вы не имеете доступа к данной операции","no");
	}
	if(get_user_class() <= UC_HEAD){
		$addition = "AND department = '".$CURUSER['department']."'";
		$department = $CURUSER['department'];
	}
	elseif(get_user_class() == UC_POWER_HEAD){
		$addition = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";

	}
	$res=sql_query("SELECT `client`.`name` FROM `client` LEFT JOIN department ON department.id = client.department WHERE client.delete = '0' AND client.id = '".$_POST['id']."' ".$addition.";")  or sqlerr(__FILE__, __LINE__);
	
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
	}
	
	$res=sql_query("SELECT department FROM `users`  LEFT JOIN department ON department.id = users.department WHERE  users.id = '".$_POST['new_manager']."' ".$addition.";")  or sqlerr(__FILE__, __LINE__);
	
	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Менеджер не найден или у вас нет доступа","no");
	}
	if (!$department) {
		$department = mysql_fetch_array($res);
	}


	$manager = $_POST['new_manager'];
	sql_query("UPDATE `client` SET `department` = '".$department['department']."', `manager` =  '".$manager."' WHERE `id` ='".$_POST['id']."';")  or sqlerr(__FILE__, __LINE__);

	$msg = "Пользователем ".$CURUSER['name']." вам был добавлен клиент. <a href=\"client.php?a=view&id=".$_POST['id']."\">Перейти</a>";
	$subject = "Назначен новый клиент";
	sql_query("INSERT INTO messages (receiver, added, msg, subject) VALUES($manager, '" . time() . "', ".sqlesc($msg).", ".sqlesc($subject).")");

	stdmsg("Менеджер изменен.","Для перехода на страницу клиента нажмите <a href=\"client.php?a=view&id=".$_POST['id']."\">тут</a>");
	safe_redirect("client.php?a=view&id=".$_POST['id']."",1);
}
?>
