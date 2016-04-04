{foreach from=$data_news item=news}
<h3 class="hidden-xs size-16 margin-bottom-20">{$news.title}</h3>
	<div class="row tab-post">
		<div class="col-md-12 col-sm-12 col-xs-12">
			{$news.subject}
			<small>{$news.date} {if $IS_POWER_HEAD}[<a href="action_admin.php?module=news&amp;action=edit&amp;newsid=4"><b>E</b></a>][<a onclick="return confirm('Вы уверены?');" href="action_admin.php?module=news&amp;action=delete&amp;newsid=4"><b>D</b></a>] {/if}</small>
		</div>
	</div>
{/foreach}

