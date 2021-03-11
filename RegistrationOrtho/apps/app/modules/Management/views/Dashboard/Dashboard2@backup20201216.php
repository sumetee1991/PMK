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
							<a href="./Dashboardlocation2" class="active"><button>รอเรียก</button></a>
							<a href="./Revert_Dashboard2/2"><button>คิวที่เสร็จสิ้นแล้ว</button></a>
					        <a href="./Revert_Cancel2/2"><button>คิวที่ถูกยกเลิก</button></a>
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
<div id="dataTable_Container" class="nowrap_container">
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
</div>
<!-- /Dashboard Table -->
<script>
	var TableRowCount = <?=(isset($i) ? $i-1 : 0 );?>;
</script>