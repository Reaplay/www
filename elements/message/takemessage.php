<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 10.04.2016
     * Time: 21:44
     */
    $receiver = (int)$_POST ["receiver"];
    $origmsg = (int)$_POST ["origmsg"];
    $save = $_POST ["save"];
    $archive = $_POST ["archive"];
    $returnto = urlencode ( $_POST ["returnto"] );
    if (! is_valid_id ( $receiver ) || ($origmsg && ! is_valid_id ( $origmsg )))
        stderr ("Ошибка","Не верный ID","no");
    $msg = trim ( $_POST ["body"] );
    if (! $msg)
        stderr ("Ошибка", "Пожалуйста введите сообщение!","no" );
    $subject = trim ( $_POST ['subject'] );
    if (! $subject)
        stderr ("Ошибка", "Пожалуйста введите тему сообщения!","no" );


    $secs_system = $REL_CONFIG['pm_delete_sys_days']*86400; // Количество дней
    $dt_system = time() - $secs_system; // Сегодня минус количество дней
    $secs_all = $REL_CONFIG['pm_delete_user_days']*86400; // Количество дней
    $dt_all = time() - $secs_all; // Сегодня минус количество дней

    $pms = sql_query ( "SELECT (SELECT SUM(1) FROM messages WHERE location=1 AND receiver={$receiver} AND IF(archived_receiver=1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all))) + (SELECT SUM(1) FROM messages WHERE saved=1 AND sender={$receiver} AND IF(archived_receiver<>1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all)))") or sqlerr(__FILE__,__LINE__);
    $pms = (int)mysql_result ( $pms, 0 );
    if ($pms >= $REL_CONFIG ['pm_max'])
        stderr ("Ошибка", "Ящик личных сообщений получателя заполнен, вы не можете отправить ему сообщение." );

    if ($save) {
        $pms = sql_query ( "SELECT (SELECT SUM(1) FROM messages WHERE location=1 AND receiver={$CURUSER['id']} AND IF(archived_receiver=1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all))) + (SELECT SUM(1) FROM messages WHERE saved=1 AND sender={$CURUSER['id']} AND IF(archived_receiver<>1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all)))") or sqlerr(__FILE__,__LINE__);
        $pms = (int)mysql_result ( $pms, 0 );
        if ($pms >= $REL_CONFIG ['pm_max'])
            stderr ( "Невозможно сохранить сообщение", "Ваш ящик личных сообщений заполнен, максимальное кол-во {$REL_CONFIG['pm_max']}. Вы не можете отправить сообщение, вам необходимо очистить ящик личных сообщений" );
    }

    // Change
    $save = ($save) ? 1 : 0;
    $archive = ($archive) ? 1 : 0;
    // End of Change
    /*$res = sql_query ( "SELECT acceptpms, notifs, last_access AS la FROM users WHERE id=$receiver" ) or sqlerr ( __FILE__, __LINE__ );
    $user = mysql_fetch_assoc ( $res );
    if (! $user)
        stderr ("Ошибка", "Нет пользователя с таким ID $receiver.","no" );
    //Make sure recipient wants this message

    if (get_user_class () < UC_ADMINISTRATOR) {
        if ($user ["acceptpms"] == "no")
           stderr ( "Отклонено", "Этот пользователь не принимает сообщения.","no");
    }*/
    sql_query ( "INSERT INTO messages (poster, sender, receiver, added, msg, subject, saved, location, archived) VALUES(" . $CURUSER ["id"] . ", " . $CURUSER ["id"] . ",
	$receiver, '" . time () . "', " . sqlesc ( ($msg) ) . ", " . sqlesc ( $subject ) . ", " . sqlesc ( $save ) . ",  1, " . sqlesc ( $archive ) . ")" ) or sqlerr ( __FILE__, __LINE__ );
  /*  $sended_id = mysql_insert_id ();

    $username = $CURUSER ["username"];
  //  $usremail = $user ["email"];
    $body = "
	$username послал вам личное сообщение!

Пройдите по ссылке ниже, чтобы его прочитать.

".$REL_SEO->make_link('message','action','viewmessage','id',$sended_id)."


";

    // email notifs
    send_notifs('unread',$body,$receiver);
*/
    $delete = $_POST ["delete"];
    if ($origmsg) {
        if ($delete) {
            // Make sure receiver of $origmsg is current user
            $res = sql_query ( "SELECT * FROM messages WHERE id=$origmsg" ) or sqlerr ( __FILE__, __LINE__ );
            if (mysql_num_rows ( $res ) == 1) {
                $arr = mysql_fetch_assoc ( $res );
                if ($arr ["receiver"] != $CURUSER ["id"])
                    stderr ("Ошибка", "Вы пытаетесь удалить не свое сообщение!" );
                if (! $arr ["saved"])
                    sql_query ( "DELETE FROM messages WHERE id=$origmsg" ) or sqlerr ( __FILE__, __LINE__ );
                elseif ($arr ["saved"])
                    sql_query ( "UPDATE messages SET location = '0' WHERE id=$origmsg" ) or sqlerr ( __FILE__, __LINE__ );
            }
        }
        if (! $returnto)
            $returnto ="message.php";
    }
    if ($returnto) {
        safe_redirect($returnto);
        //stdmsg ( 'Успешно', "Сообщение отправлено");

    } else {
        stdmsg ( 'Успешно', "Сообщение отправлено");
        safe_redirect ('message.php',2);

    }
