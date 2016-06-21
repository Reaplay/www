<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 02.05.2016
     * Time: 11:48
     */


    $REL_TPL->stdhead("Обновление БД");



    if($_GET['action'] == "start"){
        /*$res = sql_query("SELECT * FROM sys_fix_base WHERE id = '".$_GET['id']."'");
        $row = mysql_fetch_array($res);
        */
        // прикрепляем к клиенту ID последнего колбека
        if($_GET['type'] == 'fix_callback_1') {
            $res = sql_query ("SELECT `id`,`id_client` FROM callback WHERE status = '0';");
           if (mysql_num_rows ($res) == 0) {
                stderr ("Ошибка", "Данный фикс не требуется", "no");
            }
            while ($row = mysql_fetch_array ($res)) {

                sql_query("UPDATE client SET id_callback = '".$row['id']."' WHERE id = '".$row['id_client']."'");
                //UPDATE cache_stats SET cache_value=".sqlesc($_POST[$param])." WHERE cache_name='$param'";
            }
        }
        // прикрепляем к клиенту дату последнего колбека
        if($_GET['type'] == 'fix_callback_2') {
            $res = sql_query ("SELECT `id`,`id_client`, `next_call` FROM callback WHERE status = '0';");
            if (mysql_num_rows ($res) == 0) {
                stderr ("Ошибка", "Данный фикс не требуется", "no");
            }
            while ($row = mysql_fetch_array ($res)) {

                sql_query("UPDATE client SET `next_call` = '".$row['next_call']."' WHERE id = '".$row['id_client']."'");

            }
        }
        //если EQ определен, то ставим статус клиент
        if($_GET['type'] == 'fix_callback_3') {
            $res = sql_query ("SELECT `id` FROM client WHERE status != '1' AND equid !='';");
            if (mysql_num_rows ($res) == 0) {
                stderr ("Ошибка", "Данный фикс не требуется", "no");
            }
            while ($row = mysql_fetch_array ($res)) {

                sql_query("UPDATE `client` SET `status` = '1' WHERE `status` = '0' AND `equid` !='' AND id= '".$row['id']."';");

            }
        }
        if($_GET['type'] == 'fix_callback_4') {
            $res = sql_query ("SELECT `card_callback`.`id` FROM `card_client` LEFT JOIN card_callback on card_callback.id = card_client.id_callback WHERE `card_client`.`status` != 0 AND card_callback.id_client = card_client.id AND `card_callback`.`manager` < 15 AND `card_callback`.`added` < 1465396200 AND `card_callback`.`manager` != 0;");
            if (mysql_num_rows ($res) == 0) {
                stderr ("Ошибка", "Данный фикс не требуется", "no");
            }
            while ($row = mysql_fetch_array ($res)) {

                sql_query("UPDATE `card_callback` SET `manager` = '0' WHERE id= '".$row['id']."';");

            }
        }
    }

    $REL_TPL->output("update_base","admincp");
    $REL_TPL->stdfoot();

