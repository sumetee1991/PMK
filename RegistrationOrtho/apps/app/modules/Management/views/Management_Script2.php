<script type="text/javascript">
	//var JWTKey = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmbG93Iiwic3ViIjoiYmVhbS5tZWUiLCJhdWQiOlsiRDA2OTg3MjktQTNCNi1FOTExLUFBNDMtMDI1NDk4QTZENUQ2IiwiM0IyNjgyMzEtQTNCNi1FOTExLUFBNDMtMDI1NDk4QTZENUQ2IiwiOTY3NDc4MzktQTNCNi1FOTExLUFBNDMtMDI1NDk4QTZENUQ2Il0sImV4cCI6MTU3MTcxNDg5ODkzMCwiaWF0IjoxNTcxNzEzMDk4OTMwLCJzZXJ2aWNlVW5pdElkIjoiNWRhZTZkMTVjNzI1MzRlZTY1YTIzYjNmIiwic2VydmljZVVuaXROYW1lIjoi4LmA4Lin4LiK4Lij4Liw4LmA4Lia4Li14Lii4LiZIOC4leC4tuC4geC5gOC4ieC4peC4tOC4oeC4nuC4o-C4sOC5gOC4geC4teC4ouC4o-C4leC4tCDguIrguLHguYnguJkgMSIsInNlcnZpY2VVbml0QWJicmV2aWF0aW9uIjoiUkcxIiwicm9sZUlkIjoiMUVBMDBFRDUtQjBGNC1FOTExLUFBNDMtMDI1NDk4QTZENUQ2Iiwicm9sZU5hbWUiOiJyZWdpc3RyYXRpb25PcGVyYXRvciIsInNjb3BlcyI6WyJuZXctaG46d3JpdGUiXSwic2VydmljZVVuaXRzIjpbeyJzZXJ2aWNlVW5pdElkIjoiNWRhZTZkMTVjNzI1MzRlZTY1YTIzYjNmIiwic2VydmljZVVuaXROYW1lIjoi4LmA4Lin4LiK4Lij4Liw4LmA4Lia4Li14Lii4LiZIOC4leC4tuC4geC5gOC4ieC4peC4tOC4oeC4nuC4o-C4sOC5gOC4geC4teC4ouC4o-C4leC4tCDguIrguLHguYnguJkgMSIsInNlcnZpY2VVbml0QWJicmV2aWF0aW9uIjoiUkcxIiwicm9sZUlkIjoiMUVBMDBFRDUtQjBGNC1FOTExLUFBNDMtMDI1NDk4QTZENUQ2Iiwicm9sZU5hbWUiOiJyZWdpc3RyYXRpb25PcGVyYXRvciJ9XX0.XEktVEJyZG5RSWcABkKshQGbhnBmaUupK2t0ApF3KkOyRFFJjtMQUo1nN0dmq8rScFF6Pi4WFFbQ1EhswR8k-vQasudVrKPlL0-M7jVrEgOq9jwAJ2X2LKLzYdX_JYlaojHBjfeamk9f7qIQIAJbRbMgRz3IsjFutJa9shkGwy5xH52ibeRd81nP18ObaU8D3IX-dY8ujH7pOPWeeUiMHUHEySa9x1tPwuNWOwe66gQhvj3oZabv2yqeMKPJgh1cDoynEhtTnXDXjZBwLalcFSS-b8sxbGhsXIlDd1dazCy1gOqtJuEMSD9WAmUKbIlciijz7eSZgfdAzry1dfB8mHwUdXojLIBqXqcWyTx7RjYF4EytF3GLYiPsz-nOtxlkqEQDVhAVGGRYJQRmpvTRfUHJXWPb-llh8gshYCewi-Pj0_Nn-iiF0FA3nANjAhjfA-9Ohv5xqygA06PPrlH9M_GuNny7VCdh6bmeuVsNt7eomOiI_KPvp6741JUyvYg_mmkZY_p-ugO-cvvPGDTOk3Ayh5ML1S3EKNyM-15JZWAyp38sM8gLvvv4cvkNuNSvPIk5aY21jXaErmOj2C43mfhEgZt42CRlVli0GmAJzLCrZO9JTI2AKQ79A17nMT-81Tg2cudlkxa77M1V00fOsH8GqiT2l1UQ3u_tPCtmp4o";

   $('.menu').click(function(){
      var location=$(this).attr('location');
      var uid=$(this).attr('uid');

      // alert(location);
      // alert(uid);

      localStorage.setItem('location',location);
      localStorage.setItem('station',uid);




   });



   const redirectSite = "<?= ( defined('REDIRECTLOGIN') && REDIRECTLOGIN != '' ? REDIRECTLOGIN : '');?>";
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
        .catch(err => { 
           if(redirectSite != ''){
            window.location.replace(redirectSite);
         }
      });
        sessionStorage.clear();
        if(redirectSite != ''){
           window.location.replace(redirectSite);
        }
     }

     function refreshAPI(){
       console.log("RefreshToken API");
       axiosToken
        //   .post('http://service.healthyflow.xyz/hybrid-auth/api/refresh','')
        .post('http://flow-hybrid-auth.pmk.local/api/refresh','')
        .then(res => {
           var refreshToken = res.data['accessToken'];
           sessionStorage.setItem("hlab_access_token", refreshToken);
           location.reload();
        })
        .catch(err => {
           console.log(err)
           if(redirectSite != ''){
            window.location.replace(redirectSite);
         }
      })
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
         var ExpiredTime = (TokenExpired - current) - (60000*10);
         console.log( "Left : " + ExpiredTime + " milliseconds");
         console.log( "Left : " + ((ExpiredTime/1000)/60) + " minutes");
         window.setTimeout(function(){
          console.log("Token Expired Already - Refresh Token");
          refreshAPI();
       }, ExpiredTime);
         return false;
      }else{
         console.log("Token Expired");
         var PassedExpiredTime = current - TokenExpired;
         console.log( "Passed : " + PassedExpiredTime + " milliseconds");
         console.log("Token Expired Already - Refresh Token");
         refreshAPI();
         return true;
      }
   }

   $(document).ready( function () {
     var currentpage = window.location.href;
     localStorage.setItem('lastpage',currentpage);
		//Init Token
   }


   $(document).on("click", "#SetupBtn", function(e) {
       $('.sidenav_panel').removeClass('active');
       $('#Modal_Management_Setup').modal('show');				
    });

      var location=localStorage.getItem('queuelocation');
      var station=localStorage.getItem('station');

      // alert(station);

      var RequestDataCounter = base_path_url+'getSetupData_JSON'+'/'+location+'/'+station;

      $.getJSON( RequestDataCounter, function( data ) {
       var ButtonColumn = '';
       data['Counter'].forEach(function(Value,Index){
        var CounterData = {
         'ID': Value['counterno'],
         'Name': Value['countername'],
      };
      ButtonColumn += '<div class="colBtn">';
      ButtonColumn += '    <a class="button medium block c_lightblue" data-tabcounter="'+CounterData['ID']+'" data-tabaction="tabcounter">'+CounterData['Name']+'</a>';
      ButtonColumn += '</div>';
   });
       $('#counterRow_Side').html(ButtonColumn);
       $('#counterRow_Alert').html(ButtonColumn);
				//$('.counterRow').append(ButtonColumn);
				
				/*
				if(!localStorage.getItem('Counter')){
					console.log("NO Counter");
					localStorage.setItem('Counter','1');
				}
				*/
				var func_localTab = {
					'Counter' : '',  
				}
				Object.keys(func_localTab).forEach(function (key){
					func_localTab[key] = localStorage.getItem(key);
				});
				$("[data-tabcounter] .active").removeClass("active"); 
				Object.keys(func_localTab).forEach(function (key){
					if( !(localStorage.getItem(key) === null) ){
						var localSplit = localStorage.getItem(key).split(",");
						localSplit.forEach(function(Value,Index){
							$('[data-tabcounter'+'="'+Value+'"]').addClass('active');
						});
					}
				});
			});

      $(document).on("click", '[data-tabaction]', function(e) {
       var targetActionAttr = $(this).data('tabaction');
       if(targetActionAttr == 'tabcounter'){
        $('[data-'+targetActionAttr+']').removeClass('active');
     }
     $(this).toggleClass('active');

     var SelectorText = "";
     SelectorTarget = document.querySelectorAll('[data-'+targetActionAttr+']');
     SelectorTarget.forEach(function(Value,Index){
      if( SelectorTarget[Index].classList.contains('active') ){
       SelectorText += (!SelectorText == "" ? "," : '');
       SelectorText += $(SelectorTarget[Index]).data(targetActionAttr);
    }
 });

     var localTabIndex = {
        'tabcounter' : 'Counter', 
     }
     localTab[localTabIndex[targetActionAttr]] = SelectorText;
     Object.keys(localTab).forEach(function (key){
        localStorage.setItem(key,localTab[key]);
     });
  });
		//Counter

		$(document).on("click", "#acc_logout", function(e) {
			logoutAPI();
		});

		
	});

</script>
