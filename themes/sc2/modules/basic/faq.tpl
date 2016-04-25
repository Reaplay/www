

	<!-- FILTER -->
	<ul class="nav nav-pills mix-filter margin-bottom-30">
		<li class="filter active" data-filter="all"><a href="#">Все</a></li>
		<li class="filter" data-filter="client"><a href="#">Клиенты</a></li>
		<li class="filter" data-filter="card"><a href="#">Карты</a></li>
		<li class="filter" data-filter="user"><a href="#">Пользователи</a></li>
	</ul>
	<!-- /FILTER -->

	<div class="row mix-grid">

		<!-- LEFT COLUMNS -->
		<div class="col-md-9">

			<!-- TOGGLES -->
			<div class="toggle toggle-transparent toggle-bordered-simple" style="   ">
				{foreach from=$data_faq item=faq}
				<div class="toggle mix {$faq.type} mix_all" style=" display: block; opacity: 1;"><!-- toggle -->
					<label>{counter}. {$faq.title}</label>
					<div class="toggle-content" style="display: none;">

						<p class="clearfix">
							{$faq.text}
							
						</p>
						<div class="border-top-1 padding-10">
							<span class="pull-left size-11 margin-top-3 text-muted">Вопрос добавлен: {$faq.added} (Последние изменение: {$faq.edited})</span>

						</div>
					</div>
				</div><!-- /toggle -->
				{/foreach}


			</div>
			<!-- /TOGGLES -->

			<!-- CALLOUT -->
			<div class="callout alert alert-border margin-top-60 margin-bottom-60">

				<div class="row">

					<div class="col-md-9 col-sm-12"><!-- left text -->
						<h4>Нет нужного ответа? Звоните <strong>(0521) 397</strong></h4>
						<p class="font-lato size-17">
							Данная страница будет обновляться
						</p>
					</div><!-- /left text -->


					<div class="col-md-3 col-sm-12 text-right"><!-- right btn -->
						<a  class="btn btn-default btn-lg"href="mailto:{$REL_CONFIG.adminemail}">Написать письмо</a>

					</div><!-- /right btn -->

				</div>

			</div>
			<!-- /CALLOUT -->

		</div>
		<!-- /LEFT COLUMNS -->

		<!-- RIGHT COLUMNS -->
		<div class="col-md-3">

			<!-- POPULAR QUESTIONS -->
			<h4><strong>Poular</strong> Topics</h4>
			<p><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet.</em></p>

			<hr>

			<ul class="list-unstyled"><!-- block 1 -->
				<li><a href="#">Lorem ipsum dolor sit amet</a></li>
				<li><a href="#">Consectetur adipiscing elit</a></li>
				<li><a href="#">Quisque rutrum pellentesque</a></li>
			</ul><!-- /block 1 -->

			<hr>

			<!-- ASK A QUSTION -->
			<h4><strong>Ask</strong> a question</h4>
			<form class="sky-form clearfix" method="post" action="#">

				<label class="input">
					<i class="ico-prepend fa fa-user"></i>
					<input type="text" placeholder="Name">
				</label>

				<label class="input">
					<i class="ico-prepend fa fa-envelope"></i>
					<input type="text" placeholder="Email">
				</label>

				<label class="textarea">
					<i class="ico-prepend fa fa-comment"></i>
					<textarea placeholder="Type your question..." rows="3"></textarea>
				</label>

				<button class="btn btn-primary btn-sm pull-right">SUBMIT YOUR QUESTION</button>

			</form>

			<hr>

			<!-- FLICKR WIDGET -->
			<h4 class="size-16 margin-bottom-10"><strong>Flickr</strong> Photo</h4>
			<div data-limit="8" data-id="37304598@N02" class="widget-flickr clearfix lightbox margin-bottom-60"><li><a title="DSC_0660" href="http://farm4.staticflickr.com/3647/3435384001_9ed9864bb4.jpg"><img height="63" width="63" alt="DSC_0660" src="http://farm4.staticflickr.com/3647/3435384001_9ed9864bb4_s.jpg"></a></li><li><a title="DSC_0698" href="http://farm4.staticflickr.com/3311/3436188742_caaa28c689.jpg"><img height="63" width="63" alt="DSC_0698" src="http://farm4.staticflickr.com/3311/3436188742_caaa28c689_s.jpg"></a></li><li><a title="DSC_0668" href="http://farm4.staticflickr.com/3371/3436188466_418a0d8a06.jpg"><img height="63" width="63" alt="DSC_0668" src="http://farm4.staticflickr.com/3371/3436188466_418a0d8a06_s.jpg"></a></li><li><a title="DSC_0704" href="http://farm4.staticflickr.com/3397/3436188128_5e503cefcd.jpg"><img height="63" width="63" alt="DSC_0704" src="http://farm4.staticflickr.com/3397/3436188128_5e503cefcd_s.jpg"></a></li><li><a title="DSC_0699" href="http://farm4.staticflickr.com/3300/3436187796_4d228a5bde.jpg"><img height="63" width="63" alt="DSC_0699" src="http://farm4.staticflickr.com/3300/3436187796_4d228a5bde_s.jpg"></a></li><li><a title="DSC_0602" href="http://farm4.staticflickr.com/3386/3435382439_68b5e3742b.jpg"><img height="63" width="63" alt="DSC_0602" src="http://farm4.staticflickr.com/3386/3435382439_68b5e3742b_s.jpg"></a></li><li><a title="DSC_0603" href="http://farm4.staticflickr.com/3657/3436187288_e84058f54b.jpg"><img height="63" width="63" alt="DSC_0603" src="http://farm4.staticflickr.com/3657/3436187288_e84058f54b_s.jpg"></a></li><li><a title="DSC_0604" href="http://farm4.staticflickr.com/3405/3436187010_c731dea9a3.jpg"><img height="63" width="63" alt="DSC_0604" src="http://farm4.staticflickr.com/3405/3436187010_c731dea9a3_s.jpg"></a></li></div>

		</div>
		<!-- /RIGHT COLUMNS -->

	</div>

	{*

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

*}