<!DOCTYPE html>
<html>

<head>
    <title><?= (isset($Site_Title) ? $Site_Title : (defined(SITE_TITLE) ? SITE_TITLE : "Setup")); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <?= assets_css(array(
        'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
        'bootstrap-datepicker' => 'bootstrap-datepicker/css/bootstrap-datepicker.min.css',
        'fontawesome5.11.2' => 'fontawesome/css/all.css',
        'admincss' => 'css/sb-admin-2.min.css',
        'stylesheet' => 'css/style.css',
        'chartjs2.9.3' => 'chartjs/Chart.min.css'
    )); ?>
    <style type="text/css">
        #show_data .card {
            cursor: move !important;
        }

        .btn_pmk {
            color: #fff;
            /*background-color: #31527f;*/
            background: linear-gradient(90deg, rgba(36, 56, 109, 1) 0%, rgba(47, 87, 126, 1) 100%);
            border-color: #31527f;
            border-radius: 17px !important;
        }

        .border-left-pmk {
            border-left: .25rem solid #31527f !important;
        }

        .nav_pmk {

            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(46, 98, 98, 1) 51%, rgba(46, 98, 98, 1) 100%);
        }

        .btn_edit {
            font-family: Mitr_light;
            font-size: 16px;
        }

        .btn_pmk {
            color: #fff;
            /*background-color: #31527f;*/
            background: linear-gradient(90deg, rgba(36, 56, 109, 1) 0%, rgba(47, 87, 126, 1) 100%);
            border-color: #31527f;
            border-radius: 17px !important;
        }

        .border-left-pmk {
            border-left: .25rem solid #31527f !important;
        }

        .nav_pmk {

            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(46, 98, 98, 1) 51%, rgba(46, 98, 98, 1) 100%);
        }

        .btn_edit {
            font-family: Mitr_light;
            font-size: 16px;
        }

        .sidebar-dark .nav-item .nav-link:hover {
            background-color: #fafafa;
        }

        .groupprocess {
            font-family: mitrregular;
            font-size: 18px;
        }

        .payorid {
            font-family: mitrregular;
            font-size: 18px;

        }

        .patient_type_data {
            font-family: mitrregular;
            font-size: 18px;
        }

        .modal.fade .modal-dialog.modal-dialog-zoom {
            -webkit-transform: translate(0, 0)scale(.5);
            transform: translate(0, 0)scale(.5);
        }

        .modal.show .modal-dialog.modal-dialog-zoom {
            -webkit-transform: translate(0, 0)scale(1);
            transform: translate(0, 0)scale(1);
        }

        ul.inline {
            margin: 0;
            padding: 0;
        }

        ul,
        ul.inline>li {
            display: inline;
        }

        ul.seperate_bd>li {
            border-left: 1px solid RGBA(255, 255, 255, 1);
            padding-left: 0.5rem;
        }

        ul.seperate_bd>li:first-child {
            border-left: none;
        }

        ul.seperate_box li {
            background-color: #156a6c;
            padding: 5px;
            border-radius: 5px;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            color: #fff;
            font-size: 15px;
        }

        .dropdown-item {
            font-size: 15px !important;
        }

        #dropdownMenuButton {
            background-color: #156a6c !important;
            color: #fff;
            border: 1px solid #2e6262;

        }

        .topic {
            width: 100%;
            text-align: left;
            border-bottom: 1px solid #000;
            line-height: 0.1em;
            margin: 10px 0 20px;
        }

        .topic span {
            background: #fff;
            padding: 0 10px;
        }

    </style>

    <?= single_js('js/viewport.js'); ?>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-light nav_pmk topbar mb-2 static-top shadow">
        <div style="font-family: Mitr; color:#fff;font-size: 25px;">
            Pharmacy/Cashier Setup
        </div>
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <ul class="navbar-nav ml-auto">

            <ul class="inline seperate_box" style="font-size: 1.5rem;font-weight: 200;">
                <li id="li_serviceUnitAbbreviation"><img style="width: 26px" src="<?= BASEURL; ?>/static/Icon/5.png" alt=""><span id="span_serviceUnitAbbreviation">Service Unit</span></li>
                <li id="li_login" class="dropdown"><img style="width: 26px;margin-right: 4px; margin-left: 4px;" src="<?= BASEURL; ?>/static/Icon/6.png" alt="">
                    <button class="dropdown-toggle none" style="color:#FFFFFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="span_Login">No User : No Session</span>
                    </button>
                    <div class="dropdown-menu" style="font-size:1.5rem;" aria-labelledby="dropdownMenuButton">
                        <a id="acc_logout" class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
            </ul>
        </ul>
    </nav>
    <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute; left: 40%; top: 40%; z-index: 9; color: rgb(46, 98, 98); font-size: 100px;"></i>
    <div id="wrapper">
        <?= $this->load->view($Module . '/sidenav'); ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <div class="container-fluid">
                    <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;"><?= isset($FunctionName) ? $FunctionName : 'Setup'; ?></div>
                    
                    <div id="show_data" class="row" style="overflow-x:auto;">
                        <?php
                        if (isset($Content) && count($Content) > 0) {
                            foreach ($Content as $result) :
                                $this->load->view($Module . '/' . $result);
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span class="footer-txt" style="font-family: Mitr;font-size: 13px;font-weight: 300;">โรงพยาบาลพระมงกุฏเกล้า</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">คุณต้องการยืนยันออกจากระบบ</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-success" href="<?= BASEURL; ?>/Admin/user_logout">ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>


    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?= assets_js(array(
        'popper1' => 'js/popper.min.js',
        'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
        'bootstrapjs' => 'bootstrap/js/bootstrap.js',
        'bootstrap-datepicker' => 'bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        'jqueryDataTable' => 'jquerydataTable/datatables.min.js',
        'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
        'axios0.19.0' => 'axios/axios.min.js',
        'jquery-ui' => 'js/jquery-ui.js',
        'jscolor' => 'js/jscolor.js',
        'chartjs2.9.3' => 'chartjs/Chart.min.js',
        'chartjsplugin' => 'chartjs/chartjs-plugin-labels.js'
    )); ?>
    <?= (isset($node_modules) ? assets_node($node_modules) : ''); ?>
    <script type="text/javascript">
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

        const logoutAPI = () => {
            console.log("Logout API");
            axiosToken
                // .post('http://service.healthyflow.xyz/hybrid-auth/api/logout','')
                .post('http://flow-hybrid-auth.pmk.local/api/logout', '')
                .then(res => res.data)
                .catch(err => {
                    /* not hit since no 401 */
                });
            sessionStorage.clear();
            // window.location.replace("http://healthyflow.xyz/");
        }

        const refreshAPI = () => {
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

        const DecodeJWT = (Token) => {
            let result = KJUR.jws.JWS.parse(Token);
            return result['payloadObj'];
        }

        const getStorageToken = (StorageName) => {
            var Token = sessionStorage[StorageName];
            return Token;
        }

        const checkExpired = (TokenExpired) => {
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

        const ajaxURL = "<?= APPURLSETUP; ?>";

        $(document).ready(function() {
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
                    $('#span_Login').text("Test : " + TokenObject['sub']);
                    $('#span_serviceUnitAbbreviation').text("Test : " + TokenObject['serviceUnitName']);
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
                var currentURI = "<?= $_SERVER['REQUEST_URI']; ?>";
                var explodeURI = currentURI.split('/');
                explodeURI[0] = "<?= SSLPREFIX; ?>";

                var domainURL = currentURL;
                explodeURI.forEach(function(value, index) {
                    domainURL = domainURL.replace('/' + value, '');
                });
                domainURL = domainURL;

                console.log("Redirect to " + domainURL);
                // window.location.replace("http://healthyflow.xyz/");

            }
            
            $(document).on('submit', 'form[printupdate]', function(){
                let formURL = $(this).attr('action');
                let formData = $(this).serialize();
                let muser = encodeURIComponent($('#span_Login').text());
                formData += `&muser=${muser}`;
                $.post(formURL,formData)
                    .then(function(data){
                        console.log(data);
                    });
                return false;
            })
            $(document).on('change', 'form[printupdate] input', function(){
                $(this).closest('form').submit();
            })

            //Init
            $(document).on("click", "#acc_logout", function(e) {
                logoutAPI();
            });
            $('#loading').css('display', 'none');
        });
    </script>
    <?php
    if (isset($Script) && count($Script) > 0) {
        foreach ($Script as $result) :
            $this->load->view($Module . '/' . $result);
        endforeach;
    }
    ?>

</body>

</html>