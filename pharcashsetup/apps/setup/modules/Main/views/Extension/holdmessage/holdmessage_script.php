<script type="text/javascript">
    $( function() {

        $(document).on('click','[add_holdmessage]',function(e){
            let add_url = `./add_holdmessage/${$(this).attr('add_holdmessage')}`;
            $.get({url:add_url,cache:false})
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('click','[remove_holdmessage]',function(e){
            let remove_url = `./remove_holdmessage/${$(this).attr('remove_holdmessage')}`;
            $.get({url:remove_url,cache:false})
                .always(function(){
                    refresh_views();
                });
        })

        $(document).on('submit','form[holdmessage]',function(e){
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

        $(document).on('change','form[holdmessage] input[name="hold_message"]',function(e){
            $(this).closest('form').submit();
        });

    });
</script>