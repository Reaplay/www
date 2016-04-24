<?php
/*
Страница для работы с клиентами
*/
require_once("include/connect.php");

dbconn();

loggedinorreturn();
if(!$CURUSER['add_client'])
	stderr("Ошибка","У вас нет доступа к данной странице");

	if(!$REL_CONFIG['deny_client']){
		stderr("Ошибка","Данный функционал отключен администратором");
	}

if (!$_GET['a']) {
	$REL_TPL->stdhead("Список клиентов");
	require_once("elements/client/index.php");
}
elseif ($_GET['a']=="e" AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Редактирование клиента");
	if(!$_GET['type']){
		require_once("elements/client/tpl_basic_action_client.php");
	}
	elseif($_GET['type'] == "change"){
		require_once("elements/client/change.php");
	}
}
elseif ($_GET['a']=="a" AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Добавление клиента");
	require_once("elements/client/tpl_basic_action_client.php");
}
elseif ($_GET['a']=="c" & ($_SERVER['REQUEST_METHOD'] == 'POST') AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Применение изменений");
	require_once("elements/client/add_change_client.php");
}
elseif ($_GET['a']=="view") {
	$REL_TPL->stdhead("Просмотр клиента");
	require_once("elements/client/view_client.php");
}
elseif ($_GET['a']=="callback" AND !$CURUSER['only_view']) {
	if($_GET['id'] OR $_POST['id']){
		$REL_TPL->stdhead("Контакт с клиентом");
		require_once("elements/client/callback_client.php");
	}

}
elseif ($_GET['a']=="callback_history") {
	if($_GET['id'] OR $_POST['id']){
		$REL_TPL->stdhead("История контактов с клиентом");
		require_once("elements/client/callback_history.php");
	}

}
elseif ($_GET['a']=="delete" AND !$CURUSER['only_view']) {
	require_once("elements/client/delete_client.php");
}
elseif ($_GET['a']=="upload") {
	$REL_TPL->stdhead("Массовая загрузка клиентов");
	require_once("elements/client/upload_clients.php");
}
else{
	stderr("Ошибка","В доступе отказано");
	//запись в лог
}
$REL_TPL->stdfoot();
?>
