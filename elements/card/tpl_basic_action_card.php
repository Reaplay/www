<?php

    /*
    формируем список дополнительных опций, таких как отделение или права опций.
    если мы редактируем, то делаем доп. запросы в базу для проверки корректности запроса
    */

    if ($_GET['action']=="edit") {
        // проверям ID на корретность
        if(!is_valid_id($_GET['id'])){
            stderr("Ошибка","Не хорошо так делать","no");		//запись в лог
            write_log("Попытка изменения поступаемого ID","edit_user");
        }

        if(get_user_class()<UC_POWER_HEAD){
            $department = "`department` = '".$CURUSER['department']."' AND";
        }
        elseif(get_user_class()==UC_POWER_HEAD){
            $department = "(department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."') AND";
        }
        $res=sql_query("SELECT
card_client.*, department.id as d_id, department.name as d_name, department.parent
FROM `card_client`
LEFT JOIN department ON department.id = card_client.department
WHERE ".$department." card_client.id='".$_GET['id']."';")  or sqlerr(__FILE__, __LINE__);
        if(mysql_num_rows($res) == 0){
            stderr("Ошибка","Карта не найдена или у вас нет доступа","no");
        }

        $data_card = mysql_fetch_array($res);
    }
    // если выше рукля, то можно выбрать отделение

    // если рукль или выше, то можно сменить менеджера (и соответственно с ним меняется привязка к отделению)
    if(get_user_class() >= UC_HEAD){
        if(get_user_class() == UC_HEAD){
            $dep = "WHERE department = ".$CURUSER['department'];
        }
        elseif(get_user_class() == UC_POWER_HEAD){
            $dep = "WHERE department.parent = ".$CURUSER['department'];
        }
        $res=sql_query("SELECT users.id,users.name, department.name as d_name, department.parent FROM  `users` LEFT JOIN department ON department.id = users.department ".$dep.";")  or sqlerr(__FILE__, __LINE__);

        //формируем к какому отделению можно прикрепить пользователя
        while ($row = mysql_fetch_array($res)) {
            $select = "";
            if ($row['id'] == $data_card['id_manager']){
                $select = "selected = \"selected\"";
            }
            $manager .= " <option ".$select." value = ".$row['id'].">".$row['name']." (".$row['d_name'].")</option>";
        }
    }

    $card_res=sql_query("SELECT * FROM  `card_cobrand` WHERE disable = 0;")  or sqlerr(__FILE__, __LINE__);

    //формируем к какому отделению можно прикрепить пользователя
    while ($row = mysql_fetch_array($card_res)) {
        $select = "";
        if ($row['id'] == $data_card['id_cobrand']){
            $select = "selected = \"selected\"";
        }
        $card .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
    }



    $REL_TPL->assignByRef('manager',$manager);
    $REL_TPL->assignByRef('card',$card);
    $REL_TPL->assignByRef('data_card',$data_card);
    $REL_TPL->output("tpl_basic_action_card","card");

?>