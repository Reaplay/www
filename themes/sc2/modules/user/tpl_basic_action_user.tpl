{if !$IS_POWER_HEAD}
<div class="alert alert-warning margin-bottom-30">
<!-- WARNING -->
	<strong>Внимание!</strong> Пользователь будет привязан к вашему отделению.
</div>
{/if}

<!-- register form -->
<form class="<!--validate--> nomargin sky-form boxed" action="user.php?a=c" method="post">
	<header>
		<i class="fa fa-users"></i> {if $data_user}Редактирование пользователя{else}Регистрация нового пользователя{/if}
		</header>

	<fieldset class="nomargin">
	
		<div class="row margin-bottom-10">
			<div class="col-md-6">
				<label class="input margin-bottom-10">
					<i class="ico-append fa fa-user"></i>
					<input class="form-control required" type="text" name="login" placeholder="Логин" value="{$data_user.login}" {if $data_user}disabled{/if}>
					<b class="tooltip tooltip-bottom-right">Необходимо для входа в систему</b>
				</label>
			</div>
			<div class="col col-md-6">
				<label class="input">
					<i class="ico-append fa fa-user"></i>
					<input class="form-control required" type="text" name="name" placeholder="ФИО пользователя" value="{$data_user.name}">
					<b class="tooltip tooltip-bottom-right">Минимум 5 символов</b>
				</label>
			</div>
		</div>

		
		<div class="row margin-bottom-10">
			<div class="col-md-6">
				<label class="input margin-bottom-10">
					<i class="ico-append fa fa-lock"></i>
					<input class="form-control {if !$data_user}required{/if}" type="password" name="password" placeholder="Пароль">
					<b class="tooltip tooltip-bottom-right">{if $data_user}Заполнять только если изменяете пароль{else}Только латинские буквы, цифры или спецсимвол "_"{/if}</b>
				</label>
			</div>
			{*
			<div class="col col-md-6">
				<label class="input margin-bottom-10">
					<i class="ico-append fa fa-lock"></i>
					<input type="password" placeholder="Confirm password">
					<b class="tooltip tooltip-bottom-right">Только латинские буквы и цифры</b>
				</label>
			</div>
			*}
		</div>
		


		

		<div class="row margin-bottom-10">
		{if $list_department}
			<div class="col-md-6" >
				<div class="fancy-form fancy-form-select">
					<select class="form-control select2 pointer required" name="department">
					<option value="---">Отделение</option>
					{$list_department}
					</select>
					<i class="fancy-arrow"></i>
				</div>
			</div>
		{/if}
			<div class="col col-md-6">
				<div class="fancy-form fancy-form-select">
					<select class="form-control select2  pointer required" name="class">
					<option value="---">Уровень доступа</option>
						{$p_class}
					</select>
					<i class="fancy-arrow"></i>
				</div>
				
			</div>
		</div>


		
		<div class="margin-top-30">
			<label class="checkbox nomargin"><input type="checkbox" name="add_client" {if $data_user.add_client or !$data_user}checked="checked"{/if}><i></i>Добавляет новых клиентов</a></label>
			<label class="checkbox nomargin"><input type="checkbox" name="add_user"{if $data_user.add_user}checked="checked"{/if}><i></i>Добавляет новых пользователей</label>
			<label class="checkbox nomargin"><input type="checkbox" name="use_card"{if $data_user.use_card}checked="checked"{/if}><i></i>Выдача карт (СОКР)</label>
			<label class="checkbox nomargin"><input type="checkbox" name="only_view"{if $data_user.only_view}checked="checked"{/if}><i></i>Только просмотр</label>
		</div>
	</fieldset>

	<div class="row margin-bottom-20">
		<div class="col-md-12">
			<input type="hidden" name = "id" value="{$data_user.id}">
			<input type="hidden" value="false" name="is_ajax">
			<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {if $data_user}Изменить{else}Добавить{/if}</button>
		</div>
	</div>

</form>
<!-- /register form -->
