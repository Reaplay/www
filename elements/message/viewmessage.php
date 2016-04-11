<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 10.04.2016
     * Time: 14:22
     */

    if (! is_valid_id ( $_GET ['id'] ))
        stderr ("Ошибка", "Некорректный идентификатор сообщения","no");
    $pm_id = $_GET ['id'];

    // Get the message
    if (get_user_class () != UC_ADMINISTRATOR) {
        $res = sql_query ( 'SELECT * FROM messages WHERE messages.id=' . sqlesc ( $pm_id ) . ' AND (messages.receiver=' . sqlesc ( $CURUSER ['id'] ) . ' OR (messages.sender=' . sqlesc ( $CURUSER ['id'] ) . ' AND messages.saved=1)) LIMIT 1' ) or sqlerr ( __FILE__, __LINE__ );
        if (mysql_num_rows ( $res ) == 0) {
            stderr ( "Ошибка", "Такого сообщения не существует.","no");
        }

    } else {
        $res = sql_query ( 'SELECT * FROM messages WHERE messages.id=' . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
        if (mysql_num_rows ( $res ) == 0) {
            stderr ( "Ошибка", "Такого сообщения не существует.","no");
        }
        $adminview = 1;
    }

//sender отправитель
//receiver получатель
    // Prepare for displaying message
    $message = mysql_fetch_assoc ( $res );
    if ($message ['sender'] == $CURUSER ['id']) {
        // Display to
        //$res2 = sql_query ( "SELECT username FROM users WHERE id=" . sqlesc ( $message ['receiver'] ) ) or sqlerr ( __FILE__, __LINE__ );
        //$sender = mysql_fetch_array ( $res2 );
        $message['sender_name'] = $CURUSER['name'];
        $message['sender_id'] = $CURUSER['id'];
        //$reply = "";
        //$from = "Кому";
       /* $res2 = sql_query ( "SELECT `id`,`name` FROM users WHERE id=" . sqlesc ( $message ['receiver'] ) ) or sqlerr ( __FILE__, __LINE__ );
        $receiver = mysql_fetch_array ( $res2 );
        $message['receiver'] =  $receiver['name'];
        $message['receiver_id'] =  $receiver['id'];*/
    }
    elseif($message['sender'] !=0) {
      /*  $from = "От кого";
        if ($message ['sender'] == 0) {
            $sender = "Системное";
            $reply = "";
        } else {*/
            $res2 = sql_query ( "SELECT `id`,`name` FROM users WHERE id=" . sqlesc ( $message ['sender'] ) ) or sqlerr ( __FILE__, __LINE__ );
            $sender = mysql_fetch_array ( $res2 );
         $message['sender_name'] = $sender['name'];
        $message['sender_id'] = $sender['id'];
           // $sender = "<A href=\"".$REL_SEO->make_link('userdetails','id',$message['sender'],'username',translit($sender [0]))."\">{$sender [0]}</A>";
            //$reply = " [ <A href=\"".$REL_SEO->make_link('message','action','sendmessage','receiver',$message['sender'],'replyto',$pm_id)."\">Ответить</A> ]";
       // }
    }
    if($message['receiver'] == $CURUSER ['id']){
        $message['receiver_name'] = $CURUSER['name'];
        $message['receiver_id'] = $CURUSER['id'];
    }
    else{
        $res2 = sql_query ( "SELECT `id`,`name` FROM users WHERE id=" . sqlesc ( $message ['receiver'] ) ) or sqlerr ( __FILE__, __LINE__ );
        $receiver = mysql_fetch_array ( $res2 );
        $message['receiver'] = $receiver['name'];
        $message['receiver_id'] = $receiver['id'];

    }

 //   $body =  $message ['msg'] ;
    $message['added'] = mkprettytime($message['added']);
    if (get_user_class () == UC_ADMINISTRATOR && $message ['sender'] == $CURUSER ['id']) {
        $unread = ($message ['unread'] ? "<SPAN style=\"color: #FF0000;\"><b>(Новое)</b></A>" : "");
    } else {
        $unread = "";
    }
//    $subject =  $message ['subject'] ;
    if (strlen($message['subject']) <= 0) {
        $message['subject'] = "Без темы";
    }
    // Mark message unread
    if ($adminview && ($CURUSER ['id'] != $message ['receiver']) && ($CURUSER ['id'] != $message ['sender'])) {
    } else
        sql_query ( "UPDATE messages SET unread=0 WHERE id=" . sqlesc ( $pm_id ) . " AND receiver=" . sqlesc ( $CURUSER ['id'] ) . " LIMIT 1" );
    // Display message
   // $REL_TPL->stdhead( "Личное Сообщение (Тема: $subject)" );
    /*
    ?>
    <TABLE width="100%" border="0" cellpadding="4" cellspacing="0">

        <TR>
            <TD class="colhead" colspan="2">Тема: <?=$subject?><span class="higo"><a
                        href="javascript:history.go(-1);">назад</a></span></TD>

        </TR>
        <TR>
            <TD width="50%" class="colhead"><?=$from?></TD>
            <TD width="50%" class="colhead">Дата отправки</TD>
        </TR>
        <TR>
            <TD><?=$sender?></TD>
            <TD><?=$added?>&nbsp;&nbsp;<?=$unread?></TD>
        </TR>
        <TR>
            <TD colspan="2" style="padding: 20px;"><?=$body?></TD>
        </TR>
        <TR>
            <TD align="right" colspan=2><?php
                    if ($adminview && ($CURUSER ['id'] != $message ['receiver']) && ($CURUSER ['id'] != $message ['sender'])) {
                        $a_receiver = sql_query ( "SELECT username FROM users WHERE id = " . $message ['receiver'] );
                        $a_receiver = mysql_result ( $a_receiver, 0 );

                        print ( '<font color="red">Вы просматриваете это сообщение от прав администратора!</font> Получатель: <a href="'.$REL_SEO->make_link('userdetails','id',$message['receiver'],'username',translit($a_receiver)).'">' . $a_receiver . '</a><br />' );
                    }
                 //   print ( "[ <A onClick=\"return confirm('Вы уверены?')\" href=\"".$REL_SEO->make_link('message','action','deletemessage','id',$pm_id)."\">Удалить</A> ]$reply [ <A href=\"".$REL_SEO->make_link('message','action','forward','id',$pm_id)."\">Переслать</A> ]" . reportarea ( $message ['id'], 'messages' ) );
                ?></TD>
        </TR>
    </TABLE>
    <?*/

    //set_visited('messages',$pm_id);
    $REL_TPL->assignByRef('pm_id',$pm_id);
    $REL_TPL->assignByRef('message',$message);
    $REL_TPL->output("viewmessage","message");

