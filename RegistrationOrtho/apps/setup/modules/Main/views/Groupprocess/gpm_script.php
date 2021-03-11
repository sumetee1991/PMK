<script type="text/javascript">
    const refresh_views = () => {
        let view = `./groupprocess_view`;
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
            $('#groupprocess_modal input[name="uid"]').val('').removeAttr('value');
            $('#groupprocess_modal input#input_uid').removeAttr('name');
            $('#groupprocess_modal form').attr('action','./add_groupprocess');
            $('#groupprocess_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#groupprocess_modal input#input_uid').attr('name','uid');
            let groupprocess_data = `./groupprocess_data/${this_uid}`;
            $.get({
                    url: groupprocess_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#groupprocess_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#groupprocess_modal input[name="tv_message"]').val(response_data.tv_message);
                    $('#groupprocess_modal form').attr('action','./update_groupprocess');
                    $('#groupprocess_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','groupprocess').attr('data-delete','groupprocess');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'groupprocess':
                    var delete_url = `./del_groupprocess`;
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

        $(document).on('submit', '#groupprocess_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#groupprocess_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('hidden.bs.modal', '#groupprocess_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views();
        });

    });
</script>