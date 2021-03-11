<script>
	$(document).ready(function() {
		<?php echo Modules::run('Websocket/SocketConection') ?>

   
	  console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>);
      console.log('queuelocation',<?php echo json_encode($this->session->userdata('queuelocation')); ?>);
      console.log('kiosk_location',<?php echo json_encode($this->session->userdata('kiosk_location')); ?>);
      console.log(<?php echo json_encode($this->session->userdata('SessionClinicName')); ?>, 'SessionClinicName');
      console.log(<?php echo json_encode($this->session->userdata('Createoldnoappoint')); ?>, 'Createoldnoappoint');

      var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
      var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

      
      $.ajaxSetup({
         cache: false
      });

      $("#box_data").focus();
      $.ajax({
         url: "<?= MIDPREFIX . MIDURL . '/api/manage/get_new_queue' ?>",
         method: "post",
         dataType: 'json',
         data: {
          success: true
       },
       headers: {
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
          'Access-Control-Allow-Headers': '*',
          'Authorization': 'Basic YXJtOjEyMzQ='
       }
    });

		$.ajax({ // send print queue
			url: UrlBaseCont + '/StepProcessing/ClearSessionOffline',
			method: "post",
			dataType: 'json',
			success: function(msg) {
				console.log(msg, 'ClearSessionOffline');
			},
			error: function(msg) {
				// console.log(msg);
			}
		}); //ajax



		<?php echo Modules::run('Websocket/socketManage'); ?>
		$(document).on("click", "[data-action]", function(e) {
			$.ajaxSetup({
				cache: false
			});
			var Target = $(this).data('value');
			var Action = $(this).data('action');
			var Value = $(Target).val();

			if (Action && Value) {
				var data = {
					action: Action,
					value: Value,
				};
				console.log(data);
				console.log(midSocket);
				var postemit = url + '/hn_smartcard';
				$.ajax({
					url: postemit,
					method: 'post',
					dataType: 'json',
					data: data,
					success: function(data) {
						console.log('success: ', data);
					},
					error: function(err) {
						console.log(err);
					}
				});

			} else {
				console.log('No Data');
			}
		});

	});
</script>


<?php // echo 'http://'.$_SERVER['SERVER_NAME'].':8080/Qpmk/kiosk/Scanner/test'; die(); 
?>

