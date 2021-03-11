<script>
    // alert('najazuza');


    $(document).ready(function() {
        <?php echo Modules::run('Websocket/SocketConection'); ?>
        // midSocket.emit('scan_hn_success');

        midSocket.on('scan_station', function(data) {
            if (data['step'] == 'next1') {
                window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
            }
        });


        /////////////////////////////// start  /////////////////////////////

        $.ajax({
            url: baseurlMid + '/api/kiosk/tp/payor/fetch',
            method: "post",
            dataType: 'json',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers': '*',
                'Authorization': 'Basic YXJtOjEyMzQ='
            },
            data: {
                location: '4',
                step: 'next4'
            },
            success: function(msg) {
                console.log(msg, 'zaza');
            },
            error: function(msg) {
                console.log(msg);
            }

        });

        midSocket.on('payor_data', (result) => {
            console.log('data get from service');
            console.log(result);

            //////////////     create box payor    /////////////

            var HtmlMain = '';
            for (var i = 0; i < result['data'][0]['data'].length; i++) {

                HtmlMain += "<div style='padding: 10px;float: left; width: 218px; height: 218px; ' class='box_payor' value='" + result["data"][0]["data"][i]["uid"] + "'>";
                HtmlMain += "<div class='d2_lb1'>";
                HtmlMain += "<div style='width: 70%;height: 70%'>";
                HtmlMain += "</div>";
                HtmlMain += "<a style='text-align: center; font-size: 2em;font-weight: 600;color: black;'>เงินสด</a>";
                HtmlMain += "</div>";
                HtmlMain += "</div>";
            }
            $("#area_box_payyor").html(HtmlMain);

            //////////////     create box payor    /////////////




            for (var i = 0; i < result['data'][1]['data'].length; i++) {

                $(".box_payor[value='" + result["data"][1]["data"][i]["payorid"] + "']").css({
                    'background': 'green'
                });
            }


        });

        /////////////////////////////// end  /////////////////////////////













        var next_to_pcc = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;
        $("#conf_yes").click(function() {
            window.location.href = next_to_pcc;
        });
    });
</script>