
<form action="message.php" method="post" class="block-review-content">

    <div class="border-bottom-1 border-top-1 padding-10">
        Кому: <strong>{$message.receiver_name}</strong>
    </div><br />
    <div class="fancy-form">

        <i class="fa fa-newspaper-o"></i>

        <input name="subject" type="text" class="form-control" placeholder="Тема" value="{$message.subject}">

        <!-- tooltip - optional, bootstrap tooltip can be used instead -->
		<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
			<em>Введите тему</em>
		</span>
    </div>
    <textarea name="body" class="summernote form-control" data-height="200" data-lang="en-US">{$message.body}</textarea>
    <button class="btn btn-3d btn-sm btn-reveal btn-teal">
        <i class="fa fa-check"></i>
        <span>Отправить</span>
    </button>
    <input type="hidden" name="action" value="takemessage">
    <input type="hidden" name="receiver" value="{$message.receiver_id}">
    {if $message.replyto}<input type="hidden" name="origmsg" value="{$message.replyto}">{/if}
</form>
{*

<table class=main border=0 cellspacing=0 cellpadding=0>
    <tr>
        <td class=embedded>
            <form name="message" method="post"
                  action="message.php"><input type="hidden" name="action" value="takemessage">
                <table class=message cellspacing=0 cellpadding=5>
                    <tr>
                        <td colspan=2 class=colhead>Сообщение для <a class=altlink_white
                                                                     href="<?=$REL_SEO->make_link('userdetails','id',$receiver,'username',translit($user['name']))?>"><?=$user ["name"]?></a></td>
                    </tr>

                    <tr>
                        <?
                                if ($replyto) {
                                    ?>
                        <td align=center><input type=checkbox name='delete' value='1'
                            <?=$CURUSER ['deletepms'] ? "checked" : ""?> />Удалить сообщение
                            после ответа <input type=hidden name=origmsg value=<?=$replyto?> /></td>
                        <?
                                }
                            ?>
                        <td align=center><input type=checkbox name='save' value='1'
                            <?=$CURUSER ['savepms'] ? "checked" : ""?> />Сохранить сообщение в
                            отправленных</td>
                    </tr>
                    <tr>
                        <td align="center"><input type="checkbox" name='archive' value='1' />Архивировать
                            после отправки</td>
                    </tr>
                    <tr>
                        <td <?=$replyto ? " colspan=2" : ""?> align=center><input
                                type=submit value="Послать!" class=btn /></td>
                    </tr>
                </table>
                <input type=hidden name=receiver value=<?=$receiver?> /></form>
            </div>
        </td>
    </tr>
</table>*}