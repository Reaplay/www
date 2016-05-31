{*<div class="alert alert-danger margin-bottom-30">
	<strong>Внимание</strong> Страница в тестовом режиме
</div>*}
<div class="alert alert-info margin-bottom-30">
	Данные обновляются раз в {$REL_CONFIG['cache_statistic_all']/60} минут
</div>

<p class="bold">
	В системе <span class="countTo text-danger font-raleway" data-speed="3000">{$statistics.users}</span> пользователей и <span class="countTo font-raleway" data-speed="3000">{$statistics.departments}</span> разных отделений
</p>

{*
<div class="row countTo-md text-center">

	<div class="col-xs-6 col-sm-3">

		<div class="piechart" data-color="#59BA41" data-size="150" data-percent="100" data-width="2" data-animate="1700">
			<span class="countTo font-raleway" data-speed="3000">{$statistics.all_client}</span>
		</div>

		<h5>Клиентов в базе</h5>
	</div>

	<div class="col-xs-6 col-sm-3">

		<div class="piechart" data-color="#F0AD4E" data-size="150" data-percent="{($statistics.client/$statistics.all_client)*100}" data-width="2" data-animate="1700">
			<span class="countTo font-raleway" data-speed="3000">{$statistics.client}</span>
		</div>
		<h5>Клиентов банка</h5>
	</div>

	<div class="col-xs-6 col-sm-3">

		<div class="piechart" data-color="#1693A5" data-size="150" data-percent="{($statistics.not_client/$statistics.all_client)*100}" data-width="2" data-animate="1700">
			<span class="countTo font-raleway" data-speed="3000">{$statistics.not_client}</span>
		</div>
		<h5>Не клиентов</h5>
	</div>

	<div class="col-xs-6 col-sm-3">

		<div class="piechart" data-color="#C02942" data-size="150" data-percent="{($statistics.client_failure/$statistics.all_client)*100}" data-width="2" data-animate="1700">
			<span class="countTo font-raleway" data-speed="3000">{$statistics.client_failure}</span>
		</div>
		<h5>Отказались</h5>
	</div>

</div>

<div class="row countTo-md text-center">

	<div class="col-xs-6 col-sm-4">

		<span class="countTo" data-speed="3000" style="color:#59BA41">{$statistics.callback}</span>
		<h5>Контактов в базе</h5>
	</div>

	<div class="col-xs-6 col-sm-4">

		<span class="countTo" data-speed="3000">{$statistics.callback_held}</span>
		<h5>Проведено контактов</h5>
	</div>

	<div class="col-xs-6 col-sm-4">

		<span class="countTo" data-speed="3000">{$statistics.callback_planed}</span>
		<h5>Запланировано контактов</h5>
	</div>


</div>
<div class="row countTo-md text-center">

	<div class="col-xs-6 col-sm-6">

		<span class="countTo" data-speed="3000">{$statistics.callback_planned_call}</span>
		<h5>Ожидается звонков</h5>
	</div>

	<div class="col-xs-6 col-sm-6">

		<span class="countTo" data-speed="3000">{$statistics.callback_planned_meeting}</span>
		<h5>Ожидается встреч</h5>
	</div>




</div>
*}
<div class="table-responsive">
	<table class="table table-bordered table-striped" id="all">


		<tbody data-w="department">
			<tr>
				<td>Всего клиентов в базе: <b>{$statistics.all_client}</b></td>
				<td>Стали клиентами: <b>{$statistics.client}</b></td>
				<td>Еще не клиентов: <b>{$statistics.not_client}</b></td>
				<td>Отказались: <b>{$statistics.client_failure}</b></td>

			</tr>

			<tr>

				<td>Контактов в базе: <b>{$statistics.callback}</b></td>
				<td>Проведено контактов: <b>{$statistics.callback_held}</b></td>
				<td>Запланировано: <b>{$statistics.callback_planed}</b></td>
			</tr>
			<tr>

				<td>Ожидается звонков: <b>{$statistics.callback_planned_call}</b></td>
				<td>Ожидается встреч: <b>{$statistics.callback_planned_meeting}</b></td>
				<td>Рекомендаций: <b>{$statistics.callback_recomend}</b></td>
			</tr>
		</tbody>
	</table>

</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped" id="department">
		<thead>
		<tr>
			<th>Отделение</th>
			<th>Карт поступило</th>
			<th>Звонков совершено</th>
			<th>Карт выдано</th>
			<th>Карт уничтожено</th>
		</tr>
		</thead>

		<tbody data-w="department">
		{foreach from=$data_card item=data}

			<tr data-id="{$data.id}" id="card_{$data.id}" >
				<td>{$data.name_department}</td>
				<td>{$data.all_added}</td>
				<td>{$data.all_call}</td>
				<td>{$data.all_issue}</td>
				<td>{$data.all_destroy}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

</div>


