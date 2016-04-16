<!--<div class="alert alert-danger margin-bottom-30">
	<strong>Внимание</strong> Страница в тестовом режиме
</div>-->
{*
<form action="" method="post" class="row clearfix">
	<div class="col-lg-7 col-sm-7">
		<div>
			<h4>Фильтр</h4>
		</div>
	
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<label for="">text</label>
					<input type="text" class="" name="" id="">
				</div>
			</div>
		
	</div>
</form>*}
<!-- Bootstrap Modal >-->
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
							{$manager}
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
							{$select_department}
						</select>
						<i class="fancy-arrow"></i>
					</div>
					{/if}
				</div>
			</div>
				<div class="row margin-bottom-10">
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
					<div class="col-md-6">

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

<!-- HTML DATATABLES -->
<div class="table-responsive">
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Имя</th>
			<th>Менеджер</th>
			{if $IS_POWER_HEAD}
			<th>Отделение</th>
			{/if}
			<th>Статус</th>
			<th>След. контакт</th>
			<th>Действия</th>
		</tr>
	</thead>

	<tbody data-w="client">
		{foreach from=$data_client item=client}
			
		<tr data-id="{$client.id}">
			<td>
				<a href="client.php?a=view&amp;id={$client.id}">{$client.name}</a>	<i class="fa fa-external-link"></i> {if $client.cb_next_call}{if $now_date>$client.cb_next_call}<span class="label label-sm label-danger">Контакт просрочен</span>{elseif $now_date==$client.cb_next_call}<span class="label label-sm label-warning">Контакт сегодня</span>{/if}{/if}
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
				 {if $client.status == 0}<span class="label label-sm label-danger">Не клиент</span>{elseif $client.status == 1}<span class="label label-sm label-success">Клиент</span>{elseif $client.status == 2}<span class="label label-sm label-warning">Отказ</span>{/if}
			</td>
			<td>
				{if $client.time_callback}{$client.time_callback}{else}N/A{/if}
			</td>
			<td>
				<a href="client.php?a=callback&amp;id={$client.id}">Добавить отзвон</a> <i class="fa fa-external-link"></i>
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
	<li><a href="client.php?page=1{$add_link}">Первая</a></li>
	<li><a href="client.php?page={$page - 2}{$add_link}">{$page - 2}</a></li>
	{/if}
	{if ($page > 1)}
	<li><a href="client.php?page={$page - 1}{$add_link}">{$page - 1}</a></li>
	{/if}
	<li class="active"><a href="#">{$page}</a></li>
	{if ($page < ($max_page + 1) AND $page < $max_page)}
	<li><a href="client.php?page={$page + 1}{$add_link}">{$page + 1}</a></li>
	{/if}
	{if ($page < ($max_page + 2)  AND ($page+1) < $max_page)}
	<li><a href="client.php?page={$page + 2}{$add_link}">{$page + 2}</a></li>
	<li><a href="client.php?page={$max_page}{$add_link}">Последняя</a></li>
	{/if}
	<!--<li><a href="#">След</a></li>-->
</ul>




