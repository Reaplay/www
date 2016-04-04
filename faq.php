<?php


require_once("include/connect.php");

dbconn();

$res=sql_query("SELECT * FROM  `faq`;")  or sqlerr(__FILE__, __LINE__);
while ($row = mysql_fetch_array($res)){
	$data_faq[]=$row;
}


$REL_TPL->stdhead("FAQ");
$REL_TPL->assignByRef('data_faq',$data_faq);
$REL_TPL->output("faq","basic");
$REL_TPL->stdfoot();

?>