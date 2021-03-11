<script type="text/javascript">
    $( function() {

        $(document).on('click','[add_countercontrol]',function(e){
            let add_url = `./add_countercontrol/${$(this).attr('add_countercontrol')}`;
            $.get({url:add_url,cache:false})
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('click','[remove_countercontrol]',function(e){
            let remove_url = `./remove_countercontrol/${$(this).attr('remove_countercontrol')}`;
            $.get({url:remove_url,cache:false})
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('submit','form[countercontrol]',function(e){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
            return false;
        });

        $(document).on('change','form[countercontrol] select',function(e){
            $(this).closest('form').submit();
        });

    });
</script>