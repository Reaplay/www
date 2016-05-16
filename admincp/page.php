<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 16.05.2016
     * Time: 22:58
     */

    if($_GET['id'] and !is_valid_id($_GET['id'])){
        stderr("Ошибка","Ошибка ID страницы");		//запись в лог
    }

    $REL_TPL->stdhead('Страницы');

    if($_GET['action']=="disable"){
        sql_query("UPDATE `page` SET `status` = '1' WHERE `id` =".$_GET['id'].";");
        $REL_TPL->stdmsg('Выполнено','Страница отключена');

    }
    if($_GET['action']=="enable"){
        sql_query("UPDATE `page` SET `status` = '0' WHERE `id` =".$_GET['id'].";");
        $REL_TPL->stdmsg('Выполнено','Страница включена');

    }
    if($_POST['action']=="edit"){

        sql_query("UPDATE `page` SET `text` = ".sqlesc($_POST['text']).", `title` = ".sqlesc($_POST['title']).", `edited` = '".time()."' WHERE `id` =".$_GET['id'].";") or sqlerr(__FILE__, __LINE__);

        $REL_TPL->stdmsg('Выполнено','Страница изменена');
    }
    if($_POST['action']=="add"){

        sql_query("INSERT INTO `page` (`text`,`title`, `added`) VALUES (".sqlesc($_POST['text']).",".sqlesc($_POST['title']).",".time().");");
        $REL_TPL->stdmsg('Выполнено','Страница добавлена');
    }
    if($_GET['action']=="edit"){
        $res=sql_query("SELECT * FROM `page` WHERE id = '".$_GET['id']."'")  or sqlerr(__FILE__, __LINE__);
        if(mysql_num_rows($res) == 0){
            stderr("Ошибка","Такая Страница отсутствует в базе","no");
        }

        $data_page = mysql_fetch_array($res);

        $action	="edit";

        $REL_TPL->assignByRef("action",$action);
        $REL_TPL->assignByRef("id",$_GET['id']);
        $REL_TPL->assignByRef('data_page',$data_page);
        $REL_TPL->output("page_add_edit","admincp");

    }
    elseif($_GET['action']=="add"){
        $res_p=sql_query("SELECT * FROM `page`")  or sqlerr(__FILE__, __LINE__);

        $action	="add";
        $REL_TPL->assignByRef("action",$action);

        $REL_TPL->output("page_add_edit","admincp");
    }
    else {
        $res = sql_query ("SELECT * FROM `page`;") or sqlerr (__FILE__, __LINE__);
        if (mysql_num_rows ($res) == 0) {
            stderr ("Ошибка", "Вопросы не найдены. <a href='action_admin.php?module=page&action=add'>Добавить?</a>","no");
        }
        $i=0;
        while ($row = mysql_fetch_array ($res)) {
            $data_page[$i]=$row;
            if ($row['added']) {
                $data_page[$i]['added'] = mkprettytime ($row['added'], false);
            }
            else{
                $data_page[$i]['added'] = "N/A";
            }

            if($row['edited']) {
                $data_page[$i]['edited'] = mkprettytime ($row['edited'], false);
            }
            else{
                $data_page[$i]['edited'] = "N/A";
            }
            $i++;
        }

        $REL_TPL->assignByRef('data_page',$data_page);
        $REL_TPL->output("page_index","admincp");
    }

    $REL_TPL->stdfoot();