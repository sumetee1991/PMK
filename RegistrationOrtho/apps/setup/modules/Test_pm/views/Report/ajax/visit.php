<table id="management_visit_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap>#</th>
            <th nowrap>วันที่-เวลาที่ออกคิว</th>
            <th nowrap>refno</th>
            <th nowrap>HN
</th>
            <th nowrap>ID card
</th>
            <th nowrap>ชื่อ-นามสกุล
</th>
            <th nowrap>ประเภทบุคคล
</th>
            <th nowrap>ประเภทสิทธิ
</th>
            <th nowrap>ประเภทผู้ป่วย
</th>
            <th nowrap>มีคิวทำประวัติ/เปิดสิทธิหรือไม่
</th>
            <th nowrap>ประเภทคิว
</th>
            <th nowrap>หมายเลขคิว
</th>
            <th nowrap>เวลาเรียกครั้งแรก
</th>
            <th nowrap>เวลาเรียกครั้งล่าสุด
</th>
            <th nowrap>userที่เรียก
</th>
            <th nowrap>counter ที่เรียก
</th>
            <th nowrap>เวลาที่ hold
</th>

<th nowrap>ข้อความที่hold
</th>
<th nowrap>userที่Hold
</th>
<th nowrap>เวลาเสร็จสิ้น
</th>
<th nowrap>userเสร็จสิ้น
</th>
<th nowrap>มีคิวคัดกรองหรือไม่
</th>
<th nowrap>ประเภทคิว
</th>
<th nowrap>หมายเลขคิว
</th>
<th nowrap>เวลาเรียกครั้งแรก
</th>
<th nowrap>เวลาเรียกครั้งล่าสุด
</th>
<th nowrap>userที่เรียก
</th>
<th nowrap>counter ที่เรียก
</th>
<th nowrap>เวลาที่ hold
</th>
<th nowrap>ข้อความที่hold
</th>
<th nowrap>userที่Hold
</th>
<th nowrap>เวลาเสร็จสิ้น
</th>
<th nowrap>userเสร็จสิ้น
</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?=$key+1;?></td>
                    <td><?=$value->cwhen?explode(' ',$value->cwhen)[0]:'';?></td>
                    <td><?=$value->closewhen?explode(' ',explode('.',$value->closewhen)[0])[1]:'';?></td>
                    <td><?=$value->idcard;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->refno;?></td>
                    <td><?=$value->selectqueue?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->closequeue?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->closeuser;?></td>
                    <td><?=$value->room_uid;?></td>
                    <td><?=$value->room_name;?></td>
                    <td><?=$value->building_uid;?></td>
                    <td><?=$value->buildingname;?></td>
                    <td><?=$value->api_status_name;?></td>
                    <td><?=isset(json_decode($value->api_status_desc,TRUE)['visitNo'])?json_decode($value->api_status_desc,TRUE)['visitNo']:'';?></td>
                    <td><?=$value->api_cuser;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>