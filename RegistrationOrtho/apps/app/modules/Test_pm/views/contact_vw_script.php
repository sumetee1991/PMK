<script>
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
      $(this).attr('href',(segment == '' ? './test_pm' : '.')+$(this).attr('href'));
   });
   ajaxURL = (segment == '' ? './test_pm' : '.');
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
   //  window.location.replace("http://healthyflow.xyz/");
    window.location.replace("http://flow-hybrid-auth.pmk.local/");
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

   function show_building(){
    $.ajax({
     type  : 'ajax',
     url   : ajaxURL+"/contactno_data",
     async : false,
     dataType : 'json',
     success : function(data){
      var html = '';
      var i;
      var j=1;
      for(i=0; i<data.length; i++){
         html += '<div class="col-lg-4 col-sm-6 col-12 mb-2"><div class="card  shadow h-100  bg-light"><div class="card-body"><input type="hidden" value="'+j+'" data-sort="'+data[i].uid+'">'+
            // '<div style="font-size:20px;font-family:Mitr;font-weight:300;">'+data[i].code+'</div>'+
            '<div style="font-size:20px;font-family:cs_prajad_b;font-weight:300;">'+data[i].name+'</div>'+
            '<div>'+
            '<a href="javascript:void(0);" class="btn btn_pmk btn-sm item_edit btn_edit" data-uid="'+data[i].uid+'" data-product-name="'+data[i].name+'" data-allcounter="'+data[i].allcounter+'"><i class="fa fa-edit" aria-hidden="true"></i> ???????????????</a>'+' '+
            '</div>'+
            '</div></div></div>';
            j++;
         }
         $('#show_data').html(html);

         $('#loading').css('display','none');
      }

   });
 }

$('#show_data').on('click','.item_edit',function(){
    $('#header_txt').html('???????????????????????????????????????????????? ?????????????????????');
    var uid=$(this).data('uid');
    $('#uid').val(uid);
    
    var title = $(this).data('product-name');
    $('#name').val(title);
    var allcounter=$(this).data('allcounter');
    $('#allcounter').val(allcounter);

    // $('#btn_update').css('display','block');
    $('#add_modal').modal('show');
});

$('#btn_update').click(function(e){
    if($('#allcounter').val()==""){
        $('#validate-allcounter').html('?????????????????????????????????????????????????????????????????????????????????????????????????????????');
    }else{
        var formData = new FormData($('#submit')[0]);
        var uid = $('#uid').val();
        $.ajax({
            url:ajaxURL+"/update_allcounter/"+uid,
            type:"post",
            data:formData,
            processData:false,
            contentType:false,
            cache:false,
            async:false,
            success: function(data){
                $('#add_modal').modal('hide');
                $('#submit')[0].reset();
                show_building();
            }
        });
    }
});


});
</script>