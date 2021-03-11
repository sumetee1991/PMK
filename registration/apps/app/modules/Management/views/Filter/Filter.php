<div class="main_container">
	<div class="row align-items-center" style="height: 94px;">
		<span style="font-size:2rem;color:#126263;">ค้นหารายการ : </span>
		<div class="col-md-3 justify-content-center">
			<form class="form-inline" style="padding: .25rem .5rem;">
				<i class="fas fa-barcode" style="margin-right:-2.5em;z-index:999;" aria-hidden="true"></i>
				<input id="SearchRefNo" class="form-control form-control-sm ml-3 w-100 input_dual_icon" type="text" placeholder="กรอก HN / Ref No." aria-label="Add" value="">
				<i class="fas fa-times-circle" style="margin-left:-2.5em;z-index:999;" aria-hidden="true" data-clear="#SearchRefNo"></i>
				<i class="fas fa-search" style="margin-left:-2.5em;z-index:999;" aria-hidden="true" data-searchref="#SearchRefNo"></i>
			</form>
		</div>
		<span id="TabPatientName" data-refno="" data-patientuid="" data-patienthn="" style="font-size:2.5rem;color:#0000FF;"></span>
		<br>
        <a class="button medium c_green hidden" style="margin: 0 0.5rem;" data-filter="insert" data-refno="ref">เพิ่มคิว</a>
        <a class="button medium c_yellow hidden" style="margin: 0 0.5rem;" data-filter="clear">ยกเลิก</a>
        <div class="col" style="text-align: right;">
        	<div id="EditFilter" style="float: right;width: fit-content;">
        		<button class="filter_style">แก้ไขจำนวน <i class="fas fa-pencil-alt"></i></button>
        	</div>
        </div>
	</div>
	<div id="printer_location_row" class="row hidden">
		<span style="font-size:2rem;color:#126263;">Printer Location</span>
		<div class="form-inline">
			<input type="text" class="form-control form-control-sm ml-3 w-100 input_dual_icon" id="print_location" name="print_location">
		</div>
	</div>
	<div id="count_filter_patient" class="row" style="display:none;">
		<span id="count_filter_patient_head" style="font-size:1.5rem;color:#0000FF;">ผ่านการคัดกรองแล้วทั้งหมด : </span><span id="count_filter_patient_value" style="font-size:1.5rem;color:#0000FF;"><?=$Data['Count'];?></span>
	</div>
</div>
<!-- Filter -->
<div class="container-fluid">
	<div class="row building_row">
		<?php foreach($Data['Building'] as $result): ?>
			<a href="<?='../Filter/'.$result->uid;?>">
				<button class="col <?=(isset($Data['BuildingUID']) && $Data['BuildingUID'] == $result->uid ? 'active' : '');?>">
					<?=$result->building_name;?>
				</button>
			</a>
		<?php endforeach; ?>
	</div>
