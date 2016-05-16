
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
    <thead>
    <tr>
        <th>Название</th>
        <th>Ссылка</th>
        <th>Добавлено</th>
        <th>Изменено</th>
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


        </tr>
    {/foreach}
    </tbody>
</table>