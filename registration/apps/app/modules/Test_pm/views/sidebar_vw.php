<style type="text/css">
  .sidebar-dark .nav-item .nav-link:hover{
   background-color: #fafafa;
}
.groupprocess{
   font-family: mitrregular;
   font-size: 18px;
}
.payorid{
   font-family: mitrregular;
   font-size: 18px;

}
.patient_type_data{
   font-family: mitrregular;
   font-size: 18px;
}
.modal.fade .modal-dialog.modal-dialog-zoom {
   -webkit-transform: translate(0,0)scale(.5);
   transform: translate(0,0)scale(.5);
}
.modal.show .modal-dialog.modal-dialog-zoom {
   -webkit-transform: translate(0,0)scale(1);
   transform: translate(0,0)scale(1);}

}

</style>




<ul class="navbar-nav  sidebar  bg-light  sidebar-dark accordion" id="accordionSidebar" style="background-color: #fff;border-right:1px solid #ccc;">
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url();?>">
    <div class="sidebar-brand-icon rotate-n-15">
    </div>
    <!-- <div class="sidebar-brand-text  mt-3 mb-3"><img src="<?php echo base_url('static/kiosk/resources/images/logo.png');?>" width="80"></div> -->
 </a>

 <hr class="sidebar-divider my-0">
 <li class="nav-item">
    <a class="nav-link" href="/index">
     <i class="fas fa-fw fa-sign"></i>
     <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ช่องบริการ</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/payor">
     <i class="fas fa-fw fa-credit-card"></i>
     <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">สิทธิรักษา</span></a>
  </li>

  <li class="nav-item">
   <a class="nav-link" href="/patient">
    <i class="fas fa-fw fa-users"></i>
    <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ประเภทคนไข้</span></a>
 </li>

 <li class="nav-item">
    <a class="nav-link" href="/message">
       <i class="fas fa-fw fa-comments"></i>
       <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ข้อความ</span></a>
    </li>

    <li class="nav-item">
       <a class="nav-link" href="/process">
        <i class="fas fa-fw fa-cog"></i>
        <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">กระบวนการ</span></a>
     </li>

     <li class="nav-item">
       <a class="nav-link" href="/queue_category">
        <i class="fas fa-fw fa-list-alt"></i>
        <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">หมวดหมู่คิว</span></a>
     </li>

     <li class="nav-item">
       <a class="nav-link" href="/clinic">
        <i class="fas fa-fw fa-medkit"></i>
        <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ศูนย์รักษา</span></a>
     </li>
     <li class="nav-item">
       <a class="nav-link" href="/building">
        <i class="fas fa-fw fa-building"></i>
        <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ตึก/อาคาร</span></a>
     </li>
     <li class="nav-item">
       <a class="nav-link" href="/contactno">
        <i class="fas fa-fw fa-tasks"></i>
        <span style="font-family: cs_prajad_b;font-weight: 400;font-size: 20px;">ช่องบริการ (ใบนำทาง)</span></a>
     </li>
           <!-- <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div> -->
       </ul>
       <div id="content-wrapper" class="d-flex flex-column">

          <div id="content">

