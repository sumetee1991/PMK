<script>
   <?php echo Modules::run('Websocket/SocketConection'); ?>

   console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'test');
   console.log(<?php echo json_encode($this->session->userdata('SessionClinicName')); ?>, 'SessionClinicName');
   console.log(<?php echo json_encode($this->session->userdata('queuelocation')); ?>);
   var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
   var visitcode = '';
   midSocket.on('scan_station', function(data) {
      if (data['step'] == 'next1') {
         window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
      }
   });
   var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
   var result_session = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
   console.log(result_session, "SESSIONALL")
   if (result_session['UserInfo']) {
      var worklistgroup = result_session['UserInfo']['worklistgroup'];
   } else {
      var worklistgroup = result_session['worklistgroup'];
   }
   // var worklistgroup = 9;
   var payor = result_session['PayorActive']['PayorActive'];
   var PersonType = result_session['PersonType']['PersonType'];
   var Userinfo = '';
   try {
      Userinfo = result_session['UserInfo'];

      var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
      var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
      if (Userinfo != null) {
         if (Userinfo['data'][0]['gender'] == 'male') {
            $("#imgavatar").find("img").attr("src", imgMan);
         } else if (Userinfo['data'][0]['gender'] == 'female') {
            $("#imgavatar").find("img").attr("src", imgWoman);
         } else if (Userinfo['data'][0]['gender'] == '') {

         }
      }

      // alert(worklistgroup);
      console.log(Userinfo, 'USERINFO')

      var userInfo = '';
      for (k in Userinfo['data']) {
         userInfo = JSON.stringify({
            data1: Userinfo['data'][k]
         });
      }
   } catch (e) {
      console.log(e);
   }

   // console.log(userInfo);
   console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
   var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;

   if (!worklistgroup) {
      if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '2') {
         worklistgroup = '21';

      } else if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '1') {
         worklistgroup = '22';

      } else if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '3') {
         worklistgroup = '23';

      } else if (result_session['worklistgroup'] == '2') {
         worklistgroup = '12';

      } else if (result_session['worklistgroup'] == '3') {
         worklistgroup = '13';
      } else if (result_session['worklistgroup'] == '1') {
         worklistgroup = '11';
      } else if (result_session['PayorActive']['PayorActive'] == '23') {

      }
   }



   ///////////////////// start ///////////////////////////
   $.ajax({
      url: baseurlMid + '/api/kiosk/worklist/process',
      method: "post",
      dataType: 'json',
      headers: {
         'Access-Control-Allow-Origin': '*',
         'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
         'Access-Control-Allow-Headers': '*',
         'Authorization': 'Basic YXJtOjEyMzQ='
      },
      data: {
         worklistgroup: worklistgroup,
         kiosk_location: kiosk_location
      },
      success: function(data) {
         console.log(data, 'zaza');
         console.log(data.kiosk_location + " : " + kiosk_location, 'check kiosklocation');
         if (data.kiosk_location == kiosk_location) {
            // midSocketgetworklistprocess(msg.kiosk_location);


            // console.log(data.kiosk_location + " : " + kiosk_location, 'check kiosklocation 1');
            console.log(data, 'get_worklistprocess');
            var html = '';

            var SessionClinicName = <?php echo json_encode($this->session->userdata('SessionClinicName')); ?>;
            var clinicname_show = (!SessionClinicName) ? '' : SessionClinicName['clinicName'];

            html += "<div class='row no-gutters col-12 justify-content-md-center'>";
            html += "<div class='col-1 center ps_margin_r'>";
            html += '<?= single_img('kiosk/resources/images/icon/G1.png', array('class' => '_img_02')); ?>';
            html += "<p class='ps_runnum'></p>";
            html += "</div>";
            html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
            html += "<a class='bodyth'>ออกคิวเข้ารับบริการ</a>";
            html += "</div>";
            html += "<div class='col-2'>";
            html += "<span class='text_comp bodyth'>เสร็จสิ้น</span>";
            html += "</div>";
            html += "</div>";

            for (var i = 0; i < data.data.length; i++) {
               if ((i + 1) == data.data.length) {
                  var img = '<?= single_img('kiosk/resources/images/icon/Y2.png', array('class' => '_img_02')); ?>';
               } else {
                  var img = '<?= single_img('kiosk/resources/images/icon/Y1.png', array('class' => '_img_02')); ?>';
               }

               if (data.data[i]['worklistuid'] == '6') { //ติดต่อห้องตรวจ
                  html += "<div class='row no-gutters col-12 justify-content-md-center'>";
                  html += "<div class='col-1 center ps_margin_r'>";
                  html += img;
                  html += "<p class='ps_runnum'>" + (i + 1) + "</p>";
                  html += "</div>";
                  html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
                  html += "<a class='bodyth'>" + data.data[i]['flowname'] + " " + clinicname_show + "</a>";
                  html += "</div>";
                  html += "<div class='col-2'>";
                  html += "<span class='bodyth'></span>";
                  html += "</div>";
                  html += "</div>";
               } else {
                  html += "<div class='row no-gutters col-12 justify-content-md-center'>";
                  html += "<div class='col-1 center ps_margin_r'>";
                  html += img;
                  html += "<p class='ps_runnum'>" + (i + 1) + "</p>";
                  html += "</div>";
                  html += "<div class='col-7' style='align-items: center;max-height:50px;'>";
                  html += "<a class='bodyth'>" + data.data[i]['flowname'] + "</a>";
                  html += "</div>";
                  html += "<div class='col-2'>";
                  html += "<span></span>";
                  html += "</div class='bodyth'>";
                  html += "</div>";
               }

            }
            $("#area_list_process").html(html);

         }
      },
      error: function(msg) {
         // console.log(msg);
      }

   });

   function midSocketgetworklistprocess() {
      midSocket.on('get_worklistprocess', function(data) {


      });
   }

   ///////////////////// end ///////////////////////////




   var NextToSlip = baselocal + <?php echo Modules::run('Websocket/NextToSlip') ?>;
   var SessionClinicName = <?php echo json_encode($this->session->userdata('SessionClinicName')); ?>;
   var clinicname = (!SessionClinicName) ? '' : SessionClinicName['clinicName'].join(',');

   $("#cf_processing").click(function() {
      var Userinfo = result_session['UserInfo'];
      var api_url = baselocal + '/StepProcessing/visitCurl';

      //  alert(api_url);
      if (result_session['UserInfo']['data']) {
         // alert(result_session['UserInfo']['data'][0].hnno);
         var hn = result_session['UserInfo']['data'][0].hnno;
      }




      // if(!result_session['UserInfo']['dataAppointment']){

      // }
      if (hn) {

         var newhn = hn.split('/');
         var patientHN = newhn[0] || "";
         var yearHN = newhn[1] || "";
         // alert('PATIENT HN : '+patientHN);
         // alert('YEAR : '+yearHN);
      
         // hn.split('/').forEach(function(item) {
         //    if (item.length == 2) {
         //       yearHN = item;
         //       alert(yearHN);
         //    } else {
         //       patientHN = item;
         //       alert(patientHN);
         //    }
         // });


         var api_visit_post = {
            'p_run_hn': patientHN,
            'p_year_hn': yearHN,
            'p_opd': "0501",
            'p_user_created': "kiosk",
            'p_visit_type': "2",
            // 'refno': '1',
            // 'pid': '2'
         };
         var ortho_math = [];
         if (result_session['UserInfo']['dataAppointment']) {
            // var dataapp =  JSON.parse(result_session['UserInfo']['dataAppointment']);
            var dataapp = result_session['UserInfo']['dataAppointment']['data'] || [];
            var code = ['0501', '0502', '0503', '0504', '0505', '0506', '0507', '0508', '0509', '0510', '0511', '0512', '0513', '0514', '0515', '0516', '0517', '0518', '0519', '0520', '0521', '1609'];
            for (let i in dataapp) {
               if (code.indexOf(dataapp[i].examRoomId)!==-1) {
                  ortho_math.push(dataapp[i].examRoomId);
               }
            }
            // if(ortho_math.length>0){

            // }

            // console.log('mmmm',result_session['UserInfo']['dataAppointment']['data']);
            console.log("ORTHO MATCH", ortho_math);
         } else {
            api_visit_post = {
               'p_run_hn': patientHN,
               'p_year_hn': yearHN,
               'p_opd': "0501",
               'p_user_created': "kiosk",
               'p_visit_type': "2",
               // 'refno': '1',
               // 'pid': '2'
            };
         }
         // console.log("APIURL : " + api_url);
         if (ortho_math.length > 0) {
            for (let i in ortho_math) {
               console.log('LOOP ORTHO CODE : '+ortho_math[i]);
               var api_visit_post_ortho = {
                  'p_run_hn': patientHN,
                  'p_year_hn': yearHN,
                  'p_opd': ortho_math[i],
                  'p_user_created': "kiosk",
                  'p_visit_type': "2",
               };
               $.ajax({
                     url: api_url,
                     method: 'POST',
                     dataType: 'json',
                     data: api_visit_post_ortho,
                     headers: {
                        'Access-Control-Allow-Origin': '*',
                        'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                        'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept'
                     }
                  })
                  .done(function(data, textStatus, xhr) {
                     
                     console.log("API DATA ", data);
                     // alert(data.code);

                     console.log("parse", JSON.parse(data));

                  })
                  .fail(function(xhr, error_text, statusText) {
                     // alert(error_text);
                     // alert(xhr.ERROR-MESSAGe);
                     console.log(error_text);
                     console.log(statusText);
                     openvisit = 1;
                  })
                  .always(function(data, textStatus, xhr) {
                     console.log(`API CODE :` + data);
                  });
            }

         } else {
            $.ajax({
                  url: api_url,
                  method: 'POST',
                  dataType: 'json',
                  data: api_visit_post,
                  headers: {
                     'Access-Control-Allow-Origin': '*',
                     'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                     'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept'
                  }
               })
               .done(function(data, textStatus, xhr) {

                  console.log("API DATA ", data);
                  // alert(data.code);

                  console.log("parse", JSON.parse(data));

               })
               .fail(function(xhr, error_text, statusText) {
                  // alert(error_text);
                  // alert(xhr.ERROR-MESSAGe);
                  console.log(error_text);
                  console.log(statusText);
                  openvisit = 1;
               })
               .always(function(data, textStatus, xhr) {
                  console.log(`API CODE :` + data);
               });
         }


      }


      if (!worklistgroup) {
         if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '2') {
            worklistgroup = '21';

         } else if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '1') {
            worklistgroup = '22';

         } else if (result_session['PayorActive']['PayorActive'] == '26' && result_session['worklistgroup'] == '3') {
            worklistgroup = '23';

         } else if (result_session['worklistgroup'] == '2') {
            worklistgroup = '12';

         } else if (result_session['worklistgroup'] == '3') {
            worklistgroup = '13';
         } else if (result_session['worklistgroup'] == '1') {
            worklistgroup = '11';
         }



      }

      //window.location.href = NextToSlip;
      // alert(payor);
      EventTimeout = 0; // check redirect

      $("#cf_processing").css({
         'opacity': '0.2',
         'cursor': 'default',
         'pointer-events': 'none'
      })
      $("#cf_processing").prop('disabled', false);

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
      console.log(userInfo, "USER INFO OOOO")
      var test = baseurlMid + '/api/kiosk/gen/queueno';
      console.log(test, "TESTSSS")
      var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
      if (localStorage.getItem('appointTimeStart') !== "" || localStorage.getItem('appointTimeStart') !== null) {
         var start_appointment = localStorage.getItem('appointTimeStart');
      } else {
         var start_appointment = null;
      }

      // alert(start_appointment);
      $.ajax({ // send gen queue
         url: baseurlMid + '/api/kiosk/gen/queueno',
         method: "post",
         dataType: 'json',
         headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
            'Access-Control-Allow-Headers': '*',
            'Authorization': 'Basic YXJtOjEyMzQ='
         },
         data: {
            worklistgroup: worklistgroup,
            payor: payor,
            persontype: PersonType,
            userinfo: userInfo,
            kiosk_location: kiosk_location,
            clinicname: clinicname,
            queuelocation: queuelocation,
            start_appointment: start_appointment,
         },
         success: function(msg) {
            console.log(msg, 'zaza++');
         },
         error: function(msg) {
            // console.log(msg);
         }

      });

   });

   midSocket.on('redirect_slip', function(data) { //socket derirect
      console.log(data, 'redirect_slip');

      if (data['kiosk_location'] == kiosk_location) {
         if (data['step'] == 'next7') {
            window.location.href = NextToSlip;
         }
      }


   });

   midSocket.on('genqueue', function(data) {
      console.log(data, 'genqueue socket');


      if (data['kiosk_location']) {
         if (data['kiosk_location'] == kiosk_location) {

            var Queueno = [];
            var categoryuid_array = [];
            var uidPatient = '';
            var refno = data['refno'];
            try {
               for (var i = 0; i < data.data.length; i++) {
                  Queueno.push(data.data[i].queueno);
                  categoryuid_array.push(data.data[i].queuecategoryuid);
                  uidPatient = data.data[i].patientuid;
               }
            } catch (e) {
               var groupprocessuid = data[0]['data']['groupprocessuid'];
               var queuecategoryuid = data[0]['data']['queuecategoryuid'];
               var queueno = data[0]['data']['queueno'];
               var uid = data[0]['data']['uid'];
               var Patientuid_noqueue = data[0]['data']['Patientuid'];
            }

            // $.each(data, function(index, value) {

            //     var no_now = parseInt(value['queueno'].substr(-3));
            //     var calculate = parseInt(no_now) + 1;
            //     var new_no = 0;

            //     if (no_now < 10) {
            //         new_no = value['categoryuid'] + '00' + calculate;
            //     } else if (no_now < 100) {
            //         new_no = value['categoryuid'] + '0' + calculate;
            //     }else{
            //         new_no = value['categoryuid'] + calculate;
            //     }

            //     Queueno.push(new_no);
            //     categoryuid_array.push(value['categoryuid']);
            // });

            console.log(Queueno, 'Queueno new');

            //alert(new_no);

            console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'testtesttest');

            var new_queue = '';
            var typeuid = '';
            var patientuid = '';

            $.ajax({ //create session
               url: UrlBaseCont + '/StepProcessing/CreateSesQueueNew',
               type: "post",
               dataType: "json",
               data: {
                  QueueNew: Queueno,
                  Typeuid: data.typeuid,
                  Patientuid: uidPatient
               },
               success: function(msg) {
                  console.log(msg, 'genแล้ว');
                  new_queue = msg['QueueNew']['QueueNew'];
                  typeuid = msg['QueueNew']['Typeuid'];
                  patientuid = msg['QueueNew']['Patientuid'];
               } //success
            });


            try {

               var ses_all = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;

               var Appointment = ses_all['Appointment']['Appointment'];
               var PatientNewOrOld = null;
               var PayorActive = ses_all['PayorActive']['PayorActive'];
               var PersonType = ses_all['PersonType']['PersonType'];
               var QueueNew = new_queue; //ต้องทำการเรียกใช้จากการ return ajax เพราะ php มีการ render ไปก่อนแล้วทำให้ เรียกจาก session ไม่ได้
               var Typeid = typeuid;
               var Patientuid = patientuid;
               var idcard = ses_all['UserInfo']['data'][0]['idcard'];
               var UserInfo = ses_all['UserInfo'];
               var user_info = ses_all['UserInfo'];


               var worklistgroup = user_info['worklistgroup'];
               var step = user_info['step'];
               var scan = user_info['scan'];
               var location = user_info['location'];
               var from_lc = user_info['from_lc'];

               for (i in user_info['data']) {
                  var info = JSON.stringify({
                     data2: user_info['data'][i]
                  });
               }
            } catch (e) {
               var ses_all = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
               var Appointment = ses_all['Appointment']['Appointment'];
               var PatientNewOrOld = null;
               var PayorActive = ses_all['PayorActive']['PayorActive'];
               var PersonType = ses_all['PersonType']['PersonType'];
               var QueueNew = new_queue;
               var Typeid = typeuid;
               var Patientuid = patientuid;
               var info = '';
               var idcard = '';
               var worklistgroup = ses_all['worklistgroup'];
            }

            if (worklistgroup) {
               if (result_session['PayorActive']['PayorActive'] == '26' && worklistgroup == '2') {
                  worklistgroup = '21';

               } else if (result_session['PayorActive']['PayorActive'] == '26' && worklistgroup == '1') {
                  worklistgroup = '22';

               } else if (result_session['PayorActive']['PayorActive'] == '26' && worklistgroup == '3') {
                  worklistgroup = '23';

               } else if (worklistgroup == '2') {
                  worklistgroup = '12';

               } else if (worklistgroup == '3') {
                  worklistgroup = '13';
               } else if (worklistgroup == '1') {
                  worklistgroup = '11';
               }
            }

            // console.log(JSON.stringify({data: ['data']});
            console.log(info);

            if (Queueno != '') { //เงื่อนไขแบบ เปิดสิทธิ ปกติ จะมี queueno
               var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
               $.ajax({ // send print queue
                  url: baseurlMid + '/api/kiosk/print',
                  method: "post",
                  dataType: 'json',
                  headers: {
                     'Access-Control-Allow-Origin': '*',
                     'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                     'Access-Control-Allow-Headers': '*',
                     'Authorization': 'Basic YXJtOjEyMzQ='
                  },
                  data: {
                     Queueno: JSON.stringify(Queueno),
                     Categoryuid: JSON.stringify(categoryuid_array),
                     Typeuid: data.typeuid,
                     Patientuid: uidPatient,
                     PayorActive: PayorActive,
                     PersonType: PersonType,
                     PatientNewOrOld: PatientNewOrOld,
                     idcard: idcard,
                     worklistgroup: worklistgroup,
                     info: info,
                     requestPrint: '1',
                     refno,
                     kiosk_location: kiosk_location,
                     queuelocation: queuelocation,
                  },
                  success: function(msg) {
                     console.log(msg, 'คิวปกติ');
                     window.location.href = NextToSlip;
                  },
                  error: function(msg) {
                     console.log(msg);
                  }

               }); //ajax
            } else { //เงื่อนไขแบบ เปิดสิทธิ auto
               var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
               $.ajax({ // send print queue
                  url: baseurlMid + '/api/kiosk/print',
                  method: "post",
                  dataType: 'json',
                  headers: {
                     'Access-Control-Allow-Origin': '*',
                     'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                     'Access-Control-Allow-Headers': '*',
                     'Authorization': 'Basic YXJtOjEyMzQ='
                  },
                  data: {
                     Queueno: queueno,
                     Categoryuid: queuecategoryuid,
                     Typeuid: data.typeuid,
                     Patientuid: Patientuid_noqueue,
                     PayorActive: PayorActive,
                     PersonType: PersonType,
                     PatientNewOrOld: PatientNewOrOld,
                     idcard: idcard,
                     worklistgroup: worklistgroup,
                     info: info,
                     requestPrint: '1',
                     refno,
                     kiosk_location: kiosk_location,
                     queuelocation: queuelocation,
                  },
                  success: function(msg) {
                     console.log(msg, 'คิวแบบ payor อัตโนมัติ');
                     window.location.href = NextToSlip;
                  },
                  error: function(msg) {
                     console.log(msg);
                  }
               }); //ajax
            }
         }
      } else if (data[0]['data']['kiosk_location']) {
         if (data[0]['data']['kiosk_location'] == kiosk_location) {

            var Queueno = [];
            var categoryuid_array = [];
            var uidPatient = '';
            var refno = data['refno'];

            try {
               for (var i = 0; i < data.data.length; i++) {
                  Queueno.push(data.data[i].queueno);
                  categoryuid_array.push(data.data[i].queuecategoryuid);
                  uidPatient = data.data[i].patientuid;
               }
            } catch (e) {
               var groupprocessuid = data[0]['data']['groupprocessuid'];
               var queuecategoryuid = data[0]['data']['queuecategoryuid'];
               var queueno = data[0]['data']['queueno'];
               var uid = data[0]['data']['uid'];
               var Patientuid_noqueue = data[0]['data']['Patientuid'];
            }

            // $.each(data, function(index, value) {
            //     var no_now = parseInt(value['queueno'].substr(-3));
            //     var calculate = parseInt(no_now) + 1;
            //     var new_no = 0;

            //     if (no_now < 10) {
            //         new_no = value['categoryuid'] + '00' + calculate;
            //     } else if (no_now < 100) {
            //         new_no = value['categoryuid'] + '0' + calculate;
            //     }else{
            //         new_no = value['categoryuid'] + calculate;
            //     }
            //     Queueno.push(new_no);
            //     categoryuid_array.push(value['categoryuid']);
            // });

            console.log(Queueno, 'Queueno new');

            //alert(new_no);

            console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'testtesttest');

            var new_queue = '';
            var typeuid = '';
            var patientuid = '';

            $.ajax({ //create session
               url: UrlBaseCont + '/StepProcessing/CreateSesQueueNew',
               type: "post",
               dataType: "json",
               data: {
                  QueueNew: Queueno,
                  Typeuid: data.typeuid,
                  Patientuid: uidPatient
               },
               success: function(msg) {
                  console.log(msg, 'genแล้ว');
                  new_queue = msg['QueueNew']['QueueNew'];
                  typeuid = msg['QueueNew']['Typeuid'];
                  patientuid = msg['QueueNew']['Patientuid'];
               } //success
            });

            try {
               var ses_all = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;

               var Appointment = ses_all['Appointment']['Appointment'];
               // var PatientNewOrOld = ses_all['PatientNewOrOld']['PatientNewOrNoHn'];
               var PayorActive = ses_all['PayorActive']['PayorActive'];
               var PersonType = ses_all['PersonType']['PersonType'];
               var QueueNew = new_queue; //ต้องทำการเรียกใช้จากการ return ajax เพราะ php มีการ render ไปก่อนแล้วทำให้ เรียกจาก session ไม่ได้
               var Typeid = typeuid;
               var Patientuid = patientuid;
               var idcard = ses_all['UserInfo']['data'][0]['idcard'];
               var UserInfo = ses_all['UserInfo'];
               var user_info = ses_all['UserInfo'];


               var worklistgroup = user_info['worklistgroup'];
               var step = user_info['step'];
               var scan = user_info['scan'];
               var location = user_info['location'];
               var from_lc = user_info['from_lc'];

               for (i in user_info['data']) {
                  var info = JSON.stringify({
                     data2: user_info['data'][i]
                  });
               }
            } catch (e) {
               var ses_all = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
               var Appointment = ses_all['Appointment']['Appointment'];
               var PatientNewOrOld = null;
               var PayorActive = ses_all['PayorActive']['PayorActive'];
               var PersonType = ses_all['PersonType']['PersonType'];
               var QueueNew = new_queue;
               var Typeid = typeuid;
               var Patientuid = patientuid;
               var info = '';
               var idcard = '';
               var worklistgroup = ses_all['worklistgroup'];
            }


            // console.log(JSON.stringify({data: ['data']});
            // console.log(info);

            if (Queueno != '') { //เงื่อนไขแบบ เปิดสิทธิ ปกติ จะมี queueno
               var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
               $.ajax({ // send print queue
                  url: baseurlMid + '/api/kiosk/print',
                  method: "post",
                  dataType: 'json',
                  headers: {
                     'Access-Control-Allow-Origin': '*',
                     'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                     'Access-Control-Allow-Headers': '*',
                     'Authorization': 'Basic YXJtOjEyMzQ='
                  },
                  data: {
                     Queueno: JSON.stringify(Queueno),
                     Categoryuid: JSON.stringify(categoryuid_array),
                     Typeuid: data.typeuid,
                     Patientuid: uidPatient,
                     PayorActive: PayorActive,
                     PersonType: PersonType,
                     // PatientNewOrOld: PatientNewOrOld,
                     idcard: idcard,
                     worklistgroup: worklistgroup,
                     info: info,
                     requestPrint: '1',
                     refno,
                     kiosk_location: kiosk_location,
                     queuelocation: queuelocation,
                  },
                  success: function(msg) {
                     console.log(msg, 'คิวปกติ');
                     window.location.href = NextToSlip;
                  },
                  error: function(msg) {
                     console.log(msg);
                  }

               }); //ajax
            } else { //เงื่อนไขแบบ เปิดสิทธิ auto
               var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
               $.ajax({ // send print queue
                  url: baseurlMid + '/api/kiosk/print',
                  method: "post",
                  dataType: 'json',
                  headers: {
                     'Access-Control-Allow-Origin': '*',
                     'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                     'Access-Control-Allow-Headers': '*',
                     'Authorization': 'Basic YXJtOjEyMzQ='
                  },
                  data: {

                     Queueno: queueno,
                     Categoryuid: queuecategoryuid,
                     Typeuid: data.typeuid,
                     Patientuid: Patientuid_noqueue,
                     PayorActive: PayorActive,
                     PersonType: PersonType,
                     // PatientNewOrOld: PatientNewOrOld,
                     idcard: idcard,
                     worklistgroup: worklistgroup,
                     info: info,
                     requestPrint: '1',
                     refno,
                     kiosk_location: kiosk_location,
                     queuelocation: queuelocation,
                  },
                  success: function(msg) {
                     console.log(msg, 'คิวแบบ payor อัตโนมัติ');
                     window.location.href = NextToSlip;
                  },
                  error: function(msg) {
                     console.log(msg);
                  }

               }); //ajax
            }

         }
      }
   }); //socket

   var NextToSlip = baselocal + <?php echo Modules::run('Websocket/NextToSlip') ?>;
</script>