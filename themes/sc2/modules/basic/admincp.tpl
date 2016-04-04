{if $IS_ADMINISTRATOR}
<div class="heading-title heading-dotted text-center">
	<h6><span>Администраторское меню</span></h6>
</div>
<div class="row">
	<div class="col-md-5th">
		<h4>Работа с базой</h4>
		<a href="action_admin.php?module=mysqlstats">MySQL status</a>
	</div>

	<div class="col-md-5th">

	</div>

	<div class="col-md-5th">

	</div>

	<div class="col-md-5th">
		<a href="action_admin.php?module=department">Отделения</a><br />
	</div>

	<div class="col-md-5th">
		<h4>Прочее</h4>
		<a href="action_admin.php?module=pollsadmin">Опрос</a><br />
		<a href="action_admin.php?module=poll_admin">Общий опрос (не пользователей)</a><br />
		<a href="action_admin.php?module=changelog">ChangeLog</a><br />
		<a href="action_admin.php?module=configadmin">Configure</a>
	</div>
</div>

{/if}
{if $IS_POWER_HEAD}

<div class="heading-title heading-dotted text-center">
	<h6><span>Меню общих настроек</span></h6>
</div>
<div class="row">
	<div class="col-md-5th">
		<h4>Новости</h4>
		<a href="action_admin.php?module=news">Добавить новость</a> <br /> <a href="action_admin.php?module=newsarchive">Показать все новости</a>
	</div>

	<div class="col-md-5th">
		<h4>Настройки банка</h4>
		<a href="action_admin.php?module=product_bank">Продукты</a><br />
		<a href="action_admin.php?module=result_call">Результаты контакта</a>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>
</div>

{/if}
{if $IS_HEAD}
<div class="heading-title heading-dotted text-center">
	<h6><span>Запасное меню</span></h6>
</div>
<div class="row">
	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>

	<div class="col-md-5th">
		<h4>Five Columns</h4>
	</div>
</div>
{/if}