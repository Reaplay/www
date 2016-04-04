<div class="alert alert-warning margin-bottom-30"><!-- warning -->
	Все изменения вносимые в данной опции влияют на всех пользователей и клиентов
</div>

<a href="action_admin.php?module=result_call&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новый контакт</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
<thead>
	<tr>
		<th>Название</th>
		<th>Тип контакта</th>
		<th>Статус</th>
		<th>Действия</th>
	</tr>
</thead>

<tbody data-w="result_call">
	{foreach from=$data_result_call item=result_call}
			
	<tr data-id="{$result_call.id}">
		<td>
			 {$result_call.text}
		</td>
		<td>
			{if $result_call.type_contact==0}Не определено{elseif $result_call.type_contact==1}Звонок{elseif $result_call.type_contact==2}Встреча{/if}
		</td>
		<td class="center">
			{if $result_call.disable==0}<span class="label label-sm label-success">Активен</span>{else}<span class="label label-sm label-default">Выключен</span>{/if}
		</td>

		<td>
			{if $result_call.disable==0}<a href="action_admin.php?module=result_call&action=disable&id={$result_call.id}">Отключить</a>{else} <a href="action_admin.php?module=result_call&action=enable&id={$result_call.id}">Включить</a>{/if} | <a href="action_admin.php?module=result_call&action=edit&id={$result_call.id}">Изменить</a>
		</td>
	</tr>
	{/foreach}
</tbody>
</table>