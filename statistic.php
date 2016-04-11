<?php

require_once("include/connect.php");

dbconn();
loggedinorreturn();
if (!$_GET['type']) {
	$REL_TPL->stdhead("Общая статистика");
	require_once("elements/statistics/index.php");
}
	elseif ($_GET['type'] == "department") {
		$REL_TPL->stdhead("Статистика по отделению");
		require_once("elements/statistics/department.php");
	}
elseif ($_GET['type'] == "manager") {
	$REL_TPL->stdhead("Статистика по менеджерам");
	require_once("elements/statistics/manager.php");
}

$REL_TPL->stdfoot($js_add);
?>