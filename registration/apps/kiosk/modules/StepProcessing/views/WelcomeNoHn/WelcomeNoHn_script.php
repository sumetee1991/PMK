<script>
	function CallBox(BoxPage) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url("BoxPage"); ?>/box' + BoxPage,
			dataType: "html",
			success: function(response) {
				$("#boxContent").html(response);
			}
		});
	}



	$(document).ready(function() {

	});
</script>

<script>
	$(document).ready(function() {
		<?php echo Modules::run('Websocket/SocketConection'); ?>

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		console.log(<?php echo json_encode($this->session->userdata('SessionOfflineMode')); ?>, 'SessionOfflineMode');

		console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;

		var offlinemode = JSON.parse('<?php echo json_encode($this->session->userdata('SessionOfflineMode')); ?>');
		// console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, "TESTSTESTSEFSEF")
		var sessiongender = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
		try{
			var imgNo = "<?=base_url('static/kiosk/resources/images/AnnonymousAvatar.png'); ?>";
			var imgMan = "<?=base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
			var imgWoman = "<?=base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
			if(sessiongender['UserInfo'] != null){
				if(sessiongender['UserInfo']['data'][0]['gender'] == 'male' || sessiongender['UserInfo']['data'][0]['gender'] == 'male'){
					$("#imgavatar").find("img").attr("src", imgMan);
				}else if(sessiongender['UserInfo']['data'][0]['gender'] == 'female'){
					$("#imgavatar").find("img").attr("src", imgWoman);
				}else if(sessiongender['UserInfo']['data'][0]['gender'] == ''){
					
				}
			}
		} catch (e) {

		}
		// console.log(offlinemode)


		// $("#btn_go_home").click(function() {
		//     window.location.href = UrlBaseCont;
		// });

		midSocket.on('scan_station', function(data) {
			if (data['step'] == 'next1') {
				window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
			}
		});

		var next_step = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;

		$("#conf_yes").click(function() {

			EventTimeout = 0; // check redirect

			$.ajax({ //create session
				url: UrlBaseCont + '/StepProcessing/CreateSesPageNoHnNew',
				type: "post",
				dataType: "json",
				data: {
					data: 'PatientNew'
				},
				success: function(msg) {
					//console.log(msg);
					window.location.href = next_step;
				}
			});
		});


		function btnConfNo() {
			
			$("#conf_no").click(function() {
				$("#Contact_Staff").modal('show');
				EventTimeout = 0; // check redirect

			});
		}

		$("#cont_stf").click(function() {
			window.location.href = UrlBaseKiosk;
		});

		function btnclickContact(){
			$("#conf_contact").click(function() {
				$.ajax({ //create session
					url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
					type: "post",
					dataType: "json",
					data: {
						pagenow: (parseInt(list_num_pagenow) + 1)
					},
					success: function(msg) {
						window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
					},
					error: function(msg) {
						console.log(msg, 'error');
					}
				});
			});
		}

		$.ajax({
			url: baseurlMid + '/api/smart/smartcard/scannohn',
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
				step: 'next2',
				scan: 'false',
				kiosk_location: kiosk_location
			},
			success: function(data) {
				// console.log(data, "SDADSA")
				if (kiosk_location == data['kiosk_location']) {
				console.log(data, 'test11111111111');

					$.ajax({ //create session
						url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
						type: "post",
						dataType: "json",
						data: {
							patient: data['data']
						},
						success: function(msg) {
							console.log(msg, 'kiosk_nohn');
							var data = msg;
							// console.log(sessiongender, "TEST GENDERRRR")
							if(sessiongender == null){
								var imgNo = "<?=base_url('static/kiosk/resources/images/AnnonymousAvatar.png'); ?>";
								var imgMan = "<?=base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
								var imgWoman = "<?=base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
								if(data['UserInfo']['data'][0]['gender'] == 'male'){
									$("#imgavatar").find("img").attr("src", imgMan);
								}else if(data['UserInfo']['data'][0]['gender'] == 'female'){
									$("#imgavatar").find("img").attr("src", imgWoman);
								}else if(data['UserInfo']['data'][0]['gender'] == ''){
									
								}
							}
							console.log(offlinemode, "TEST OFFLINE");
							var sesdata = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
							if(offlinemode == null){
								if(data['UserInfo'] != null){
									var data = msg;
									var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
									var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
									var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
									var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
									var hn = (data['UserInfo']['data'][0]['hn'] == '' || data['UserInfo']['data'][0]['hn'] == null) ? '-' : data['UserInfo']['data'][0]['hn'];
									var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
									var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
									$("#pt_Name").html(prename + forename + ' ' + surname);
									$("#pt_IdCard").html(citizenid_xxx);
									$("#pt_Birth").html(birth);
									$("#pt_HN").html(hn);
								}else{
									$.ajax({ //create session
										url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
										type: "post",
										dataType: "json",
										data: {
											patient: sesdata['UserInfo']
										},
										success: function(msg) {
											console.log(msg, 'testsetestests')
											var data = msg;
											// if(data['UserInfo']['data'][0]['gender'] == 'male'){
											// 	$("#imgavatar").find("img").attr("src", imgMan);
											// }else if(data['UserInfo']['data'][0]['gender'] == 'female'){
											// 	$("#imgavatar").find("img").attr("src", imgWoman);
											// }else if(data['UserInfo']['data'][0]['gender'] == ''){
												
											// }
											var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
											var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
											var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
											var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
											var hn = (data['UserInfo']['data'][0]['hn'] == '' || data['UserInfo']['data'][0]['hn'] == null) ? '-' : data['UserInfo']['data'][0]['hn'];
											var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
											var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
											$("#pt_Name").html(prename + forename + ' ' + surname);
											$("#pt_IdCard").html(citizenid_xxx);
											$("#pt_Birth").html(birth);
											$("#pt_HN").html(hn);
										}
									});
								}
							}else if(offlinemode != null && offlinemode['With'] == 'Appointment'){
								if(data['UserInfo'] != null){
									var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
									var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
									var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
									var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
									var hn = (data['UserInfo']['data'][0]['hnno'] == '' || data['UserInfo']['data'][0]['hnno'] == null) ? '-' : data['UserInfo']['data'][0]['hnno'];
									var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
									var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
									$("#pt_Name").html(prename + forename + ' ' + surname);
									$("#pt_IdCard").html(citizenid_xxx);
									$("#pt_Birth").html(birth);
									$("#pt_HN").html(hn);
								}else{
									$.ajax({ //create session
										url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
										type: "post",
										dataType: "json",
										data: {
											patient: sesdata['UserInfo']
										},
										success: function(msg) {
											console.log(msg, 'testsetestests')
											var data = msg;
											// if(data['UserInfo']['data'][0]['gender'] == 'male'){
											// 	$("#imgavatar").find("img").attr("src", imgMan);
											// }else if(data['UserInfo']['data'][0]['gender'] == 'female'){
											// 	$("#imgavatar").find("img").attr("src", imgWoman);
											// }else if(data['UserInfo']['data'][0]['gender'] == ''){
												
											// }
											var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
											var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
											var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
											var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
											var hn = (data['UserInfo']['data'][0]['hnno'] == '' || data['UserInfo']['data'][0]['hnno'] == null) ? '-' : data['UserInfo']['data'][0]['hnno'];
											var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
											var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
											$("#pt_Name").html(prename + forename + ' ' + surname);
											$("#pt_IdCard").html(citizenid_xxx);
											$("#pt_Birth").html(birth);
											$("#pt_HN").html(hn);
										}
									});
								}
							}else if(offlinemode != null && offlinemode['With'] == 'Patient_HIS'){
								// alert('2')
								var sesdata = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
								// alert(sesdata)
								if(offlinemode['With'] == 'Patient_HIS'){
									$.ajax({ //create session
										url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
										type: "post",
										dataType: "json",
										data: {
											patient: sesdata
										},
										success: function(data) {
											if(data['UserInfo']){
												console.log(data, "SSSADADA")
												// alert("HAVE")
												// if(data['UserInfo']['data'][0]['gender'] == 'male'){
												// 	$("#imgavatar").find("img").attr("src", imgMan);
												// }else if(data['UserInfo']['data'][0]['gender'] == 'female'){
												// 	$("#imgavatar").find("img").attr("src", imgWoman);
												// }else if(data['UserInfo']['data'][0]['gender'] == ''){
													
												// }
												var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
												var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '-' : data['UserInfo']['data'][0]['prefixname_th'];
												var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '-' : data['UserInfo']['data'][0]['firstname_th'];
												var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '-' : data['UserInfo']['data'][0]['lastname_th'];
												var hn = (data['UserInfo']['data'][0]['hn'] == '' || data['UserInfo']['data'][0]['hn'] == null) ? '-' : data['UserInfo']['data'][0]['hn'];
												var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
												var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
												$("#pt_Name").html(prename + forename + ' ' + surname);
												$("#pt_IdCard").html(citizenid_xxx);
												$("#pt_Birth").html(birth);
												$("#pt_HN").html(hn);
											}else{
												// alert("NOT HAVE")
												$("#pt_Name").html('');
												$("#pt_IdCard").html('-');
												$("#pt_Birth").html('-');
												$("#pt_HN").html('-');
											}
										}
									});
								}else{
									// alert("NOT HAVE")
									$("#pt_Name").html('');
									$("#pt_IdCard").html('-');
									$("#pt_Birth").html('-');
									$("#pt_HN").html('-');
								}
							}
							
						},
						error: function(msg) {
							console.log(msg, 'error');
						}
					});
				

				}
			},
			error: function(msg) {
				console.log(msg);
			}

		});


		midSocket.on('kiosk_nohn', (data) => {
			console.log('data get from service');

			// 

			// console.log(data, 'peech');
			// console.log(msg, 'wangya');

		}); //socket
		console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, "TEST")

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

		// console.log(offlinemode, "TES OFFLINE MODE")
		if (offlinemode != null && offlinemode['With'] == 'Patient_HIS') {//เช็คerror api และ offline manual
			var BtnHtml = '';
			BtnHtml += "<div class='col-12 center'>";
			BtnHtml += "<button type='button center' type='button' class='d2_2_b2 bodyth' id='YesInformation' value='yesinformation'>มีประวัติแล้ว</button>";
			BtnHtml += "</div>";
			BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
			BtnHtml += "<button type='button' class='welno_no bodyth' id='NoInformation' value='noinformation'>ยังไม่มีประวัติ</button>";
			BtnHtml += "</div>";
			$("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
			$("#AreaButton_HN").html(BtnHtml);
			back_for_offline(); // ลบ id เก่า ใส่ class กดกลับจะแสดงถามแบบ ofline
			btn_information(); // กดแล้วแสดง ปุ่ม มีนีด / ไม่มีนัด
		} else if (offlinemode != null && offlinemode['With'] == 'Appointment') {//เช็คerror api และ offline manual
			var group = '1';
			var BtnHtml = '';
			BtnHtml += "<div class='col-12 center'>";
			BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย / มาไม่ตรงนัด /<br/>ทำหัตถการไม่พบแพทย์ / ทันตกรรม</button>";
			BtnHtml += "</div>";
			BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
			BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
			BtnHtml += "</div>";
			$("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
			$("#AreaButton_HN").html(BtnHtml);
			$.ajax({
				url: UrlBaseCont + '/StepProcessing/groupSesOffline',
				method: "post",
				data: {group: group},
				async: false,
				dataType: "json",
				success: function(data){
					var dtInformation = "";
					var DataNut = "";
					var worklistgroup = data.worklistgroup;
					$("#YesNut").click(function() {
						DataNut = $(this).val();
						if(worklistgroup == 1){
							dtInformation = "yesinformation";
						// alert(worklistgroup)
							var dtgroup = '2';
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/changeOldPatientGroupAppointOffline',
								method: "post",
								data: {group: dtgroup},
								async: false,
								dataType: "json",
								success: function(data){
									// alert('DI ' + DataInformation + ' | DN ' + DataNut);
									console.log(data, "GROUP OLD PATIENT OFFLINE")
									check_type_offline(dtInformation, DataNut);
									$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
								}
							});

						}
						
						
					});

					$("#NoNut").click(function() {
						dtInformation = "noinformation";
						DataNut = $(this).val();
						//alert('DI ' + DataInformation + ' | DN ' + DataNut);
						var dtgroup = '1';
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/changeOldPatientNoNutGroupAppointOffline',
								method: "post",
								data: {group: dtgroup},
								async: false,
								dataType: "json",
								success: function(data){
									// alert('DI ' + DataInformation + ' | DN ' + DataNut);
									// console.log(data, "GROUP OLD PATIENT OFFLINE")
									check_type_offline(dtInformation, DataNut);
									$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
								}
							});
					});
				}
				
			});
		} else if(offlinemode == null) {
			var BtnHtml = '';

			BtnHtml += "<div class='col-12 center'>";
			BtnHtml += "<button type='button' class='d2_2_b2 btn_cancle_on bodyth' id='conf_contact'>ขอคิวทําประวัติ</button>";
			BtnHtml += "</div>";
			BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
			BtnHtml += "<button type='button' class='welno_no btn_suc_click bodyth' id='conf_no'>ฉันมีประวัติแล้ว</button>";
			BtnHtml += "</div>";
			$("#showtext").html('เราไม่พบประวัติของคุณ <br>กรุณาติดต่อทำประวัติ');
			$("#AreaButton_HN").html(BtnHtml);
			btnclickContact();
			btnConfNo();

		}

	});


	var DataInformation = '';
	var DataNut = '';

	<?php echo Modules::run('Websocket/SocketConection'); ?>
	var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
	function btn_information() {
		$("#NoInformation").click(function() {
			var group = '3';
			// oldCreateSes(group);
			DataInformation = $(this).val();
			$.ajax({
				url: UrlBaseCont + '/StepProcessing/groupSesOffline',
				method: "post",
				data: {group: group},
				async: false,
				dataType: "json",
				success: function(data){
					console.log(data, "patient group")
					var BtnHtml = '';
					BtnHtml += "<div class='col-12 center'>";
					BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย / มาไม่ตรงนัด /<br/>ทำหัตถการไม่พบแพทย์ / ทันตกรรม</button>";
					BtnHtml += "</div>";
					BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
					BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
					BtnHtml += "</div>";
					$("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
					$("#AreaButton_HN").html(BtnHtml);
					btn_offline(data.worklistgroup);
				}
				
			});
		});

		$("#YesInformation").click(function() {
			var group = '1';
			// oldCreateSes(group);
			DataInformation = $(this).val();

			$.ajax({
				url: UrlBaseCont + '/StepProcessing/groupSesOffline',
				method: "post",
				data: {group: group},
				async: false,
				dataType: "json",
				success: function(data){
					var BtnHtml = '';
					BtnHtml += "<div class='col-12'>";
					BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut'>มีนัดหมาย / มาไม่ตรงนัด /<br/>ทำหัตถการไม่พบแพทย์ / ทันตกรรม</button>";
					BtnHtml += "</div>";
					BtnHtml += "<div class='col-12' style='margin-top: 4rem;'>";
					BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut'>ไม่มีนัดหมาย</button>";
					BtnHtml += "</div>";
					$("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
					$("#AreaButton_HN").html(BtnHtml);
					btn_offline(data.worklistgroup);
				}
				
			});
		});
	}


	function btn_offline(worklistgroup) {
		console.log(worklistgroup, "GROUP ON OFFLINE")
		$("#YesNut").click(function() {
			DataNut = $(this).val();
			if(worklistgroup == 1){
			// alert(worklistgroup)
				var group = '2';
				$.ajax({
					url: UrlBaseCont + '/StepProcessing/changeOldPatientGroupAppointOffline',
					method: "post",
					data: {group: group},
					async: false,
					dataType: "json",
					success: function(data){
						// alert('DI ' + DataInformation + ' | DN ' + DataNut);
						console.log(data, "GROUP OLD PATIENT OFFLINE")
						check_type_offline(DataInformation, DataNut);
						$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
					}
				});

			}
			
			
		});

		$("#NoNut").click(function() {
			DataNut = $(this).val();
			//alert('DI ' + DataInformation + ' | DN ' + DataNut);
			check_type_offline(DataInformation, DataNut);
			$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
		});

	}

	function check_type_offline(info, nut) {
		var next_step = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
		if (info == 'yesinformation' && nut == 'yesnut') { // เก่า มีนัด
			// alert('เก่า มีนัด');
			window.location.href = next_step;
		} else if (info == 'yesinformation' && nut == 'nonut') { //เก่า ไม่มีนัด
			// alert('เก่า ไม่มีนัด');
			window.location.href = next_step;
		} else if (info == 'noinformation' && nut == 'nonut') { //ใหม่ ไม่มีนัด
			// alert('ใหม่ ไม่มีนัด');
			window.location.href = next_step;
		}

	}


	function back_for_offline() {
		$("#btn_backpage").addClass('backoffline').removeAttr('id');

		$(".backoffline").click(function() {
			var BtnHtml = '';
			BtnHtml += "<div class='col-12'>"; 
			BtnHtml += "<button type='button' type='button' class='d2_2_b2' id='YesInformation' value='yesinformation'>มีประวัติแล้ว</button>";
			BtnHtml += "</div>";
			BtnHtml += "<div class='col-12' style='margin-top: 4rem;'>";
			BtnHtml += "<button type='button' class='d2_3_b2' id='NoInformation' value='noinformation'>ยังไม่มีประวัติ</button>";
			BtnHtml += "</div>";
			$("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
			$("#AreaButton_HN").html(BtnHtml);
			back_for_offline();
			btn_information();
		});
	}
</script>

<script>
	// $("#btn_backpage").click(function() {
	//     history.back();
	// });
</script>