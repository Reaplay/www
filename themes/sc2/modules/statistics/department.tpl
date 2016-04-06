<div class="alert alert-danger margin-bottom-30">
	<strong>Внимание</strong> Страница в тестовом режиме
</div>
<div class="row">

    <div class="col-md-6">

        <!-- PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>За прошлый месяц</strong> <!-- panel title -->
				</span>

            </div>

            <!-- panel content -->
            <div class="panel-body">

                <!-- tabs content -->
                <div class="tab-content transparent">

                    <div ><!-- TAB 1 CONTENT -->
                        <h6>По клиентам</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Менеджер</th>
                                    <th>Добавлено</th>
                                    <th>Стало</th>
                                    <th>Думают</th>
                                    <th>Отказ</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$data_last_month item=data}
                                <tr>
                                    <td><a href="#">{$data.name}</a></td>
                                    <td>{$data.client + $data.no_client + $data.decline}</td>
                                    <td>{if $data.client}{$data.client}{else}0{/if}</td>
                                    <td>{if $data.no_client}{$data.no_client}{else}0{/if}</td>
                                    <td>{if $data.decline}{$data.decline}{else}0{/if}</td>
                                </tr>
                                {/foreach}
                                </tbody>
                            </table>
                            <h6>По действиям</h6>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Менеджер</th>
                                    <th>Всего звонков</th>
                                    <th>Всего встреч</th>

                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$callback_last_month item=callback}
                                    <tr>
                                        <td>{$callback.name}</td>
                                        <td>{if $callback.call}{$callback.call}{else}0{/if}</td>
                                        <td>{if $callback.meeting}{$callback.meeting}{else}0{/if}</td>

                                    </tr>
                                {/foreach}

                                </tbody>
                            </table>
                        </div>

                    </div><!-- /TAB 1 CONTENT -->


                </div>
                <!-- /tabs content -->

            </div>
            <!-- /panel content -->

        </div>
        <!-- /PANEL -->


    </div>
    <div class="col-md-6">

        <!-- PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>За текущий месяц</strong> <!-- panel title -->
				</span>

            </div>

            <!-- panel content -->
            <div class="panel-body">

                <!-- tabs content -->
                <div class="tab-content transparent">

                    <div ><!-- TAB 1 CONTENT -->
                        <h6>По клиентам</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Менеджер</th>
                                    <th>Добавлено</th>
                                    <th>Стало</th>
                                    <th>Думают</th>
                                    <th>Отказ</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$data_current_month item=data}
                                    <tr>
                                        <td><a href="#">{$data.name}</a></td>
                                        <td>{$data.client + $data.no_client + $data.decline}</td>
                                        <td>{if $data.client}{$data.client}{else}0{/if}</td>
                                        <td>{if $data.no_client}{$data.no_client}{else}0{/if}</td>
                                        <td>{if $data.decline}{$data.decline}{else}0{/if}</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                            <h6>По действиям</h6>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Менеджер</th>
                                    <th>Всего звонков</th>
                                    <th>Всего встреч</th>

                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$callback_current_month item=callback}
                                    <tr>
                                        <td>{$callback.name}</td>
                                        <td>{if $callback.call}{$callback.call}{else}0{/if}</td>
                                        <td>{if $callback.meeting}{$callback.meeting}{else}0{/if}</td>

                                    </tr>
                                {/foreach}

                                </tbody>
                            </table>
                        </div>

                    </div><!-- /TAB 1 CONTENT -->


                </div>
                <!-- /tabs content -->

            </div>
            <!-- /panel content -->

        </div>
        <!-- /PANEL -->


    </div>

</div>