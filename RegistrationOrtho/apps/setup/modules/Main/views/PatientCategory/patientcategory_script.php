<script type="text/javascript">
    var queuelocationuid = <?=$Data['thisQueuelocation']->locationuid;?>;
    const refresh_views = () => {
        let view = `./patientcategory_view`;
        if(queuelocationuid){
            view = `./patientcategory_view_location/${queuelocationuid}`;
        }
        $('#loading').css('display', 'block');
        $.get({
                url: view,
                cache: false
            })
            .then( (response) => {
                $("#show_data").html(response.html);
                
                $("#patientcategory_list").sortable({
                    update: function(event, ui) {
                        $('#patientcategory_list [sortcate]').each(function(i) {
                            let update_url = "./update_patientcategory";
                            let update_sort = `uid=${$(this).data('uid')}&sequence=${i}`;
                            $.post(update_url,update_sort);
                        });
                    }
                });
                
                $('#loading').css('display', 'none');
            })
            .fail( () => {
                $('#show_data').html("Try Again");
                $('#loading').css('display', 'none');
            });
    }
    $( function() {
        //refresh_views();
        $("#patientcategory_list").sortable({
            update: function(event, ui) {
                $('#patientcategory_list [sortcate]').each(function(i) {
                    let update_url = "./update_patientcategory";
                    let update_sort = `uid=${$(this).data('uid')}&sequence=${i}`;
                    $.post(update_url,update_sort);
                });
            }
        });
        
        $(document).on('click', '[btn-add]', function() {
            $('#patientcategory_modal input[name="uid"]').val('').removeAttr('value');
            $('#patientcategory_modal input#input_uid').removeAttr('name');
            $('#patientcategory_modal form').attr('action','./add_patientcategory');
            // let input = document.getElementById('input_color');
            // let picker = new jscolor(input);
            $('#patientcategory_modal').modal('show');
        });

        $(document).on('click', '[btn-edit]', function() {
            let this_uid = $(this).attr('btn-edit');
            $('#patientcategory_modal input#input_uid').attr('name','uid');
            let patientcategory_data = `./patientcategory_data/${this_uid}`;
            $.get({
                    url: patientcategory_data,
                    cache: false
                })
                .then( (response) => {
                    let response_data = JSON.parse(response);
                    $('#patientcategory_modal input[name="uid"]').val(this_uid).attr('value', this_uid);
                    $('#patientcategory_modal input[name="patientcategoryshortname"]').val(response_data.patientcategoryshortname);
                    $('#patientcategory_modal input[name="patientcategoryname"]').val(response_data.patientcategoryname);
                    $('#patientcategory_modal input[name="ticketdisplay"]').val(response_data.ticketdisplay);
                    $('#patientcategory_modal input[name="color"]').val(response_data.color);
                    $('#patientcategory_modal input[name="waitingtime"]').val(response_data.waitingtime);
                    $('#patientcategory_modal select[name="groupprocessuid"]').val(response_data.groupprocessuid);
                    $(`#patientcategory_modal input[name="statusflag"][value="${response_data.statusflag}"]`).prop('checked', true);
                    $('#patientcategory_modal form').attr('action','./update_patientcategory');
                    // let input = document.getElementById('input_color');
                    // let picker = new jscolor(input);
                    $('#patientcategory_modal').modal('show');
                });
        });

        $(document).on('click', '[btn-del]', function() {
            let this_uid = $(this).attr('btn-del');
            $('#del_modal #del_confirm').data('delete','patientcategory').attr('data-delete','patientcategory');
            $('#del_modal #del_confirm').data('uid',this_uid).attr('data-uid',this_uid);
            $('#del_modal').modal('show');
        });

        $(document).on('click', '#del_confirm', function() {
            let target = $(this).data('delete');
            let uid = $(this).data('uid');
            switch (target) {
                case 'patientcategory':
                    var delete_url = `./del_patientcategory`;
                    break;            
                default:
                    console.log("Try Again");
                    break;
            }
            if(typeof delete_url !== undefined){
                $.post(delete_url,{uid:uid})
                    .then( (response) => {
                        $('#del_modal').modal('hide');
                    });
            }
            
        })

        $(document).on('submit', '#patientcategory_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#patientcategory_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('submit', '#patientcategory_message_modal form', function(){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();
            let muser = encodeURIComponent($('#span_Login').text());
            formData += `&muser=${muser}`;
            $.post(formURL,formData)
                    .then( (response) => {
                        $('#patientcategory_message_modal').modal('hide');
                    });
            return false;
        })

        $(document).on('change', '#select_queuelocation', async function(){
            queuelocationuid = $(this).val();
            refresh_views();
        })
        
        $(document).on('hidden.bs.modal', '#patientcategory_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#patientcategory_message_modal', refresh_views);
        $(document).on('hidden.bs.modal', '#del_modal', () => {
            $('#del_modal #del_confirm').data('delete','').removeAttr('data-delete');
            $('#del_modal #del_confirm').data('uid','').removeAttr('data-uid');
            refresh_views();
        });

    });
</script>