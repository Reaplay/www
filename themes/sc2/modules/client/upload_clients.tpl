<div class="alert alert-danger margin-bottom-30">
	<strong>Внимание</strong> Все загруженные клиенты будут прикреплены к вашей учетной записи.<br>
	Шаблон для загрузки: <a href="{$REL_CONFIG.defaultbaseurl}/manual/shablon.csv">Скачать</a>
</div>

<form enctype="multipart/form-data" action="client.php?a=upload&type=upload_client" method="POST" accept-charset="utf-8">
<input class="custom-file-upload" type="file" id="file" name="attachment" id="contact:attachment" data-btn-text="Выберите файл" />
<small class="text-muted block">Максимальный размер файла: 2Mb (только .csv)</small>
<button  class="btn btn-info">Загрузить</button>
</form>

{if $text_err}{*
<div class="row countTo-md text-center">

	<div class="col-xs-6 col-sm-3">
	<span class="countTo" data-speed="3000">{$num_err.all}</span>
		<h5>Загружено клиентов</h5>
	</div>

	<div class="col-xs-6 col-sm-3">
		<span class="countTo" data-speed="3000">{$num_err.mobile}</span>
		<h5>Некорректный номер телефона</h5>
	</div>

	<div class="col-xs-6 col-sm-3">
		<span class="countTo" data-speed="3000">{$num_err.email}</span>
		<h5>Ошибка с email</h5>
	</div>

	<div class="col-xs-6 col-sm-3">
		<span class="countTo" data-speed="3000">{$num_err.name}</span>
		<h5>Некорректное ФИО</h5>
	</div>

</div>*}
	<div class="toggle toggle-transparent toggle-bordered-simple">
		<div class="toggle">
			<label>Отчет по неудачным загрузкам</label>
			<div class="toggle-content">
				<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
					<thead>
					<tr>
						<td>ФИО</td>
						<td colspan="6" class="center" >Тип проверки</td>
					</tr>
					<tr>
						<th></th>
						<th>Имя</th>
						<th>Сотовый</th>

						<th>E-mail</th>
						<th>Менеджер</th>
						<th>Результат</th>
					</tr>
					</thead>
					<tbody data-w="text"><div>
						{foreach from=$text_err item=text}
							<tr data-id="">
								<td>
									{$text.fio}
								</td>
								<td>
									{$text.name}
								</td>
								<td>
									{$text.mobile}
								</td>
								<td>
									{$text.email}
								</td>
								<td class="center">
									{$text.manager}
								</td>
								<td>
									{$text.result}
								</td>

							</tr>

						{/foreach}
					</div></tbody>
				</table></div>
		</div></div>



{/if}
