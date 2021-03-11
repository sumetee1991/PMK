<script>
	<?php echo Modules::run('Websocket/SocketConection') ?>


	console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
	console.log(<?php echo json_encode($this->session->userdata('SessionClinicName')); ?>, 'SessionClinicName');

	var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
	var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

	$.ajax({ // send print queue
		url: UrlBaseCont + '/StepProcessing/ClearSessionOffline',
		method: "post",
		dataType: 'json',
		success: function(msg) {
			console.log(msg, 'ClearSessionOffline');
		},
		error: function(msg) {
			console.log(msg);
		}
	}); //ajax


	$.ajax({ // send print queue
		url: baseurlMid + '/api/kiosk/getSlip',
		method: "post",
		dataType: 'json',
		headers: {
			'Access-Control-Allow-Origin': '*',
			'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
			'Access-Control-Allow-Headers': '*',
			'Authorization': 'Basic YXJtOjEyMzQ='
		},
		data: {
			Slip: '1',
			location: '7',
			step: 'next7',
			kiosk_location: kiosk_location
		},
		success: function(response) {
			$('#loading2').remove();
			TimeoutRedirect();
			console.log(response, 'zaza');
			// var data = msg;
			// $("#test").html(data);
			console.log(response, 'kiosk_hn4444');
			var datax = [];
			var data = [];
			var isLocation = 0;
			for (var j = 0; j < response.data.length; j++) {
				if (response.data[j].kiosk_location == kiosk_location) {
					isLocation++;
					datax.push(response.data[j])
				}
			}
			data.data = datax;
			console.log(data, 'kiosk_hn3333');
			if (isLocation != 0) {

				console.log(response, 'slip_station');
				if (response['kiosk_location'] == kiosk_location) {


					var html = '';
					for (var i = 0; i < data.data.length; i++) {

						var queno_show = '';
						var waitingpayor = '';

						try {
							idcard = data.data[i]['infoData']['idcard'];
							prefixname_th = data.data[i]['infoData']['prefixname_th'];
							firstname_th = data.data[i]['infoData']['firstname_th'];
							lastname_th = data.data[i]['infoData']['lastname_th'];
							hn_th = data.data[i]['infoData']['hnno'];
							patientcometype = data.data[i]['patientcometype'];
							console.log(data.data[i], "TEST REFNO !!!")
							if (data.data[0]['refnoxx'] != null) {
								refnoxx = data.data[i]['refnoxx'];
							} else {
								refnoxx = data.data[i]['infoData']['refnoxx'];
							}
							$("#ref_no").html('Ref no : ' + refnoxx);
							$("#type_person").html(patientcometype);
						} catch (e) {
							idcard = '';
							prefixname_th = '';
							firstname_th = '';
							lastname_th = '';
							hn_th = '';
							if (data.data[i]['refnoxx'] != null) {
								refnoxx = data.data[i]['refnoxx'];
							} else {
								refnoxx = data.data[i]['infoData']['refnoxx'];
							}
							$("#ref_no").html('Ref no : ' + refnoxx);
							$("#type_person").html(patientcometype);
						}

						// if (data["data"]["process"][i]["uid"] == '3' || data["data"]["process"][i]["uid"] == '5') {
						//     queno = data["data"]['queno'];
						// }

						if (data.data[i].queueno != null) {
							queno_show = data.data[i].queueno;
						}

						// if (data.data[i].waitingpayor) {
						// 	waitingpayor = data.data[i].waitingpayor;
						// }

						// html += "<div class='slip_box form- col-12' style='height:auto; display:inline-block; border-bottom:1px dashed black; padding-top:0px;'>";
						// html += "<div class='slip_box_01 col-1'>";
						// html += "<a>" + (i + 1) + "</a>";
						// html += "</div>";
						// html += "<div class='slip_box_02 col-8' style='text-align:right'>";
						// html += "<a>" + data.data[i].title + "</a> <br>";
						// html += "<a>รอ คิว</a>";
						// html += "</div>";
						// html += "<div class='slip_box_03 col-3' style=''>";
						// html += "<p>" + queno_show + "</p>";
						// html += "</div>";
						// html += "</div>";

						var waitinghn = (data.data[i].waitinghn == null) ? '-' : data.data[i].waitinghn;
						var waitingpayor = (data.data[i].waitingpayor == null) ? '-' : data.data[i].waitingpayor;


						var SessionClinicName = <?php echo json_encode($this->session->userdata('SessionClinicName')); ?>;
						var clinicname_show = (!SessionClinicName) ? '' : SessionClinicName['clinicName'];

						if (data.data[i]['groupprocessuid'] == '1') {
							if (data.data[i]['queueno']) {
								html += "<div class='slip_box row'>";
								html += "<div class='slip_box_02 '>";
								html += "<a>" + (i + 1) + '. ' + data.data[i].flowname + " ที่ช่อง " + data.data[i].allcounter + " </a>";
								html += "<div class='slip_box_03' style=''>";
								html += "<p style='font-weight: bold !important; color:#000;'></p>";
								html += "</div>";
								html += "</div>";
								html += "<div class='slip_box_text'>";
								html += "<p style='font-weight: bold !important; color:#000;'>" + data.data[i].title + "</p>";
								html += "</div>";
								html += "<div class='slip_box_number'>";
								html += "<span class=''>" + queno_show + "</span>";
								html += "<p style='font-weight: bold !important; color:#000;' class=''>(จำนวนคิวที่รอ : " + waitinghn + " คิว)</p>";
								html += "</div>";
								html += '<span>* คิวทำประวัติผู้ป่วยจะยังไม่ถูกเรียก จนกว่าจะคัดกรองเสร็จสิ้น</span>';
								html += "</div>";
							} else {
								html += "<div class='slip_box'>";
								html += "<div class='slip_box_02'>";
								html += "<a style='font-weight: bold !important; color:#000;'>" + (i + 1) + '. ' + data.data[i].flowname + "</a>";
								html += "<div class='slip_box_03' style=''>";
								html += "<p style='font-weight: bold !important; color:#000;'></p>";
								html += "</div>";
								html += "</div>";
								html += "</div>";
							}
						} else if (data.data[i]['groupprocessuid'] == '2') {
							if (queno_show == '') {
								html += "<div class='slip_box row'>";
								html += "<div class='slip_box_02 '>";
								html += "<a>" + (i + 1) + '. ' + data.data[i].flowname + " ที่ช่อง " + data.data[i].counterpayor + " </a>";
								html += "<div class='slip_box_03' style=''>";
								html += "<p style='font-weight: bold !important; color:#000;'></p>";
								html += "</div>";
								html += "</div>";
								html += "</div>";
							} else {
								html += "<div class='slip_box row'>";
								html += "<div class='slip_box_02 '>";
								html += "<a>" + (i + 1) + '. ' + data.data[i].flowname+ " ที่ช่อง " + data.data[i].counterpayor + " </a>";
								html += "<div class='slip_box_03' style=''>";
								html += "<p style='font-weight: bold !important; color:#000;'></p>";
								html += "</div>";
								html += "</div>";
								html += "<div class='slip_box_text'>";
								html += "<p style='font-weight: bold !important; color:#000;'>" + data.data[i].title + "</p>";
								html += "</div>";
								html += "<div class='slip_box_number'>";
								html += "<span class=''>" + queno_show + "</span>";
								html += "<p style='font-weight: bold !important; color:#000;' class=''>(จำนวนคิวที่รอ : " + waitingpayor + " คิว)</p>";
								html += "</div>";
								// html += '<span>* คิวเปิดสิทธิจะยังไม่ถูกเรียก จนกว่าจะคัดกรอง และ/หรือ ทำประวัติเสร็จสิ้น</span>';
								html += "</div>";
							}
						} else if (data.data[i]['worklistuid'] == '6') { // "ติดต่อห้องตรวจ"
							html += "<div class='slip_box'>";
							html += "<div class='slip_box_02'>";
							html += "<a style='font-weight: bold !important; color:#000;'>" + (i + 1) + '. ' + data.data[i].flowname + "</a>";
							html += "<div class='slip_box_03' style=''>";
							html += "<p style='font-weight: bold !important; color:#000;'></p>";
							html += "</div>";
							html += "</div>";
							html += "</div>";
						} else {
							html += "<div class='slip_box'>";
							html += "<div class='slip_box_02'>";
							html += "<a style='font-weight: bold !important; color:#000;'>" + (i + 1) + '. ' + data.data[i].flowname + "</a>";
							html += "<div class='slip_box_03' style=''>";
							html += "<p style='font-weight: bold !important; color:#000;'></p>";
							html += "</div>";
							html += "</div>";
							html += "</div>";
						}

					}

					$("#area_list").html(html);
					//  ^^ data process


					console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'test');
					var data_ses = <?php echo json_encode($this->session->userdata('SessionMain')) ?>;


					console.log(data_ses['UserInfo'], 'zaza');

					if (data_ses['UserInfo'][0]) { //ปร้ิ้น ปกติ
						var new_idcard = data_ses['UserInfo'][0]['infoData']['idcard'].substr(0, data_ses['UserInfo'][0]['infoData']['idcard'].length - 3);
						// $('#pt_Name').html(prefixname_th + firstname_th + ' ' + lastname_th);
						// $('#pt_IdCard').html(new_idcard + 'xxx');
						// $('#pt_Birth').html(data_ses['UserInfo'][0]['infoData']['issuedate']);
						// $('#pt_HN').html(hn_th);
					} else { //รี ปริ้น
						var new_idcard = data_ses['UserInfo']['data'][0]['idcard'].substr(0, data_ses['UserInfo']['data'][0]['idcard'].length - 3);
						//alert(new_idvard);
						// $('#pt_Name').html(data_ses['UserInfo']['data'][0]['prefixname_th'] + data_ses['UserInfo']['data'][0]['firstname_th'] + ' ' + data_ses['UserInfo']['data'][0]['lastname_th']);
						// $('#pt_IdCard').html(new_idcard + 'xxx');
						// $('#pt_Birth').html(data_ses['UserInfo']['data'][0]['issuedate']);
						// $('#pt_HN').html(hn_th);
					}
					// console.log(data_ses['UserInfo']['data'][0]['prefixname_th'], "TEST VALUE");
				}
			}
		},
		error: function(msg) {
			console.log(msg);
		}

	}); //ajax


	var idcard = '';
	var prefixname_th = '';
	var firstname_th = '';
	var lastname_th = '';
	var hn_th = '';
	var patientcometype = '';
	var refnoxx = '';

	midSocket.on('slip_station', function(response) {


	});






	var NextToScannerPage = baselocal + <?php echo Modules::run('Websocket/ScannerPage') ?>;

	// setTimeout(function() {
	// 	window.location.href = NextToScannerPage;
	// }, 8000);

	const TimeoutRedirect = () => {
		setTimeout(function() {
			window.location.href = NextToScannerPage;
		}, 4000);
	}
</script>