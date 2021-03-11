<div class="container-fluid">
    <div class="row">
        <div class="col mb-2">
            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-add href="javascript:void(0);">Add Message</a>
        </div>
        <div class="col-4 mb-2">
            <select name="dropdown_groupprocess" id="dropdown_groupprocess" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                <option value="">ALL</option>
                <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
                    <?php if($value->groupprocessdesc != 'All'): ?>
                    <option value="<?= $value->uid; ?>"><?= $value->groupprocessdesc; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div id="holdmessage_list" class="row ui-sortable">
        <?php foreach ($Data['HoldMessage'] as $key => $value) : ?>
            <div class="col-lg-4 col-sm-6 col-12 mb-2 ui-sortable-handle">
                <div class="card  shadow h-100  bg-light">
                    <div class="card-body">
                        <input type="hidden" value="1" data-sort="<?= $value->sequence; ?>">
                        <div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;"><?= $value->hold_message; ?></div>
                        <span><?= "$value->groupprocessdesc | $value->message_description"; ?></span>
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

<div class="modal fade" id="holdmessage_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">Counter</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="input_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Hold Message
                        <input name="hold_message" id="input_hold_message" placeholder="Hold Message" type="text" class="form-control">
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Message Description
                        <input name="message_description" id="input_message_description" placeholder="Message Description" type="text" class="form-control">
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Groupprocess
                        <select name="groupprocessuid" id="select_groupprocessuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                            <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->groupprocessdesc; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Active
                        <div class="col">
                            <input type="radio" name="active" value="Y" checked="checked">เปิด
                            <input type="radio" name="active" value="N">ปิด
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
                <a id="del_confirm" class="btn btn-success" data-delete="holdmessage" data-uid="">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>