<div class="main" style="display:none;">
	<div class="tile tile1"></div>
	<div class="tile tile2"></div>
	<div class="tile tile3"></div>
	<div class="tile tile4"></div>
	<div class="tile tile5"></div>
</div>

<div class='' style="background-color: #fffefa; min-height: 100%; border-radius: 60px 60px 0 0">

	<div class='form-group' style="max-height: 100%; padding-top: 1.3rem;">
		<div class="row no-gutters form-group" style="padding: 1rem 2.954321rem;">

			<div class="col-10 " style="">

				<?= single_img('kiosk/resources/images/logo.png', array('style' => 'float: left; height: 81px', 'class' => 'rotate-vert-center')) ?>

				<div style="text-align: left; float: left; padding-left: 20px;">
					<p class="primary headth" style="">โรงพยาบาลพระมงกุฎเกล้า</p>
					<p class="secondary headth" style="">Phramongkutklao Hospital</p>
				</div>
			</div>

			<div class="col-2" style="padding-top: 1.2vw">
				<?= single_img('kiosk/resources/images/BG/on.png', array('style' => 'width: 36px; float: right; margin-right: 16px')) ?>
			</div>
		</div>

		<div class='col-12' style="text-align: center;display: flex; justify-content: center; align-items: center; height: 35rem">
			<h1 style="font-size: 5.1rem;" class='bodyth'>จุดออกคิวเข้ารับบริการ</h1>
		</div>

		<div class='form-group col-12' style="text-align: center;">
			<h1 style='font-size: 3.3rem;' class='bodyth'>เสียบบัตรประชาชน </h1>
			<h2 style='font-size: 2.1111rem;' class='bodyth'>หรือกรอกเลขประจำตัวผู้ป่วย / เลขประจำตัวประชาชน</h2>
		</div>

		<div class=' col-12 topnav d-flex justify-content-center'>
			<div class="form-group search-container">

				<input class='area_main' id="box_data" type="text" placeholder="กรอกเลขประจำตัวผู้ป่วย / เลขประจำตัวประชาชน" onkeyup="handleChange(this);">
				<button class='area_main' type="button" style="line-height:0px;" id="search_data"><i class="fa fa-search"></i></button>

			</div>
		</div>
		<div class=' col-12 topnav d-flex justify-content-center' style="font-size:2rem;">
			<button type="button" id="offline_mode" class='bodyth'><u>ลืม/ไม่มีเลขประจำตัวประชาชน?</u></button>
		</div>

		<div class="col-12" style="height: 45rem; display: flex; justify-content: center; align-items: center; padding-top: 4rem;">
			<?= single_img('kiosk/resources/images/BG/scanner.png', array('style' => 'width: 40rem')) ?>

		</div>


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
							<div class='col-10 content_alert' id="content_show_md" style="text-align: left; font-size: 48px;">123
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer row no-gutters" style="margin-bottom: 40px;padding: 0;border-top: none;">
				<div class='col-10'></div>
				<div class='col-4'><button type="button" class="ok_alert" id="conf_no" data-dismiss="modal">ตกลง</button></div>
			</div>

		</div>
	</div>
</div>
<!-- The Modal -->



<!-- The Modal alert -->
<div class="modal" id="scaning" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 960px !important;">
		<div class="modal-content" id="md_scan_cont">
			<!-- Modal body -->
			<div class="modal-body" style="margin-top:20px">
				<div class="row no-gutters" style="font-size: 4vw;">

					<div class='col-12 row form-control no-gutters form-group justify-content-md-center center' style="min-height: 50px;border:none;">
						<div class='col-10 logo_alert'></div>
					</div>
					<div class='col-12 row no-gutters justify-content-md-center center' style=" min-height: 20rem;">
						<div class='col-10' id="scan_status" style='text-align:center; align-items: center; display: inline;'></div>
					</div>
					<div class='col-12 row no-gutters justify-content-md-center center'>
						<div class='col-9 content_alert' id="content_show_md">
						</div>
						<div class='col-1'></div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
		</div>
	</div>
</div>
<!-- The Modal -->