{*<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме
</div>
*}
<div class="col-lg-3 col-md-3 col-sm-4">


	<ul class="nav nav-tabs nav-stacked">
		<li {if $t==view}class="active"{/if}>
			{if $t==view}<a href="#tab_a" data-toggle="tab">{else}<a href="client.php?a=view&id={$id}">{/if}<i class="fa fa-eye"></i> Профиль</a>
		</li>
		<li {if $t==history}class="active"{/if}>
			<a href="client.php?a=callback_history&id={$id}"><i class="fa fa-history"></i> История контактов</a>
		</li>
		{if $CURUSER.only_view}
		<li {if $t==callback}class="active"{/if}>
			<a href="client.php?a=callback&amp;id={$id}" ><i class="fa fa-plus"></i> Добавить контакт</a>
		</li>
		<li>
			<a href="client.php?a=e&amp;id={$id}" tabindex="-1"><i class="fa fa-pencil-square-o"></i>Редактировать</a>
		</li>
		{/if}
		{*{if $t==view}*}
		{if $IS_HEAD}
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Действия<span class="caret"></span></a>
			<ul class="dropdown-menu">
				

				<li><a href="#change_mgr" tabindex="-1" data-toggle="tab">Сменить менеджера</a></li>
				<li><a href="client.php?a=delete&amp;id={$id}" tabindex="-1">Удалить</a></li>

			</ul>
		</li>
		{/if}
	</ul>

</div>


	