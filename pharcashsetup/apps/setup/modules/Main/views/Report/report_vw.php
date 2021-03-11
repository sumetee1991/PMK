<div class="container-fluid">
    <form form_stop id="report_form" name="report_form" method="post" action="./report_ajax">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="Topic">Select Topic</label>
                    <select class="form-control" id="topic" name="topic">
                        <option value="0">Kiosk</option>
                        <option value="1">คิดราคายา</option>
                        <option value="2">ออกคิวยา</option>
                        <option value="3">การเงิน</option>
                        <option value="4">จัดยา</option>
                        <option value="5">เช็คยา</option>
                        <option value="6">จ่ายยา</option>
                        <option value="7">kiosk+คิดราคายา+ออกคิวยา+การเงิน+จัดยา+เช็คยา+จ่ายยา</option>                       
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="From">From</label>
                    <input class="form-control" type="text" id="date_from" name="date_from" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?= date("Y-m-d"); ?>">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="To">To</label>
                    <input class="form-control" type="text" id="date_to" name="date_to" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?= date("Y-m-d"); ?>">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="Date">สถานที่ห้องยา</label>
                    <select name="queuelocationuid" id="select_queuelocation" class="form-control" style="font-family: cs_prajad_b;font-size: 18px;">
                        <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
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
    <div id="show_report" style="overflow-x:auto;width:100%">
    </div>
</div>