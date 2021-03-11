  <style type="text/css">
   #show_data .card {
     cursor: move !important;
  }
  .li6 {
      background-color: #53a5a5;
      border-radius: 10px;
     }
</style>
<body id="page-top">
   <?php echo $this->load->view('nav');?>

   <div id="wrapper">
      <?php $this->load->view('sidebar_vw');?>
      <div class="container-fluid">
         <div class="container">

          <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;">จำนวนที่รับ walk-in</div>
          <!-- <div class="row">
            <div class="col-12 mb-2">
               <div class="float-left"><a href="javascript:void(0);" class="btn btn_pmk btn-sm" data-toggle="modal" data-target="#add_modal" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" id="btn-add">เพิ่มรายการ</a></div>
            </div>
         </div> -->
         <div id="show_data" class="row">
         </div>
      </div>
      <!-- delete product modal -->
   </div>
</div>

<?php $this->load->view('bottom_vw');?>
</div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
</a>


<!-- add product modal -->
<div class="modal fade" id="add_modal">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
    <div class="modal-content">
     <div class="modal-header">
      <div style="font-family: cs_prajad_b;font-size: 30px;" id="header_txt"></div>
   </div>
   <div class="modal-body">
      <form class="form-horizontal" id="submit" enctype='multipart/form-data'>
         <input type="hidden" name="uid" id="uid">
         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            <!-- จำนวนที่จำกัด -->
            <input type="number" class="form-control" name="code" id="code" placeholder="รหัส">
            <div id="validate-process" style="color:red;"></div>
         </div>
         <!-- <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            OPD Code
            <input type="text" class="form-control" name="clinic_code" id="clinic_code" placeholder="OPD Code">
            <div id="validate-process" style="color:red;"></div>
         </div>
         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            ชื่อศูนย์รักษา
            <input type="text" class="form-control" name="detail" id="detail" placeholder="ชื่อศูนย์รักษา">
            <div id="validate-process" style="color:red;"></div>
         </div>

         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            ตึก/อาคาร
            <select class="form-control" id="building" name="building">

            </select>
            <div id="validate-process" style="color:red;"></div>
         </div>

         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            ชั้น
            <select class="form-control" id="floor" name="floor">

            </select>


            <div id="validate-process" style="color:red;"></div>
         </div>

         <div class="form-group">
            จำนวน
            <input type="text" class="form-control" name="amount" id="amount">
         </div> -->

         <!-- <div class="form-group">
            วันเปิดทำการ
            <div class="row">
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Sunday">SUN
              </div>              
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Monday">MON
              </div>
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Tuesday">TUE
              </div>
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Wednesday">WED
              </div>
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Thursday">THU
              </div>
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Friday">FRI
              </div>
              <div class="col">
                <input type="checkbox" name="active_date[]" value="Saturday">SAT
              </div>
            </div>
         </div> -->


         <!-- <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            เปิด/ปิด visit
            <div>
               <input type="radio" name="visit_active" class="visit_active" value="Y" checked="checked">เปิด
               <input type="radio" name="visit_active" class="visit_active" value="N">ปิด
            </div>
         </div> -->
         <!-- <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            เปิด/ปิด
            <div>
               <input type="radio" name="active" class="active" value="Y" checked="checked">เปิด
               <input type="radio" name="active" class="active" value="N">ปิด
            </div>
         </div> -->

         <div class="form-group float-left">
           <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-size: 18px;">ยกเลิก</button>
        </div>
        <div class="form-group float-right">
         <div id="btn">
            <button class="btn btn_pmk" type="button" id="btn_update" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
            <!-- <button class="btn btn_pmk" type="button"  id="btn_upload" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก2</button> -->
         </div>
      </div>
   </form>   
</div>
</div>
</div>
</div>


<form>
   <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
     <div class="modal-content">

        <div class="modal-body">
         <div style="font-family: cs_prajad_b;font-weight: 300;font-size: 23px;">คุณต้องการลบออก?</div>
      </div>
      <div class="modal-footer">
       <input type="hidden" name="product_code_delete" id="product_code_delete" class="form-control">
       <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-weight: 300;font-size: 17px;">ยกเลิก</button>
       <button type="button" type="submit" id="btn_delete" class="btn btn_pmk" style="font-family: cs_prajad_b;font-weight: 300;font-size: 17px;">ตกลง</button>
    </div>
 </div>
</div>
</div>
</form>