<?php

require_once("include/connect.php");

dbconn();

$res=sql_query("SELECT * FROM  `changelog` ORDER BY `id` DESC;")  or sqlerr(__FILE__, __LINE__);
$i=0;
while ($row = mysql_fetch_array($res)){
	
	$changelog[$i]['rev'] = $row['rev'];
	$changelog[$i]['text'] = $row['text'];
	$changelog[$i]['id'] = $row['id'];
	if($row['date']){
		$changelog[$i]['date'] = mkprettytime($row['date'],false);
	}
	$i++;
}

$REL_TPL->stdhead("Список изменений");
$REL_TPL->assignByRef('changelog',$changelog);
$REL_TPL->output("changelog","basic");
$REL_TPL->stdfoot();
?>
