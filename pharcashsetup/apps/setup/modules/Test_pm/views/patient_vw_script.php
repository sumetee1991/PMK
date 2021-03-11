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
  // window.location.replace("http://healthyflow.xyz/");
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

    patient_type();
    show_groupprocess();


    $("#show_data").sortable({
       update: function (event, ui) {
          $('#show_data .card .card-body input').each(function (i) {
            var numbering = i + 1;
            var sort=$(this).val(numbering);
            var id=$(this).data('sort');
            update_sort(numbering,id);
         })
       }
    });

    function update_sort($sort,$id){
      $.ajax({
         url:ajaxURL+"/update_patient_sort/"+$id+'/'+$sort,
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


   function patient_type(){
     $.ajax({
       type  : 'ajax',
       url   : ajaxURL+"/patient_type_data",
       async : false,
       dataType : 'json',
       success : function(data){
         var html = '';
         var i;
         var j=1;
         for(i=0; i<data.length; i++){
            html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card shadow h-100 bg-light"><div class="card-body"><input type="hidden" value="'+j+'" data-sort="'+data[i].uid+'">'+
            '<div style="font-size:18px;font-family:cs_prajad_b;font-weight:400;font-size:20px;">'+data[i].code+'</div>'+
            '<div style="font-size:18px;font-family:cs_prajad_b;font-weight:300;font-size:20px;">'+data[i].name+'</div>'+
            '<div>'+
            '<a href="javascript:void(0);" class="btn btn_pmk btn_edit btn-sm item_edit" data-uid="'+data[i].uid+'" data-code="'+data[i].code+'" data-name="'+data[i].name+'" data-short-name="'+data[i].shortname+'" data-groupprocess="'+data[i].groupprocessuid+'"   style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไข</a>'+' '+
            '<a href="javascript:void(0);" class="btn btn_pmk btn_edit btn-sm item_delete" data-product-id="'+data[i].uid+'" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-times" aria-hidden="true"></i> ลบ</a>'+
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



  function show_groupprocess(){
     $.ajax({
       type  : 'ajax',
       url   : ajaxURL+"/get_groupprocess",
       async : false,
       dataType : 'json',
       success : function(data){
         var html = '';
         var i;
         for(i=0; i<data.length; i++){
            html += 
            '<option value="'+data[i].uid+'">'+data[i].name+'</option>';
         }
         $('#groupprocess').html(html);


      }

   });
  }

  $('#btn_upload').click(function(e){

     if($('#code').val()==""){
      $('#validate-code').html('กรุณาระบุรหัส');

   }else if($('#name').val()==""){
      // var formData = new FormData($('#submit')[0]);
      $('#validate-name').html('กรุณาระบุชื่อ');
   }else{
       // $('#submit').submit(function(e){
         // e.preventDefault(); 
         $.ajax({
            url:ajaxURL+"/add_patient_type",
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
                      patient_type();
                      show_groupprocess();
                   }
                });
      }
   });


  $('#code').keyup(function(){
     $('#validate-code').html('');
  });
  $('#name').keyup(function(){
   $('#validate-name').html('');
});



  $('#btn-add').click(function(){
   $('#header_txt').html('เพิ่มประเภทคนไข้');
   $('#btn_upload').css('display','block');
   $('#btn_update').css('display','none');
   $('#add_modal').modal('show');
   $('#submit')[0].reset();
});


  $('#show_data').on('click','.item_edit',function(){
   var code = $(this).data('code');
   var name = $(this).data('name');
   var shortname = $(this).data('short-name');
   var uid=$(this).data('uid');
   $('#uid').val(uid);
      // alert(uid)

      $('#btn_upload').css('display','none');
      $('#btn_update').css('display','block');
      $('#header_txt').html('แก้ไขประเภทคนไข้');
      $('#add_modal').modal('show');
      $('#code').val(code);
      $('#name').val(name);
      $('#shortname').val(shortname);
      $('#groupprocess').val(groupprocess);

   });



  $('#btn_update').click(function(e){


   if($('#code').val()==""){
      $('#validate-code').html('กรุณาระบุรหัส');

   }else{




      var formData = new FormData($('#submit')[0]);
      var uid = $('#uid').val();
      // alert(uid);
      $.ajax({
         url:ajaxURL+"/update_pateint_type/"+uid,
         type:"post",
                   data:formData, //this is formData
                   processData:false,
                   contentType:false,
                   cache:false,
                   async:false,
                   success: function(data){

                     // alert("Upload Image Successful.");
                     $('#add_modal').modal('hide');
                     $('#submit')[0].reset();
                     patient_type();
                     // show();
                  }
               });
   }
});
// update product


$('#show_data').on('click','.item_delete',function(){
   var product_code = $(this).data('product-id');

   $('#modal_delete').modal('show');
   $('[name="product_code_delete"]').val(product_code);
});

        //delete record to database
        $('#btn_delete').on('click',function(){
         var product_code = $('#product_code_delete').val();
         $.ajax({
          type : "POST",
          url  : ajaxURL+"/delete_patient_type",
          dataType : "JSON",
          data : {product_code:product_code},
          success: function(response){

             if (response.success) {
              // alert('ok');
              $('#modal_delete').modal('hide');
              patient_type();
           }
        }
     });
      });

     });

function postAJAX(urlpath,data){
   $.ajax({
     url: urlpath,
     method: 'POST',
     dataType: 'json',
     data: data,
     headers: {
       'Access-Control-Allow-Origin': '*',
       'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
       'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
       'Authorization':'Basic YXJtOjEyMzQ=',
    }, 
    success: function(data){
       console.log('success: ' , data);
       return data;
    },
    error: function(err){
       console.log(err);
    },
 });

}
$('#btn').click(function(){
   <?=Modules::run('Websocket/SocketConnection');?>
   var data=$('#txt_btn').val();
   alert(data);
   var postURL = baseurlMid + '/testpostemit';
   var postData = {
      'confirmed': '1',
      'finished': data,
   } 
   postAJAX(postURL,postData);
   midSocket.on('testSocket', function( data ){
      console.log(data, 'TEST DATA RETURN')
   });
});
</script>