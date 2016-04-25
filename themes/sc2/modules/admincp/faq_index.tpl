
<a href="action_admin.php?module=faq&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новый вопрос</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Добавлено</th>
        <th>Изменено</th>
        <th>Статус</th>
        <th>Действие</th>


    </tr>
    </thead>

    <tbody data-w="department">
    {foreach from=$data_faq item=faq}

        <tr data-id="{$faq.id}">
            <td>
                {$faq.title}
            </td>
            <td>
                {$faq.type}
            </td>
            <td>
                {$faq.added}
            </td>
            <td>
                {$faq.edited}
            </td>
            <td>
                {if $faq.status == '0'}<span class="label label-sm label-success">Включено</span>{elseif $faq.status == '1'}<span class="label label-sm label-default">Выключено</span>{else}N/A{/if}
            </td>
            <td>
                {if $faq.status==0}<a href="action_admin.php?module=faq&action=disable&id={$faq.id}">Отключить</a>{else} <a href="action_admin.php?module=faq&action=enable&id={$faq.id}">Включить</a>{/if} | <a href="action_admin.php?module=faq&action=edit&id={$faq.id}">Изменить</a>
            </td>

        </tr>
    {/foreach}
    </tbody>
</table>