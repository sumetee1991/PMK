<style type="text/css">
    #show_data .card {
        cursor: move !important;
    }
    .li7 {
      background-color: #53a5a5;
      border-radius: 10px;
     }
</style>

<body id="page-top">
    <?php echo $this->load->view('../nav'); ?>

    <div id="wrapper">
        <?php $this->load->view('../sidebar_vw'); ?>
        <div class="container-fluid">
            <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;">Report ตาราง</div>
            <form form_stop id="report_form" name="report_form" method="post" action="<?= APPURLSETUP . '/Test_pm/report_ajax'; ?>">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="Topic">Select Topic</label>
                            <select class="form-control" id="topic" name="topic">
                                <option value="0">Kiosk</option>
                                <!-- <option value="1">คัดกรอง</option> -->
                                <option value="2">ทำประวัติ / เปิดสิทธิ</option>
                                <option value="3">คัดกรอง</option>
                                <option value="1">kiosk+ทำประวัติ / เปิดสิทธิ+คัดกรอง</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="From">From</label>
                            <input class="form-control" type="text" id="date_from" name="date_from" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?=date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="To">To</label>
                            <input class="form-control" type="text" id="date_to" name="date_to" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?=date("Y-m-d");?>">
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
                <?php 
                    if( isset($Report) ){
                        $this->load->view($Report['view'],$Report);
                    }
                ?>
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