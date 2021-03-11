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

	<style>
		@font-face {
			font-family: 'Mitr-Light';
			src: url('<?= staticmain() ?>fonts/Mitr/Mitr-Light.ttf');
		}

		@font-face {
			font-family: 'Lato-Light';
			src: url('<?= staticmain() ?>fonts/Lato/Lato-Light.ttf');
		}

		@font-face {
			font-family: 'CSPraJad-bold';
			src: url('<?= staticmain() ?>fonts/CS_PraJad/CSPraJad-bold.otf');
		}

		@font-face {
			font-family: 'Lato-Bold';
			src: url('<?= staticmain() ?>fonts/Lato/Lato-Bold.ttf');
		}


		.headth {
			font-family: 'Mitr-Light';
		}

		.headen,
		.bodyen {
			font-family: 'Lato-Light';
		}

		.bodyth {
			font-family: 'CSPraJad-bold';
		}

		.numberth {
			font-family: 'Lato-Bold';
		}
	</style>

	<?= single_js('js/viewport.js'); ?>

	<?php


	$dataPt = $this->session->userdata('PatientInfo');


	$idcard = '';
	$prename = '';
	$forename = '';
	$surname = '';
	$hn = '';
	$birth = '';

	// var_dump($dataPt['PtDetail']);
	$idcard = (!isset($dataPt['data']) || $dataPt['data']['pidxxx'] == '') ? '' : $dataPt['data']['pidxxx'];
	$prename = (!isset($dataPt['data']) || $dataPt['data']['prename'] == '') ? '' : $dataPt['data']['prename'];
	$forename = (!isset($dataPt['data']) || $dataPt['data']['forename'] == '') ? '' : $dataPt['data']['forename'];
	$surname = (!isset($dataPt['data']) || $dataPt['data']['surname'] == '') ? '' : $dataPt['data']['surname'];
	$hn = (!isset($dataPt['data']) || @$dataPt['data']['hn'] == '' || @$dataPt['data']['hn'] == null) ? '-' : $dataPt['data']['hn'];
	$birth = (!isset($dataPt['data']) || $dataPt['data']['dob'] == '') ? '-' : $dataPt['data']['dob'];
	$citizenid_xxx = (!isset($dataPt['data']) || @$dataPt['data']['pidxxx'] == '') ? '-' : @$dataPt['data']['pidxxx'];



	$imgshow = "AnonymousAvatar.png";

	if ($dataPt['data']['gender'] == 'm') {

		$imgshow = "YoungmanAvatar.png";
	} else if ($dataPt['data']['gender'] == 'f') {

		$imgshow = "WomenAvatar.png";
	} else {

		$imgshow = "AnonymousAvatar.png";
	}

	?>
</head>

