<?php


require_once("include/connect.php");

dbconn();

$res=sql_query("SELECT * FROM  `faq` WHERE `status` = '0';")  or sqlerr(__FILE__, __LINE__);
	$i=0;
while ($row = mysql_fetch_array($res)){
	$data_faq[$i]=$row;
	if ($row['added']) {
		$data_faq[$i]['added'] = mkprettytime ($row['added'], false);

	}
	else{
		$data_faq[$i]['added'] = "N/A";

	}
	if($row['edited']) {
		$data_faq[$i]['edited'] = mkprettytime ($row['edited'], false);
	}
	else{
		$data_faq[$i]['edited'] = "N/A";
	}
	$i++;
}


$REL_TPL->stdhead("FAQ");
$REL_TPL->assignByRef('data_faq',$data_faq);
$REL_TPL->output("faq","basic");
$REL_TPL->stdfoot();

?>