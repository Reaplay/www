<div class="alert alert-success margin-bottom-30">
	<strong>Внимание</strong> Выбираете тип контакта и к нему привязываете результат
</div>
<div class="panel panel-default">
	<div class="panel-heading panel-heading-transparent">
		<h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} контакт</h2>
	</div>

	<div class="panel-body">
		<form method="post" action="action_admin.php?module=result_call{if $action=="edit"}&id={$id}{/if}">
			<div class="row">
				<div class="form">
					<div class="col-md-4 col-sm-4">
							<div class="fancy-form fancy-form-select">
								<select class="form-control  select2" name="type_contact">
								{$data_contact}
								</select>
								<i class="fancy-arrow"></i>
							</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<input type="text" name="text" class="form-control" placeholder="Введите название контакта" value="{$data_result_call.text}">
					</div>
				
					<div class="col-md-4 col-sm-4">
						<button type="submit" class="btn btn-primary" type="submit">{if $action=="add"}Добавить{else}Изменить{/if}</button>
						<input type="hidden" name="action" value="{$action}">
					</div>
				</div>
			</div>
		
		</form>
	</div>
</div>