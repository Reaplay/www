<div class="panel panel-default">
	<div class="panel-heading panel-heading-transparent">
		<h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} отделение</h2>
	</div>
	<div class="panel-body">
		<form method="post" action="action_admin.php?module=department{if $action=="edit"}&id={$id}{/if}">
			<div class="row">
				<div class="form-group">
					<div class="col-md-6 col-sm-6">
						<label>Название отделения</label>
						<input type="text" name="name" class="form-control" placeholder="Введите название отделения" value="{$data_department.name}">
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Подчиняется</label>
						<div class="fancy-form fancy-form-select">
								<select class="form-control  select2" name="id_parent">
								{$data_department_parents}
								</select>
								<i class="fancy-arrow"></i>
							</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-3d btn-teal btn-slg btn-block" type="submit">
						{if $action=="add"}Добавить{else}Изменить{/if}
					</button>
					<input type="hidden" name="action" value="{$action}">
				</div>
			</div>

	</div>

			</div>
		
		</form>
	</div>
</div>