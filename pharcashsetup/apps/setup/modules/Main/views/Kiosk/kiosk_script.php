<script type="text/javascript">
    var queuelocationuid = <?=$Data['thisQueuelocation']->locationuid;?>;
    const refresh_views = () => {
        let view = `./kiosk_view`;
        if(queuelocationuid){
            view = `./kiosk_view_location/${queuelocationuid}`;
        }
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
        //refresh_views();
        $(document).on('submit','form[kiosk_ticket]',function(e){
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
        
        $(document).on('change','form[kiosk_ticket] textarea[name="display_message"]',function(e){
            $(this).closest('form').submit();
        });

        $(document).on('submit','form[kiosk]',function(e){
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

        $(document).on('change','form[kiosk] textarea[name="popup_message"]',function(e){
            $(this).closest('form').submit();
        });

        $(document).on('change','form[kiosk] input[type="radio"]',function(e){
            $(this).closest('form').submit();
        });

        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })

    });
</script>