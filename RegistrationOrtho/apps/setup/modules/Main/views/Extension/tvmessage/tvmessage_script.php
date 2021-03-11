<script type="text/javascript">
    $( function() {
        $(document).on('submit','form[tvmessage]',function(e){
            let this_loading = $(this).find('[loading_spin]')
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            let thisGroupprocess = (groupprocessuid != undefined && groupprocessuid != null)? groupprocessuid : <?=$tvmessage['groupprocessuid'];?>;
            formData += `&muser=${muser}`;
            this_loading.css('display','block');
            $.post(formURL,formData)
                .always(function(){
                    this_loading.css('display','none');
                            
                    let triggerURL = `./trigger_tv_update/${groupprocessuid}/${queuelocationuid}`;
                    $.get({url:triggerURL,cache:false})

                })
            
            return false;
        });

        $(document).on('change','form[tvmessage] input[name="tv_message"]',function(e){
            $(this).closest('form').submit();
        });

    });
</script>