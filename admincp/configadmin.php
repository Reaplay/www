<?php
/**
 * Configuration script (main)
 * @license GNU GPLv3 http://opensource.org/licenses/gpl-3.0.html
 * @package Kinokpk.com releaser
 * @author ZonD80 <admin@kinokpk.com>
 * @copyright (C) 2008-now, ZonD80, Germany, TorrentsBook.com
 * @link http://dev.kinokpk.com
 */

require_once "include/connect.php";
dbconn();

if (get_user_class() < UC_ADMINISTRATOR) 
	stderr("Ошибка","В доступе отказано");


if (!isset($_GET['action'])){
	$REL_TPL->stdhead("Основные настройки");


	$REL_TPL->output("configadmin","admincp");
	$REL_TPL->stdfoot();

}

elseif ($_GET['action'] == 'save'){
	if($_POST['type']=="site"){
		$reqparametres=array('siteonline','defaultbaseurl','siteemail','adminemail','default_theme','yourcopy','use_blocks','use_gzip');
	}
	elseif($_POST['type']=="crm"){
		$reqparametres=array('per_page_clients','per_page_users','per_page_department','per_page_callback');
	}
	elseif($_POST['type']=="register"){
		$reqparametres=array('deny_signup');
	}
	elseif($_POST['type']=="notify"){
		$reqparametres=array('default_notifs','default_emailnotifs');
	}
	elseif($_POST['type']=="limit"){
		$reqparametres=array('maxusers','pm_max');
	}
	elseif($_POST['type']=="security"){
		$reqparametres=array('debug_mode','debug_template');
	}
	elseif($_POST['type']="cache"){
		$reqparametres=array('cache_template','cache_template_time','cache_statistic_all');
	}

	//$captcha_param = array('re_publickey','re_privatekey');

	$updateset = array();

	foreach ($reqparametres as $param) {
		if (!isset($_POST[$param])) stderr("Ошибка","Некоторые поля не заполнены ($param)");
		$updateset[] = "UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
	}
/*
	if ($_POST['use_captcha'] == 1) {
		foreach ($captcha_param as $param) {
			if (!$_POST[$param] || !isset($_POST[$param])) stderr($REL_LANG->say_by_key('error'),"Приватный или публичный ключи капчи не определены");
			$updateset[] = "UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
		}
	}*/

	foreach ($updateset as $query) sql_query($query);

	$REL_CACHE->clearCache('system','config');

	safe_redirect("action_admin.php?module=configadmin");


}

else
	stderr("Ошибка","Неизвестное действие");

?>