<div class="form-group">

	<div class="row form-group center ps_head">
		<div class="col-10 appm_head">
			<h2 class="sty_h2_b3">ขั้นตอนการเข้ารับบริการ</h2>
		</div>
	</div>

	<div class="form-group col-12 ps_ctn" id="area_worklist">




	</div>

	<div class="row justify-content-md-center">
		<div class="col-6">
			<button class="btn_gry btn_suc_click" style="float:right;" type="button" id="DisCardQueue">ขอคิวใหม่</button>
		</div>
		<div class="col-6">
			<button class="btn_gre btn_cancle_on" style="float:left;" type="button" id="reprint">พิมพ์ซ้ำ</button>
		</div>
	</div>
</div>


<!-- The Modal alert -->
<div class="modal" id="md_alert_scan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 960px !important;">
		<div class="modal-content" id="md_scan_cont">
			<!-- Modal body -->
			<div class="modal-body" style="margin-top:20px; padding: 0px;">
				<div class="row" style="font-size: 4vw;">

					<div class='col-12 row no-gutters justify-content-md-center'>
						<div class='logo_alert line_alert' style=""><span class="logo_alert_img"><?= single_img('kiosk/resources/images/icon/xx.png', array('style' => 'width:90px;height:90px;display:block;position: relative; left: -27px;')) ?></span></div>
					</div>

					<div class='col-12 row no-gutters justify-content-md-center center' style=" min-height: 16rem;">
						<div class='col-10 content_alert center' id="content_show_md" style="text-align: left; font-size: 48px;">

						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer row no-gutters" style="margin-bottom: 40px;padding: 0;border-top: none;">

				<div class='col-4'><button type="button" class="no_alert" data-dismiss="modal">ยกเลิก</button></div>
				<div class='col-4'><button type="button" class="d2_2_b2 ok_alert" id="conf_no" data-dismiss="modal">ตกลง</button></div>
			</div>

		</div>
	</div>
</div>
<!-- The Modal -->
