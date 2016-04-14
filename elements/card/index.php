<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 14.04.2016
     * Time: 19:34
     */
    

    $page = (int) $_GET["page"];

    if ($page < 2){
        $start_page = 0;
        $page = 1;
    }
    else {
        $start_page = ($page - 1)*$REL_CONFIG['per_page_card'];
    }
    $cpp = $REL_CONFIG['per_page_card'];
    $limit = "LIMIT ".$start_page." , ".$cpp;


    //выводим список всех пользователей, которых мы можем редактировать
    // всех пользователей могут редактировать лишь принадлежащие к ОО Самарский
    if(get_user_class()==UC_HEAD){
        $department = "card.department = '".$CURUSER['department']."' AND";
    }
    elseif(get_user_class()==UC_POWER_HEAD){
        $department = "(department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')  AND";
        $left_join = "LEFT JOIN department ON department.id = card.department";
    }
    if(get_user_class() <= UC_ADMINISTRATOR){
        //$banned = "AND users.banned = '0' ";
    }


    $res=sql_query("SELECT card.*, department.name as d_name, department.parent FROM `card` LEFT JOIN department ON department.id = card.department  WHERE ".$department." ".$limit.";")  or sqlerr(__FILE__, __LINE__);

    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Карты не найдены","no");
    }

    while ($row = mysql_fetch_array($res)){
        $data_card[]=$row;
    }


    //необходима оптимизация
    // узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
    $res = sql_query("SELECT SUM(1) FROM card $left_join WHERE ".$department." ;") or sqlerr(__FILE__,__LINE__);
    $row = mysql_fetch_array($res);
    //всего записей
    $count = $row[0];
    //всего страниц
    $max_page = ceil($count / $cpp);
    //print $cpp;



    $REL_TPL->assignByRef('data_card',$data_card);

    $REL_TPL->assignByRef('cpp',$cpp);
    $REL_TPL->assignByRef('page',$page);
    //$REL_TPL->assignByRef('add_link',$add_link);
    $REL_TPL->assignByRef('max_page',$max_page);

    $REL_TPL->output("index","card");



    ?>
