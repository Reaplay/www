<h3> {$pm.mailbox_name}</h3>
<div class="panel panel-default">
    <div class="panel-body">
        <strong>Ваш ящик заполнен на:</strong>{$pm.all_mess} ({$pm.all_mess_procent}%)<small>максимальное количество сообщений - {$REL_CONFIG['pm_max']}</small><br />

              <a href="{$REL_CONFIG['defaultbaseurl']}/message.php?action=viewmailbox&box=1"><span>Входящие {$pm.inbox_all} ({$pm.inbox_all_procent}%) </span></a><br/>
            <a href="{$REL_CONFIG['defaultbaseurl']}/message.php?action=viewmailbox&box=-1"><span>Отправленные {$pm.outbox_all} ({$pm.outbox_all_procent}%) </span></a>

    </div>
</div>






{*<div align="left"><img src="pic/pn_inboxnew.gif" alt="Непрочитанные" />
    mail_unread_desc<br />
    <img src="pic/pn_inbox.gif" alt="Прочитанные" /> mail_read_desc</div>

*}
{if $pm.not_message}
    <div class="alert alert-default margin-bottom-30"><!-- DEFAULT -->
        <strong>{$pm.not_message}</strong>
    </div>
{else}
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
        <tr>
            <th></th>
            <th>Тема</th>
            <th>Отправитель</th>
            <th>Дата</th>
            <th>В архиве</th>
            <th>Срок хранения</th>
            <th></th>
        </tr>
    </thead>
    <form id="message" action="{$REL_CONFIG['defaultbaseurl']}/message.php" method="POST"><input type="hidden" name="action" value="moveordel">
    <tbody data-w="department">
    {foreach from=$data_message item=message}

        <tr data-id="{$message.id}">
            <td>{if $message.unread AND $pm.mailbox != 'PM_SENTBOX'}<i class="fa fa-envelope"></i>{else}<i class="fa fa-envelope-o"></i>{/if}</td>
            <td>{if $message.subject}<a href="message.php?action=viewmessage&id={$message.id}">{$message.subject}</a>{else}Без темы{/if}</td>
            <td>
                {if $pm.mailbox != PM_SENTBOX}
                    {if $message.sender != 0}{$message.sender_username}{else}Система{/if}
                {else}
                    {if $message.receiver != 0}{$message.receiver_username}{else}Система{/if}
                {/if}
            </td>
            <td>{$message.added}</td>
            <td>{if $message.archived}Да{else}Нет{/if}</td>
            <td>{$message.time_to_del}</td>
            <td><input type="checkbox" name="messages[]" title="mark" value="{$messagen.id}" id="checkbox_tbl_{$messagen.id}"></td>


        </tr>
    {/foreach}
    </tbody>
    </form>
</table>

    <tr class="colhead">
        <td class="colhead">&nbsp;</td>
        <td colspan="6" align="right" width="100%" class="colhead" />
        <input type="hidden" name="box" value="{$pm.mailbox}" />
        <input type="submit" name="delete"
               title="delete_marked_messages>"
               value="delete"
               onClick="return confirm('sure_mark_delete')" />
        <input type="submit" name="markread"
               title="mark_as_rea"
               value="mark_read"
               onClick="return confirm('sure_mark_read')" />
        <input type="submit" name="archive" title="Архивировать"
               value="Архивировать"
               onClick="return confirm('Архивировать выбранные сообщения? (они не будут удалены системой автоматически)')" />
        <input type="submit" name="unarchive" title="Разархивировать"
               value="Разархивировать"
               onClick="return confirm('Разархивировать выбранные сообщения? (они будут удалены системой автоматически)')" />
        </td>

    </tr>
{/if}
{*
  if ($row['receiver']==$CURUSER['id']) {
                        $row['archived'] = $row['archived_receiver'];
                    }



                    $msgtext = strip_tags($row['msg']);
                    $msgtext = "<small>".(strlen($msgtext)>70?'...'.substr($msgtext,-70):$msgtext)."</small>";
                    echo ("<TD><A href=\"".$REL_SEO->make_link('message','action','viewmessage','id',$row ['id'])."\">" . $subject . "</A><br/>$msgtext</TD>\n");





                    echo ("<TD><INPUT type=\"checkbox\" name=\"messages[]\" title=\"mark\" value=\"" . $row ['id'] . "\" id=\"checkbox_tbl_" . $row ['id'] . "\"></TD>\n</TR>\n");

*}