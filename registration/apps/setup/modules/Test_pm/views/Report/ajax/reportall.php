<table id="management_reportall" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap>#</th>

            <th nowrap>วันที่-เวลาที่ออกคิว</th>
            <th nowrap>refno</th>
            <th nowrap>HN</th>
            <th nowrap>ID card</th>
            <th nowrap>ชื่อ-นามสกุล</th>
            <th nowrap>ประเภทบุคคล</th>
            <th nowrap>ประเภทสิทธิ</th>
            <th nowrap>ประเภทผู้ป่วย</th>
            <th nowrap>มีคิวคัดกรองหรือไม่</th>
            <th nowrap>วันที่-เวลา ที่สแกน</th>
            <th nowrap>user ที่คัดกรอง</th>
            <th nowrap>ชื่อห้องตรวจ</th>
            <th nowrap>ชื่ออาคาร</th>
            <th nowrap>เปิด visit สำเร็จ</th>
            <th nowrap>visit No</th>
            <th nowrap>User ที่เปิด visit</th>
            <th nowrap>มีคิวทำประวัติหรือไม่</th>
            <th nowrap>ประเภทคิว</th>
            <th nowrap>หมายเลขคิว</th>
            <th nowrap>เวลาเรียกครั้งแรก</th>
            <th nowrap>เวลาเรียกครั้งล่าสุด</th>
            <th nowrap>userที่เรียก</th>
            <th nowrap>counter ที่เรียก</th>
            <th nowrap>เวลาที่ hold</th>
            <th nowrap>ข้อความที่hold</th>
            <th nowrap>userที่Hold</th>
            <th nowrap>เวลาเสร็จสิ้น</th>
            <th nowrap>userเสร็จสิ้น</th>
            <th nowrap>มีคิวเปิดสิทธิหรือไม่</th>
            <th nowrap>ประเภทคิว</th>
            <th nowrap>หมายเลขคิว</th>
            <th nowrap>เวลาเรียกครั้งแรก</th>
            <th nowrap>เวลาเรียกครั้งล่าสุด</th>
            <th nowrap>userที่เรียก</th>
            <th nowrap>counter ที่เรียก</th>
            <th nowrap>เวลาที่ hold</th>
            <th nowrap>ข้อความที่hold</th>
            <th nowrap>userที่Hold</th>
            <th nowrap>เวลาเสร็จสิ้น</th>
            <th nowrap>userเสร็จสิ้น</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?=$key+1;?></td>

                    <td><?=$value->cwhen;?></td>
                    <td><?=$value->refno;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->idcard;?></td>
                    <td><?=$value->fullname;?></td>
                    <td><?=$value->patienttypename;?></td>
                    <td><?=$value->worklistgroupname;?></td>
                    <td><?=$value->selecqueue_visit;?></td>
                    <td><?=$value->closewhen_visit;?></td>
                    <td><?=$value->closeuser_visit;?></td>
                    <td><?=$value->room_name_visit;?></td>
                    <td><?=$value->buildingname_visit;?></td>
                    <td><?=$value->api_status_name_visit;?></td>
                    <td><?=$value->api_status_desc_visit;?></td>
                    <td><?=$value->cuser;?></td>
                    <td><?=$value->api_cuser_visit;?></td>
                    <td><?=$value->selectqueue_newhn;?></td>
                    <td><?=$value->queuetype_newhn;?></td>
                    <td><?=$value->queueno_newhn;?></td>
                    <td><?=$value->first_called_newhn;?></td>
                    <td><?=$value->last_called_newhn;?></td>
                    <td><?=$value->calluser_newhn;?></td>
                    <td><?=$value->callcounter_newhn;?></td>
                    <td><?=$value->hold_when_newhn;?></td>
                    <td><?=$value->hold_message_newhn;?></td>
                    <td><?=$value->hold_user_newhn;?></td>
                    <td><?=$value->closewhen_newhn;?></td>
                    <td><?=$value->closeuser_newhn;?></td>
                    <td><?=$value->selectqueue_payor;?></td>
                    <td><?=$value->queuetype_payor;?></td>
                    <td><?=$value->queueno_payor;?></td>
                    <td><?=$value->first_called_payor;?></td>
                    <td><?=$value->last_called_payor;?></td>
                    <td><?=$value->calluser_payor;?></td>
                    <td><?=$value->callcounter_payor;?></td>
                    <td><?=$value->hold_when_payor;?></td>
                    <td><?=$value->hold_message_payor;?></td>
                    <td><?=$value->hold_user_payor;?></td>
                    <td><?=$value->closewhen_payor;?></td>
                    <td><?=$value->closeuser_payor;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>