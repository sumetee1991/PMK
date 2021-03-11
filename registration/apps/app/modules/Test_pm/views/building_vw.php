  <style type="text/css">
   #show_data .card {
     cursor: move !important;
  }
</style>
<body id="page-top">
   <?php echo $this->load->view('nav');?>

   <div id="wrapper">
      <?php $this->load->view('sidebar_vw');?>
      <div class="container-fluid">
         <div class="container">

          <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;">ตึก/อาคาร</div>
          <div class="row">
            <div class="col-12 mb-2">
               <div class="float-left"><a href="javascript:void(0);" class="btn btn_pmk btn-sm" data-toggle="modal" data-target="#add_modal" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" id="btn-add">เพิ่มรายการ</a></div>
            </div>
         </div>
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
            ชื่อตึก/อาคาร
            <input type="text" class="form-control" name="building_name" id="building_name" placeholder="ชื่อตึก/อาคาร">
            <div id="validate-process" style="color:red;"></div>
         </div>

         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            ชั้น
            <div>
               <button class="btn btn_pmk" id="add_building" type="button">เพิ่มชั้น</button>
               <table  class="table">
                  <tbody id="floor_list"></tbody>
               </table>
               <div id="building_set">
               </div>
            </div>

         </div>
         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            เปิด/ปิด
            <div>
               <input type="radio" name="active" class="active" value="Y" checked="checked">เปิด
               <input type="radio" name="active" class="active" value="N">ปิด
            </div>
           <!--  <select class="form-control" id="active" name="active" style="font-family: Mitr;font-size: 18px;">
               <option value="Y">เปิด</option>
               <option value="N">ปิด</option>
            </select> -->
         </div>

         <div class="form-group float-left">
           <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-size: 18px;">ยกเลิก</button>
        </div>
        <div class="form-group float-right">
         <div id="btn">
            <button class="btn btn_pmk" type="button" id="btn_update" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
            <button class="btn btn_pmk" type="button"  id="btn_upload" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
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
         <div style="font-family: Mitr;font-weight: 300;font-size: 23px;">คุณต้องการลบออก?</div>
      </div>
      <div class="modal-footer">
       <input type="hidden" name="product_code_delete" id="product_code_delete" class="form-control">
       <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ยกเลิก</button>
       <button type="button" type="submit" id="btn_delete" class="btn btn_pmk" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ตกลง</button>
    </div>
 </div>
</div>
</div>
</form>