<?php
//
$now_date = strtotime(date("d.m.Y"));

/*

Те, что относятся к пользователю
действия по которым НЕ сделаны
1) звонок, клиент активен, сделать сегодня
2) звонок, клиент активен, действие пропущено

*/
// упростим запрос, для удобства чтения

if(get_user_class() == UC_ADMINISTRATOR and $_GET['user_id']){
	$first_part_sql = "SELECT SUM(1) FROM `callback` LEFT JOIN client ON client.id = callback.id_client WHERE client.manager='".$_GET['user_id']."' AND callback.status = 0 AND callback.next_call != 0";
}
else {
	$first_part_sql = "SELECT SUM(1) FROM `callback` LEFT JOIN client ON client.id = callback.id_client WHERE client.manager='".$CURUSER['id']."' AND callback.status = 0 AND callback.next_call != 0";
}
$res=sql_query("
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call > '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call > '".$now_date."') 
UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=0 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=0 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=0 AND callback.next_call > '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=0 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=0 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=0 AND callback.next_call > '".$now_date."')     

;") 
or sqlerr(__FILE__, __LINE__);
/*
шаблон для перменных
stat - статистика по отделению
act - активные клиенты
pot - потенциальные
base - база и рекомендации

mt - встреча
call - звонок

now  - на сегодня
lost - пропущены
next - дальнейшие

act_mt_now
act_mt_lost
act_mt_next
act_call_now
act_call_lost
act_call_next
*/
$params = array(
'act_mt_now',
'act_mt_lost',
'act_mt_next',
'act_call_now',
'act_call_lost',
'act_call_next',
'pot_mt_now',
'pot_mt_lost',
'pot_mt_next',
'pot_call_now',
'pot_call_lost',
'pot_call_next');
foreach ($params as $param) {
	list($value) = mysql_fetch_array($res);
	$activity_log[$param] = $value;
}
	//var_dump($activity_log);
$REL_TPL->assignByRef('activity_log',$activity_log);
/*
активные (пропущено-сегодня)
потенциальные

для простого пользователя:
ид юзвера, статус (нужен 0, т.е. не выполнено)
тип контакта (звонок или приход)
дата след. звонка, равна сегодняшней или меньше

SELECT SUM(1)
FROM `callback`
LEFT JOIN client ON client.id = callback.id_client  
WHERE callback.id_user='".$CURUSER['id']."' AND callback.status = 0 AND callback.type_contact = 1 AND client.status=1 AND callback.nex_call='".time()."'


$res=sql_query("
(SELECT SUM(1) FROM callback WHERE id_user='".$CURUSER['id']."' AND status = 0 AND type_contact = 1) UNION ALL
(SELECT SUM(1) FROM callback WHERE id_user='".$CURUSER['id']."' AND status = 0 AND type_contact = 1) UNION ALL
(SELECT SUM(1) FROM client WHERE status=0) UNION ALL
(SELECT SUM(1) FROM client WHERE gender=1) UNION ALL
(SELECT SUM(1) FROM client WHERE gender=2)
      ");

	$params = array(
'num_client',
'not_manager',
'not_client',
'male',
'female');
	foreach ($params as $param) {
		list($value) = mysql_fetch_array($res);
		$block_online[$param] = $value;
	}


	




// var_dump($block_online);
$num_client = $block_online['num_client'];
*/

//$REL_TPL->assignByRef('data_callback',$data_callback);
$REL_TPL->output("activity_log","basic");

?>
