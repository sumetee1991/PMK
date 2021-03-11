<style type="text/css">
   .txt_b {
      font-family: cs_prajad_b;
      font-size: 20px;
   }

   .txt {
      font-family: cs_prajad_b;
      font-size: 20px;
   }
</style>



<script type="text/javascript">

$.ajaxSetup({
   cache: false,
   headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
      'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
      'Authorization':'Basic YXJtOjEyMzQ=',
   }
});

   const axiosToken = axios.create({
      withCredentials: true,
      headers: {
         'Access-Control-Allow-Origin': '*',
         'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
         'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
      },
   });

   function logoutAPI() {
      console.log("Logout API");
      axiosToken
         // .post('http://service.healthyflow.xyz/hybrid-auth/api/logout','')
         .post('http://flow-hybrid-auth.pmk.local/api/logout', '')
         .then(res => res.data)
         .catch(err => {
            /* not hit since no 401 */ });
      sessionStorage.clear();
      // window.location.replace("http://healthyflow.xyz/");
   }

   function refreshAPI() {
      console.log("RefreshToken API");
      axiosToken
         // .post('http://service.healthyflow.xyz/hybrid-auth/api/refresh','')
         .post('http://flow-hybrid-auth.pmk.local/api/refresh', '')
         .then(res => {
            //console.log(res.data)
            var refreshToken = res.data['accessToken'];
            sessionStorage.setItem("hlab_access_token", refreshToken);
         })
         .catch(err => {
            console.log(err)
         })
   }

   function DecodeJWT(Token) {
      let result = KJUR.jws.JWS.parse(Token);
      return result['payloadObj'];
   }

   function getStorageToken(StorageName) {
      var Token = sessionStorage[StorageName];
      return Token;
   }

   function checkExpired(TokenExpired) {
      var current = new Date().getTime();
      console.log("Expired : " + TokenExpired);
      if (TokenExpired > current) {
         console.log("Token Not Expired Yet");
         var ExpiredTime = (TokenExpired - current) - 60000;
         console.log("Left : " + ExpiredTime + " milliseconds");
         window.setTimeout(function() {
            console.log("Token Expired Already - Refresh Token");
            refreshAPI();
         }, ExpiredTime);
         return false;
      } else {
         console.log("Token Expired");
         var PassedExpiredTime = current - TokenExpired;
         console.log("Passed : " + PassedExpiredTime + " milliseconds");
         return true;
      }
   }



   var ajaxURL = '';
   $(document).ready(function() {
      var segment = "<?= $this->uri->segment($this->uri->total_segments()); ?>";
      $('.nav-link').each(function(index) {
         $(this).attr('href', (segment == '' ? './Test_pm' : '.') + $(this).attr('href'));
      });
      ajaxURL = "<?=APPURLSETUP.'/Test_pm';?>"; //Overwrite ajaxURL [ (segment == '' ? './test_pm' : '.') ]te ajaxURL [ (segment == '' ? './test_pm' : '.') ]

      //Init Token
      if (getStorageToken('hlab_access_token')) {
         var TokenKey = getStorageToken('hlab_access_token');
         var TokenDecode = KJUR.jws.JWS.parse(TokenKey);
         var TokenObject = DecodeJWT(TokenKey);

         if (!checkExpired(TokenObject['exp'])) {
            $('#span_Login').text(TokenObject['sub']);
            $('#span_serviceUnitAbbreviation').text(TokenObject['serviceUnitName']);
         } else {
            $('#span_Login').text("No User : Session Expired");
            // window.location.replace("http://healthyflow.xyz/");
            <?php if (defined('TESTMODE') && TESTMODE == 'Y') : ?>
               $('#span_Login').text("Test : " + TokenObject['sub']);
               $('#span_serviceUnitAbbreviation').text("Test : " + TokenObject['serviceUnitName']);
            <?php endif; ?>
         }

         window.addEventListener('storage', function(e) {

            if (e.storageArea === sessionStorage) {
               if (!getStorageToken('hlab_access_token')) {
                  // window.location.replace("http://healthyflow.xyz/");             
               }
            }
         });
      } else {
         console.log("No Session!");
         $('#span_Login').text("No User : No Session");
         var currentURL = window.location.href;
         var currentURI = '<?= $_SERVER['REQUEST_URI']; ?>';
         var explodeURI = currentURI.split('/');
         explodeURI[0] = 'http://';

         var domainURL = currentURL;
         explodeURI.forEach(function(value, index) {
            domainURL = domainURL.replace('/' + value, '');
         });
         domainURL = domainURL;

         console.log("Redirect to " + domainURL);
         // window.location.replace("http://healthyflow.xyz/");

      }
      //Init
      $(document).on("click", "#acc_logout", function(e) {
         logoutAPI();
      });

      show_grouprocess_list();

      $("#groupprocess_list .payor").sortable({
         update: function(event, ui) {
            $('#groupprocess_list .payor .card .card-body input').each(function(i) {
               var numbering = i + 1;
               var sort = $(this).val(numbering);
               var id = $(this).data('sort');
               update_sort(numbering, id);
            })
         }
      });

      function update_sort($sort, $id) {
         $.ajax({
            url: ajaxURL + "/update_sort/" + $id + '/' + $sort,
            type: "post",
            data: {
               sort: $sort
            },
            dataType: "json",
            cache: false,
            processData: false,
            success: function(data) {}
         });
      }
      // queue_category();
      show_payor();
      show_patient_type();
      show_grouprocess();


      function show_grouprocess_list() {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/get_groupprocess",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               var k = 1;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<div class="row txt_b payor cat' + k + '"><div class="col-12">' + data[i].name + '</div>';
                  // queue_category_list(data[i].uid);
                  $.ajax({
                     type: 'ajax',
                     url: ajaxURL + "/queue_category_data_list/" + data[i].uid,
                     async: false,
                     dataType: 'json',
                     success: function(data) {
                        var j = 1;
                        var i;
                        for (i = 0; i < data.length; i++) {
                           html += '<div class="col-4"><div class="card bg-light shadow mb-2"><div class="card-body txt"><input type="hidden" name="name" data-sort="' + data[i].uid + '" value="' + j + '">' + data[i].name +
                              '<div>' +
                              '<a href="javascript:void(0);" class="btn btn_edit btn_pmk btn-sm item_edit" data-uid="' + data[i].uid + '" data-code="' + data[i].code + '" data-name="' + data[i].name + '" data-description="' + data[i].description + '"  data-groupprocessuid="' + data[i].groupprocessuid + '" data-counter="' + data[i].counter + '" data-active="' + data[i].active + '" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>' + '' +
                              '<a href="javascript:void(0);" class="btn btn_edit btn_pmk btn-sm item_delete" data-product-id="' + data[i].uid + '" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>' +
                              '</div></div></div></div>';
                           j++;
                        }

                        // console.log(html);
                        // $('#show_data_list1').html(html);

                        // $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: Mitr;font-size: 18px;">ตกลง</button>');
                        $('#loading').css('display', 'none');

                     }
                     // $("#show_data_list1").html(html);

                  });
                  k++;
                  html += '</div>';

               }

               $('#groupprocess_list').html(html);

            }
         });
      }





      function queue_category_list($id) {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/queue_category_data_list/" + $id,
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html += '<div>' + data[i].name + '</div>';
               }

               // console.log(html);
               $('#show_data_list1').html(html);

               // $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: Mitr;font-size: 18px;">ตกลง</button>');
               // $('#loading').css('display','none');
            }
            // $("#show_data_list1").html(html);

         });
      }






      //  function queue_category(){
      //     $.ajax({
      //      type  : 'ajax',
      //      url   : ajaxURL+"/queue_category_data",
      //      async : false,
      //      dataType : 'json',
      //      success : function(data){
      //       var html = '';
      //       var i;
      //       for(i=0; i<data.length; i++){
      //          html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card bg-light shadow h-100"><div class="card-body">'+
      //          '<div style="font-family:cs_prajad_b;font-weight:400;font-size:20px;">'+data[i].code+'</div>'+
      //          '<div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;">'+data[i].name+'</div>'+
      //          '<div>'+
      //          '<a href="javascript:void(0);" class="btn btn_edit btn_pmk btn-sm item_edit" data-uid="'+data[i].uid+'" data-code="'+data[i].code+'" data-name="'+data[i].name+'" data-description="'+data[i].description+'"  data-groupprocessuid="'+data[i].groupprocessuid+'"  style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>'+' '+
      //          '<a href="javascript:void(0);" class="btn btn_edit btn_pmk btn-sm item_delete" data-product-id="'+data[i].uid+'" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>'+
      //          '</div>'+
      //          '</div></div></div>';
      //       }
      //       $('#show_data').html(html);

      //       $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: Mitr;font-size: 18px;">ตกลง</button>');
      //       $('#loading').css('display','none');
      //    }

      // });
      //  }







      function show_grouprocess() {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/get_groupprocess",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '<option value="">กรุณาระบุกระบวนการ</option>';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('#groupprocess_sl').html(html);

               $('#groupprocess_esl').html(html);
            }
         });
      }



      function show_payor() {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/payor_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('.payorid').html(html);
            }
         });
      }


      function show_payor_add(id) {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/payor_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('#payorid_add' + id + '').html(html);
            }
         });
      }


      function show_patient_type_add(id) {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/patient_type_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('#patient_type_add' + id + '').html(html);
            }
         });
      }



      function show_payor_select(id) {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/payor_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('#edit' + id + '').html(html);
            }
         });
      }


      function show_patient_type() {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/patient_type_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('.patient_type_data').html(html);
            }
         });
      }

      function show_patient_type_select(id) {
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/patient_type_data",
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               for (i = 0; i < data.length; i++) {
                  html +=
                     '<option value="' + data[i].uid + '">' + data[i].name + '</option>';
               }
               $('#patient_type_edit' + id + '').html(html);
            }
         });
      }

      $('#btn_upload').click(function(e) {
         // var formData = new FormData($('#submit')[0])
         // $('#submit').submit(function(e){
         // e.preventDefault(); 
         $.ajax({
            url: ajaxURL + "/add_queue_category",
            type: "post",
            data: new FormData($('#submit')[0]), //this is formData
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
               $('#submit')[0].reset();
               $('#add_modal').modal('hide');
               $('#fields1').html('');
               show_grouprocess_list();

            }
         });
      });

      $('#btn-add').click(function() {
         $('#add_modal').modal('show');
         $('#submit')[0].reset();
      });


      $('#groupprocess_list').on('click', '.item_edit', function() {

         $('input[type=checkbox]').prop('checked', false);


         var code = $(this).data('code');
         var name = $(this).data('name');
         var description = $(this).data('description');
         var groupprocessuid = $(this).data('groupprocessuid');
         var counter = $(this).data('counter');
         var active = $(this).data('active');

         var uid = $(this).data('uid');
         $('#edit_modal').modal('show');
         $('#code_edit').val(code);
         $('#name_edit').val(name);
         $('#description_edit').val(description);
         $('#uid_edit').val(uid);
         $('#groupprocess_esl').val(groupprocessuid);
         $('#counter_edit').val(counter);
         $('#active_edit').val(active);


         // alert(uid);
         $.ajax({
            type: 'ajax',
            url: ajaxURL + "/get_catgory_detail/" + uid,
            async: false,
            dataType: 'json',
            success: function(data) {


               var html = '';
               var i;
               var j = 1;
               for (i = 0; i < data.length; i++) {

                  console.log(data[i].uid);


                  html += '<input type="checkbox" name="chk[chk][]" id="chk' + data[i].uid + '" value="' + data[i].uid + '" style="position:absolute;z-index:-999;"><div class="row" id="row' + j + '">' +
                     '<div class="col-5"><input type="hidden"  name="detailuid[detailuid][]" value="' + data[i].uid + '"><div class="form-group"><select name="payorid[payorid][]" class="form-control payorid" id="payorid' + j + '" value="' + data[i].payoruid + '" style="font-family:cs_prajad_b;"></select></div></div>' +
                     '<div class="col-5"><div class="form-group"><select name="patient_type_data[patient_type_data][]" id="patient_type_data' + j + '" class="form-control patient_type_data" value="' + data[i].patienttypeuid + '" style="font-family:cs_prajad_b;"></select></div></div><div class="col-2"><button type="button" data-uid="' + data[i].uid + '" name="remove" id="' + j + '" class="btn btn_pmk btn-sm btn_remove"><i class="fa fa-minus"></i></button>' +
                     '</div></div>';

                  j++;
               }


               $('#fields1_edit').html(html);

               show_payor();
               show_patient_type();


               var k = 1;
               for (i = 0; i < data.length; i++) {
                  $('#payorid' + k + '').val(data[i].payoruid);
                  $('#patient_type_data' + k + '').val(data[i].patienttypeuid);
                  k++;

               }


            }
         });
      });


      $('#btn_update_edit').click(async function(e) {
         var formData = new FormData($('#edit_submit')[0]);
         let dupForm = formData;
         let detailuid = {};
         let payorid = {};
         let patient_type_data = {};
         let ct = [0, 0, 0];
         await dupForm.forEach(function(value, key) {
            switch (key) {
               case 'detailuid[detailuid][]':
                  detailuid[ct[0]] = value;
                  ct[0]++;
                  break;
               case 'payorid[payorid][]':
                  payorid[ct[1]] = value;
                  ct[1]++;
                  break;
               case 'patient_type_data[patient_type_data][]':
                  patient_type_data[ct[2]] = value;
                  ct[2]++;
                  break;
            }
         });
         let merge = [];
         var failed = false;
         await Object.keys(detailuid).forEach(function(item, index) {
            merge[index] = [];
            merge.forEach(element => {
               if ([payorid[index], patient_type_data[index]].every(e => element.includes(e))) {
                  alert("หมวดหมู่คิวที่ท่านเลือกนั้นมีการเลือกไว้แล้ว(ของหมวดหมู่นี้)");
                  failed = true;
                  return false;
               }
            });
            merge[index][0] = payorid[index];
            merge[index][1] = patient_type_data[index];
            //merge[index][2] = detailuid[index];
         });
         var uid_edit = $('#uid_edit').val();
         // alert(uid_edit);
         if (failed == false) {
            await $.ajax({
               url: ajaxURL + "/update_category/" + uid_edit,
               type: "post",
               data: formData, //this is formData
               processData: false,
               contentType: false,
               cache: false,
               async: false,
               success: function(data) {
                  $('#edit_modal').modal('hide');
                  $('#edit_submit')[0].reset();

                  $('#fields_edit').html('');
                  show_grouprocess_list();
               }
            });
         }
      });

      $('#groupprocess_list').on('click', '.item_delete', function() {
         var product_code = $(this).data('product-id');

         $('#modal_delete').modal('show');
         $('[name="product_code_delete"]').val(product_code);
      });

      $('#btn_delete').on('click', function() {
         var product_code = $('#product_code_delete').val();
         $.ajax({
            type: "POST",
            url: ajaxURL + "/delete_queue_category",
            dataType: "JSON",
            data: {
               product_code: product_code
            },
            success: function(response) {

               if (response.success) {
                  $('#modal_delete').modal('hide');
                  show_grouprocess_list();
                  show_payor();
                  show_patient_type();

               }
            }
         });
      });

      var i = 1;

      $('#add').click(function() {
         i++;
         $('#fields1').append('<div class="row" id="row' + i + '">' +
            '<div class="col-5"><div class="form-group">' +
            '<select class="form-control payorid" name="payorid[payorid][]" id="payorid_add' + i + '" style="font-family:cs_prajad_b;"></select></div></div>' +
            '<div class="col-5"><div class="form-group"><select class="form-control patient_type_data" name="patient_type_data[patient_type_data][]" id="patient_type_add' + i + '" style="font-family:cs_prajad_b;"></select></div></div>' +
            '<div class="col-2"><button type="button" name="remove" id="' + i + '" class="btn btn_pmk btn-sm btn_remove"><i class="fa fa-minus"></i></button></div></div></div>');
         show_payor_add(i);
         show_patient_type_add(i);
      });



      var i = 1;
      $('#add_edit').click(function() {
         i++;
         $('#fields_edit').append('<div class="row" id="rowedit' + i + '">' +
            '<div class="col-5"><div class="form-group">' +
            '<input type="hidden" name="detailuid[detailuid][]"><select class="form-control payorid" name="payorid[payorid][]" id="edit' + i + '" style="font-family:cs_prajad_b;"></select></div></div>' +
            '<div class="col-5"><div class="form-group"><select class="form-control patient_type_data" name="patient_type_data[patient_type_data][]" id="patient_type_edit' + i + '" style="font-family:cs_prajad_b;"></select></div></div>' +
            '<div class="col-2"><div class="form-group"><button type="button" name="remove" id="' + i + '" class="btn btn_pmk btn-sm btn_remove_edit"><i class="fa fa-minus"></i><input type="checkbox" id="chk' + i + '" style="position:absolute;z-index:-999;"></button></div></div></div></div>');
         show_payor_select(i);
         show_patient_type_select(i);
      });




      $(document).on('click', '.btn_remove_edit', function() {
         var button_id = $(this).attr("id");
         $('#rowedit' + button_id + '').remove();
      });

      $(document).on('click', '.btn_remove', function() {
         var button_id = $(this).attr("id");
         var uid = $(this).data('uid');

         $('#chk' + uid + '').prop('checked', true);

         // $(this).html('ลบ');

         // alert(uid);

         $('#row' + button_id + '').remove();
      });







   });

   function postAJAX(urlpath, data) {
      $.ajax({
         url: urlpath,
         method: 'POST',
         dataType: 'json',
         data: data,
         headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
            'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
            'Authorization': 'Basic YXJtOjEyMzQ=',
         },
         success: function(data) {
            console.log('success: ', data);
            return data;
         },
         error: function(err) {
            console.log(err);
         },
      });

   }
   $('#btn').click(function() {
      <?= Modules::run('Websocket/SocketConnection'); ?>
      var data = $('#txt_btn').val();
      alert(data);
      var postURL = baseurlMid + '/testpostemit';
      var postData = {
         'confirmed': '1',
         'finished': data,
      }
      postAJAX(postURL, postData);
      midSocket.on('testSocket', function(data) {
         console.log(data, 'TEST DATA RETURN')
      });
   });
</script>