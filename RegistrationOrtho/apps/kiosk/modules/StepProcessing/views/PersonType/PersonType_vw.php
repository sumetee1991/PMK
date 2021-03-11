<div style='min-height:50rem;'>
	<div class="form-group">
		<div class="row form-group center">
			<div class="form-group center" style="border-bottom: 2px solid; text-align: center; width: 720px; height: 120px">
				<h2 class="sty_h2_b3 bodyth">ระบุประเภทผู้ป่วย</h2>
			</div>
			<div class="col-12">
			</div>
		</div>
		<input type='hidden' id="box_type" value=''>
		<div class="row form-group col-12 center" id="" style="">
			<h3 class="col-11 bodyth" style="text-align: left; padding: 24px 0; font-size: 2.4rem">โปรดระบุประเภทผู้ป่วย</h3>

			<div class="col-12 row form-group" style="display: inherit; padding: 16px 3rem; overflow-y:auto; height:30rem;" id="area_check_box">

			</div>


		</div>

	</div>
</div>

<div class="row form-group justify-content-md-center" style="padding-top: 2rem">
	<div class="col-12 center">
		<button class="d2_2_b2 btn_suc_click bodyth" type="button" id="conf_next">ยืนยัน</button>
	</div>
</div>


<!-- The Modal alert -->
<div class="modal" id="md_alert_scan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 960px !important;">
		<div class="modal-content" id="md_scan_cont">
			<!-- Modal body -->
			<div class="modal-body" style="margin-top:20px; padding: 0px;">
				<div class="row no-gutters" style="font-size: 4vw;">

					<div class='col-12 row no-gutters justify-content-md-center'>
						<div class='logo_alert line_alert' style=""><span class="logo_alert_img"><?= single_img('kiosk/resources/images/icon/xx.png', array('style' => 'width:90px;height:90px;display:block;position: relative; left: -27px;')) ?></span></div>
					</div>

					<div class='col-12 row no-gutters justify-content-md-center center' style="min-height: 14rem;">

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
