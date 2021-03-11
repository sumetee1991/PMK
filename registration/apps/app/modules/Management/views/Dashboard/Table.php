<table id="dataTable">
	<thead>
		<tr>
			<th style="width: 4.64%;">#</th>
            <th style="width: 6.60%;">เลขคิว</th>
            <th style="width: 10.31%;">ประเภท</th>
            <th style="width: 16.51%;">สิทธิ</th>
			<th style="width: 7.22%;">เวลารอ (นาที)</th>
            <th style="width: 16.51%;">ชื่อ-สกุล</th>
            <th style="width: 7.22%;">HN</th>
            <th style="width: 5.15%;">ช่อง</th>
            <th style="width: 8.25%;">สถานะ</th>
            <th style="width: 5.88%;">Call</th>
            <th style="width: 5.88%;">Hold</th>
            <th style="width: 7.84%;">เสร็จสิ้น</th>
            <th style="width: 5.15%;"> </th>
		</tr>
	</thead>
	<tbody>
		<?php
			if( isset($Data['Queue']) && count($Data['Queue']) > 0):
				foreach ($Data['Queue'] as $key => $value) {
		?>
			<tr role="row" id="Queue_<?=$value->queueno;?>" class="odd">
                <td><?=$key+1;?></td>
                <td><span class="font_queuenumber"><?=$value->queueno;?></span></td>
                <td><?=$value->patienttypename;?></td>
                <td><?=$value->payorname;?></td>
                <td><?=intval((($value->lastworklist_waiting)/1000)/60);?></td>
                <td><?=$value->patientname;?></td>
                <td><span class="font_queuenumber"><?=$value->hn;?></span></td>
                <td><?=$value->call_counter;?></td>
                <td><?=$value->lastworklist;?></td>
                <td>
                    <button class="button block small c_green <?=($value->callqueue == NULL ? '':'active');?>" data-q_call="<?=$value->queueno;?>" data-patientuid="<?=$value->patientuid;?>">Call </button>
                </td>
                <td>
                    <button class="button block small c_yellow <?=($value->holdqueue == NULL ? '':'active');?>" data-toggle="modal" data-target="#hold-modal" data-q_val="<?=$value->queueno;?>" data-puid_val="<?=$value->patientuid;?>">Hold </button>
                </td>
                <td>
                    <button class="button block small static_blue <?=($value->closqueue_register == NULL ? '':'active');?>" data-q_complete="<?=$value->queueno;?>" data-patientuid="<?=$value->patientuid;?>"><i class="fas fa-check"></i></button>
                </td>
                <td>
                    <button class="none" style="color:#000000" type="button" id="dropdown_Queue_<?=$value->queueno;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu" style="font-size:1.5rem;" aria-labelledby="dropdown_Queue_<?=$value->queueno;?>">
                        <button class="dropdown-item  " href="#" data-q_completeall="<?=$value->queueno;?>" data-patientuid="<?=$value->patientuid;?>">เสร็จสิ้นทั้งหมด</button>
                        <button class="dropdown-item  " href="#" data-q_cancel="<?=$value->queueno;?>" data-patientuid="<?=$value->patientuid;?>">ยกเลิกคิว</button>
                    </div>
                </td>
            </tr>
		<?php
				}
			endif;
		?>
	</tbody>
</table>
<script>
    $(document).ready(function() {
        var PostDataURL = base_path_url + 'CompleteQueue2/' + const_groupprocessid;
        console.log(const_groupprocessid);
        // postData = {
        //     'patientdetailuid': 1,
        // };
        // postAJAX(PostDataURL, postData);
        // $("#detail1").html(postData);

        $.post(PostDataURL,{
            event : 'Follow',
            groupprocessuid: const_groupprocessid,
        },
        function(data, status)
        {
            console.log(data);
            var data1 = 'คิวรอเรียกรวม(ทุกประเภทคิว) :' + ' ' + data 
            $("#detail2").html(data1);
        });
	});
</script>