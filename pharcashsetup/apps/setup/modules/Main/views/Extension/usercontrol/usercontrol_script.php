<script type="text/javascript">
    $(".option_select2").select2();

    var state_re = 0;
    var groupprocessuid = 6;
    var queuelocationuid = <?= $Data['thisQueuelocation']->locationuid; ?>;
    const refresh_views = () => {
        let view = `./userauthorization_view`;
        if (queuelocationuid) {
            view = `./userauthorization_view_location/${queuelocationuid}`;
        }
        $('#loading').css('display', 'block');
        // $('#usercontrol_div').css('display', 'none');
        $.get({
                url: view,
                cache: false
            })
            .then((response) => {
                // console.log(response.html);
                $('#usercontrol_div').html(response.html);
                $('#loading').css('display', 'none');
                if (state_re == 1) {
                    refresh_dataTable();
                }
            })
            .fail(() => {
                //console.log('no display username');
                $('#usercontrol_div').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }

    const refresh_dataTable = () => {
        $('#usercontrol_div').dataTable();
        $('#usercontrol_div').css('display', 'block');
    }

    $(function() {
        $(document).ready(function() {
            $('#usercontrol_div').dataTable();
            $('#usercontrol_div').css('display', 'block');
        });

        $(document).on('submit', 'form[sub_username_authorization]', function(e) {
            // e.preventDefault();
            $('#usercontrol_div').css('display', 'none');
            let add_user = document.getElementById('Add_un_tb_authorization').value;
            let muser = encodeURIComponent($('#span_Login').text());
            let formURL = `./add_usercontrol/${$(this).attr('action')}`;
            let formData = `username=${add_user}&queuelocationuid=1&muser=${muser}`;
            // console.log('add-username');
            // alert(formData)
            $.post(formURL, formData)
                .always(function() {
                    state_re = 1;
                    var table = $('#usercontrol_div').DataTable();
                    table.destroy();
                    refresh_views();
                });

        });


        // $(document).on('click', '[add_usercontrol]', function(e) {
        //     $("#Add_un_tb_user_auth").attr("action");
        //     let formURL = $(this).attr('action');
        //     let formData = $(this).serialize();
        //     let muser = encodeURIComponent($('#span_Login').text());
        //     formData += `&queuelocationuid=1&muser=${muser}`;
        //     // formURL += `./add_usercontrol`;

        //     // let add_url = `./add_usercontrol`;
        //     // let muser = encodeURIComponent($('#span_Login').text());
        //     // $input = file_get_contents('#Add_un_tb_user_auth');
        //     // let add_data = `username=""&queuelocationuid=1&muser=${muser}`;
        //     console.log('add-username');
        //     $.post(formURL, formData)
        //         .always(function() {
        //             // refresh_views();
        //         });
        // })

        $(document).on('click', '[remove_usercontrol]', function(e) {
            // $(this).closest("tr").remove();
            $('#usercontrol_div').css('display', 'none');
            let remove_url = `./remove_usercontrol/${$(this).attr('remove_usercontrol')}`;
            // console.log('del-username');
            $.get({
                    url: remove_url,
                    cache: false
                })
                .always(function() {
                    state_re = 1;
                    var table = $('#usercontrol_div').DataTable();
                    table.destroy();
                    refresh_views();
                });

        })

        $(document).on('submit', 'form[usercontrol]', function(e) {
            let this_loading = $(this).find('[loading_spin]')
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            this_loading.css('display', 'block');
            $.post(formURL, formData)
                .always(function() {
                    this_loading.css('display', 'none');
                })
            return false;
        });

        $(document).on('change', 'form[usercontrol] select', function(e) {
            $(this).closest('form').submit();
        });

    });
</script>