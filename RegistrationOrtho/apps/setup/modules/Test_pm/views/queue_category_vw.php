  <style type="text/css">
   #show_data .card {
     cursor: move !important;
  }
  .li5 {
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


      </div>
      <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 25px;">หมวดหมู่คิว</div>
      <div class="row">
         <div class="col-12 mb-2">
          <div class="float-left"><a href="javascript:void(0);" class="btn btn_pmk btn-sm" data-toggle="modal" data-target="#add_modal" style="font-family:cs_prajad_b;font-weight: 300;font-size: 18px;" id="btn-add">เพิ่มหมวดหมู่คิว</a></div>
       </div>
    </div>
    <style type="text/css">
      #groupprocess_list .card, body.dragging * {
        cursor: move !important;
     }
     .dragged {
        position: absolute;
        /*opacity: 0.5;*/
        /*z-index: 2000;*/
     }
     /*div .example {*/
        /*margin: 30px 0;*/
        /*padding: 0;*/
        /*}*/
        /*div .example div {*/
           /*list-style-type: none;*/
           /*display: block;*/
           /*border: 1px solid #c7c7c7;*/
           /*cursor: pointer;*/
           /*height: 2em;*/
           /*}*/
           /*div .example div.placeholder {*/
              /*position: relative;*/
              /*list-style-type: none;*/
              /*height: 2em;*/
              /*background: none #eee;*/
              /** More li styles **/
              /*}*/
              /*div .example div.placeholder:before {*/
                 /*position: absolute;*/
                 /** Define arrowhead **/
                 /*}*/
              </style>

      <!--         <div class="row category">
                 <div class="col-4">
                  <div class="card bg-light shadow mb-2">
                     <div class="card-body">
                        dfdfdfdf
                        <input type="text">
                     </div>
                  </div>
               </div>
               <div class="col-4">
                  <div class="card bg-light shadow mb-2">
                     <div class="card-body">
                        fdfdfdf
                        <input type="text">
                     </div>
                  </div>
               </div>
               <div class="col-4">
                  <div class="card bg-light shadow mb-2">
                     <div class="card-body">
                        123456
                        <input type="text">
                     </div>
                  </div>
               </div>
               <div class="col-4"><div class="card bg-light shadow mb-2"><div class="card-body"><input type="text">
               </div></div></div>
               <div class="col-4"><div class="card bg-light shadow mb-2"><div class="card-body"><input type="text">
               </div></div></div>
               <div class="col-4"><div class="card bg-light shadow mb-2"><div class="card-body"><input type="text">
               </div></div></div>
               <div class="col-4"><div class="card bg-light shadow mb-2"><div class="card-body"><input type="text">
               </div></div></div>

            </div> -->




            <div id="groupprocess_list">
            </div>

            <div id="show_data" class="row">
            </div>
         </div>
      </div>
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
         <div style="font-family: cs_prajad_b;font-size: 30px;">เพิ่มหมวดหมู่คิว</div>
      </div>
      <div class="modal-body">
         <form class="form-horizontal" id="submit" enctype='multipart/form-data'>
            <input type="hidden" name="uid" id="uid">

            <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
              สถานะหมวดหมู่คิว
              <select  class="form-control" name="active" id="active">
                <option value="Y">Active</option>
                <option value="N">Inactive</option>
              </select>
            </div>
            <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;display:none;">
              ช่องที่ติดต่อ
              <input type="text" class="form-control" name="counter" id="counter" placeholder="ช่องที่ติดต่อ">
            <div id="validate-process" style="color:red;"></div>
            </div>
            <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
             รหัสหมวดหมู่คิว
             <input type="text" name="code" class="form-control" placeholder="code" id="code">
          </div>

            <style>
               label {
                  /* color: #945; */
                  font-size: var(--labelSize);
                  font-weight: bold;
               }
               .inputtime {
                  background-position: var(--margin) 50%;
                  /* background-repeat: no-repeat; */
                  background-size: var(--size) var(--size);
                  border: var(--border) solid var(--color);
                  border-radius: var(--borderRadius);
                  color: #222;
                  font-size: var(--size);
                  padding: var(--margin) var(--margin) var(--margin) var(--marginLeft);
                  transition: backgroundImage 0.25s;
               }
               .inputtime:focus {
                  /* outline: 2px dashed #945; */
                  outline-offset: 3px;
               }       
            </style>

          <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
               <!-- <label for="time" style="color: #945;font-weight: bold;">ตั้งเวลาเพื่อออกคิวตามรูปแบบอักษร</label> -->
               ตั้งเวลาเพื่อออกคิวตามรูปแบบอักษร
               <br>
               <!-- value = "22:53"  -->
               <input class="inputtime" type="time" name="timestart" id="timestart" style="margin: 10px;"/>&nbsp;&nbsp;ถึง&nbsp;&nbsp; 
               <input class="inputtime" type="time" name="timeend" id="timeend" style="margin: 10px;"/>
          </div>

            <script>
               document.querySelector("#time").addEventListener("input", function(e) {
               const reTime = /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/;
               const time = this.value;
               if (reTime.exec(time)) {
                  const minute = Number(time.substring(3,5));
                  const hour = Number(time.substring(0,2)) % 12 + (minute / 60);
               }
               });
            </script>

          <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
             ชื่อหมวดหมู่
             <input type="text" name="name" class="form-control" placeholder="name" id="name">
          </div>
          <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            รายละเอียด
            <textarea style="font-family: cs_prajad_b;font-size: 18px;" class="form-control" name="description" placeholder="รายละเอียด"></textarea>
         </div>


         <div class="form-group" style="font-family:cs_prajad_b;font-size: 18px;">
            กระบวนการ
            <select class="form-control" name="groupprocess" id="groupprocess_sl">
               <option value="">เลือกกระบวนการ</option>
            </select>
         </div>



         <div class="row">

            <div class="col-5">
               <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                  สิทธิการรักษา
                  <select name="payorid[payorid][]" id="payorid" class="form-control payorid" style="font-family: cs_prajad_b;font-size: 18px;">

                  </select>
               </div>
            </div>
            <div class="col-5">
              <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                ประเภทคนไข้
                <select name="patient_type_data[patient_type_data][]" id="patient_type_data" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">

                </select>
             </div>
          </div>


          <div class="col-2">
             <div class="form-group">
               <button class="btn btn_pmk" id="add" type="button"><i class="fa fa-plus"></i></button>
            </div>
         </div>
      </div>
      <div id="fields1">
      </div>

      <div calss="col-2">
       <div class="form-group float-left">
          <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-size: 18px;">ยกเลิก</button>
       </div>
       <div class="form-group float-right">

         <button class="btn btn_pmk" type="button"  id="btn_upload" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
      </div>
   </div>
