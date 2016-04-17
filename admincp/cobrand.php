<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 14.04.2016
     * Time: 20:12
     */
    

if($_GET['id'] and !is_valid_id($_GET['id'])){
    stderr("Ошибка","Ошибка ID продукта");		//запись в лог
}

$REL_TPL->stdhead('Кобрендовые карты банка');

if($_GET['action']=="disable"){
    sql_query("UPDATE `card_cobrand` SET `disable` = '1', `edited` = '".time()."' WHERE `id` =".$_GET['id'].";") or sqlerr(__FILE__, __LINE__);
    $REL_TPL->stdmsg('Выполнено','Продукт отключен');

}
if($_GET['action']=="enable"){
    sql_query("UPDATE `card_cobrand` SET `disable` = '0', `edited` = '".time()."' WHERE `id` =".$_GET['id'].";") or sqlerr(__FILE__, __LINE__);
    $REL_TPL->stdmsg('Выполнено','Продукт включен');

}
if($_POST['action']=="edit"){
    sql_query("UPDATE `card_cobrand` SET `name` = '".$_POST['name']."', `edited` = '".time()."', `type` = '".$_POST['type_card']."' WHERE `id` =".$_GET['id'].";") or sqlerr(__FILE__, __LINE__);
    $REL_TPL->stdmsg('Выполнено','Название изменено');
}
if($_POST['action']=="add"){
    sql_query("INSERT INTO `card_cobrand` (`name`, `added`, `type`) VALUES ('".$_POST['name']."', '".time()."', '".$_POST['type_card']."' );") or sqlerr(__FILE__, __LINE__);
    $REL_TPL->stdmsg('Выполнено','Название изменено');
}
if($_GET['action']=="edit"){
    $res=sql_query("SELECT * FROM `card_cobrand` WHERE id = '".$_GET['id']."'")  or sqlerr(__FILE__, __LINE__);
    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Такой продукт отсутствует в базе","no");
    }
    $data_card_cobrand = mysql_fetch_array($res);
    $action	="edit";

    $REL_TPL->assignByRef("action",$action);
    $REL_TPL->assignByRef("id",$_GET['id']);
    $REL_TPL->assignByRef('data_card_cobrand',$data_card_cobrand);
    $REL_TPL->output("card_cobrand_add_edit","admincp");

}
elseif($_GET['action']=="add"){

    $action	="add";
    $REL_TPL->assignByRef("action",$action);
    $REL_TPL->output("card_cobrand_add_edit","admincp");
}
else {
    $res=sql_query("SELECT * FROM `card_cobrand`;")  or sqlerr(__FILE__, __LINE__);
    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Карты в базе не обнаружены. <a href='action_admin.php?module=cobrand&action=add'>Добавить</a>","no");
    }
    $i=0;
    while ($row = mysql_fetch_array($res)){
        $data_card_cobrand[]=$row;
        //костыль для красивого времени
        $data_card_cobrand[$i]['added']=mkprettytime($row['added']);
        if ($data_card_cobrand[$i]['edited'] == '0')
            $data_card_cobrand[$i]['edited'] = "Не изменялось";
        else
            $data_card_cobrand[$i]['edited']=mkprettytime($row['edited']);

        $i++;
    }
    //print_r ($data_card_cobrand);
    ////print $data_card_cobrand['0']['']['edited'];
    //die();

    $REL_TPL->assignByRef('data_card_cobrand',$data_card_cobrand);
    $REL_TPL->output("card_cobrand_index","admincp");
}
$REL_TPL->stdfoot();
?>
