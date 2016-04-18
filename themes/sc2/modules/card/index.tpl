<div class="alert alert-danger margin-bottom-30">
    <strong>Внимание</strong> Страница в тестовом режиме
</div>


    <div class="text-center">
        {*<a href="card.php?action=add"><button type="submit" class="btn btn-primary"> Добавить</button></a>*}
        <a href="card.php?action=add"> <button type="button" class="btn btn-primary btn-lg  margin-bottom-30" >Добавить карту</button></a>
        <button type="button" class="btn btn-primary btn-lg  margin-bottom-30" data-toggle="modal" data-target="#filter">Фильтр карт</button>
    </div>
<div id="filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="card.php" method="get">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Фильтр</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row margin-bottom-10">
                        <div class="col-md-6">
                            <h4>Фильтр по картам</h4>
                            <div class="fancy-form fancy-form-select">
                                <select class="form-control" name="type_card">
                                    <option value="">Выберите карту</option>
                                    {$list_card}
                                </select>
                                <i class="fancy-arrow"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Фильтр по менеджерам</h4>
                            <div class="fancy-form fancy-form-select">
                                <select class="form-control" name="manager">
                                    <option value="">Выберите менеджера</option>
                                    {$list_manager}
                                </select>
                                <i class="fancy-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-md-6">
                            {if $IS_POWER_HEAD}
                                <h4>Фильтр по отделениям</h4>
                                <div class="fancy-form fancy-form-select">
                                    <select class="form-control" name="department">
                                        <option value="">Выберите отделение</option>
                                        {$list_department}
                                    </select>
                                    <i class="fancy-arrow"></i>
                                </div>
                            {/if}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-md-6">
                            <h4>Опции</h4>
                            <label class="checkbox">
                                <input type="checkbox" name="only_my" value="1">
                                <i></i> Только мои
                            </label>
                        </div>
                        <div class="col-md-6">
                                <div class="search-box">
								
										<div class="input-group ">
											<input type="text" name="s" placeholder="Поиск" class="form-control typeahead" />
											<span class="input-group-btn">
												<button class="btn btn-primary" type="submit">Найти</button>
											</span>
										</div>
								
								</div> 
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Применить</button>

                </div>
            </form>
        </div>
    </div>
</div>


<!-- HTML DATATABLES -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Менеджер</th>
            {if $IS_POWER_HEAD}
                <th>Отделение</th>
            {/if}
            <th>EQUID</th>
            <th>Тип карты</th>
            <th>След. звонок</th>
            <th>Действие</th>
        </tr>
        </thead>

        <tbody data-w="card">
        {foreach from=$data_card item=card}

            <tr data-id="{$card.id}" id="card_{$card.id}" >
                <td>
                   <a href="card.php?action=view&amp;id={$card.id}"> {$card.name}</a>	<i class="fa fa-external-link"></i>
                </td>
                <td>
                    {$card.manager}
                </td>
                {if $IS_POWER_HEAD}
                    <td>
                        {$card.d_name}
                    </td>
                {/if}
                <td>
                    {$card.equid}
                </td>
                <td>
                    {$card.name_card}
                </td>
                <td>
                    {if $card.next_call}{$card.next_call}{else}N/A{/if}
                </td>
                <td>
                    <i class="fa fa-times" aria-hidden="true"></i>
                    <a href="#" onclick="issue_card({$card.id},'issue')">Выдать </a> | <a href="#" onclick="issue_card({$card.id},'destroy')">Уничтожить </a> | <a href="card.php?action=edit&id={$card.id}">Редактировать</a> | <a href="card.php?action=call_client&id={$card.id}">Звонок</a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    </table>
    <!--очень кривой вывод номеров страниц. переделать-->
    <ul class="pagination pagination-sm">
        <!--<li class="disabled"><a href="#">Пред</a></li>-->
        {if ($page > 2)}
            <li><a href="card.php?page=1{$add_link}">Первая</a></li>
            <li><a href="card.php?page={$page - 2}{$add_link}">{$page - 2}</a></li>
        {/if}
        {if ($page > 1)}
            <li><a href="card.php?page={$page - 1}{$add_link}">{$page - 1}</a></li>
        {/if}
        <li class="active"><a href="#">{$page}</a></li>
        {if ($page < ($max_page + 1) AND $page < $max_page)}
            <li><a href="card.php?page={$page + 1}{$add_link}">{$page + 1}</a></li>
        {/if}
        {if ($page < ($max_page + 2)  AND ($page+1) < $max_page)}
            <li><a href="card.php?page={$page + 2}{$add_link}">{$page + 2}</a></li>
            <li><a href="card.php?page={$max_page}{$add_link}">Последняя</a></li>
        {/if}
        <!--<li><a href="#">След</a></li>-->
    </ul>



