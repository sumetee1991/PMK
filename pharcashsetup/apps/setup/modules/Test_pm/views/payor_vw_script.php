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
      console.log(res.data)
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
      $(this).attr('href',(segment == '' ? './test_pm' : '.')+$(this).attr('href'));
   });
   ajaxURL = "<?=APPURLSETUP.'/Test_pm';?>"; //Overwrite ajaxURL [ (segment == '' ? './test_pm' : '.') ]te ajaxURL [ (segment == '' ? './test_pm' : '.') ]



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

    payor();


    $("#show_data .payor_list").sortable({
       update: function (event, ui) {
          $('#show_data .payor_list .card .card-body input').each(function (i) {
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
         url:ajaxURL+"/update_payor_sort/"+$id+'/'+$sort,
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


   function payor(){
     $.ajax({
       type  : 'ajax',
       url   : ajaxURL+"/payor_data",
       async : false,
       dataType : 'json',
       success : function(data){
         var html = '<div class="payor_list row">';
         var i;
         var j=1;
         for(i=0; i<data.length; i++){
            html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card shadow h-100 bg-light"><div class="card-body"><input type="hidden" value="'+j+'" data-sort="'+data[i].uid+'">'+
            '<div style="font-size:18px;font-family:cs_prajad_b;font-weight:400;font-size:20px;">'+data[i].code+'</div>'+
            '<div style="font-size:18px;font-family:cs_prajad_b;font-weight:300;font-size:20px;">'+data[i].name+'</div>'+
            '<div>'+
            '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_edit" data-uid="'+data[i].uid+'" data-code="'+data[i].code+'" data-name="'+data[i].name+'" data-short-name="'+data[i].shortname+'" data-hiscode="'+data[i].hiscode+'" data-groupprocess="'+data[i].groupprocessuid+'" data-openactive="'+data[i].openactive+'" data-active="'+data[i].active+'" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-edit" aria-hidden="true"></i> ???????????????</a>'+' '+
            '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_delete" data-product-id="'+data[i].uid+'" style="font-family:cs_prajad_b;font-size:18px;font-weight:300;"><i class="fa fa-times" aria-hidden="true"></i> ??????</a>'+
            '</div>'+
            '</div></div></div>';
            j++;
         }
         html+='</div>';
         $('#show_data').html(html);

         $('#btn-section').html('<button class="btn btn-success" id="btn_upload" style="font-family: Mitr;font-size: 18px;">????????????</button>');
         $('#loading').css('display','none');
      }

   });
  }

  $('#code').keyup(function(){
   if($('#code').val()==""){
    $('#validate-code').html('???????????????????????????????????????');
 }else{
    $('#validate-code').html('');
 }

});
  $('#name').keyup(function(){
   if($('#name').val()==""){
      $('#validate-name').html('???????????????????????????????????????');
   }else{
      $('#validate-name').html('');
   }

});

  $('#btn_upload').click(function(e){

   if($('#code').val()==""){
      $('#validate-code').html('???????????????????????????????????????');

   }else if($('#name').val()==""){
      $('#validate-name').html('???????????????????????????????????????');
   }else{

      // var formData = new FormData($('#submit')[0]);
       // $('#submit').submit(function(e){
         // e.preventDefault(); 
         $.ajax({
            url:ajaxURL+"/add_payor",
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
                      payor();
                   }
                })
      }
   });



  $('#btn-add').click(function(){
   $('#btn_update').css('display','none');
   $('#btn_upload').css('display','block');
   $('#add_modal').modal('show');

   $('#submit')[0].reset();
});


  $('#show_data').on('click','.item_edit',function(){
   var code = $(this).data('code');
   var hiscode = $(this).data('hiscode');
   var name = $(this).data('name');
   var shortname=$(this).data('short-name');
   var uid=$(this).data('uid');
   var openactive= $(this).data('openactive');
   var active= $(this).data('active');
   $(`[name="active"][value="${active}"]`).attr("checked",true);
   // alert(active);
   if(openactive=='Y'){
      $('#open_y').prop( "checked", true );
   }else if(openactive=='N'){
     $('#open_n').prop( "checked", true );
  }else{

  }


  if(active=='Y'){
   $('#active_y').prop( "checked", true );
}else if(active=='N'){
  $('#active_n').prop( "checked", true );
}else{

}

   // alert(uid);
   $('#uid').val(uid);
   $('#btn_update').css('display','block');
   $('#btn_upload').css('display','none');
   $('#shortname').val(shortname);
   $('#add_modal').modal('show');
   $('#code').val(code);
   $('#name').val(name);
    $('#hiscode').val(hiscode);
   // $('#groupprocess').val(groupprocess);
   // $('#uid').val(uid);
});



  $('#btn_update').click(function(e){
   var formData = new FormData($('#submit')[0]);
   var uid = $('#uid').val();
      // alert(uid);
      $.ajax({
         url:ajaxURL+"/update_payor/"+uid,
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
                     payor();

                  }
               });
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
          url  : ajaxURL+"/delete_payor",
          dataType : "JSON",
          data : {product_code:product_code},
          success: function(response){

             if (response.success) {
              // alert('ok');
              $('#modal_delete').modal('hide');
              payor();
           }
        }
     });
      });

     });
  </script>