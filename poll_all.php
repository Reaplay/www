<?php

require_once("include/connect.php");

dbconn();

if(!is_valid_id($_GET['id']))
	stderr("Ошибка","Опрос не найден");


$res=sql_query("SELECT * FROM `poll_index` WHERE id = '".$_GET['id']."';")  or sqlerr(__FILE__, __LINE__);
$row = mysql_fetch_array($res);
if($row['end_date'] AND $row['end_date']<time())
	stderr("Ошибка","Опрос завершен");
if($row['enable'] != "1")
	stderr("Ошибка","Опрос выключен");

$res_poll=sql_query("
SELECT poll_question.id as q_id, poll_question.question as q_q, poll_answer.answer as a_a, poll_answer.id as a_id
FROM `poll_question` 
LEFT JOIN `poll_answer` ON poll_answer.id_question = poll_question.id
WHERE poll_question.id_poll = '".$row['id']."' AND poll_answer.id_poll = '".$row['id']."';")  
or sqlerr(__FILE__, __LINE__);

while ($row_poll = mysql_fetch_array($res_poll)){
	/* в массив пихаем таким образом
	первая перменная - ИД вопроса
	
	первая строчка
		q_q - текст вопроса
	во второй строчке
		вторая перменная - ИД ответа
		и собственно сам ответ
		получается структура
		ID вопроса
			q-q - Вопрос
			ID ответа - Ответ
			
Array ( 
[1] => Array ( 
	[q_q] => Кто вы 
	[1] => человек 
	[2] => зерг 
	[3] => протос 
) 

[2] => Array ( 
	[q_q] => Зачем вы 
	[4] => могу 
	[5] => не могу ) 
)
			
			
	*/
	$data_poll[$row_poll['q_id']]['q_q']=$row_poll['q_q'];
	$data_poll[$row_poll['q_id']][$row_poll['a_id']]=$row_poll['a_a'];


//	$data_client[$i]=$row_poll;
	//нужно сделать, что бы перебирался ВТОРОЙ массив
	
	
	
	//$data_poll['q_id']=$row_poll['q_id'];
	//$data_poll[$row_poll['q_id']]['q_q']=$row_poll['q_q'];
	//$data_poll[$row_poll['q_id']][$i]['a_id']=$row_poll['a_id'];
	
	//$exit_poll[$row_poll['q_id']]=$data_poll[];


	//unset ($data_poll);
}
//$row_poll[] = mysql_fetch_array($res_poll);
// id опроса id ответа результат
//print_r ($data_poll);
//print $data_poll[2][3]['a_a'];

$REL_TPL->stdhead("Опрос");
$REL_TPL->output("poll_user","poll_all");
$REL_TPL->stdfoot();
?>

