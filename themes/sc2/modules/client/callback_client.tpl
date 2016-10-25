<div class="col-lg-9 col-md-9 col-sm-8">
	<div class="tab-content tab-stacked">
		<div>


<form class="nomargin sky-form boxed" action="client.php?a=callback" method="post">
	<header>
		<i class="fa fa-users"></i> Добавление контакта с  клиентом
	</header>

	<fieldset class="nomargin">
	
		<div class="row">
			<div class="col-xs-2">
				Тип контакта *
			</div>
			<div class="col-xs-4">
				<div class="fancy-form fancy-form-select">
					<select class="form-control  select2" name="type_contact" onchange="load_r_call(this)">
						<option value="0">Выберите тип контакта</option>
						<option value="1">Исходящий звонок</option>
						<option value="2">Встреча</option>
						<option value="3">Рекомендации</option>

					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">
				Результат *
			</div>
			<div class="col-xs-6">
				<div class="fancy-form fancy-form-select">

					<select name="result_call" class="form-control  select2">
						<option value="0">Выберите контакт</option>
						{*$result*}
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		</div>


		<div class="row">
		<div class="col-xs-2">
			Продукты
		</div>
		<div class="col-xs-10">
			{$product}
		</div>
	</div>
		<div class="row">
		<div class="col-xs-2">
			Дата будущего контакта *
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control datepicker required" data-format="dd/mm/yyyy" data-lang="ru" data-RTL="false" name="next_call">
		</div>
	</div>
	{if !$data_client.equid}
	<div class="row">
		<div class="col-xs-2">
			EQ ID
		</div>
		<div class="col-xs-6">
			<label class="input">
				<i class="ico-prepend fa fa-key"></i>
				<input class="form-control" type="text" name="equid" placeholder="EQ UID" value="">
				<b class="tooltip tooltip-bottom-left">Назначенный EQUID</b>
			</label>
		</div>
	</div>
	{/if}
		<div class="row">
			<div class="col-xs-2">
				Статус клиента
			</div>
			<div class="col-xs-6">
				<div class="fancy-form fancy-form-select">

					<select name="status" class="form-control  select2">
						<option value="0">Не клиент</option>
						<option value="1">Клиент</option>
						<option value="2">Отказной</option>
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">
				Не звонить
			</div>
			<div class="col-xs-6">
				<div class="fancy-form">

					<label class="checkbox nomargin"><input type="checkbox" name="dont_call"{if $data_client.dont_call}checked="checked"{/if}><i></i>Да</label>

				</div>
			</div>
		</div>
		<div class="row">
		<div class="form-group">
			<div class="col-md-12 col-sm-12">
				<label>Комментарий</label>
				<textarea name="comment" rows="4" class="form-control required"></textarea>
			</div>
		</div>
	</div>
	</fieldset>

	<div class="row margin-bottom-20">
		<div class="col-md-12">
			<input type="hidden" name="id" value="{$id}">
			<input type="hidden" name="action" value="add">
			{if $return_url}<input type="hidden" name="return_url" value="{$return_url}">{/if}
			<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Добавить</button>
		</div>
	</div>

</form>
</div>
</div>
</div>
