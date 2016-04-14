<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title>{$title}</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="Author" content="" />

		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

		<!-- WEB FONTS : use %7C instead of | (pipe) -->
		<link href="assets/css/web_fonts.css" rel="stylesheet" type="text/css" />
		
		<!-- CORE CSS -->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />

		<!-- PAGE LEVEL SCRIPTS -->
		<link href="assets/css/header-1.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
		
	
	</head>


	<body class="smoothscroll enable-animation">

		<!-- SLIDE TOP -->
		<div id="slidetop">

			<div class="container">
				
				<div class="row">

					<div class="col-md-4">
						<h6><i class="fa fa-heart-o" aria-hidden="true"></i>Что это за проект и для чего он нужен?</h6>
						<p>Что бы вести более простой учет клиентов и звонков к ним.</p>
					</div>

					<div class="col-md-4">
						<h6><i class="fa fa-paperclip"></i> Что еще?</h6>
						<ul class="list-unstyled">
							<li><a href="#"><i class="fa fa-angle-right"></i> Мы постоянно что-то обновляем</a></li>
							<li><a href="#"><i class="fa fa-angle-right"></i> Ждем от вас фидбек и критику</a></li>
							<li><a href="#"><i class="fa fa-angle-right"></i> Попробуйте!</a></li>
							<li><a href="#"><i class="fa fa-angle-right"></i> ...</a></li>
							<li><a href="#"><i class="fa fa-angle-right"></i> PROFIT!</a></li>
						</ul>
					</div>

					<div class="col-md-4">
						<h6><i class="icon-envelope"></i> Контакты</h6>
						<ul class="list-unstyled">
							<li><b>Адрес:</b> г. Самара, ул. Мичурина 19В  <br /> этаж 2, кабинет 205, стол слева</li>
							<li><b>Телефон:</b> (0521) 397</li>
							<li><b>Email:</b> <a href="mailto:svdodonov@alfabank.ru">svdodonov@alfabank.ru</a></li>
						</ul>
					</div>

				</div>

			</div>

			<a class="slidetop-toggle" href="#"><!-- toggle button --></a>

		</div>
		<!-- /SLIDE TOP -->


		<!-- wrapper -->
		<div id="wrapper">

		
			<!-- Top Bar -->
			<div id="topBar">
				<div class="container">

					<!-- right -->
					<ul class="top-links list-inline pull-right">
						{if $CURUSER}
						<li class="text-welcome">Приветствуем в Smarty, <strong>{$CURUSER['name']}</strong></li>
						<li>
							<a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><i class="fa fa-user hidden-xs"></i> Мой аккаунт</a>
							<ul class="dropdown-menu">
								<li><a tabindex="-1" href="message.php"><i class="fa fa-envelope-o"></i> Сообщения (<b>{$CURUSER.unread|@count}</b>)</a></li>
								{*<li><a tabindex="-1" href="#"><i class="fa fa-history"></i> История</a></li>*}
								<li class="divider"></li>
								{*<li><a tabindex="-1" href="#"><i class="fa fa-bookmark"></i> Закладки</a></li>
								<li><a tabindex="-1" href="userdetails.php"><i class="fa fa-edit"></i> Мой профиль</a></li>*}
								<li><a tabindex="-1" href="my_setting.php"><i class="fa fa-cog"></i> Мои настройки</a></li>
								<li class="divider"></li>
								<li><a tabindex="-1" href="logout.php"><i class="glyphicon glyphicon-off"></i> Выйти</a></li>
							</ul>
						</li>
						{else}
						<li><a href="login.php">Войти</a></li>
						{/if}
					</ul>

					<!-- left -->
					<ul class="top-links list-inline">
						<li><a href="faq.php">FAQ</a></li>
					</ul>

				</div>
			</div>
			<!-- /Top Bar -->

			<div id="header" class="sticky clearfix">

				<!-- TOP NAV -->
				<header id="topNav">
					<div class="container">

						<!-- Mobile Menu Button -->
						<button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
							<i class="fa fa-bars"></i>
						</button>

						<!-- BUTTONS -->
						<ul class="pull-right nav nav-pills nav-second-main">

							<!-- SEARCH -->
							<li class="search">
								<a href="javascript:;">
									<i class="fa fa-search"></i>
								</a>
								<div class="search-box">
									<form action="search.php" method="get">
										<div class="input-group "  data-minLength="1"  data-queryURL="elements/ajax.php?action=search&search=">
											<input type="text" name="s" placeholder="Поиск" class="form-control typeahead" />
											<span class="input-group-btn">
												<button class="btn btn-primary" type="submit">Найти</button>
											</span>
										</div>
									</form>
								</div> 
							</li>
							<!-- /SEARCH -->

						</ul>
						<!-- /BUTTONS -->

						<!-- Logo -->
						<a class="logo pull-left" href="{$REL_CONFIG.defaultbaseurl}">
							<img src="assets/images/logo_dark.png" alt="" />
						</a>

						<!-- 
							Top Nav 
							
							AVAILABLE CLASSES:
							submenu-dark = dark sub menu
						-->
						<div class="navbar-collapse pull-right nav-main-collapse collapse submenu-dark">
							<nav class="nav-main">

								<!--
									NOTE
									
									For a regular link, remove "dropdown" class from LI tag and "dropdown-toggle" class from the href.
									Direct Link Example: 

									<li>
										<a href="#">HOME</a>
									</li>
								-->
								<ul id="topMain" class="nav nav-pills nav-main">
									<!-- HOME -->
									<li>
										<a href="index.php">
											Главная
										</a>
									</li>
									{if $CURUSER.add_client}
									<!-- CLIENTS -->
									<li class="dropdown">
										<a class="dropdown-toggle" href="#">
											Клиенты
										</a>
										<ul class="dropdown-menu">
											<li><a href="client.php">Список клиентов</a></li>
											<li><a href="client.php?a=a">Добавить клиента</a></li>
										{if $IS_HEAD}<li><a href="client.php?a=upload">Массовая загрузка</a></li>{/if}
										</ul>
									</li>
									{/if}
									{if $CURUSER.use_card}
										<!-- CLIENTS -->
										<li class="dropdown">
											<a class="dropdown-toggle" href="#">
												Карты
											</a>
											<ul class="dropdown-menu">
												<li><a href="card.php">Список карт</a></li>
												<li><a href="card.php?action=add">Добавить карту</a></li>
												{if $IS_HEAD}<li><a href="card.php?action=upload">Массовая загрузка</a></li>{/if}
											</ul>
										</li>
									{/if}
									{if $IS_POWER_USER AND $CURUSER.add_client}
									<!-- STATISTICS -->
									<li class="dropdown">
										<a class="dropdown-toggle" href="#">
											Статистика
										</a>
										<ul class="dropdown-menu">
											<li><a href="statistic.php"><i class="et-expand"></i> Общая</a></li>
											<li><a href="statistic.php?type=department"><i class="et-expand"></i> По отделению</a></li>
											 {if $IS_HEAD}<li><a href="statistic.php?type=manager"><i class="et-grid"></i> По менеджерам</a></li>{/if}
										</ul>
									</li>
									{/if}

									{if $CURUSER.add_user}
									<!-- USERS -->
									<li class="dropdown">
										<a class="dropdown-toggle" href="#">
											Пользователи
										</a>
										<ul class="dropdown-menu">
											<li><a href="user.php">Список пользователей</a></li>
											<li><a href="user.php?a=a">Добавить пользователя</a></li>
										</ul>
									</li>
									{/if}
									{if $IS_ADMINISTRATOR}
									<!-- ADMINISTRATOR -->
									<li class="dropdown active">
										<a class="dropdown-toggle" href="#">
											Панель администратора
										</a>
										<ul class="dropdown-menu">
											<li><a href="admincp.php">Настройки</a></li>
										</ul>
									</li>
									{/if}
									<!-- COMMENT -->
									<!--<li class="dropdown mega-menu">
										<a class="dropdown-toggle" href="#">
											Зарезервировано
										</a>
										<ul class="dropdown-menu">
										</ul>
									</li>-->
								</ul>

							</nav>
						</div>

					</div>
				</header>
				<!-- /Top Nav -->

			</div>


			<!-- 
				PAGE HEADER 
				
				CLASSES:
					.page-header-xs	= 20px margins
					.page-header-md	= 50px margins
					.page-header-lg	= 80px margins
					.page-header-xlg= 130px margins
					.dark			= dark page header

					.shadow-before-1 	= shadow 1 header top
					.shadow-after-1 	= shadow 1 header bottom
					.shadow-before-2 	= shadow 2 header top
					.shadow-after-2 	= shadow 2 header bottom
					.shadow-before-3 	= shadow 3 header top
					.shadow-after-3 	= shadow 3 header bottom
			-->
			<section class="page-header dark page-header-xs">
				<div class="container">

					<h1>{$title}</h1>

					{*<!-- breadcrumbs -->
					<ol class="breadcrumb">
						<li><a href="#">Home</a></li>
						<li><a href="#">Blog</a></li>
						<li class="active">Both Sidebar</li>
					</ol><!-- /breadcrumbs -->
*}
				</div>
			</section>
			<!-- /PAGE HEADER -->
			<section>
				<div class="container"> <!-- class container-fluid-->

					<div class="row">
					<!-- LEFT -->
<!--<div class="col-md-2 col-sm-2">
        {show_blocks('l')}
	</div>-->
	<!-- CENTER -->
<div class="col-md-12 col-sm-12">
{show_blocks('t')}