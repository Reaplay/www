

	<!-- RIGHT -->
<div class="col-lg-9 col-md-9 col-sm-8">
	<div class="tab-content tab-stacked">
		<div id="tab_a" class="tab-pane active">
			<h4>Профиль</h4>
			{if $data_client.status == 0}<span class="label label-sm label-danger">Не клиент</span>{elseif $data_client.status == 1}<span class="label label-sm label-success">Клиент</span>{elseif $data_client.status == 2}<span class="label label-sm label-warning">Отказ</span>{/if}
			<p>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-user  fa-fw"></li>ФИО
					</div>
					<div class="col-md-5">
						{$data_client.name}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-male  fa-fw"></li>Пол:
					</div>
					<div class="col-md-5">
						 {if $data_client.gender == 1}Мужской{elseif $data_client.gender == 2}Женский{else}Не задан{/if}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-phone  fa-fw"></li>Телефон
					</div>
					<div class="col-md-5">
						 {if $data_client.mobile!=0}{$data_client.mobile}{/if}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-envelope-o  fa-fw"></li>E-mail:
					</div>
					<div class="col-md-5">
						 {$data_client.email}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-birthday-cake fa-fw"></li>ДР:
					</div>
					<div class="col-md-5">
						{if $data_client.birthday!=0} {$data_client.birthday} {else}Не задана{/if}
					</div>
				</div>
			</p>
			<p>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-users  fa-fw"></li>Менеджер:
					</div>
					<div class="col-md-5">
						 {$data_client.u_name} {if $IS_HEAD_POWER}({$data_client.d_name}){/if}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<li class="footer-sprite fa fa-key  fa-fw"></li>EQ UID:
					</div>
					<div class="col-md-5">
						 {$data_client.equid} {if !$data_client.equid}Отсутствует{/if}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<h4>Комментарий</h4>
						{$data_client.comment}
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
		{if $IS_HEAD}
		<div id="change_mgr" class="tab-pane">
			<h4>Изменить менеджера</h4>
			<p>
				Текущий: {$data_client.u_name} {if $IS_HEAD_POWER}({$data_client.d_name}){/if}
				<br />
			
				<div class="row">
					<div class="col-md-2">
						Сменить на
					</div>
					<form class="nomargin sky-form" action="client.php?a=e&type=change" method="post">
					<div class="col-md-6">
						<div class="fancy-form fancy-form-select" >
							<select name="new_manager" class="form-control  select2" style="width: 100%;"> 
							{$data_manager}
							</select>
							<i class="fancy-arrow"></i>
						</div>
					</div>
					<input type="hidden" name = "id" value="{$data_client.id}">
					<input type="hidden" name = "action" value="change_mgr">
					<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {if $data_client}Изменить{else}Добавить{/if}</button>
					</form>
				</div>

				
			</p>
		</div>
		{/if}
	</div>
</div>
	
