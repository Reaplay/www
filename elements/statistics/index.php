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
		(SELECT SUM(1) FROM callback WHERE status=0 and type_contact = 2) UNION ALL
		(SELECT SUM(1) FROM callback WHERE type_contact = 3)
      ");

		$params = array(
			'users',
			'departments',
			'all_client',
			'not_client',
			'client',
			'client_failure',
			'callback',
			'callback_held',
			'callback_planed',
			'callback_planned_call',
			'callback_planned_meeting',
			'callback_recomend'
		);
		foreach ($params as $param) {
			list($value) = mysql_fetch_array($res);
			$statistics[$param] = $value;

		}


		$REL_CACHE->set('statistics', 'index', $statistics);

	}

	$now_date = strtotime(date("d.m.Y"));

	$res_dep = sql_query("SELECT id, name FROM department WHERE parent !=0 AND `disable` = '0'") or sqlerr(__FILE__, __LINE__);
	while ($row_dep = mysql_fetch_array($res_dep)) {
		$department[] = $row_dep;
	}
	$i = 0;
	foreach ($department as $data_department) {
		$data[$i]['name_department'] = $data_department['name'];

		$date_start = 0;
		$date_end = time();

		$res_card = sql_query("(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."') UNION ALL
		(SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id_client = card_client.id WHERE department = '".$data_department['id']."') UNION ALL
		(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."' AND status = 1) UNION ALL
		(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."' AND status = 2) UNION ALL

		(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."' AND added >= '".$date_start."' AND added <= '".$date_end."') UNION ALL
		(SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id_client = card_client.id WHERE department = '".$data_department['id']."' AND card_callback.added >= '".$date_start."' AND card_callback.added <= '".$date_end."') UNION ALL
		(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."' AND status = 1 AND added >= '".$date_start."' AND added <= '".$date_end."') UNION ALL
		(SELECT SUM(1) FROM card_client WHERE department = '".$data_department['id']."' AND status = 2 AND added >= '".$date_start."' AND added <= '".$date_end."')") or sqlerr(__FILE__, __LINE__);


		$params = array(
			'all_added',
			'all_call',
			'all_issue',
			'all_destroy',
			'range_added',
			'range_call',
			'range_issue',
			'range_destroy');
		foreach ($params as $param) {
			list($value) = mysql_fetch_array($res_card);
			$data[$i][$param] = $value;

		}
		$i++;

	}

	$REL_TPL->assignByRef('statistics',$statistics);
	$REL_TPL->assignByRef('data_card',$data);
	$REL_TPL->output("index","statistics");



?>
