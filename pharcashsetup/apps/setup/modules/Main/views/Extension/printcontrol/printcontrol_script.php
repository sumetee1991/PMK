<script type="text/javascript">
    $( function() {

        $(document).on('submit','form[printcontrol]',function(e){
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

        $(document).on('change','form[printcontrol] input[type="radio"]',function(e){
            $(this).closest('form').submit();
        });

    });
</script>