<script>
	$(document).mouseup(function(e) {
		$("#box_data").focus();
	});

	$(document).ready(function() {
		$("#box_data").val('');
		<?php //echo Modules::run('Websocket/socketManage'); 
		?>
		console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
		console.log(<?php echo json_encode($this->session->userdata('SessionOfflineMode')); ?>, 'SessionOfflineMode');
		var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;

		<?php echo Modules::run('Websocket/SocketConection'); ?>
		var url_main = baseurlMid;
		var url = baseurlMid + <?php echo Modules::run('Websocket/Scanner_url'); ?> + '/patient';
		var url_step_two = baselocal + <?php echo Modules::run('Websocket/NextStepTwo') ?>;
		var url_step_three = baselocal + <?php echo Modules::run('Websocket/NextToPersonType') ?>;
		var GotoPccClear = baselocal + <?php echo Modules::run('Websocket/NextToProcessServiceClear') ?>;
		var url_step_six = baselocal + <?php echo Modules::run('Websocket/NextToAppointment') ?>;

		console.log(url_step_two, 'url_step_two');
		console.log(url, 'url');

		var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;

		$.ajax({ //create session
			url: UrlBaseCont + '/StepProcessing/ClearSessionAll',
			async: false,
			success: function(msg) {
				console.log('Clear Session ALL OK');
			},
			error: function(msg) {
				console.log('error');
			}
		});

		// midSocket.on('kiosk_nohn', (data) => {
		//     console.log(data);
		//     if (data['step'] == "next2") {
		//         window.location.href = url_step_two;
		//     } else if (data['step'] == "next3") {
		//         window.location.href = url_step_three;
		//     }
		// });

		midSocket.on('status_processing', (data) => { // เจอ hn หรือ ไม่เจอ ก็จะเข้าที่นี้
			if (data.kiosk_location == kiosk_location) {
				console.log(data);
				if (data.scan_status == '1') { // เสียบบัตร
					$("#md_alert_scan").modal('hide');
					$("#scaning").modal('show');
					$("#scan_status").html('กำลังอ่านข้อมูลจากบัตรประชาชน<br>. . .').css('color', '#285348');

					// setTimeout(function() {
					// 	$("#scaning").modal('hide');
					// }, 8000);

				} else if (data.scan_status == '2') { // เสร็จสิ้น
					$("#scaning").modal('show');
					var text = '';
					text += '<span class="col-12"><?= single_img("kiosk/resources/images/icon/G2.png", array("style" => "width:10rem;")) ?></span><br>';
					text += "<br><span class='col-12'>อ่านข้อมูลเรียบร้อย</span><br>";
					text += "<span class='col-12'>กรุณานำบัตรออก</span>";

					$("#scan_status").html(text);

					// setTimeout(function() {
					// 	$("#scaning").modal('hide');
					// }, 3000);

				} else if (data.scan_status == '3') { // ถอดการ์ด

				} else if (data.scan_status == '0') { // error
					$("#scaning").modal('hide');
					$("#md_alert_scan").modal('show');
					$("#content_show_md").html('ไม่สามารถอ่านข้อมูลจากบัตรประชาชนได้กรุณาลอกใหม่อีกครั้ง');

					setTimeout(function() {
						$("#md_alert_scan").modal('hide');
					}, 3000);
				}
			}
		});

		midSocket.on('scanner_kiosk', function(data) {
			if (data.kiosk_location == kiosk_location && data.card == 'scanner') {
				console.log("Rewrite kiosk_hn Scancard", data);
				$.post("<?= APPURL . '/StepProcessing/scanInput'; ?>", data.data)
           .done(function(response) {
            console.log(JSON.parse(response));
         });
        }
     });

		midSocket.on('kiosk_hn', function(data) {
			/*
			if(data.kiosk_location == kiosk_location && data.card == 'scanner'){
				console.log("Rewrite kiosk_hn Scancard",data);
				$.post("<?= APPURL . '/StepProcessing/scanInput'; ?>",data.data)
					.done(function(response){
						console.log(response);
					});
			}
			//return false; //Break Test
			*/
			//return false; //Break Test
			console.log(data, 'kiosk_hn');

			//return false; //Break Test
			if (data.kiosk_location == kiosk_location) {

				console.log(data, 'test data api error');

				if (data['step'] == "next2") {

					if (data['worklistgroup'] == 1) {

						$.ajax({
							url: UrlBaseCont + '/StepProcessing/createPtNoAppoint',
							type: "post",
							data: {
								worklistgroup: data['worklistgroup']
							},
							success: function(data) {
								console.log('createPtNoAppoint');
								console.log(data);
								setTimeout(function() {
									window.location.href = url_step_two;
								}, 2000);
							}
						});

					} else {
						setTimeout(function() {
							window.location.href = url_step_two;
						}, 2000);
					}

				} else if (data['step'] == "next3") {
					setTimeout(function() {
						window.location.href = url_step_three;
					}, 2000);
				} else if (data['step'] == "next8scan") {
					setTimeout(function() {
						window.location.href = GotoPccClear + "?data=" + data;
					}, 2000);
				} else if (data['step'] == "next6" && !data['error']) {
					setTimeout(function() {
						window.location.href = url_step_six;
					}, 2000);
					// console.log(url_step_six, 'STEP 6');
				} else if (data['success'] == false && data['error'] == 500) {
					// console.log(msg, "ERROR")
					if (data['api_his'] == false && data['api_appointment'] == true) {
						// alert('5')
						$.ajax({
							url: UrlBaseCont + '/StepProcessing/CreateOffline',
							type: "post",
							success: function(data) {
								window.location.href = url_step_two;
							}
						});
					} else if (data['api_his'] == true && data['api_appointment'] == false) {
						$.ajax({
							url: UrlBaseCont + '/StepProcessing/CreateOfflineApiErrorAppointment',
							type: "post",
							success: function(data) {
								window.location.href = url_step_two;
							}
						});
					}
				}

				// else if (data['step'] == "next2" && typeof data['oldnoappoint'] != 'undefined') { //เก่า ไม่มีนัด
				// 	console.log("createold emit");
				// 	$.ajax({
				// 		url: UrlBaseCont + '/StepProcessing/Createoldnoappoint',
				// 		type: "post",
				// 		success: function(data) {
				// 			console.log('data');
				// 			console.log(data);
				// 			window.location.href = url_step_two;
				// 		}
				// 	});


				// }
			}
		});



		$("#search_data").click(function() {

       var queuelocation=<?php echo json_encode($this->session->userdata('queuelocation'));?>;
       search_patient();
    });

		$("#box_data").keyup(function(e) {
			
			if (e.keyCode == 13) {
				
				
				search_patient();
			}
		});

		const SearchPatient = (Input) => {
			$.post("<?= APPURL . '/StepProcessing/manualInput'; ?>", {
           "input": Input
        })
       .done(function(response) {
        console.log(JSON.parse(response));
     });
    }

    function search_patient() {
      // alert('xxx');
			// alert('error500');
			// window.location.href = url_step_two;

			// return false;

			//alert($("#box_data").val());

			var tem_split = $("#box_data").val().split('/');

			// alert(tem_split[1]);

			
			if ($("#box_data").val().length == 13) { //สำหรับบัตรประชาชนเ่านั้น
				var checkform_card = checkForm($("#box_data").val());

				if (checkform_card == 'CardNotFormat') {
					$("#content_show_md").html('เลขประจําตัวผู้ป่วย / เลขบัตรประชาชน / Ref no ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
					$("#md_alert_scan").modal('show');
					$("#box_data").val('');
					return false;
				}
			}
			


			var box_data = $("#box_data").val();
			var data = {
				idcard: box_data,
				kiosk_location: kiosk_location,
				examroomid:'0501',
			};
			//extend
			SearchPatient(box_data); // สร้าง ses patient

			// url == http://...url.../api/kiosk/patient;
			$.ajax({
				url: url,
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


               localStorage.setItem('worklistgroup_new_by_pat',msg['worklistgroup']);

// alert(localStorage.getItem('worklistgroup_new_by_pat'));
					//console.log(msg);return false; //Break Test
					console.log(msg, 'MSG');
					//return false;
					if (msg.api_nocard || msg.api_no_refno) {
						if (msg.api_nocard) {
							$("#content_show_md").html('เลขประจําตัวผู้ป่วย / เลขบัตรประชาชน / Ref no ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
							$("#md_alert_scan").modal('show');
							$("#box_data").val('');
							return false;
						} else if (msg.api_no_refno != '') {
							$("#content_show_md").html('เลขประจําตัวผู้ป่วย / เลขบัตรประชาชน / Ref no ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
							$("#md_alert_scan").modal('show');
							$("#box_data").val('');
							return false;
						} else if (!msg.api_no_refno) {
							$("#content_show_md").html('เลขประจําตัวผู้ป่วย / เลขบัตรประชาชน / Ref no ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
							$("#md_alert_scan").modal('show');
							$("#box_data").val('');
							return false;
						}
					}
					// alert(msg['api_appointment'])	
					console.log(msg['step'], ' ', typeof msg['oldnoappoint']);
					if (msg['step'] == "next2") {

						if (msg['worklistgroup'] == 11) {


							$.ajax({
								url: UrlBaseCont + '/StepProcessing/createPtNoAppoint',
								type: "post",
								data: {
									worklistgroup: msg['worklistgroup']
								},
								success: function(data) {



									console.log('createPtNoAppoint');
									console.log(data);


									
									window.location.href = url_step_two;
								}
							});

						} else {
							$("#scaning").modal('show');
     $("#scan_status").html('กรุณารอสักครู่<br>. . .').css('color', '#285348');
							window.location.href = url_step_two;
						}


					} else if (msg['step'] == "next3") {
						window.location.href = url_step_three;
					} else if (msg['step'] == "next8") { //กรณีคนไข้เก่า เข้ามาอีกครั้ง
						window.location.href = GotoPccClear;
					} else if (msg['step'] == "next6") {
						window.location.href = url_step_six;
						console.log(url_step_six, 'STEP 6');
					} else if (msg['success'] == false && msg['error'] == 500) {
						// console.log(msg, "ERROR")
						if (msg['api_his'] == false && msg['api_appointment'] == true) {
							//alert('5')
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/CreateOffline',
								type: "post",
								success: function(data) {
									window.location.href = url_step_two;
								}
							});
						} else if (msg['api_his'] == true && msg['api_appointment'] == false) {
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/CreateOfflineApiErrorAppointment',
								type: "post",
								success: function(data) {
									window.location.href = url_step_two;
								}
							});
						} else {
							$.ajax({
								url: UrlBaseCont + '/StepProcessing/CreateOfflineApiErrorAppointment',
								type: "post",
								data: {
									infoData: msg['data']
								},
								success: function(data) {
									window.location.href = url_step_two;
								}
							});
						}
					} else if (false) {

					}

					// else if (msg['step'] == "next2" && typeof msg['oldnoappoint'] != 'undefined') { //เก่า ไม่มีนัด
					// 	console.log("createold search");
					// 	$.ajax({
					// 		url: UrlBaseCont + '/StepProcessing/Createoldnoappoint',
					// 		type: "post",
					// 		success: function(data) {
					// 			console.log('data');
					// 			console.log(data);
					// 			window.location.href = url_step_two;
					// 		}
					// 	});


					// }

				},
				error: function(msg) {
					console.log(msg);
				}

			});

		};

		// เช็คบัตรประชาชน

		function checkID(id) {
			if (id.length != 13) return false;
			for (i = 0, sum = 0; i < 12; i++)
				sum += parseFloat(id.charAt(i)) * (13 - i);
			if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
				return false;
			return true;
		}

		function checkForm(getid) {
			if (!checkID(getid)) { //รหัสไม่ถูก
				//alert('รหัสประชาชนไม่ถูกต้อง');
				return 'CardNotFormat';
			} else { //รหัสถูก
				// alert('รหัสประชาชนถูกต้อง เชิญผ่านได้');
				return 'CardSuccess';
			}
		}

		// เช็คบัตรประชาชน

		console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'Data SessionMain');


		$("#offline_mode").click(function() {

        

         // alert('james');
         sessionStorage.clear();
         localStorage.clear();

         $.ajax({
          url: UrlBaseCont + '/StepProcessing/CreateOffline',
          type: "post",
          async: false,
          success: function(data) {
           var offlinemode = 'offlinemode';
           createpageRedirect(offlinemode);
 <?php $this->session->unset_userdata('SessionMain');?>
           window.location.href = url_step_two;


        }

     })
      });


		function createpageRedirect(worklistgroup = null) {


			var url = $(location).attr('href');
			var parts = url.split("/");
			var mainurl = '';

			var filtered = parts.filter(function(el) {
				return el != '';
			});

			for (var i = 0; i < (filtered.length - 1); i++) {
				if (i == 0) {
					mainurl += filtered[i] + '//';
				} else {
					mainurl += filtered[i] + '/';
				}
			}
			var tem_url = filtered[filtered.length - 1];

			var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
			$.ajax({
				url: UrlBaseCont + '/StepProcessing/createPageRedirect',
				type: "post",
				//async: false,
				data: {
					fullurl: mainurl,
					worklistgroup: worklistgroup
				},
				success: function(msg) {
					console.log(JSON.parse(msg), 'createpageRedirect');
					//alert(JSON.parse(msg)['indexpagenow']+' '+tem_url);
					$.ajax({
						url: UrlBaseCont + '/StepProcessing/createPageRedirect',
						type: "post",
						//async: false,
						data: {
							indexpage: JSON.parse(msg)['indexpagenow'],
							tem_url: tem_url,

						},
						success: function(msg) {
							console.log(JSON.parse(msg), 'createpageRedirect++');
						}
					});
				}
			});
		}


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

<!-- <script>
	<?php echo Modules::run('Websocket/SocketConection') ?>
	var UrlBaseKiosk = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?> + '/';

	var LimitTimeout = 3;
	var EventTimeout = 0;
	setInterval(() => {
		if (EventTimeout == 3) {
			window.location.href = UrlBaseKiosk;
		}
		EventTimeout++;
	}, 1000);
</script> -->