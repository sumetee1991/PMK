<script type="text/javascript">
    $(".option_select2").select2();

    var state_re = 0;
    var groupprocessuid = 6;
    var queuelocationuid = <?= $Data['thisQueuelocation']->locationuid; ?>;
    const refresh_views = () => {
        let view = `./usercreate_view`;
        if (queuelocationuid) {
            view = `./usercreate_view_location/${queuelocationuid}`;
        }
        $('#loading').css('display', 'block');
        // $('#usercreate_div').css('display', 'none');
        $.get({
                url: view,
                cache: false
            })
            .then((response) => {
                // console.log(response.html);
                $('#usercreate_div').html(response.html);
                $('#loading').css('display', 'none');
                if (state_re == 1) {
                    refresh_dataTable();
                }
            })
            .fail(() => {
                //console.log('no display username');
                $('#usercreate_div').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    const refresh_dataTable = () => {
        $('#usercreate_div').dataTable();
        $('#usercreate_div').css('display', 'block');
    }

    $(function() {
        $(document).ready(function() {
            $('#usercreate_div').dataTable();
            $('#usercreate_div').css('display', 'block');
        });

        $(document).on('submit', 'form[sub_username_auth]', function(e) {
            // e.preventDefault();
            $('#usercreate_div').css('display', 'none');
            let add_user = document.getElementById('Add_un_tb_auth').value;
            let formURL = `./add_usercreate/${$(this).attr('action')}`;
            let formData = `username=${add_user}&queuelocationuid=1&statusflag=Y`;
            // console.log('add-username');
            // alert(formData)
            $.post(formURL, formData)
                .always(function() {
                    state_re = 1;
                    var table = $('#usercreate_div').DataTable();
                    table.destroy();
                    refresh_views();
                });

        });

        $(document).on('click', '[remove_usercreate]', function(e) {
            // $(this).closest("tr").remove();
            $('#usercreate_div').css('display', 'none');
            let remove_url = `./remove_usercreate/${$(this).attr('remove_usercreate')}`;
            // console.log('del-username');
            $.get({
                    url: remove_url,
                    cache: false
                })
                .always(function() {
                    state_re = 1;
                    var table = $('#usercreate_div').DataTable();
                    table.destroy();
                    refresh_views();
                });

        })

        $(document).on('submit', 'form[usercreate]', function(e) {
            let this_loading = $(this).find('[loading_spin]')
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&statusflag=Y`;
            this_loading.css('display', 'block');
            $.post(formURL, formData)
                .always(function() {
                    this_loading.css('display', 'none');
                })
            return false;
        });

        $(document).on('change', 'form[usercreate] select', function(e) {
            $(this).closest('form').submit();
        });

    });
</script>