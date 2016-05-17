<div class="col-lg-3 col-md-3 col-sm-4">


	<ul class="nav nav-tabs nav-stacked">
        <li class="active">
            <a href="#tab_a" data-toggle="tab"><i class="fa fa-eye"></i> Профиль</a>
        </li>
		<li>
			<a href="card.php?action=call_client&amp;id={$data_card.id}" ><i class="fa fa-plus"></i> Добавить контакт</a>
		</li>
		<li>
			<a href="card.php?action=edit&id={$data_card.id}" ><i class="fa  fa-pencil-square-o"></i> Редактировать</a>
		</li>

        {if $IS_POWER_USER}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Действия<span class="caret"></span></a>
                <ul class="dropdown-menu">


                    <li><a href="#change_mgr" tabindex="-1" data-toggle="tab">Сменить менеджера</a></li>
                    <li><a href="card.php?action=delete&id={$data_card.id}" ><i class="fa  fa-trash-o"></i> Удалить</a></li>

                </ul>
            </li>
        {/if}



	</ul>

</div>

<!-- RIGHT -->
<div class="col-lg-9 col-md-9 col-sm-8">
    <div class="tab-content tab-stacked">
        <div id="tab_a" class="tab-pane active">
            <h4>Профиль карты</h4>
            {if $data_card.status == 0}<span class="label label-sm label-danger">Не выдана</span>{elseif $data_card.status == 1}<span class="label label-sm label-success">Выдана</span>{elseif $data_card.status == 2}<span class="label label-sm label-warning">Уничтожена</span>{/if} {if $data_card.vip}<span class="label label-purple">VIP</span>{/if}
            <p>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-user  fa-fw"></li>ФИО
                </div>
                <div class="col-md-5">
                    {$data_card.name}
                </div>
            </div>
             <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-phone  fa-fw"></li>Телефон
                </div>
                <div class="col-md-5">
                    {if $data_card.mobile!=0}{$data_card.mobile}{/if}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-credit-card  fa-fw"></li>Тип карты
                </div>
                <div class="col-md-5">
                    {$data_card.name_card} ({if $cobrand.type == 1}Дебетовая{elseif $cobrand.type == 2}Кредитная{else}N/A{/if})
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-calendar-times-o  fa-fw"></li>Следующий звонок
                </div>
                <div class="col-md-5">
                    {$data_card.next_call}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-calendar  fa-fw"></li>Карта добавлена
                </div>
                <div class="col-md-5">
                    {$data_card.added}
                </div>
            </div>
            </p>
            <p>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-users  fa-fw"></li>Менеджер:
                </div>
                <div class="col-md-5">
                    {$data_card.u_manager} {if $IS_POWER_HEAD}({$data_card.d_name}){/if}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <li class="footer-sprite fa fa-key  fa-fw"></li>EQ UID:
                </div>
                <div class="col-md-5">
                    {$data_card.equid} {if !$data_card.equid}Отсутствует{/if}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4>Комментарий</h4>
                    {$data_card.comment}
                </div>
            </div>
            <div class="divider"><!-- divider --></div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Последние контакты</h4>
                    <p>
                        {if !$data_callback}
                        История пуста
                        {else}

                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Тип контакта</th>
                            <th>Результат контакта</th>
                            <th>Сотрудник</th>
                            <th>След. звонок</th>
                        </tr>
                        </thead>

                        <tbody data-w="callback">
                        {foreach from=$data_callback item=callback}
                            <tr data-id="{$callback.id}">
                                <td>
                                    {$callback.added}
                                </td>
                                <td>
                                    {if $callback.type_contact == 1}Звонок{elseif $callback.type_contact == 2}Встреча{else}Не известно{/if}
                                </td>
                                <td>
                                    {$callback.rc_name}
                                </td>
                                <td>
                                    {$callback.u_name}
                                </td>

                                <td>
                                    {$callback.next_call}
                                </td>
                            </tr>
                            {if {$callback.comment}}
                                <tr>
                                    <td colspan="6" >{$callback.comment}	</td>
                                </tr>
                            {/if}
                        {/foreach}

                        </tbody>
                    </table>
                    {/if}
                    </p>
                </div>

            </div>
            </p>
        </div>
        <div id="tab_b" class="tab-pane">
            <h4>История контактов</h4>
            <a href="client.php?a=callback&amp;id={$data_card.id}" tabindex="-1">Добавить контакт</a>
            <p>
                {if !$data_callback}
                История пуста
                {else}
                Фильтр:
            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Тип контакта</th>
                    <th>Сотрудник</th>
                    <th>Продукты</th>
                    <th>Результат</th>
                    <th>След. звонок</th>
                </tr>
                </thead>

                <tbody data-w="callback">
                {foreach from=$data_callback item=callback}
                    <tr data-id="{$callback.id}">
                        <td>
                            {$callback.added}
                        </td>
                        <td>
                            {if $callback.type_contact == 1}Звонок{elseif $callback.type_contact == 2}Встреча{else}Не известно{/if}
                        </td>
                        <td>
                            {$callback.u_name}
                        </td>
                        <td class="center">
                            {$callback.product}
                        </td>
                        <td>
                            {$callback.rc_name}
                        </td>
                        <td>
                            {$callback.next_call}
                        </td>
                    </tr>
                {/foreach}

                </tbody>
            </table>
            {/if}
            </p>
        </div>
        {if $IS_POWER_USER}
            <div id="change_mgr" class="tab-pane">
                <h4>Изменить менеджера</h4>
                <p>
                    Текущий: {$data_card.u_manager} {if $IS_HEAD_POWER}({$data_card.d_name}){/if}
                    <br />

                <div class="row">
                    <div class="col-md-2">
                        Сменить на
                    </div>
                    <form class="nomargin sky-form" action="card.php?action=change_mgr" method="post">
                        <div class="col-md-6">
                            <div class="fancy-form fancy-form-select" >
                                <select name="new_manager" class="form-control  select2" style="width: 100%;">
                                    {$data_manager}
                                </select>
                                <i class="fancy-arrow"></i>
                            </div>
                        </div>
                        <input type="hidden" name = "id" value="{$data_card.id}">
                        <input type="hidden" name = "action" value="change_mgr">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {if $data_card}Изменить{else}Добавить{/if}</button>
                    </form>
                </div>


                </p>
            </div>
        {/if}
    </div>
</div>
	
