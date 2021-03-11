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

localStorage.clear();

      var worklistgroup_find_appointment='';

      <?php echo Modules::run('Websocket/SocketConection'); ?>


      console.log(<?php echo json_encode($this->session->userdata('queuelocation')); ?>,'location');
      var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		//console.log(<?php echo json_encode($this->session->userdata('APISession')); ?>, 'APISession');

		//console.log(<?php echo json_encode($this->session->userdata('Createoldnoappoint')); ?>, 'Createoldnoappoint');

		console.log(<?php echo json_encode($this->session->userdata('SessionOfflineMode')); ?>, 'SessionOfflineMode');

		var oldnoappoint = <?php echo json_encode($this->session->userdata('Createoldnoappoint')); ?>;

		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;

      var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;

      var offlinemode = JSON.parse('<?php echo json_encode($this->session->userdata('SessionOfflineMode')); ?>');
		// console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, "TESTSTESTSEFSEF")
		var sessiongender = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
		try {
			var imgNo = "<?= base_url('static/kiosk/resources/images/AnnonymousAvatar.png'); ?>";
			var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
			var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
		} catch (e) {}



		function btn_off_noapp(data) {

			//console.log(offlinemode, "TEST OFFLINE");
			var sesdata = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
			if (offlinemode == null && ptnoapp_worklistgroup == '') {
				if (data['UserInfo'] != null) {
					var data = data;
					var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
					var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
					var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
					var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
					var hn = (data['UserInfo']['data'][0]['hn'] == '' || data['UserInfo']['data'][0]['hn'] == null) ? '-' : data['UserInfo']['data'][0]['hn'];
					var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
					var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
					// $("#pt_Name").html(prename + forename + ' ' + surname);
					// $("#pt_IdCard").html(citizenid_xxx);
					// $("#pt_Birth").html(birth);
					// $("#pt_HN").html(hn);
				} else {
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
							// $("#pt_Name").html(prename + forename + ' ' + surname);
							// $("#pt_IdCard").html(citizenid_xxx);
							// $("#pt_Birth").html(birth);
							// $("#pt_HN").html(hn);
						}
					});
				}
			} else if (offlinemode != null && offlinemode['With'] == 'Appointment') {
				if (data['UserInfo'] != null) {
					var idcard = (data['UserInfo']['data'][0]['idcard'] == '') ? '-' : data['UserInfo']['data'][0]['idcard'];
					var prename = (data['UserInfo']['data'][0]['prefixname_th'] == '') ? '' : data['UserInfo']['data'][0]['prefixname_th'];
					var forename = (data['UserInfo']['data'][0]['firstname_th'] == '') ? '' : data['UserInfo']['data'][0]['firstname_th'];
					var surname = (data['UserInfo']['data'][0]['lastname_th'] == '') ? '' : data['UserInfo']['data'][0]['lastname_th'];
					var hn = (data['UserInfo']['data'][0]['hnno'] == '' || data['UserInfo']['data'][0]['hnno'] == null) ? '-' : data['UserInfo']['data'][0]['hnno'];
					var birth = (data['UserInfo']['data'][0]['issuedate'] == '') ? '-' : data['UserInfo']['data'][0]['issuedate'];
					var citizenid_xxx = (data['UserInfo']['data'][0]['citizenid_xxx'] == '') ? '-' : data['UserInfo']['data'][0]['citizenid_xxx'];
					// $("#pt_Name").html(prename + forename + ' ' + surname);
					// $("#pt_IdCard").html(citizenid_xxx);
					// $("#pt_Birth").html(birth);
					// $("#pt_HN").html(hn);
				} else {
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
							// $("#pt_Name").html(prename + forename + ' ' + surname);
							// $("#pt_IdCard").html(citizenid_xxx);
							// $("#pt_Birth").html(birth);
							// $("#pt_HN").html(hn);
						}
					});
				}
			} else if (offlinemode != null && offlinemode['With'] == 'Patient_HIS') {
				// alert('2')
				var sesdata = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
				// alert(sesdata)
				if (offlinemode['With'] == 'Patient_HIS') {
					$.ajax({ //create session
						url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
						type: "post",
						dataType: "json",
						data: {
							patient: sesdata
						},
						success: function(data) {
							if (data['UserInfo']) {
								console.log(data, "SSSADADA")
// alert(data['UserInfo']['worklistgroup']);
                        localStorage.setItem('worklistgroup_for_location2',data['UserInfo']['worklistgroup']);
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
								// $("#pt_Name").html(prename + forename + ' ' + surname);
								// $("#pt_IdCard").html(citizenid_xxx);
								// $("#pt_Birth").html(birth);
								// $("#pt_HN").html(hn);
							} else {
								// alert("NOT HAVE")
								// $("#pt_Name").html('');
								// $("#pt_IdCard").html('-');
								// $("#pt_Birth").html('-');
								// $("#pt_HN").html('-');
							}
						}
					});
				} else {
					// alert("NOT HAVE")
					// $("#pt_Name").html('');
					// $("#pt_IdCard").html('-');
					// $("#pt_Birth").html('-');
					// $("#pt_HN").html('-');
				}
			} else if (ptnoapp_worklistgroup != '') {



				var BtnHtml = '';

            // var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
      

            if(queuelocation==1){
              BtnHtml += "<div class='col-12 center'>";
              BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='2' >มีนัดหมาย</button>";
              BtnHtml += "</div>";
              BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
              BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='1' >ไม่มีนัดหมาย</button>";
              BtnHtml += "</div>";
              $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
           }else{

             BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
             BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='1' >ไม่มีนัดหมาย</button>";
             BtnHtml += "</div>";
             $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
          }


          $("#AreaButton_HN").html(BtnHtml);

          var send_workg = ptnoapp_worklistgroup;
          setTimeout(function() {
             $("#YesNut").click(function() {
               btn_ptnoappoint($(this).val());
            });

             $("#NoNut").click(function() {

               btn_ptnoappoint($(this).val());
            });
          }, 50);

       }
    }


    var ptnoapp_worklistgroup = '';

		$.ajax({ //create session
			url: UrlBaseCont + '/StepProcessing/callSesPtOldNoApp',
			type: "post",
			dataType: "json",
			async: false,
			success: function(data) {
				console.log('callSesPtOldNoApp');
				console.log(data);
				if (data != null) {
					ptnoapp_worklistgroup = data.worklistgroupdf;
				}
			}
		});

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

		function btnclickContact() {
			$("#conf_contact").click(function() {
				$.ajax({ //create session
					url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
					type: "post",
					dataType: "json",
					data: {
						pagenow: (parseInt(list_num_pagenow) + 1)
					},
					success: function(msg) {


						createpageRedirect();

                 var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;

                 if(queuelocation==1){
                  window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
               }else{


                  var input_box='001';
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

window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPayor') ?>;
}

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
			async: false,
			data: {
				location: '1',
				step: 'next2',
				scan: 'false',
				kiosk_location: kiosk_location,
            queuelocation:queuelocation,
         },
         success: function(data) {
          console.log(data, "SDADSA")

          console.log(data['worklistgroup']+'pat');


          if (data.data != undefined && data.data.worklistgroup != undefined) {
         
             worklistgroup_find_appointment=data['data']['worklistgroup'];//www5
             
             localStorage.setItem('worklistgroup_find_appointment',worklistgroup_find_appointment);//www
             createpageRedirect(data.data.worklistgroup);
				} else { //ต้อนย้อนกลับ ไม่ให้ userinfo หายไป
					$.ajax({ //create session
						url: UrlBaseCont + '/StepProcessing/callsesmain',
						type: "post",
						dataType: "json",
						async: false,
						success: function(data) {
							
							console.log('dataazaa');
							console.log(data);
							if (data != undefined) {
								createpageRedirect(data.worklistgroup);
							}
						}
					});
				}
				if (kiosk_location == data['kiosk_location']) {

					if (data['data'] != undefined) { // get จาก service ถ้ามีให้สร้าง ses userinfo
						//console.log(data, 'get UserInfo');
						//createpageRedirect(data.data.worklistgroup); //publictemplate	
						$.ajax({ //create session
							url: UrlBaseCont + '/StepProcessing/CreateSesInfoPageNoHn',
							type: "post",
							dataType: "json",
							async: false,
							data: {
								patient: data['data']
							},
							success: function(msg) {
								console.log(msg, 'create ses userinfo');

								var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
var idcard=(msg['UserInfo']['data'][0]['idcard']);
var hn=(msg['UserInfo']['data'][0]['hnno']);
var input_box='001';
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
      idcard: idcard,
      hn: hn,
      location: 2,
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
                          
                        }
                     });

                  }
               }
            },
            error: function(msg) {
               console.log(msg);
            }

         });




  localStorage.setItem('worklistgroup_for_location2',(msg['UserInfo']['worklistgroup']));

                        
								var data = msg;
								// console.log(sessiongender, "TEST GENDERRRR")
								if (sessiongender == null) {
									var imgNo = "<?= base_url('static/kiosk/resources/images/AnnonymousAvatar.png'); ?>";
									var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
									var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
								}
								btn_off_noapp(data);

							},
							error: function(msg) {
								console.log(msg, 'error');
							}
						});
					} else { // ถ้าไม่มีไม่ต้องสร้างเพราะมี userinfo อยู่แล้ว
						btn_off_noapp(data);
					}
				}

			},
			error: function(msg) {
				console.log(msg);
			}

		});

		$.ajax({ //create session
			url: UrlBaseCont + '/StepProcessing/callsesmain',
			type: "post",
			dataType: "json",
			async: false,
			success: function(data) {
				console.log('callsesmain -------------');
				console.log(data);
			}
		});

		midSocket.on('kiosk_nohn', (data) => {
			console.log('data get from service');

			// 
			// console.log(data, 'peech');
			// console.log(msg, 'wangya');

		}); //socket
		//console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, "TEST")

		$.ajax({ //create session NumberPage
			url: UrlBaseCont + '/StepProcessing/CreateSesNumberPage',
			type: "post",
			dataType: "json",
			success: function(msg) {
				//console.log(msg, 'zaza');
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


// alert(offlinemode['With']);

		// console.log(offlinemode, "TES OFFLINE MODE")

		if (offlinemode != null && offlinemode['With'] == 'Patient_HIS') { //เช็คerror api และ offline manual

         var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;




         var BtnHtml = '';

         if(queuelocation==1){
            BtnHtml += "<div class='col-12 center'>";
            BtnHtml += "<button type='button center' type='button' class='d2_2_b2 bodyth' id='YesInformation' value='yesinformation'>มีประวัติแล้ว</button>";
            BtnHtml += "</div>";
            BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
            BtnHtml += "<button type='button' class='welno_no bodyth' id='NoInformation' value='noinformation'>ยังไม่มีประวัติ</button>";
            BtnHtml += "</div>";

            $("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
         }else{

          BtnHtml += "<div class='col-12 center'>";
          BtnHtml += "<button type='button center' type='button' class='d2_2_b2 bodyth' id='YesInformation' value='yesinformation'>มีประวัติแล้ว</button>";
          BtnHtml += "</div>";
          BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
          BtnHtml += "<button type='button' class='welno_no bodyth' id='NoInformation' value='noinformation'>ยังไม่มีประวัติ</button>";
          BtnHtml += "</div>";

          $("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
       }


       $("#AreaButton_HN").html(BtnHtml);
			back_for_offline(); // ลบ id เก่า ใส่ class กดกลับจะแสดงถามแบบ ofline
			btn_information(); // กดแล้วแสดง ปุ่ม มีนีด / ไม่มีนัด



		} else if (offlinemode != null && offlinemode['With'] == 'Appointment') { //เช็คerror api และ offline manual
			



         var group = '1';
         var BtnHtml = '';
         BtnHtml += "<div class='col-12 center'>";
         BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย</button>";
         BtnHtml += "</div>";
         BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
         BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
         BtnHtml += "</div>";
         $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
         $("#AreaButton_HN").html(BtnHtml);
         $.ajax({
           url: UrlBaseCont + '/StepProcessing/groupSesOffline',
           method: "post",
           data: {
             group: group
          },
          async: false,
          dataType: "json",
          success: function(data) {
             var dtInformation = "";
             var DataNut = "";
             var worklistgroup = data.worklistgroup;
             $("#YesNut").click(function() {
               DataNut = $(this).val();
               if (worklistgroup == 1) {
                 dtInformation = "yesinformation";
							// alert(worklistgroup)
							var dtgroup = '2';
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/changeOldPatientGroupAppointOffline',
								method: "post",
								data: {
									group: dtgroup
								},
								async: false,
								dataType: "json",
								success: function(data) {
									// alert('DI ' + DataInformation + ' | DN ' + DataNut);
									createpageRedirect();
									console.log(data, "GROUP OLD PATIENT OFFLINE");
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
							data: {
								group: dtgroup
							},
							async: false,
							dataType: "json",
							success: function(data) {
								// alert('DI ' + DataInformation + ' | DN ' + DataNut);
								// console.log(data, "GROUP OLD PATIENT OFFLINE")
								check_type_offline(dtInformation, DataNut);
								createpageRedirect();
								$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
							}
						});
					});
          }

       });
      } else if (offlinemode == null && ptnoapp_worklistgroup == '') {
         var BtnHtml = '';


         var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;

         if(queuelocation==1){

            BtnHtml += "<div class='col-12 center'>";
            BtnHtml += "<button type='button' class='d2_2_b2 btn_cancle_on bodyth' id='conf_contact'>ขอคิวทําประวัติ</button>";
            BtnHtml += "</div>";
            BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
            BtnHtml += "<button type='button' class='welno_no btn_suc_click bodyth' id='conf_no'>ฉันมีประวัติแล้ว</button>";
            BtnHtml += "</div>";
            $("#showtext").html('เราไม่พบประวัติของคุณ <br>กรุณาติดต่อทำประวัติ');


         }else{
           
            if(worklistgroup_find_appointment==3){
               BtnHtml += "<div class='col-12 center'>";
               BtnHtml += "<button type='button' class='d2_2_b2 btn_cancle_on bodyth' id='conf_contact'>ขอคิวทําประวัติ</button>";
               BtnHtml += "</div>";
 
             
               $("#showtext").html('เราไม่พบประวัติของคุณ <br>กรุณาติดต่อทำประวัติ');

            }else{


               $('.d1_m_b2').css('display','none');
                         // BtnHtml += "<div class='col-12 center'>";
                         // BtnHtml += "<button type='button' class='d2_2_b2 btn_cancle_on bodyth' id='conf_contact'>ขอคิวทําประวัติ</button>";
                         // BtnHtml += "</div>";

                         BtnHtml +="<div class='col-12 row appm_r1'>"

                         BtnHtml +="<div class='col-4' style='padding: 0 !important'>"
                         BtnHtml +="<a>เวลานัด</a></div>"


                         BtnHtml +="<div class='col-4' style='padding: 0 !important'>"
                         BtnHtml +="<a>ชื่อแพทย์</a>"
                         BtnHtml +="</div>"

                         BtnHtml +="<div class='col-4' style='padding: 0 !important'>"
                         BtnHtml +="<a>แผนก</a>"
                         BtnHtml +="</div>"

                         BtnHtml +="</div>"

                         BtnHtml +="<div class='row col-12 d-flex justify-content-around appm_r2' id='area_list_appointment'>"

                         BtnHtml +="<div style='font-size:2.6rem;'>ไม่พบนัดหมายในวันนี้</div>"

                         BtnHtml +="</div>"

                         BtnHtml += "<div class='col-12 center' style='margin-top: 42rem;'>";
                         BtnHtml += "<button type='button' class='d2_2_b2 btn_suc_click bodyth' id='conf_contact'>ต่อไป</button>";
                         BtnHtml += "</div>";
                      }

                   }


                   $("#AreaButton_HN").html(BtnHtml);



                   btnclickContact();
                   btnConfNo();

                } else if (ptnoapp_worklistgroup != '') {
                 var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;




                 var BtnHtml = '';

                 if(queuelocation==1){

                  BtnHtml += "<div class='col-12 center'>";
                  BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='2' >มีนัดหมาย</button>";
                  BtnHtml += "</div>";
                  BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
                  BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='1' >ไม่มีนัดหมาย</button>";
                  BtnHtml += "</div>";
                  $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');

               }else{





   // <div style="height: 27rem; max-height: 27rem; padding-top: 18px; padding-bottom: 10px;">
   //    <div class="form-group col-12 appm_d_main">


   //       <!-- // Head // -->

   //       <div class="row col-12 d-flex justify-content-around appm_r2" id="area_list_appointment">



   //       </div>
   //       <!-- // list // -->
   //    </div>
   // </div>
   BtnHtml +="<div class='form-group col-12 appm_d_main'>";

   BtnHtml +="<div class='col-12 row appm_r1'>";

   BtnHtml += "<div class='col-4' style='padding: 0 !important'>";
   BtnHtml += "<a>เวลานัด</a>";
   BtnHtml += "</div>";
   BtnHtml += "<div class='col-4' style='padding: 0 !important'>";
   BtnHtml += "<a>ชื่อแพทย์</a>";
   BtnHtml += "</div>";
   BtnHtml += "<div class='col-4' style='padding: 0 !important'>";
   BtnHtml += "<a>แผนก</a>";
   BtnHtml += "</div>";
   BtnHtml += "</div>";

   BtnHtml += "<div class='row col-12 d-flex justify-content-around appm_r2' id='area_list_appointment'>";

   BtnHtml += "<div class='col-12 center' style='color:#285348'>";
   BtnHtml += "<div style='font-size:2.6rem;'>ไม่พบนัดหมายในวันนี้</div>";
   BtnHtml += "</div>";

   BtnHtml += " </div>";
   BtnHtml += " </div>";

   // BtnHtml += "<div class='col-12 center'>";
   // BtnHtml += "ไม่พบนัดหมายในวันนี้";
   // BtnHtml += "</div>";

   BtnHtml += "<div class='col-12 center' style='margin-top: 42rem;'>";
   BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='NoNut' value='1' >ต่อไป</button>";
   BtnHtml += "</div>";
   $('.d1_m_b2').css('display','none');
   $("#showtext").html('');











}



$("#AreaButton_HN").html(BtnHtml);

var send_workg = ptnoapp_worklistgroup;
setTimeout(function() {
  $("#YesNut").click(function() {
    btn_ptnoappoint($(this).val());
 });

  $("#NoNut").click(function() {
    btn_ptnoappoint($(this).val());
 });
}, 50);





}


		// else if(oldnoappoint != null){
		// 	var group = '1';
		// 	var BtnHtml = '';
		// 	BtnHtml += "<div class='col-12 center'>";
		// 	BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย / มาไม่ตรงนัด /<br/>ทำหัตถการไม่พบแพทย์ / ทันตกรรม</button>";
		// 	BtnHtml += "</div>";
		// 	BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
		// 	BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
		// 	BtnHtml += "</div>";
		// 	$("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
		// 	$("#AreaButton_HN").html(BtnHtml);

		// 	$("#YesNut").click(function() {
		// 		$.ajax({
		// 			url: UrlBaseCont + '/StepProcessing/updateoldnoappoint',
		// 			method: "post",
		// 			data: {group: 2},
		// 			async: false,
		// 			dataType: "json",
		// 			success: function(data){
		// 				// alert('DI ' + DataInformation + ' | DN ' + DataNut);
		// 				//console.log(data, "GROUP OLD PATIENT OFFLINE")
		// 				$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline');
		// 				window.location.href = next_step;
		// 			}
		// 		});
		// 	});

		// 	$("#NoNut").click(function() {
		// 		$.ajax({
		// 			url: UrlBaseCont + '/StepProcessing/updateoldnoappoint',
		// 			method: "post",
		// 			data: {group: 1},
		// 			async: false,
		// 			dataType: "json",
		// 			success: function(data){
		// 				// alert('DI ' + DataInformation + ' | DN ' + DataNut);
		// 				// console.log(data, "GROUP OLD PATIENT OFFLINE")
		// 				$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline');
		// 				window.location.href = next_step;
		// 			}
		// 		});
		// 	});

		// }

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
				data: {
					group: group
				},
				async: false,
				dataType: "json",
				success: function(data) {
					console.log(data, "patient group")
					var BtnHtml = '';
              var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;

              if(queuelocation==1){
				  
               BtnHtml += "<div class='col-12 center'>";
               BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย</button>";
               BtnHtml += "</div>";
               BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
               BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
               BtnHtml += "</div>";
               $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
            }else{

              BtnHtml += "<div class='col-12 center'>";
              BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut' >มีนัดหมาย</button>";
              BtnHtml += "</div>";


              BtnHtml += "<div class='col-12 center' style='margin-top: 4rem;'>";
              BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut' >ไม่มีนัดหมาย</button>";
              BtnHtml += "</div>";
              $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
           }

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
				data: {
					group: group
				},
				async: false,
				dataType: "json",
				success: function(data) {
					var BtnHtml = '';

               var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
               if(queuelocation==1){
                 BtnHtml += "<div class='col-12'>";
                 BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut'>มีนัดหมาย</button>";
                 BtnHtml += "</div>";
                 BtnHtml += "<div class='col-12' style='margin-top: 4rem;'>";
                 BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut'>ไม่มีนัดหมาย</button>";
                 BtnHtml += "</div>";
                 $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
              }else{
                 BtnHtml += "<div class='col-12'>";
                 BtnHtml += "<button type='button' class='d2_2_b2 bodyth' id='YesNut' value='yesnut'>มีนัดหมาย</button>";
                 BtnHtml += "</div>";
                 BtnHtml += "<div class='col-12' style='margin-top: 4rem;'>";
                 BtnHtml += "<button type='button' class='d2_3_b2 bodyth' id='NoNut' value='nonut'>ไม่มีนัดหมาย</button>";
                 BtnHtml += "</div>";
                  $("#showtext").html('วันนี้คุณมีนัดหมายพบแพทย์หรือไม่ ?');
              }
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
   if (worklistgroup == 1) {
				// alert(worklistgroup)
				var group = '2';
				$.ajax({
					url: UrlBaseCont + '/StepProcessing/changeOldPatientGroupAppointOffline',
					method: "post",
					data: {
						group: group
					},
					async: false,
					dataType: "json",
					success: function(data) {
						// alert('DI ' + DataInformation + ' | DN ' + DataNut);
						createpageRedirect();
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
			createpageRedirect();
			$(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline')
		});

}

function check_type_offline(info, nut) {

 var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;

 if(queuelocation==1){
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

   }else{



    var input_box='001';
    var next_step = baselocal + <?php echo Modules::run('Websocket/NextToPayor') ?>;

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
         window.location.href = next_step;
      }, 1000)
   }
});

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


   var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;

   if(queuelocation==1){
      $("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
   }else{
      $("#showtext").html('คุณมีประวัติผู้ป่วยที่<br/>โรงพยาบาลแล้วหรือยัง ?');
   }


   $("#AreaButton_HN").html(BtnHtml);
   back_for_offline();
   btn_information();
});
}


function btn_ptnoappoint(ptnoapp_worklistgroup) {



  var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;

  if(queuelocation==1){


     $.ajax({
      url: UrlBaseCont + '/StepProcessing/changeOldPatientGroupAppointOffline',
      type: "post",
      data: {
       group: ptnoapp_worklistgroup
    },
    async: false,
    success: function(data) {
       console.log(data);
       createpageRedirect();
       $(".backoffline").attr('id', 'btn_backpage').removeClass('backoffline');
				$.ajax({ //create session
					url: UrlBaseCont + '/StepProcessing/callsesmain',
					type: "post",
					dataType: "json",
					async: false,
					success: function(data) {
						console.log('callsesmain -------------');
						console.log(data);
						window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
					}
				});
			}
		});
  }else{



$.ajax({ //create session
   url: UrlBaseCont + '/StepProcessing/callsesmain',
   type: "post",
   dataType: "json",
   async: false,
   success: function(data) {
      console.log(data);

// var sesdata = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
var idcard=(data['UserInfo']['data'][0]['idcard']);
var hn=(data['UserInfo']['data'][0]['hnno']);
var  idcard
var input_box='001';
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
      idcard: idcard,
      hn: hn,
      location: 2,
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
                           window.location.href = baselocal + <?php echo Modules::run('Websocket/NextToPayor'); ?>
                        }
                     });

                  }
               }
            },
            error: function(msg) {
               console.log(msg);
            }

         });
}
});


}



}
</script>

