<script>
   
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

 function logoutAPI(){
   console.log("Logout API");
   axiosToken
   // .post('http://service.healthyflow.xyz/hybrid-auth/api/logout','')
   .post('http://flow-hybrid-auth.pmk.local/api/logout','')
   .then(res => res.data)
.catch(err => { /* not hit since no 401 */ });
sessionStorage.clear();
// window.location.replace("http://healthyflow.xyz/");
}

function refreshAPI(){
   console.log("RefreshToken API");
   axiosToken
   // .post('http://service.healthyflow.xyz/hybrid-auth/api/refresh','')
   .post('http://flow-hybrid-auth.pmk.local/api/refresh','')
   .then(res => {
            //console.log(res.data)
            var refreshToken = res.data['accessToken'];
            sessionStorage.setItem("hlab_access_token", refreshToken);
         })
   .catch(err => {console.log(err)})
}

function DecodeJWT(Token){
   let result = KJUR.jws.JWS.parse(Token);
   return result['payloadObj'];
}

function getStorageToken(StorageName){
 var Token = sessionStorage[StorageName];
 return Token;
}

function checkExpired(TokenExpired){
 var current = new Date().getTime();
 console.log("Expired : "+TokenExpired);
 if( TokenExpired > current ){
   console.log("Token Not Expired Yet");
   var ExpiredTime = (TokenExpired - current) - 60000;
   console.log( "Left : " + ExpiredTime + " milliseconds");
   window.setTimeout(function(){
     console.log("Token Expired Already - Refresh Token");
     refreshAPI();
  }, ExpiredTime);
   return false;
}else{
   console.log("Token Expired");
   var PassedExpiredTime = current - TokenExpired;
   console.log( "Passed : " + PassedExpiredTime + " milliseconds");
   return true;
}
}

var ajaxURL = '';

