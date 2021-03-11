<!-- <div class="row"> -->
<div class="col-12" style="margin: 5px;">
    (ยอดผู้ป่วยที่ไม่มีจำนวนห้องตรวจที่สอง) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?php echo $Data_Count; ?> คน </span>
</div>
<!-- </div> -->

<table id="management_visit_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap>#</th>
            <th nowrap>วันที่-เวลา จาก kiosk</th>
            <th nowrap>วันที่-เวลา สแกนคิว</th>
            <th nowrap>idcard</th>
            <th nowrap>hn</th>
            <th nowrap>refno</th>
            <th nowrap>ประเภทบุคคล</th>
            <th nowrap>ประเภทสิทธิ</th>
            <th nowrap>มีขั้นตอนคัดกรอง</th>
            <th nowrap>userที่คัดกรอง</th>
            <th nowrap>idห้องตรวจ</th>
            <th nowrap>ชื่อห้องตรวจ</th>
            <th nowrap>idของอาคาร</th>
            <th nowrap>ชื่ออาคาร</th>
            <th nowrap>เปิดvisitสำเร็จ</th>
            <th nowrap>visitno</th>
            <th nowrap>userที่เปิดvisit</th>
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
                    <td><?=$value->closewhen;?></td>
                    <td><?=$value->idcard;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->refno;?></td>
                    <td><?=$value->patientypename;?></td>
                    <td><?=$value->payorname;?></td>
                    <td><?=$value->selectqueue?'ใช่':'';?></td>
                    <!-- <td><?=$value->closequeue?'ใช่':'ไม่ใช่';?></td> -->
                    <!-- <td><?=$value->closeuser;?></td>  -->
                    <td>ยังไม่มีการเก็บค่า worklistuid11</td>
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