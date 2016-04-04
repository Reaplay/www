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



