</div>					
					<!-- RIGHT -->

					<!--	<div class="col-md-2 col-sm-2 ">
						{show_blocks('r')}
						</div>
					-->
					</div>





				</div>
			</section>
			<!-- / -->


			<!-- FOOTER -->
			<footer id="footer">
				
				<div class="copyright">
					<div class="container">
						<ul class="pull-right nomargin list-inline mobile-block">
							<li><a href="faq.php">Список вопросов</a></li>
							<li>&bull;</li>
							<li><a href="changelog.php">Список изменений</a></li>
						</ul>
						{$COPYRIGHT}
					</div>
				</div>
			</footer>
			<!-- /FOOTER -->
		
		</div>
		<!-- /wrapper -->


		<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>


		<!-- PRELOADER -->
		<div id="preloader">
			<div class="inner">
				<span class="loader"></span>
			</div>
		</div><!-- /PRELOADER -->


		<!-- JAVASCRIPT FILES -->
		{literal}
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>

		<script type="text/javascript" src="assets/js/scripts.js"></script>
		{/literal}

			{if $CURUSER.unread|@count > 0 AND $CURUSER['notifs']!= 'no_notify'}
			<script type="text/javascript">_toastr("У вас {$CURUSER.unread|@count} не прочитанных сообщений","top-right","info",false);</script>
			{/if}
		<!-- STYLESWITCHER - REMOVE 
		<script async type="text/javascript" src="assets/plugins/styleswitcher/styleswitcher.js"></script>-->
		

		{$js_add}

	</body>
</html>