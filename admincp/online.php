<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 13.05.2016
     * Time: 22:46
     */

    $secs = 1 * 300;//Время выборки (5 последних минут)
    $dt = time() - $secs;

    $spy_res = sql_query("SELECT sid,uid, username, sessions.class, sessions.ip, url, department.name as department FROM sessions LEFT JOIN users ON users.id = sessions.uid LEFT JOIN department ON department.id = users.department ORDER BY uid ASC")  or sqlerr(__FILE__,__LINE__);

    $i=0;
    while($spy_row = mysql_fetch_array($spy_res)) {
        $data_session[$i]=$spy_row;
        if($CURUSER['id'] == $spy_row['uid']){
            $data_session[$i]['username'] = $data_session[$i]['username']." (Вы здесь)";
        }
        $data_session[$i]['class'] = get_user_class_name($spy_row['class']);
        $data_session[$i]['url'] = basename($spy_row['url']);
        $i++;
    }




    $REL_TPL->assignByRef('data_session',$data_session);
    $REL_TPL->stdhead('Кто онлайн');
    $REL_TPL->output("online","admincp");
    $REL_TPL->stdfoot();