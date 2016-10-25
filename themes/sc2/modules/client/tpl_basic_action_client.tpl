{if !$IS_HEAD}
<div class="alert alert-warning margin-bottom-30">
<!-- WARNING -->
	<strong>Внимание!</strong> Клиент будет привязан к вашему профилю
</div>
{/if}

<!-- register form -->
<form class="<!--validate--> nomargin sky-form boxed" action="client.php?a=c" method="post">
	<header>
		<i class="fa fa-users"></i> {if $data_client}Редактирование{else}Регистрация нового{/if} клиента
		</header>

	<fieldset class="nomargin">
	
		<div class="row margin-bottom-10">
			<div class="col-md-6">
				<label class="input">
					<i class="ico-append fa fa-user"></i>
					<input class="form-control required" type="text" name="name" placeholder="ФИО клиента" value="{$data_client.name}">
					<b class="tooltip tooltip-bottom-right">Не меньше 5 мимволов</b>
				</label>
			</div>
			<div class="col col-md-6">
				<label class="input">
					<i class="ico-prepend fa fa-key"></i>
					<input class="form-control" type="text" name="equid" placeholder="EQ UID" value="{$data_client.equid}">
					<b class="tooltip tooltip-bottom-left">Значение из эквейжена, если есть</b>
				</label>
			</div>
		</div>

		
		<div class="row margin-bottom-10">
			<div class="col-md-6">
				<label class="input">
					<i class="ico-append fa fa-phone-square"></i>
					<input type="text" class="form-control masked required" data-format="+9 (999) 999-99-99" data-placeholder="{$data_client.mobile}" placeholder={if !$data_client.mobile}"Номер сотового телефона"{else}"Нажмите для отображения"{/if} name="mobile" value="{$data_client.mobile}">
					<b class="tooltip tooltip-bottom-right">Введите номер сотового телефона</b>
				</label>

			</div>
			<div class="col col-md-6">
				<label class="input">
					<i class="ico-prepend fa fa-envelope-o"></i>
					<input type="email" name="email" value="{$data_client.email}" class="form-control" placeholder="Электропочта">
					
				</label>
			</div>
		</div>
		
		<div class="row margin-bottom-10">
			<div class="col-md-6">
				<label class="input">
					<i class="ico-append fa fa-birthday-cake"></i>
					<input type="text" name="birthday" class="form-control masked" data-format="99/99/9999" data-placeholder="{$data_client.birthday}" placeholder={if !$data_client.birthday}"День рождения"{else}"Нажмите для отображения"{/if} value="{$data_client.birthday}">
					<b class="tooltip tooltip-bottom-right">ДД/ММ/ГГГГ</b>
				</label>
			</div>
			<div class="col col-md-6">
				<div class="fancy-form fancy-form-select">
					<select class="form-control select2 pointer required" name="gender">
						<option value="---">Выберите пол</option>
						<option value="1" {if $data_client.gender == "1"} selected = "selected"{/if}>Мужской</option>
						<option value="2" {if $data_client.gender == "2"} selected = "selected"{/if}>Женский</option>
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		</div>		


		

		<div class="row margin-bottom-10">
		{if $IS_HEAD}
			<div class="col-md-6">
				<div class="fancy-form  fancy-form-select">
					<select class="form-control select2 pointer required" name="manager">
						<option value="---">Выберите менеджера</option>
						{$manager}
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		{/if}
		
			<div class="col-md-6">
				<div class="fancy-form fancy-form-select">
					<select class="form-control select2 pointer required" name="status">
						<option value="---">Статус клиента</option>
						<option value="0" {if $data_client.status == "0"} selected = "selected"{/if}>Не клиент</option>
						<option value="1" {if $data_client.status == "1"} selected = "selected"{/if}>Клиент</option>
						<option value="2" {if $data_client.status == "2"} selected = "selected"{/if}>Отказной</option>
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		
		</div>
		<div class="margin-bottom-30">
			<label class="checkbox nomargin"><input type="checkbox" name="vip"{if $data_client.vip}checked="checked"{/if}><i></i>VIP-клиент</label>
			<label class="checkbox nomargin"><input type="checkbox" name="dont_call"{if $data_client.dont_call}checked="checked"{/if}><i></i>Не звонить</label>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-12 col-sm-12">
					<label>Комментарий</label>
					{*<textarea class="summernote form-control" data-height="200" data-lang="en-US" name="comment">{$data_client.comment}</textarea>*}
					<textarea name="comment" rows="4" class="form-control required">{$data_client.comment}</textarea>
				</div>
			</div>
		</div>

		

	</fieldset>

	<div class="row margin-bottom-20">
		<div class="col-md-12">
			{if $data_client.id}
			<input type="hidden" name = "id" value="{$data_client.id}">
			{/if}
			<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {if $data_client}Изменить{else}Добавить{/if}</button>
		</div>
	</div>

</form>
<!-- /register form -->
