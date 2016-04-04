<?php
global $REL_LANG, $REL_CONFIG, $REL_CACHE, $REL_SEO;
if (!defined('BLOCK_FILE')) {
	safe_redirect(" ../".$REL_SEO->make_link('index'));
	exit;
}

$block_online=$REL_CACHE->get('block_client_depart', 'queries',300);

// UPDATE CACHES:
if ($block_online===false) {
	$res=sql_query("(SELECT COUNT(1) FROM `client`) UNION ALL
	(SELECT COUNT(1) FROM `client` WHERE department = '0') UNION ALL
	(SELECT COUNT(1) FROM `client` WHERE manager = '0') 
	");

	$params = array(
'num_client',
'not_department',
'not_client');
	foreach ($params as $param) {
		list($value) = mysql_fetch_array($res);
		$data_stat[$param] = $value;
	}


	$REL_CACHE->set('block_client_depart-stats', 'queries', $block_online);

}


$REL_TPL->assignByRef('data_stat',$data_stat);


?>