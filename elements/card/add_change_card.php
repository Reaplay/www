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
        stderr("Ошибка","Такой клиент в базе не обнаружен","no");
    }

}

//общее

//проверяем фио
$name = trim($_POST["name"]);
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
                $addition_sql = "AND department.parent = ".$CURUSER['department'];
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
   /* if (!check_unic($mobile,'client','mobile',$id)){
        stderr("Ошибка","В базе уже есть клиент с таким номером. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
    }*/
    //тип карты
    $id_card = $_POST['card'];
    $res = sql_query("SELECT id FROM `card_cobrand` WHERE `id` = '".$id_card."';")  or sqlerr(__FILE__, __LINE__);
    $data_card = mysql_fetch_array($res);
    if(!$data_card){
        stderr("Ошибка","Такой клиент в базе не обнаружен","no");
    }

if (!$id){
    $ret = sql_query("
INSERT INTO `card_client`(
`name`,`id_manager`, `department`, `equid`,`added`,`comment`,`next_call`,`mobile`,`id_cobrand`)
VALUES (".implode(",", array_map("sqlesc", array(
$name, $manager, $department, $equid, time(), $comment, $next_call, $mobile, $id_card
))).");")  or sqlerr(__FILE__, __LINE__);


}/*
else {

    sql_query("
UPDATE `users` SET `department` = '".$department."', `class` =  '".$class."', `name` = '".$name."', `add_user` = '".$add_user."', `add_client` = '".$add_client."', `use_card`='".$use_card."', ".$passhash." `last_update` = '".time()."' WHERE `id` ='".$id."';")  or sqlerr(__FILE__, __LINE__);
}*/
stdmsg("Выполнено.","Ошибок не обнаружено");
	safe_redirect("card.php",2);
?>
