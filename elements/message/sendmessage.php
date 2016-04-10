<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 10.04.2016
     * Time: 20:41
     */
    if(!is_valid_id($_GET['receiver']))
        stderr('Ошибка', 'Неверное ID получателя','no');

    $message['receiver_id'] = (int)$_GET['receiver'];

    if($_GET['replyto'] && !is_valid_id($_GET ['replyto']))
        stderr('Ошибка', 'Неверное ID сообщения','no');

    $message['replyto'] = (int)$_GET['replyto'];

    $res = sql_query("SELECT `name` FROM users WHERE id=".$message['receiver_id']."") or sqlerr( __FILE__, __LINE__ );
    $user = mysql_fetch_assoc($res);
    if(!$user)
        stderr ("Ошибка", "Пользователя с таким ID не существует.","no");
    $message['receiver_name'] = $user['name'];

    if($message['replyto']){
        $res = sql_query("SELECT `receiver`,`sender`,`msg`,`subject` FROM messages WHERE id=".$message['replyto']."") or sqlerr( __FILE__, __LINE__ );
        $msga = mysql_fetch_assoc($res);
        if ($msga["receiver"] != $CURUSER["id"])
            stderr ( "Ошибка", "Вы пытаетесь ответить не на свое сообщение!","no");

        $res = sql_query ( "SELECT `name` FROM users WHERE id=" . $msga ["sender"] ) or sqlerr( __FILE__, __LINE__ );
        $usra = mysql_fetch_assoc ( $res );
        $message['body']  .= "<blockquote>" .  $msga ['msg']  . "</blockquote><cite>$usra[name]</cite><hr /><br /><br />";
        // Change
        if (!preg_match("/^Re\(([0-9]+)\)\:/",$msga ['subject']))
            $message['subject'] = "Re(1): ".$msga ['subject'];
        else
            $message['subject'] = preg_replace("/^Re\(([0-9]+)\)\:/e","'Re('.(\\1+1).'):'",$msga ['subject']);



        // End of Change
    }

   // $REL_TPL->stdhead( "Отсылка сообщений", false );


    $REL_TPL->assignByRef('message',$message);
    $REL_TPL->output("sendmessage","message");