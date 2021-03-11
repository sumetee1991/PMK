<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-2">
            <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-add href="javascript:void(0);">Add Ticket</a>
        </div>
    </div>
    <?php foreach ($Data['Ticket'] as $key => $value) : ?>
        <h4 class="topic"><span><?= $value->ticket_name; ?></span></h4>
        <div class="row">
            <div class="col"><span><?= $value->ticket_description; ?></span></div>
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-message=="<?= $value->uid; ?>" <?= ($value->messageuid ? 'message-uid="' . $value->messageuid . '"' : ''); ?> href="javascript:void(0);"><i class="fas fa-comment-alt" aria-hidden="true"></i> ข้อความ</a>
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-edit="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-del="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="ticket_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">Ticket</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="input_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Name
                        <input name="ticket_name" id="input_ticket_name" placeholder="Name" type="text" class="form-control">
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Description
                        <input name="ticket_description" id="input_ticket_description" placeholder="Description" type="text" class="form-control">
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Groupprocess
                        <select name="groupprocessuid" id="select_groupprocessuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                            <option></option>
                            <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->groupprocessdesc; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        QueueLocation
                        <select name="queuelocationuid" id="select_queuelocationuid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                            <option></option>
                            <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->locationname_th; ?></option>
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

<div class="modal fade" id="ticket_message_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">Ticket</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="minput_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Message
                        <textarea name="display_message" id="minput_display_message" placeholder="Description" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Description
                        <input name="description" id="minput_description" placeholder="Description" type="text" class="form-control">
                    </div>

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        Ticket
                        <select name="ticket_uid" id="select_ticket_uid" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                            <?php foreach ($Data['Ticket'] as $key => $value) : ?>
                                <option value="<?= $value->uid; ?>"><?= $value->ticket_name; ?></option>
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
                <a id="del_confirm" class="btn btn-success" data-delete="ticket" data-uid="">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>