</div>
</form>   
</div>
</div>
</div>
</div>





<div class="modal fade" id="edit_modal">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
    <div class="modal-content">
     <div class="modal-header">
        <div style="font-family: cs_prajad_b;font-size: 30px;">แก้ไขหมวดหมู่คิว</div>
     </div>
     <div class="modal-body">
      <form class="form-horizontal" id="edit_submit" enctype='multipart/form-data'>
       <input type="hidden" name="uid_edit" id="uid_edit">
       
       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
              สถานะหมวดหมู่คิว
              <select  class="form-control" name="active_edit" id="active_edit">
                <option value="Y">Active</option>
                <option value="N">Inactive</option>
              </select>
            </div>

       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;display:none;">
            ช่องที่ติดต่อ
            <input type="text" class="form-control" name="counter_edit" id="counter_edit" placeholder="ช่องที่ติดต่อ">
         <div id="validate-process" style="color:red;"></div>
         </div>
       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
          รหัสหมวดหมู่คิว
          <input type="text" name="code_edit" class="form-control" placeholder="code" id="code_edit">
       </div>
         
       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
               <!-- <label for="time" style="color: #945;font-weight: bold;">ตั้งเวลาเพื่อออกคิวตามรูปแบบอักษร</label> -->
               ตั้งเวลาเพื่อออกคิวตามรูปแบบอักษร
               <br>
               <!-- value = "22:53"  -->
               <input class="inputtime" type="time" name="timestart" id="timestart1" style="margin: 10px;"/>&nbsp;&nbsp;ถึง&nbsp;&nbsp; 
               <input class="inputtime" type="time" name="timeend" id="timeend1" style="margin: 10px;"/>
          </div>

       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
          ชื่อหมวดหมู่
          <input type="text" name="name_edit" class="form-control" placeholder="name" id="name_edit">
       </div>
       <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
         รายละเอียด
         <textarea style="font-family: cs_prajad_b;font-size: 18px;" class="form-control" name="description_edit" placeholder="รายละเอียด" id="description_edit"></textarea>
      </div>

      <div class="form-group" style="font-family:cs_prajad_b;font-size: 18px;">
         กระบวนการ
         <select class="form-control" name="groupprocess" id="groupprocess_esl">
            <option></option>
         </select>
      </div>
      <?php /*
      <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
          สถานะหมวดหมู่คิว 
         <div>
            <input type="radio" name="active_edit" class="active" value="Y" checked="checked">เปิด
            <input type="radio" name="active_edit" class="active" value="N">ปิด
         </div>
            <!--
            <select  class="form-control" name="active_edit" id="active_edit">
               <option value="Y">Active</option>
               <option value="N">Inactive</option>
            </select>
          -->
       </div> */ ?>
       
       <!--   <select name="payorid[payorid][]" id="payorid" class="form-control payorid" style="font-family: Mitr;font-size: 18px;">

         </select>

          <select name="patient_type_data[patient_type_data][]" id="patient_type_data" class="form-control patient_type_data" style="font-family: Mitr;font-size: 18px;">

          </select> -->
          <div class="row">
            <div class="col-5" style="font-family: cs_prajad_b;font-size: 18px;">สิทธิการรักษา</div>
            <div class="col-5" style="font-family: cs_prajad_b;font-size: 18px;">ประเภทคนไข้</div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="form-group float-left">
                  <button class="btn btn_pmk" id="add_edit" type="button"><i class="fa fa-plus"></i></button>
               </div>
            </div>
         </div>
         <div id="fields1_edit">

         </div>


         <div id="fields_edit">
         </div>

         <div calss="col-2">
          <div class="form-group float-left">
             <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family:cs_prajad_b;font-size: 18px;">ยกเลิก</button>
          </div>
          <div class="form-group float-right">
            <button class="btn btn_pmk" type="button" id="btn_update_edit" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>

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
       <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ยกเลิก</button>
       <button type="button" type="submit" id="btn_delete" class="btn btn-success" style="font-family: Mitr;font-weight: 300;font-size: 17px;">ตกลง</button>
    </div>
 </div>
</div>
</div>
</form>