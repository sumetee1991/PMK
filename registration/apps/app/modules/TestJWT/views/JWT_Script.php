<script>
	function getToken(){
		var tokenURL = 'http://54.179.157.32/auth/api/login';
	}

	function checkLocal(){
		console.log(localStorage);
	}
	function checkSession(){
		console.log(sessionStorage);
	}

	function postAJAX(urlpath,data,callback){
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
            success: function(result){
                console.log('AJAX Result : ' , result);
                if (callback) {
				    callback(result);
				}
            },
            error: function(err){
                console.log(err);
            },
        });
	}
	$(document).ready(function(){

	});
</script>