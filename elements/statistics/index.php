<?php


	$statistics=$REL_CACHE->get('statistics', 'index',$REL_CONFIG['cache_statistic_all']);

	// UPDATE CACHES:
	if ($statistics===false) {
		$res=sql_query("
		(SELECT SUM(1) FROM users) UNION ALL
		(SELECT SUM(1) FROM department) UNION ALL
		(SELECT SUM(1) FROM client) UNION ALL
    	(SELECT SUM(1) FROM client WHERE status=0) UNION ALL
		(SELECT SUM(1) FROM client WHERE status=1) UNION ALL
		(SELECT SUM(1) FROM client WHERE status=2) UNION ALL
		(SELECT SUM(1) FROM callback) UNION ALL
		(SELECT SUM(1) FROM callback WHERE status=0) UNION ALL
		(SELECT SUM(1) FROM callback WHERE status=1) UNION ALL
		(SELECT SUM(1) FROM callback WHERE status=0 and type_contact = 1) UNION ALL
		(SELECT SUM(1) FROM callback WHERE status=0 and type_contact = 2)
      ");

		$params = array(
			'users',
			'departments',
			'all_client',
			'client',
			'not_client',
			'client_failure',
			'callback',
			'callback_held',
			'callback_planed',
			'callback_planned_call',
			'callback_planned_meeting'
		);
		foreach ($params as $param) {
			list($value) = mysql_fetch_array($res);
			$statistics[$param] = $value;

		}


		$REL_CACHE->set('statistics', 'index', $statistics);

	}

$REL_TPL->assignByRef('statistics',$statistics);



$REL_TPL->output("index","statistics");



?>
