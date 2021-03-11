<table id="dispense_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่มีคิวเข้าจ่ายยา </th>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">HN</th>  
            <th nowrap valign="bottom">VN ใหญ่</th>
            <th nowrap valign="bottom">VN เล็ก</th>
            <th nowrap valign="bottom">ชื่อ-นามสกุล</th>
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวครั้งแรก</th>
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวล่าสุด</th>
            <th nowrap valign="bottom">ช่องบริการที่เรียกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เรียกคิว</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ Hold </th>
            <th nowrap valign="bottom">เหตุผลที่ Hold</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ Hold</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ยกเลิกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ยกเลิก</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
                ?>
                <tr>
                    <td><?=$key+1;?></td>
                    <td><?=$value->worklistdatetime15;?></td>     
                    <td><?=$value->pharmacyqueueno;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->vnpharmacy;?></td>
                    <td><?=$value->en;?></td>
                    <td><?=$value->fullname;?></td>
                    <td><?=$value->callbeforedate2;?></td>
                    <td><?=$value->callafterdate2;?></td>
                    <td><?=$value->callcounter2;?></td>
                    <td><?=$value->callby2;?></td>
                    <td><?=$value->messagecwhen2;?></td>
                    <td><?=$value->messagedetail2;?></td>
                    <td><?=$value->messagedetailcreateby2;?></td>
                    <td><?=$value->worklistdatetime17;?></td>
                    <td><?=$value->worklistcreateby17;?></td>
                    <td><?=$value->worklistdatetime20;?></td>
                    <td><?=$value->worklistcreateby20;?></td>
                </tr>
                <?php
            }
        endif;
        ?>
    </tbody>
</table>

