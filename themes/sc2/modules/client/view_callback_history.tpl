
	<!-- RIGHT -->
<div class="col-lg-9 col-md-9 col-sm-8">
	<div class="tab-content tab-stacked">
		<div>
			<h4>История контактов</h4>
			<a href="client.php?a=callback&amp;id={$data_client.id}" tabindex="-1">Добавить контакт</a>
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

				<tbody data-w="callback"><div>
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
								{if $callback.next_call}{$callback.next_call}{else}N/A{/if}
							</td>
						</tr>

					{if {$callback.comment}}
						<tr>
							<td colspan="6" >{$callback.comment}	</td>
						</tr>
					{/if}


				{/foreach}
					</div>
				</tbody>
				</table>
				{/if}
			</p>
		</div>
		
		
		<!--очень кривой вывод номеров страниц. переделать-->
		<ul class="pagination pagination-sm">
			<!--<li class="disabled"><a href="#">Пред</a></li>-->
			{if ($page > 2)}
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page=1{$add_link}">Первая</a></li>
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page={$page - 2}{$add_link}">{$page - 2}</a></li>
			{/if}
			{if ($page > 1)}
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page={$page - 1}{$add_link}">{$page - 1}</a></li>
			{/if}
			<li class="active"><a href="#">{$page}</a></li>
			{if ($page < ($max_page + 1) AND $page < $max_page)}
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page={$page + 1}{$add_link}">{$page + 1}</a></li>
			{/if}
			{if ($page < ($max_page + 2)  AND ($page+1) < $max_page)}
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page={$page + 2}{$add_link}">{$page + 2}</a></li>
			<li><a href="client.php?a=callback_history&id={$data_client.id}&page={$max_page}{$add_link}">Последняя</a></li>
			{/if}
			<!--<li><a href="#">След</a></li>-->
		</ul>
	</div>
</div>

	
