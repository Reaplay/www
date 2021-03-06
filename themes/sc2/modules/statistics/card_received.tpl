<form class="<!--validate--> nomargin sky-form boxed" action="statistic.php?type=card&subtype=received" method="post">
        <fieldset class="nomargin">


        <div class="row margin-bottom-10">


            <div class="col-md-3">
                <input type="text" class="form-control rangepicker" data-format="dd-mm-yyyy" data-from="{$smarty.now|date_format:"%d-%m-%Y"}" data-to="{$smarty.now|date_format:"%d-%m-%Y"}" name="time_range" value="{if $data_range}{$data_range}{else}{$smarty.now|date_format:"%d-%m-%Y"} - {$smarty.now|date_format:"%d-%m-%Y"}{/if}">

            </div>



            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Отобразить</button>

            </div>



    </fieldset>



</form>
<br />



<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
        <tr>
            <th>ФИО</th>
            <th>Всего</th>
            <th>Получено</th>
            <th>Выдано</th>
            <th>Уничтожено</th>

        </tr>
        </thead>

        <tbody data-w="user">
        {foreach from=$data_user item=user}

            <tr data-id="{$user.id}" id="user_{$user.id}" >
                <td>
                    {$user.name}
                </td>

                <td>
                    {$user.all}
                </td>
                <td>
                    {$user.received}
                </td>
                <td>
                    {$user.issued}
                </td>
                <td>
                    {$user.destroy}
                </td>

            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
        <tr>
            <th>Карта</th>
            <th>Всего</th>
            <th>Получено</th>
            <th>Выдано</th>
            <th>Уничтожено</th>

        </tr>
        </thead>

        <tbody data-w="user">
        {foreach from=$data_card item=card}

            <tr data-id="{$card.id}" id="card_{$card.id}" >
                <td>
                    {$card.name}
                </td>

                <td>
                    {$card.all}
                </td>
                <td>
                    {$card.received}
                </td>
                <td>
                    {$card.issued}
                </td>
                <td>
                    {$card.destroy}
                </td>

            </tr>
        {/foreach}
        </tbody>
    </table>
</div>



