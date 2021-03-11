<style type="text/css">
    #show_data .card {
        cursor: move !important;
    }
</style>

<body id="page-top">
    <?php echo $this->load->view('../nav'); ?>

    <div id="wrapper">
        <?php $this->load->view('../sidebar_vw'); ?>
        <div class="container-fluid">
            <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;">Report กราฟ</div>
            <form form_stop id="report_form" name="report_form" method="post" action="<?= APPURLSETUP . '/Test_pm/statistic_ajax'; ?>">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="Topic">Select Topic</label>
                            <select class="form-control" id="topic" name="topic">
                                <option value="0">Kiosk</option>
                                <option value="1">คัดกรอง</option>
                                <option value="2">ทำประวัติ</option>
                                <option value="3">เปิดสิทธิ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="Date">Date</label>
                            <input class="form-control" type="text" id="date_select" name="date_select" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" value="<?=date("d/m/Y");?>">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn_pmk btn-md">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="show_data" class="row" style="overflow-x:auto;">
            </div>
            <!-- delete product modal -->
        </div>
    </div>

    <?php $this->load->view('../bottom_vw'); ?>
    </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>