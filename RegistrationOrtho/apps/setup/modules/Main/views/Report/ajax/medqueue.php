<table id="medqueue_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">VN ใหญ่</th>
            <th nowrap valign="bottom">VN เล็ก</th>
            <th nowrap valign="bottom">HN</th>
            <th nowrap valign="bottom">ขื่อ-นามสกุล</th>
            <th nowrap valign="bottom">ติดต่อการเงิน (Y/N)</th>
            <th nowrap valign="bottom">ประเภทคิว</th>
            <th nowrap valign="bottom">หมายเลขคิว</th>
            <th nowrap valign="bottom">Datetime ที่ออกคิว</th>
            <th nowrap valign="bottom">User ที่ออกคิว</th>
            <th nowrap valign="bottom">สถานที่ ห้องยาที่ออกคิว</th>
            <th nowrap valign="bottom">Datetime ที่ยกเลิกคิว</th>
            <th nowrap valign="bottom">User ที่ยกเลิกคิว</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?="";?></td>
                    <td><?=$value->en;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->fullname;?></td>
                    <td><?=$value->contact;?></td>
                    <td><?=$value->patientcategory;?></td>
                    <td><?=$value->pharmacyqueueno;?></td>
                    <td><?=$value->worklistdatetime15;?></td>
                    <td><?=$value->worklistcreateby15;?></td>
                    <td><?=$value->location;?></td>
                    <td><?=""?></td>
                    <td><?=""?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>