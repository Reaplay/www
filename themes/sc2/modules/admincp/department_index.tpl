<div class="alert alert-warning margin-bottom-30"><!-- warning -->
	Все изменения вносимые в данной опции влияют на всех пользователей
</div>

<a href="action_admin.php?module=department&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новое отделение</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
<thead>
	<tr>
		<th>Название</th>
		<th>Родитель</th>
		<th>Статус</th>
		<th>Действия</th>
	</tr>
</thead>

<tbody data-w="department">
	{foreach from=$data_department item=department}
			
	<tr data-id="{$department.id}">
		<td>
			 {$department.name}
		</td>
		<td>
			{if $department.parent==0}Корневой{else}{$department.n_parent}{/if}
		</td>
		<td class="center">
			{if $department.disable==0}<span class="label label-sm label-success">Активен</span>{else}<span class="label label-sm label-default">Выключен</span>{/if}
		</td>

		<td>
			{if $department.disable==0}<a href="action_admin.php?module=department&action=disable&id={$department.id}">Отключить</a>{else} <a href="action_admin.php?module=department&action=enable&id={$department.id}">Включить</a>{/if} | <a href="action_admin.php?module=department&action=edit&id={$department.id}">Изменить</a>
		</td>
	</tr>
	{/foreach}
</tbody>
</table>