<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 12.04.2016
     * Time: 23:39
     */
    if (isset ( $_POST ["id"] ) && ! is_valid_id ( $_POST ["id"] ))
        stderr ( "Ошибка", "Не верный  ID","no" );
    $pm_id = $_POST ['id'];

    $pm_box = ( int ) $_POST ['box'];
    if (! is_array ( $_POST ['messages'] ))
        stderr ( "Ошибка", "Не верный  ID","no" );
    $pm_messages = $_POST ['messages'];
   /* if ($_POST ['move']) {
        if ($pm_id) {
            // Move a single message
            @sql_query ( "UPDATE messages SET location=" . sqlesc ( $pm_box ) . ", saved = 1 WHERE id=" . sqlesc ( $pm_id ) . " AND receiver=" . $CURUSER ['id'] . " LIMIT 1" );
        } else {
            // Move multiple messages
            @sql_query ( "UPDATE messages SET location=" . sqlesc ( $pm_box ) . ", saved = 1 WHERE id IN (" . implode ( ", ", array_map ( "sqlesc", array_map ( "intval", $pm_messages ) ) ) . ') AND receiver=' . $CURUSER ['id'] );
        }
        // Check if messages were moved
        if (@mysql_affected_rows () == 0) {
            stderr ( "Ошибка", "Не возможно переместить сообщения!","no" );
        }
        safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
       // exit ();
    }*/
    if ($_POST ['delete']) {
        if ($pm_id) {
            // Delete a single message
            $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
            $message = mysql_fetch_assoc ( $res );
            if ($message ['receiver'] == $CURUSER ['id'] && ! $message ['saved']) {
                sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
            } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] == PM_DELETED) {
                sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
            } elseif ($message ['receiver'] == $CURUSER ['id'] && $message ['saved']) {
                sql_query ( "UPDATE messages SET location=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
            } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] != PM_DELETED) {
                sql_query ( "UPDATE messages SET saved=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
            }
        }
        else {
            // Delete multiple messages
            if (is_array ( $pm_messages ))
                foreach ( $pm_messages as $id ) {
                    $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
                    $message = mysql_fetch_assoc ( $res );
                    if ($message ['receiver'] == $CURUSER ['id'] && ! $message ['saved']) {
                        sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                    } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] == PM_DELETED) {
                        sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                    } elseif ($message ['receiver'] == $CURUSER ['id'] && $message ['saved']) {
                        sql_query ( "UPDATE messages SET location=0 WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                    } elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] != PM_DELETED) {
                        sql_query ( "UPDATE messages SET saved=0 WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                    }
                }
        }
        // Check if messages were moved
        if (@mysql_affected_rows () == 0) {
            stderr ( "Ошибка", "Сообщение не может быть удалено!","no" );
        } else {
            safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
            //exit ();
        }
    }
    elseif ($_POST ["markread"]) {
        //помечаем одно сообщение
        if ($pm_id) {
            sql_query ( "UPDATE messages SET unread=0 WHERE id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
        } //помечаем множество сообщений
        else {
            if (is_array ( $pm_messages ))
                foreach ( $pm_messages as $id ) {
                    $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
                    $message = mysql_fetch_assoc ( $res );
                    sql_query ( "UPDATE messages SET unread=0 WHERE id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                }
        }
        // Проверяем, были ли помечены сообщения

        safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
       // exit ();

    }
    /*elseif ($_POST ["archive"]) {
        //архивируем одно сообщение
        if ($pm_id) {
            sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},1,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,1) WHERE id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
        } //архивируем множество сообщений
        else {
            if (is_array ( $pm_messages ))
                foreach ( $pm_messages as $id ) {
                    $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
                    $message = mysql_fetch_assoc ( $res );
                    sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},1,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,1) WHERE id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                }
        }

        safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box),1 );
        stdmsg("Успешно", "Сообщение(я) архивировано(ы)!");

    }
    elseif ($_POST ["unarchive"]) {
        //архивируем одно сообщение
        if ($pm_id) {
            sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},0,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,0) AND id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
        } //архивируем множество сообщений
        else {
            if (is_array ( $pm_messages ))
                foreach ( $pm_messages as $id ) {
                    $res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
                    $message = mysql_fetch_assoc ( $res );
                    sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},0,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,0) AND id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
                }
        }

        safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box),1 );
        stdmsg("Успешно", "Сообщение(я) разархивировано(ы)!");
    }*/
    else
        stderr ( "Ошибка", "Нет действия.","no" );