<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 03.04.2016
     * Time: 14:13
     */

    if($_POST['id_user']){

    }

    if(get_user_class()==UC_HEAD){
        $department = "users.department = '".$CURUSER['department']."' AND";
    }
    elseif(get_user_class()==UC_POWER_HEAD){
        $department = "(department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')  AND";
        $left_join = "LEFT JOIN department ON department.id = users.department";
    }
    if(get_user_class() <= UC_ADMINISTRATOR){
        //$banned = "AND users.banned = '0' ";
    }
    $res=sql_query("SELECT users.id, users.name, users.department, department.name as d_name, department.parent FROM `users` LEFT JOIN department ON department.id = users.department  WHERE ".$department." `class` <= '".$CURUSER['class']."';")  or sqlerr(__FILE__, __LINE__);

    while ($row = mysql_fetch_array($res)){
        $data_user[]=$row;
    }

    $REL_TPL->assignByRef('data_user',$data_user);
    $REL_TPL->output("manager","statistics");
    ?>
