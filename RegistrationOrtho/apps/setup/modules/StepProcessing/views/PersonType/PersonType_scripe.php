<script>
    $(document).ready(function() {
        <?php echo Modules::run('Websocket/SocketConection') ?>

        var idcard = '';
        var hn = '';

        midSocket.on('scan_station', function(data) {
            if (data['step'] == 'next1') {
                window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
            }
        });


        /////////////////////////////// start ข้อมูล hn กรณีที่เจอ ผู่ป่วยเก่า /////////////////////////////

        $.ajax({
            url: baseurlMid + '/api/kiosk/hn',
            method: "post",
            dataType: 'json',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers': '*',
                'Authorization': 'Basic YXJtOjEyMzQ='
            },
            data: {
                location: '1',
                step: 'next3'
            },
            success: function(msg) {
                console.log(msg, 'zaza');
            },
            error: function(msg) {
                console.log(msg);
            }

        });

        midSocket.on('kiosk_hn', (data) => {
            console.log('data get from service');
           

            idcard = data['data'][0]['idcard'];
            hn = data['data'][0]['hn'];
            
            $.ajax({
                url: baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?> + '/StepProcessing/CreateSession',
                type: "post",
                dataType: "json",
                data: {
                    data: data['data'][0]
                },
                success: function(msg) {
                    console.log(msg, 'zaza');
                    console.log(<?php echo json_encode($this->session->userdata('SessionMain'));?>,'test');
                }
            });
        });

        /////////////////////////////// end ข้อมูล hn กรณีที่เจอ  ผู่ป่วยเก่า/////////////////////////////


        $.ajax({
            url: baseurlMid + '/api/kiosk/tp/type',
            method: "post",
            dataType: 'json',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers': '*',
                'Authorization': 'Basic YXJtOjEyMzQ='
            },
            data: {
                requestType: '1',
                location: '4',
            },
            success: function(msg) {
                console.log(msg['data']);
                var html = '';
                for (var i = 0; i < msg['data'].length; i++) {
                    html += "<div class='form-check'>";
                    html += "<input class='form-check-input in_checkbox' type='checkbox' value='" + msg["data"][i]["code"] + "' style='width:40px; height:40px;'>";
                    html += "<label class='form-check-label' for='defaultCheck1' style='font-size:40px;margin-left:50px;'>";
                    html += msg["data"][i]["name"];
                    html += "</label>";
                    html += "</div>";
                }
                $("#area_check_box").html(html);

            },
            error: function(msg) {
                console.log(msg);
            }

        });


        $("#conf_next").click(function() {

            var input_box = $(".in_checkbox:checked").val();
            $.ajax({
                url: baseurlMid + '/api/kiosk/tp/type',
                method: "post",
                dataType: 'json',
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Headers': '*',
                    'Authorization': 'Basic YXJtOjEyMzQ='
                },
                data: {
                    requestType: '2',
                    typeval: input_box,
                    idcard: idcard,
                    hn: hn,
                    location: '4',
                },
                success: function(msg) {
                    console.log(msg);
                    if (msg['success'] == true) {
                        window.location.href = NextToChTm;
                    }
                },
                error: function(msg) {
                    console.log(msg);
                }

            });
        });






        var NextToChTm = baselocal + <?php echo Modules::run('Websocket/NextToCheckPayor') ?>;

        // $("#conf_next").click(function() {
        //     window.location.href = NextToChTm;
        // });
    });
</script>