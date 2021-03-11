<script>
    <?php echo Modules::run('Websocket/SocketConection'); ?>


    midSocket.on('scan_station', function(data) {
        if (data['step'] == 'next1') {
            window.location.href = baselocal + <?php echo Modules::run('Websocket/ScannerPage'); ?>
        }
    });


    var NextToSlip = baselocal + <?php echo Modules::run('Websocket/NextToSlip') ?>;
    $("#cf_processing").click(function() {
        window.location.href = NextToSlip;
    });
</script>