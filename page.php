<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 16.05.2016
     * Time: 22:53
     */
    require_once("include/connect.php");

    dbconn();
if($_GET['id'] AND !is_valid_id($_GET['id'])){
    stderr("Ошибка","Страница не найдена");
}
    if($_GET['id']){
        $res=sql_query("SELECT * FROM page WHERE id = '".$_GET['id']."' AND status = '0'");
        if(mysql_num_rows($res) == 0){
            stderr("Ошибка","Страница не найдена или у вас нет доступа");
        }
        $row=mysql_fetch_array($res);
        $REL_TPL->stdhead($row['title']);
        print $row['text'];
    }
    else{
        $res=sql_query("SELECT * FROM page WHERE status = '0'");

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

        $REL_TPL->stdhead("Список страниц");
        $REL_TPL->output("page","basic");
    }
    $REL_TPL->stdfoot();