<div class="panel panel-default">
    <div class="panel-heading panel-heading-transparent">
        <h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} карту</h2>
    </div>
    <div class="panel-body">
        <form method="post" action="action_admin.php?module=cobrand{if $action=="edit"}&id={$id}{/if}">
            <div class="row">
                <div class="form">
                    <div class="col-md-4 col-sm-4">
                        <input type="text" name="name" class="form-control" placeholder="Введите название кобрендовой карты" value="{$data_card_cobrand.name}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="fancy-form fancy-form-select">
                            <select class="form-control  select2" name="type_card">
                                <option value="---">Выберите тип карты</option>
                                <option {if $data_card_cobrand.type == 1}selected = "selected"{/if} value="1">Дебетовая</option>
                                <option {if $data_card_cobrand.type == 2}selected = "selected"{/if} value="2">Кредитная</option>
                            </select>
                            <i class="fancy-arrow"></i>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <button type="submit" class="btn btn-primary" type="submit">{if $action=="add"}Добавить{else}Изменить{/if}</button>
                        <input type="hidden" name="action" value="{$action}">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>