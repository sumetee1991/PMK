<script type="text/javascript">
    const refresh_views = () => {
        let view = `./ticket_view`;
        $('#loading').css('display', 'block');
        $.get({
                url: view,
                cache: false
            })
            .then( (response) => {
                $("#show_data").html(response.html);
                $('#loading').css('display', 'none');
            })
            .fail( () => {
                $('#show_data').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    $( function() {
        refresh_views();

        $(document).on('click', '[btn-add]', function() {
            $('#ticket_modal input[name="uid"]').val('').removeAttr('value');
            $('#ticket_modal input#input_uid').removeAttr('name');
            $('#ticket_modal form').attr('action','./add_ticket');
            $('#ticket_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#ticket_modal input#input_uid').attr('name','uid');
            let ticket_data = `./ticket_data/${this_uid}`;
            $.get({
                    url: ticket_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#ticket_modal input[name="uid"]').val(this_uid).attr('value', this_uid)
                    $('#ticket_modal input[name="ticket_name"]').val(response_data.ticket_name);
                    $('#ticket_modal input[name="ticket_description"]').val(response_data.ticket_description);
                    $('#ticket_modal select[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $('#ticket_modal select[name="queuelocationuid"]').val(response_data.queuelocationuid);
                    $(`#ticket_modal input[name="active"][value="${response_data.active}"]`).prop('checked', true);
                    $('#ticket_modal form').attr('action','./update_ticket');
                    $('#ticket_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','ticket').attr('data-delete','ticket');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '[btn-message]', function() {
            let this_uid = $(this).attr('message-uid');
            let ticket_message = `./ticket_message/${this_uid}`;
            $('#ticket_message_modal input[name="uid"]').val('').removeAttr('value');
            $('#ticket_message_modal input#minput_uid').removeAttr('name');
            $.get({
                    url: ticket_message,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#ticket_message_modal input#minput_uid').attr('name','uid');
                    $('#ticket_message_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#ticket_message_modal textarea[name="display_message"]').val(response_data.display_message);
                    $('#ticket_message_modal input[name="description"]').val(response_data.description);
                    $('#ticket_message_modal select[name="ticket_uid"]').val(response_data.ticket_uid);
                    $(`#ticket_message_modal input[name="active"][value="${response_data.active}"]`).prop('checked', true);
                    $('#ticket_message_modal form').attr('action','./update_ticket_message');
                })
                .fail( () => {
                    $('#ticket_message_modal form').attr('action','./add_ticket_message');
                })
                .always( () => {
                    $('#ticket_message_modal').modal('show');
                })
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'ticket':
                    var delete_url = `./del_ticket`;
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

        $(document).on('submit', '#ticket_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#ticket_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('submit', '#ticket_message_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#ticket_message_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('hidden.bs.modal', '#ticket_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#ticket_message_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views();
        });

    });
</script>