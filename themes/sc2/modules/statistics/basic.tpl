<div class="alert alert-info margin-bottom-30">
    Данные обновляются раз в {$REL_CONFIG['cache_statistic_card']/60} минут
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="all_card">
        <thead>
        <tr>
            <th>Поступило карт</th>
            <th>Выдано</th>
            <th>Уничтожено</th>
            <th>Ожидает</th>
            <th>Просрочено</th>
            <th>Среднее время изменения статуса</th>
        </tr>
        </thead>

        <tbody data-w="all_card">


            <tr>
                <td>{$card.all_added}</td>
                <td>{$card.all_issue}</td>
                <td>{$card.all_destroy}</td>
                <td>{$card.all_wait}</td>
                <td>{$card.all_expired}</td>
                <td>{$card.all_avg_time}</td>
            </tr>

        </tbody>
    </table>

</div>

{*
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="card_manager">
        <thead>
        <tr>
            <th>Менеджер</th>
            <th>Карт поступило</th>
            <th>Выдано</th>
            <th>Уничтожено</th>
            <th>Ожидает</th>
            <th>Просрочено</th>
            <th>Среднее время изменения статуса</th>
        </tr>
        </thead>

        <tbody data-w="department">
        {foreach from=$data_card item=data}

            <tr data-id="{$data.id_user}" id="user_{$data.id_user}" >
                <td>{$data.added}</td>
                <td>{$data.issue}</td>
                <td>{$data.destroy}</td>
                <td>{$data.wait}</td>
                <td>{$data.expired}</td>
                <td>{$data.avg_time}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>

</div>
*}