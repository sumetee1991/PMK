<script>
	$(document).ready(function() {



		<?php echo Modules::run('Websocket/SocketConection') ?>

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;


		/////////////////////////////// start ข้อมูล hn กรณีที่เจอ ผู่ป่วยเก่า /////////////////////////////

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
				step: 'next3',
				kiosk_location: kiosk_location
			},
			success: function(msg) {
				console.log(msg, 'zaza');

				if (msg.kiosk_location == kiosk_location) {
					midSocketkiosk_hn(msg.kiosk_location);
				}
			},
			error: function(msg) {
				console.log(msg, "ERROR");
			}

		});


		function midSocketkiosk_hn(location_k) {
			midSocket.on('kiosk_hn', (data) => { // เจอ hn หรือ ไม่เจอ ก็จะเข้าที่นี้
				console.log('data get from service appointment');
				console.log(data);

				if (location_k == kiosk_location) {

					$.ajax({
						url: UrlBaseCont + '/StepProcessing/CreateSession',
						type: "post",
						async: false,
						dataType: "json",
						data: {
							data: data
						},
						success: function(msg) {
							console.log(msg, 'socket kiosk_hn');

							var dataPt = msg;


							// สั่งเขียนที่หน้า PublicTemplate ให้ PtDetail ไปแสดง
							var idcard = (dataPt['UserInfo']['data'][0]['idcard'] == '') ? '-' : dataPt['UserInfo']['data'][0]['idcard'];
							var prename = (dataPt['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : dataPt['UserInfo']['data'][0]['prefixname_th'];
							var forename = (dataPt['UserInfo']['data'][0]['firstname_th'] == '') ? '' : dataPt['UserInfo']['data'][0]['firstname_th'];
							var surname = (dataPt['UserInfo']['data'][0]['lastname_th'] == '') ? '' : dataPt['UserInfo']['data'][0]['lastname_th'];
							var birth = (dataPt['UserInfo']['data'][0]['issuedate'] == '') ? '-' : dataPt['UserInfo']['data'][0]['issuedate'];
							var hnno = (dataPt['UserInfo']['data'][0]['hnno'] == '') ? '-' : dataPt['UserInfo']['data'][0]['hnno'];
							var type = (dataPt['UserInfo']['data'][0]['type'] == '') ? '' : dataPt['UserInfo']['data'][0]['type'];
							var citizenid_xxx = (dataPt['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : dataPt['UserInfo']['data'][0]['citizenid_xxx'];
							$("#box_type").val(type);

							$("#pt_Name").html(prename + forename + ' ' + surname);
							$("#pt_IdCard").html(citizenid_xxx);
							$("#pt_Birth").html(birth);
							$("#pt_HN").html(hnno);
							// สั่งเขียนที่หน้า PublicTemplate ให้ PtDetail ไปแสดง  


							try {
								if (dataPt['UserInfo']['dataAppointment']['data'].length > 0) {
									show_appointment(dataPt['UserInfo']['dataAppointment']['data']);
									call_btn(dataPt['UserInfo']['dataAppointment']['data']);

									var clinicName = [];

									$.each(dataPt['UserInfo']['dataAppointment']['data'], function(index, value) {
										clinicName.push(value['examRoomName']);
									});

									$.ajax({
										url: UrlBaseCont + '/StepProcessing/CreateclinicName',
										type: "post",
										async: false,
										dataType: "json",
										data: {
											Appointment: 'Appointment',
											clinicName: clinicName
										},
										success: function(msg) {
											console.log(msg, 'SessionClinicName');
										}
									}); //ajax

								} else {
									show_appointment(0);
									call_btn(0);
								}
							} catch (e) {
								show_appointment(0);
								call_btn(0);
							}
						}
					});


					$.ajax({ //create session NumberPage
						url: UrlBaseCont + '/StepProcessing/CreateSesNumberPage',
						type: "post",
						dataType: "json",
						success: function(msg) {
							console.log(msg, 'zaza');
							num_page_tmp = msg['NumberPage']['NumberPage'];
							list_num_pagenow = msg['NumberPage']['NowPage'];

							var count_page = 1;
							var text_page = '';

							for (var i = 0; i < num_page_tmp; i++) {
								text_page += '<li class="step_page " value="' + parseInt(count_page++) + '"></li>';
							}
							$("#list_number_page").html(text_page);
							$(".step_page[value='" + list_num_pagenow + "']").addClass('active');
						},
						error: function(msg) {
							console.log(msg, 'error');
						}
					});
				}

			});
		}









		function show_appointment(check) {

			if (check.length > 0) {
				var html = '';
				$.each(check, function(index, value) {
					console.log(value, "test value")
					var location = value['examRoomName'];
					var doctorFullName = value['doctorFullName'];
					var appointTime = value['appointTimeStart'].slice(0,-3)+' น. - '+value['appointTimeEnd'].slice(0,-3)+' น.';

					// var location = value['clinicName'];
					// var doctorFullName = value['doctorFullName'];
					// var appointTime = value['appointTimeStart'].slice(0,-3)+' น. - '+value['appointTimeEnd'].slice(0,-3)+' น.';
					// var appointTime = value['appointTime'];

					html += "<div class='row col-12 appm_rd'>";
					html += "<div class='col-4'>";
					html += "<p>" + appointTime + "</p>";
					html += "</div>";
					html += "<div class='col-4'>";
					html += "<p>" + doctorFullName + "</p>";
					html += "</div>";
					html += "<div class='col-4'>";
					html += "<p>" + location + "</p>";
					html += "</div>";
					html += "</div>";

					if (check.length != (index + 1)) {
						html += "<div class='row no-gutters appm_bd_btm'>";
						html += "</div>";
					}

				}); //each

				$("#area_list_appointment").html(html);

			} else {
				var html = '';
				html += "<div class='row col-12 appm_rd'>";
				html += "<div class='col-4'>";
				html += "</div>";
				html += "<div class='col-4'>";
				html += "<p>ไม่พบนัดหมายในวันนี้</p>";
				html += "</div>";
				html += "<div class='col-4'>";
				html += "</div>";
				html += "</div>";

				$("#area_list_appointment").html(html);
			}
		}


		function call_btn(data) {

			if (data.length > 0) {
				var html_btn = '';
				html_btn += "<div class=''>";
				html_btn += "<button class='d2_2_b2 btn_suc_click' type='button' id='ok_doctor'>พบแพทย์ตามนัดหมาย</button>";
				html_btn += "</div>";
				html_btn += "<div class='' style='margin-top: 2rem;'>";
				html_btn += "<button class='welno_no btn_cancle_on' id='doctor_more' type='button'>ขอพบแพทย์เพิ่มเติม</button>";
				html_btn += "</div>";

				$("#area_btn_app").html(html_btn);
				$("#area_text_app").html('<h2 style="font-size: 2.8rem;">คุณต้องการพบแพทย์ตามนัดหมายหรือไม่ ?</h2>');

			} else {

				var html_btn = '';
				html_btn += "<div class='' style='margin-top:11rem;'>";
				html_btn += "<button class='d2_2_b2 btn_suc_click' type='button' id='ok_doctor'> เข้ารับการคัดกรองอาการ</button>";
				html_btn += "</div>";

				$("#area_btn_app").html(html_btn);

			}

			btnclick(); //event ต้องเกิดหลังจากสร้างปุ่มเสร็จ

		}


		function btnclick() {

			$("#doctor_more").click(function() {

				$.ajax({ //create session
					url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
					type: "post",
					dataType: "json",
					data: {
						worklistgroup: '6'
					},
					success: function(msg) {

						$.ajax({
							url: baseurlMid + '/api/kiosk/ap/appointment',
							method: "post",
							dataType: 'json',
							headers: {
								'Access-Control-Allow-Origin': '*',
								'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
								'Access-Control-Allow-Headers': '*',
								'Authorization': 'Basic YXJtOjEyMzQ='
							},
							data: {
								requestAP: '0'
							},
							success: function(msg) {
								console.log(msg, 'zaza');

								if (msg['step'] == 'next3') {
									window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPersonType'); ?>
								}
							},
							error: function(msg) {
								console.log(msg);
							}

						}); //ajax
					}
				}); //ajax
			});


			$("#ok_doctor").click(function() {

				EventTimeout = 0; // check redirect

				$.ajax({ //create session
					url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
					type: "post",
					dataType: "json",
					data: {
						pagenow: (parseInt(list_num_pagenow) + 1)
					},
					success: function(msg) {
						console.log(msg);
					},
					error: function(msg) {
						console.log(msg, 'error');
					}
				});

				$.ajax({
					url: baseurlMid + '/api/kiosk/ap/appointment',
					method: "post",
					dataType: 'json',
					headers: {
						'Access-Control-Allow-Origin': '*',
						'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
						'Access-Control-Allow-Headers': '*',
						'Authorization': 'Basic YXJtOjEyMzQ='
					},
					data: {
						requestAP: '0'
					},
					success: function(msg) {
						console.log(msg, 'zaza');

						if (msg['step'] == 'next3') {
							window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPersonType'); ?>
						}
					},
					error: function(msg) {
						console.log(msg);
					}

				});
			}); //click event
		}


	}); //document
	///////////////////////////////  end ข้อมูล hn กรณีที่เจอ ผู่ป่วยเก่า /////////////////////////////
</script>