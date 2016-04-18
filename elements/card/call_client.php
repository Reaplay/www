<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 16.04.2016
     * Time: 22:51
     */

    if(!is_valid_id($_GET['id']) AND !is_valid_id($_POST['id'])){
        stderr("Ошибка","Некорретный ID","no");
        // write_log("Попытка изменения поступаемого ID при добавлении изменений (специально)","edit_user");
    }
    if ($_POST['id'])
        $id_client=$_POST['id'];
    else
        $id_client = $_GET['id'];

    if(get_user_class() <= UC_HEAD){
        $add_query = "AND card_client.department ='".$CURUSER['department']."'";
    }
    elseif(get_user_class()==UC_POWER_HEAD){
        $add_query = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
    }

    $res = sql_query("SELECT card_client.id, department.parent, department.id as d_id FROM  `card_client` LEFT JOIN department ON department.id = card_client.department WHERE card_client.id = '".$id_client."' $add_query;")  or sqlerr(__FILE__, __LINE__);
    $data_client = mysql_fetch_array($res);
    if(!$data_client){
        stderr("Ошибка","Такая карта в базе не обнаружена","no");
    }


if($_POST){

    //дату звонка
    if ($_POST["next_call"]) {
        $call  = explode("/",$_POST["next_call"]);
        $next_call = mktime( 0,0,0,$call['1'],$call['0'],$call['2']);
        // проверка, на случай, если звонок на сегодняшний день.
        // нельзя добавить звоки в прошлое
        $arr_cur_time = explode("/",date("d/m/Y",time()));
        $cur_time = mktime( 0,0,0,$arr_cur_time['1'],$arr_cur_time['0'],$arr_cur_time['2']);
        if($next_call<$cur_time)
            stderr("Ошибка","Дата следующего контакта не может быть прошедшей","no");

    }
    $comment = ((string)$_POST["comment"]);

        $manager = $CURUSER['id'];
        $department = $CURUSER['department'];


    sql_query("INSERT INTO `card_callback`(`id_client`,`id_manager`, `added`, `next_call`,`comment`)
VALUES (".implode(",", array_map("sqlesc", array($id_client, $manager, time(), $next_call, $comment
        ))).");")  or sqlerr(__FILE__, __LINE__);
    // получаем ид коллбека
    $id_callback = mysql_insert_id();
    //обновляем запись
    sql_query("UPDATE `card_client` SET `id_callback` = '".$id_callback."',`next_call` = ".$next_call." WHERE `id` ='".$id_client."';")  or sqlerr(__FILE__, __LINE__);

    if($_POST['return_url']){
        stdmsg("Добавлено","Контакт с клиентом добавлен. Вы будете перенаправлены обратно на список карт. <br /> Если вам нужно попасть в профиль клиента, нажмите <a href=\"card.php?action=view&id=".$id_client."\">здесь</a>");
        safe_redirect($_POST['return_url'],2);
    }
    else {
        stdmsg("Добавлено","Контакт с клиентом добавлен. Вы будете перенаправлены на страницу клиента через пару секунд. <br /> Если этого не произошло, нажмите <a href=\"card.php?action=view&id=".$id_client."\">здесь</a>");
        safe_redirect ("card.php?action=view&id=" . $id_client, 2);
    }
}
    else {

        if(!stristr($_SERVER['HTTP_REFERER'],"action=")){
            $return_url = $_SERVER['HTTP_REFERER'];
        }



      /*  if(get_user_class() >= UC_HEAD){
            $get_mgr = get_manager(get_user_class(),$CURUSER['department']);

            while ($row = mysql_fetch_array($get_mgr)) {
                $select = "";
                if ($row['id'] == $data_card['id_manager']){
                    $select = "selected = \"selected\"";
                }
                $manager .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
            }
        }

        $REL_TPL->assignByRef('manager',$manager);*/
        $REL_TPL->assignByRef('id',$id_client);
        $REL_TPL->assignByRef('return_url',$return_url);
        $REL_TPL->output ("call_client", "card");
    }
    ?>
