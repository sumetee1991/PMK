<script>
   $.ajaxSetup({
      cache: false,
      headers: {
         'Access-Control-Allow-Origin': '*',
         'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
         'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
         'Authorization': 'Basic YXJtOjEyMzQ=',
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
         $(this).attr('href', (segment == '' ? './test_pm' : '.') + $(this).attr('href'));
      });
      ajaxURL = "<?= APPURLSETUP . '/Test_pm'; ?>"; //Overwrite ajaxURL [ (segment == '' ? './test_pm' : '.') ]
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
            //  window.location.replace("http://healthyflow.xyz/");
            window.location.replace("http://flow-hybrid-auth.pmk.local/");
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

      show_building();


      $("#show_data").sortable({
         update: function(event, ui) {
            $('#show_data .card .card-body input').each(function(i) {
               var numbering = i + 1;
               var sort = $(this).val(numbering);
               $(this).val(numbering);
               var id = $(this).data('sort');

               update_sort(numbering, id);
            })
         }
      });


      function update_sort($sort, $id) {
         $.ajax({
            url: ajaxURL + "/update_building_sort/" + $id + '/' + $sort,
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

      function show_building() {
         $.ajax({
            cache: false,
            type: 'ajax',
            url: ajaxURL + "/building_data"+`?_${Date.now()}`,
            async: false,
            dataType: 'json',
            success: function(data) {
               var html = '';
               var i;
               var j = 1;
               for (i = 0; i < data.length; i++) {
                  html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card  shadow h-100  bg-light"><div class="card-body"><input type="hidden" value="' + j + '" data-sort="' + data[i].uid + '">' +
                     // '<div style="font-size:20px;font-family:Mitr;font-weight:300;">'+data[i].code+'</div>'+
                     '<div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;">' + data[i].building_name + '</div>' +
                     '<div>' +
                     '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_edit btn_edit" data-uid="' + data[i].uid + '" data-product-name="' + data[i].building_name + '"  data-active="' + data[i].active + '"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>' + ' ' +
                     '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_delete" data-product-id="' + data[i].uid + '" style="font-family:cs_prajad_b;font-size:16px;"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>' +
                     '</div>' +
                     '</div></div></div>';
                  j++;
               }
               $('#show_data').html(html);

               $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: cs_prajad_b;font-size: 18px;">ตกลง</button>');
               $('#loading').css('display', 'none');
            }

         });
      }


      $('#counter_name').keyup(function() {
         if ($('#counter_name').val() == "") {
            $('#validate-counter').html('กรุณากรอก counter');
         } else {
            $('#validate-counter').html('');
         }
      });
      $('#groupprocess').change(function() {
         if ($('#groupprocess').val() == "") {
            $('#validate-process').html('กรุณากรอกเลือกกระบวนการ');
         } else {
            $('#validate-process').html('');
         }

      });

      $('#btn_upload').click(function(e) {
         // var formData = new FormData($('#submit')[0]);
         if ($('#counter_name').val() == "") {
            $('#validate-counter').html('กรุณากรอก counter');
         } else if ($('#groupprocess').val() == "") {
            $('#validate-process').html('กรุณากรอกเลือกกระบวนการ');
         } else {

            // $('#submit').submit(function(e){
            // e.preventDefault(); 
            $.ajax({
               url: ajaxURL + "/add_building",
               type: "post",
               data: new FormData($('#submit')[0]), //this is formData
               processData: false,
               contentType: false,
               cache: false,
               async: false,
               success: function(data) {
                  $('#submit')[0].reset();
                  // alert("Upload Image Successful.");
                  $('#add_modal').modal('hide');
                  show_building();
               }
            });

            $('#building_set').html('');
            $('#floor_list').html('');
         }
      });

      $('#btn-add').click(function() {
         $('#header_txt').html('ตึก/อาคาร');
         $('#btn_update').css('display', 'none');
         $('#btn_upload').css('display', 'block');
         $('#add_modal').modal('show');
         $('#building_set').html('');
         $('#floor_list').html('');
         $('#submit')[0].reset();
      });


      $('#show_data').on('click', '.item_edit', function() {
         $('#building_set').html('');
         $('#header_txt').html('ตึก/อาคาร');
         var uid = $(this).data('uid');
         $('#uid').val(uid);
         $.ajax({
            url: ajaxURL + "/get_floor_building",
            type: "POST",
            data: {
               'building': uid
            },
            dataType: 'json',
            success: function(data) {
               $('#floor_list').html(data);
            }
            //  error: function () {
            //   $('#floor').prop('disabled', false);
            //    // alert('โหลดไม่สำเร็จ');
            // }
         });

         var title = $(this).data('product-name');
         $('#building_name').val(title);
         var groupprocess = $(this).data('groupprocess');
         $('#groupprocess').val(groupprocess);
         var active = $(this).data('active');

         $(`[name="active"]`).attr("checked", false);
         $(`[name="active"][value="${active}"]`).trigger('click');
         $(`[name="active"][value="${active}"]`).attr("checked", true);
         // $(`[name="active"]`).attr("checked", false);
         // $(`[name="active"][value="${active}"]`).attr("checked", true);
         $('#btn_upload').css('display', 'none');
         $('#btn_update').css('display', 'block');

         $('#add_modal').modal('show');
      });

      $('#btn_update').click(function(e) {
         if ($('#counter_name').val() == "") {
            $('#validate-counter').html('กรุณากรอก counter');
         } else if ($('#groupprocess').val() == "") {
            $('#validate-process').html('กรุณากรอก counter');
         } else {


            var formData = new FormData($('#submit')[0]);
            var uid = $('#uid').val();
            $.ajax({
               url: ajaxURL + "/update_building/" + uid,
               type: "post",
               data: formData,
               processData: false,
               contentType: false,
               cache: false,
               async: false,
               success: function(data) {
                  $('#add_modal').modal('hide');
                  $('#submit')[0].reset();
                  show_building();
               }
            });
         }
      });

      $('#show_data').on('click', '.item_delete', function() {
         var product_code = $(this).data('product-id');
         $('#modal_delete').modal('show');
         $('[name="product_code_delete"]').val(product_code);
      });


      $('#btn_delete').on('click', function() {
         var product_code = $('#product_code_delete').val();
         $.ajax({
            type: "POST",
            url: ajaxURL + "/delete_building",
            dataType: "JSON",
            data: {
               product_code: product_code
            },
            success: function(response) {
               if (response.success) {
                  $('#modal_delete').modal('hide');
                  show_building();
               }
            }
         });
      });

      var i = 1;
      $('#add_building').click(function() {

         $('#building_set').append('<div class="row" id="row' + i + '">' +
            '<div class="col-4"><div class="form-group"><input type="text" class="form-control patient_type_data" name="floor['+(i-1)+'][floor_number]" id="number_floor' + i + '" style="font-family:cs_prajad_b;" value="" placeholder="เลขชั้น"></div></div>' +
            '<div class="col-6"><div class="form-group"><input type="text" class="form-control patient_type_data" name="floor['+(i-1)+'][floor_name]" id="floor' + i + '" style="font-family:cs_prajad_b;" value="" placeholder="ชื่อชั้น"></div></div>' +
            '<div class="col-2"><button type="button" name="remove" id="' + i + '" class="btn btn_pmk btn-sm btn_remove"><i class="fa fa-minus"></i></button></div></div></div>');
         i++;
      });

      $(document).on('click', '.btn_remove', function() {
         var button_id = $(this).attr("id");
         $('#row' + button_id + '').remove();

      });


      $(document).on('click', '.btn_remove_floor', function() {
         var button_id = $(this).attr("id");
         $('#row_floor' + button_id + '').remove();

         var uid = $(this).data('uid');

         $('#chk' + uid + '').prop('checked', true);

      });


   });
</script>