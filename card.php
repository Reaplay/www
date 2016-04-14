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
    elseif ($_GET['action'] == 'add') {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/tpl_basic_action_card.php");
    }
    elseif ($_GET['action'] == 'change') {
        $REL_TPL->stdhead("Добавить карту клиента");
        require_once("elements/card/add_change_card.php");
    }
    $REL_TPL->stdfoot();