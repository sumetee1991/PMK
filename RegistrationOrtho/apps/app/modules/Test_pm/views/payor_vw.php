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

            <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 30px;">สิทธิการรักษาพยาบาล</div>
            <div class="row">
               <div class="col-12 mb-2">
                  <div class="float-left"><a href="javascript:void(0);" class="btn btn_pmk btn-sm" data-toggle="modal" data-target="#add_modal" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" id="btn-add">เพิ่มสิทธิการรักษา</a></div>
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

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <div class="modal-body">คุณต้องการยืนยันออกจากระบบ</div>
        <div class="modal-footer">
         <button class="btn btn-danger" type="button" data-dismiss="modal">ยกเลิก</button>
         <a class="btn btn-success" href="<?php echo base_url('Admin/user_logout');?>">ยืนยัน</a>
      </div>
   </div>
</div>
</div>

<!-- add product modal -->
<div class="modal fade" id="add_modal">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
    <div class="modal-content">
     <div class="modal-header">
      <div style="font-family: cs_prajad_b;font-size: 30px;">เพิ่มสิทธิ</div>
   </div>
   <div class="modal-body">
      <form class="form-horizontal" id="submit" enctype='multipart/form-data'>
         <input type="hidden" name="uid" id="uid">
         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
           รหัสประเภท
           <input type="text" name="code" class="form-control" placeholder="ระบุรหัส" id="code">
           <div id="validate-code" style="color:red;"></div>
        </div>

        <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
           ชื่อ
           <input type="text" name="name" class="form-control" placeholder="ระบุชื่อ" id="name">
           <div id="validate-name" style="color:red;"></div>
        </div>
        <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
           ชื่อย่อ
           <input type="text" name="shortname" class="form-control" placeholder="ระบุชื่อย่อ" id="shortname">
           <div id="validate-name-short" style="color:red;"></div>
        </div>

          <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
           <input type="text" name="hiscode" class="form-control"  id="hiscode" placeholder="hiscode">
           <!-- <div id="validate-name-short" style="color:red;"></div> -->
        </div>


        <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
         เปิดสิทธิอัตโนมัติ
         <input type="radio" name="open_active" value="Y" id="open_y">เปิด
         <input type="radio" name="open_active" value="N" id="open_n">ปิด
      </div>
      <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
         <div>
            เปิด/ปิด
         </div>
         <div>
            <input type="radio" name="active" value="Y" id="active_y">เปิด
            <input type="radio" name="active" value="N" id="active_n">ปิด
         </div>
      </div>
      <!--   <div class="form-group">
         Worklist
         <select class="form-control" id="groupprocess" style="font-family: Mitr;font-size: 18px;" name="groupprocess">
            <option></option>

         </select>
      </div> -->
      <div class="form-group float-left">
        <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-size: 18px;">ยกเลิก</button>
     </div>
     <div class="form-group float-right">
      <button class="btn btn_pmk" type="button" id="btn_update" style="font-family: cs_prajad_b;font-size: 18px;"><i class="fa fa-floppy" aria-hidden="true"></i>บันทึก</button>
      <button class="btn btn_pmk" type="button"  id="btn_upload" style="font-family: cs_prajad_b;font-size: 18px;"><i class="fa fa-floppy" aria-hidden="true"></i> บันทึก</button>
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
           <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ยกเลิก</button>
           <button type="button" type="submit" id="btn_delete" class="btn btn-success" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ตกลง</button>
        </div>
     </div>
  </div>
</div>
</form>