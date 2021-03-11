<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-2">
            <!-- <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-add href="javascript:void(0);">Add Groupprocess</a> -->
        </div>
    </div>
    <?php foreach ($Data['Groupprocess'] as $key => $value) : ?>
        <h4 class="topic"><span><?= $value->groupprocessdesc; ?></span></h4>
        <div class="row">
            <div class="col"><span>ข้อความ : <?= $value->tv_message; ?></span></div>
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-edit="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>
                <!-- <a class="btn btn_pmk btn-sm" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" btn-del="<?= $value->uid; ?>" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a> -->
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="groupprocess_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <div style="font-family: cs_prajad_b;font-size: 30px;">Groupprocess</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input name="uid" id="input_uid" type="hidden">

                    <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        TV Message
                        <input name="tv_message" id="input_tv_message" placeholder="Message" type="text" class="form-control">
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
                <a id="del_confirm" class="btn btn-success" data-delete="groupprocess" data-uid="">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>