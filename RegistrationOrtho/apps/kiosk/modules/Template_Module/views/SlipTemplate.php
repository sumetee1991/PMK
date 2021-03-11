<!DOCTYPE html>
<html>

<head>
	<title><?= (isset($Site_Title) ? $Site_Title : (defined(SITE_TITLE) ? SITE_TITLE : "DashQueue")); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?= (isset($css) ? assets_css($css) : ''); ?>

	<?= single_js('js/viewport.js'); ?>
</head>

<body style="position: absolute; width: 100%; z-index: 999; height: 100%;">
	<i id="loading2" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 45%;top: 45%; z-index: 9999; color:#ffc20e;font-size: 80px;"></i>
	
	<div class=' main_container form-group'>

		<div class="row no-gutters form-group" style="padding: 1rem;">

			<div class="col-10 " style="">
				<?= single_img('kiosk/resources/images/logo.png', array('class' => 'rotate-vert-center', 'style' => 'float: left; height: 81px')) ?>
				<div style="text-align: left; float: left; padding-left: 20px;">
					<p class="primary" style="">โรงพยาบาลพระมงกุฎเกล้า</p>
					<p class="secondary" style="line-height: 10px;">Phramongkutklao Hospital</p>
				</div>
			</div>

			<div class="col-2" style="padding-top: 1.2vw">
				<?= single_img('kiosk/resources/images/BG/on.png', array('style' => 'width: 36px; float: right; margin-right: 16px')) ?>
			</div>

		</div>
		<!-- slip -->

		<div class='col-12 slip_head'>
			<h1 style="font-size: 4rem;font-weight: bolder;">ตัวอย่างใบนำทาง</h1>
		</div>

		<div id="boxContent" style="width: 100%; height: 80%">


			<center>
				<div class="row col-12 center" style="background-image: url('<?= single_img_path('kiosk/resources/images/BG/slip_main.png'); ?>');background-repeat: no-repeat;
        height: 78rem; background-size: 34rem 100%; background-position: center; font-family: CS_PraJad; margin-top: 20px;">
					<div class="slip_main_div">

						<div class="slip_div_head">
							<div class="slip_div_inhead">
								<div style="text-align: left;">
									<span>
										<h5 style="color: #000000; font-weight: bold; font-size: 1.2rem;">โรงพยาบาลพระมงกุฎเกล้า</h5>
									</span>
								</div>
								<div style="text-align: right;">
									<span>
										<h5 style="color: #000000; font-weight: bold; font-size: 1.2rem;" id="type_person"></h5>
									</span>
								</div>
							</div>
						</div>
						<!-- head -->

						<div class="slip_div_refno">

							<div>
								<h1 style="font-size: 4.2rem;color: black;font-weight: bold !important;">ใบนำทาง</h1>
								<?= single_img('kiosk/resources/images/bar_code/000001.jpg') ?>
								<p style="color: black;" id="ref_no"></p>
							</div>
						</div>

						<div class="slip_div_user">
							<div>
								<h4><span id="pt_Name"></span></h4>
								<h6>HN </span><span id="pt_HN"></span></h6>
							</div>
						</div>

						<div class="slip_div_bd">
							<div class="slip_head_bd">
								<a>ขั้นตอนการเข้ารับบริการ</a>
							</div>



							<?php
							if (isset($Content) && count($Content) > 0) {
								foreach ($Content as $result) :
									$this->load->view($Module . '/' . $result);
								endforeach;
							}
							?>



						</div>
						<div class="slip_footer">
							<div class="row">
								<div class="col-md-12 slip_textbox_1" style="margin-bottom: 6px;">
									<p style="color: black;font-weight: bold !important;">** ในกรณีที่ผู้ป่วยมี Smart Phone สามารถสแกน QR Code เพื่อใช้งานระบบออนไลน์</p>
								</div>
							</div>
							<div class="slip_footer_div1 row no-gutters col-12 form-group">
								<div class="slip_footer_img col-6 center">
									<?= single_img('kiosk/resources/images/qr_code/qr.jpg') ?>
								</div>
								<div class="slip_footer_list col-6">
									<p>1. เข้าแอปพลิเคชัน Line</p>
									<p>2. กดเพิ่มเพื่อน</p>
									<p>3. กดปุ่ม QR Code</p>
									<p>4. สแกน QR Code</p>
									<p>5. เมื่อถึงคิว ให้ไปตามสถานที่่ที่แจ้งในระบบ</p>
								</div>
							</div>
							<div class="row no-gutters col-12 slip_footer_div2 form-group">
								<div class="col-6">
									<p style="color: black;">ลงทะเบียน <span id="show_time"></span></p>
								</div>
								<div class="col-6" style="text-align: right;">
									<p style="color: black;">print: <span id="show_date"></span></p>
								</div>
							</div>
						</div>
						<!-- even -->
					</div>
				</div>
			</center>

		</div>
		<div class='col-12 row' style="margin-top: 7rem; display: flex; justify-content: flex-end; padding-right: 10%;">
			<div style="">
				<h1 style="font-size: 4rem;font-weight: bolder; float: left;">กรุณารับใบนำทาง&nbsp;&nbsp;&nbsp;&nbsp;</h1>
				<?= single_img('kiosk/resources/images/icon/slip.png', array('style' => 'height: 7rem; float: right;', 'class' => 'shake_vertical')) ?>
			</div>
		</div>
	</div>

	<div class="lds-facebook">
		<div></div>
		<div></div>
		<div></div>
	</div>
	</div>

	<?= (isset($js) ? assets_js($js) : ''); ?>
	<?= (isset($node_modules) ? assets_node($node_modules) : ''); ?>

	<?php
	if (isset($Script) && count($Script) > 0) {
		foreach ($Script as $result) :
			$this->load->view($Module . '/' . $result);
		endforeach;
	}
	?>

</body>

</html>

<script>
	var newdate = new Date();
	var date = newdate.getDate() + '/' + (newdate.getMonth() + 1) + '/' + (newdate.getFullYear() + 543);
	var time_h = (newdate.getHours() < 10) ? '0' + newdate.getHours() : newdate.getHours();
	var time_m = (newdate.getMinutes() < 10) ? '0' + newdate.getMinutes() : newdate.getMinutes();
	var time_result = time_h + ':' + time_m + ' น.';
	$("#show_date").html(date + ' ' + time_result);
	$("#show_time").html(time_result);
</script>

<!--  block (drag coppy clickright) -->
<script language="JavaScript1.2">
	function disableselect(e) {
		return false
	}

	function reEnable() {
		return true
	}
	//if IE4+
	document.onselectstart = new Function("return false")
	//if NS6
	if (window.sidebar) {
		document.onmousedown = disableselect
		document.onclick = reEnable
	}

	function clickIE() {
		if (document.all) {
			//alert(message);
			return false;
		}
	}

	function clickNS(e) {
		if (document.layers || (document.getElementById && !document.all)) {
			if (e.which == 2 || e.which == 3) {
				//alert(message);
				return false;
			}
		}
	}
	if (document.layers) {
		document.captureEvents(Event.MOUSEDOWN);
		document.onmousedown = clickNS;
	} else {
		document.onmouseup = clickNS;
		document.oncontextmenu = clickIE;
	}
	document.oncontextmenu = new Function("return false")
</script>
