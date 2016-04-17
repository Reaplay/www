<div class="alert alert-danger margin-bottom-30">
    <strong>Внимание</strong> Страница в тестовом режиме
</div>
{if !$IS_HEAD}
    <div class="alert alert-warning margin-bottom-30">
        <!-- WARNING -->
        <strong>Внимание!</strong> Клиент будет привязан к вашему профилю
    </div>
{/if}

<!-- register form -->
<form class="<!--validate--> nomargin sky-form boxed" action="card.php?action=call_client" method="post">
    <header>
        <i class="fa fa-users"></i> Добавление нового звонка по карте клиента
    </header>

    <fieldset class="nomargin">


        <div class="row margin-bottom-10">
            {if $IS_HEAD}
                {if !$data_card.id}
                    <div class="col-md-6">
                        <label class="input">
                            <i class="ico-prepend fa fa-calendar"></i>
                            <input type="text" class="form-control datepicker required" data-format="dd/mm/yyyy" data-lang="en" data-RTL="false" name="next_call" placeholder="Дата след. контакта">
                            {* <b class="tooltip tooltip-bottom-left">Назначенный EQUID</b>*}
                        </label>
                    </div>
                {/if}
            {/if}
            {* {if $IS_HEAD}
                <div class="col-md-6">
                    <div class="fancy-form fancy-form-select">
                        <select class="form-control select2 pointer required" name="manager">
                            <option value="---">Выберите менеджера</option>
                            {$manager}
                        </select>
                        <i class="fancy-arrow"></i>
                    </div>
                </div>
            {/if}
            *}
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12 col-sm-12">
                    <label>Комментарий</label>
                    <textarea class="summernote form-control" data-height="200" data-lang="en-US" name="comment"></textarea>

                </div>
            </div>
        </div>



    </fieldset>

    <div class="row margin-bottom-20">
        <div class="col-md-12">
            <input type="hidden" name = "id" value="{$id}">
            {if $return_url}<input type="hidden" name="return_url" value="{$return_url}">{/if}
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Добавить</button>
        </div>
    </div>

</form>
<!-- /register form -->
