<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 06.04.2016
     * Time: 22:26
     */
// Get Mailbox Number
    $mailbox = ( int ) $_GET ['box'];
    if (! $mailbox) {
        $pm['mailbox'] = PM_INBOX;
    }
    if ($mailbox == PM_INBOX) {
        $pm['mailbox_name'] = "Входящие";
    } else {
        $pm['mailbox_name'] = "Исходящие";
    }

    // Start Page

    #amount of messages
    $inbox_all = count($CURUSER['inbox']);
    $outbox_all = count($CURUSER['outbox']);
   // die($outbox_all);

    $pm['all_mess'] = $inbox_all+$outbox_all;
    $pm['all_mess_procent'] = round(($pm['all_mess']/$REL_CONFIG['pm_max'])*100);
    //print($all_mess_procent);
    $pm['inbox_all_procent'] = round(($inbox_all/$REL_CONFIG['pm_max'])*100);
    $pm['outbox_all_procent'] = round(($outbox_all/$REL_CONFIG['pm_max'])*100);


            $secs_system = $REL_CONFIG['pm_delete_sys_days']*86400; // Количество дней
            $dt_system = time() - $secs_system; // Сегодня минус количество дней
            $secs_all = $REL_CONFIG['pm_delete_user_days']*86400; // Количество дней
            $dt_all = time() - $secs_all; // Сегодня минус количество дней


            if ($pm['mailbox'] != PM_SENTBOX) {
                $res = sql_query ( "
SELECT m.*, u.name AS sender_username
FROM messages AS m
LEFT JOIN users AS u ON m.sender = u.id
WHERE receiver=" . sqlesc ( $CURUSER ['id'] ) . " AND location=" . sqlesc ( $pm['mailbox'] ) . " AND IF(m.archived_receiver=1, 1=1, IF(m.sender=0,m.added>$dt_system,m.added>$dt_all))
ORDER BY id DESC" ) or sqlerr ( __FILE__, __LINE__ );

            } else {
                $res = sql_query ( "SELECT m.*, u.name AS receiver_username FROM messages AS m LEFT JOIN users AS u ON m.receiver = u.id  WHERE sender=" . sqlesc ( $CURUSER ['id'] ) . " AND saved=1 AND IF(m.archived_receiver<>1, 1=1, IF(m.sender=0,m.added>$dt_system,m.added>$dt_all)) ORDER BY id DESC" ) or sqlerr ( __FILE__, __LINE__ );

            }

            if (mysql_num_rows ( $res ) == 0) {
                $pm['not_message'] = "Нет сообщений";

            }
            else{
                $i=0;
                while ($row = mysql_fetch_array($res)) {
                    $data_message[$i] = $row;
                    $data_message[$i]['added'] = mkprettytime ($row['added']);
                    if ($row['archived']) {
                        $data_message[$i]['time_to_del'] == 'N/A';
                    }
                    else{
                        if ($row ['sender'] == 0)
                            $pm_del = $REL_CONFIG ['pm_delete_sys_days'];
                        else
                            $pm_del = $REL_CONFIG ['pm_delete_user_days'];
                        $data_message[$i]['time_to_del'] = $pm_del - round ( (time () - $row ['added']) / 86400 )." дня(ей)";
                    }


                    $i++;
                }
            }


    $REL_TPL->assignByRef('pm',$pm);
    $REL_TPL->assignByRef('data_message',$data_message);
    $REL_TPL->output("viewmailbox","message");