<table id="drugcharge_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">เลขคิว</th>
            <th nowrap valign="bottom">ชื่อ นามสกุล</th>
            <th nowrap valign="bottom">Datetime กดเรียกคิว</th>
            <th nowrap valign="bottom">User ที่เรียกคิว</th>
            <th nowrap valign="bottom">ช่องบริการที่เรียกคิว</th>
            <th nowrap valign="bottom">สถานที่ห้องยา</th>
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
                    <td><?=$value->worklistdatetime14;?></td>
                    <td><?=$value->worklistcreateby14;?></td>
                    <td><?=$value->callcounter6;?></td>
                    <td><?=$value->location;?></td>
                    <td><?=$value->messagecwhen6;?></td>
                    <td><?=$value->messagedetail6;?></td>
                    <td><?=$value->messagedetailcreateby6;?></td>
                    <td><?=$value->worklistdatetime15;?></td>
                    <td><?=$value->worklistcreateby15;?></td>
                    <td><?=$value->worklistdatetime22;?></td>
                    <td><?=$value->worklistcreateby22;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>