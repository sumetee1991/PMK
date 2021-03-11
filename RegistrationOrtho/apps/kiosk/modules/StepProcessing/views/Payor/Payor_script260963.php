<script>
	// alert('najazuza');

	<?php echo Modules::run('Websocket/SocketConection'); ?>
	var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;


	$(document).ready(function() {
		// midSocket.emit('scan_hn_success');
		// console.log(<?php echo json_encode($this->session->userdata('APISession')); ?>, 'APISession');
		// console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
      console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>);
      var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;

      var session_main = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;

      midSocket.on('scan_station', function(data) {
         if (data['step'] == 'next1') {
          window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
       }
    });

      var payoractiveold = '';
      var payor_active = '';

      var check_patient_type = '';
      var worklistgroup = '';
      var idcard_sess = '';

      var check_patient_type = '';
      var worklistgroup = '';
      var idcard_sess = '';

      $.ajax({
         url: UrlBaseCont + '/StepProcessing/callsesmain',
         type: "post",
         dataType: 'json',
         async: false,
         success: function(data) {
				//var data = JSON.parse(data);
				//console.log(data);
				//console.log('gg data');
				//alert(data['PayorActive']['PayorActive']);
				payoractiveold = (typeof data['PayorActive'] == 'undefined') ? '' : data['PayorActive']['PayorActive'];

				console.log('ajax sesmain');
				console.log(data);
				check_patient_type = (data.worklistgroup == undefined) ? data.UserInfo.worklistgroup : data.worklistgroup;
				worklistgroup = (data.worklistgroup == undefined) ? data.UserInfo.worklistgroup : data.worklistgroup;
				idcard_sess = data.UserInfo.data[0].idcard;
			}
		});

      var checkofflinemode = '';

      $.ajax({
         url: UrlBaseCont + '/StepProcessing/callsesoffline',
         type: "post",
         dataType: 'json',
         async: false,
         success: function(data) {
          console.log('offline');
          console.log(data);
          if (data != null && data.OfflineMode != null && data.With != 'Appointment') {
           checkofflinemode = data.OfflineMode;
        }
     }
  });















      $.ajax({
         url: UrlBaseCont + '/StepProcessing/PersonType/Get_payor',
         type: "post",
         dataType: 'json',
         async: false,
         success: function(msg) {
           console.log(msg, 'aaaasdsdsdsdsd');
           var HtmlMain = '';
           var openactive = '';
           var color = '';
           var check_full_condition = '';
           var payor_auto = '';

           $.each(msg, function(index, value) {

             HtmlMain += "<button class='col-3 center btn_payor chk_sty' style='outline:none;' payor_auto='" + payor_auto + "' hiscode='" + value["hiscode"] + "' condition='" + check_full_condition + "' active_click=''  name_payor='" + value["hiscadit"] + "' value='" + value["uid"] + "' check_payor='" + value["openactive"] + "'>";
             HtmlMain += "<div class='' style='text-align: center;'>";
             HtmlMain += "<div class='center div_chk_content d2_lb1' style='' active=''>";
             HtmlMain += "<span class='_st'></span>";
             HtmlMain += "<a class='chk_font bodyth'>" + value["name"] + "</a>";
             HtmlMain += "</div>";
             HtmlMain += "<span class='form-control openactive_class' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;" + color + "'>" + openactive + "</span>";
             HtmlMain += "</div>";
             HtmlMain += "</button>";
          });

           $("#area_box_payyor").html(HtmlMain);


           if (payoractiveold != '') {

             $(".btn_payor[value='" + payoractiveold + "']").find('div').find('.d2_lb1').css({
               'background-color': '#78b3a3',
               'color': 'white'
            }).attr('active', 'now');
             $(".btn_payor[value='" + payoractiveold + "']").attr('active_click', 'active').trigger('click');

             $("#hiscode_se").val($(".btn_payor[active_click='active']").attr('hiscode'));
             payor_active = payoractiveold;
          }



       }
    });

      console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'test');



      try {
         var date_ses = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
         console.log(date_ses, "DATA SESSION")

         var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
         var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
         if (date_ses['UserInfo'] != null) {
				// if (date_ses['UserInfo']['data'][0]['gender'] == 'male') {
				// 	$("#imgavatar").find("img").attr("src", imgMan);
				// } else if (date_ses['UserInfo']['data'][0]['gender'] == 'female') {
				// 	$("#imgavatar").find("img").attr("src", imgWoman);
				// } else if (date_ses['UserInfo']['data'][0]['gender'] == '') {

				// }
			}





			var check_scan = date_ses['UserInfo']['scan'];

			var list_last_payor = [];

			$("#area_payor_before").val(date_ses['UserInfo']['data'][0]['payorname']);

			var oldworklistgroup_check = '';

			var hn_sess = '';




			if (date_ses['UserInfo']['data'][0]['hnno']) {

				hn_sess = date_ses['UserInfo']['data'][0]['hnno'];

				var fullHn = '';

				if (hn_sess.includes('/')) {
					var s = hn_sess.split('/');
					fullHn = s[1] + '/' + s[0]

					var list_holderid = [];
					console.log("OPENVISIT")

					// url: baselinkapi + `/ords/pmkords/hlab/credit-master/${fullHn}`,
					// url: UrlBaseCont + '/StepProcessing/demotest',
					$.ajax({
						// url: UrlBaseCont + '/StepProcessing/demotest',
						// url: baselinkapi + `/ords/pmkords/hlab/credit-master/${fullHn}`,
						url: UrlBaseCont + `/StepProcessing/openVisit`,
						type: "post",
						dataType: "json",
						data: {
							HN: fullHn
						},
						header: {
							// 'X-Request-With':'XMLHttpRequest',
							'Access-Control-Allow-Origin': '*',
							'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
							'Access-Control-Allow-Headers': '*',
							"content-type": "application/json"
						},
						async: false,
						success: function(data) {
							//console.log(data, 'demotest');
							$.each(JSON.parse(data), function(index, value) {
								// console.log(index, "INDEX EACH");
								// console.log(value['periodStart'], "VALUE EACH");
								// console.log(value);

								if (value['periodStart'] <= dateformat() && value['periodEnd'] >= dateformat()) {
									list_holderid.push(value['policyHolderId']);
								} else if (value['periodStart'] == "null" || value['periodEnd'] == "null") {
									list_holderid.push(value['policyHolderId']);
								} else if (value['periodStart'] == null || value['periodEnd'] == null) {
									list_holderid.push(value['policyHolderId']);
								}
							});
						}
					});

					// console.log(list_holderid, 'list_holderid');
				}
			}



			if (date_ses['UserInfo']['oldworklistgroup']) {

				oldworklistgroup_check = date_ses['UserInfo']['oldworklistgroup'];

				$.ajax({
					url: UrlBaseCont + '/StepProcessing/UpdateUserInfotoOld',
					type: "post",
					dataType: "json",
					data: {
						worklistgroup: oldworklistgroup_check
					},
					success: function(msg) {
						console.log(msg, 'gotoOld');
					}
				});
			}
		} catch (e) {

		}

		// ---  get payor main --- //

		/////////////////////////////// start  /////////////////////////////
