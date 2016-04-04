<?php


require "include/connect.php";
dbconn();
//loggedinorreturn();

//httpauth();

if(!$CURUSER){
	stderr("Ошибка","У вас нет доступа к данной странице");
}

$REL_TPL->stdhead('Administrator control panel');


$REL_TPL->output("admincp","basic");
$REL_TPL->stdfoot();
?>