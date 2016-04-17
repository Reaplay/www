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
        $department = "AND card_client.department = '".$CURUSER['department']."' ";
    }
    elseif(get_user_class()==UC_POWER_HEAD){
        $department = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
        $left_join = "LEFT JOIN department ON department.id = card_client.department";
    }
    elseif(get_user_class() <= UC_ADMINISTRATOR){
        //$banned = "AND users.banned = '0' ";
    }
    if($_GET['type_card'] AND is_valid_id($_GET['type_card'])){
        $flt_card = "AND card_client.id_cobrand = '".$_GET['type_card']."'";
        $add_link .= "&type_card=".$_GET['type_card'];
    }
    if($_GET['manager'] AND is_valid_id($_GET['manager'])){
        $flt_manager = "AND card_client.id_manager = '".$_GET['manager']."'";
        $add_link .= "&manager=".$_GET['manager'];
    }
    if($_GET['department'] AND is_valid_id($_GET['department'])){
        $flt_department = "AND card_client.department = '".$_GET['department']."'";
        $add_link .= "&department=".$_GET['department'];
    }
    if($_GET['only_my']){
        $only_my = "AND card_client.id_manager = '".$CURUSER['id']."'";
        $add_link .= "&only_my=1";
    }
    $res=sql_query("SELECT card_client.*, department.name as d_name, department.parent, users.name as manager,(SELECT `name` FROM card_cobrand WHERE id = card_client.id_cobrand) as name_card FROM `card_client` LEFT JOIN department ON department.id = card_client.department LEFT JOIN users ON users.id = card_client.id_manager WHERE card_client.status = 0  ".$department." ".$only_my." ".$flt_manager." ".$flt_department." $flt_card ".$limit.";")  or sqlerr(__FILE__, __LINE__);

    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Карты не найдены","no");
    }
    $i=0;
    while ($row = mysql_fetch_array($res)){
        $data_card[]=$row;
        $data_card[$i]['next_call']=mkprettytime($row['next_call'],false);
        $i++;
    }

    //формируем список менеджеров для фильтра
    $get_mgr = get_manager(get_user_class(),$CURUSER['department']);
    while ($mgr = mysql_fetch_array($get_mgr)) {
        $select = "";
        if ($mgr['id'] == $_GET['manager']){
            $select = "selected = \"selected\"";
        }
        $list_manager .= " <option ".$select." value = ".$mgr['id'].">".$mgr['name']."</option>";
    }
//
    $get_card = sql_query("SELECT `id`, `name` FROM card_cobrand WHERE disable = '0'")  or sqlerr(__FILE__, __LINE__);

    while ($card = mysql_fetch_array($get_card)) {
        $select = "";
        if ($card['id'] == $_GET['type_card']){
            $select = "selected = \"selected\"";
        }
        $list_card .= " <option ".$select." value = ".$card['id'].">".$card['name']."</option>";
    }

    // спиcок отделений дял фильтра
    $list_department = get_department(get_user_class(),$CURUSER['department'],$_GET['department']);
    //необходима оптимизация
    // узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
    $res = sql_query("SELECT SUM(1) FROM card_client $left_join WHERE card_client.status = 0 ".$department." ".$only_my." ".$flt_manager." ".$flt_department." $flt_card;") or sqlerr(__FILE__,__LINE__);
    $row = mysql_fetch_array($res);
    //всего записей
    $count = $row[0];
    //всего страниц
    $max_page = ceil($count / $cpp);
    //print $cpp;




    $REL_TPL->assignByRef('data_card',$data_card);
    $REL_TPL->assignByRef('list_manager',$list_manager);
    $REL_TPL->assignByRef('list_card',$list_card);
    $REL_TPL->assignByRef('list_department',$list_department);
    $REL_TPL->assignByRef('cpp',$cpp);
    $REL_TPL->assignByRef('page',$page);
    $REL_TPL->assignByRef('add_link',$add_link);
    $REL_TPL->assignByRef('max_page',$max_page);

    $REL_TPL->output("index","card");



    ?>
