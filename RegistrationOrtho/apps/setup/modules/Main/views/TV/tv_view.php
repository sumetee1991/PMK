<div class="container-fluid">
    <div class="row">
        <div class="col-8 mb-2">
            <?php if(count($Data['TV']) < 5): ?>
            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-add href="javascript:void(0);">Add TV</a>
            <?php endif; ?>
        </div>
        <div class="col">
            <select name="queuelocationuid" id="select_queuelocation" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                    <option value="<?= $value->locationuid; ?>"><?= $value->locationname_th; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php foreach ($Data['TV'] as $key => $value) : ?>
        <h4 class="topic"><span><?= $value->tv_description; ?></span></h4>
        <div class="row">
            <div class="col"><a href="<?=DASHBOARDPHARCASH."/dashboard_dispense?location_id=$value->queuelocationuid&tvuid=$value->uid";?>"><?=DASHBOARDPHARCASH."/dashboard_dispense?location_id=$value->queuelocationuid&tvuid=$value->uid";?></a></div>            
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-setting="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-edit" aria-hidden="true"></i> ตั้งค่าคิว</a>
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-edit="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-del="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="tv_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">TV</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="input_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        TV Description
                        <input name="tv_description" id="input_tv_description" placeholder="Description" type="text" class="form-control">
                    </div>

                    <div class="row">
                        <div class="form-group col" style="font-family: cs_prajad_b;font-size: 18px;">
                            Column
                            <select name="message_qty" id="select_message_qty" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                                <?php for($count = 1;$count <= 5;$count++) : ?>
                                    <option value="<?= $count; ?>"><?= $count; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <!--
                        <div class="form-group col" style="font-family: cs_prajad_b;font-size: 18px;">
                            Row
                            <select name="message_row" id="select_message_row" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                                <?php for($count = 1;$count <= 7;$count++) : ?>
                                    <option value="<?= $count; ?>"><?= $count; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        -->

                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        <input type="hidden" name="groupprocessuid" id="input_groupprocessuid" value="2">
                        <!--
                        Groupprocess
                            <select name="groupprocessuid" id="select_groupprocessuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                                <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
                                    <option value="<?= $value->uid; ?>"><?= $value->groupprocessdesc; ?></option>
                                <?php endforeach; ?>
                            </select>
                        -->
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">                        
                        <input type="hidden" name="queuelocationuid" id="input_queuelocationuid" value="<?=$Data['TVQueuelocation']->locationuid;?>">
                        <!--
                        QueueLocation
                        <select name="queuelocationuid" id="select_queuelocationuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                            <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->locationname_th; ?></option>
                            <?php endforeach; ?>
                        </select>
                        -->
                    </div>


                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Active
                        <div class="col">
                            <input type="radio" name="status" value="1" checked="checked">เปิด
                            <input type="radio" name="status" value="0">ปิด
                        </div>
                    </div>

                    <div calss="col-2">
                        <div class="form-group float-left">
                            <button type="button" class="btn btn_pmk" style="font-family: cs_prajad_b;font-size: 18px;" data-dismiss="modal">ยกเลิก</button>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn_pmk" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="tv_message_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">TV Setting</div>
                <a style="font-size: 2rem;text-decoration: none;" data-dismiss="modal" href="javascript:void(0);">&times;</a>
            </div>
            <div class="modal-body">
                <div id="message_display">
                </div>
                <div class="row" style="margin-top:5px;">                    
                    <div calss="col">
                        <div class="form-group float-left">
                            <button type="button" class="btn btn_pmk" style="font-family: cs_prajad_b;font-size: 18px;" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group float-right">
                            <button type="submit" submit_settings class="btn btn_pmk" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="del_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Are to sure to delete</div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
                <a id="del_confirm" class="btn btn-success" data-delete="tv" data-uid="">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>