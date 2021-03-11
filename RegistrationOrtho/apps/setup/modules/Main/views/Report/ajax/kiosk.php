<table id="kiosk_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
            <th nowrap valign="bottom">เลขคิวมียา</th>
            <th nowrap valign="bottom">Datetime กดคิวมียา</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?=$value->queueno;?></td>
                    <td><?=$value->cwhen;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>