<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 03.05.2016
     * Time: 22:54
     */
    //если дата задана
    if($_POST["time_range"]){
        // получаем даты и разбиваем их
        $time_range  = explode(" - ",$_POST["time_range"]);
        //разбиваем и преобразуем еще раз
        // начало
        $start_date = explode("-",$time_range['0']);
        $start_date = mktime( 0,0,0,$start_date['1'],$start_date['0'],$start_date['2']);
        //конец
        $end_date = explode("-",$time_range['1']);
        $end_date = mktime( 23,59,59,$end_date['1'],$end_date['0'],$end_date['2']);
        $data_range = $_POST["time_range"];
    }
    else{
        //получаем сегодняшнюю дату, преобразовываем её
        $arr_cur_time = explode("/",date("d/m/Y",time()));
        $start_date = mktime( 0,0,0,$arr_cur_time['1'],$arr_cur_time['0'],$arr_cur_time['2']);
        $end_date = mktime( 23,59,59,$arr_cur_time['1'],$arr_cur_time['0'],$arr_cur_time['2']);
       // $data_range = date("d-m-Y",time()) ." - ".date("d-m-Y",time());
    }

    if(get_user_class()<UC_POWER_HEAD){
        //$left_join_client = "";
        $department_users = "AND users.department = '".$CURUSER['department']."'";

        //$left_join_card = "";
        $department_card = "AND card_client.department = '".$CURUSER['department']."'";

    }
    elseif(get_user_class()== UC_POWER_HEAD){
        $left_join_users = "LEFT JOIN department ON department.id=users.department";
        $department_users = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";

        $left_join_card = "LEFT JOIN department ON department.id=card_client.department";
        $department_card = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
    }

    //получаем инфу по пользователям
    $res_user=sql_query("SELECT users.name, users.department, (SELECT SUM(1) FROM card_client WHERE card_client.manager = users.id AND card_client.status = 1 AND card_client.last_update >= '".$start_date."' AND card_client.last_update <= '".$end_date."') AS issued, (SELECT SUM(1) FROM card_client WHERE card_client.manager = users.id AND card_client.status = 2 AND card_client.last_update >= '".$start_date."' AND card_client.last_update <= '".$end_date."') AS destroy FROM users $left_join_users WHERE users.use_card = 1 $department_users") or sqlerr(__FILE__, __LINE__);
    $i=0;
    while ($row_user = mysql_fetch_array($res_user)){
        if (($row_user['issued'] + $row_user['destroy']) == 0)
            continue;
        $data_user[$i]=$row_user;
        $data_user[$i]['all']=$row_user['issued'] + $row_user['destroy'];
        $i++;
    }

    //получаем инфу по картам
    $res_card=sql_query("SELECT card_cobrand.name,
(SELECT SUM(1) FROM card_client $left_join_card WHERE card_client.id_cobrand = card_cobrand.id AND card_client.status = 1 AND card_client.last_update >= '".$start_date."' AND card_client.last_update <= '".$end_date."' $department_card) AS issued,
(SELECT SUM(1) FROM card_client $left_join_card WHERE card_client.id_cobrand = card_cobrand.id AND card_client.status = 2 AND card_client.last_update >= '".$start_date."' AND card_client.last_update <= '".$end_date."' $department_card) AS destroy FROM card_cobrand ") or sqlerr(__FILE__, __LINE__);
    $i=0;
    while ($row_card = mysql_fetch_array($res_card)){
        if (($row_card['issued'] + $row_card['destroy']) == 0)
            continue;
        $data_card[$i]=$row_card;
        $data_card[$i]['all']=$row_card['issued'] + $row_card['destroy'];
        $i++;
    }
    $REL_TPL->assignByRef('data_user',$data_user);
    $REL_TPL->assignByRef('data_card',$data_card);
    $REL_TPL->assignByRef('data_range',$data_range);


    $REL_TPL->output("card_issued","statistics");