</div>
<div id="container_building"class="container-fluid" style="height:calc(75% - 6rem);overflow-y: auto;overflow-x: hidden;">
	<?php if($Data['BuildingUID'] != 0){?>
	<?php if(isset($Data['Building_Floor']) && count($Data['Building_Floor']) > 0): ?>
		<?php foreach($Data['Building_Floor'] as $Floor): ?>

		<div class="container-fluid" style="margin: 1rem auto; background-color: #f8f8f8; box-shadow: 0px 2px 8px 0px #b7b7b7; border-radius: 8px;">
			<div class="row">
				<div class="col-1" style="padding:10px 25px;"><h3>ชั้น <?=$Floor->floor_number;?></h3></div>
				<div class="col" style="padding:10px 25px;">
					<div class="row">

						<?php if(isset($Data['Building_Room']) && count($Data['Building_Room']) > 0): ?>
							<?php foreach($Data['Building_Room'] as $Room): ?>
								<?php if($Room->flooruid == $Floor->uid){ ?>
								<div class="col-4" style="text-align: center;padding:5px 25px;">
									<button class="building_room" data-buildinguid="<?=$Room->buildinguid;?>" data-flooruid="<?=$Room->flooruid;?>" data-opdcode="<?=$Room->clinic_code;?>" data-tabfilter="<?=$Room->uid;?>" data-tabaction="tabfilter"><?=$Room->detail;?></button>
									<h6 class="center" style="color: #2d407d;margin-top: 0.6rem;">
										<a class="button btn_de c_green hidden" style="" data-editfilter="subtract" data-roomuid="<?=$Room->uid;?>">-</a>
											<span class="span_limit">												
												<span id="count_filter_<?=$Room->uid;?>"><?=isset($Data['CountClinic'])?$Data['CountClinic'][array_search($Room->uid, array_column($Data['CountClinic'], 'uid'))]['count']:'0';?></span>
												/
												<span id="max_count_filter_<?=$Room->uid;?>"><?=$Room->amount;?></span>
											</span>
										<a class="button btn_pl c_green hidden" style="" data-editfilter="add" data-roomuid="<?=$Room->uid;?>">+</a>
									</h6>
								</div>
								<?php } ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</div>
				</div>
			</div>			
		</div>

		<?php endforeach; ?>
	<?php endif; ?>
	<?php }else{ ?>
		<h1>โปรดเลือกอาคาร</h1>
		
	<?php } ?>
</div>
<!-- /Filter -->

	<?php /*
	<hr style="margin:15px;">
	<div id="boxFilter" class="row">
		<?php foreach($Data['Room'] as $result): ?>
			<div class="col-md-4 colFilter"><a id="filter_<?=$result->uid;?>" class="button block filter" data-tabfilter="<?=$result->uid;?>" data-tabaction="tabfilter"><?=$result->detail;?></a>
				<span style="position:absolute;top:0;right:1rem;padding: 1rem;color:#FFFFFF;">
					<span id="count_filter_<?=$result->uid;?>">0</span>
					/<span id="max_count_filter_<?=$result->uid;?>">40</span>
				</span>
			</div>
		<?php endforeach; ?>
		<!--
			<div class="col-md-4 colFilter"><a id="filter_1" class="button block filter" data-tabfilter="1" data-tabaction="tabfilter">ลอเรม ยิปอะไร?</a></div>
			<div class="col-md-4 colFilter"><a id="filter_2" class="button block filter" data-tabfilter="2" data-tabaction="tabfilter">ลอเรม ยิปหนึ่ง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_3" class="button block filter" data-tabfilter="3" data-tabaction="tabfilter">ลอเรม ยิปซ่อง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_4" class="button block filter" data-tabfilter="4" data-tabaction="tabfilter">ลอเรม ยิปซั่ม!!</a></div>
			<div class="col-md-4 colFilter"><a id="filter_5" class="button block filter" data-tabfilter="5" data-tabaction="tabfilter">ลอเรม ยิปอะไร?</a></div>
			<div class="col-md-4 colFilter"><a id="filter_6" class="button block filter" data-tabfilter="6" data-tabaction="tabfilter">ลอเรม ยิปหนึ่ง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_7" class="button block filter" data-tabfilter="7" data-tabaction="tabfilter">ลอเรม ยิปซ่อง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_8" class="button block filter" data-tabfilter="8" data-tabaction="tabfilter">ลอเรม ยิปซั่ม!!</a></div>
			<div class="col-md-4 colFilter"><a id="filter_9" class="button block filter" data-tabfilter="9" data-tabaction="tabfilter">ลอเรม ยิปอะไร?</a></div>
			<div class="col-md-4 colFilter"><a id="filter_10" class="button block filter" data-tabfilter="10" data-tabaction="tabfilter">ลอเรม ยิปหนึ่ง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_11" class="button block filter" data-tabfilter="11" data-tabaction="tabfilter">ลอเรม ยิปซ่อง</a></div>
			<div class="col-md-4 colFilter"><a id="filter_12" class="button block filter" data-tabfilter="12" data-tabaction="tabfilter">ลอเรม ยิปซั่ม!!</a></div>
		-->
	</div>
	*/ ?>