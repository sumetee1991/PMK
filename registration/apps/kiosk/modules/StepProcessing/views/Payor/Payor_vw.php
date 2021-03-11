<div class="form-group">
	<div class="row form-group center">
		<div class="row form-group center">
			<div class="form-group center" style="border-bottom: 2px solid; text-align: center; width: 720px; height: 120px">
				<h2 class="sty_h2_b3 bodyth">ตรวจสอบสิทธิการรักษา</h2>
			</div>
			<div class="col-12">
			</div>
		</div>
		<div class="col-12">
		</div>

		<div class="col-3" style="text-align: left;">
			<h2 class="btn1_b3 bodyth" type="" style="">สิทธิปัจจุบัน</h2>
		</div>

		<div class="col-8 center">
			<input class="sty_in_b3" type="text" name="" id="last_payor" value="-" data-policyholderid=''>
		</div>

	</div>
	<input type='hidden' id="box_type" value=''>
	<div style="height: 39rem">
		<div class="row form-group col-12 center" id="" style="">
			<h3 class="center bodyth" style="width: 720px; border-bottom: 2px solid; padding: 10px 0;font-size: 48px;">สิทธิที่ต้องการใช้ในวันนี้ </h3>

			<div class="col-12 row bodyth" style="display: inherit; padding: 16px 3rem;" id="area_box_payyor">

			</div>

			<!-- <div class="col-12">
         -----------
      </div> -->
		</div>
	</div>


	<div class="row form-group justify-content-md-center">
		<div class="col-12 center" style="padding-top: .6rem;">
			<button class="d2_2_b2 btn_suc_click bodyth" type="button" id="conf_yes">ยืนยัน</button>
		</div>
	</div>
</div>

<!-- The Modal alert -->
<div class="modal" id="md_alert_scan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width:960px !important;">
		<div class="modal-content" id="md_scan_cont">
			<!-- Modal body -->
			<div class="modal-body" style="margin-top:20px; padding: 0px;">
				<div class="row no-gutters" style="font-size: 4vw;">

					<div class='col-12 row no-gutters justify-content-md-center center'>
						<div class='logo_alert line_alert' style=""><span class="logo_alert_img"><?= single_img('kiosk/resources/images/icon/xx.png', array('style' => 'width:90px;height:90px;display:block;position: relative; left: -27px;')) ?></span></div>
					</div>

					<div class='col-12 row no-gutters justify-content-md-center center' style="min-height: 16rem;">

						<div class='col-12 row no-gutters justify-content-md-center'>

							<div class='col-10 content_alert' id="content_show_md" style="text-align: center; font-size: 48px;">

							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer row no-gutters" style="margin-bottom: 40px;padding: 0;border-top: none;">
				<div class='col-10'></div>
				<div class='col-4'><button type="button" class="ok_alert btn_suc_click" id="conf_no" data-dismiss="modal">ตกลง</button></div>
			</div>

		</div>
	</div>
</div>
<!-- The Modal -->



<!-- The Modal alert -->
<div class="modal" id="md_alert_payor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 960px !important;">
		<div class="modal-content" id="md_scan_cont" style="padding-bottom: 80px; height: 1371px; max-height: 1371px;">
			<!-- Modal body -->
			<div class="modal-body center" style="margin-top:20px">
				<div class="row no-gutters" style="font-size: 4vw; !important">


					<div class='col-12' style=" margin-top: 5rem;">
						<div class='col-12 text_head'>

						</div>
						<div class='col-12 content_alert content_payor' id="content_show_md">
							<span class="logo_alert_img2" style="display:flex;justify-content:center;"></span>
						</div>
						<div class='col-12 text_footer'>

						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer row no-gutters center" id="list_btn_payor">

			</div>

		</div>
	</div>
</div>
<!-- The Modal -->
