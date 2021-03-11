<div class="form-group">

	<div class="row form-group center ps_head">
		<div class="col-10 appm_head">
			<h2 class="sty_h2_b3">ขั้นตอนการเข้ารับบริการ</h2>
		</div>
	</div>

	<div class="form-group col-12 ps_ctn" id="area_list_process">
		<?php if ($Data['worklist_process']) : ?>
			<div class='row no-gutters col-12 justify-content-md-center'>
				<div class='col-1 center ps_margin_r'>
					<?= single_img('kiosk/resources/images/icon/G1.png', array('class' => '_img_02')); ?>
					<p class='ps_runnum'></p>
				</div>
				<div class='col-7' style='align-items: center;max-height:50px;'>
					<a>ออกคิวเข้ารับบริการ</a>
				</div>
				<div class='col-2'>
					<span class='text_comp'>เสร็จสิ้น</span>
				</div>
			</div>
			<?php foreach ($Data['worklist_process'] as $key => $value) : ?>
				<div class='row no-gutters col-12 justify-content-md-center'>
					<div class='col-1 center ps_margin_r'>
						<?= single_img('kiosk/resources/images/icon/' . ($key + 1 == count($Data['worklist_process']) ? 'Y2' : 'Y1') . '.png', array('class' => '_img_02')); ?>
						<p class='ps_runnum'><?= $key + 1; ?></p>
					</div>
					<div class='col-7' style='align-items: center;max-height:50px;'>
						<a><?= $value->flowname . ($value->worklistuid == '6' ? " " . $this->session->userdata('SessionClinicName')['clinicName'] : ""); ?></a>
					</div>
					<div class='col-2'>
						<span></span>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-12 center">
			<button class="d2_2_b2 btn_suc_click" type="button" id="cf_processing">ยืนยัน และพิมพ์ใบนําทาง</button>
		</div>
	</div>


</div>