<!-- HTML DATATABLES -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Отделение</th>
            <th>Уровень доступа</th>
            <th>IP</th>
            <th>Месторасположение</th>

        </tr>
        </thead>

        <tbody data-w="online">
        {foreach from=$data_session item=session}

            <tr data-id="{$session.sid}">
                <td>
                    {$session.username}
                </td>
                <td>
                    {$session.department}
                </td>
                <td>
                    {$session.class}
                </td>
                <td>
                    {$session.ip}
                </td>
                <td>
                    <a href="{$session.url}">{$session.url}</a> <i class="fa fa-external-link"></i>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>

