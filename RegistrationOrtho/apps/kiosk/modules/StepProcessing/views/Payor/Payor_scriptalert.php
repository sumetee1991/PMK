<script>
    <?php echo Modules::run('Websocket/SocketConection'); ?>
    var UrlBaseCont = baselocal + <?php echo Modules::run('Websocket/BaseContoller') ?>;
    $(document).ready(function() {

        var manual;
        // midSocket.emit('scan_hn_success');
        console.log(<?php echo json_encode($this->session->userdata('APISession')); ?>, 'APISession');
        console.log(<?php echo json_encode($this->session->userdata('kiosk_location')); ?>, 'kiosk_location');
        var kiosk_location = <?php echo json_encode($this->session->userdata('kiosk_location')); ?>;
        var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
        var session_main = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;

        midSocket.on('scan_station', function(data) {
            if (data['step'] == 'next1') {
                window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
            }
        });

        var payoractiveold = '';
        var payor_active = '';

        var check_patient_type = '';
        var worklistgroup = '';
        var idcard_sess = '';

        var check_patient_type = '';
        var worklistgroup = '';
        var idcard_sess = '';

        $.ajax({ //create session
            url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
            type: "post",
            dataType: "json",
            data: {
                pagenow: (parseInt(list_num_pagenow) + 1)
            },
            success: function(msg) {
                console.log(msg);
            },
            error: function(msg) {
                console.log(msg, 'error');
            }
        });



        $.ajax({
            url: UrlBaseCont + '/StepProcessing/callsesmain',
            type: "post",
            dataType: 'json',
            async: false,
            success: function(data) {
                //var data = JSON.parse(data);
                //console.log(data);
                //console.log('gg data');
                //alert(data['PayorActive']['PayorActive']);
                payoractiveold = (typeof data['PayorActive'] == 'undefined') ? '' : data['PayorActive'][
                    'PayorActive'
                ];

                console.log('ajax sesmain');
                console.log(data);
                check_patient_type = (data.worklistgroup == undefined) ? data.UserInfo.worklistgroup :
                    data.worklistgroup;
                worklistgroup = (data.worklistgroup == undefined) ? data.UserInfo.worklistgroup : data
                    .worklistgroup;
                idcard_sess = data.UserInfo.data[0].idcard;
            }
        });

        var checkofflinemode = '';

        $.ajax({
            url: UrlBaseCont + '/StepProcessing/callsesoffline',
            type: "post",
            dataType: 'json',
            async: false,
            success: function(data) {
                console.log('offline');
                console.log(data);



                if (data != null && data.OfflineMode != null && data.With != 'Appointment') {
                    checkofflinemode = data.OfflineMode;

                    $.ajax({ //create session
                        url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
                        type: "post",
                        dataType: "json",
                        data: {
                            pagenow: (parseInt(list_num_pagenow) + 1)
                        },
                        success: function(msg) {

                            num_page_tmp = msg['NumberPage']['NumberPage'];
                            list_num_pagenow = msg['NumberPage']['NowPage'];

                            var count_page = 1;
                            var text_page = '';

                            for (var i = 0; i < num_page_tmp; i++) {
                                text_page += '<li class="step_page " value="' + parseInt(
                                    count_page++) + '"></li>';
                            }
                            $("#list_number_page").html(text_page);
                            $(".step_page[value='" + list_num_pagenow + "']").addClass(
                                'active');



                            console.log(msg, '???????????????????????????');
                        },
                        error: function(msg) {
                            console.log(msg, 'error');
                        }
                    });


                }



            }
        });

        $.ajax({
            url: UrlBaseCont + '/StepProcessing/PersonType/Get_payor',
            type: "post",
            dataType: 'json',
            async: false,
            success: function(msg) {
                console.log(msg, 'aaaasdsdsdsdsd');
                var HtmlMain = '';
                var openactive = '';
                var color = '';
                var check_full_condition = '';
                var payor_auto = '';

                $.each(msg, function(index, value) {

                    HtmlMain +=
                        "<button class='col-3 center btn_payor chk_sty' style='outline:none;' payor_auto='" +
                        payor_auto + "' hiscode='" + value["hiscode"] + "' condition='" +
                        check_full_condition + "' active_click=''  name_payor='" + value[
                            "hiscadit"] + "' value='" + value["uid"] + "' check_payor='" +
                        value["openactive"] + "'>";
                    HtmlMain += "<div class='' style='text-align: center;'>";
                    HtmlMain +=
                        "<div class='center div_chk_content d2_lb1' style='' active=''>";
                    HtmlMain += "<span class='_st'></span>";
                    HtmlMain += "<a class='chk_font bodyth'>" + value["name"] + "</a>";
                    HtmlMain += "</div>";
                    HtmlMain +=
                        "<span class='form-control openactive_class' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;" +
                        color + "'>" + openactive + "</span>";
                    HtmlMain += "</div>";
                    HtmlMain += "</button>";
                });


                $("#area_box_payyor").html(HtmlMain);


                if (payoractiveold != '') {

                    $(".btn_payor[value='" + payoractiveold + "']").find('div').find('.d2_lb1').css({
                        'background-color': '#78b3a3',
                        'color': 'white'
                    }).attr('active', 'now');
                    $(".btn_payor[value='" + payoractiveold + "']").attr('active_click', 'active')
                        .trigger('click');

                    $("#hiscode_se").val($(".btn_payor[active_click='active']").attr('hiscode'));
                    payor_active = payoractiveold;
                }



            }
        });
        console.log(<?php echo json_encode($this->session->userdata('SessionMain')); ?>, 'test');
        try {
            var date_ses = <?php echo json_encode($this->session->userdata('SessionMain')); ?>;
            console.log(date_ses, "DATA SESSION")

            var imgMan = "<?= base_url('static/kiosk/resources/images/YoungmanAvatar.png'); ?>";
            var imgWoman = "<?= base_url('static/kiosk/resources/images/WomenAvatar.png'); ?>";
            if (date_ses['UserInfo'] != null) {
                // if (date_ses['UserInfo']['data'][0]['gender'] == 'male') {
                //    $("#imgavatar").find("img").attr("src", imgMan);
                // } else if (date_ses['UserInfo']['data'][0]['gender'] == 'female') {
                //    $("#imgavatar").find("img").attr("src", imgWoman);
                // } else if (date_ses['UserInfo']['data'][0]['gender'] == '') {

                // }
            }





            var check_scan = date_ses['UserInfo']['scan'];

            var list_last_payor = [];

            $("#area_payor_before").val(date_ses['UserInfo']['data'][0]['payorname']);

            var oldworklistgroup_check = '';

            var hn_sess = '';




            if (date_ses['UserInfo']['data'][0]['hnno']) {

                hn_sess = date_ses['UserInfo']['data'][0]['hnno'];

                var fullHn = '';

                if (hn_sess.includes('/')) {
                    var s = hn_sess.split('/');
                    fullHn = s[1] + '/' + s[0]

                    var list_holderid = [];
                    console.log("OPENVISIT")

                    // url: baselinkapi + `/ords/pmkords/hlab/credit-master/${fullHn}`,
                    // url: UrlBaseCont + '/StepProcessing/demotest',
                    $.ajax({
                        // url: UrlBaseCont + '/StepProcessing/demotest',
                        // url: baselinkapi + `/ords/pmkords/hlab/credit-master/${fullHn}`,
                        url: UrlBaseCont + `/StepProcessing/openVisit`,
                        type: "post",
                        dataType: "json",
                        data: {
                            HN: fullHn
                        },
                        header: {
                            // 'X-Request-With':'XMLHttpRequest',
                            'Access-Control-Allow-Origin': '*',
                            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                            'Access-Control-Allow-Headers': '*',
                            "content-type": "application/json"
                        },
                        async: false,
                        success: function(data) {
                            //console.log(data, 'demotest');
                            $.each(JSON.parse(data), function(index, value) {
                                // console.log(index, "INDEX EACH");
                                // console.log(value['periodStart'], "VALUE EACH");
                                // console.log(value);

                                if (value['periodStart'] <= dateformat() && value[
                                        'periodEnd'] >= dateformat()) {
                                    list_holderid.push(value['policyHolderId']);
                                } else if (value['periodStart'] == "null" || value[
                                        'periodEnd'] == "null") {
                                    list_holderid.push(value['policyHolderId']);
                                } else if (value['periodStart'] == null || value['periodEnd'] ==
                                    null) {
                                    list_holderid.push(value['policyHolderId']);
                                }
                            });
                        }
                    });

                    console.log(list_holderid, 'list_holderid');
                }
            }



            if (date_ses['UserInfo']['oldworklistgroup']) {

                oldworklistgroup_check = date_ses['UserInfo']['oldworklistgroup'];

                $.ajax({
                    url: UrlBaseCont + '/StepProcessing/UpdateUserInfotoOld',
                    type: "post",
                    dataType: "json",
                    data: {
                        worklistgroup: oldworklistgroup_check
                    },
                    success: function(msg) {
                        console.log(msg, 'gotoOld');
                    }
                });
            }
        } catch (e) {

        }

        // ---  get payor main --- //

        /////////////////////////////// start  /////////////////////////////


        function dateformat() {
            var date = new Date();
            var day = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
            var month = (date.getMonth() < 10) ? '0' + date.getMonth() : date.getMonth();
            var year = date.getFullYear();

            return year + '-' + (month + 1) + '-' + day;
        }

        $.ajax({
            url: UrlBaseCont + '/StepProcessing/callsesoffline',
            type: "post",
            dataType: 'json',
            async: false,
            success: function(data) {
                console.log('offline');
                console.log(data);

                if (data) {

                } else {
                    $.ajax({
                        url: baseurlMid + '/api/kiosk/tp/payor/fetch',
                        method: "post",
                        dataType: 'json',
                        async: false,
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                            'Access-Control-Allow-Headers': '*',
                            'Authorization': 'Basic YXJtOjEyMzQ='
                        },
                        data: {
                            location: '4',
                            step: 'next4',
                            kiosk_location: kiosk_location
                        },
                        success: function(msg) {
                            console.log('dddd', msg, 'get payor api');
                            console.log('data get from service');
                            // console.log(result);

                            if (msg.kiosk_location == kiosk_location) {

                                console.log(msg.kiosk_location + " : " + kiosk_location,
                                    'payor_data');

                                //////////////     create box payor    /////////////

                                var HtmlMain = '';
                                var check_py_uid = [];
                                if (msg.data.length > 0) {


                                    if (msg['data'][0]['Payor'].length > 0 &&
                                        worklistgroup != '3') {
                                        for (var i = 0; i < msg['data'][0]['Payor']
                                            .length; i++) {


                                            var tem_hidcode = (msg['data'][0]['Payor'][i][
                                                'hiscode'
                                            ] != null) ? msg['data'][0]['Payor'][i][
                                                'hiscode'
                                            ].split(',') : '';
                                            var tem_hidcode_final = tem_hidcode;
                                            // $.each(tem_hidcode_final, function(index, value) {
                                            //    var use_hidcode = value;
                                            //    $.each(list_holderid, function(index, value) {
                                            //    }); //each ??????
                                            // }); //each ?????????
                                            // if (value == use_hidcode) {}

                                            var openactive = '';
                                            var color = '';
                                            var check_full_condition = '';
                                            var payor_auto = '';

                                            //if (worklistgroup == '2') { // ????????????????????????????????????????????? ??????????????????????????? ????????????????????? ????????????/????????? ????????????????????????

                                            // if (msg["data"][0]["Payor"][i]["openactive"] === 'Y' && msg["data"][0]["Payor"][i]["hiscadit"] == '??????????????????' && check_patient_type != '3') {
                                            //    openactive = '?????????????????????????????????????????????';
                                            //    color = 'background-color:#f7eab5;';
                                            //    payor_auto = 'auto';
                                            // }


                                            // if (msg["data"][0]["dataLastPayor"] != null) { // ???????????????????????????????????????????????? payor ??????????????????
                                            //    var policyHolder = msg["data"][0]["dataLastPayor"]["policyHolder"];

                                            //    if (msg["data"][0]['Payor'][i]['hiscadit'] != null) { //????????????????????? payorLast ??????????????? math ????????? payor????????????????????????????????????
                                            //       var tmp = msg["data"][0]['Payor'][i]['hiscadit'].split(',');
                                            //       for (var d = 0; d < tmp.length; d++) {
                                            //          if (msg["data"][0]["Payor"][i]["openactive"] === 'Y' && tmp[d] == policyHolder && check_patient_type != '3') {
                                            //             openactive = '?????????????????????????????????????????????';
                                            //             color = 'background-color:#f7eab5;';
                                            //             check_full_condition = 'condition_full';
                                            //          }
                                            //       }
                                            //    }
                                            // }

                                            $.each(tem_hidcode_final, function(index,
                                                value) {
                                                var use_hidcode = value;
                                                //console.log(list_holderid, 'AA');
                                                $.each(list_holderid, function(
                                                    index, value) {
                                                    if (msg["data"][0][
                                                            "Payor"
                                                        ][i][
                                                            "openactive"
                                                        ] ===
                                                        'Y') {
                                                        if (use_hidcode ==
                                                            value) {

                                                            openactive =
                                                                '?????????????????????????????????????????????';
                                                            color =
                                                                'background-color:#f7eab5;';
                                                            check_full_condition
                                                                =
                                                                'condition_full';
                                                            payor_auto =
                                                                'auto';
                                                            //alert(msg["data"][0]["Payor"][i]["uid"]);
                                                            $(".btn_payor[value='" +
                                                                    msg[
                                                                        "data"]
                                                                    [0][
                                                                        "Payor"
                                                                    ]
                                                                    [i][
                                                                        "uid"
                                                                    ] +
                                                                    "']")
                                                                .find(
                                                                    '.openactive_class'
                                                                ).css(
                                                                    'background-color',
                                                                    '#f7eab5'
                                                                );
                                                        }
                                                    }
                                                }); //each ??????
                                            }); //each ?????????


                                            //} //worklistgroup == '2'
                                            // HtmlMain += "<button class='col-3 center btn_payor chk_sty' style='outline:none;' payor_auto='" + payor_auto + "' hiscode='" + msg["data"][0]["Payor"][i]["hiscode"] + "' condition='" + check_full_condition + "' active_click=''  name_payor='" + msg["data"][0]["Payor"][i]["hiscadit"] + "' value='" + msg["data"][0]["Payor"][i]["uid"] + "' check_payor='" + msg["data"][0]["Payor"][i]["openactive"] + "'>";
                                            // HtmlMain += "<div class='' style='text-align: center;'>";
                                            // HtmlMain += "<div class='center div_chk_content d2_lb1' style='' active=''>";
                                            // HtmlMain += "<span class='_st'></span>";
                                            // HtmlMain += "<a class='chk_font'>" + msg["data"][0]["Payor"][i]["name"] + "</a>";
                                            // HtmlMain += "</div>";
                                            // HtmlMain += "<span class='form-control' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;" + color + "'>" + openactive + "</span>";
                                            // HtmlMain += "</div>";
                                            // HtmlMain += "</button>";


                                            $(".btn_payor[value='" + msg["data"][0]["Payor"]
                                                [i]["uid"] + "']").find(
                                                '.openactive_class').html(openactive);
                                            $(".btn_payor[value='" + msg["data"][0]["Payor"]
                                                [i]["uid"] + "']").attr('condition',
                                                check_full_condition);
                                            $(".btn_payor[value='" + msg["data"][0]["Payor"]
                                                [i]["uid"] + "']").attr('payor_auto',
                                                payor_auto);
                                        }
                                        $("#payorauto_se").val($(
                                                ".btn_payor[active_click='active']")
                                            .attr('payor_auto'));
                                    } else if (worklistgroup == '3') {
                                        // alert('????????????????????? 3');
                                        for (var i = 0; i < msg['data'][0]['Payor']
                                            .length; i++) {

                                            $(".btn_payor[value='" + msg["data"][0]["Payor"]
                                                [i]["uid"] + "']").attr('payor_auto',
                                                payor_auto);

                                            // HtmlMain += "<button class='col-3 center btn_payor chk_sty' style='outline:none;' payor_auto='" + payor_auto + "' hiscode='" + msg["data"][0]["Payor"][i]["hiscode"] + "' active_click=''  name_payor='" + msg["data"][0]["Payor"][i]["hiscadit"] + "' value='" + msg["data"][0]["Payor"][i]["uid"] + "' check_payor='" + msg["data"][0]["Payor"][i]["openactive"] + "'>";
                                            // HtmlMain += "<div class='' style='text-align: center;'>";
                                            // HtmlMain += "<div class='center div_chk_content d2_lb1' style='' active=''>";
                                            // HtmlMain += "<span class='_st'></span>";
                                            // HtmlMain += "<a class='chk_font'>" + msg["data"][0]["Payor"][i]["name"] + "</a>";
                                            // HtmlMain += "</div>";
                                            // HtmlMain += "<span class='form-control' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;'></span>";
                                            // HtmlMain += "</div>";
                                            // HtmlMain += "</button>";

                                        }

                                        $("#payorauto_se").val($(
                                                ".btn_payor[active_click='active']")
                                            .attr('payor_auto'));
                                    }
                                }
                                //$("#area_box_payyor").html(HtmlMain);
                                if (msg['data'].length) {
                                    if (msg['data'][0]['dataLastPayor']['policyHolderId']) {

                                        var tem_policyHolderId = msg['data'][0][
                                            'dataLastPayor'
                                        ]['policyHolderId'];

                                        $(".btn_payor").each(function() {

                                            var hiscode_tem = ($(this).attr(
                                                'hiscode') == null) ? '' : $(
                                                this).attr('hiscode').split(',');
                                            var value_btn = $(this).val();
                                            $.each(hiscode_tem, function(index,
                                                value) {


                                                if (value ==
                                                    tem_policyHolderId) {
                                                    if (payoractiveold ==
                                                        '') {
                                                        $(".btn_payor[value='" +
                                                                value_btn +
                                                                "']").find(
                                                                'div').find(
                                                                '.d2_lb1')
                                                            .css({
                                                                'background-color': '#78b3a3',
                                                                'color': 'white'
                                                            }).attr(
                                                                'active',
                                                                'now');
                                                        $(".btn_payor[value='" +
                                                            value_btn +
                                                            "']").attr(
                                                            'active_click',
                                                            'active');
                                                        payor_active =
                                                            value_btn;
                                                    }
                                                    $("#hiscode_se").val($(
                                                        ".btn_payor[value='" +
                                                        value_btn +
                                                        "']").attr(
                                                        'hiscode'));
                                                    $("#payorauto_se").val(
                                                        $(".btn_payor[value='" +
                                                            value_btn +
                                                            "']").attr(
                                                            'payor_auto'
                                                        ));


                                                    $.ajax({ //create session
                                                        url: UrlBaseCont +
                                                            '/StepProcessing/CreateSesPagePayor',
                                                        type: "post",
                                                        async: false,
                                                        dataType: "json",
                                                        data: {
                                                            payor_active: payor_active
                                                        },
                                                        success: function(
                                                            msg
                                                        ) {
                                                            console
                                                                .log(
                                                                    msg,
                                                                    'CreateSesPagePayor'
                                                                );
                                                        }
                                                    }); //ajax
                                                }
                                            });

                                        });
                                    }
                                }

                                if (worklistgroup == '3') {
                                    $("#last_payor").val('-');
                                    $(".div_chk_content").removeAttr('style');

                                } else {
                                    if (msg.data.length) {


                                        // alert(msg["data"][0]['dataLastPayor']['policyHolderName']);
                                        var payor_last_Ses = (msg["data"][0][
                                                'dataLastPayor'
                                            ]['policyHolderName'] ==
                                            null) ? '-' : msg["data"][0][
                                            'dataLastPayor'
                                        ]['policyHolderName'];
                                        $("#last_payor").val(payor_last_Ses);
                                        $("#last_payor").attr('data-policyholderid', msg[
                                            "data"][0]['dataLastPayor'][
                                            'policyHolderId'
                                        ])
                                    }
                                }




                                //////////////     create box payor    /////////////


                                // for (var i = 0; i < result["data"][0]['dataLastPayorAll'].length; i++) { // ??????????????????????????? map ???????????????????????????????????? ????????? ?????????????????????????????????????????????????????? ??????????????????????????????????????????

                                //    var policyHolder = result["data"][0]["dataLastPayorAll"][i]["policyHolder"];

                                //    for (var i = 0; i < result["data"][0]['Payor'].length; i++) {
                                //       if (result["data"][0]['Payor'][i]['hiscadit'] != null) {
                                //          var tmp = result["data"][0]['Payor'][i]['hiscadit'].split(',');

                                //          for (var d = 0; d < tmp.length; d++) {
                                //             //alert(policyHolder + ' [HD]/' + tmp[d] + '/' + tmp);
                                //             if (tmp[d] == policyHolder) {
                                //                $(".btn_payor[name_payor='" + tmp + "']").find('._st').html('??????????????????');
                                //             }
                                //          }
                                //       }


                                //    }
                                // }
                                // if (tmp[i] == policyHolder) { //?????????????????? dataLastPayorAll ????????? Payor ?????? ??????????????????????????????????????? ????????????????????? ??????????????????
                                //     $(".btn_payor[name_payor='" + tmp + "']").css({
                                //         'background': 'green'
                                //     });
                                // }

                            }
                        },
                        error: function(msg) {
                            console.log(msg);
                        }

                    });
                }
                // if (data != null && data.OfflineMode != null && data.With != 'Appointment') {
                //    checkofflinemode = data.OfflineMode;
                // }
            }
        });




        midSocket.on('payor_data', (result) => {
            // console.log('data get from service');
            // console.log(result);

            // if (result.kiosk_location == kiosk_location) {

            //    console.log(result.kiosk_location + " : " + kiosk_location, 'payor_data');

            //    //////////////     create box payor    /////////////

            //    var HtmlMain = '';
            //    if (result['data'][0]['Payor'].length > 0) {
            //       for (var i = 0; i < result['data'][0]['Payor'].length; i++) {
            //          var openactive = '';
            //          var color = '';
            //          if (result["data"][0]["Payor"][i]["openactive"] === 'Y' && result["data"][0]["Payor"][i]["hiscadit"] == '??????????????????') {
            //             openactive = '?????????????????????????????????????????????';
            //             color = 'background-color:#f7eab5;';
            //          }


            //          if (result["data"][0]["dataLastPayor"] != null) { // ???????????????????????????????????????????????? payor ??????????????????
            //             var policyHolder = result["data"][0]["dataLastPayor"]["policyHolderName"];

            //             if (result["data"][0]['Payor'][i]['hiscadit'] != null) { //????????????????????? payorLast ??????????????? math ????????? payor????????????????????????????????????
            //                var tmp = result["data"][0]['Payor'][i]['hiscadit'].split(',');
            //                for (var d = 0; d < tmp.length; d++) {
            //                   if (result["data"][0]["Payor"][i]["openactive"] === 'Y' && tmp[d] == policyHolder) {
            //                      openactive = '?????????????????????????????????????????????';
            //                      color = 'background-color:#f7eab5;';
            //                   }
            //                }
            //             }
            //          }




            //          HtmlMain += "<button class='col-3 center btn_payor chk_sty' style='outline:none;' active_click=''  name_payor='" + result["data"][0]["Payor"][i]["hiscadit"] + "' value='" + result["data"][0]["Payor"][i]["uid"] + "' check_payor='" + result["data"][0]["Payor"][i]["openactive"] + "'>";
            //          HtmlMain += "<div class='' style='text-align: center;'>";
            //          HtmlMain += "<div class='center div_chk_content d2_lb1' style='' active=''>";
            //          HtmlMain += "<span class='_st'></span>";
            //          HtmlMain += "<a class='chk_font'>" + result["data"][0]["Payor"][i]["name"] + "</a>";
            //          HtmlMain += "</div>";
            //          HtmlMain += "<span class='form-control' style='font-size: 1.2rem; border:none;margin-top: -4px; line-height: 37px; width: 94%; border-radius: 0 0 13px 13px; margin-left: 3%;" + color + "'>" + openactive + "</span>";
            //          HtmlMain += "</div>";
            //          HtmlMain += "</button>";

            //       }
            //    }
            //    $("#area_box_payyor").html(HtmlMain);

            //    //////////////     create box payor    /////////////


            //    // for (var i = 0; i < result["data"][0]['dataLastPayorAll'].length; i++) { // ??????????????????????????? map ???????????????????????????????????? ????????? ?????????????????????????????????????????????????????? ??????????????????????????????????????????

            //    //    var policyHolder = result["data"][0]["dataLastPayorAll"][i]["policyHolder"];

            //    //    for (var i = 0; i < result["data"][0]['Payor'].length; i++) {
            //    //       if (result["data"][0]['Payor'][i]['hiscadit'] != null) {
            //    //          var tmp = result["data"][0]['Payor'][i]['hiscadit'].split(',');

            //    //          for (var d = 0; d < tmp.length; d++) {
            //    //             //alert(policyHolder + ' [HD]/' + tmp[d] + '/' + tmp);
            //    //             if (tmp[d] == policyHolder) {
            //    //                $(".btn_payor[name_payor='" + tmp + "']").find('._st').html('??????????????????');
            //    //             }
            //    //          }
            //    //       }


            //    //    }


            //    // }


            //    // if (tmp[i] == policyHolder) { //?????????????????? dataLastPayorAll ????????? Payor ?????? ??????????????????????????????????????? ????????????????????? ??????????????????
            //    //     $(".btn_payor[name_payor='" + tmp + "']").css({
            //    //         'background': 'green'
            //    //     });
            //    // }

            //    try {
            //       $("#last_payor").val(result["data"][0]['dataLastPayor']['policyHolderName']);
            //    } catch (e) {

            //    }


            // }
        }); // emit payor_data

        /////////////////////////////// end  /////////////////////////////


        var payor_26;
        $("#area_box_payyor").on('click', '.btn_payor', function() {
            payor_active = $(this).val();
            payor_26 = payor_active;



        });





        function no_card_queue() {
            // alert('NoqueueCard');
            $('#close').click(function() {
                $("#md_alert_payor").modal('hide');
            });


            $('#request_queue').click(function() {


                if (payor_active !== '26' && (worklistgroup == '3' || worklistgroup == '13' ||
                        worklistgroup == '23')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '13',
                            oldworklistgroup: '3'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            // alert('1');
                            alert('Here 11');
                            conf_yes();
                        }
                    });
                } else if (payor_active == '26' && (worklistgroup == '3' || worklistgroup == '13' ||
                        worklistgroup == '23')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '23',
                            oldworklistgroup: '3'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            // alert('2');
                            alert('Here 12');
                            conf_yes();
                        }
                    });


                } else if (payor_active !== '26' && (worklistgroup == '1' || worklistgroup == '11' ||
                        worklistgroup == '14' || worklistgroup == '22')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '11',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('N');
                            // conf_yes();
                        }
                    });


                } else if (payor_active == '26' && (worklistgroup == '1' || worklistgroup == '11' ||
                        worklistgroup == '14' || worklistgroup == '22')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '22',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('Here 13');
                            conf_yes();
                        }
                    });

                } else if (payor_active !== '26' && (worklistgroup == '2' || worklistgroup == '12' ||
                        worklistgroup == '15' || worklistgroup == '21')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '12',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('Here 14');
                            conf_yes();
                        }
                    });

                } else if (payor_active == '26' && (worklistgroup == '2' || worklistgroup == '12' ||
                        worklistgroup == '15' || worklistgroup == '21')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '21',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('Here 15');
                            conf_yes();
                        }
                    });
                }


                if (queuelocation == '2') {

                    if (worklistgroup == '1') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '11',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    } else if (worklistgroup == '2') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '12',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('Here 16');
                                conf_yes();
                            }
                        });
                    }



                }








                //logpayor($("#hiscode_se").val(),null);//??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                // window.location.href = next_to_pcc;
                $.ajax({ //create session
                    url: UrlBaseCont + '/StepProcessing/CreateSesPagePayor',
                    type: "post",
                    dataType: "json",
                    data: {
                        payor_active: payor_active
                    },
                    success: function(msg) {
                        console.log(msg);

                        $.ajax({
                            url: baseurlMid + '/api/kiosk/ap/appointment',
                            method: "post",
                            dataType: 'json',
                            data: {
                                'requestAP': '1',
                                'location': '5',
                                kiosk_location: kiosk_location
                            },
                            headers: {
                                'Access-Control-Allow-Origin': '*',
                                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                                'Access-Control-Allow-Headers': '*',
                                'Authorization': 'Basic YXJtOjEyMzQ='
                            },
                            success: function(msg) {
                                console.log(msg, 'MSG');
                                if (msg['kiosk_location'] == kiosk_location) {

                                    if (msg['step'] == 'next6') { //????????????????????????


                                        $.ajax({ //create session
                                            url: UrlBaseCont +
                                                '/StepProcessing/CreatePtAppointment',
                                            type: "post",
                                            dataType: "json",
                                            data: {
                                                appointment: '0'
                                            },
                                            success: function(msg) {
                                                window.location.href =
                                                    NextToPccSv;
                                            }
                                        });


                                    } else if (msg['step'] == 'next5') { //???????????????
                                        //??????????????????
                                    }
                                }
                            },
                            error: function(msg) {
                                console.log(msg);
                            }

                        }); //ajax
                    } //success
                });
            });
            // conf_yes();
        }


        var next_to_pcc = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;

        // ?????????????????????????????? payor
        $("#conf_yes").click(function() {
            // alert(worklistgroup);

            if ($(".btn_payor[active_click='active']").length == 0) {
                $("#content_show_md").html('?????????????????????????????????????????????????????????????????????');
                $("#md_alert_scan").modal('show');
                return false;
            }
            var queuelocation = <?php echo json_encode($this->session->userdata('queuelocation')); ?>;
            var hiscode_tem = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
            var last_payor_tem = $("#last_payor").attr('data-policyholderid');
            console.log('hiscode_tem ' + hiscode_tem);
            console.log('last_payor_tem ' + last_payor_tem);

            // alert(hiscode_tem);
            // alert(payor_active);

            if (payor_active == '') {
                $("#content_show_md").html('?????????????????????????????????????????????????????????????????????');
                $("#md_alert_scan").modal('show');
                return false;
            }
            alert('Worklist Group'+worklistgroup);
            // offline mode pat
            $.ajax({
                url: UrlBaseCont + '/StepProcessing/callsesoffline',
                type: "post",
                dataType: 'json',
                async: false,
                success: function(data) {
                    console.log('offline test');
                    // console.log(data);
                    // alert(data);
                    // if(data){

                    if ((worklistgroup == "3" || worklistgroup == "13" || worklistgroup == "23") && last_payor_tem == "" && payor_active == "26") {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '23',
                                oldworklistgroup: '3'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('Here 17');
                                // conf_yes();
                            }
                        });
                    } else if ((worklistgroup == "3" || worklistgroup == "13" || worklistgroup == "23") && last_payor_tem == "" && payor_active == "25" || payor_active == "24" || payor_active == "23") {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '13',
                                oldworklistgroup: '3'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');

                            }
                        });
                        alert('Here 18');
                        // conf_yes();
                    }
                }
                // }
            });
            // end offline mode pat





            var tem_math = '';
            if (last_payor_tem) { //????????????????????????????????? last
                $.each(hiscode_tem, function(index, value) {
                    if (last_payor_tem != value) {} else if (last_payor_tem == value) {
                        tem_math = 'math';
                    }
                });
            }
            alert('Payor Active :'+payor_active);

            if (payor_active == '25' && worklistgroup !== '3' && list_holderid && list_holderid.indexOf(
                    '52') !== -1 && tem_math == '') {
                //     if(check_scan=='true' ){
                //  alert('true1');

                if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                        22) && (payor_active == 25)) {
                    // alert('????????????????????????????????????');

                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '11',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //  conf_yes();
                        }
                    });
                }
                if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                        21) && (payor_active == 25)) {
                    // alert('????????????????????????????????????');

                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '12',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //  conf_yes();
                        }
                    });
                }
                alert('Here 19');

                conf_yes();



                if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                        22) && (payor_active == 24)) {
                    // alert('????????????????????????????????????');

                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '14',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //  conf_yes();
                        }
                    });
                }
                if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                        21) && (payor_active == 24)) {
                    // alert('????????????????????????????????????');

                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '15',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //  conf_yes();
                        }
                    });
                }
            } else {


                // ?????????????????????????????? api ?????????????????????????????????????????????????????????
                if (tem_math == 'math' && (payor_active == '23' || payor_active == '24')) {

                    if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                            22) && (payor_active == 23 || payor_active == 24 || payor_active == 25 || payor_active == 26)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '14',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }

                    if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                            21) && (payor_active == 23 || payor_active == 24 || payor_active == 25 || payor_active == 26)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '15',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }



                    alert('Here');
                    conf_yes();
                } else if (payor_active == '25' || payor_active == '26') {


                    if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                            22) && (payor_active == 23 || payor_active == 24 || payor_active == 25)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '11',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }

                    if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                            22) && (payor_active == 26)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '22',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }


                    if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                            21) && (payor_active == 23 || payor_active == 24 || payor_active == 25)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '15',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }

                    if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                            22) && (payor_active == 26)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '21',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    }


                    alert('Here 1');
                    conf_yes();

                } else {

                    alert('adsfasdfasdfasfdsadfasdfasdf');
                    //    if(check_scan=='true'){


                    var payor_auto = $(".btn_payor[active_click='active']").attr('payor_auto');
                    var hiscode = $(".btn_payor[active_click='active']").attr('hiscode');
                    // alert('api'+idcard_sess+'hn:'+hn_sess+'hiscode:'+hiscode+'worklist :'+worklistgroup+'payor_auto :'+payor_auto);
                    // alert(hiscode+'scan true ??????');
                    if (list_holderid.indexOf(hiscode) != -1) {



                        // }else{


                        if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                                22) && (payor_active == 26)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '22',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }


                        if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 || worklistgroup ==
                                22) && (payor_active == 23 || payor_active == 24 || payor_active == 25)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '11',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }



                        if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                                21) && (payor_active == 26)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '21',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }


                        if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 || worklistgroup ==
                                21) && (payor_active == 23 || payor_active == 24 || payor_active == 25)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '12',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }

                        if ((worklistgroup == 3 || worklistgroup == 13 || worklistgroup == 23) && (payor_active == 26)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '23',
                                    oldworklistgroup: '3'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }


                        if ((worklistgroup == 3 || worklistgroup == 13 || worklistgroup == 23) && (payor_active == 23 || payor_active == 24 || payor_active == 25)) {
                            // alert('????????????????????????????????????');

                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '13',
                                    oldworklistgroup: '3'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                        alert(worklistgroup);

                        if (payor_active == 24 || payor_active == 23) {
                            alert('??????????????????????????????');
                            $.ajax({ //???????????? api ????????????????????????????????????????????? ??????????????????last  ?????? ??????????????????????????????

                                url: baseurlMid +
                                    '/api/kiosk/creditmaster/open/credit',
                                method: "post",
                                dataType: 'json',
                                data: {
                                    postCredit: '1',
                                    // pid: idcard_sess,
                                    // hn: hn_sess,
                                    // p_opd: null,
                                    // p_patient_type_id: null,
                                    // p_credit_id: hiscode,
                                    // worklistgroup: worklistgroup,
                                    // payor_auto: payor_auto
                                },
                                headers: {
                                    'Access-Control-Allow-Origin': '*',
                                    'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                                    'Access-Control-Allow-Headers': '*',
                                    // 'Content-Type': 'application/json',
                                    'Authorization': 'Basic YXJtOjEyMzQ='
                                },
                                success: function(data) {
                                    console.log(data, 'check api auto');
                                    alert('??????????????????');
                                    if (data.success == false) {
                                        logpayor($("#hiscode_se").val(),
                                            'apifail'
                                        ); //??????????????????????????? / ??????????????? auto ?????????????????????
                                        openqueue_fail();
                                    } else if (data.success == true) {
                                        logpayor($("#hiscode_se").val(),
                                            'apitrue'
                                        ); //??????????????????????????? / ??????????????? auto ????????????
                                        openqueue_success();
                                        alert('success');
                                    }
                                }
                            });
                        }else{
                            // conf_yes();
                        }

                        // }





                        

                        // conf_yes(); /asdfasdfasdfasdf
                        // }



                    } else if (check_scan == 'false' && payor_active == '24' && hiscode) {
                        var html = '';
                        html += "<div class='col-12 center'>";
                        html +=
                            "<button class='d2_2_b2 center' type='button' id='request_queue'> ??????????????????????????? ??????????????????????????????????????????</button>";
                        html += "</div>";
                        html += "<div class='col-12 center' style='margin-top: 2rem;'>";
                        html +=
                            "<button class='welno_no again_payor center' type='button' id='close' style='margin-buttom:20ex;'>????????????????????????</button>";
                        html += "</div>";

                        $("#md_alert_payor").modal('show');
                        $(".text_head").html('???????????????????????????????????????????????????????????????<br/>?????????????????????????????????????????????????????????').css({
                            'font-size': '4vw'
                        });
                        $(".logo_alert_img2").html(
                            '<?= single_img('kiosk/resources/images/icon/cardin.png', array('style' => 'height:400.63px;display:block;margin-top:9rem;')) ?>'
                        );
                        $("#list_btn_payor").html(html);
                        no_card_queue();
                    }
                    // alert('alert ??????????????????');

                }
            }
            // alert(check_scan);
            if (check_scan == 'false') {


                // alert('worklistgroup'+worklistgroup);
                // alert(check_patient_type);
                createpageRedirect();
                var check_click_box = '';
                $(".div_chk_content ").each(function() {
                    if ($(this).attr('active') != '') {
                        check_click_box = 'click';
                    }
                });



                if (queuelocation == '2') {



                    // alert('???????????????????????????location');
                    // alert('payor'+payor_active);
                    alert('temmath '+tem_math);

                    // alert('worklistgroup'+worklistgroup);

                    if ((worklistgroup == 3 || worklistgroup == 13 || worklistgroup == 23) && tem_math == '' &&
                        (payor_active == 23 || payor_active == 24)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '13',
                                oldworklistgroup: '3'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('A');
                                conf_yes();
                            }
                        });
                    } else if ((worklistgroup == 1 || worklistgroup == 11 || worklistgroup == 14 ||
                            worklistgroup == 22) && tem_math == '' && (payor_active == 23 || payor_active ==
                            24)) {
                        // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '11',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    } else if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 ||
                            worklistgroup == 21) && tem_math == '' && (payor_active == 23 || payor_active ==
                            24)) {
                        //                   // alert('????????????????????????????????????');

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '12',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    } else if (payor_active !== '26' && (worklistgroup == '3' || worklistgroup == '13' ||
                            worklistgroup == '23')) {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '13',
                                oldworklistgroup: '3'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });
                    } else if (payor_active == '26' && (worklistgroup == '3' || worklistgroup == '13' ||
                            worklistgroup == '23')) {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '23',
                                oldworklistgroup: '3'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('B');
                                conf_yes();
                            }
                        });



                    } else if (payor_active == '26' && (worklistgroup == '1' || worklistgroup == '11' ||
                            worklistgroup == '14' || worklistgroup == '22')) {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '22',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('C');
                                conf_yes();
                            }
                        });
                    } else if (payor_active == '26' && (worklistgroup == '2' || worklistgroup == '12' ||
                            worklistgroup == '15' || worklistgroup == '21')) {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '21',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                alert('D');
                                conf_yes();
                            }
                        });

                    } else if ((worklistgroup == 1 || worklistgroup == '11' || worklistgroup == 14 ||
                            worklistgroup == '22') && payor_active == 23 && tem_math == 'math') {
                        // alert('text ??????????????????????????????');
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '14',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });



                    } else if ((worklistgroup == 1 || worklistgroup == '11' || worklistgroup == 14 ||
                            worklistgroup == '22') && payor_active == 24 && tem_math == 'math') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '14',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });

                    } else if (worklistgroup == 1 && payor_active == 23 && tem_math == 'math') {

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '14',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });

                    } else if ((worklistgroup == '11' || worklistgroup == 1) && (payor_active == 24 ||
                            payor_active == 25 || payor_active == 23)) {

                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '11',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });


                    } else if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 ||
                            worklistgroup == '21') && payor_active == 23 && tem_math == 'math') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '15',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });

                    } else if ((worklistgroup == 2 || worklistgroup == 12 || worklistgroup == 15 ||
                            worklistgroup == '21') && payor_active == 24 && tem_math == 'math') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '15',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                // conf_yes();
                            }
                        });


                    } else if (tem_math !== '') { //????????????????????????????????? last




                        alert('Tem_mat '+ tem_math);

                        if (worklistgroup == '2') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '15',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    alert('E');
                                    conf_yes();
                                }
                            });
                        } else if (worklistgroup == '1' || worklistgroup == '22') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '14',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                    } else if (tem_math == '') { //????????????????????????????????? last


                        if ((worklistgroup == 2 || worklistgroup == '12' || worklistgroup == '15' ||
                                worklistgroup == '21') && (payor_active == '24' || payor_active == '25')) {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '12',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                        if ((worklistgroup == '12' || worklistgroup == '15') && payor_active == '26') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '21',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                        if ((worklistgroup == '21') && payor_active == '26') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '15',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                        if ((worklistgroup == '1' || worklistgroup == '11' || worklistgroup == '14' ||
                                worklistgroup == '22') && (payor_active == '24' || payor_active == '25')) {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '11',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }
                        if ((worklistgroup == '11' || worklistgroup == '14') && payor_active == '26') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '22',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    // conf_yes();
                                }
                            });
                        }

                        if ((worklistgroup == '11' || worklistgroup == '14') && payor_active == '23') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '14',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    alert('G');
                                    conf_yes();
                                }
                            });
                        }



                        if (worklistgroup == '2') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '12',
                                    oldworklistgroup: '2'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    alert('H');
                                    conf_yes();
                                }
                            });
                        } else if (worklistgroup == '1') {
                            $.ajax({ //create session user info
                                url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                                type: "post",
                                dataType: "json",
                                data: {
                                    worklistgroup: '11',
                                    oldworklistgroup: '1'
                                },
                                success: function(msg) {
                                    console.log(msg, 'update userinfo worklistgroup');
                                    alert('WWW');
                                    // conf_yes();
                                }
                            });
                        }

                    }
                }





                
                if (check_patient_type == '3') { //????????????????????????????????? ????????????????????????????????????????????????????????????????????????



                    alert('I');
                    conf_yes();
                } else {

                    var payoruid = $(".btn_payor[active_click='active']").val();
                    var btn_payor_active = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
                    var last_payor = $("#last_payor").attr('data-policyholderid'); //????????? last
                    var payor_auto = $(".btn_payor[active_click='active']").attr('payor_auto');
                    var hiscode = $(".btn_payor[active_click='active']").attr('hiscode');
                    if ($(".btn_payor[active_click='active']").attr('check_payor') == 'Y' && $(
                            ".btn_payor[active_click='active']").attr('payor_auto') != '' && checkofflinemode ==
                        '') { // ????????????/????????? ?????????????????????????????????????????? click payor ????????????????????? ??????????????????????????????????????????????????????

                        $.each(btn_payor_active, function(index, value) {

                            if (value !=
                                last_payor) { //?????????????????????????????? ??????????????????????????? ???????????????????????????????????? ?????????????????? ????????????????????????????????????

                                if (check_scan == 'false' && $(".btn_payor[active_click='active']")
                                    .attr('condition') != '' && $(".btn_payor[active_click='active']")
                                    .val() != '23') { //???????????????????????????????????? scan ????????????????????????????????????
                                    //   alert('false1');
                                    console.log('scan false');
                                    logpayor($("#hiscode_se").val(),
                                        'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                                    var html = '';
                                    html += "<div class='col-12 center'>";
                                    html +=
                                        "<button class='d2_2_b2 center' type='button' id='request_queue'> ??????????????????????????? ??????????????????????????????????????????</button>";
                                    html += "</div>";
                                    html += "<div class='col-12 center' style='margin-top: 2rem;'>";
                                    html +=
                                        "<button class='welno_no again_payor center' type='button' id='' style='margin-buttom:20ex;'>????????????????????????</button>";
                                    html += "</div>";

                                    $("#md_alert_payor").modal('show');
                                    $(".text_head").html(
                                        '???????????????????????????????????????????????????????????????<br/>?????????????????????????????????????????????????????????').css({
                                        'font-size': '4vw'
                                    });
                                    // $(".text_footer").html('???????????????????????????????????????/????????????????????????????????? ???????????????????????????');
                                    $("#list_btn_payor").html(html);
                                    $(".logo_alert_img2").html(
                                        '<?= single_img('kiosk/resources/images/icon/cardin.png', array('style' => 'height:400px;display:block;')) ?>'
                                    );
                                    btn_click();

                                } else if (check_scan == 'true' && $(
                                        ".btn_payor[active_click='active']").attr('condition') != '' &&
                                    $(".btn_payor[active_click='active']").val() != '23'
                                ) { //???????????????????????????????????? scan ??????????????????????????????
                                    //   alert('true2');
                                    if (idcard_sess == idcard_sess) { //???????????? ?????????????????? sess = ?????????
                                        $.ajax({ //???????????? api ????????????????????????????????????????????? ??????????????????last  ?????? ??????????????????????????????

                                            url: baseurlMid +
                                                '/api/kiosk/creditmaster/open/creditxxx',
                                            method: "post",
                                            dataType: 'json',
                                            data: {
                                                postCredit: '1',
                                                pid: idcard_sess,
                                                hn: hn_sess,
                                                p_opd: null,
                                                p_patient_type_id: null,
                                                p_credit_id: hiscode,
                                                worklistgroup: worklistgroup,
                                                payor_auto: payor_auto
                                            },
                                            headers: {
                                                'Access-Control-Allow-Origin': '*',
                                                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                                                'Access-Control-Allow-Headers': '*',
                                                // 'Content-Type': 'application/json',
                                                'Authorization': 'Basic YXJtOjEyMzQ='
                                            },
                                            success: function(data) {
                                                console.log(data, 'check api auto');
                                                if (data.success == false) {
                                                    logpayor($("#hiscode_se").val(),
                                                        'apifail'
                                                    ); //??????????????????????????? / ??????????????? auto ?????????????????????
                                                    openqueue_fail();
                                                } else if (data.success == true) {
                                                    logpayor($("#hiscode_se").val(),
                                                        'apitrue'
                                                    ); //??????????????????????????? / ??????????????? auto ????????????
                                                    openqueue_success();
                                                    // alert('success');
                                                }
                                            }
                                        });


                                    } else if (idcard_sess != idcard_sess) { //???????????? ?????????????????? sess = ??????????????????
                                        //  alert('??????????????????????????????');
                                        logpayor($("#hiscode_se").val(),
                                            'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                                        card_fail();
                                    }
                                } else if (check_scan == 'true' || check_scan == 'false' && $(
                                        ".btn_payor[active_click='active']").attr('condition') != '' &&
                                    $(".btn_payor[active_click='active']").val() == '23') {
                                    //   alert('true3&false1');
                                    console.log('auto 23');
                                    if (idcard_sess == idcard_sess) { //???????????? ?????????????????? sess = ?????????
                                        $.ajax({ //???????????? api ????????????????????????????????????????????? ??????????????????last  ?????? ??????????????????????????????

                                            url: baseurlMid +
                                                '/api/kiosk/creditmaster/open/creditxxx',
                                            method: "post",
                                            dataType: 'json',
                                            data: {
                                                postCredit: '1',
                                                pid: idcard_sess,
                                                hn: hn_sess,
                                                p_opd: null,
                                                p_patient_tyopenqueue_failpe_id: null,
                                                p_credit_id: hiscode,
                                                worklistgroup: worklistgroup,
                                                payor_auto: payor_auto
                                            },
                                            headers: {
                                                'Access-Control-Allow-Origin': '*',
                                                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                                                'Access-Control-Allow-Headers': '*',
                                                'Authorization': 'Basic YXJtOjEyMzQ=',
                                                // 'Content-Type': 'application/json'
                                            },
                                            success: function(data) {
                                                console.log(data, 'check api auto');
                                                if (data.success == false) {
                                                    logpayor($("#hiscode_se").val(),
                                                        'apifail'
                                                    ); //??????????????????????????? / ??????????????? auto ?????????????????????
                                                    alert('Here 144');
                                                    openqueue_fail();
                                                    // alert('fail');
                                                } else if (data.success == true) {
                                                    logpayor($("#hiscode_se").val(),
                                                        'apitrue'
                                                    ); //??????????????????????????? / ??????????????? auto ????????????
                                                    if ($("#hiscode_se").val() == $(
                                                            '#last_payor').attr(
                                                            'data-policyholderid')) {
                                                                alert('J');
                                                        conf_yes();
                                                    } else {
                                                        openqueue_success();
                                                    }


                                                    // alert('success');
                                                }
                                            }
                                        });


                                    } else if (idcard_sess != idcard_sess) { //???????????? ?????????????????? sess = ??????????????????
                                        //  alert('??????????????????????????????');
                                        logpayor($("#hiscode_se").val(),
                                            'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                                        card_fail();
                                    }
                                } else if ($(".btn_payor[active_click='active']").attr('condition') ==
                                    '') {
                                    logpayor($("#hiscode_se").val(),
                                        'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                                    // conf_yes();
                                }
                            } else if (value ==
                                last_payor) { //?????????????????????????????? ?????????????????? ??????????????????????????????????????? ?????????????????? ????????????????????????????????????
                                // alert('?????????????????? ????????? auto');
                                logpayor($("#hiscode_se").val(),
                                    'apitrue'); //??????????????????????????? / ??????????????? auto ????????????
                                if ($("#hiscode_se").val() == $('#last_payor').attr(
                                        'data-policyholderid')) {
                                    // conf_yes();
                                    alert('THISSSSSS');
                                } else {
                                    openqueue_success();
                                }

                                // openqueue_success();
                                // $("#queue_next").trigger('click');
                                // conf_yes();
                            }
                        });

                        // openqueue_success();
                        // $("#queue_next").trigger('click');

                    }
                    // else if ($(".btn_payor[active_click='active']").attr('check_payor') == 'Y' && $(".btn_payor[active_click='active']").val() == '23') {

                    //    openqueue_success();
                    //    // $("#queue_next").trigger('click');
                    // }
                    else if (($(".btn_payor[active_click='active']").attr('check_payor') == 'N' || $(
                            ".btn_payor[active_click='active']").attr('check_payor') == 'Y') && worklistgroup !=
                        '3' && checkofflinemode == ''
                    ) { // [?????????????????? ??????????????????????????????????????????]  ???????????? ???????????? ?????????????????????????????? ???????????? y ??????????????????????????????????????????????????????????????? ???????????????????????????

                        $.each(btn_payor_active, function(index, value) {
                            if (last_payor == '' || last_payor != value) {
                                logpayor($("#hiscode_se").val(),
                                    'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                                // conf_yes();
                                alert('Each BTN LAST PAYOR')
                            } else if (last_payor != '' && value != '' && last_payor == value) {
                                alert('Here 146');
                                logpayor($("#hiscode_se").val(),
                                    'apitrue'); //??????????????????????????? / ??????????????? auto ????????????
                                openqueue_success();
                                // $("#queue_next").trigger('click');
                            }
                        });
                    } else if (($(".btn_payor[active_click='active']").attr('check_payor') == 'N' || $(
                            ".btn_payor[active_click='active']").attr('check_payor') == 'Y') &&
                        checkofflinemode != '') {
                        // alert('offf?????????????????????');
                        alert('Here 145');
                        logpayor($("#hiscode_se").val(), 'null'); //??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
                        // conf_yes();
                    }
                } //else

            }else{
                alert('Check Scan');
            }
        });


        function conf_yes() {
            // alart($(this).arr)
            var check_click_box = '';
            $(".div_chk_content ").each(function() {
                if ($(this).attr('active') != '') {
                    check_click_box = 'click';
                }
            });

            if (check_click_box == '') {
                $("#content_show_md").html('?????????????????????????????????????????????????????????????????????');
                $("#md_alert_scan").modal('show');
                return false;
            }





            $.ajax({ //create session
                url: UrlBaseCont + '/StepProcessing/CreateSesNumberPageUpdate',
                type: "post",
                dataType: "json",
                data: {
                    pagenow: (parseInt(list_num_pagenow) + 1)
                },
                success: function(msg) {
                    console.log(msg, '??????????????????');
                },
                error: function(msg) {
                    console.log(msg, 'error');
                }
            });
            // alert(payor_active);
            //logpayor($("#hiscode_se").val(),null);//??????????????????????????? / ??????????????? ???????????????????????? ????????? auto
            // window.location.href = next_to_pcc;
            $.ajax({ //create session
                url: UrlBaseCont + '/StepProcessing/CreateSesPagePayor',
                type: "post",
                dataType: "json",
                data: {
                    payor_active: payor_active
                },
                success: function(msg) {
                    console.log(msg);

                    $.ajax({
                        url: baseurlMid + '/api/kiosk/ap/appointment',
                        method: "post",
                        dataType: 'json',
                        data: {
                            'requestAP': '1',
                            'location': '5',
                            kiosk_location: kiosk_location
                        },
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                            'Access-Control-Allow-Headers': '*',
                            'Authorization': 'Basic YXJtOjEyMzQ='
                        },
                        success: function(msg) {
                            console.log(msg, 'MSG');
                            if (msg['kiosk_location'] == kiosk_location) {

                                if (msg['step'] == 'next6') { //????????????????????????


                                    $.ajax({ //create session
                                        url: UrlBaseCont +
                                            '/StepProcessing/CreatePtAppointment',
                                        type: "post",
                                        dataType: "json",
                                        data: {
                                            appointment: '0'
                                        },
                                        success: function(msg) {
                                            window.location.href = NextToPccSv;
                                        }
                                    });


                                } else if (msg['step'] == 'next5') { //???????????????
                                    //??????????????????
                                }
                            }
                        },
                        error: function(msg) {
                            console.log(msg, 'detail');
                        }

                    }); //ajax
                } //success
            });
        } //function

        var databtn_payor = '';
        $("#area_box_payyor").on('click', '.btn_payor', function() {

            EventTimeout = 0; // check redirect

            databtn_payor = $(this).val();

            $(".btn_payor").find('div').find('.d2_lb1').css({
                'background-color': '',
                'color': 'black',
                'position': 'relative',
                'z-index': '1015'
            }).attr('active', '');
            $(".btn_payor").attr('active_click', '');

            $(this).find('div').find('.d2_lb1').css({
                'background-color': '#78b3a3',
                'color': 'white'
            }).attr('active', 'now');
            $(this).attr('active_click', 'active');

            $("#hiscode_se").val($(this).attr('hiscode'));
            $("#payorauto_se").val($(this).attr('payor_auto'));
        });

        function openqueue_success() {
            var html = '';
            html += "<div class='col-12 center'>";
            html +=
                "<button class='d2_2_b2 center' type='button' id='queue_next' style='margin-buttom:20ex;'> ???????????????</button>";
            html += "</div>";

            $("#md_alert_payor").modal('show');
            $(".text_head").html('?????????????????????????????????????????????!').css({
                'font-size': '80px',
                'margin-top': '0'
            });
            //  $(".text_footer").html('???????????????????????????????????????????????????????????????').css('margin-top', '4em');
            $("#list_btn_payor").html(html);
            $(".logo_alert_img2").html(
                '<?= single_img('kiosk/resources/images/icon/G2.png', array('style' => 'height:230.63px;display:block;margin-top:9rem;')) ?>'
            );

            btn_click();
        }

        function openqueue_fail() {
            var html = '';
            html += "<div class='col-12 center'>";
            html +=
                "<button class='d2_2_b2' type='button' id='call_payor_counter'> ??????????????????????????????????????????????????????????????????????????????</button>";
            html += "</div>";
            html += "<div class='col-12 center' style='margin-top: 3.5rem;'>";
            html += "<button class='welno_no again_payor' type='button'>??????????????????????????????</button>";
            html += "</div>";
            $("#md_alert_payor").modal('show');
            $(".text_head").html('?????????????????????????????????????????????????????????!').css('font-size', '80px');;
            $("#list_btn_payor").html(html);
            $(".logo_alert_img2").html(
                '<?= single_img('kiosk/resources/images/icon/X.png', array('style' => 'height:248px;display:block;')) ?>'
            );

            $('.again_payor').click(function() {

                $("#md_alert_payor").modal('hide');
            });
            $('#call_payor_counter').click(function() {
                $('#md_alert_payor').modal('hide');
                if ((worklistgroup == '1' || worklistgroup == '11' || worklistgroup == '14' || worklistgroup ==
                        '22') && (payor_active == '23' || payor_active == '24')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '11',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('Here 7');
                            conf_yes();
                            var NextToPccSv = baselocal +
                                <?php echo Modules::run('Websocket/NextToProcessService') ?>;
                            window.location.href = NextToPccSv;
                        }
                    });
                } else if ((worklistgroup == '2' || worklistgroup == '12' || worklistgroup == '15' ||
                        worklistgroup == '21') && (payor_active == '23' || payor_active == '24')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '12',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            alert('Here 148');
                            conf_yes();
                            var NextToPccSv = baselocal +
                                <?php echo Modules::run('Websocket/NextToProcessService') ?>;
                            window.location.href = NextToPccSv;
                        }
                    });
                }
                var NextToPccSv = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;
                window.location.href = NextToPccSv;

            });


            // btn_click();
        }

        function card_fail() {

            var html = '';
            html += "<div class='col-12 center'>";
            html +=
                "<button class='d2_2_b2' type='button' id='call_payor_counter'> ??????????????????????????????????????????????????????????????????????????????</button>";
            html += "</div>";
            html += "<div class='col-12 center' style='margin-top: 3.5rem;'>";
            html += "<button class='welno_no again_payor' type='button'>??????????????????????????????</button>";
            html += "</div>";

            $("#md_alert_payor").modal('show');
            $(".text_head").html('???????????????????????????????????????????????????<br/>?????????????????????????????? !').css('font-size', '80px');;
            $("#list_btn_payor").html(html);
            $(".logo_alert_img2").html(
                '<?= single_img('kiosk/resources/images/icon/discard.png', array('style' => 'height:248px;display:block;')) ?>'
            );

            btn_click();
        }

        var NextToPccSv = baselocal + <?php echo Modules::run('Websocket/NextToProcessService') ?>;


        function btn_click() {

            $(".again_payor").click(function() {

                EventTimeout = 0; // check redirect

                $("#md_alert_payor").modal('hide');

                $(".btn_payor").find('div').find('.d2_lb1').css({
                    'background-color': '',
                    'color': 'black',
                    'position': 'relative',
                    'z-index': '1015'
                }).attr('active', '');
                $(".btn_payor").attr('active_click', '');
            });


            $("#request_queue").click(function() {

                EventTimeout = 0; // check redirect

                $("#md_alert_payor").modal('hide');
                //$("#conf_yes").trigger('click');
                no_card_queue(); //??????????????????????????????????????????????????????
                // conf_yes();

                // var name_payor = $(this).attr('name_payor');
                // var payoruid = $(this).val();
                // $.ajax({
                //     url: baseurlMid + '/api/kiosk/oc/openconverage',
                //     method: "post",
                //     dataType: 'json',
                //     headers: {
                //         'Access-Control-Allow-Origin': '*',
                //         'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                //         'Access-Control-Allow-Headers': '*',
                //         'Authorization': 'Basic YXJtOjEyMzQ='
                //     },
                //     data: {
                //         idcard: idcard_sess,
                //         hn: hn_sess,
                //         payorcode: '???????????????????????????',
                //         payorname: name_payor,

                //     },
                //     success: function(msg) {
                //         console.log(msg, 'openconverage');
                //         if (msg.status == true) { //????????????????????????????????????????????????
                //             openqueue_success();
                //         } else if (msg.status == false) { //?????????????????????????????????????????????????????????
                //             openqueue_fail();
                //         }
                //     },
                //     error: function(msg) {
                //         console.log(msg);
                //     }

                // });


            });

            $("#call_payor_counter").click(function() {

                EventTimeout = 0; // check redirect

                $("#md_alert_payor").modal('hide');

                if ((worklistgroup == '1' || worklistgroup == '11' || worklistgroup == '14' || worklistgroup ==
                        '22') && (payor_active == '23' || payor_active == '24')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '11',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            // conf_yes();

                            var NextToPccSv = baselocal +
                                <?php echo Modules::run('Websocket/NextToProcessService') ?>;
                            window.location.href = NextToPccSv;
                        }
                    });
                } else if ((worklistgroup == '2' || worklistgroup == '12' || worklistgroup == '15' ||
                        worklistgroup == '21') && (payor_active == '23' || payor_active == '24')) {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '12',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            // conf_yes();
                            var NextToPccSv = baselocal +
                                <?php echo Modules::run('Websocket/NextToProcessService') ?>;
                            window.location.href = NextToPccSv;
                        }
                    });
                }



                //$("#conf_yes").trigger('click');

                // conf_yes();
            });



            $("#queue_next").click(function() {
                EventTimeout = 0; // check redirect


                var hiscode_tem = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
                var last_payor_tem = $("#last_payor").attr('data-policyholderid');

                var apitrue = $("#hiscode_se").val();
                // alert(apitrue);
                $("#md_alert_payor").modal('hide');
                //goto stepprocessing
                // alert(worklistgroup);

                if (payor_active == '23' || payor_active == '24' && worklistgroup == '1' || worklistgroup ==
                    '11' || worklistgroup == '14' || worklistgroup == '22') {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '14',
                            oldworklistgroup: '1'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //$("#conf_yes").trigger('click');
                            alert('Here 4');
                            conf_yes();
                        }
                    });
                } else if (payor_active == '23' || payor_active == '24' && worklistgroup == '2' ||
                    worklistgroup == '12' || worklistgroup == '15' || worklistgroup == '21') {
                    $.ajax({ //create session user info
                        url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                        type: "post",
                        dataType: "json",
                        data: {
                            worklistgroup: '15',
                            oldworklistgroup: '2'
                        },
                        success: function(msg) {
                            console.log(msg, 'update userinfo worklistgroup');
                            //$("#conf_yes").trigger('click');
                            alert('Here 5');
                            conf_yes();
                        }
                    });
                }









                var tem_math = '';

                if (last_payor_tem) { //????????????????????????????????? last
                    $.each(hiscode_tem, function(index, value) {
                        if (last_payor_tem != value) {} else if (last_payor_tem == value) {
                            tem_math = 'math';
                        }
                    });
                }

                if (tem_math == '') { //???????????????????????? ?????????????????? last

                    if (payor_active == '26' && worklistgroup == '1') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '22',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                //$("#conf_yes").trigger('click');
                                alert('Here 6');
                                conf_yes();
                            }
                        });

                    } else if (payor_active == '26' && worklistgroup == '2') {
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '21',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                //$("#conf_yes").trigger('click');
                                alert('Here 7');
                                conf_yes();
                            }
                        });


                    } else if (worklistgroup == '1') { // ??????????????????????????????????????????????????????????????????????????????
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '14',
                                oldworklistgroup: '1'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                //$("#conf_yes").trigger('click');
                                alert('Here 8');
                                conf_yes();
                            }
                        });

                    } else if (worklistgroup == '2') { // ??????????????????????????????????????????????????????????????????????????????
                        $.ajax({ //create session user info
                            url: UrlBaseCont + '/StepProcessing/UpdateUserInfo',
                            type: "post",
                            dataType: "json",
                            data: {
                                worklistgroup: '15',
                                oldworklistgroup: '2'
                            },
                            success: function(msg) {
                                console.log(msg, 'update userinfo worklistgroup');
                                //$("#conf_yes").trigger('click');
                                conf_yes();
                            }
                        });
                    }

                }


            });
        } // fn btn_click


        midSocket.on('chk_card_insert', (result) => {
            console.log(result);
            if (result['kiosk_location'] == kiosk_location) {
                var btn_payor_active = $(".btn_payor[active_click='active']").attr('hiscode').split(',');
                var last_payor = $("#last_payor").attr('data-policyholderid'); //????????? last
                var payor_auto = $(".btn_payor[active_click='active']").attr('payor_auto');
                var hiscode = $(".btn_payor[active_click='active']").attr('hiscode');

                if (result['scan_status'] == '2') {
                    if (result['idcard'] != idcard_sess) { //???????????????????????????????????? redirech

                        $("#request_queue").attr('disabled', false).removeClass('d2_3_b2').addClass('d2_2_b2');
                        // console.log('id ???????????????????????????');
                        // window.location.href = UrlBaseKiosk;

                        $("#md_alert_payor").modal('hide');
                        card_fail();

                    } else {

                        $("#request_queue").attr('disabled', false).removeClass('d2_3_b2').addClass('d2_2_b2');
                        $("#md_alert_payor").modal('hide');

                        $.each(btn_payor_active, function(index, value) {
                            if (value != last_payor) { //?????????????????????????????? ??????????????????????????? ???????????????????????????????????? ??????????????????

                                if (idcard_sess == idcard_sess) { //???????????? ?????????????????? sess = ?????????
                                    $.ajax({ //???????????? api ????????????????????????????????????????????? ??????????????????last  ?????? ??????????????????????????????
                                        url: baseurlMid + '/api/kiosk/creditmaster/open/creditxxx',
                                        method: "post",
                                        dataType: 'json',
                                        data: {
                                            postCredit: '1',
                                            pid: idcard_sess,
                                            hn: hn_sess,
                                            p_opd: null,
                                            p_patient_type_id: null,
                                            p_credit_id: hiscode,
                                            worklistgroup: worklistgroup,
                                            payor_auto: payor_auto
                                        },
                                        headers: {
                                            'Access-Control-Allow-Origin': '*',
                                            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                                            'Access-Control-Allow-Headers': '*',
                                            'Authorization': 'Basic YXJtOjEyMzQ=',
                                            // 'Content-Type': 'application/json',
                                        },
                                        success: function(data) {
                                            console.log(data, 'check api auto');
                                            if (data.success == false) {
                                                //alert('?????????????????? ?????????????????? auto api false emit');
                                                logpayor($("#hiscode_se").val(), 'apifail');
                                                openqueue_fail();
                                            } else if (data.success == true) {
                                                //alert('?????????????????? ?????????????????? auto api true emit');
                                                logpayor($("#hiscode_se").val(), 'apitrue');
                                                openqueue_success();
                                            }
                                        }
                                    });


                                } else if (idcard_sess != idcard_sess) { //???????????? ?????????????????? sess = ??????????????????
                                    //alert('??????????????????????????????');
                                    logpayor($("#hiscode_se").val(), 'null');
                                    card_fail();
                                }

                            } else if (value == last_payor) { //?????????????????????????????? ?????????????????? ??????????????????????????????????????? ??????????????????
                                // alert('?????????????????? ????????? auto emit');
                                logpayor($("#hiscode_se").val(), 'apitrue'); //??????????????????????????? / ??????????????? auto ????????????
                                openqueue_success();
                                $("#queue_next").trigger('click');
                                alert('Here 10');
                                conf_yes(); // ????????????????????? log
                            }
                        });
                        // openqueue_success();
                    }
                }
            }
        });

        function logpayor(hiscode, statusauto) {
            $.ajax({
                url: UrlBaseCont + '/StepProcessing/CreateLogPayor',
                type: "post",
                async: false,
                data: {
                    hiscode: hiscode,
                    statusauto: statusauto
                },
                success: function(msg) {
                    console.log('logpayor');

                    console.log(msg);
                }
            });
        }

    }); //document
</script>