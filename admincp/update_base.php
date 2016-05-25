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

                sql_query("UPDATE client SET `status` = '1' WHERE status != '1' AND equid !='';");

            }
        }
    }

    $REL_TPL->output("update_base","admincp");
    $REL_TPL->stdfoot();

