<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 20.04.2016
     * Time: 21:38
     */

if(get_user_class() < UC_POWER_USER){
    stderr ("Ошибка", "В доступе отказано", "no");
}
     if (!is_valid_id ($_GET['id'])) {
        stderr ("Ошибка", "Ошибка ID клиента", "no");
        write_log ("Попытка изменения поступаемого ID при добавлении изменений (специально)", "edit_client");
     }
    $id = $_GET['id'];

    if(get_user_class() <= UC_HEAD){
        $addition = "AND client.department = '".$CURUSER['department']."'";
    }
    elseif(get_user_class() == UC_POWER_HEAD){
        $addition = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
    }

    $res = sql_query ("SELECT client.manager,client.department FROM `client`LEFT JOIN department ON department.id = client.department WHERE client.delete = '0' AND client.id = '" . $id . "' ".$addition.";") or sqlerr (__FILE__, __LINE__);
    $data_client = mysql_fetch_array ($res);
    if (!$data_client) {
        stderr ("Ошибка", "Такой клиент в базе не обнаружен или отказано в доступе", "no");
    }
    sql_query("UPDATE `client` SET `delete` = '1'  WHERE `id` ='".$id."';")  or sqlerr(__FILE__, __LINE__);


    //safe_redirect("client.php");
    header('Location: '.$REL_CONFIG['defaultbaseurl'].'/client.php');
    die();

