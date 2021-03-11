<div class="main_container">
	<div class="row" style="padding: 1rem 0;">
		<div class="col-md-8 justify-content-center align-self-center">
            <div class="container-fluid">
            	<div class="row">
            		<div style="min-width:10rem;">
				        <h4>ประเภทคิว :</h4>
				    </div>
					<div class="col">
						<div id="queuecateRow" class="row btn_row">
							<!--
								<a data-tabqueuecate="1" data-buttonaction="tabqueuecate"><button>A</button></a>
							-->
						</div>
					</div>
				</div><br>
            	<div class="row">
            		<div style="min-width:10rem;">
				        <h4>รายการคิว :</h4>
					</div>
					<div class="col">
						<div class="row btn_row">
							<?php foreach($Data['MenuButton'] as $MenuButton):	?>
				            	<a class="<?=$MenuButton['Class'];?>" href="../<?=$MenuButton['URL'];?>"><button><?=$MenuButton['Text'];?></button></a>
							<?php endforeach; ?>
						</div>
					</div>
				</div><br>
		    </div>

		</div>

		<div class="col">
			<div class="row center">
	            <div class="col-4" style="text-align: end; color: #126263;">
	               <h3>ค้นหารายการ</h3>
	            </div>
				<div class="col">
					<form class="form-inline center" style="padding: .25rem 0rem;">
						<!-- <i class="fas fa-search" style="margin-right:-4em;z-index:999;" aria-hidden="true"></i> -->
						<input id="SearchHN_DT" class="form-control form-control-sm ml-3 w-100 input_icon" type="text" placeholder="กรอกชื่อผู้ป่วย / เลขคิว"	aria-label="Search">
						<i style="font-size:2rem;margin-left:-4rem;z-index:999;" aria-hidden="true" data-clear="#SearchHN_DT">&times;</i>
					</form>
				</div>
			</div>
		</div>
		<!-- 
		<div class="col">
			<div class="row center">
	            <div class="col-4" style="text-align: end; color: #126263;">
	               <h3>ค้นหารายการ</h3>
	            </div>
				<div class="col">
					<form class="form-inline" style="padding: .25rem .5rem;">
						<i class="fas fa-search" style="margin-right:-4em;z-index:999;" aria-hidden="true"></i>
						<input id="SearchHN_DT" class="form-control form-control-sm ml-3 w-100 input_icon" type="text" placeholder="กรอกชื่อผู้ป่วย / เลขคิว"	aria-label="Search">
						<i style="font-size:2rem;margin-left:-4rem;z-index:999;" aria-hidden="true" data-clear="#SearchHN_DT">&times;</i>
					</form>
				</div>
			</div>
		</div> -->
	</div>
</div>

<!-- Dashboard Table -->
<div class="nowrap_container" id="dataTable_Container">
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
</div>
<!-- /Dashboard Table -->
<script>
	var TableRowCount = <?=(isset($i) ? $i-1 : 0 );?>;
</script>