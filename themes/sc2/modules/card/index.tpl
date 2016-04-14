<div class="alert alert-danger margin-bottom-30">
    <strong>Внимание</strong> Страница в тестовом режиме
</div>
<!-- HTML DATATABLES -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Менеджер</th>
            {if $IS_POWER_HEAD}
                <th>Отделение</th>
            {/if}
            <th>EQUID</th>
            <th>Тип карты</th>
            <th>След. звонок</th>
            <th>Действие</th>
        </tr>
        </thead>

        <tbody data-w="card">
        {foreach from=$data_card item=card}

            <tr data-id="{$card.id}" id="card_{$card.id}" >
                <td>
                    {$card.name}
                </td>
                <td>
                    {$card.manager}
                </td>
                {if $IS_POWER_HEAD}
                    <td>
                        {$card.d_name}
                    </td>
                {/if}
                <td>
                    {$card.equid}
                </td>
                <td>
                    {$card.name_card}
                </td>
                <td>
                    {$card.next_call}
                </td>
                <td>
                    <i class="fa fa-times" aria-hidden="true"></i>
                    <a class="disable" href="#" onclick="issue_card({$card.id})">Выдать </a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    </table>
    <!--очень кривой вывод номеров страниц. переделать-->
    <ul class="pagination pagination-sm">
        <!--<li class="disabled"><a href="#">Пред</a></li>-->
        {if ($page > 2)}
            <li><a href="user.php?page=1{$add_link}">Первая</a></li>
            <li><a href="user.php?page={$page - 2}{$add_link}">{$page - 2}</a></li>
        {/if}
        {if ($page > 1)}
            <li><a href="user.php?page={$page - 1}{$add_link}">{$page - 1}</a></li>
        {/if}
        <li class="active"><a href="#">{$page}</a></li>
        {if ($page < ($max_page + 1) AND $page < $max_page)}
            <li><a href="user.php?page={$page + 1}{$add_link}">{$page + 1}</a></li>
        {/if}
        {if ($page < ($max_page + 2)  AND ($page+1) < $max_page)}
            <li><a href="user.php?page={$page + 2}{$add_link}">{$page + 2}</a></li>
            <li><a href="user.php?page={$max_page}{$add_link}">Последняя</a></li>
        {/if}
        <!--<li><a href="#">След</a></li>-->
    </ul>



