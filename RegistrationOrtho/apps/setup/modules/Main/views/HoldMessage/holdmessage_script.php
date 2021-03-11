<script type="text/javascript">
    var groupprocess_dropdown = null;
    const refresh_views = (groupprocessuid) => {
        let view = `./holdmessage_view`;
        view += groupprocessuid?`/${groupprocessuid}`:'';
        $('#loading').css('display', 'block');
        $.get({
                url: view,
                cache: false
            })
            .then( (response) => {
                $("#show_data").html(response.html);
                $("#dropdown_groupprocess").val(groupprocessuid);
                $('#loading').css('display', 'none');
            })
            .fail( () => {
                $('#show_data').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    $( function() {
        refresh_views(groupprocess_dropdown);

        $(document).on('change', '#dropdown_groupprocess', function(){
            groupprocess_dropdown = $(this).val();
            refresh_views(groupprocess_dropdown);
        })

        $(document).on('click', '[btn-add]', function() {
            $('#holdmessage_modal input[name="uid"]').val('').removeAttr('value');
            $('#holdmessage_modal input#input_uid').removeAttr('name');
            $('#holdmessage_modal form').attr('action','./add_holdmessage');
            $('#holdmessage_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#holdmessage_modal input#input_uid').attr('name','uid');
            let holdmessage_data = `./holdmessage_data/${this_uid}`;
            $.get({
                    url: holdmessage_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#holdmessage_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#holdmessage_modal input[name="hold_message"]').val(response_data.hold_message);
                    $('#holdmessage_modal input[name="message_description"]').val(response_data.message_description);
                    $('#holdmessage_modal select[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $(`#holdmessage_modal input[name="active"][value="${response_data.active}"]`).prop('checked', true);
                    $('#holdmessage_modal form').attr('action','./update_holdmessage');
                    $('#holdmessage_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','holdmessage').attr('data-delete','holdmessage');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'holdmessage':
                    var delete_url = `./del_holdmessage`;
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

        $(document).on('submit', '#holdmessage_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#holdmessage_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('submit', '#holdmessage_message_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#holdmessage_message_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('hidden.bs.modal', '#holdmessage_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#holdmessage_message_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views(groupprocess_dropdown);
        });

    });
</script>