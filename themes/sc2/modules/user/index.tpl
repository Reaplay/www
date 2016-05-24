{if $IS_POWER_HEAD}
<div class="text-center">
	{*<a href="card.php?action=add"><button type="submit" class="btn btn-primary"> Добавить</button></a>*}
	<a href="users.php?action=add"> <button type="button" class="btn btn-primary btn-lg  margin-bottom-30" >Добавить пользователя</button></a>
	<button type="button" class="btn btn-primary btn-lg  margin-bottom-30" data-toggle="modal" data-target="#filter">Фильтр</button>
</div>

<div id="filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form  action="user.php" method="get">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Фильтр</h4>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">

					<div class="row margin-bottom-10">
						<div class="col-md-6">

								<h4>Фильтр по отделениям</h4>
								<div class="fancy-form fancy-form-select">
									<select class="form-control" name="department">
										<option value="">Выберите отделение</option>
										{$list_department}
									</select>
									<i class="fancy-arrow"></i>
								</div>

						</div>
						<div class="col-md-6">

						</div>
					</div>


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
{/if}
{paginator page='user' add_link=$add_link add_sort=$add_sort  num_page=$page max_page=$max_page count=$count}
{*
<ul class="pagination pagination-sm">
	<!--<li class="disabled"><a href="#">Пред</a></li>-->
	{if ($page > 2)}
		<li><a href="card.php?page=1{$add_link}{$add_sort}">Первая</a></li>
		<li><a href="card.php?page={$page - 2}{$add_link}{$add_sort}">{$page - 2}</a></li>
	{/if}
	{if ($page > 1)}
		<li><a href="card.php?page={$page - 1}{$add_link}{$add_sort}">{$page - 1}</a></li>
	{/if}
	<li class="active"><a href="#">{$page}</a></li>
	{if ($page < ($max_page + 1) AND $page < $max_page)}
		<li><a href="card.php?page={$page + 1}{$add_link}{$add_sort}">{$page + 1}</a></li>
	{/if}
	{if ($page < ($max_page + 2)  AND ($page+1) < $max_page)}
		<li><a href="card.php?page={$page + 2}{$add_link}{$add_sort}">{$page + 2}</a></li>
		<li><a href="card.php?page={$max_page}{$add_link}{$add_sort}">Последняя</a></li>
	{/if}
	<!--<li><a href="#">След</a></li>-->
	Результаты поиска ({$count} записей)
</ul>

*}
<!-- HTML DATATABLES -->
<div class="table-responsive">
	<table class="table table-bordered table-striped" id="table">
	<thead>
		<tr>
			<th>Имя</th>
			<th>Логин</th>
			{if $IS_POWER_HEAD}
			<th>Отделение</th>
			{/if}
			<th>Статус</th>
			<th>Редактировать</th>
			<th></th>
		</tr>
	</thead>

	<tbody data-w="user">
		{foreach from=$data_user item=user}
				
		<tr data-id="{$user.id}">
			<td>
				 {$user.name}
			</td>
			<td>
				  {$user.login}
			</td>
			{if $IS_POWER_HEAD}
			<td>
				 {$user.d_name}
			</td>
			{/if}
			<td class="center" id="status_{$user.id}">
				 {if $user.enable == 2}<span class="label label-sm label-danger">Отключен</span>{elseif $user.enable == 1}<span class="label label-sm label-success">Включен</span>{elseif $user.enable == 0}<span class="label label-sm label-warning">Заморожен</span>{/if}
			</td>
			<td>
				<i class="fa fa-external-link"></i> <a href="user.php?a=e&amp;id={$user.id}">Перейти</a>
			</td>
			<td id="disable_{$user.id}">
				<i class="fa fa-ban"></i>{if $user.enable == 1} <a class="disable" href="#" onclick="disable_user('disableuser',{$user.id})">Отключить </a>{elseif $user.enable == 2} <a class="disable" href="#" onclick="disable_user('enableuser',{$user.id})">Включить</a>{else}Запрещено{/if}
			</td>
		</tr>
		{/foreach}
	</tbody>
	</table>
</table>
	</div>
{paginator page='user' add_link=$add_link add_sort=$add_sort  num_page=$page max_page=$max_page count=$count}
{*
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
*}



