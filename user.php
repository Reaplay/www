<?php
/*
страница для работы с пользователями
*/
require_once("include/connect.php");

dbconn();
//если не залогинен
if(!$CURUSER){
	stderr("Ошибка","У вас нет доступа к данной странице");
}
//если у него нет прав на добавление пользователей
elseif($CURUSER['add_user']!=1){
	stderr("Ошибка","Вы не имеете доступа к данной странице");
}
// если действие не определено, грузим стартовую страницу
elseif (!$_GET['a']) {
	$REL_TPL->stdhead("Список пользователей");
	require_once("elements/user/index.php");
}
// это идет след. т.к. единственно возможная страница без ID
elseif ($_GET['a']=="a" AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Добавление нового пользователя");
	require_once("elements/user/tpl_basic_action_user.php");
}
elseif ($_GET['a']=="e" AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Редактирование пользователя");
	require_once("elements/user/tpl_basic_action_user.php");
}
elseif ($_GET['a']=="c" AND ($_SERVER['REQUEST_METHOD'] == 'POST') AND !$CURUSER['only_view']) {
	$REL_TPL->stdhead("Применение изменений");
	require_once("elements/user/add_change_user.php");
}
elseif ($_GET['a']=="d" AND !$CURUSER['only_view']) {
	require_once("elements/user/delete_user.php");
}
//все пролетели
else{
	stderr("Ошибка","В доступе отказано");
	//запись в лог
}
$REL_TPL->stdfoot();
?>
