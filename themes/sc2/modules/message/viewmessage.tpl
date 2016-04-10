    <div class="box-inner">

        <!-- MESSAGE -->
        <ul class="comment list-unstyled">
            <li class="comment">

                <!-- avatar -->
                <img height="50" width="50" alt="avatar" src="/assets/images/no_avatar.jpg" class="avatar">

                <!-- message body -->
                <div class="comment-body">
                    От кого: {if $message.sender}<a href="userdetalis.php?id={$message.sender_id}"><span>{$message.sender_name}</span></a>{else}Системное{/if}  <small class="text-muted pull-right"> {$message.added} </small>
                    <p>{if $message.receiver}Кому: <a href="userdetalis.php?id={$message.receiver_id}"><span>{$message.receiver_name}</span></a>{/if}</p>
                    <p>Тема: {$message.subject}</p>


                    <hr>
                    <p>
                        {$message.msg}
                    </p>
                </div><!-- /message body -->

                <!-- options -->
                <ul class="list-inline size-11 margin-top-10">
                    <li>
                        {if $message.sender}<a class="text-info" href="message.php?action=sendmessage&receiver={$message.sender_id}&replyto={$pm_id}"><i class="fa fa-reply"></i> Ответить</a>{/if}

                    </li>
                    <li class="pull-right">
                        <a class="text-danger" href="message.php?action=deletemessage&id={$pm_id}">Удалить</a>
                    </li>

                </ul>
            </li><!-- /options -->

        </ul>
        <!-- /MESSAGE -->

    </div>