$(document).ready(function(){
   var segment = "<?=$this->uri->segment($this->uri->total_segments());?>";
   $('.nav-link').each(function( index ) {
      $(this).attr('href',(segment == '' ? './Test_pm' : '.')+$(this).attr('href'));
   });
   ajaxURL = "<?=APPURLSETUP.'/Test_pm';?>"; //Overwrite ajaxURL [ (segment == '' ? './test_pm' : '.') ]
//Init Token
if( getStorageToken('hlab_access_token') ){
 var TokenKey = getStorageToken('hlab_access_token');
 var TokenDecode = KJUR.jws.JWS.parse(TokenKey);
 var TokenObject = DecodeJWT(TokenKey);

 if( !checkExpired(TokenObject['exp']) ){
  $('#span_Login').text(TokenObject['sub']);
  $('#span_serviceUnitAbbreviation').text(TokenObject['serviceUnitName']);
}else{
  $('#span_Login').text("No User : Session Expired");
          //window.location.replace("http://healthyflow.xyz/");
          <?php if( defined('TESTMODE') && TESTMODE == 'Y'): ?>
            $('#span_Login').text("Test : " + TokenObject['sub']);
            $('#span_serviceUnitAbbreviation').text("Test : " + TokenObject['serviceUnitName']);
         <?php endif; ?>
      }

      window.addEventListener('storage', function(e) {  

        if(e.storageArea===sessionStorage) {
         if( !getStorageToken('hlab_access_token') ){
              // window.location.replace("http://healthyflow.xyz/");             
           }
        }
     });
   }else{
    console.log("No Session!");
    $('#span_Login').text("No User : No Session");  
    var currentURL = window.location.href;
    var currentURI = '<?=$_SERVER['REQUEST_URI'];?>';
    var explodeURI = currentURI.split('/');
    explodeURI[0] = 'http://';

    var domainURL = currentURL;
    explodeURI.forEach(function(value, index){
     domainURL = domainURL.replace('/'+value,'');
  });
    domainURL = domainURL;

    console.log("Redirect to " + domainURL);
        // window.location.replace("http://healthyflow.xyz/");

     }
    //Init
    $(document).on("click", "#acc_logout", function(e) {
      logoutAPI();
   });

    show_clinic();
    show_building();


    $("#show_data").sortable({
     update: function (event, ui) {
        $('#show_data .card .card-body input').each(function (i) {
         var numbering = i + 1;
         var sort=$(this).val(numbering);
         $(this).val(numbering);
         var id=$(this).data('sort');

         update_sort(numbering,id);
      })
     }
  });
 function update_sort($sort,$id){
      $.ajax({
         url:ajaxURL+"/update_clinic_sort/"+$id+'/'+$sort,
         type:"post",
         data: {
            sort: $sort
         },
         dataType: "json",
         cache : false,
         processData: false,
         success: function(data){
         }
      });
   }


    function show_clinic(){
       $.ajax({
        type  : 'ajax',
        url   : ajaxURL+"/clinic_data",
        async : false,
        dataType : 'json',
        success : function(data){
         var html = '';
         var i;
         var j=1;
         for(i=0; i<data.length; i++){
            // console.log(data[i], "DATA CLINIC")
            html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card  shadow h-100  bg-light"><div class="card-body"><input type="hidden" value="'+j+'" data-clinic_code="'+data[i].clinic_code+'" data-sort="'+data[i].uid+'">'+
            '<div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;">'+data[i].code+'</div>'+
            '<div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;">'+data[i].detail+'</div>'+
            '<div>'+
            '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_edit btn_edit" data-uid="'+data[i].uid+'" data-code="'+data[i].code+'" data-flooruid="'+data[i].flooruid+'"  data-detail="'+data[i].detail+'" data-building="'+data[i].buildinguid+'" data-amount="'+data[i].amount+'" data-active="'+data[i].active+'" data-visit_active="'+data[i].visit_active+'" data-active_date="'+data[i].active_date+'" data-clinic_code="'+data[i].clinic_code+'"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>'+' '+
            '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_delete" data-product-id="'+data[i].uid+'" style="font-family:cs_prajad_b;font-size:16px;"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>'+
            '</div>'+
            '</div></div></div>';
            j++;
         }
         $('#show_data').html(html);

         $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: Mitr;font-size: 18px;">ตกลง</button>');
         $('#loading').css('display','none');
      }

   });
    }

    function show_building(){
       $.ajax({
        type  : 'ajax',
        url   : ajaxURL+"/building_data",
        async : false,
        dataType : 'json',
        success : function(data){
         var html = '<option value="">กรุณาเลือก ตึก/อาคาร</option>';
         var i;
         for(i=0; i<data.length; i++){
            html += '<option value="'+data[i].uid+'">'+data[i].building_name+'</option>';
         }
         $('#building').html(html);
      }

   });
    }

    $('#counter_name').keyup(function(){
      if($('#counter_name').val()==""){
         $('#validate-counter').html('กรุณากรอก counter');
      }else{
        $('#validate-counter').html('');
     }
  });
    $('#groupprocess').change(function(){
      if($('#groupprocess').val()==""){
         $('#validate-process').html('กรุณากรอกเลือกกระบวนการ');
      }else{
       $('#validate-process').html('');
    }

 });

    $('#btn_upload').click(function(e){
      // var formData = new FormData($('#submit')[0]);
      if($('#counter_name').val()==""){
         $('#validate-counter').html('กรุณากรอก counter');
      }else if($('#groupprocess').val()==""){
         $('#validate-process').html('กรุณากรอกเลือกกระบวนการ');
      }else{

       // $('#submit').submit(function(e){
         // e.preventDefault(); 
         $.ajax({
            url:ajaxURL+"/add_clinic",
            type:"post",
                   data:new FormData($('#submit')[0]), //this is formData
                   processData:false,
                   contentType:false,
                   cache:false,
                   async:false,
                   success: function(data){
                     $('#submit')[0].reset();
                      // alert("Upload Image Successful.");
                      $('#add_modal').modal('hide');
                      show_clinic();
                   }
                });
      }
   });

    $('#btn-add').click(function(){
       $('#header_txt').html('ศูนย์รักษา');
       $('#btn_update').css('display','none');
       $('#btn_upload').css('display','block');
       $('#add_modal').modal('show');
       $('#submit')[0].reset();
    });


    $('#show_data').on('click','.item_edit',function(){
      
      $('#header_txt').html('ศูนย์รักษา');

      var code = $(this).data('code');
      var detail=$(this).data('detail');
      var building=$(this).data('building');
      var uid=$(this).data('uid');
      var amount=$(this).data('amount');
      var clinic_code=$(this).data('clinic_code');
      var active=$(this).data('active');
      var visit_active=$(this).data('visit_active');
      var active_date=$(this).data('active_date');
      var floor=$(this).data('flooruid');
      // alert(floor);
      $.ajax({
         url: ajaxURL+"/get_floor",
         type: "POST",
         data: {'building': building},
         dataType: 'json',
         success: function (data) {
            // console.log(data, "FLOOR")
            // $('#floor').prop('disabled', true);
            $('#floor').html(data);
            $('#floor').val(floor);
           // $('#loading').css('display', 'none');
        }
       //  error: function () {
       //   $('#floor').prop('disabled', false);
       //    // alert('โหลดไม่สำเร็จ');
       // }
    });
      $('input[name="active_date[]"]').prop('checked',false);
      if(active_date != null){
         if(active_date.length){
            active_date = (active_date.slice(1, active_date.length-1)).split(',');

            active_date.forEach(function (item) {
              console.log(item);
              $('input[name="active_date[]"][value="'+item+'"]').prop('checked',true);
            });
         }else{
            active_date = null;
         }
       
      }
      
      

      $('#btn_upload').css('display','none');
      $('#btn_update').css('display','block');
      $('#add_modal').modal('show');
      $('#code').val(code);
      $('#clinic_code').val(clinic_code);
      $('#detail').val(detail);
      $('#building').val(building);
      $('#uid').val(uid);
      $('#amount').val(amount);
      $('#clinic_code').val(clinic_code);
      $(`.active[value="${active}"]`).attr("checked",true);
      $(`.visit_active[value="${visit_active}"]`).attr("checked",true);
     
      // $('input[name="active_date[]"]').val(active_date);
      //query สำหรับเช็ควันทำการ
      //SELECT * FROM public.tb_opdclinic WHERE to_char(CURRENT_TIMESTAMP, 'Day')=ANY(tb_opdclinic.active_date);

   });

    $('#btn_update').click(function(e){


     if($('#counter_name').val()==""){
      $('#validate-counter').html('กรุณากรอก counter');
   }else if($('#groupprocess').val()==""){
      $('#validate-process').html('กรุณากรอก counter');
   }else{


      var formData = new FormData($('#submit')[0]);
      console.log(formData, "DATA TO UPDATE")
      var uid = $('#uid').val();
      $.ajax({
         url:ajaxURL+"/update_clinic/"+uid,
         type:"post",
         data:formData,
         processData:false,
         contentType:false,
         cache:false,
         async:false,
         success: function(data){
            $('#add_modal').modal('hide');
            $('#submit')[0].reset();
            show_clinic();
         }
      });
   }
});

    $('#show_data').on('click','.item_delete',function(){
      var product_code = $(this).data('product-id');
      $('#modal_delete').modal('show');
      $('[name="product_code_delete"]').val(product_code);
   });


    $('#btn_delete').on('click',function(){
      var product_code = $('#product_code_delete').val();
      $.ajax({
        type : "POST",
        url  : ajaxURL+"/delete_clinic",
        dataType : "JSON",
        data : {product_code:product_code},
        success: function(response){
           if (response.success) {
             $('#modal_delete').modal('hide');
             show_clinic();
          }
       }
    });
   });

    $('#building').change(function(){
     // $('#building').on('change', function () {
     // $('#loading').css('display', 'block');
     var building = $(this).val();


     if (building == '') {
      $('#floor').prop('disabled', true);
   }
   else {
      $('#floor').prop('disabled', false);
      $.ajax({
         url: ajaxURL+"/get_floor",
         type: "POST",
         data: {'building': building},
         dataType: 'json',
         success: function (data) {
            console.log(data, "FLOOR")
            // $('#floor').prop('disabled', true);
            $('#floor').html(data);

           // $('#loading').css('display', 'none');
        }
       //  error: function () {
       //   $('#floor').prop('disabled', false);
       //    // alert('โหลดไม่สำเร็จ');
       // }
    });
   }
});
 });
</script>