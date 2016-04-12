<div class="alert alert-danger margin-bottom-30">
    <strong>Внимание</strong> Страница в тестовом режиме
</div>
<h3> {$pm.mailbox_name}</h3>
<div class="panel panel-default">
    <div class="panel-body">
        <strong>Ваш ящик заполнен на:</strong> {$pm.all_mess} ({$pm.all_mess_procent}%) <small>максимальное количество сообщений - {$REL_CONFIG['pm_max']}</small><br />

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
    <form id="message" action="{$REL_CONFIG['defaultbaseurl']}/message.php" method="POST"><input type="hidden" name="action" value="moveordel">
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
        <tr>
            <th></th>
            <th>Тема</th>
            <th>Отправитель</th>
            <th>Дата</th>
            <th>В архиве</th>
            <th>Срок хранения</th>
            <th>
                <input id="check_all_message"  type="checkbox" title="Отметить все" value="Отметить все" />
            </th>
        </tr>
    </thead>

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
            <td><input class="checkbox" type="checkbox" name="messages[]" title="mark" value="{$message.id}" id="checkbox_tbl_{$message.id}"></td>


        </tr>
    {/foreach}
    </tbody>

</table>

    <tr class="colhead">
        <td class="colhead">&nbsp;</td>
        <td colspan="6" align="right" width="100%" class="colhead" />
        <input type="hidden" name="box" value="{$pm.mailbox}" />

        <form action="message.php" method="post">
        <button type="submit" name="delete"  title="Удалить помеченные сообщения" value="delete" onClick="return confirm('Точно удалить все сообщения?')" type="button" class="btn btn-default">Удалить</button>
        <button type="submit" name="markread"  title="Отметить как прочитанные" value="mark_read" onClick="return confirm('Вы уверены, что хотите пометить выбранные сообщения как прочитанные?')" type="button" class="btn btn-default">Отметить как прочитанные</button>
        {*<button type="submit" name="archive"  title="Архивировать" value="archive" onClick="return confirm('Архивировать выбранные сообщения? (они не будут удалены системой автоматически)')" type="button" class="btn btn-default">Архивировать</button>
        <button type="submit" name="unarchive"  title="Разархивировать сообщения" value="un_archive" onClick="return confirm('Разархивировать выбранные сообщения? (они будут удалены системой автоматически)')" type="button" class="btn btn-default">Разархивировать</button>
*}

        </td>

    </tr>
    </form>
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