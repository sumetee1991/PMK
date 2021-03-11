<script type="text/javascript">
    var groupprocessuid = 6;
    var queuelocationuid = <?=$Data['thisQueuelocation']->locationuid;?>;
    const refresh_views = () => {
        let view = `./drugcharge_view`;
        if(queuelocationuid){
            view = `./drugcharge_view_location/${queuelocationuid}`;
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
        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })
    });
</script>