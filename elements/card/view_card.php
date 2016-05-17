<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 16.04.2016
     * Time: 22:56
     */



    if(!is_valid_id($_GET['id'])){
        stderr("Ошибка","Некоректный ID клиента","no");		//запись в лог
    }

    //если рукль, то те, кто к ним привязан
        if(get_user_class() <= UC_HEAD){
            $add_query = "AND client.department ='".$CURUSER['department']."'";
        }
        elseif(get_user_class() == UC_POWER_HEAD){
            $add_query = "AND (department.parent ='".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
        }
    //а выше рукля - всех могут

    $res=sql_query("
SELECT card_client.*, department.name as d_name, department.parent, users.name as u_manager,
(SELECT `name` FROM card_cobrand WHERE id = card_client.id_cobrand) as name_card
FROM `card_client`
LEFT JOIN department ON department.id = card_client.department
LEFT JOIN users ON users.id = card_client.manager
WHERE card_client.delete = '0' AND card_client.id = '".$_GET['id']."'  ".$department." ;
")  or sqlerr(__FILE__, __LINE__);

    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
    }
    $data_card = mysql_fetch_array($res);
    $data_card['next_call'] = mkprettytime($data_card['next_call'],false);
    $data_card['added'] = mkprettytime($data_card['added'],false);
    $res=sql_query("
SELECT card_callback.*, users.name as u_name,result_call.text as rc_name
FROM `card_callback`
LEFT JOIN users ON users.id = card_callback.manager
LEFT JOIN result_call ON result_call.id = card_callback.id_result
WHERE  card_callback.id_client = '".$_GET['id']."'
ORDER BY `added` DESC
LIMIT 0,15
;")
    or sqlerr(__FILE__, __LINE__);
    $i=0;
    while ($row = mysql_fetch_array($res)){
        $data_callback[$i]=$row;
        $data_callback[$i]['added']=date("d-m-Y",$row['added']);
        if ($row['next_call']){
            $data_callback[$i]['next_call']=date("d-m-Y",$row['next_call']);
        }
        else
            $data_callback[$i]['next_call']="N/A";

        $i++;
    }

// смена манаргера
    if(get_user_class() >= UC_POWER_USER){
        if(get_user_class() <= UC_HEAD){
            $dep = "WHERE department = ".$CURUSER['department'];
        }
        elseif(get_user_class() == UC_POWER_HEAD){
            $dep = "WHERE (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
        }
        $res=sql_query("SELECT users.id,users.name, department.name as d_name FROM  `users` LEFT JOIN department ON department.id = users.department ".$dep.";")  or sqlerr(__FILE__, __LINE__);

        //формируем к какому отделению можно прикрепить пользователя
        while ($row = mysql_fetch_array($res)) {
            $select = "";
            if ($row['id'] == $data_client['u_id']){
                $select = "selected = \"selected\"";
            }
            $data_manager .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
        }
    }



        $REL_TPL->assignByRef('data_card',$data_card);
        $REL_TPL->assignByRef('data_callback',$data_callback);
        $REL_TPL->assignByRef('data_manager',$data_manager);
        //$REL_TPL->assignByRef('data_mgr',$mgr);

         $REL_TPL->output("view_card","card");



        //это не надо
    //	$template = "edit_user_result";
    //die();




?>
