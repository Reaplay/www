<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 16.05.2016
     * Time: 22:53
     */
    require_once("include/connect.php");

    dbconn();
if(!is_valid_id($_GET['id'])){
    stderr("Ошибка","Страница не найдена");
}
    $res=sql_query("SELECT * FROM page WHERE id = '".$_GET['id']."' AND status = '0'");
    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Страница не найдена или у вас нет доступа");
    }
    $row=mysql_fetch_array($res);
    $REL_TPL->stdhead($row['title']);
    print $row['text'];
    $REL_TPL->stdfoot();