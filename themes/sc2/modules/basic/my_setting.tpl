<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 ">

	{if $msg}
		<div class="alert alert-{$msg.class} margin-bottom-30">
			{$msg.text}
		</div>
	{/if}

						<ul class="nav nav-tabs nav-top-border">
							<li class="active"><a data-toggle="tab" href="#info" aria-expanded="false">Персональная информация</a></li>
							<li class=""><a data-toggle="tab" href="#password" aria-expanded="true">Пароль</a></li>
							<li class=""><a data-toggle="tab" href="#setting" aria-expanded="false">Доп. настройки</a></li>
						</ul>

						<div class="tab-content margin-top-20 col-md-7">

							<!-- PERSONAL INFO TAB -->
							<div id="info" class="tab-pane fade active in">
								В разработке...
							</div>
							<!-- /PERSONAL INFO TAB -->


							<!-- PASSWORD TAB -->
							<div id="password" class="tab-pane fade">

								<form method="post" action="my_setting.php">

									<div class="form-group">
										<label class="control-label">Текущий пароль</label>
										<input type="password" class="form-control" name="old_password" value="">
									</div>
									<div class="form-group">
										<label class="control-label">Новый пароль</label>
										<input type="password" class="form-control" name="new_password" value="">
									</div>
									<div class="form-group">
										<label class="control-label">Повторите пароль</label>
										<input type="password" class="form-control" name="re_new_password" value="">
									</div>

									<div class="margiv-top10">
										<button class="btn btn-primary" ><i class="fa fa-check"></i> Изменить пароль</button>
									</div>
									<input type="hidden" value="yes" name="change_password">
								</form>

							</div>
							<!-- /PASSWORD TAB -->

							<!-- PRIVACY TAB -->
							<div id="setting" class="tab-pane fade">

								<form method="post" action="my_setting.php">
									<div class="sky-form">

										<table class="table table-bordered table-striped">
											<tbody>
												{*<tr>
													<td>Уведомления по почте</td>
													<td>
														<div class="inline-group">
															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" checked="" name="radioOption"><i></i> Да
															</label>

															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" checked="" name="radioOption"><i></i> Нет
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Показывать "чужих" клиентов</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" checked="" name="checkbox"><i></i> Да
														</label>
													</td>
												</tr>*}
												<tr>
													<td>Показывать уведомления от "системы"</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" {if !$CURUSER.notifs}checked=""{/if} name="notify"><i></i> Да
														</label>
													</td>
												</tr>
												<tr>
													<td>Показывать клиентов</td>
													<td>

															<select name="viev_client">
																<option value="0" {if $CURUSER['viev_client'] == 0}selected="selected"{/if}">Всех</option>
																<option value="1" {if $CURUSER['viev_client'] == 1}selected="selected"{/if}>Кому еще надо позвонить</option>
															</select>

													</td>
												</tr>
												{*<tr>
													<td>Уведомления</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" checked="" name="checkbox"><i></i> Да
														</label>
													</td>
												</tr>*}
											</tbody>
										</table>

									</div>

									<div class="margin-top-10">
										<input type="hidden" value="yes" name="change_setting">

										<button class="btn btn-primary" ><i class="fa fa-check"></i> Сохранить изменения </button>
										<a class="btn btn-default" href="#">Отмена </a>
									</div>

								</form>

							</div>
							<!-- /PRIVACY TAB -->

						</div>

					</div>