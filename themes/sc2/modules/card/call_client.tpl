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
            
            
                    <div class="col-md-6">
                        <b>ФИО:</b> {$data_client.name} <br />
                        <b>Номер телефона:</b> {$data_client.mobile}
                    </div>
            
            
            <div class="col-md-6">

                   
                </div>
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
        <div class="row margin-bottom-10">


            <div class="col-md-6">
                <div class="fancy-form fancy-form-select">
                    <select class="form-control  select2" name="type_contact" onchange="load_r_call(this)">
                        <option value="0">Выберите тип контакта *</option>
                        <option value="1">Исходящий звонок</option>
                        <option value="2">Встреча</option>
                    </select>
                    <i class="fancy-arrow"></i>
                </div>
            </div>


            <div class="col-md-6">
                <div class="fancy-form fancy-form-select">

                    <select name="result_call" class="form-control  select2">
                        <option value="0">Выберите контакт *</option>
                        {*$result*}
                    </select>
                    <i class="fancy-arrow"></i>
                </div>

            </div>
          </div>
        <div class="row margin-bottom-10">


            <div class="col-md-6">
                <label class="input">
                    <i class="ico-prepend fa fa-calendar"></i>
                    <input type="text" class="form-control datepicker required" data-format="dd/mm/yyyy" data-lang="ru" data-RTL="false" name="next_call" placeholder="Дата след. контакта">
                    {* <b class="tooltip tooltip-bottom-left">Назначенный EQUID</b>*}
                </label>
            </div>


            <div class="col-md-6">

            </div>

        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12 col-sm-12">
                    <label>Комментарий</label>
                    <textarea name="comment" rows="4" class="form-control required"></textarea>

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
