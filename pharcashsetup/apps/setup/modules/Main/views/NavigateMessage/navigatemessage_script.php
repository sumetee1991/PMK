<script type="text/javascript">
    var groupprocess_dropdown = 6;
    const refresh_views = (groupprocessuid) => {
        let view = `./navigatemessage_view`;
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
                
                $("#navigatemessage_list").sortable({
                    update: function(event, ui) {
                        $('#navigatemessage_list [sortcate]').each(function(i) {
                            let update_url = "./update_navigatemessage";
                            let update_sort = `uid=${$(this).data('uid')}&sequence=${i}`;
                            $.post(update_url,update_sort);
                        });
                    }
                });
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
            $('#navigatemessage_modal input[name="uid"]').val('').removeAttr('value');
            $('#navigatemessage_modal input#input_uid').removeAttr('name');
            $('#navigatemessage_modal form').attr('action','./add_navigatemessage');
            $('#navigatemessage_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#navigatemessage_modal input#input_uid').attr('name','uid');
            let navigatemessage_data = `./navigatemessage_data/${this_uid}`;
            $.get({
                    url: navigatemessage_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#navigatemessage_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#navigatemessage_modal input[name="message"]').val(response_data.message);
                    $('#navigatemessage_modal input[name="message_description"]').val(response_data.message_description);
                    $('#navigatemessage_modal input[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $(`#navigatemessage_modal input[name="status"][value="${response_data.status}"]`).prop('checked', true);
                    $('#navigatemessage_modal form').attr('action','./update_navigatemessage');
                    $('#navigatemessage_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','navigatemessage').attr('data-delete','navigatemessage');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'navigatemessage':
                    var delete_url = `./del_navigatemessage`;
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

        $(document).on('submit', '#navigatemessage_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#navigatemessage_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('submit', '#navigatemessage_message_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#navigatemessage_message_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('hidden.bs.modal', '#navigatemessage_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#navigatemessage_message_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views(groupprocess_dropdown);
        });

    });
</script>