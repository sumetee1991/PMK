<div class="col" style="margin: 5px;">
    ออกคิวยา(ไม่รวมยอดยกเลิกคิว) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?php echo $Data_Count; ?> คน </span>
    <!-- <?php var_dump($Data_Count); ?> -->
</div>
<table id="medqueue_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap valign="bottom">ลำดับ</th>
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

        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <!-- <?php if ($value->cancelqueuedate == null) : ?>
                        <td><?= $key; ?></td>
                    <?php elseif ($value->cancelqueuedate != null) : ?>
                        <td><?= $key + 1; ?></td>
                    <?php endif; ?> -->
                    <td><?= $key + 1; ?></td>
                    <td><?= $value->worklistdatetime15; ?></td>
                    <td><?= $value->queueno; ?></td>
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
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>