
<a href="action_admin.php?module=page&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новый вопрос</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
    <tr>
        <th>Название</th>
        <th>Ссылка</th>
        <th>Добавлено</th>
        <th>Изменено</th>
        <th>Статус</th>
        <th>Действие</th>


    </tr>
    </thead>

    <tbody data-w="department">
    {foreach from=$data_page item=page}

        <tr data-id="{$page.id}">
            <td>
                {$page.title}
            </td>
            <td>
                <a href="page.php?id={$page.id}">Перейти</a> <i class="fa fa-external-link"></i>
            </td>
            <td>
                {$page.added}
            </td>
            <td>
                {$page.edited}
            </td>
            <td>
                {if $page.status == '0'}<span class="label label-sm label-success">Включено</span>{elseif $page.status == '1'}<span class="label label-sm label-default">Выключено</span>{else}N/A{/if}
            </td>
            <td>
                {if $page.status==0}<a href="action_admin.php?module=page&action=disable&id={$page.id}">Отключить</a>{else} <a href="action_admin.php?module=page&action=enable&id={$page.id}">Включить</a>{/if} | <a href="action_admin.php?module=page&action=edit&id={$page.id}">Изменить</a>
            </td>

        </tr>
    {/foreach}
    </tbody>
</table>