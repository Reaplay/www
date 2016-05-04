<?php

require_once("include/connect.php");

dbconn();
loggedinorreturn();

	if(!$REL_CONFIG['deny_statistic']){
		stderr("Ошибка","Данный функционал отключен администратором");
	}

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
elseif ($_GET['type'] == "client") {
	if($_GET['subtype'] == "sales_funnel") {
		$REL_TPL->stdhead ("Воронка продаж");
		require_once ("elements/statistics/client/sales_funnel.php");
	}
}
elseif ($_GET['type'] == "card") {
	if($_GET['subtype'] == "basic") {
		$REL_TPL->stdhead ("Общая статистика по картам");
		require_once ("elements/statistics/card/basic.php");
	}
	elseif($_GET['subtype'] == "received") {
		$REL_TPL->stdhead ("Отчет по поступившим картам");
		require_once ("elements/statistics/card/received.php");
	}
	elseif($_GET['subtype'] == "issued") {
		$REL_TPL->stdhead ("Отчет по выданным/уничтоженным картам");
		require_once ("elements/statistics/card/issued.php");
	}
}

$REL_TPL->stdfoot($js_add);
?>
