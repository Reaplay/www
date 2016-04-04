<?php

require_once("include/connect.php");

dbconn();

logoutcookie();

unset($CURUSER);
$REL_TPL->assignByRef('CURUSER',$CURUSER);

$REL_TPL->stdhead("Выход из системы");
stdmsg("Выход из системы успешно произведен","<a href=\"".$REL_CONFIG['defaultbaseurl']."\">Продолжить</a>");
$REL_TPL->stdfoot();

?>