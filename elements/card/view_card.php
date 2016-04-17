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
LEFT JOIN users ON users.id = card_client.id_manager
WHERE card_client.id = '".$_GET['id']."'  ".$department." ;
")  or sqlerr(__FILE__, __LINE__);

    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
    }
    $data_card = mysql_fetch_array($res);

    $res=sql_query("
SELECT card_callback.*, users.name as u_name
FROM `card_callback`
LEFT JOIN users ON users.id = card_callback.id_manager

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




        $REL_TPL->assignByRef('data_card',$data_card);
        $REL_TPL->assignByRef('data_callback',$data_callback);
        //$REL_TPL->assignByRef('data_mgr',$mgr);

         $REL_TPL->output("view_card","card");



        //это не надо
    //	$template = "edit_user_result";
    //die();




?>
