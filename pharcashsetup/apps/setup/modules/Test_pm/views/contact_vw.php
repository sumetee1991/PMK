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

          <div style="font-family: cs_prajad_b;font-weight: 400;font-size: 32px;">ช่องบริการ</div>
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
            ชื่อบริการ
            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อบริการ" disabled="disabled">
            <div id="validate-name" style="color:red;"></div>
         </div>
  
         <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
            ที่ช่อง
            <input type="text" class="form-control" name="allcounter" id="allcounter" placeholder="Ex. 4-11">
            <div id="validate-allcounter" style="color:red;"></div>
         </div>
        

         <div class="form-group float-left">
           <button type="button" class="btn btn_pmk" data-dismiss="modal" style="font-family: cs_prajad_b;font-size: 18px;">ยกเลิก</button>
        </div>
        <div class="form-group float-right">
         <div id="btn">
            <button class="btn btn_pmk" type="button" id="btn_update" style="font-family: cs_prajad_b;font-size: 18px;">บันทึก</button>
         </div>
      </div>
   </form>   
</div>
</div>
</div>
</div>