<script type="text/javascript">
    var groupprocessuid = 2;
    var queuelocationuid = <?=$Data['TVQueuelocation']->locationuid;?>;
    const refresh_views = () => {
        let view = `./tv_view`;
        if(queuelocationuid){
            view = `./tv_view_location/${queuelocationuid}`;
        }
        $('#loading').css('display', 'block');
        $.get({
                url: view,
                cache: false
            })
            .then( (response) => {
                $("#show_data").html(response.html);
                $("#select_queuelocation").val(queuelocationuid);
                $('#loading').css('display', 'none');
            })
            .fail( () => {
                $('#show_data').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    const queuecode_dropdown = async () => {        
        let url  = `./get_queuelist`;
        let rawdata = await $.get({url: url,cache: false});
        let data = JSON.parse(rawdata);
        let html = ``;
        html += `<select update_dropdown name="code" class="form-control col" style="font-family: cs_prajad_b;font-size: 18px;">`;
        await data.forEach(
            (element, index, array) => {
                html += `
                <option value="${element.queuecode}">${element.queuecode}</option>
                `;
            });
            html += `</select>`;
        return html;
    }
    const message_modal = (uid) => {
        this_uid = uid;
        let getdata = `./tv_message_data/${this_uid}`;
        $.get({
                url: getdata,
                cache: false
            })
            .then( async (response) => {
                let response_data = await JSON.parse(response);
                let queuedropdown = await queuecode_dropdown();
                let display_html = ``;

                let tv_rawdata = await $.get({url: `./tv_data/${this_uid}`,cache: false});
                let tv_data = JSON.parse(tv_rawdata);
                display_html +=  `
                <!--
                <div class="row">
                    <div class="form-group col" style="font-family: cs_prajad_b;font-size: 18px;">
                        Column
                        <form stop_redirect class="form-horizontal" method="post" enctype="multipart/form-data" action="./update_tv">
                            <input type="hidden" name="uid" class="form-control" style="font-family: cs_prajad_b;font-size: 18px;" value="${tv_data.uid}">
                            <select update_settings name="message_qty" id="settings_select_message_qty" class="form-control" style="font-family: cs_prajad_b;font-size: 18px;" data-uid="${tv_data.uid}">
                `;
                for (let qty_column = 1; qty_column <= 5; qty_column++) {
                    display_html +=`
                                    <option value="${qty_column}" ${response_data.length == qty_column?'selected':''}>${qty_column}</option>
                    `;                        
                }
                display_html += `
                            </select>
                        </form>
                    </div>
                    <div class="form-group col" style="font-family: cs_prajad_b;font-size: 18px;">
                        
                        <form stop_redirect class="form-horizontal" method="post" enctype="multipart/form-data" action="./update_tv">
                            <input type="hidden" name="uid" class="form-control" style="font-family: cs_prajad_b;font-size: 18px;" value="${tv_data.uid}">
                `;
                display_html += `
                        </form>
                    </div>
                </div>
                -->
                `;
                let display_qty = (uid,tvuid) => {
                    html = ``;
                    html += `
                    <form stop_redirect class="form-horizontal" method="post" enctype="multipart/form-data" action="./update_tv_message/${uid}" data-uid="${uid}" data-tvuid= "${tvuid}" data-qty="1">
                        <div class="row">
                            ${queuedropdown}
                            <select update_settings name="qty_row" id="settings_select_qty_row" class="form-control col" style="font-family: cs_prajad_b;font-size: 18px;" data-uid="${tv_data.uid}">
                    `;
                    for (let qty_row = 1; qty_row <= 7; qty_row++) {
                        html +=`
                                <option value="${qty_row}">${qty_row}</option>
                        `;                        
                    }
                    html += `
                            </select>
                            <input type="hidden" name="qty" value="1">
                        </div>
                    </form>
                    `;
                    return html;
                }
                display_html += `
                <div>
                    <div class="row">
                        <div class="col" style="font-family: cs_prajad_b;font-size: 18px;">Queue</div>
                        <div class="col" style="font-family: cs_prajad_b;font-size: 18px;">Row</div>
                    </div>
                `;
                await response_data.forEach((element, index, array) => {
                        display_html += display_qty(element.uid,element.tvuid);
                    });
                display_html += `
                </div>
                `;
                await $('#tv_message_modal #message_display').html(display_html);
                await response_data.forEach((element, index, array) => {
                        $(`form[action="./update_tv_message/${element.uid}"] select[name="code"]`).val(element.code);
                        $(`form[action="./update_tv_message/${element.uid}"] select[name="qty_row"]`).val(element.qty_row);
                    });
                await $('#tv_message_modal').modal('show');
            });
    }
    $( function() {
        //refresh_views();

        $(document).on('click', '[btn-add]', function() {
            $('#tv_modal input[name="uid"]').val('').removeAttr('value');
            $('#tv_modal input#input_uid').removeAttr('name');
            $('#tv_modal form').attr('action','./add_tv');
            $('#tv_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#tv_modal input#input_uid').attr('name','uid');
            let tv_data = `./tv_data/${this_uid}`;
            $.get({
                    url: tv_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#tv_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#tv_modal input[name="tv_description"]').val(response_data.tv_description);
                    $('#tv_modal select[name="message_qty"]').val(response_data.message_qty);
                    $('#tv_modal select[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $('#tv_modal input[name="queuelocationuid"]').val(response_data.queuelocationuid);
                    $(`#tv_modal input[name="status"][value="${response_data.status}"]`).prop('checked', true);
                    $('#tv_modal form').attr('action','./update_tv');
                    $('#tv_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','tv').attr('data-delete','tv');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '[btn-setting]', function() {
            let this_uid = $(this).attr('btn-setting');
            message_modal(this_uid);
        })

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'tv':
                    var delete_url = `./del_tv`;
                    break;            
                default:
                    console.log("Try Again");
                    break;
            }
            if(typeof delete_url !== undefined){
                $.post(delete_url,{uid:uid})
                    .then( (response) => {
                        $('#del_modal').modal('hide');
                    });
            }
            
        })

        $(document).on('submit', '#tv_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            if( $('#tv_modal input[name="uid"]').length == 0 ){
                formData += `&message_row=7`;
            }
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#tv_modal').modal('hide');                                    
                        let triggerURL = `./trigger_tv_update/${groupprocessuid}/${queuelocationuid}/${$('#tv_modal form input[name="uid"]').val()}`;
                        $.get({url:triggerURL,cache:false})
                    });
            return false;
        })

        $(document).on('submit', 'form[stop_redirect]', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
            return false;
        })

        $(document).on('change', '[update_settings]', async function(){
            let this_uid = $(this).data('uid');
            await $(this).closest("form").submit();
            await message_modal(this_uid);
        })

        $(document).on('change', '[update_dropdown]', async function(){
            return false;
            let this_uid = $(this).data('uid');
            await $(this).closest("form").submit();
        })

        $(document).on('click', '[submit_settings]',async function(){
            let thisTVUID = '';
            await $('#tv_message_modal form').each(function(){
                thisTVUID = $(this).data('tvuid');
                $(this).submit();
            });
            let triggerURL = `./trigger_tv_update/${groupprocessuid}/${queuelocationuid}/${thisTVUID}`;
            await $.get({url:triggerURL,cache:false})
            await $('#tv_message_modal').modal('hide');
        })

        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })

        $(document).on('hidden.bs.modal', '#tv_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views();
        });

    });
</script>