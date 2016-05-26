<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 26.05.2016
     * Time: 23:19
     */
    require_once "include/connect.php";
    dbconn();
    loggedinorreturn();
    if(isset($_COOKIE['override_class'])){
        setcookie('override_class', '', 0x7fffffff, "/");
        setcookie('override_department', '', 0x7fffffff, "/");
        stderr("Выполнено","Ложные классы/отделения сброшены (если есть). Для смены на новые обновите страницу");

    }
    elseif(get_user_class() <UC_POWER_HEAD){
        stderr("Ошибка","У вас нет доступа к данной странице");
    }



    if ($_GET['action'] == 'editclass') {
        if ($_GET['class'] != "---") {
            $newclass = (int)$_GET['class'];
            if ($CURUSER['class'] < $newclass)
                stderr ("Ошибка", "Попытка смены класса отклонена, ваш класс слишком низок");
            setcookie ('override_class', $newclass, 0x7fffffff, "/");
        }
        if ($_GET['department'] != "---") {
            $newdepartment = (int)$_GET['department'];
            setcookie ('override_department', $newdepartment, 0x7fffffff, "/");
        }
    }

    $maxclass = get_user_class() - 1;
    for ($i = 0; $i <= $maxclass; ++$i)
        $data_class .=('<option value="'.$i.'">'.get_user_class_name($i).'</option>');

    $data_department = get_department(get_user_class(),$CURUSER['department'],$CURUSER['department']);

    $REL_TPL->stdhead("Смена класса и отделения");

    $REL_TPL->assignByRef('data_class',$data_class);
    $REL_TPL->assignByRef('data_department',$data_department);
    $REL_TPL->output("setclass","basic");
    $REL_TPL->stdfoot();
