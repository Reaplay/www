<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 03.04.2016
     * Time: 14:13
     */
    /* функция обработки статистики клиентов*/
    function processing_stat_client($department,$begin_month,$last_month){
        $res_client_month = sql_query("SELECT  users.id,users.name, COUNT(*) as num , client.status FROM users LEFT JOIN client ON  client.manager = users.id WHERE client.department = ".$department." AND client.added > ".$begin_month." AND client.added < ".$last_month."  GROUP BY users.id, client.status;");

        while ($row = mysql_fetch_array($res_client_month)){
            $data_month[$row['id']]['id']=$row['id'];
            $data_month[$row['id']]['name']=$row['name'];
            if($row['status'] == 0){
                $data_month[$row['id']]['no_client']=$row['num'];
            }
            elseif($row['status'] == 1){
                $data_month[$row['id']]['client']=$row['num'];
            }
            elseif($row['status'] == 2){
                $data_month[$row['id']]['decline']=$row['num'];
            }
        }
        return $data_month;

    }
    /* функция обработки статистики контактов*/
    function processing_stat_contact($department,$begin_month,$last_month){
        $res_callback_last_month = sql_query("SELECT  users.id,users.name, COUNT(*) as num , callback.type_contact FROM users LEFT JOIN callback ON  callback.id_user = users.id WHERE users.department = ".$department." AND callback.added > ".$begin_month." AND callback.added < ".$last_month." GROUP BY users.id, callback.type_contact;");

        while ($row = mysql_fetch_array($res_callback_last_month)) {
            $data_callback[$row['id']]['id'] = $row['id'];
            $data_callback[$row['id']]['name'] = $row['name'];
            if ($row['type_contact'] == 1) {
                $data_callback[$row['id']]['call'] = $row['num'];
            } elseif ($row['type_contact'] == 2) {
                $data_callback[$row['id']]['meeting'] = $row['num'];
            }
        }
        return $data_callback;
    }
// формируем даты
    $current_month = date('m');
    $current_year = date('Y');
    if($current_month == 1) {
        $last_month = 12;
        $last_year = date('Y') - 1;
        $last_day = getdate('t');
    }
    else{
        $last_month = $current_month -1;
        $last_year =  $current_year;
    }
    //задаем даты для выборки
    $begin_last_month = mktime(0, 0, 0, $last_month, 1, $last_year);
    $end_last_month =  mktime(0, 0, 0, $current_month, 0, $last_year);

    $begin_current_month = mktime(0, 0, 0, $current_month, 1, $current_year);
    $end_current_month =  mktime(0, 0, 0, $current_month+1, 0, $current_year);

    //получаем данные
    $data_last_month =  processing_stat_client($CURUSER['department'],$begin_last_month,$end_last_month);
    $callback_last_month = processing_stat_contact($CURUSER['department'],$begin_last_month,$end_last_month);

    $data_current_month =  processing_stat_client($CURUSER['department'],$begin_current_month,$end_current_month);
    $callback_current_month = processing_stat_contact($CURUSER['department'],$begin_current_month,$end_current_month);

    $REL_TPL->assignByRef('data_last_month',$data_last_month);
    $REL_TPL->assignByRef('callback_last_month',$callback_last_month);
    $REL_TPL->assignByRef('data_current_month',$data_current_month);
    $REL_TPL->assignByRef('callback_current_month',$callback_current_month);
    $REL_TPL->output("department","statistics");