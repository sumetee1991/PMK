<table id="checkmed_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่มีคิวเข้าเช็คยา</th>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">HN</th>  
            <th nowrap valign="bottom">VN ใหญ่</th>
            <th nowrap valign="bottom">VN เล็ก</th>
            <th nowrap valign="bottom">ชื่อ-นามสกุล</th>
            <th nowrap valign="bottom">สถานะสุดท้าย (ออกคิวยา/จัดยาเสร็จ/เช็คยาเสร็จ/ยามีปัญหา)</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)(HIS)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เช็คยา(HIS)</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)(จากระบบคิว)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เช็คยา(จากระบบคิว)</th>
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
                    <td><?=$value->checkmedstatus;?></td>
                    <td><?=$value->his_drugchecked_finished_date;?></td>
                    <td>ไม่มีการส่งข้อมูลจากHIS</td>
                    <td><?=$value->worklistdatetime5;?></td>
                    <td><?=$value->worklistcreateby5;?></td>
                </tr>
                <?php
            }
        endif;
        ?>
    </tbody>
</table>