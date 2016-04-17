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

    if (!$_GET['action']) {
        $REL_TPL->stdhead("Список карт");
        require_once("elements/card/index.php");
    }
    elseif ($_GET['action'] == 'add' AND !$CURUSER['only_view']) {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/tpl_basic_action_card.php");
    }
    elseif ($_GET['action'] == 'edit' AND !$CURUSER['only_view']) {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/tpl_basic_action_card.php");
    }
    elseif ($_GET['action'] == 'change' AND !$CURUSER['only_view']) {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/add_change_card.php");
    }
    elseif ($_GET['action'] == 'call_client' AND !$CURUSER['only_view']) {
        $REL_TPL->stdhead("Добавить звонок по карте");
        require_once("elements/card/call_client.php");
    }
    elseif ($_GET['action'] == 'view') {
        $REL_TPL->stdhead("Просмотр карты клиента");
        require_once("elements/card/view_card.php");
    }
    else{
        stderr("Ошибка","В доступе отказано");
        //запись в лог
    }
    $REL_TPL->stdfoot();