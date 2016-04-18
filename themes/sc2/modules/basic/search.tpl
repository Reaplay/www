<form class="clearfix well well-sm search-big nomargin" action="search.php" method="get">
	<div class="input-group">

		<div class="input-group-btn">
			<button data-toggle="dropdown" class="btn btn-default input-lg dropdown-toggle noborder-right" type="button" aria-expanded="false">
				Клиенты <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li class="active">
					<a href="#"><i class="fa fa-check"></i> Клиенты</a>
				</li>

			</ul>
		</div>

		<input type="text" placeholder="Найти..." class="form-control input-lg" name="s">
		<div class="input-group-btn">
			<button class="btn btn-default input-lg noborder-left" type="submit">
				<i class="fa fa-search fa-lg nopadding"></i>
			</button>
		</div>
	</div>

</form>
{if $data_search}
<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>Имя</th>
			<th>Менеджер</th>
			<th>Отделение</th>
			<th>Телефон</th>
			<th>EQ UID</th>
			<!--<th>Профиль</th>-->
			<!--<th>Действия</th>-->
		</tr>
		</thead>

		<tbody data-w="client">
		{foreach from=$data_search item=search}

			<tr data-id="{$search.id}">
				<td>
					{if $type == "card"}
				<a href="card.php?action=view&id={$search.id}">{$search.name}</a>
				{else}
				<a href="client.php?a=view&id={$search.id}">{$search.name}</a>
				{/if}
					<i class="fa fa-external-link"></i>
				</td>
				<td>
					{$search.u_name}
				</td>
				<td>
					{$search.d_name}
				</td>
				<td>
					{$search.mobile}
				</td>
				<td>
					{$search.equid}
				</td>

			</tr>
		{/foreach}
		</tbody>
	</table>
	</table>
	{/if}
