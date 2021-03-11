<table id="medication_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">ชื่อ นามสกุล</th>
            <th nowrap valign="bottom">สถานะสุดท้าย</th>
            <th nowrap valign="bottom">Datetime ที่ scan (ครั้งแรก)</th>
            <th nowrap valign="bottom">User ที่ scan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?=$value->queueno;?></td>
                    <td><?=$value->fullname;?></td>
                    <td><?=$value->status;?></td>
                    <td><?=$value->worklistdatetime3;?></td>
                    <td><?=$value->worklistcreateby3;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>