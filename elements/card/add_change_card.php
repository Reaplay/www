<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 14.04.2016
     * Time: 20:49
     */


/*
сначала проверяем данные на корректность
потом проверяем если у нас изменение
внесение измененеий в базу
*/
// если идет изменение, то сразу запрашиваем некоторые данные
if($_POST['id']){
    if(!is_valid_id($_POST['id'])){
        stderr("Ошибка","Некорретный ID","no");
       // write_log("Попытка изменения поступаемого ID при добавлении изменений (специально)","edit_user");
    }
    $id = $_POST['id'];
    $res = sql_query("SELECT next_call FROM  `card_client` WHERE `id` = '".$id."';")  or sqlerr(__FILE__, __LINE__);
    $data_client = mysql_fetch_array($res);
    if(!$data_client){
        stderr("Ошибка","Такая карта в базе не обнаружена","no");
    }

}

//общее

//проверяем фио
    $name = mb_convert_case(trim($_POST["name"]),MB_CASE_TITLE);
//длину
if (strlen($name)<5)
    stderr("Ошибка","ФИО должно быть не короче 5 символов","no");

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

    //equid
    //коммент
    $equid = $_POST['equid'];
    $comment = ((string)$_POST["comment"]);
    //манагер
    if(get_user_class()<=UC_POWER_USER){
        $manager = $CURUSER['id'];
        $department = $CURUSER['department'];
    }
// если рукль, тогда отделение уже определено
    elseif(get_user_class() >= UC_HEAD){
        // если мы редактируем и текущее отделение и привязка не совпадают...
        if($id AND ($data_client['department'] != $CURUSER['department']) AND get_user_class() == UC_HEAD) {
            stderr("Ошибка","Ошибка проверки отделения (class dep)","no");
            write_log("Не совпадание ID отделения клиента и ID отделения менеджера (специально, рук-ль)","edit_client");
        }
        // если какой-то менеджер прописан
        if ($_POST['manager'] != "---"){

            // проверяем на валидность
            if (!is_valid_id($_POST['manager'])){
                stderr("Ошибка","Не выбран менеджер (class mgr)","no");
                write_log("Попытка изменения поступаемого ID менеджера при добавлении изменений (специально, рук-ль)","edit_client");
            }

            $manager = $_POST['manager'];

            if(get_user_class() == UC_HEAD){
                $addition_sql = "AND `department` = '".$CURUSER['department']."'";

            }
            elseif(get_user_class() == UC_POWER_HEAD){
                $add_select = ", department.parent";
                $left_join = "LEFT JOIN department ON department.id = users.department";
                $addition_sql = "AND (department.parent = ".$CURUSER['department']." OR department.id =".$CURUSER['department'].")";
            }


            //проверяем что манагер из отделения рукля
            $res=sql_query("SELECT users.department,users.id $add_select FROM  `users` $left_join WHERE users.id = '".$manager."' ".$addition_sql." ;")  or sqlerr(__FILE__, __LINE__);
            if(mysql_num_rows($res) == 0){
                stderr("Ошибка","Выбранный менеджер не привязан к вашему отделению или не существует. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
            }
            $row = mysql_fetch_array($res);
            $department = $row['department'];

        }
        else {
            stderr("Ошибка","Вы не выбрали менеджера. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
        }

    }
    //телефон
    $mobile = check_mobile($_POST['mobile']);
    	if (strlen($mobile) < 9){
		$mobile = 'NULL';
	}
   /* if (!check_unic($mobile,'client','mobile',$id)){
        stderr("Ошибка","В базе уже есть клиент с таким номером. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
    }*/
    //тип карты
    $id_card = $_POST['card'];
    $res = sql_query("SELECT id FROM `card_cobrand` WHERE `id` = '".$id_card."';")  or sqlerr(__FILE__, __LINE__);
    $data_card = mysql_fetch_array($res);
    if(!$data_card){
        stderr("Ошибка","Такая карта в базе не обнаружена","no");
    }



if (!$id){
// добавляем в базу
        $ret = sql_query("
INSERT INTO `card_client`(
`name`,`id_manager`, `department`, `equid`,`added`,`comment`,`next_call`,`mobile`,`id_cobrand`,`id_callback`)
VALUES (".implode(",", array_map("sqlesc", array(
$name, $manager, $department, $equid, time(), $comment, $next_call, $mobile, $id_card, $id_callback
))).");")  or sqlerr(__FILE__, __LINE__);
    // получаем ид
    $id_client = mysql_insert_id();
    // добавляем как колбек
    sql_query("
INSERT INTO `card_callback`(
`id_client`,`id_manager`, `added`, `next_call`,`comment`)
VALUES (".implode(",", array_map("sqlesc", array(
            $id_client, $manager, time(), $next_call,"Карта добавлена"
        ))).");")  or sqlerr(__FILE__, __LINE__);
    // получаем ид коллбека
    $id_callback = mysql_insert_id();
    //обновляем запись
    sql_query("
UPDATE `card_client` SET `id_callback` = '".$id_callback."' WHERE `id` ='".$id_client."';")  or sqlerr(__FILE__, __LINE__);
}
else {

    sql_query("
UPDATE `card_client` SET `name` = '".$name."', `id_manager` = '".$manager."', `department` = '".$department."', `equid` = '".$equid."', `comment` = '".$comment."' `mobile` = ".$mobile.", `id_card` = '".$id_card."' WHERE `id` ='".$id."';")  or sqlerr(__FILE__, __LINE__);
}
stdmsg("Выполнено.","Ошибок не обнаружено");
	safe_redirect("card.php",2);
?>