//       var input_box='001';
// $.ajax({ //create session
//    url: UrlBaseCont + '/StepProcessing/CreateSesPagePersonType',
//    type: "post",
//    dataType: "json",
//    data: {
//       typeval: input_box
//    },
//    success: function(msg) {
//       console.log(msg);

//          window.location.href = NextToPayor;

//    }
// });








function dateformat() {
   var date = new Date();
   var day = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
   var month = (date.getMonth() < 10) ? '0' + date.getMonth() : date.getMonth();
   var year = date.getFullYear();

   return year + '-' + (month + 1) + '-' + day;
}


// alert(baseurlMid + '/api/kiosk/tp/payor/fetch');

$.ajax({
   url: baseurlMid + '/api/kiosk/tp/payor/fetch',
   method: "post",
   dataType: 'json',
   async: false,
   headers: {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
    'Access-Control-Allow-Headers': '*',
    'Authorization': 'Basic YXJtOjEyMzQ='
 },
 data: {
    location: '4',
    step: 'next4',
    kiosk_location: kiosk_location
 },
 success: function(msg) {

    console.log(msg, 'get payor api');
    console.log('data get from service');
				// console.log(result);

				if (msg.kiosk_location == kiosk_location) {

					console.log(msg.kiosk_location + " : " + kiosk_location, 'payor_data');

					//////////////     create box payor    /////////////

					var HtmlMain = '';
					var check_py_uid = [];
               // alert(msg.kiosk_location);

               try{
                  console.log(msg['data'][0]['Payor']);

               }catch{
                  // alert('error');


                // alert(data);
             }


             if(msg['data']=="" || msg['data']==null){
             }else{





                if (msg['data'][0]['Payor'].length > 0 && worklistgroup != '3') {

                  for (var i = 0; i < msg['data'][0]['Payor'].length; i++) {
                   var tem_hidcode = (msg['data'][0]['Payor'][i]['hiscode'] != null) ? msg['data'][0]['Payor'][i]['hiscode'].split(',') : '';
                   var tem_hidcode_final = tem_hidcode;




							// $.each(tem_hidcode_final, function(index, value) {
							// 	var use_hidcode = value;
							// 	$.each(list_holderid, function(index, value) {
							// 	}); //each ใน
							// }); //each นอก
							// if (value == use_hidcode) {}

							var openactive = '';
							var color = '';
							var check_full_condition = '';
							var payor_auto = '';

							//if (worklistgroup == '2') { // เปิดสิทธิที่นี้ ขึ้นเฉพาะ ผู้ป่วย เก่า/นัด เท่านั้น

							// if (msg["data"][0]["Payor"][i]["openactive"] === 'Y' && msg["data"][0]["Payor"][i]["hiscadit"] == 'เงินสด' && check_patient_type != '3') {
							// 	openactive = 'เปิดสิทธิที่นี่';
							// 	color = 'background-color:#f7eab5;';
							// 	payor_auto = 'auto';
							// }


							// if (msg["data"][0]["dataLastPayor"] != null) { // สำหรับคนที่เคยมี payor ล่าสุด
							// 	var policyHolder = msg["data"][0]["dataLastPayor"]["policyHolder"];

							// 	if (msg["data"][0]['Payor'][i]['hiscadit'] != null) { //เช็คจาก payorLast ว่าจะ math กับ payorรายการอันไหน
							// 		var tmp = msg["data"][0]['Payor'][i]['hiscadit'].split(',');
							// 		for (var d = 0; d < tmp.length; d++) {
							// 			if (msg["data"][0]["Payor"][i]["openactive"] === 'Y' && tmp[d] == policyHolder && check_patient_type != '3') {
							// 				openactive = 'เปิดสิทธิที่นี่';
							// 				color = 'background-color:#f7eab5;';
							// 				check_full_condition = 'condition_full';
							// 			}
							// 		}
							// 	}
							// }

							$.each(tem_hidcode_final, function(index, value) {
								var use_hidcode = value;
								//console.log(list_holderid, 'AA');
								$.each(list_holderid, function(index, value) {
									if (msg["data"][0]["Payor"][i]["openactive"] === 'Y') {
										if (use_hidcode == value) {

											openactive = 'เปิดสิทธิที่นี่';
											color = 'background-color:#f7eab5;';
											check_full_condition = 'condition_full';
											payor_auto = 'auto';
											//alert(msg["data"][0]["Payor"][i]["uid"]);
											$(".btn_payor[value='" + msg["data"][0]["Payor"][i]["uid"] + "']").find('.openactive_class').css('background-color', '#f7eab5');
										}
									}
								}); //each ใน
							}); //each นอก



							$(".btn_payor[value='" + msg["data"][0]["Payor"][i]["uid"] + "']").find('.openactive_class').html(openactive);
							$(".btn_payor[value='" + msg["data"][0]["Payor"][i]["uid"] + "']").attr('condition', check_full_condition);
							$(".btn_payor[value='" + msg["data"][0]["Payor"][i]["uid"] + "']").attr('payor_auto', payor_auto);
						}
						$("#payorauto_se").val($(".btn_payor[active_click='active']").attr('payor_auto'));
					} else if (worklistgroup == '3') {

						for (var i = 0; i < msg['data'][0]['Payor'].length; i++) {

							$(".btn_payor[value='" + msg["data"][0]["Payor"][i]["uid"] + "']").attr('payor_auto', payor_auto);

							
						}
						$("#payorauto_se").val($(".btn_payor[active_click='active']").attr('payor_auto'));
					}
					//$("#area_box_payyor").html(HtmlMain);
					if (msg['data'].length) {
						if (msg['data'][0]['dataLastPayor']['policyHolderId']) {

							var tem_policyHolderId = msg['data'][0]['dataLastPayor']['policyHolderId'];

							$(".btn_payor").each(function() {

								var hiscode_tem = ($(this).attr('hiscode') == null) ? '' : $(this).attr('hiscode').split(',');
								var value_btn = $(this).val();
								$.each(hiscode_tem, function(index, value) {


									if (value == tem_policyHolderId) {
										if (payoractiveold == '') {
											$(".btn_payor[value='" + value_btn + "']").find('div').find('.d2_lb1').css({
												'background-color': '#78b3a3',
												'color': 'white'
											}).attr('active', 'now');
											$(".btn_payor[value='" + value_btn + "']").attr('active_click', 'active');
											payor_active = value_btn;
										}
										$("#hiscode_se").val($(".btn_payor[value='" + value_btn + "']").attr('hiscode'));
										$("#payorauto_se").val($(".btn_payor[value='" + value_btn + "']").attr('payor_auto'));


										$.ajax({ //create session	
											url: UrlBaseCont + '/StepProcessing/CreateSesPagePayor',
											type: "post",
											async: false,
											dataType: "json",
											data: {
												payor_active: payor_active
											},
											success: function(msg) {
												console.log(msg, 'CreateSesPagePayor');
											}
										}); //ajax
									}
								});

							});



						}
					}



					var payor_last_Ses = (msg["data"][0]['dataLastPayor']['policyHolderName'] == null) ? '-' : msg["data"][0]['dataLastPayor']['policyHolderName'];
					$("#last_payor").val(payor_last_Ses);
					$("#last_payor").attr('data-policyholderid', msg["data"][0]['dataLastPayor']['policyHolderId'])

					

				}

         }
      },


      error: function(msg) {
       console.log(msg);
    }



 });






