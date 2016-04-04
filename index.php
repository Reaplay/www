<?php

require_once("include/connect.php");

dbconn();
loggedinorreturn();
$REL_TPL->stdhead("Главная страница");

if($CURUSER){
	require_once("elements/basic/activity_log.php");
}

$REL_TPL->stdfoot();
?>
