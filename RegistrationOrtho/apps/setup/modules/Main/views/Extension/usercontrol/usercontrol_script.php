<script type="text/javascript">
    $( function() {

        $(document).on('click','[add_usercontrol]',function(e){
            let add_url = `./add_usercontrol`;
            let muser = encodeURIComponent($('#span_Login').text());
            let add_data = `username=''&queuelocationuid=0&muser=${muser}`;
            $.post(add_url,add_data)
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('click','[remove_usercontrol]',function(e){
            let remove_url = `./remove_usercontrol/${$(this).attr('remove_usercontrol')}`;
            $.get({url:remove_url,cache:false})
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('submit','form[usercontrol]',function(e){
            let this_loading = $(this).find('[loading_spin]')
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            this_loading.css('display','block');
            $.post(formURL,formData)
                .always(function(){
                    this_loading.css('display','none');
                })
            return false;
        });

        $(document).on('change','form[usercontrol] select',function(e){
            $(this).closest('form').submit();
        });

    });
</script>