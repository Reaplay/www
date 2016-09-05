<?php

require_once("include/connect.php");

dbconn();
$REL_TPL->stdhead("Поиск");
loggedinorreturn();
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
		if($_GET['type']=="card"){
			$res = sql_query("
SELECT card_client.name, card_client.id, card_client.mobile, card_client.equid, department.name as d_name, users.name as u_name
FROM `card_client`
LEFT JOIN department ON department.id = card_client.department
LEFT JOIN users ON users.id = card_client.manager
WHERE card_client.name LIKE '%".$_GET['s']."%' OR card_client.mobile LIKE '%".$_GET['s']."%' OR card_client.equid LIKE '%".$_GET['s']."%' LIMIT 0 , 30")  or sqlerr(__FILE__,__LINE__);
		$REL_TPL->assignByRef('type',$_GET['type']);
			
		}
		else{
        $res = sql_query("
SELECT client.name, client.id, client.mobile, client.equid, department.name as d_name, users.name as u_name
FROM `client`
LEFT JOIN department ON department.id = client.department
LEFT JOIN users ON users.id = client.manager
WHERE client.name LIKE '%".$_GET['s']."%' OR client.mobile LIKE '%".$_GET['s']."%' OR client.equid LIKE '%".$_GET['s']."%' LIMIT 0 , 30")  or sqlerr(__FILE__,__LINE__);
		}
		
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
