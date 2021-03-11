<div class="container-fluid">
    <form form_stop id="stat_form" name="stat_form" method="post" action="./statistic_ajax">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="Topic">Select Topic</label>
                    <select class="form-control" id="topic" name="topic">
                        <option value="0">Kiosk</option>
                        <option value="1">คิดราคายา</option>
                        <!-- <option value="2">ออกคิวยา</option> -->
                        <option value="3">การเงิน</option>
                        <option value="4">จัดยา</option>
                        <option value="5">เช็คยา</option>
                        <option value="6">จ่ายยา</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="Date">Date</label>
                    <input class="form-control" type="text" id="date_select" name="date_select" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" value="<?= date("d/m/Y"); ?>">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="Date">สถานที่ห้องยา</label>
                    <select name="queuelocationuid" id="select_queuelocation" class="form-control" style="font-family: cs_prajad_b;font-size: 18px;">
                        <?php foreach ($Data['Queuelocation'] as $key => $value) : 
                            //var_dump($Data['Queuelocation']->locationname_th);
                            ?>
                            <option value="<?= $value->locationuid; ?>"><?= $value->locationname_th; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <br>
                    <button type="submit" class="btn btn_pmk btn-md">Search</button>
                </div>
            </div>
        </div>
    </form>
    <div id="show_stat" class="row" style="overflow-x:auto;">
    </div>
</div>