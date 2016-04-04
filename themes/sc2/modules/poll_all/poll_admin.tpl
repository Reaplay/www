<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме
</div>
	<a href="action_admin.php?module=poll_admin&action=step1"><button type="button" class="btn btn-primary btn-lg btn-block">Добавить опрос</button></a>
<hr>
{if $data_poll}
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Опрос</th>
				<th>Создан</th>
				<th>Заканчивается</th>
				<th>Статус</th>
				<th>Действия</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$data_poll item=poll}
			<tr>
				<td>{$poll.name}</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>
					<a href="#" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> Edit </a>
					<a href="#" class="btn btn-default btn-xs"><i class="fa fa-times white"></i> Delete </a>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</div>
{else}
<div class="alert alert-mini alert-warning margin-bottom-30">
	Опросы не проводились
</div>
{/if}{*
<table width="100%" border="1"><tr><td>Опрос</td><td>Создан</td><td>Заканчивается</td><td>Ред / Уд</td></tr>

<tr><td><a href="'.$REL_SEO->make_link('polloverview','id',$poll['id']).'">'.$poll['question'].'</a></td><td>'.mkprettytime($poll['start']).'</td><td>'.(!is_null($poll['exp'])?(($poll['exp']< time())?mkprettytime($poll['exp'])." (закрыт)":mkprettytime($poll['exp'])):"Бесконечен")."</td><td><a href=\"".$REL_SEO->make_link('poll_admin','action','edit','id',$poll['id'])."\">E</a> / <a onClick=\"return confirm('Вы уверены?')\" href=\"".$REL_SEO->make_link('poll_admin','action','delete','id',$poll['id'])."\">D</a></td></tr>


</table>
*}