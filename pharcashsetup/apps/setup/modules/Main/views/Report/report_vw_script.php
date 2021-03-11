<script type="text/javascript">
    $(function() {
        var topicMap = {
            "kiosk_report": "Kiosk",
            "drugcharge_report": "คิดราคายา",
            "medqueue_report": "ออกคิวยา",
            "cashier_report": "การเงิน",
            "medication_report": "จัดยา",
            "checkmed_report": "เช็คยา",
            "dispense_report": "จ่ายยา",
            "total_report": "kiosk+คิดราคายา+ออกคิวยา+การเงิน+จัดยา+เช็คยา+จ่ายยา"
        };

        $(document).on('submit', '#report_form', function(e) {
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            $('#show_report').html('');
            $('#loading').css('display', 'block');
            $.post(formURL, formData)
                .done((data) => {
                    console.log(data);
                    $('#show_report').html(data.html);
                    $(`#${data.table}`).dataTable({
                        dom: 'fBrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('.dataTables_filter').css('display', 'inline');
                    document.title = `สถิติ ${topicMap[data.table]} ${$('#date_from').val()} ถึง ${$('#date_to').val()}}`;
                    $('#loading').css('display', 'none');
                })
                .fail(() => {
                    $('#show_report').html("Try Again");
                    $('#loading').css('display', 'none');
                });

            return false;
        });

    });
</script>