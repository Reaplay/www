<button type="button" class="btn btn-primary btn-lg btn-block margin-bottom-30" data-toggle="modal" data-target="#filter">
	Фильтр клиентов
</button>

<div id="filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form  action="client.php" method="get">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Фильтр</h4>
				Действия работают только с выбором статуса клиента
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<div class="row margin-bottom-10">
					<div class="col-md-6">
						<h4>Статус клиента</h4>

						<div class="fancy-form fancy-form-select">
							<select class="form-control " name="status_client">
								<option value="">Выберите статус клиента</option>
								<option value="1">Не клиент</option>
								<option value="2">Клиент</option>
								<option value="3">Отказ</option>
							</select>
							<i class="fancy-arrow"></i>
						</div>

					</div>

					<div class="col-md-6">
						<h4>Действия по клиентам</h4>
						<div class="fancy-form fancy-form-select">
							<select class="form-control" name="status_action">
								<option value="">Выберите статус</option>
								<option value="miss">Пропущенные</option>
								<option value="today">На сегодня</option>
								<option value="next">Дальнейшие</option>
							</select>
							<i class="fancy-arrow"></i>
						</div>
					</div>
				</div>
			<div class="row margin-bottom-10">
				<div class="col-md-6">
					<h4>Фильтр по менеджерам</h4>
					<div class="fancy-form fancy-form-select">
						<select class="form-control" name="manager">
							<option value="">Выберите менеджера</option>
							{$list_manager}
						</select>
						<i class="fancy-arrow"></i>
					</div>
				</div>
				<div class="col-md-6">
					{if $IS_POWER_HEAD}
					<h4>Фильтр по отделениям</h4>
					<div class="fancy-form fancy-form-select">
						<select class="form-control" name="department">
							<option value="">Выберите отделение</option>
							{$list_department}
						</select>
						<i class="fancy-arrow"></i>
					</div>
					{/if}
				</div>
			</div>
				<div class="row margin-bottom-10">
					<div class="col-md-6">
						<h4>Фильтр по промоакциям</h4>
						<div class="fancy-form fancy-form-select">
							<select class="form-control" name="promo_actio">
								<option value="">Выберите промоакцию</option>
								{$list_promo_actio}
							</select>
							<i class="fancy-arrow"></i>
						</div>
					</div>
					<div class="col-md-6">
						<h4>Опции</h4>
						<label class="checkbox">
							<input type="checkbox" name="only_my" value="1">
							<i></i> Только мои
						</label>
						{*<label class="checkbox">
                            <input type="checkbox" name="no_contact" value="1">
                            <i></i> Без запланированных контактов
                        </label>*}
					</div>

				</div>
			<!--	<h4>Статус клиента</h4>
				<p><div class="row margin-bottom-10">
				<div class="col col-md-6">

				</div></div>
				</p>

				<h4>По менеджеру</h4>
				<p></p>

				<h4>По отделению</h4>
				<p></p>
-->
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
				<button type="submit" class="btn btn-primary">Применить</button>

			</div>
			</form>
		</div>
	</div>
</div>
{paginator page='client' add_link=$add_link add_sort=$add_sort  num_page=$page max_page=$max_page count=$count}

<!-- HTML DATATABLES -->
<div class="table-responsive">
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>{if $sort.name}
					{if $sort.name == "asc"}<a href="client.php?page=1{$add_link}&name=desc"><i class="fa fa-caret-up" aria-hidden="true"></i>
					{elseif $sort.name == "desc"}<a href="client.php?page=1{$add_link}&name=asc"><i class="fa fa-caret-down" aria-hidden="true"></i>
					{/if}
				{else}
					<a href="client.php?page=1{$add_link}&name=asc"><i class="fa fa-arrows-v" aria-hidden="true"></i>
				{/if}
				Имя</a>
			</th>
			<th>Менеджер</th>
			{if $IS_POWER_HEAD}
			<th>Отделение</th>
			{/if}
			<th>Статус</th>
			<th>{if $sort.next_call}
					{if $sort.next_call == "asc"}<a href="client.php?page=1{$add_link}&next_call=desc"><i class="fa fa-caret-up" aria-hidden="true"></i>
					{elseif $sort.next_call == "desc"}<a href="client.php?page=1{$add_link}&next_call=asc"><i class="fa fa-caret-down" aria-hidden="true"></i>
					{/if}
				{else}
						<a href="client.php?page=1{$add_link}&next_call=asc"><i class="fa fa-arrows-v" aria-hidden="true"></i>
				{/if}
				След. контакт</a>
			</th>
			<th>Посл. комментарий</th>
			<th>Действия</th>
		</tr>
	</thead>

	<tbody data-w="client">
		{foreach from=$data_client item=client}
			
		<tr data-id="{$client.id}">
			<td>
				<a href="client.php?a=view&amp;id={$client.id}">{$client.name}</a>	<i class="fa fa-external-link"></i> {if $client.cb_next_call}{if $now_date>$client.cb_next_call}<span class="label label-sm label-danger">Пропущен</span>{elseif $now_date==$client.cb_next_call}<span class="label label-sm label-warning">Сегодня</span>{/if}{/if} {if $client.vip}<span class="label label-purple">VIP</span>{/if}
			</td>
			<td>
				  {$client.u_name}
			</td>
			{if $IS_POWER_HEAD}
			<td>
				<small>{$client.d_name}</small>
			</td>
			{/if}
			<td class="center">
				 {if $client.status == 0}<span class="label label-sm label-default">Не клиент</span>{elseif $client.status == 1}<span class="label label-sm label-success">Клиент</span>{elseif $client.status == 2}<span class="label label-sm label-warning">Отказ</span>{/if}
			</td>
			<td>
				{if $client.time_callback}{$client.time_callback}{else}<span class="label label-danger">Не задана</span>{/if}
			</td>
			<td>
				{if $client.cb_comment}{$client.cb_comment}{elseif $client.result_call}{$client.result_call}<br />({$client.cb_manager}){/if}
			</td>
			<td>
				<a href="client.php?a=callback&amp;id={$client.id}">Добавить контакт</a> <i class="fa fa-external-link"></i>
			</td>
		</tr>
		{/foreach}
	</tbody>
	</table>
</div>
{paginator page='client' add_link=$add_link add_sort=$add_sort  num_page=$page max_page=$max_page count=$count}




