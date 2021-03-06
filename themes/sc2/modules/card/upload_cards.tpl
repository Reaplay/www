<div class="alert alert-danger margin-bottom-30">
	<strong>Внимание</strong> В зависимости от заполнености файла, все загруженные карты могут быть прикреплены к вашей учетной записи.<br>
	Инструкция по загрузке: <a href="{$REL_CONFIG.defaultbaseurl}/page.php?id=1">Посмотреть</a> | <a href="{$REL_CONFIG.defaultbaseurl}/manual/manual_upload.docx">Скачать</a><br>
	Шаблон для загрузки: <a href="{$REL_CONFIG.defaultbaseurl}/manual/shablon_upload_card.csv">Скачать</a>
</div>

<form enctype="multipart/form-data" action="card.php?action=upload_cards&type=upload_cards" method="POST" accept-charset="utf-8">
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

						<th>Карта</th>
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
									{$text.cobrand_id}
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
