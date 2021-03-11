<div class="container-fluid">
    <div class="row">
        <div class="col-8 mb-2">
            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-add href="javascript:void(0);">Add Category</a>
        </div>
        <div class="col">
            <select name="queuelocationuid" id="select_queuelocation" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                    <option value="<?= $value->locationuid; ?>" <?=$value->locationuid == $Data['thisQueuelocation']->locationuid?'selected':'';?>><?= $value->locationname_th; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div id="patientcategory_list" class="row ui-sortable">
        <?php foreach ($Data['PatientCategory'] as $key => $value) : ?>
            <div class="col-lg-4 col-sm-6 col-12 mb-2 ui-sortable-handle" sortcate data-uid="<?=$value->uid;?>" data-sequence="<?=$value->sequence;?>">
                <div class="card  shadow h-100  bg-light">
                    <div class="card-body">
                        <div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;text-shadow: 0px 0px 2px #646464;" <?=($value->color?"color:$value->color":'');?>><?= ($value->patientcategoryshortname?$value->patientcategoryshortname:' ‎'); ?>‎‎</div>
                        <span><?= "$value->patientcategorydescription"; ?></span>
                        <div>
                            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-edit="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>
                            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-del="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="patientcategory_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">PatientCategory</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="input_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Shortname <!-- <span style="color:grey;font-size:0.7rem;">required</span> -->
                        <input name="patientcategoryshortname" id="input_patientcategoryshortname" placeholder="PatientCategory Shortname" type="text" class="form-control" required>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Name <!-- <span style="color:grey;font-size:0.7rem;">required</span> -->
                        <input name="patientcategoryname" id="input_patientcategoryname" placeholder="PatientCategory Name" type="text" class="form-control" required>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        ชื่อที่แสดงบนบัตรคิว <!-- <span style="color:grey;font-size:0.7rem;">required</span> -->
                        <input name="ticketdisplay" id="input_ticketdisplay" type="text" class="form-control" required> <!-- jscolor -->
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Color <!-- <span style="color:grey;font-size:0.7rem;">required</span> -->
                        <input name="color" id="input_color" type="text" class="form-control" required> <!-- jscolor -->
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Waiting Time <!-- <span style="color:grey;font-size:0.7rem;">required</span> -->
                        <input name="waitingtime" id="input_waitingtime" maxlength="3" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;" required>
                    </div>

                    <input type="hidden" name="queuelocationuid" value="<?=$Data['thisQueuelocation']->locationuid;?>">

                    <div class="form-group" style="display:none;font-family: cs_prajad_b;font-size: 18px;">
                        Groupprocess
                        <select name="groupprocessuid" id="select_groupprocessuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;" disabled>
                            <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->groupprocessdesc; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Active
                        <div class="col">
                            <input type="radio" name="statusflag" value="Y" checked="checked">เปิด
                            <input type="radio" name="statusflag" value="N">ปิด
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

<div class="modal fade" id="del_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Are to sure to delete</div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
                <a id="del_confirm" class="btn btn-success" data-delete="patientcategory" data-uid="">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>