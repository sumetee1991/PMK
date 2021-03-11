<table id="kiosk_report" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed"  >
    <thead>
        <tr>
           <th nowrap valign="bottom">ลำดับ</th>    
           <?php if($_POST['queuelocationuid'] != '4'): ?>
           <th nowrap valign="bottom">วันที่-เวลา กดคิวมียา</th>
           <th nowrap valign="bottom">เลขคิวมียา</th>
           <?php elseif($_POST['queuelocationuid'] == '4'): ?>
           <th nowrap valign="bottom">วันที่-เวลา สแกนคิว walk in</th>
           <th nowrap valign="bottom">เลขคิว walk in</th>
           <th nowrap valign="bottom">วันที่-เวลา สแกนคิวon line </th>
           <th nowrap valign="bottom">เลขคิว on line</th>
           <th nowrap valign="bottom">ประเภทคิว on lineหรือ walk-in</th>
         <?php endif; ?>
       </tr>
   </thead>
   <tbody>
    <?php
    if (isset($Data) && count($Data) > 0) :
        foreach ($Data as $key => $value) { ?>
            <tr>
                <td><?=$key+1;?></td>
                <?php if($_POST['queuelocationuid'] != '4'): ?>
                <td><?=$value->cwhen;?></td>
                <td><?=$value->queueno;?></td> 
                <?php elseif($_POST['queuelocationuid'] == '4'): ?>
                <td><?=$value->cwhen;?></td>
                <td><?=$value->queueno;?></td>
                <td><?=$value->worklistdatetime15;?></td>
                <td><?=$value->pharmacyqueueno;?></td>
                <td><?=$value->processstatus;?></td>  
               <?php endif; ?>
           </tr>
           <?php
       }
   endif;
   ?>
</tbody>
</table>


