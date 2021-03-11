<script>
	$(document).ready(function() {
		$.ajaxSetup({
			cache: false
		});

		<?php echo Modules::run('Websocket/SocketConection'); ?>

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		var url_step_two = baselocal + <?php echo Modules::run('Websocket/NextStepTwo') ?>;
		var url_step_six = baselocal + <?php echo Modules::run('Websocket/NextToAppointment') ?>;


		console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;


		console.log(UrlBaseCont);

		$.ajax({
			url: baseurlMid + '/api/kiosk/hn',
			method: "post",
			dataType: 'json',
			headers: {
				'Access-Control-Allow-Origin': '*',
				'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
				'Access-Control-Allow-Headers': '*',
				'Authorization': 'Basic YXJtOjEyMzQ='
			},
			data: {
				location: '1',
				step: 'next8',
				scan: 'false',
				kiosk_location: kiosk_location
			},
			success: function(msg) {
				console.log(msg, "KIOSK HN");

				console.log(msg.kiosk_location + " : " + kiosk_location, '/hn');

				if (msg.kiosk_location == kiosk_location) {
					midSocketkiosk_hn(msg['data']);
				}
			},
			error: function(msg) {
				//console.log(msg);
			}

		});

		var patient_uid = '';
		var idcard_reprint = '';
		var group = '';

		var alldata_ses = '';

		var session_idcard = '';
		var session_hn = '';

		var clinicname = '';

		function midSocketkiosk_hn(data) {
			console.log("midsocket_hn",data);
			//midSocket.on('kiosk_hn', (data) => {
				var kiosklocate = [];
				var isLocation = 0;
				for (var j = 0; j < data.length; j++) {
					if (data[j].kiosk_location == kiosk_location) {
						isLocation++;
						kiosklocate.push(data[j])
					}
				}
				// console.log(data, 'kiosk_hn3333');

				if(data.length) {

				} else {
					// alert('1');
					// var NextToScannerPage = baselocal + <?php echo Modules::run('Websocket/ScannerPage') ?>;
					// window.location.href = NextToScannerPage;
				}
				if (isLocation != 0) {
					if (data['step'] == "next8scan") {
						// var patient_uid = '';
						// var idcard_reprint = '';
						$.ajax({ //create session user info
							url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
							type: "post",
							dataType: "json",
							data: {
								patient: kiosklocate
							},
							success: function(msg) {
								console.log(msg, 'kiosk_hn 1');

								var data = msg;
								alldata_ses = data;


								session_idcard = data['UserInfo'][0]['infoData']['idcard'];
								session_hn = data['UserInfo'][0]['infoData']['hnno'];

								patient_uid = data['UserInfo'][0]['infoData']['patient_uid'];
								idcard_reprint = data['UserInfo'][0]['infoData']['idcard'];
								group = data['UserInfo'][0]['group'];
								$("#conf_no").val(group);

								if (data['UserInfo'][0]['clinicname']) {
									//clinicname = data['UserInfo'][0]['clinicname'].replace(".", ",");
									clinicname = '';

									$.ajax({
										url: UrlBaseCont + '/StepProcessing/CreateclinicName',
										type: "post",
										async: false,
										dataType: "json",
										data: {
											Appointment: 'Appointment',
											clinicName: clinicname
										},
										success: function(msg) {
											console.log(msg, 'SessionClinicName');
										}
									}); //ajax
								}


								var idcard = (data['UserInfo'][0]['infoData']['idcard'] == '') ? '-' : data['UserInfo'][0]['infoData']['idcard'];
								var prename = (data['UserInfo'][0]['infoData']['prefixname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['prefixname_th'];
								var forename = (data['UserInfo'][0]['infoData']['firstname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['firstname_th'];
								var surname = (data['UserInfo'][0]['infoData']['lastname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['lastname_th'];
								var hn = (data['UserInfo'][0]['infoData']['hnno'] == '' || data['UserInfo'][0]['infoData']['hnno'] == null) ? '-' : data['UserInfo'][0]['infoData']['hnno'];
								var birth = (data['UserInfo'][0]['infoData']['issuedate'] == '' || !data['UserInfo'][0]['infoData']['issuedate']) ? '-' : data['UserInfo'][0]['infoData']['issuedate'];
								var citizenid_xxx = (data['UserInfo'][0]['infoData']['citizenid_xxx'] == '') ? '-' : data['UserInfo'][0]['infoData']['citizenid_xxx'];
								$("#pt_Name").html(prename + forename + ' ' + surname);
								$("#pt_IdCard").html(citizenid_xxx);
								$("#pt_Birth").html(birth);
								$("#pt_HN").html(hn);
								var num_ = 0;
								var css = '';
								var html = '';
								$.each(data, function(index, value) {
									console.log('555');

									html += "<div class='row no-gutters col-12 justify-content-md-center'>";
									html += "<div class='col-1 center ps_margin_r'>";
									html += '<?= single_img('kiosk/resources/images/icon/G1.png', array('class' => '_img_02')); ?>';
									html += "<p class='ps_runnum'></p>";
									html += "</div>";
									html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
									html += "<a>ออกคิวเข้ารับบริการ</a>";
									html += "</div>";
									html += "<div class='col-2'>";
									html += "<span class='text_comp'>เสร็จสิ้น</span>";
									html += "</div>";
									html += "</div>";

									for (var i = 0; i < value.length; i++) {

										var imgy1 = '<?= single_img('kiosk/resources/images/icon/Y1.png', array('class' => '_img_02')); ?>';
										var imgy2 = '<?= single_img('kiosk/resources/images/icon/Y2.png', array('class' => '_img_02')); ?>';
										var sendimg = '';

										if ((i + 1) == value.length) {
											sendimg = imgy2;
										} else {
											sendimg = imgy1;
										}



										var numrow = (num_ += 1);
										var flowname = value[i]['flowname'];
										var queueno = value[i]['queueno'];
										var worklistuid = value[i]['worklistuid'];
										var closevs = value[i]['closevs'];
										var closenewhn = value[i]['closenewhn'];
										var count_patient_newhn = value[i]['count_patient_newhn'];
										var closepayor = value[i]['closepayor'];
										var count_patient_payor = (value[i]['count_patient_payor'] == null) ? '' : value[i]['count_patient_payor'];

										html += show_list_row(worklistuid, numrow, flowname, closevs, closenewhn, count_patient_newhn, closepayor, count_patient_payor, sendimg);

									}

									$("#area_worklist").html(html);
								});
								loop_classwk();

							},
							error: function(msg) {
								console.log(msg, 'error');
							}
						});
					} else {
						console.log(data, "not next8scan");
						$.ajax({ //create session user info
							url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
							type: "post",
							dataType: "json",
							data: {
								patient: kiosklocate
							},
							success: function(msg) {
								console.log(msg, 'kiosk_hn 2');

								var data = msg;

								var imgMan = "<?=base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
								var imgWoman = "<?=base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
								if(data['UserInfo'] != null){
									if(data['UserInfo'][0]['infoData']['gender'] == 'male'){
										$("#imgavatar").find("img").attr("src", imgMan);
									}else if(data['UserInfo'][0]['infoData']['gender'] == 'female'){
										$("#imgavatar").find("img").attr("src", imgWoman);
									}else if(data['UserInfo'][0]['infoData']['gender'] == ''){
										
									}
								}

								alldata_ses = data;

								session_idcard = data['UserInfo'][0]['infoData']['idcard'];
								session_hn = data['UserInfo'][0]['infoData']['hnno'];
								patient_uid = data['UserInfo'][0]['infoData']['patient_uid'];
								console.log(patient_uid, 'kiosk_hn 3ss');
								idcard_reprint = data['UserInfo'][0]['infoData']['idcard'];
								group = data['UserInfo'][0]['group'];
								$("#conf_no").val(group);

								if (data['UserInfo'][0]['clinicname']) {
									//clinicname = data['UserInfo'][0]['clinicname'].replace(".", ",");
									clinicname = '';


									$.ajax({
										url: UrlBaseCont + '/StepProcessing/CreateclinicName',
										type: "post",
										async: false,
										dataType: "json",
										data: {
											Appointment: 'Appointment',
											clinicName: clinicname
										},
										success: function(msg) {
											console.log(msg, 'SessionClinicName');
										}
									}); //ajax
								}





								var idcard = (data['UserInfo'][0]['infoData']['idcard'] == '') ? '-' : data['UserInfo'][0]['infoData']['idcard'];
								var prename = (data['UserInfo'][0]['infoData']['prefixname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['prefixname_th'];
								var forename = (data['UserInfo'][0]['infoData']['firstname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['firstname_th'];
								var surname = (data['UserInfo'][0]['infoData']['lastname_th'] == '') ? '' : data['UserInfo'][0]['infoData']['lastname_th'];
								var hn = (data['UserInfo'][0]['infoData']['hnno'] == '' || data['UserInfo'][0]['infoData']['hnno'] == null) ? '-' : data['UserInfo'][0]['infoData']['hnno'];
								var birth = (data['UserInfo'][0]['infoData']['issuedate'] == '' || !data['UserInfo'][0]['infoData']['issuedate']) ? '-' : data['UserInfo'][0]['infoData']['issuedate'];
								var citizenid_xxx = (data['UserInfo'][0]['infoData']['citizenid_xxx'] == '') ? '-' : data['UserInfo'][0]['infoData']['citizenid_xxx'];
								$("#pt_Name").html(prename + forename + ' ' + surname);
								$("#pt_IdCard").html(citizenid_xxx);
								$("#pt_Birth").html(birth);
								$("#pt_HN").html(hn);
								var num_ = 0;
								var html = '';
								$.each(data, function(index, value) {
									console.log(value);

									html += "<div class='row no-gutters col-12 justify-content-md-center'>";
									html += "<div class='col-1 center ps_margin_r'>";
									html += '<?= single_img('kiosk/resources/images/icon/G1.png', array('class' => '_img_02')); ?>';
									html += "<p class='ps_runnum'></p>";
									html += "</div>";
									html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
									html += "<a>ออกคิวเข้ารับบริการ</a>";
									html += "</div>";
									html += "<div class='col-2'>";
									html += "<span class='text_comp'>เสร็จสิ้น</span>";
									html += "</div>";
									html += "</div>";

									for (var i = 0; i < value.length; i++) {

										var imgy1 = '<?= single_img('kiosk/resources/images/icon/Y1.png', array('class' => '_img_02')); ?>';
										var imgy2 = '<?= single_img('kiosk/resources/images/icon/Y2.png', array('class' => '_img_02')); ?>';
										var sendimg = '';

										if ((i + 1) == value.length) {
											sendimg = imgy2;
										} else {
											sendimg = imgy1;
										}



										var numrow = (num_ += 1);
										var flowname = value[i]['flowname'];
										var queueno = value[i]['queueno'];
										var worklistuid = value[i]['worklistuid'];
										var closevs = value[i]['closevs'];
										var closenewhn = value[i]['closenewhn'];
										var count_patient_newhn = value[i]['count_patient_newhn'];
										var closepayor = value[i]['closepayor'];
										var count_patient_payor = (value[i]['count_patient_payor'] == null) ? '' : value[i]['count_patient_payor'];

										html += show_list_row(worklistuid, numrow, flowname, closevs, closenewhn, count_patient_newhn, closepayor, count_patient_payor, sendimg, clinicname);

									}

									$("#area_worklist").html(html);
								});

								loop_classwk();


								// $.ajax({ //get worklist 
								//     url: UrlBaseCont + '/StepProcessing/PersonType/Get_Worklist',
								//     type: "post",
								//     dataType: "json",
								//     data: {
								//         patient_uid: patient_uid
								//     },
								//     success: function(data) {
								//         console.log(data);
								//         var html = '';
								//         var num = 0;

								//         $.each(data, function(index, value) {
								//             var css = '';
								//             if (value['uid'] == 1 || value['uid'] == 2) {
								//                 css = 'opacity:0.5;';
								//             }


								//         });

								//         $("#area_worklist").html(html);

								//     },
								//     error: function(msg) {
								//         alert(msg);
								//     }
								// });
							},
							error: function(msg) {
								console.log(msg, 'error');
							}
						});
					}
				}

			//});
		}


		$("#DisCardQueue").click(function() {

			EventTimeout = 0; // check redirect

			$("#md_alert_scan").modal('show');
			$("#content_show_md").html('คิวปัจจุบันของคุณจะถูกยกเลิกทั้งหมด คุณต้องขอคิวใหม่หรือไม่ ?');

		});

		$("#conf_no").click(function() {

			var TypePerson = $(this).val();

			var alldata_group = alldata_ses['UserInfo'][0]['group'];
			var alldata_session = alldata_ses['UserInfo'][0];
			var url_step_two = baselocal + <?php echo Modules::run('Websocket/NextStepTwo') ?>;
			var url_step_three = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
			var GotoPccClear = baselocal + <?php echo Modules::run('Websocket/NextToProcessServiceClear') ?>;
			var url_step_six = baselocal + <?php echo Modules::run('Websocket/NextToAppointment') ?>;

			EventTimeout = 0; // check redirect


			$.ajax({
				url: UrlBaseCont + '/StepProcessing/PersonType/Discard_queue',
				method: "post",
				dataType: 'json',
				data: {
					patient_uid: patient_uid,
					active: 'N'
				},
				success: function(msg) {
					console.log(msg);
					$.ajax({ // send print queue
						url: baseurlMid + '/api/kiosk/discard_queue',
						method: "post",
						dataType: 'json',
						headers: {
							'Access-Control-Allow-Origin': '*',
							'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
							'Access-Control-Allow-Headers': '*',
							'Authorization': 'Basic YXJtOjEyMzQ='
						},
						data: {
							patient_uid: patient_uid,
							DISCARD: '1',
							alldata_group: alldata_group,
							alldata_session: JSON.stringify(alldata_session),
							location_page: 'appointment',
							kiosk_location: kiosk_location
						},
						success: function(msg) {
							console.log(msg, 'discard_queue');
							if (msg.kiosk_location == kiosk_location) {


								var url = '';
								var data = {
									idcard: session_idcard,
									kiosk_location: kiosk_location
								};
								// console.log(data, 'sesdata');


								$.ajax({ //create session
									url: UrlBaseCont + '/StepProcessing/ClearSessionAll',
									type: "post",
									dataType: "json",
									success: function(msg) {
										console.log(msg, 'ClearSessionAll');
									},
									error: function(msg) {
										console.log(msg, 'ClearSessionAll');
									}
								});

								$.ajax({
									url: baseurlMid + <?php echo Modules::run('Websocket/Scanner_url'); ?> + '/patient',
									method: "post",
									dataType: 'json',
									data: data,
									headers: {
										'Access-Control-Allow-Origin': '*',
										'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
										'Access-Control-Allow-Headers': '*',
										'Authorization': 'Basic YXJtOjEyMzQ='
									},
									success: function(msg) {
										console.log(msg, 'patient');

										if (msg['kiosk_location'] == kiosk_location) {
											if (msg['step'] == "next1"){
												window.location.href = "<?=APPURL;?>";
											} else if (msg['step'] == "next2") {
												window.location.href = url_step_two;
											} else if (msg['step'] == "next3") {
												window.location.href = url_step_three;
											} else if (msg['step'] == "next8") { //กรณีคนไข้เก่า เข้ามาอีกครั้ง
												window.location.href = GotoPccClear;
											} else if (msg['step'] == "next6") {
												window.location.href = url_step_six;
												console.log(url_step_six, 'STEP 6');
											} else if (msg['success'] == false && msg['error'] == 500){
												// console.log(msg, "ERROR")
												if(msg['api_his'] == false && msg['api_appointment'] == true){
													alert('5')
													$.ajax({
														url: UrlBaseCont + '/StepProcessing/CreateOffline',
														type: "post",
														success: function(data) {
															window.location.href = url_step_two;
														}
													});
												}else if(msg['api_his'] == true && msg['api_appointment'] == false){
													$.ajax({
														url: UrlBaseCont + '/StepProcessing/CreateOfflineApiErrorAppointment',
														type: "post",
														success: function(data) {
															window.location.href = url_step_two;
														}
													});
												}
												else{
													$.ajax({
														url: UrlBaseCont + '/StepProcessing/CreateOfflineApiErrorAppointment',
														type: "post",
														data: {infoData: msg['data']},
														success: function(data) {
															window.location.href = url_step_two;
														}
													});
												}
											}

										}
									},
									error: function(msg) {
										console.log(msg);
									}

								}); //ajax
							}
						},
						error: function(msg) {
							console.log(msg);
						}

					}); //ajax
				},
				error: function(msg) {
					console.log(msg);
				}

			}); //ajax



		});


		$("#reprint").click(function() {

			EventTimeout = 0; // check redirect

			var patientuid = patient_uid;
			var idcard = idcard_reprint;
			var wlgroup = group;

			$("#reprint").css({'opacity':'0.2','cursor':'default','pointer-events':'none'})
			$("#reprint").prop('disabled', false);

			$.ajax({ // send print queue
				url: baseurlMid + '/api/kiosk/reprintslip',
				method: "post",
				dataType: 'json',
				headers: {
					'Access-Control-Allow-Origin': '*',
					'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
					'Access-Control-Allow-Headers': '*',
					'Authorization': 'Basic YXJtOjEyMzQ='
				},
				data: {
					reprint: '1',
					location: '8',
					step: 'next8',
					patientuid: patientuid,
					idcard: idcard,
					group: wlgroup,
					hnno: session_hn,
					kiosk_location: kiosk_location
				},
				success: function(msg) {

					console.log(msg, 'reprintslip');

					if (msg.kiosk_location == kiosk_location) {
						window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToSlip') ?>
					}
				},
				error: function(msg) {
					console.log(msg);
				}

			}); //ajax
		});

	});


	function show_list_row(worklistuid, numrow, flowname, closevs, closenewhn, count_patient_newhn, closepayor, count_patient_payor, sendimg, clinicname) {




		//alert(closevs);

		var time = '';
		var count = '';
		var worklistuid_get = '';

		// closevs // เสร็จคัดกรอง
		// closenewhn // เสร็จทำประวัติ
		// closepayor // เสร็จเปิดสิทธิ

		// count_patient_newhn //จำนวน ทำประวัติ
		// count_patient_payor //จำนวน เปิดสิทะิ

		// cancelregister // ยกเลิก เปิดสิทธิ
		// cancelnewhn// ยกเลิกทำประวัติ

		var html = '';

		var newdate = new Date(closevs + closenewhn + closepayor);


		var gethoure = (newdate.getHours() < 10) ? '0' + newdate.getHours() : newdate.getHours();
		var getminute = (newdate.getMinutes() < 10) ? '0' + newdate.getMinutes() : newdate.getMinutes();
		var show_time = gethoure + ':' + getminute + ' น.';
		var show_queue = 'รอ ' + count_patient_newhn + count_patient_payor + ' คิว';

		var show_result = '';

		if ((closevs != '' || closenewhn != '' || closepayor != '') && closevs != null) {
			show_result = show_time;
		} else if ((count_patient_newhn != '' || count_patient_payor != '') && count_patient_newhn != null) {
			show_result = show_queue;
		}

		if (worklistuid == '6') {
			html += "<div class='row no-gutters col-12 justify-content-md-center'>";
			html += "<div class='col-1 center ps_margin_r'>";
			html += "<span class='img_wklist' data-value='" + worklistuid + "' time='" + closevs + closenewhn + closepayor + "' count='" + count + "'>" + sendimg + "</span>";
			html += "<p class='ps_runnum'>" + numrow + "</p>";
			html += "</div>";
			html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
			html += "<a>" + flowname + " " + clinicname + "</a>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<span class='text_comp'>" + show_result + "</span>";
			html += "</div>";
			html += "</div>";
		} else {
			html += "<div class='row no-gutters col-12 justify-content-md-center'>";
			html += "<div class='col-1 center ps_margin_r'>";
			html += "<span class='img_wklist' data-value='" + worklistuid + "' time='" + closevs + closenewhn + closepayor + "' count='" + count + "'>" + sendimg + "</span>";
			html += "<p class='ps_runnum'>" + numrow + "</p>";
			html += "</div>";
			html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
			html += "<a>" + flowname + "</a>";
			html += "</div>";
			html += "<div class='col-2'>";
			html += "<span class='text_comp'>" + show_result + "</span>";
			html += "</div>";
			html += "</div>";
		}

		return html;
	}


	function loop_classwk() {

		var imgg1 = '<?= single_img('kiosk/resources/images/icon/G1.png', array('class' => '_img_02')); ?>';
		var imgg2 = '<?= single_img('kiosk/resources/images/icon/G2.png', array('class' => '_img_02')); ?>';
		var imgy1 = '<?= single_img('kiosk/resources/images/icon/Y1.png', array('class' => '_img_02')); ?>';
		var imgy2 = '<?= single_img('kiosk/resources/images/icon/Y2.png', array('class' => '_img_02')); ?>';

		$(".img_wklist").each(function() {
			if ($(this).attr('data-value') == '2' && $(this).attr('time') != '') { //คัดกรอง + กรอกเอกสารรับบริการ
				$(".img_wklist[data-value='1']").html(imgg1).next().html('');
				$(".img_wklist[data-value='2']").html(imgg1).next().html('');
				$(".img_wklist[data-value='1']").parent().parent().find('div').find('.text_comp').html('เสร็จสิ้น');
				$(".img_wklist[data-value='2']").parent().parent().find('div').find('.text_comp').html('เสร็จสิ้น');
			} else if ($(this).attr('data-value') == '3' && $(this).attr('time') != '') { //  ทำประวัติผู้ป่วย
				$(".img_wklist[data-value='3']").html(imgg1).next().html('');
				$(".img_wklist[data-value='3']").parent().parent().find('div').find('.text_comp').html('เสร็จสิ้น');
			} else if ($(this).attr('data-value') == '5' && $(this).attr('time') != '') { //เปิดสิทธิ + ติดต่อ opd
				$(".img_wklist[data-value='5']").html(imgg1).next().html('');
				// $(".img_wklist[data-value='6']").html(imgg2).next().html('');
				$(".img_wklist[data-value='5']").parent().parent().find('div').find('.text_comp').html('เสร็จสิ้น');
				// $(".img_wklist[data-value='6']").parent().parent().find('div').find('.text_comp').html('เสร็จสิ้น');
			}

		});
	}
</script>