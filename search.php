<?php

require_once("include/connect.php");

dbconn();
$REL_TPL->stdhead("Поиск");

/*
сначала пишем поиск по клиентам
искать по:
фио, equid, телефону
t - type (клиент, пользователь, и т.д., среди кого искать)
d - department  - id отделения, в котором ищем
v - value - значение, то что мы ищем (если поиск по тексту)
id - идентификатор некоторых значений


*/

    if ($_GET['s']){
        $res = sql_query("
SELECT client.name, client.mobile, client.equid, department.name as d_name, users.name as u_name
FROM `client`
LEFT JOIN department ON department.id = client.department
LEFT JOIN users ON users.id = client.manager
WHERE client.name LIKE '%".$_GET['s']."%' OR client.mobile LIKE '%".$_GET['s']."%' OR client.equid LIKE '%".$_GET['s']."%' LIMIT 0 , 30")  or sqlerr(__FILE__,__LINE__);
        if(mysql_num_rows($res) == 0){
            stderr("Ошибка","Ничего не найдено","no");
        }

        while ($row = mysql_fetch_array($res)){
            $data_search[]=$row;
        }
        $REL_TPL->assignByRef('data_search',$data_search);
    }
$REL_TPL->output("search","basic");
$REL_TPL->stdfoot();
?>
