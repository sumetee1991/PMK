<script type="text/javascript">
    $( function() {

        $(document).on('submit','#report_form',function(e){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();            
            $('#show_report').html('');
            $('#loading').css('display', 'block');
            $.post(formURL,formData)
                .done( (data) => {
                    console.log(data);
                    $('#show_report').html(data.html);
                    $(`#${data.table}`).dataTable({
                        dom: 'fBrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('.dataTables_filter').css('display','inline');
                    $('#loading').css('display', 'none');
                })
                .fail( () => {
                    $('#show_report').html("Try Again");
                    $('#loading').css('display', 'none');
                });

            return false;
        });

    });
</script>