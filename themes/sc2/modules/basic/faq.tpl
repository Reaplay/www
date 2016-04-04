<p class="lead">Здесь собраны ответы на самые популярные вопросы. Наверное.</p>

<div class="divider divider-center divider-color nomargin-top margin-bottom-80"><!-- divider -->
	<i class="fa fa-chevron-down"></i>
</div>

<div class="columnize-2">
	
{foreach from=$data_faq item=faq}
	<h2 class="size-20">{$faq.title}</h2>
	<p>
		{$faq.text}
	</p>

	
	
{/foreach}


</div>

<!-- FEEDBACK -->
<div class="callout alert alert-border margin-top-60 margin-bottom-60">

	<div class="row">

		<div class="col-md-9 col-sm-12"><!-- left text -->
			<h4>Не нашли ответ на ваш вопрос? <strong>Пишите</strong> и быть может мы ответим!</h4>
			<p class="font-lato size-17">
				Если не сильно заняты
			</p>
		</div><!-- /left text -->

		
		<div class="col-md-3 col-sm-12 text-right"><!-- right btn -->
			<a href="#" class="btn btn-default btn-lg">Написать</a>
		</div><!-- /right btn -->

	</div>

</div>
<!-- /FEEDBACK -->

