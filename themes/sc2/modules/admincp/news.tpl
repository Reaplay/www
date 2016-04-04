{if $warning}
<div class="alert alert-default margin-bottom-30">
	{$warning}
</div>
{/if}

<form action="action_admin.php?module=news&action={if $data_news}edit&newsid={$data_news.id}{else}add{/if}" method="post" class="block-review-content">
	<div class="fancy-form">
		<i class="fa fa-newspaper-o"></i>

		<input name="subject" type="text" class="form-control" placeholder="Тема новости" value="{$data_news.subject}">

		<!-- tooltip - optional, bootstrap tooltip can be used instead -->
		<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
			<em>Введите тему</em>
		</span>
	</div>
	<textarea name="body" class="summernote form-control" data-height="200" data-lang="en-US">{$data_news.body}</textarea>
	<button class="btn btn-3d btn-sm btn-reveal btn-teal">
		<i class="fa fa-check"></i>
		<span>{if $data_news}Изменить{else}Разместить{/if} новость</span>
	</button>

</form>

