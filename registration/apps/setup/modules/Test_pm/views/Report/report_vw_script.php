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
        $('#loading').css('display', 'none');

        var topicMap = {
            "kiosk_report":"Kiosk",
            "management_visit_report":"คัดกรอง",
            "management_newhn_report":"ทำประวัติ",
            "management_register_report":"เปิดสิทธิ",
            "management_reportall":"kiosk+คัดกรอง+ทำประวัติ+เปิดสิทธิ"
        };

        $(document).on('submit','#report_form',function(e){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();            
            $('#show_data').html('');
            $('#loading').css('display', 'block');
            $.post(formURL,formData)
                .done( (data) => {
                    console.log(data);
                    $('#show_data').html(data.html);
                    $(`#${data.table}`).dataTable({
                        dom: 'fBrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('.dataTables_filter').css('display','inline');
                    document.title = `สถิติ ${topicMap[data.table]} ${$('#date_from').val()} ถึง ${$('#date_to').val()}}`;
                    $('#loading').css('display', 'none');
                })
                .fail( () => {
                    $('#show_data').html("Try Again");
                    $('#loading').css('display', 'none');
                });

            return false;
        });

    });
</script>