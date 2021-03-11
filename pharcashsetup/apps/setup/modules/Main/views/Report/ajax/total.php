<div class="col" style="margin: 5px;">
    ออกคิวยา(ไม่รวมยอดยกเลิกคิว) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?php echo $Data_Count; ?> คน </span>
    <!-- <?php var_dump($Data_Count); ?> -->
</div>

<table id="total_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
            <!-- kiosk -->
            <?php if ($_POST['queuelocationuid'] != '4') : ?>
                <th nowrap valign="bottom">วันที่-เวลา กดคิวมียา</th>
                <th nowrap valign="bottom">เลขคิวมียา</th>
            <?php elseif ($_POST['queuelocationuid'] == '4') : ?>
                <th nowrap valign="bottom">วันที่-เวลา สแกนคิว walk in</th>
                <th nowrap valign="bottom">เลขคิว walk in</th>
                <th nowrap valign="bottom">วันที่-เวลา สแกนคิวon line </th>
                <th nowrap valign="bottom">เลขคิว on line</th>
                <th nowrap valign="bottom">ประเภทคิว on lineหรือ walk-in</th>
            <?php endif; ?>
            <!-- drugcharge -->
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวครั้งแรก</th>
            <th nowrap valign="bottom">วันที่-เวลา กดเรียกคิวล่าสุด</th>
            <th nowrap valign="bottom">ช่องบริการที่เรียกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เรียกคิว</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ Hold</th>
            <th nowrap valign="bottom">เหตุผลที่ Hold</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ Hold</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เสร็จสิ้น</th>
            <!-- medqueue -->
            <th nowrap valign="bottom">วันที่-เวลา ที่ออกคิวยา</th>
            <th nowrap valign="bottom">เลขคิวจาก Kiosk</th>
            <th nowrap valign="bottom">ประเภทคิว</th>
            <th nowrap valign="bottom">หมายเลขคิว</th>
            <?php if ($_POST['queuelocationuid'] == '4') : ?>
                <th nowrap valign="bottom">ประเภทคิว on lineหรือ walk-in</th>
            <?php endif; ?>
            <th nowrap valign="bottom">VN ใหญ่</th>
            <th nowrap valign="bottom">VN เล็ก</th>
            <th nowrap valign="bottom">HN</th>
            <th nowrap valign="bottom">ขื่อ-นามสกุล</th>
            <th nowrap valign="bottom">ติดต่อการเงิน (Y/N)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ออกคิว</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ยกเลิกคิว</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ยกเลิกคิว</th>
            <!-- cashier -->
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
            <!-- medication -->
            <th nowrap valign="bottom">สถานะสุดท้าย</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ scan (ครั้งแรก)(จากระบบHIS)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ scan(จากระบบHIS)</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่ scan (ครั้งแรก)(จากระบบคิว)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่ scan(จากระบบคิว)</th>
            <!-- checkmed   -->
            <th nowrap valign="bottom">สถานะสุดท้าย (ออกคิวยา/จัดยาเสร็จ/เช็คยาเสร็จ/ยามีปัญหา)</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)(HIS)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เช็คยา(HIS)</th>
            <th nowrap valign="bottom">วันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)(จากระบบคิว)</th>
            <th nowrap valign="bottom">ชื่อผู้ใช้งาน ที่เช็คยา(จากระบบคิว)</th>
            <!-- dispense -->
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
        // echo '<pre>';
        // print_r($Data);
        // echo '</pre>';
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?= $key + 1; ?></td>
                    <!-- kiosk -->
                    <?php if ($value->kiosqueueno == '0' || $value->kiosqueueno == null) : ?>
                        <?php if ($_POST['queuelocationuid'] != '4') : ?>
                            <td></td>
                            <td><?= $value->kiosqueueno; ?></td>
                        <?php elseif ($_POST['queuelocationuid'] == '4') : ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($_POST['queuelocationuid'] != '4') : ?>
                            <td><?= $value->cwhen; ?></td>
                            <td><?= $value->kiosqueueno; ?></td>
                        <?php elseif ($_POST['queuelocationuid'] == '4') : ?>
                            <td><?= $value->cwhen; ?></td>
                            <td><?= $value->kiosqueueno; ?></td>
                            <td><?= $value->worklistdatetime15; ?></td>
                            <td><?= $value->pharmacyqueueno; ?></td>
                            <td><?= $value->processstatus; ?></td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!-- drugcharge -->
                    <td><?= $value->callbeforedate6; ?></td>
                    <td><?= $value->callafterdate6; ?></td>
                    <td><?= $value->callcounter6; ?></td>
                    <td><?= $value->callby6; ?></td>
                    <td><?= $value->messagecwhen6; ?></td>
                    <td><?= $value->messagedetail6; ?></td>
                    <td><?= $value->messagedetailcreateby6; ?></td>
                    <?php if ($value->kiosqueueno == '0' || $value->kiosqueueno == null) : ?>
                        <td></td>
                    <?php else : ?>
                        <td><?= $value->worklistdatetime15; ?></td>
                    <?php endif; ?>
                    <td><?= $value->worklistcreateby15; ?></td>
                    <!-- medqueue -->
                    <td><?= $value->worklistdatetime15; ?></td>
                    <td><?= $value->medqueueno; ?></td>
                    <td><?= $value->patientcategoryshortname; ?></td>
                    <td><?= $value->pharmacyqueueno; ?></td>
                    <?php if ($_POST['queuelocationuid'] == '4') : ?>
                        <td><?= $value->processstatus; ?></td>
                    <?php endif; ?>
                    <td><?= $value->vnpharmacy; ?></td>
                    <td><?= $value->en; ?></td>
                    <td><?= $value->hn; ?></td>
                    <td><?= $value->fullname; ?></td>
                    <td><?= $value->contact; ?></td>
                    <td><?= $value->worklistcreateby15; ?></td>
                    <td><?= $value->cancelqueuedate; ?></td>
                    <td>ยังไมมีข้อมูล</td>
                    <!-- cashier -->
                    <td><?= $value->creditname; ?></td>
                    <td><?= $value->callbeforedate1; ?></td>
                    <td><?= $value->callafterdate1; ?></td>
                    <td><?= $value->callcounter1; ?></td>
                    <td><?= $value->callby1; ?></td>
                    <td><?= $value->messagecwhen1; ?></td>
                    <td><?= $value->messagedetail1; ?></td>
                    <td><?= $value->messagedetailcreateby1; ?></td>
                    <td><?= $value->worklistdatetime13; ?></td>
                    <td><?= $value->worklistcreateby13; ?></td>
                    <td><?= $value->worklistdatetime19; ?></td>
                    <td><?= $value->worklistcreateby19; ?></td>
                    <!-- medication -->
                    <td><?= $value->medicationstatus; ?></td>
                    <td><?= $value->his_druging_finished_date; ?></td>
                    <td>ไม่มีการส่งข้อมูลจากHIS</td>
                    <td><?= $value->worklistdatetime3; ?></td>
                    <td><?= $value->worklistcreateby3; ?></td>
                    <!-- checkmed   -->
                    <td><?= $value->checkmedstatus; ?></td>
                    <td><?= $value->his_drugchecked_finished_date; ?></td>
                    <td>ไม่มีการส่งข้อมูลจากHIS</td>
                    <td><?= $value->worklistdatetime5; ?></td>
                    <td><?= $value->worklistcreateby5; ?></td>
                    <!-- dispense -->
                    <td><?= $value->callbeforedate2; ?></td>
                    <td><?= $value->callafterdate2; ?></td>
                    <td><?= $value->callcounter2; ?></td>
                    <td><?= $value->callby2; ?></td>
                    <td><?= $value->messagecwhen2; ?></td>
                    <td><?= $value->messagedetail2; ?></td>
                    <td><?= $value->messagedetailcreateby2; ?></td>
                    <td><?= $value->worklistdatetime17; ?></td>
                    <td><?= $value->worklistcreateby17; ?></td>
                    <td><?= $value->worklistdatetime20; ?></td>
                    <td><?= $value->worklistcreateby20; ?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>