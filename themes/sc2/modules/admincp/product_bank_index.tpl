<div class="alert alert-warning margin-bottom-30"><!-- warning -->
	Все изменения вносимые в данной опции влияют на всех пользователей и клиентов
</div>

<a href="action_admin.php?module=product_bank&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить новый продукт</button></a>
<hr>
<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
<thead>
	<tr>
		<th>Название</th>
		<th>Дата добавления</th>
		<th>Последнее изменение</th>
		<th>Статус</th>
		
		<th>Действия</th>
	</tr>
</thead>

<tbody data-w="product">
	{foreach from=$data_product item=product}
			
	<tr data-id="{$product.id}">
		<td>
			 {$product.name}
		</td>
		<td>
			  {$product.added}
		</td>
		<td>
			 {$product.edited}
		</td>
		<td class="center">
			{if $product.disable==0}<span class="label label-sm label-success">Активен</span>{else}<span class="label label-sm label-default">Выключен</span>{/if}
		</td>

		<td>
			{if $product.disable==0}<a href="action_admin.php?module=product_bank&action=disable&id={$product.id}">Отключить</a>{else} <a href="action_admin.php?module=product_bank&action=enable&id={$product.id}">Включить</a>{/if} | <a href="action_admin.php?module=product_bank&action=edit&id={$product.id}">Изменить</a>
		</td>
	</tr>
	{/foreach}
</tbody>
</table>