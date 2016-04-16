<?php

	require "include/connect.php";

	dbconn();
	if(get_user_class() < UC_ADMINISTRATOR){
		stderr("Ошибка","У вас нет доступа к данной странице");
	}
if($_GET['module']){
	require_once("admincp/".$_GET['module'].".php");
	}
?>