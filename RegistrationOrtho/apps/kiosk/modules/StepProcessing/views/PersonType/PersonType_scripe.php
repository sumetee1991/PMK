<script>
	$(document).ready(function() {
		<?php echo Modules::run('Websocket/SocketConection') ?>

		//console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'test');

		var get_from_appoint = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
		console.log(get_from_appoint, 'from_appoint');

		try {
			var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
			var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
			// if (get_from_appoint['UserInfo']['data'][0]['gender'] == 'male') {
			// 	$("#imgavatar").find("img").attr("src", imgMan);
			// } else if (get_from_appoint['UserInfo']['data'][0]['gender'] == 'female') {
			// 	$("#imgavatar").find("img").attr("src", imgWoman);
			// } else if (get_from_appoint['UserInfo']['data'][0]['gender'] == '') {

			// }
		} catch (e) {

		}

		var idcard_get = '';
		var hn_get = '';
		var box_type_click = '';

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		midSocket.on('scan_station', function(data) {
			if (data['step'] == 'next1') {
				window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
			}
		});

		console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;

		/////////////////////////////// start ข้อมูล hn กรณีที่เจอ ผู่ป่วยเก่า /////////////////////////////
		var persontypeold = '';
		$.ajax({
			url: UrlBaseCont + '/StepProcessing/callsesmain',
			type: "post",
			dataType: 'json',
			async: false,
			success: function(data) {
				//var data = JSON.parse(data);
				console.log('callsesmain -------------');
				console.log(data);
				
				//alert(data['PayorActive']['PayorActive']);
				persontypeold = (typeof data['PersonType'] == 'undefined') ? '' : data['PersonType']['PersonType'];
			}
		});

		$.ajax({ //get persontype box
			url: UrlBaseCont + '/StepProcessing/PersonType/Get_persontype',
			method: "post",
			async: false,
			dataType: 'json',
			success: function(msg) {
				console.log(msg, 'zaaa');
				var html = '';
				$.each(msg, function(index, value) {

					html += "<button class='col-3 center in_checkbox chk_sty' style='outline:none;' value='" + value["code"] + "'>";
					html += "<div class='' style='text-align: center;'>";
					html += "<div class='center div_chk_content d2_lb1' style='' active=''>";
					html += "<span class='_st'></span>";
					html += "<a class='chk_font bodyth'>" + value["name"] + "</a>";
					html += "</div>";
					html += "<span class='form-control' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;'></span>";
					html += "</div>";
					html += "</button>";

				});
				$("#area_check_box").html(html);
				var box_type = $("#box_type").val();
				
				//$(".in_checkbox[value='" + box_type + "']").find('div').find('.d2_lb1').css('background-color', '#b8ffb8');

				if (persontypeold != '') {
					$(".in_checkbox[value='" + persontypeold + "']").find('div').find('.d2_lb1').css({
						'background-color': '#78b3a3',
						'color': 'white'
					}).attr('active', 'now');
					$(".in_checkbox[value='" + persontypeold + "']").trigger('click');
					box_type_click = persontypeold;
				}
			}
		});






		$.ajax({ //เพิ่ม hn และ id card
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
				console.log(msg, 'zaza22');

				console.log(msg.kiosk_location + " : " + kiosk_location, 'check kiosklocation');
				if (msg.kiosk_location == kiosk_location) {
					midSocketkiosk_hn();
				}
			},
			error: function(msg) {
				console.log(msg);
			}

		});

		function midSocketkiosk_hn() {
			midSocket.on('kiosk_hn', (data) => { // เจอ hn หรือ ไม่เจอ ก็จะเข้าที่นี้

				console.log(data, 'data get from service');


				$.ajax({
					url: UrlBaseCont + '/StepProcessing/CreateSession',
					type: "post",
					async: false,
					dataType: "json",
					data: {
						data: data,
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
						var hnno = (dataPt['UserInfo']['data'][0]['hnno'] == '' || dataPt['UserInfo']['data'][0]['hnno'] == null) ? '-' : dataPt['UserInfo']['data'][0]['hnno'];
						var type = (dataPt['UserInfo']['data'][0]['type'] == '') ? '' : dataPt['UserInfo']['data'][0]['type'];
						var citizenid_xxx = (dataPt['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : dataPt['UserInfo']['data'][0]['citizenid_xxx'];

						idcard_get = idcard;
						hn_get = hnno;

						$("#box_type").val(type);

						// $("#pt_Name").html(prename + forename + ' ' + surname);
						// $("#pt_IdCard").html(citizenid_xxx);
						// $("#pt_Birth").html(birth);
						// $("#pt_HN").html(hnno);
						// สั่งเขียนที่หน้า PublicTemplate ให้ PtDetail ไปแสดง

					}
				});

				

			});
		}

		/////////////////////////////// end เจอ hn หรือ ไม่เจอ ก็จะเข้าที่นี้/////////////////////////////


		// $.ajax({
		// 	url: baseurlMid + '/api/kiosk/tp/type',
		// 	method: "post",
		// 	dataType: 'json',
		// 	headers: {
		// 		'Access-Control-Allow-Origin': '*',
		// 		'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
		// 		'Access-Control-Allow-Headers': '*',
		// 		'Authorization': 'Basic YXJtOjEyMzQ='
		// 	},
		// 	data: {
		// 		requestType: '1',
		// 		location: '4',
		// 		kiosk_location: kiosk_location
		// 	},
		// 	success: function(msg) {
		// 		console.log(msg, 'tp/type');

		// 		if (msg.kiosk_location == kiosk_location) {

		// 			// var html = '';
		// 			// for (var i = 0; i < msg['data'].length; i++) {

		// 			// 	html += "<button class='col-3 in_checkbox chk_sty' style='outline:none;' value='" + msg["data"][i]["code"] + "'>";
		// 			// 	html += "<div class='center'>";
		// 			// 	html += "<div class='center div_chk_content d2_lb1' style='' active=''>";
		// 			// 	html += "<span class='_st'></span>";
		// 			// 	html += "<a class='chk_font'>" + msg["data"][i]["name"] + "</a>";
		// 			// 	html += "</div>";
		// 			// 	html += "<span class='' style='font-size: 1.2rem;'></span>";
		// 			// 	html += "</div>";
		// 			// 	html += "</button>";

		// 			// }
		// 			// $("#area_check_box").html(html);
		// 			// var box_type = $("#box_type").val();
		// 			// box_type_click = box_type;
		// 			// $(".in_checkbox[value='" + box_type + "']").find('div').find('.d2_lb1').css('background-color', '#b8ffb8');
		// 		} //if

		// 	},
		// 	error: function(msg) {
		// 		console.log(msg);
		// 	}

		// });

		//alert($('#box_type').val());
		// $(".in_checkbox[value='"+$('#box_type').val()+"']").attr('checked',true);


		$("#conf_next").click(function() {

			EventTimeout = 0; // check redirect
			//alert(input_box + ' / ' + idcard_get + ' / ' + hn_get);
			createpageRedirect();
			var check_click_box = '';
			$(".div_chk_content").each(function() {
				if ($(this).attr('active') != '') {
					check_click_box = 'click';
				}
			});

			if (check_click_box == '') {
				$("#content_show_md").html('กรุณาระบุประเภทผู้ป่วย');
				$("#md_alert_scan").modal('show');
				return false;
			}



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

			$.ajax({ //create session
				url: UrlBaseCont + '/StepProcessing/CreateSesPagePtOld',
				type: "post",
				dataType: "json",
				data: {
					data: 'PatientOld'
				},
				success: function(msg) {
					console.log(msg, 'check create NoHnNo');
				}
			});


			var input_box = box_type_click;
			//alert(input_box);
			$.ajax({
				url: baseurlMid + '/api/kiosk/tp/type',
				method: "post",
				dataType: 'json',
				headers: {
					'Access-Control-Allow-Origin': '*',
					'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
					'Access-Control-Allow-Headers': '*',
					'Authorization': 'Basic YXJtOjEyMzQ='
				},
				data: {
					requestType: '2',
					typeval: input_box,
					idcard: idcard_get,
					hn: hn_get,
					location: '4',
					kiosk_location: kiosk_location
				},
				success: function(msg) {
					console.log(msg, 'tp_type');
					if (msg.kiosk_location == kiosk_location) {

						if (msg['success'] == true) {

							$.ajax({ //create session
								url: UrlBaseCont + '/StepProcessing/CreateSesPagePersonType',
								type: "post",
								dataType: "json",
								data: {
									typeval: input_box
								},
								success: function(msg) {
									console.log(msg);
									setTimeout(function() {
										window.location.href = NextToPayor;
									}, 1000)
								}
							});

						}
					}
				},
				error: function(msg) {
					console.log(msg);
				}

			});
		});

		var box_val = '';



		console.log(<?php echo json_encode($this->session->userdata('SessionNumPage')); ?>, 'test');

		var NextToPayor = baselocal + <?php echo Modules::run('Websocket/NextToPayor') ?>;


		$("#area_check_box").on('click', '.in_checkbox', function() {

			EventTimeout = 0; // check redirect

			$(".in_checkbox").find('div').find('.d2_lb1').css({
				'background-color': '',
				'color': 'black'
			}).attr('active', '');
			$(this).find('div').find('.d2_lb1').css({
				'background-color': '#78b3a3',
				'color': 'white'
			}).attr('active', 'now');

			box_type_click = $(this).val();
		});

	});
</script>