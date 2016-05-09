<form class="<!--validate--> nomargin sky-form boxed" action="statistic.php?type=client&subtype=sales_funnel" method="post">
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
            <th>Звонков</th>
            <th>Встреч</th>
            <th>Продаж</th>

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