<div class="panel panel-default">
    <div class="panel-heading panel-heading-transparent">
        <h2 class="panel-title bold">{if $action=="add"}Добавить{else}Изменить{/if} страницу</h2>
    </div>
    <div class="panel-body">
        <form method="post" action="action_admin.php?module=page{if $action=="edit"}&id={$id}{/if}">
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <label>Название страницы</label>
                        <input type="text" name="title" class="form-control" placeholder="Введите название страницы" value="{$data_page.title}">
                    </div>
                    <div class="col-md-6 col-sm-6">


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12 col-sm-12">
                        <label>Текст страницы</label>
                        <textarea name="text" class="summernote form-control" data-height="200" data-lang="en-US">{$data_page.text}</textarea>
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