<table id="dispense_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">ชื่อ นามสกุล</th>
            <th nowrap valign="bottom">Datetime กดเรียกคิวล่าสุด</th>
            <th nowrap valign="bottom">User ที่เรียกคิว</th>
            <th nowrap valign="bottom">ช่องบริการที่เรียกคิว</th>
            <th nowrap valign="bottom">Datetime ที่ Hold </th>
            <th nowrap valign="bottom">เหตุผลที่ Hold</th>
            <th nowrap valign="bottom">User ที่ Hold</th>
            <th nowrap valign="bottom">Datetime ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">User ที่เสร็จสิ้น</th>
            <th nowrap valign="bottom">Datetime ที่ยกเลิกคิว</th>
            <th nowrap valign="bottom">User ที่ยกเลิก</th>
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
                    <td><?=$value->worklistdatetime17?$value->worklistdatetime17:$value->worklistdatetime16;?></td>
                    <td><?=$value->worklistcreateby17?$value->worklistcreateby17:$value->worklistcreateby16;?></td>
                    <td><?=$value->callcounter2;?></td>
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