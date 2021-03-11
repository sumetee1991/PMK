<html>
<head>
</head>
<body>
<h1> Queue PMK Application </h1>
<form id="form1">
<input type="text" name="user" id="user" value=""> 
<button type="button" class="save">Save</button>
</form>

<form id="testpost">
<input type="text" name="QueueID" id="QueueID" value="ABC12345">
<button type="button" class="send" value="call">Call</button>
<button type="button" class="send" value="hold">Hold</button>
<button type="button" class="send" value="note">Note</button>
<button type="button" class="send" value="complete">Complete</button>
<button type="button" class="send" value="cancel">Cancel</button>
</form>

<script type='text/javascript' src='<?=base_url('static/js/jquery-3.4.1.min.js');?>'></script>
<script src="<?php echo base_url('node_modules/socket.io-client/dist/socket.io.js');?>"></script>
<script>
   

    $(document).ready(function(){
        var socket = io.connect( 'http://192.168.0.134:7001' );
        var appSocket = io.connect('http://192.168.0.134:9000');
        $('#form1').on('click', '.save', function(){
            var user = $('#user').val();
            // console.log(user);

            if(user){
                var data = user;
                // $.get('http://192.168.0.134:9000/testemit', data, function(data){
                //     console.log('success: '+data);
                // })
                $.ajax({
                    url: 'http://192.168.0.134:9000/testemit',
                    method: 'get',
                    dataType: 'json',
                    data: data,
                    success: function(data){
                        console.log('success: '+data);
                        // appSocket.emit( 'serverSocket', data );
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            }else{
                console.log('success: false');
            }
        });

        // appSocket.on('testSocket', (data) => {
        //     console.log(data);
        //     // for(var p=0;p<data.length;p++){
        //     //     console.log(data)
        //     // }
        // });


        $('#testpost').on('click', '.send', function(){
            var queueid = $('#QueueID').val();
            var action = $(this).val();

            console.log(action);

            if(queueid && action){
                var data = {
					queueid: queueid, 
					action: action, 
				};

                $.ajax({
                    url: 'http://192.168.0.134:9000/testpostemit',
                    method: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(data){
                    	console.log("Response",data);
                        // appSocket.emit( 'serverSocket', data );
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            }else{
                console.log('success: false');
            }
        });

        
    });
</script>
</body>
</html>