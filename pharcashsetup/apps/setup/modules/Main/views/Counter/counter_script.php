<script type="text/javascript">
    var groupprocess_dropdown = null;
    const refresh_views = (groupprocessuid) => {
        let view = `./counter_view`;
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
                
                $("#counter_list").sortable({
                    update: function(event, ui) {
                        $('#counter_list [sortcate]').each(function(i) {
                            let update_url = "./update_counter";
                            let update_sort = `uid=${$(this).data('uid')}&sq=${i}`;
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
            $('#counter_modal input[name="uid"]').val('').removeAttr('value');
            $('#counter_modal input#input_uid').removeAttr('name');
            $('#counter_modal form').attr('action','./add_counter');
            $('#counter_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#counter_modal input#input_uid').attr('name','uid');
            let counter_data = `./counter_data/${this_uid}`;
            $.get({
                    url: counter_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#counter_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#counter_modal input[name="computername"]').val(response_data.computername);
                    $('#counter_modal input[name="ipaddress"]').val(response_data.ipaddress);
                    $('#counter_modal input[name="counterno"]').val(response_data.counterno);
                    $('#counter_modal select[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $('#counter_modal select[name="queuelocationuid"]').val(response_data.queuelocationuid);
                    $(`#counter_modal input[name="statusflag"][value="${response_data.statusflag}"]`).prop('checked', true);
                    $('#counter_modal form').attr('action','./update_counter');
                    $('#counter_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','counter').attr('data-delete','counter');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'counter':
                    var delete_url = `./del_counter`;
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

        $(document).on('submit', '#counter_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#counter_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('submit', '#counter_message_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#counter_message_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('hidden.bs.modal', '#counter_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#counter_message_modal', () => {
            refresh_views(groupprocess_dropdown)
        });
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views(groupprocess_dropdown);
        });

    });
</script>