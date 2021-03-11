<table id="management_register_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed">
    <thead>
        <tr>
            <th nowrap>#</th>
            <th nowrap>วันที่</th>
            <th nowrap>เวลา</th>
            <th nowrap>idcard</th>
            <th nowrap>hn</th>
            <th nowrap>refno</th>
            <!-- <th nowrap>มีขั้นตอนเปิดสิทธิ</th> -->
            <!-- <th nowrap>มีคิวเปิดสิทธิ</th> -->
            <th nowrap>ประเภทคิว</th>
            <th nowrap>คิว</th>
            <!-- <th nowrap>ถูกเรียกหรือไม่</th> -->
            <th nowrap>เวลาเรียกครั้งแรก</th>
            <th nowrap>เวลาเรียกครั้งสุดท้าย</th>
            <th nowrap>userที่เรียก</th>
            <th nowrap>counterที่เรียก</th>
            <!-- <th nowrap>ถูกholdหรือไม่</th> -->
            <th nowrap>เวลาที่hold</th>
            <th nowrap>ข้อความhold</th>
            <th nowrap>userที่hold</th>
            <!-- <th nowrap>เสร็จสิ้น</th> -->
            <th nowrap>เวลาเสร็จสิ้น</th>
            <th nowrap>userเสร็จสิ้น</th>
            <th nowrap>ประเภทผู้ป่วย</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($Data) && count($Data) > 0) :
            foreach ($Data as $key => $value) {
        ?>
                <tr>
                    <td><?=$key+1;?></td>
                    <td><?=$value->cwhen?explode(' ',$value->cwhen)[0]:'';?></td>
                    <td><?=$value->idcard;?></td>
                    <td><?=$value->hn;?></td>
                    <td><?=$value->refno;?></td>
                    <td><?=$value->selectqueue?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->queue_exist?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->queuetype && $value->queuetype != 'null' ?$value->queuetype:'';?></td>
                    <td><?=$value->queueno && $value->queueno != 'null' ?$value->queueno:'';?></td>
                    <td><?=$value->queue_called?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->first_called?explode(' ',explode('.',$value->first_called)[0])[1]:'';?></td>
                    <td><?=$value->last_called?explode(' ',explode('.',$value->last_called)[0])[1]:'';?></td>
                    <!-- <td><?=$value->first_called;?></td> -->
                    <!-- <td><?=$value->last_called;?></td> -->
                    <td><?=$value->calluser;?></td>
                    <td><?=$value->callcounter;?></td>
                    <td><?=$value->queue_hold?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->hold_when?explode(' ',explode('.',$value->hold_when)[0])[1]:'';?></td>
                    <td><?=$value->hold_message;?></td>
                    <td><?=$value->hold_user;?></td>
                    <td><?=$value->closequeue?'ใช่':'ไม่ใช่';?></td>
                    <td><?=$value->closewhen?explode(' ',explode('.',$value->closewhen)[0])[1]:'';?></td>
                    <td><?=$value->closeuser;?></td>
                </tr>
        <?php
            }
        endif;
        ?>
    </tbody>
</table>