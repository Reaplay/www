<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 11.04.2016
     * Time: 22:22
     */

    if (! is_valid_id ( $_GET ["id"] ))
        stderr ("Ошибка", "Не верный ID");
    $pm_id = $_GET ['id'];

    // Delete message
    $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
    if (! $res) {
        stderr ("Ошибка", "Сообщения с таким ID не существует.","no"  );
    }
    if (mysql_num_rows ( $res ) == 0) {
        stderr ("Ошибка", "Сообщения с таким ID не существует.","no"  );
    }
    $message = mysql_fetch_assoc ( $res );
    if ($message ['receiver'] == $CURUSER ['id'] && ! $message ['saved']) {
        $res2 = sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
    } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] == PM_DELETED) {
        $res2 = sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
    } elseif ($message ['receiver'] == $CURUSER ['id'] && $message ['saved']) {
        $res2 = sql_query ( "UPDATE messages SET location=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
    } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] != PM_DELETED) {
        $res2 = sql_query ( "UPDATE messages SET saved=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
    }
    if (! $res2) {
        stderr ("Ошибка", "Невозможно удалить сообщение.","no" );
    }
    if (mysql_affected_rows () == 0) {
        stderr ("Ошибка", "Невозможно удалить сообщение.","no"  );
    } else {
        safe_redirect($REL_SEO->make_link('message','action','viewmailbox','id',$message['location']));

    }