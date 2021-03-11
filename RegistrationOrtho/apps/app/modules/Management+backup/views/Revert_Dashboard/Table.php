<table id="dataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>เลขคิว</th>
            <th>ประเภท</th>
            <th>สิทธิ</th>
            <th>ชื่อ-สกุล</th>
            <?=(isset($Data['SelectedgroupprocessUID']) && $Data['SelectedgroupprocessUID'] == 2 ? '<th>HN</th>' : '');?>
            <th>ช่อง</th>
            <th>สถานะ</th>
            <th>Revert</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if( isset($Data['Queue']) && count($Data['Queue']) > 0):
                foreach ($Data['Queue'] as $key => $value) {
        ?>
            <tr id="Queue_<?=$value->queueno;?>">
                <td><?=$key;?></td>
                <td><span class="font_queuenumber"><?=$value->queueno;?></span></td>
                <td><?=$value->patienttypename;?></td>
                <td><?=$value->payorname;?></td>
                <td><?=$value->patientname;?></td>
                <?=(isset($Data['SelectedgroupprocessUID']) && $Data['SelectedgroupprocessUID'] == 2 ? '<td>'.$value->hn.'</td>' : '');?>
                <td><?=$value->call_counter;?></td>
                <td><?=$value->lastworklist;?></td>
                <td><button class="button c_green block small" data-q_revert="<?=$value->queueno;?>" data-patientuid="<?=$value->patientuid;?>" data-worklistuid="<?=$Data['JSConstant']['WorklistUID'];?>" <?=($value->active == 'N' ? 'disabled' : '');?> >Revert</button></td>
            </tr>
        <?php
                }
            endif;
        ?>
    </tbody>
</table>