midSocket.on('payor_data', (result) => {


			// }
		}); // emit payor_data

		/////////////////////////////// end  /////////////////////////////

		$("#area_box_payyor").on('click', '.btn_payor', function() {
			payor_active = $(this).val();
			//alert(payor_active);
		});

		var next_to_pcc = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;


		$("#conf_yes").click(function() {

       var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation')); ?>;
       var result_session = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
       // alert(localStorage.getItem('worklistgroup_new_by_pat'));
// alert('ok');
var worklistgroup=localStorage.setItem('worklistgroup_new_by_pat','21');
alert(worklistgroup+'assign_val21');
alert(localStorage.getItem('worklistgroup_new_by_pat')+'session21');

         if($(this).val()=='26' && localStorage.getItem('worklistgroup_new_by_pat')=='2'){
            // worklistgroup='21';

               $.ajax({ //create session user info
                     url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                     type: "post",
                     dataType: "json",
                     data: {
                        worklistgroup: worklistgroup,
                        oldworklistgroup: '2',
                     },
                     success: function(msg) {
                        console.log(msg, 'update userinfo worklistgroup');
                        //$("#conf_yes").trigger('click');
                        conf_yes();
                     }
                  });
         }


//    if(queuelocation=="2"){
//             if($(this).val()=='26'){
//              alert('23');

//              $.ajax({ //create session user info
//                      url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
//                      type: "post",
//                      dataType: "json",
//                      data: {
//                         worklistgroup: '23',
//                         oldworklistgroup: '2',
//                      },
//                      success: function(msg) {
//                         console.log(msg, 'update userinfo worklistgroup');
//                         //$("#conf_yes").trigger('click');
//                         conf_yes();
//                      }
//                   });
// alert(data);
//           }

//        }




// worklistgroup_e=='active'
//    alert(worklistgroup_e);
//    alert($(this).val());
//    alert('ok');
// }
// alert(worklistgroup_e);



var check_click_box = '';
$(".div_chk_content ").each(function() {
  if ($(this).attr('active') != '') {
     check_click_box = 'click';
  }
});

if (check_click_box == '') {
  $("#content_show_md").html('กรุณาเลือกสิทธิการรักษา');
  $("#md_alert_scan").modal('show');
  return false;
}

			if (check_patient_type == '3') { //ผู้ป่วยใหม่ ไม่ให้เปิดสิทธิอัตโนมัติ

				conf_yes();

			} else {



				var payoruid = $(".btn_payor[active_click='active']").val();

           localStorage.setItem('payor',payoruid);
// พัตแก้ 250963
// if(queuelocation=="2"){

//    if(payoruid=='26'){

    // if(worklistgroup==''){
    //       alert('ปุ่ม26');
    //            // $.ajax({ //create session user info
    //            // url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
    //            // type: "post",
    //            // dataType: "json",
    //            // data: {
    //            //    worklistgroup: '22',
    //            //    oldworklistgroup: '2',
    //            // },
    //            // success: function(msg) {
    //            //    console.log(msg, 'update userinfo worklistgroup');
    //            //          //$("#conf_yes").trigger('click');
    //            //          conf_yes();
    //            //       }
    //            //    });




    // }else if(payoruid=='23'){


    //          $.ajax({ //create session user info
    //            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
    //            type: "post",
    //            dataType: "json",
    //            data: {
    //               worklistgroup: '23',
    //               oldworklistgroup: '2',
    //            },
    //            success: function(msg) {
    //               console.log(msg, 'update userinfo worklistgroup');
    //                     //$("#conf_yes").trigger('click');
    //                     conf_yes();
    //                  }
    //               });
    //       }
       // }

//        else if(payoruid=='25'){
//          if(worklistgroup!==1){
// alert(worklistgroup+'ok');
//  $.ajax({ //create session user info
//                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
//                type: "post",
//                dataType: "json",
//                data: {
//                   worklistgroup: '12',
//                   oldworklistgroup: '2',
//                },
//                success: function(msg) {
//                   console.log(msg, 'update userinfo worklistgroup');
//                         //$("#conf_yes").trigger('click');
//                         conf_yes();
//                      }
//                   });

//          }else{



//           $.ajax({ //create session user info
//                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
//                type: "post",
//                dataType: "json",
//                data: {
//                   worklistgroup: '11',
//                   oldworklistgroup: '2',
//                },
//                success: function(msg) {
//                   console.log(msg, 'update userinfo worklistgroup');
//                         //$("#conf_yes").trigger('click');
//                         conf_yes();
//                      }
//                   });
//   }

// }else if(payoruid=='27'){
//          alert(payoruid);
//   $.ajax({ //create session user info
//    url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
//    type: "post",
//    dataType: "json",
//    data: {
//       worklistgroup: '11',
//       oldworklistgroup: '2',
//    },
//    success: function(msg) {
//       console.log(msg, 'update userinfo worklistgroup');
//                         //$("#conf_yes").trigger('click');
//                         conf_yes();
//                      }
//                   });

// }

// }







var btn_payor_active = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
				var last_payor = $("#last_payor").attr('data-policyholderid'); //ของ last
				var payor_auto = $(".btn_payor[active_click='active']").attr('payor_auto');
				var hiscode = $(".btn_payor[active_click='active']").attr('hiscode');
				if ($(".btn_payor[active_click='active']").attr('check_payor') == 'Y' && $(".btn_payor[active_click='active']").attr('payor_auto') != '' && checkofflinemode == '') { // เก่า/นัด เลือกอัตโนมัติ click payor ที่เป็น เปิดสิทธิอัตโนมัติ

					$.each(btn_payor_active, function(index, value) {

						if (value != last_payor) { //สิทธล่าสุด ไม่ตรงกับ สิทธิที่ลือก ผปเก่า ให้ถามหาบัตร

							if (check_scan == 'false' && $(".btn_payor[active_click='active']").attr('condition') != '' && $(".btn_payor[active_click='active']").val() != '23') { //ระบบไม่มีการ scan เข้าไปแต่แรก
								console.log('scan false');
								logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
								var html = '';
								html += "<div class='col-12 center'>";
								html += "<button class='d2_2_b2 center' type='button' id='request_queue'> ไม่มีบัตร ขอคิวเปิดสิทธิ</button>";
								html += "</div>";
								html += "<div class='col-12 center' style='margin-top: 2rem;'>";
								html += "<button class='welno_no again_payor center' type='button' id='' style='margin-buttom:20ex;'>ย้อนกลับ</button>";
								html += "</div>";

								$("#md_alert_payor").modal('show');
								$(".text_head").html('กรุณาเสียบบัตรประชาชน<br/>เพื่อทำการเปิดสิทธิ').css({
									'font-size': '4vw'
								});
								// $(".text_footer").html('กรณีไม่มีบัตร/บัตรมีปัญหา โปรดเลือก');
								$("#list_btn_payor").html(html);
								$(".logo_alert_img2").html('<?= single_img('kiosk/resources/images/icon/cardin.png', array('style' => 'height:400px;display:block;')) ?>');
								btn_click();

							} else if (check_scan == 'true' && $(".btn_payor[active_click='active']").attr('condition') != '' && $(".btn_payor[active_click='active']").val() != '23') { //เข้ามาโดยการ scan ตั้งแต่แรก

								if (idcard_sess == idcard_sess) { //เช็ค บัตรใน sess = ตรง
									$.ajax({ //เช็ค api สิทธิเปิดที่นี้ ไม่ตรงlast  จะ เปิดได้ไหม

										url: baseurlMid + '/api/kiosk/creditmaster/open/credit',
										method: "post",
										dataType: 'json',
										data: {
											postCredit: '1',
											pid: idcard_sess,
											hn: hn_sess,
											p_opd: null,
											p_patient_type_id: null,
											p_credit_id: hiscode,
											worklistgroup: worklistgroup,
											payor_auto: payor_auto
										},
										headers: {
											'Access-Control-Allow-Origin': '*',
											'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
											'Access-Control-Allow-Headers': '*',
											// 'Content-Type': 'application/json',
											'Authorization': 'Basic YXJtOjEyMzQ='
										},
										success: function(data) {
											console.log(data, 'check api auto');
											if (data.success == false) {
												logpayor($("#hiscode_se").val(), 'apifail'); //เก็บสิทธิ / สถานะ auto ไม่ผ่าน
												openqueue_fail();
											} else if (data.success == true) {
												logpayor($("#hiscode_se").val(), 'apitrue'); //เก็บสิทธิ / สถานะ auto ผ่าน
												openqueue_success();
											}
										}
									});


								} else if (idcard_sess != idcard_sess) { //เช็ค บัตรใน sess = ไม่ตรง
									//  alert('บัตรไม่ตรง');
									logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
									card_fail();
								}
							} else if (check_scan == 'true' || check_scan == 'false' && $(".btn_payor[active_click='active']").attr('condition') != '' && $(".btn_payor[active_click='active']").val() == '23') {
								console.log('auto 23');
								if (idcard_sess == idcard_sess) { //เช็ค บัตรใน sess = ตรง
									$.ajax({ //เช็ค api สิทธิเปิดที่นี้ ไม่ตรงlast  จะ เปิดได้ไหม

										url: baseurlMid + '/api/kiosk/creditmaster/open/credit',
										method: "post",
										dataType: 'json',
										data: {
											postCredit: '1',
											pid: idcard_sess,
											hn: hn_sess,
											p_opd: null,
											p_patient_type_id: null,
											p_credit_id: hiscode,
											worklistgroup: worklistgroup,
											payor_auto: payor_auto
										},
										headers: {
											'Access-Control-Allow-Origin': '*',
											'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
											'Access-Control-Allow-Headers': '*',
											'Authorization': 'Basic YXJtOjEyMzQ=',
											// 'Content-Type': 'application/json'
										},
										success: function(data) {
											console.log(data, 'check api auto');
											if (data.success == false) {
												logpayor($("#hiscode_se").val(), 'apifail'); //เก็บสิทธิ / สถานะ auto ไม่ผ่าน
												openqueue_fail();
											} else if (data.success == true) {
												logpayor($("#hiscode_se").val(), 'apitrue'); //เก็บสิทธิ / สถานะ auto ผ่าน
												openqueue_success();
											}
										}
									});


								} else if (idcard_sess != idcard_sess) { //เช็ค บัตรใน sess = ไม่ตรง
									//  alert('บัตรไม่ตรง');
									logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
									card_fail();
								}
							} else if ($(".btn_payor[active_click='active']").attr('condition') == '') {
								logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
								conf_yes();
							}
						} else if (value == last_payor) { //สิทธล่าสุด ตรงกัน สิทธิที่เลือก ผปเก่า ไม่ถามหาบัตร
							// alert('สแกนมา ตรง auto');
							logpayor($("#hiscode_se").val(), 'apitrue'); //เก็บสิทธิ / สถานะ auto ผ่าน
							openqueue_success();
							$("#queue_next").trigger('click');
							conf_yes();
						}
					});

					// openqueue_success();
					// $("#queue_next").trigger('click');





				}
				// else if ($(".btn_payor[active_click='active']").attr('check_payor') == 'Y' && $(".btn_payor[active_click='active']").val() == '23') {

				// 	openqueue_success();
				// 	// $("#queue_next").trigger('click');
				// } 
				else if (($(".btn_payor[active_click='active']").attr('check_payor') == 'N' || $(".btn_payor[active_click='active']").attr('check_payor') == 'Y') && worklistgroup != '3' && checkofflinemode == '') { // [ทั่วไป คนเก่าเท่านั้น]  เก่า ปกติ กรณีทั่วไป หรือ y ที่เชคไม่ผ่านเงื่อนไข อัตโนมัติ

					$.each(btn_payor_active, function(index, value) {
						if (last_payor == '' || last_payor != value) {
							logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
							conf_yes();
						} else if (last_payor != '' && value != '' && last_payor == value) {
							logpayor($("#hiscode_se").val(), 'apitrue'); //เก็บสิทธิ / สถานะ auto ผ่าน
							openqueue_success();
							$("#queue_next").trigger('click');
						}
					});
				} else if (($(".btn_payor[active_click='active']").attr('check_payor') == 'N' || $(".btn_payor[active_click='active']").attr('check_payor') == 'Y') && checkofflinemode != '') {
					logpayor($("#hiscode_se").val(), 'null'); //เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
					conf_yes();
				}
			} //else





		});

