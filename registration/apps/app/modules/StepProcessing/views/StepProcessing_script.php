<script>
    function CallBox(BoxPage) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("BoxPage"); ?>/box' + BoxPage,
            dataType: "html",
            success: function(response) {
                $("#boxContent").html(response);
            }
        });
    }



    $(document).ready(function() {

    });
</script>