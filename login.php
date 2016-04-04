<?php

require_once("include/connect.php");

dbconn();

if ($CURUSER)
stderr("Ошибка", "Вы уже вошли в систему!");

if($_POST['login'] AND $_POST['password']){
	if (!mkglobal("login:password"))
	die();
	function bark($text = ''){
		if (!$text) 
			$text = "Не правлиьный логин";
	stderr("Ошибка входа", $text);
}

$login = (string)$login;
if (!validusername($login)) bark("Не правильный формат логина");

//var_dump($password);
$res = sql_query("SELECT * FROM users WHERE login = ". sqlesc($login));
$row = @mysql_fetch_array($res);



if (!$row) {
	stderr("Ошибка",'Вы не зарегестрированы, или ввели не правильный логин/пароль. <a href="login.php">Попробуйте еще раз</a>.');
}



if ($row["passhash"] != md5($row["secret"] . $password . $row["secret"]))
stderr("Ошибка",'Вы не зарегестрированы, или ввели не правильный логин/пароль. <a href="login.php">Попробуйте еще раз</a>.');

logincookie($row["id"], $row["passhash"], $row["language"]);

if ($row["banned"])
stderr("Аккаунт заблокирован","Ваш аккаунт заблокирован с этим комментарием: ".$row['dis_reason']);

$CURUSER = $row;
sql_query("UPDATE LOW_PRIORITY users SET last_login = '".time()."' WHERE id=" . $CURUSER["id"]);
$returnto = strip_tags(trim((string)$_POST['returnto']));

$REL_TPL->stdhead("Вход в систему");/*
if ($returnto)
stdmsg("Вход осуществлен","<a href=\"".$returnto."\">Продолжить</a>");
else*/
stdmsg("Вход осуществлен","<a href=\"".$REL_CONFIG['defaultbaseurl']."\">Продолжить</a>");
$REL_TPL->stdfoot();

die();
}

$REL_TPL->stdhead("Вход");
/*
$returnto = strip_tags(trim((string)$_GET['returnto']));

if ($returnto)
if (!$_GET["nowarn"]) {
	$error = "<table style=\"margin: 0 auto\"><tr class=\"error_login\"><td colspan=\"2\" style=\"border:none\"><img src=\"pic/attention_login.gif\" alt=\"attention\"/></td><td colspan=\"2\" style=\"border:none; vertical-align: middle;\">Sorry, but the page you required can only be accessed by <b>logged in users</b>.<br />Please log in to the system, and we will reditect you to this page after this.</td></tr></table>";
	//print("<h1>Не авторизированы!</h1>\n");
	//print("<p><b>Ошибка:</b> Страница, которую вы пытаетесь посмотреть, доступна только зарегистрированым.</p>\n");
}

if (isset($error)) {
	echo $error;
}*/
$REL_TPL->output("login","basic");

$REL_TPL->stdfoot();

?>