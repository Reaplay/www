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
   /* if(get_user_class()<=UC_HEAD){
        $department = "AND card_client.department = '".$CURUSER['department']."' ";
    }
    elseif(get_user_class()==UC_POWER_HEAD){
        $department = "AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
        $left_join .= "LEFT JOIN department ON department.id = card_client.department";
    }
    elseif(get_user_class() <= UC_ADMINISTRATOR){
        //$banned = "AND users.banned = '0' ";
    }/*
    // фильтруем по типу карты
    if($_GET['type_card'] AND is_valid_id($_GET['type_card'])){
        $flt_card = "AND card_client.id_cobrand = '".$_GET['type_card']."'";
        $add_link .= "&type_card=".$_GET['type_card'];
    }
    // фильтр по менеджеру
    if($_GET['manager'] AND is_valid_id($_GET['manager'])){
        $flt_manager = "AND card_client.manager = '".$_GET['manager']."'";
        $add_link .= "&manager=".$_GET['manager'];
    }
    //фильтр по отделению
    if($_GET['department'] AND is_valid_id($_GET['department']) AND get_user_class() >=UC_POWER_HEAD){
        $flt_department = "AND card_client.department = '".$_GET['department']."'";
        $add_link .= "&department=".$_GET['department'];
    }
    // фильтр по самому себе
    if($_GET['only_my']){
        $only_my = "AND card_client.manager = '".$CURUSER['id']."'";
        $add_link .= "&only_my=1";
    }
    // фильтр по статусу выдачи
    if($_GET['status_action']){
        // получаем текущую дату
        $now_date = strtotime(date("d.m.Y"));
        $add_link .= "&status_action=".$_GET['status_action'];
       // $left_join .= "LEFT JOIN card_callback ON card_callback.id = card_client.id_callback";

            if($_GET['status_action']=='miss'){
                $card_callback .="AND card_client.next_call < '".$now_date."' ";
                $card_callback .= "AND card_client.next_call != '0' ";
            }
            elseif($_GET['status_action']=='next'){
                $card_callback .="AND card_client.next_call > '".$now_date."' ";
            }
            elseif($_GET['status_action']=='today'){
                $card_callback .="AND card_client.next_call = '".$now_date."' ";
            }
           // $add_link .= "&status_action=".$_GET['status_action'];
            //$card_callback .= "AND card_callback.status = '0' ";
    }

*/
    $filter = filter_index($_GET,"card_client");

    // сортировка
    $sort = sort_index($_GET,"card_client");
  /*  if($_GET['name']){
        if($_GET['name']=='asc'){
            $sort['name']='asc';
        }
        elseif($_GET['name']=='desc'){
            $sort['name']='desc';
        }
        $add_sort .= "&name=".$sort['name'];
        $sort['query'] = "ORDER BY card_client.name ".$sort['name']."";
    }
    elseif($_GET['added']){
        if($_GET['added']=='asc'){
            $sort['added']='asc';
        }
        elseif($_GET['added']=='desc'){
            $sort['added']='desc';
        }
        $add_sort .= "&added=".$sort['added'];
        $sort['query'] = "ORDER BY card_client.name ".$sort['added']."";

    }
    elseif($_GET['next_call']){
        if($_GET['next_call']=='asc'){
            $sort['next_call']='asc';
        }
        elseif($_GET['next_call']=='desc'){
            $sort['next_call']='desc';
        }
        $add_sort .= "&next_call=".$sort['next_call'];
        $sort['query'] = "ORDER BY card_client.name ".$sort['next_call']."";

    }*/


    // поиск
    if($_GET['s']){
        $res = sql_query ("SELECT card_client.*, department.name as d_name, department.parent, users.name as manager, card_callback.comment as card_comment, (SELECT `name` FROM card_cobrand WHERE id = card_client.id_cobrand) as name_card, (SELECT `name` FROM users WHERE id = card_callback.manager) as comment_manager FROM `card_client` LEFT JOIN department ON department.id = card_client.department LEFT JOIN users ON users.id = card_client.manager LEFT JOIN card_callback ON card_callback.id = card_client.id_callback  WHERE card_client.delete = '0' AND card_client.status = '0' AND  card_client.name LIKE '%".$_GET['s']."%' OR card_client.mobile LIKE '%".$_GET['s']."%' OR card_client.equid LIKE '%".$_GET['s']."%' ".$sort['query']." ".$limit.";") or sqlerr (__FILE__, __LINE__);
    }
    else {

        $res = sql_query ("SELECT card_client.*, department.name as d_name, department.parent, users.name as manager, card_callback.comment as card_comment, (SELECT `name` FROM card_cobrand WHERE id = card_client.id_cobrand) as name_card, (SELECT `name` FROM users WHERE id = card_callback.manager) as comment_manager FROM `card_client` LEFT JOIN department ON department.id = card_client.department LEFT JOIN users ON users.id = card_client.manager LEFT JOIN card_callback ON card_callback.id = card_client.id_callback WHERE card_client.delete = '0' AND card_client.status = '0'  ".$filter['add_where']." ".$sort['query']." " . $limit . ";") or sqlerr (__FILE__, __LINE__);
    }
    if(mysql_num_rows($res) == 0){
        stderr("Ошибка","Карты не найдены","no");
    }
    $i=0;
    while ($row = mysql_fetch_array($res)){
        $data_card[]=$row;
        $data_card[$i]['comment_manager'] = preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $row['comment_manager']);
	//$data_card[$i]['comment_manager'] = preg_replace('#(.*)\s+(.).*\s+(.).*#usi', '$1 $2.$3.', $row['comment_manager']);
        $data_card[$i]['added']=mkprettytime($row['added'],false);
       	if($row['next_call']){
			$data_card[$i]['next_call']=mkprettytime($row['next_call'],false);
		}
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
    if($_GET['s']){
        $res = sql_query("SELECT SUM(1) FROM card_client LEFT JOIN department ON department.id = card_client.department WHERE card_client.delete = '0' AND card_client.status = '0' AND  card_client.name LIKE '%".$_GET['s']."%' OR card_client.mobile LIKE '%".$_GET['s']."%' OR card_client.equid LIKE '%".$_GET['s']."%'") or sqlerr(__FILE__,__LINE__);

    }
    else{
        $res = sql_query("SELECT SUM(1) FROM card_client LEFT JOIN department ON department.id = card_client.department WHERE card_client.delete = '0' AND card_client.status = '0' ".$filter['add_where']." ;") or sqlerr(__FILE__,__LINE__);
    }
    $row = mysql_fetch_array($res);
    //всего записей
    $count = $row[0];
    //всего страниц
    $max_page = ceil($count / $cpp);
    //print $cpp;



    //данные по картам
    $REL_TPL->assignByRef('data_card',$data_card);

    //спислк для фильтра
    $REL_TPL->assignByRef('list_manager',$list_manager);
    $REL_TPL->assignByRef('list_card',$list_card);
    $REL_TPL->assignByRef('list_department',$list_department);

    // формируем переход между страниц
    $REL_TPL->assignByRef('cpp',$cpp);
    $REL_TPL->assignByRef('page',$page);
    $REL_TPL->assignByRef('max_page',$max_page);
    //доп. данные для перехода сортировки и фильтров
    $REL_TPL->assignByRef('add_link',$filter['add_link']);
    $REL_TPL->assignByRef('add_sort',$sort['link']);
    $REL_TPL->assignByRef('sort',$sort);

    //счетчик записей
    $REL_TPL->assignByRef('count',$count);

    $REL_TPL->output("index","card");



    ?>
