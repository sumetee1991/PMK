<table id="drugcharge_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <th nowrap valign="bottom">วันที่-เวลา คิวเข้าคิดราคายา</th>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวครั้งแรก</th>
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวล่าสุด</th>
            <th nowrap valign="bottom">ช่องบริการที่เรียกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เรียกคิว</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ Hold</th>
            <th nowrap valign="bottom">เหตุผลที่ Hold</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ Hold</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เสร็จสิ้น</th>
            <!-- <th nowrap valign="bottom">วันที่-เวลา ที่ยกเลิกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ยกเลิก</th> -->
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
                    <td><?=$value->queueno;?></td>
                    <td><?=$value->callbeforedate6;?></td>
                    <td><?=$value->callafterdate6;?></td>
                    <td><?=$value->callcounter6;?></td>
                    <td><?=$value->callby6;?></td>
                    <td><?=$value->messagecwhen6;?></td>
                    <td><?=$value->messagedetail6;?></td>
                    <td><?=$value->messagedetailcreateby6;?></td>
                    <td><?=$value->worklistdatetime15;?></td>
                    <td><?=$value->worklistcreateby15;?></td>
                    <!-- <td><?=$value->worklistdatetime22;?></td>
                    <td><?=$value->worklistcreateby22;?></td> -->
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>