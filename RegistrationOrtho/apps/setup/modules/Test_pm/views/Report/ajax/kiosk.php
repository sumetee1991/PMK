<table id="kiosk_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap>#</th>
            <th nowrap>วันที่</th>
            <th nowrap>เวลาที่ออกใบนำทาง</th>
            <th nowrap>idcard</th>
            <th nowrap>hn</th>
            <th nowrap>refno</th>
            <th nowrap>ผู้ป่วยใหม่</th>
            <th nowrap>typeid</th>
            <th nowrap>typename</th>
            <th nowrap>payorid</th>
            <th nowrap>payor</th>
            <th nowrap>ประเภทใบนำทาง</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?= $key + 1; ?></td>
                    <td><?= $value->cwhen ? explode(' ', $value->cwhen)[0] : ''; ?></td>
                    <td><?= $value->cwhen ? explode(' ', explode('.', $value->cwhen)[0])[1] : ''; ?></td>
                    <td><?= $value->idcard; ?></td>
                    <td><?= $value->hn; ?></td>
                    <td><?= $value->refno; ?></td>
                    <td><?= $value->newpatient ? 'ใช่' : 'ไม่ใช่'; ?></td>
                    <td><?= $value->patienttypeid; ?></td>
                    <td><?= $value->patienttypename; ?></td>
                    <td><?= $value->payorid; ?></td>
                    <td><?= $value->payorname; ?></td>
                    <td><?= $value->worklistgroupname; ?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>