function conf_yes() {

   var check_click_box = '';
   $(".div_chk_content ").each(function() {
     if ($(this).attr('active') != '') {
       check_click_box = 'click';
    }
 });

   if (check_click_box == '') {
     $("#content_show_md").html('กรุณาเลือกสิทธิการรักษา');
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

			//logpayor($("#hiscode_se").val(),null);//เก็บสิทธิ / สถานะ เปิดปกติ ไม่ auto
			// window.location.href = next_to_pcc;
			$.ajax({ //create session
				url: UrlBaseCont + '/StepProcessing/CreateSesPagePayor',
				type: "post",
				dataType: "json",
				data: {
					payor_active: payor_active
				},
				success: function(msg) {
					console.log(msg);

					$.ajax({
						url: baseurlMid + '/api/kiosk/ap/appointment',
						method: "post",
						dataType: 'json',
						data: {
							'requestAP': '1',
							'location': '5',
							kiosk_location: kiosk_location
						},
						headers: {
							'Access-Control-Allow-Origin': '*',
							'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
							'Access-Control-Allow-Headers': '*',
							'Authorization': 'Basic YXJtOjEyMzQ='
						},
						success: function(msg) {
							console.log(msg, 'MSG');
							if (msg['kiosk_location'] == kiosk_location) {

								if (msg['step'] == 'next6') { //ไม่มีนัด


									$.ajax({ //create session
										url: UrlBaseCont + '/StepProcessing/CreatePtAppointment',
										type: "post",
										dataType: "json",
										data: {
											appointment: '0'
										},
										success: function(msg) {
											window.location.href = NextToPccSv;
										}
									});


								} else if (msg['step'] == 'next5') { //มีนัด
									//รอปรับ
								}
							}
						},
						error: function(msg) {
							console.log(msg);
						}

					}); //ajax
				} //success
			});
		} //function





		var databtn_payor = '';
		$("#area_box_payyor").on('click', '.btn_payor', function() {


			EventTimeout = 0; // check redirect

			databtn_payor = $(this).val();


			$(".btn_payor").find('div').find('.d2_lb1').css({
				'background-color': '',
				'color': 'black',
				'position': 'relative',
				'z-index': '1015'
			}).attr('active', '');
			$(".btn_payor").attr('active_click', '');

			$(this).find('div').find('.d2_lb1').css({
				'background-color': '#78b3a3',
				'color': 'white'



			}).attr('active', 'now');




			$(this).attr('active_click', 'active');


// 

// 


$("#hiscode_se").val($(this).attr('hiscode'));
$("#payorauto_se").val($(this).attr('payor_auto'));
});








		function openqueue_success() {
			var html = '';
			html += "<div class='col-12 center'>";
			html += "<button class='d2_2_b2 center' type='button' id='queue_next' style='margin-buttom:20ex;'> ต่อไป</button>";
			html += "</div>";

			$("#md_alert_payor").modal('show');
			$(".text_head").html('เปิดสิทธิสำเร็จ!').css({
				'font-size': '80px',
				'margin-top': '0'
			});
			$(".text_footer").html('กรุณานำบัตรประชาชนออก').css('margin-top', '4em');
			$("#list_btn_payor").html(html);
			$(".logo_alert_img2").html('<?= single_img('kiosk/resources/images/icon/G2.png', array('style' => 'height:230.63px;display:block;margin-top:9rem;')) ?>');

			btn_click();
		}

		function openqueue_fail() {

			var html = '';
			html += "<div class='col-12 center'>";
			html += "<button class='d2_2_b2' type='button' id='call_payor_counter'> ขอคิวเปิดสิทธิทีเคาน์เตอร์</button>";
			html += "</div>";
			html += "<div class='col-12 center' style='margin-top: 3.5rem;'>";
			html += "<button class='welno_no again_payor' type='button'>ลองอีกครัง</button>";
			html += "</div>";

			$("#md_alert_payor").modal('show');
			$(".text_head").html('เปิดสิทธิไม่สําเร็จ!').css('font-size', '80px');;
			$("#list_btn_payor").html(html);
			$(".logo_alert_img2").html('<?= single_img('kiosk/resources/images/icon/X.png', array('style' => 'height:248px;display:block;')) ?>');

			btn_click();
		}

		function card_fail() {

			var html = '';
			html += "<div class='col-12 center'>";
			html += "<button class='d2_2_b2' type='button' id='call_payor_counter'> ขอคิวเปิดสิทธิทีเคาน์เตอร์</button>";
			html += "</div>";
			html += "<div class='col-12 center' style='margin-top: 3.5rem;'>";
			html += "<button class='welno_no again_payor' type='button'>ลองอีกครัง</button>";
			html += "</div>";

			$("#md_alert_payor").modal('show');
			$(".text_head").html('ข้อมูลบัตรประชาชน<br/>ไม่ถูกต้อง !').css('font-size', '80px');;
			$("#list_btn_payor").html(html);
			$(".logo_alert_img2").html('<?= single_img('kiosk/resources/images/icon/discard.png', array('style' => 'height:248px;display:block;')) ?>');

			btn_click();
		}

		var NextToPccSv = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;


		function btn_click() {
			$(".again_payor").click(function() {

				EventTimeout = 0; // check redirect

				$("#md_alert_payor").modal('hide');

				$(".btn_payor").find('div').find('.d2_lb1').css({
					'background-color': '',
					'color': 'black',
					'position': 'relative',
					'z-index': '1015'
				}).attr('active', '');
				$(".btn_payor").attr('active_click', '');
			});


			$("#request_queue").click(function() {

				EventTimeout = 0; // check redirect

				$("#md_alert_payor").modal('hide');
				//$("#conf_yes").trigger('click');

				conf_yes();



			});

			$("#call_payor_counter").click(function() {

				EventTimeout = 0; // check redirect

				$("#md_alert_payor").modal('hide');
				//$("#conf_yes").trigger('click');
				conf_yes();
			});

			$("#queue_next").click(function() {

				EventTimeout = 0; // check redirect

				$("#md_alert_payor").modal('hide');
				//goto stepprocessing
				//alert(worklistgroup);

				var hiscode_tem = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
				var last_payor_tem = $("#last_payor").attr('data-policyholderid');


				var tem_math = '';

				if (last_payor_tem) { //ทำเฉพาะคนมี last
					$.each(hiscode_tem, function(index, value) {
						if (last_payor_tem != value) {} else if (last_payor_tem == value) {
							tem_math = 'math';
						}
					});
				}




// 				if (tem_math == '') { //ที่เลือก ไม่ตรง last
//                alert(SessionMain['Appointment']['Appointment']);
// 					if (worklistgroup == '6') {
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: '7',
// 								oldworklistgroup: '6'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					} else if (worklistgroup == '1') {
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: '4',
// 								oldworklistgroup: '1'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					} else if (worklistgroup == '2') {
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: '5',
// 								oldworklistgroup: '2'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					}
// 				} else if (tem_math != '') { //ที่เลือก ตรง last
// 					if (worklistgroup == '1') {
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: '8',
// 								oldworklistgroup: '1'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					} else if (worklistgroup == '2') {
//                   var worklistgroup_tem='9';
//                   if(queuelocation==2){
//                     worklistgroup_tem='18';
//                  }
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: worklistgroup_tem,
// 								oldworklistgroup: '2'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					}
// 					if (worklistgroup == '6') {
// 						$.ajax({ //create session user info
// 							url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
// 							type: "post",
// 							dataType: "json",
// 							data: {
// 								worklistgroup: '10',
// 								oldworklistgroup: '6'
// 							},
// 							success: function(msg) {
// 								console.log(msg, 'update userinfo worklistgroup');
// 								//$("#conf_yes").trigger('click');
// 								conf_yes();
// 							}
// 						});
// 					}
// // e





// }


});
		} // fn btn_click


		midSocket.on('chk_card_insert', (result) => {
			console.log(result);
			if (result['kiosk_location'] == kiosk_location) {
				var btn_payor_active = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
				var last_payor = $("#last_payor").attr('data-policyholderid'); //ของ last
				var payor_auto = $(".btn_payor[active_click='active']").attr('payor_auto');
				var hiscode = $(".btn_payor[active_click='active']").attr('hiscode');

				if (result['scan_status'] == '2') {
					if (result['idcard'] != idcard_sess) { //เลขไม่ตรงให้ redirech

						$("#request_queue").attr('disabled', false).removeClass('d2_3_b2').addClass('d2_2_b2');
						// console.log('id ไม่ตรงกัน');
						// window.location.href = UrlBaseKiosk;

						$("#md_alert_payor").modal('hide');
						card_fail();

					} else {

						$("#request_queue").attr('disabled', false).removeClass('d2_3_b2').addClass('d2_2_b2');
						$("#md_alert_payor").modal('hide');

						$.each(btn_payor_active, function(index, value) {
							if (value != last_payor) { //สิทธล่าสุด ไม่ตรงกับ สิทธิที่ลือก ผปเก่า

								if (idcard_sess == idcard_sess) { //เช็ค บัตรใน sess = ตรง
									$.ajax({ //เช็ค api สิทธิเปิดที่นี้ ไม่ตรงlast  จะ เปิดได้ไหม
										url: baseurlMid + '/api/kiosk/creditmaster/open/credit',
										method: "post",
										dataType: 'json',
										data: {
											postCredit: '1',
											pid: idcard_sess,
											hn: hn_sess,
											p_opd: null,
											p_patient_type_id: null,
											p_credit_id: hiscode,
											worklistgroup: worklistgroup,
											payor_auto: payor_auto
										},
										headers: {
											'Access-Control-Allow-Origin': '*',
											'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
											'Access-Control-Allow-Headers': '*',
											'Authorization': 'Basic YXJtOjEyMzQ=',
											// 'Content-Type': 'application/json',
										},
										success: function(data) {
											console.log(data, 'check api auto');
											if (data.success == false) {
												//alert('สแกนมา ไม่ตรง auto api false emit');
												logpayor($("#hiscode_se").val(), 'apifail');
												openqueue_fail();
											} else if (data.success == true) {
												//alert('สแกนมา ไม่ตรง auto api true emit');
												logpayor($("#hiscode_se").val(), 'apitrue');
												openqueue_success();
											}
										}
									});


								} else if (idcard_sess != idcard_sess) { //เช็ค บัตรใน sess = ไม่ตรง
									//alert('บัตรไม่ตรง');
									logpayor($("#hiscode_se").val(), 'null');
									card_fail();
								}

							} else if (value == last_payor) { //สิทธล่าสุด ตรงกัน สิทธิที่เลือก ผปเก่า
								// alert('สแกนมา ตรง auto emit');
								logpayor($("#hiscode_se").val(), 'apitrue'); //เก็บสิทธิ / สถานะ auto ผ่าน
								openqueue_success();
								$("#queue_next").trigger('click');
								conf_yes(); // ตอนเก็บ log
							}
						});
						// openqueue_success();
					}
				}
			}
		});
		// function openqueue_success() {
		// 	var html = '';
		// 	html += "<div class='col-12'>";
		// 	html += "<button class='d2_2_b2' type='button' id='queue_next'> ต่อไป</button>";
		// 	html += "</div>";

		// 	$("#md_alert_payor").modal('show');
		// 	$(".text_head").html('เปิดสิทธิสำเร็จ!');
		// 	$(".text_footer").html('กรุณานำบัตรประชาชนออก');
		// 	$("#list_btn_payor").html(html);
		// 	$(".logo_alert_img").html('<?= single_img('kiosk/resources/images/icon/cardout.png', array('style' => 'height:400px;display:block;')) ?>');

		// 	btn_click();
		// }

		// function openqueue_fail() {

		// 	var html = '';
		// 	html += "<div class='col-12'>";
		// 	html += "<button class='d2_2_b2' type='button' id='call_payor_counter'> ขอคิวเปิดสิทธิทีเคาน์เตอร์</button>";
		// 	html += "</div>";
		// 	html += "<div class='col-12' style='margin-top: 2rem;'>";
		// 	html += "<button class='d2_3_b2 again_payor' type='button'>ลองอีกครัง</button>";
		// 	html += "</div>";

		// 	$("#md_alert_payor").modal('show');
		// 	$(".text_head").html('เปิดสิทธิไม่สําเร็จ!');
		// 	$("#list_btn_payor").html(html);
		// 	$(".logo_alert_img").html('<?= single_img('kiosk/resources/images/icon/X.png', array('style' => 'height:200px;display:block;')) ?>');

		// 	btn_click();
		// }

		function logpayor(hiscode, statusauto) {
			$.ajax({
				url: UrlBaseCont + '/StepProcessing/CreateLogPayor',
				type: "post",
				async: false,
				data: {
					hiscode: hiscode,
					statusauto: statusauto

				},
				success: function(msg) {
					console.log('logpayor');
					console.log(msg);
				}
			});
		}

	}); //document
</script>