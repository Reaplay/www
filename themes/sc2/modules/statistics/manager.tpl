<form  action="statistic.php?type=manager" method="post">
    <div class="col-md-6" >
        <div class="fancy-form fancy-form-select">
            <select class="form-control select2 pointer required" name="user_id">
                {foreach from=$data_user item=user}
               <option value = "{$user.id}">{$user.name} ({$user.d_name})</option>";
                {/foreach}
            </select>
            <i class="fancy-arrow"></i>
        </div>
    </div>
    <div class="col-md-6" >
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Вывести</button>
    </div>
</form>