<table id="cashier_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่มีคิวเข้าการเงิน </th>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">HN</th>  
            <th nowrap valign="bottom">VN ใหญ่</th>
            <th nowrap valign="bottom">VN เล็ก</th>
            <th nowrap valign="bottom">ชื่อ-นามสกุล</th>
            <th nowrap valign="bottom">สิทธิ</th>
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
            <!-- <th nowrap valign="bottom">ติดต่อการเงิน (Y/N)</th> -->
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
                    <td><?=$value->creditname;?></td>
                    <td><?=$value->callbeforedate1;?></td>
                    <td><?=$value->callafterdate1;?></td>
                    <td><?=$value->callcounter1;?></td>
                    <td><?=$value->callby1;?></td>
                    <td><?=$value->messagecwhen1;?></td>
                    <td><?=$value->messagedetail1;?></td>
                    <td><?=$value->messagedetailcreateby1;?></td>
                    <td><?=$value->worklistdatetime13;?></td>
                    <td><?=$value->worklistcreateby13;?></td>
                    <td><?=$value->worklistdatetime19;?></td>
                    <td><?=$value->worklistcreateby19;?></td>           
                    <!-- <td><?=$value->contact;?></td> -->
                </tr>
                <?php
            }
        endif;
        ?>
    </tbody>
</table>