<!DOCTYPE html>
<html>

<head>
    <title><?= (isset($Site_Title) ? $Site_Title : (defined(SITE_TITLE) ? SITE_TITLE : "DashQueue")); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <?= (isset($css) ? assets_css($css) : ''); ?>

    <?= single_js('js/viewport.js'); ?>
</head>

<body>
    <center>
        <div style="width: 100%;height: 95%;font-family: kanit;">

            <div class="lds" style="width: 100%; height: 2em;font-size: 7em; text-shadow: 2px 4px 10px #000000; color:#fefefe; ">
                <span> กรุณารอสักครู่</span>
                <div class="lds-facebook">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

            <div class="div_cnt" style="width: 88%;height: 80%;background-color: #ecf0f1; box-shadow: 0px 0px 18px 2px #0e0e0e; border-radius: .4em;">

                <div style="padding: 10px 20px 18px 56px; font-size: 3em;height: 15%; width: 80%">


                    <?= single_img('kiosk/resources/images/logo.png', array('style' => 'height: 100%;float: left;')) ?>
                    <p class="" style="width: 100%; padding-top: 1em">โรงพยาบาลพระมงกุฎเกล้า</p>
                    <p class="" style="width: 100%; font-size: .9em;">Phamongkutklao Hospital</p>

                </div>
                <!-- head -->
                <div class="" style=" height: 16%;">
                    <div style="width: 40%;height: 100%;float: left; padding: 0px 20px 0 90px;padding-top: 2em;">
                     
                        <?= single_img('kiosk/resources/images/qr.jpg', array('style' => 'height:16em;')) ?>
                    </div>
                    <div style="width: 60%;height: 100%;float: left; text-align:left; padding: 6px 17px 0px 0px;">
                        <div class="slip_user" style="width: 100%;height: 100%;float: left; text-align: left; padding: 18px 17px 0px 0px;">

                            <h4>คุณเบญจวรรณ รัตนเพิ่ม</h4>
                            <h6>เลขบัตรประชาชน : <a>1-2345-67890-12-3</a></h6>
                            <h6>วัน / เดือน / ปีเกิด : <a>1/11/2000</a></h6>
                            <h6>HN : <a>wwwwww</a></h6>
                        </div>

                    </div>

                </div>
                <!-- user -->
                <div class="num_q_box">
                    <a>หมายเลขบริการ</a>

                    <div style="font-family: 'Kanit SemiBold', 'Kanit Regular', 'Kanit';font-weight: 600;font-style: normal; font-size: 120px; text-align: center; width: 88%;">
                        <span>NA001</span>
                    </div>
                </div>

                <!-- user -->
                <div id="boxContent" style="width: 100%; height: 58%">
                    <?php
                    if (isset($Content) && count($Content) > 0) {
                        foreach ($Content as $result) :
                            $this->load->view($Module . '/' . $result);
                        endforeach;
                    }
                    ?>
                </div>
            </div>
            <div style="position: absolute;bottom: 40px;right: 50px;width: 91%;">
                <div class="second_footer">
                    <span class="item-3">วัน พุธ ที่ 18 กันยายน พ.ศ. 2562</span>
                </div>
            </div>
        </div>

    </center>

    <?php

    ?>

    <?= (isset($js) ? assets_js($js) : ''); ?>
    <?= (isset($node_modules) ? assets_node($node_modules) : ''); ?>

    <?php
    if (isset($Script) && count($Script) > 0) {
        foreach ($Script as $result) :
            $this->load->view($Module . '/' . $result);
        endforeach;
    }
    ?>

</body>

</html>