<body>
	<div class='main_container'>

		<div class="row no-gutters form-group" style="padding: 1rem;">

			<div class="col-10 " style="">

				<?= title_img('kiosk/resources/images/logo.png', array('style' => 'float: left; height: 81px', 'class' => 'rotate-vert-center')) ?>

				<div style="text-align: left; float: left; padding-left: 20px;">
					<p class="primary headth" style="">โรงพยาบาลพระมงกุฎเกล้า</p>
					<p class="secondary headth" style="">Phramongkutklao Hospital</p>
				</div>
			</div>

			<div class="col-2" style="padding-top: 1.2vw">
				<?= single_img('kiosk/resources/images/BG/on.png', array('style' => 'width: 36px; float: right; margin-right: 16px')) ?>
			</div>

		</div>

		<div class="row no-gutters form-group center" style="box-shadow: 0px 3px 8px 1px #e1e0dc; border-radius: 4px 4px 4px 60px; padding:14px 30px 30px 30px ">
			<div class="col-12 div_in_center center" style="    margin-bottom: 1.4rem;">
				<div class=" " style="border-bottom: 2px solid #9b9b99; text-align: center; width: 720px;">
					<h1 style="font-size: 4.9rem; font-weight: 100 !important;" class='bodyth'>ยินดีต้อนรับ</h1>
				</div>
			</div>

			<div class="chk_img_user" style="text-align: center;">
				<span id="imgavatar"><?= single_img("kiosk/resources/images/$imgshow", array('class' => '_img_user')) ?></span>
			</div>

			<div class="col-9 ct_user2" style="">
				<h4 class="col-12 row form-control headth"><span class='col-12' id="pt_Name"><?= $prename . $forename . ' ' . $surname ?></span></h4>
				<h6 class='col-12 row headth'><span class='col-7' style='text-align:left; font-weight: bold !important;'>เลขประจำตัวประชาชน</span><span style='text-align:left; margin-left:-48px;' class='col-5 numberth' id="pt_IdCard"><?= @$citizenid_xxx ?></span></h6>
				<h6 class='col-12 row headth'><span class='col-6' style='text-align:left; font-weight: bold !important;'>วัน/เดือน/ปีเกิด</span><span style='text-align:left; margin-left:-40px;' class='col-6 numberth' id="pt_Birth"><?= $birth ?></span></h6>
				<h6 class='col-12 row headen'><span class='col-3' style='text-align:left; font-weight: bold !important;'>HN</span><span style='text-align:left;margin-left:-40px;' class='col-6 numberth' id="pt_HN"><?= $hn ?></span></h6>
				<button class="btn_home logout headth" type="button" id="btn_go_home" style='outline:none;'>ออกจากระบบ</button>
			</div>


		</div>


		<div class='form-group' id="boxContent" style="min-height: 65rem; box-shadow: 0px 3px 8px 1px #e1e0dc; border-radius: 4px 4px 4px 60px; padding: 14px 26px;">
			<?php
			if (isset($Content) && count($Content) > 0) {
				foreach ($Content as $result) :
					$this->load->view($Module . '/' . $result);
				endforeach;
			}
			?>
		</div>

		<div class="form-group row justify-content-md-center align-items-center " style="padding-top: 1rem;">
			<div class="col-3">
				<button class="btn_back backpage" type="button" id="btn_backpage" style='outline:none;'>
					< ย้อนกลับ</button> </div> <div class="col-8" style="">


						<div class="step_content">
							<ul class="progressbar" style="" id="list_number_page">

							</ul>
						</div>

			</div>
		</div>

	</div>

	<?php

	?>

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
	<?php echo Modules::run('Websocket/SocketConection') ?>
	//console.log(<?php echo json_encode($this->session->userdata('PatientInfo')); ?>, 'PatientInfo');
	console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'tmp_check_numberPage_in_template');

	var UrlBaseKiosk = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?> + '/';

	var getses_number = <?php echo json_encode($this->session->userdata('SessionNumPage')); ?>;

	var template_sess_main = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;

	try {
		var num_page_tmp = getses_number['NumberPage']['NumberPage'];
		var list_num_pagenow = getses_number['NumberPage']['NowPage'];
		// alert(list_num_pagenow+'textpage');
	} catch (e) {
		var num_page_tmp = '';
		var list_num_pagenow = '';
	}








	var count_page = 1;

	var text_page = '';

	for (var i = 0; i < num_page_tmp; i++) {
		text_page += '<li class="step_page " value="' + parseInt(count_page++) + '"></li>';
	}
	$("#list_number_page").html(text_page);
	$(".step_page[value='" + list_num_pagenow + "']").addClass('active');

	$("#btn_go_home").click(function() {
		window.location.href = UrlBaseKiosk;
	});

	$("#btn_backpage").click(function() {
		window.history.back();
		return;
		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
	// alert(UrlBaseCont);
		$.ajax({ //create session
				url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
				type: "post",
				
				data: {
					pagenow: (parseInt(list_num_pagenow) - 1)
				},
				success: function(msg) {
					console.log(msg);

					
				},
				error: function(msg) {
					console.log(msg, 'error');
				}
			});
		

		$(this).attr('disabled', true);
		
		var pagedirectnow = <?php echo json_encode($this->session->userdata('pageredirect')) ?>;

		var url = $(location).attr('href');
	
		var parts = url.split("/");
		var mainurl = '';

		var filtered = parts.filter(function(el) {
			return el != '';
		});

		var tem_url = filtered[filtered.length - 1];

// alert(tem_url);
		$.ajax({
			url: UrlBaseCont + '/StepProcessing/backPageRedirect',
			type: "post",
			async:false,
			data:{
				tem_url:tem_url
			},
			success: function(msg) {
				console.log(JSON.parse(msg), 'back page');
				window.location.href = JSON.parse(msg);
			}
		});


	});
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
<script>
	$(document).ready(function() {




	});
</script>

<script>
	var EventTimeout = 0;
	var LimitTimeout = 300;


	setInterval(() => {
		if (EventTimeout == LimitTimeout) {
			console.log(EventTimeout, 'EventTimeout');
			window.location.href = UrlBaseKiosk;
		}
		EventTimeout++;
	}, 1000);
</script>

<script>
	console.log(<?php echo json_encode($this->session->userdata('pageredirect')); ?>, 'pageredirect');

	var pagedirectnow = <?php echo json_encode($this->session->userdata('pageredirect')) ?>;

	function createpageRedirect(worklistgroup = null) {

		var url = $(location).attr('href');
		var parts = url.split("/");
		var mainurl = '';

		var filtered = parts.filter(function(el) {
			return el != '';
		});

		for (var i = 0; i < (filtered.length - 1); i++) {
			if(i == 0){
				mainurl += filtered[i] + '//';
			}else{
				mainurl += filtered[i] + '/';
			}
		}
		var tem_url = filtered[filtered.length - 1];

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
		$.ajax({
			url: UrlBaseCont + '/StepProcessing/createPageRedirect',
			type: "post",
			async:false,
			data: {
				fullurl: mainurl,
				worklistgroup: worklistgroup
			},
			success: function(msg) {
				//console.log(JSON.parse(msg), 'createpageRedirect');
				//alert(JSON.parse(msg)['indexpagenow']+' '+tem_url);
				$.ajax({
					url: UrlBaseCont + '/StepProcessing/createPageRedirect',
					type: "post",
					async:false,
					data: {
						indexpage: JSON.parse(msg)['indexpagenow'],
						tem_url:tem_url,

					},
					success: function(msg) {
						//console.log(JSON.parse(msg), 'createpageRedirect++');
					}
				});
			}
		});
	}
</script>