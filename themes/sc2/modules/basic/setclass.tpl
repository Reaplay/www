<div>
    <form action="setclass.php" method="get">
    <div class="col-md-3">
        <div class="fancy-form  fancy-form-select">
            <select class="form-control select2 pointer required" name="class">
                <option value="---">Выберите класс</option>
                {$data_class}
            </select>
            <i class="fancy-arrow"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="fancy-form  fancy-form-select">
            <select class="form-control select2 pointer required" name="department">
                <option value="---">Выберите отделение</option>
                {$data_department}
            </select>
            <i class="fancy-arrow"></i>
        </div>
    </div>
    <div class="col-md-3">
        <input type="hidden" name="action" value="editclass">
        <button type="submit" class="btn btn-primary margin-bottom-30" >Изменить</button>

    </div>
</form>
</div>