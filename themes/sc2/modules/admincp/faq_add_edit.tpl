<div class="panel panel-default">
    <div class="panel-heading panel-heading-transparent">
        <h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} вопрос</h2>
    </div>
    <div class="panel-body">
        <form method="post" action="action_admin.php?module=faq{if $action=="edit"}&id={$id}{/if}">
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <label>Название вопроса</label>
                        <input type="text" name="title" class="form-control" placeholder="Введите вопрос" value="{$data_faq.title}">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label>Тип</label>
                        <div class="fancy-form fancy-form-select">
                            <select class="form-control  select2" name="type">
                                <option value="client">Клиент</option>
                                <option value="card">Карта</option>
                                <option value="user">Пользователь</option>
                                <option value="other">Прочее</option>

                            </select>
                            <i class="fancy-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12 col-sm-12">
                        <label>Текст ответа</label>
                        <textarea name="text" class="summernote form-control" data-height="200" data-lang="en-US">{$data_faq.text}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-3d btn-teal btn-slg btn-block" type="submit">
                        {if $action=="add"}Добавить{else}Изменить{/if}
                    </button>
                    <input type="hidden" name="action" value="{$action}">
                </div>
            </div>

    </div>

</div>

</form>
</div>
</div>