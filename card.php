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
    if(!$CURUSER['user_card'])
        stderr("Ошибка","У вас нет доступа к данной странице");

    if (!$_GET['a']) {
        $REL_TPL->stdhead("Список клиентов");
        require_once("elements/card/index.php");
    }

    $REL_TPL->stdfoot();