<script type="text/javascript">
    var groupprocessuid = 2;
    var queuelocationuid = <?=$Data['thisQueuelocation']->locationuid;?>;
    const refresh_views = () => {
        let view = `./dispense_view`;
        if(queuelocationuid){
            view = `./dispense_view_location/${queuelocationuid}`;
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
        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })
    });
</script>