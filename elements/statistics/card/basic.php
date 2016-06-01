<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 10.05.2016
     * Time: 22:05
     */
     //stderr("Ошибка","Данный функционал еще в разработке и поэтому не доступен","no");

     $card_department=$REL_CACHE->get('statistics', 'card_department'.$CURUSER['department'],$REL_CONFIG['cache_statistic_card']);

     // UPDATE CACHES:
     if ($card_department===false) {
          $res=sql_query("
          (SELECT SUM(1) FROM card_client WHERE department = ".$CURUSER['department'].") UNION ALL
		  (SELECT SUM(1) FROM card_client WHERE status = 1 AND department = ".$CURUSER['department'].") UNION ALL
		  (SELECT SUM(1) FROM card_client WHERE status = 2 AND department = ".$CURUSER['department'].") UNION ALL
    	  (SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 0 AND card_client.department = ".$CURUSER['department']." AND card_callback.next_call >= '".time()."') UNION ALL
		  (SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 0 AND card_client.department = ".$CURUSER['department']." AND card_callback.next_call < '".time()."')
          ");

          $params = array('all_added','all_issue','all_destroy','all_wait','all_expired');

          foreach ($params as $param) {
               list($value) = mysql_fetch_array($res);
               $card_department[$param] = $value;

         }
          $avg_time = 0;
          $i=0;
          $res_avg=sql_query("SELECT card_client.added as start, card_callback.added as end FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 1 OR card_client.status = 2");
          while($row_avg = mysql_fetch_array($res_avg)){
               $avg_time =$avg_time + $row_avg['and'] - $row_avg['start'];
               $i++;
          }

          $card_department['all_avg_time'] = date("H:i:s", mktime(0, 0, $avg_time/$i));
          $REL_CACHE->set('statistics', 'card_department'.$CURUSER['department'], $card_department);

     }
     /*
     $card_manager=$REL_CACHE->get('statistics', '$card_manager',$REL_CONFIG['cache_statistic_card']);


     if ($card_manager===false) {
          $res=sql_query("
          (SELECT SUM(1) FROM card_client WHERE department = ".$CURUSER['department'].") UNION ALL
		  (SELECT SUM(1) FROM card_client WHERE status = 1 AND department = ".$CURUSER['department'].") UNION ALL
		  (SELECT SUM(1) FROM card_client WHERE status = 2 AND department = ".$CURUSER['department'].") UNION ALL
    	  (SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 0 AND card_client.department = ".$CURUSER['department']." AND card_callback.added <= '".time()."') UNION ALL
		  (SELECT SUM(1) FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 0 AND card_client.department = ".$CURUSER['department']." AND card_callback.added > '".time()."')
          ");

          $params = array('all_added','all_issue','all_destroy','all_wait','all_expired');

          foreach ($params as $param) {
               list($value) = mysql_fetch_array($res);
               $card_manager[$param] = $value;

          }
          $avg_time = 0;
          $i=0;
          $res_avg=sql_query("SELECT card_client.added as start, card_callback.added as end FROM card_client LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.status = 1 OR card_client.status = 2");
          while($row_avg = mysql_fetch_array($res_avg)){
               $avg_time =$avg_time + $row_avg['and'] - $row_avg['start'];
               $i++;
          }

          $card_manager['all_avg_time'] = date("H:i:s", mktime(0, 0, $avg_time/$i));
          $REL_CACHE->set('statistics', 'index', $card_manager);

     }

*/

     $REL_TPL->assignByRef('card',$card_department);
  //   $REL_TPL->assignByRef('data',$card_manager);
     //$REL_TPL->assignByRef('data_range',$data_range);


     $REL_TPL->output("basic","statistics");
