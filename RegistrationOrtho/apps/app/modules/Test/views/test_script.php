<script>

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

   // $(document).ready(function(){

   //    <?=Modules::run('Websocket/SocketConnection');?>

   //    var postURL = baseurlMid + '/testpostemit';
   //    var postData = {
   //       'confirmed': '1',
   //       'finished': '1',
   //    } 



   //    postAJAX(postURL,postData);

   //    midSocket.on('testSocket', function( data ){
   //       console.log(data, 'TEST DATA RETURN')
   //    });




   //    //testSocket

   // });


   $('#btn').click(function(){

      var data=$('#inp').val();
     <?=Modules::run('Websocket/SocketConnection');?>

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