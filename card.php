<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 14.04.2016
     * Time: 19:08
     */

    require_once("include/connect.php");

    dbconn();
    loggedinorreturn();
    if(!$CURUSER['use_card'])
        stderr("Ошибка","У вас нет доступа к данной странице");

    if(!$REL_CONFIG['deny_card'] AND get_user_class() != UC_ADMINISTRATOR){
        stderr("Ошибка","Данный функционал отключен администратором");
    }

/*
if($_GET['s']){
		safe_redirect("search.php?type=card&s=".$_GET['s']);
		die();
	}*/
	
    if (!$_GET['action']) {
        $REL_TPL->stdhead("Список карт");
        require_once("elements/card/index.php");
    }
    elseif ($_GET['action'] == 'view') {
        $REL_TPL->stdhead("Просмотр карты клиента");
        require_once("elements/card/view_card.php");
    }
    elseif($CURUSER['only_view']){
        stderr("Ошибка","В доступе отказано");
    }
    elseif ($_GET['action'] == 'add') {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/tpl_basic_action_card.php");
    }
    elseif ($_GET['action'] == 'edit') {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/tpl_basic_action_card.php");
    }
    elseif ($_GET['action'] == 'change') {
        $REL_TPL->stdhead("Карта клиента");
        require_once("elements/card/add_change_card.php");
    }
    elseif($_GET['action'] == "change_mgr"){
        require_once("elements/card/change.php");
    }
    elseif ($_GET['action'] == 'call_client') {
        $REL_TPL->stdhead("Добавить звонок по карте");
        require_once("elements/card/call_client.php");
    }
    elseif ($_GET['action']=="delete") {
        require_once("elements/card/delete_card.php");
    }
    elseif ($_GET['action']=="upload_cards") {
        $REL_TPL->stdhead("Массовая загрузка карт");
        require_once("elements/card/upload_cards.php");
    }
     else{
        stderr("Ошибка","В доступе отказано");
        //запись в лог
    }
    $REL_TPL->stdfoot();
