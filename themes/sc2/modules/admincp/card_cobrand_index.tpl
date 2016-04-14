<div class="alert alert-warning margin-bottom-30"><!-- warning -->
    Все изменения вносимые в данной опции влияют на всех пользователей и клиентов
</div>

<a href="action_admin.php?module=cobrand&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новую кобрендовую карту</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
    <tr>
        <th>Название</th>
        <th>Дата добавления</th>
        <th>Последнее изменение</th>
        <th>Статус</th>

        <th>Действия</th>
    </tr>
    </thead>

    <tbody data-w="product">
    {foreach from=$data_card_cobrand item=cobrand}

        <tr data-id="{$cobrand.id}">
            <td>
                {$cobrand.name}
            </td>
            <td>
                {$cobrand.added}
            </td>
            <td>
                {$cobrand.edited}
            </td>
            <td class="center">
                {if $cobrand.disable==0}<span class="label label-sm label-success">Активен</span>{else}<span class="label label-sm label-default">Выключен</span>{/if}
            </td>

            <td>
                {if $cobrand.disable==0}<a href="action_admin.php?module=cobrand&action=disable&id={$cobrand.id}">Отключить</a>{else} <a href="action_admin.php?module=cobrand&action=enable&id={$cobrand.id}">Включить</a>{/if} | <a href="action_admin.php?module=cobrand&action=edit&id={$cobrand.id}">Изменить</a>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>