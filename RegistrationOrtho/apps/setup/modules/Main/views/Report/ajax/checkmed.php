<table id="checkmed_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">ชื่อ นามสกุล</th>
            <th nowrap valign="bottom">สถานะสุดท้าย (จัดยาเสร็จ /ยามีปัญหา)</th>
            <th nowrap valign="bottom">Datetime ที่เช็คยา (ครั้งสุดท้าย)</th>
            <th nowrap valign="bottom">User ที่เช็คยา</th>
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
                    <td><?=$value->worklistdatetime5;?></td>
                    <td><?=$value->worklistcreateby5;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>