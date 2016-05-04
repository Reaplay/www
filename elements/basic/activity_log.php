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

// LEFT JOIN callback ON callback.id = client.id_callback
	$first_part_sql = "SELECT SUM(1) FROM `callback` LEFT JOIN client ON client.id = callback.id_client WHERE client.delete = '0' AND client.department='".$CURUSER['department']."' AND callback.status = 0 AND callback.next_call != 0";

$res=sql_query("
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 1 AND client.status=1 AND callback.next_call > '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND callback.type_contact = 2 AND client.status=1 AND callback.next_call > '".$now_date."') UNION ALL
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
	$REL_TPL->assignByRef('activity_log',$activity_log);


if ($CURUSER['use_card']) {
	$first_part_sql = "SELECT SUM(1) FROM `card_client` WHERE card_client.delete = 0 AND card_client.department='".$CURUSER['department']."' AND card_client.status = 0 AND card_client.next_call != 0";

	$res=sql_query("
(".$first_part_sql." AND card_client.next_call = '".$now_date."') UNION ALL
(".$first_part_sql." AND card_client.next_call < '".$now_date."') UNION ALL
(".$first_part_sql." AND card_client.next_call > '".$now_date."')

;")	or sqlerr(__FILE__, __LINE__);
	$params = array(
		'card_now',
		'card_lost',
		'card_next');
	foreach ($params as $param) {
		list($value) = mysql_fetch_array($res);
		$activity_card[$param] = $value;
	}
	$REL_TPL->assignByRef('activity_card',$activity_card);


	$res = sql_query("
	SELECT card_cobrand.name, card_cobrand.id, (SELECT SUM(1) FROM `card_client` WHERE card_client.id_cobrand = card_cobrand.id AND card_client.delete = 0 AND card_client.status = 0 AND card_client.next_call != 0 AND card_client.department='".$CURUSER['department']."' AND card_client.next_call = '".$now_date."') AS card_now, (SELECT SUM(1) FROM `card_client` WHERE card_client.id_cobrand = card_cobrand.id AND card_client.delete = 0 AND card_client.status = 0 AND card_client.next_call != 0 AND card_client.department='".$CURUSER['department']."' AND card_client.next_call < '".$now_date."') AS card_lost, (SELECT SUM(1) FROM `card_client` WHERE card_client.id_cobrand = card_cobrand.id AND card_client.delete = 0 AND card_client.status = 0 AND card_client.next_call != 0 AND card_client.department='".$CURUSER['department']."' AND card_client.next_call > '".$now_date."') AS card_next  FROM card_cobrand") or sqlerr(__FILE__, __LINE__);

	while ($row = mysql_fetch_array($res)) {
		$data_card[] = $row;

	}
	$REL_TPL->assignByRef('data_card',$data_card);

}

	//var_dump($activity_log);


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
