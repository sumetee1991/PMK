<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    const axiosToken = axios.create({
        withCredentials: true,
    });

    function logoutAPI(){
        axiosToken
        //   .post('https://service.healthyflow.xyz/hybrid-auth/api/logout','')
          .post('http://flow-hybrid-auth.pmk.local/api/logout','')
          .then(res => res.data)
          .catch(err => { /* not hit since no 401 */ })
    }

    function refreshToken(){
        axiosToken
        //   .post('https://service.healthyflow.xyz/hybrid-auth/api/refresh','')
          .post('http://flow-hybrid-auth.pmk.local/api/refresh','')
          .then(res => res.data)
          .catch(err => { /* not hit since no 401 */ })
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
        /*
        axiosToken.defaults.headers.common['Authorization'] = 'Basic YXJtOjEyMzQ=';
        axiosToken.post('http://192.168.0.134:9000/testpostemit', {
          //mode: 'no-cors',
          dataType: 'json',
          data: {'name':'peecz'},
          headers: {
            // 'X-Requested-With': 'XMLHttpRequest',
            // 'Access-Control-Allow-Origin': '*',
            // 'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
            // 'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
            //'Authorization':'Basic YXJtOjEyMzQ=',
            'content-type': 'application/json' 
          },
          withCredentials: true,
          credentials: 'same-origin',

        }).then(response => {

        }).catch((error) => {
            console.log(error);
        });
        */
    });
        
</script>