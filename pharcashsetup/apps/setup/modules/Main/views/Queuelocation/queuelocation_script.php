<script type="text/javascript">
    var queuelocationuid = <?=$Data['LocationData']->uid;?>;
    const refresh_views = () => {
        let view = `./queuelocation_view`;
        if(queuelocationuid){
            view = `./queuelocation_view_location/${queuelocationuid}`;
        }
        $('#loading').css('display', 'block');
        $.get({
                url: view,
                cache: false
            })
            .then( (response) => {
                $("#show_data").html(response.html);
                $("#select_queuelocation").val(queuelocationuid);
                $('#loading').css('display', 'none');
            })
            .fail( () => {
                $('#show_data').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    $( function() {
        //refresh_views();

        $(document).on('submit','form[queuelocation_form]',function(e){
            let this_loading = $(this).find('[loading_spin]')
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            this_loading.css('display','block');
            $.post(formURL,formData)
                .always(function(){
                    this_loading.css('display','none');
                    refresh_views();
                })
            return false;
        });

        $(document).on('change','form[queuelocation_form] input[type="radio"]',function(e){
            $(this).closest('form').submit();
        });

        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })

    });
</script>