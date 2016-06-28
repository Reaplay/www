<form class="<!--validate--> nomargin sky-form boxed" action="statistic.php?type=client&subtype=promo_actio" method="post">
    <fieldset class="nomargin">


        <div class="row margin-bottom-10">


            <div class="col-md-3">
                <select class="form-control select2 pointer required" name="promo">
                    <option value="---">Выберите промоакцию</option>
                    {$data_promo}
                </select>
                <i class="fancy-arrow"></i>

            </div>



            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Отобразить</button>

            </div>



    </fieldset>



</form>
<br />


<div class="table-responsive">
    <table class="table table-bordered table-striped" id="table">
        <thead>
        <tr>

            <th>Не клиент</th>
            <th>Клиент</th>
            <th>Отказной</th>

        </tr>
        </thead>

        <tbody data-w="user">


            <tr>
                <td>
                    {$data.0}
                </td>

                <td>
                    {$data.1}
                </td>

                <td>
                    {$data.2}
                </td>


            </tr>

        </tbody>
    </table>
</div>