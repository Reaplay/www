<div class="panel panel-default">
	<div class="panel-heading panel-heading-transparent">
		<h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} продукт</h2>
	</div>
	<div class="panel-body">
		<form method="post" action="action_admin.php?module=product_bank{if $action=="edit"}&id={$id}{/if}">
			<div class="row">
				<div class="form">
					<div class="col-md-6 col-sm-6">
						<input type="text" name="name" class="form-control" placeholder="Введите название продукта" value="{$data_product.name}">
					</div>
					<div class="col-md-6 col-sm-6">
						<button type="submit" class="btn btn-primary" type="submit">{if $action=="add"}Добавить{else}Изменить{/if}</button>
						<input type="hidden" name="action" value="{$action}">
					</div>
				</div>
			</div>
		
		</form>
	</div>
</div>