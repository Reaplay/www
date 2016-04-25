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
<form class="<!--validate--> nomargin sky-form boxed" action="card.php?action=change" method="post">
    <header>
        <i class="fa fa-users"></i> {if $data_card}Редактирование{else}Добавление новой{/if} карты клиента
    </header>

    <fieldset class="nomargin">

        <div class="row margin-bottom-10">
            <div class="col-md-6">
                <label class="input">
                    <i class="ico-append fa fa-user"></i>
                    <input class="form-control required" type="text" name="name" placeholder="ФИО клиента" value="{$data_card.name}">
                    <b class="tooltip tooltip-bottom-right">Не меньше 5 мимволов</b>
                </label>
            </div>
            <div class="col col-md-6">
                <label class="input">
                    <i class="ico-prepend fa fa-key"></i>
                    <input class="form-control" type="text" name="equid" placeholder="EQ UID" value="{$data_card.equid}">
                    <b class="tooltip tooltip-bottom-left">Значение из эквейжена, если есть</b>
                </label>
            </div>
        </div>


        <div class="row margin-bottom-10">
            <div class="col-md-6">
                <label class="input">
                    <i class="ico-append fa fa-phone-square"></i>
                    <input type="text" class="form-control masked required" data-format="+9 (999) 999-99-99" data-placeholder="{$data_card.mobile}" placeholder={if !$data_card.mobile}"Номер сотового телефона"{else}"Нажмите для отображения"{/if} name="mobile" value="{$data_card.mobile}">
                    <b class="tooltip tooltip-bottom-right">Введите номер сотового телефона</b>
                </label>
            </div>
            <div class="col col-md-6">
                <div class="fancy-form  fancy-form-select">
                    <select class="form-control select2 pointer required" name="card">
                        <option value="---">Выберите карту</option>
                        {$card}
                    </select>
                    <i class="fancy-arrow"></i>
                </div>
            </div>
        </div>

        <div class="row margin-bottom-10">
            <div class="col-md-6">

            </div>
            <div class="col col-md-6">
                <div class="fancy-form fancy-form-select">


                </div>
            </div>
        </div>




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
            {if $IS_HEAD}
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

        </div>
        <div class="margin-bottom-30">
            <label class="checkbox nomargin"><input type="checkbox" name="vip"{if $data_card.vip}checked="checked"{/if}><i></i>VIP-карта</label>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12 col-sm-12">
                    <label>Комментарий</label>
                    {*<textarea class="summernote form-control" data-height="200" data-lang="en-US" name="comment">{$data_card.comment}</textarea>*}
                    <textarea name="comment" rows="4" class="form-control required">{$data_card.comment}</textarea>

                </div>
            </div>
        </div>



    </fieldset>

    <div class="row margin-bottom-20">
        <div class="col-md-12">
            {if $data_card.id}
            <input type="hidden" name = "id" value="{$data_card.id}">
            {/if}
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {if $data_card}Изменить{else}Добавить{/if}</button>
        </div>
    </div>

</form>
<!-- /register form -->
