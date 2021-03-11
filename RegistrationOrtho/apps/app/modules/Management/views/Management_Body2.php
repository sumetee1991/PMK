<div class="management-container" style="height:100%">
	

	<div id="ManagementOuterTab" class="header" style="height:56PX">
		<a class="out-panel_btn" data-sidenav="#management_sidepanel"><i class="fa fa-align-justify"></i></a>
		<h1 class="col-3" style="white-space: nowrap;padding-left:1rem;">DashQueue</h1>
		<h2 class="col-1" style="white-space: nowrap;"><?=(isset($Data['TitleText']) ? $Data['TitleText'] : '');?></h2>
		<div id="ManagementTab" class="col text-right" style="color:#FFFFFF;">
			<ul class="inline seperate_box" style="font-size: 1.5rem;font-weight: 200;">
				<!-- <i class="fas fa-map-marker-alt"></i>  -->
           <li id="li_serviceUnitAbbreviation"><img style="width: 26px" src="<?=base_url('static/Icon');?>/5.png" alt=""><span id="span_serviceUnitAbbreviation">Service Unit</span></li>
           <li id="li_queuecategory"><img style="width: 26px" src="<?=base_url('static/Icon');?>/5.png" alt=""><span style="font-weight: 400;">QueueCategory</span>:<span id="span_QueueCategory">Category (A)</span></li>
           <li id="li_counter"><!-- <span style="font-weight: 400;">Counter</span>: --><span id="span_Counter">Counter 1</span></li>
           <li id="li_login" class="dropdown"><img style="width: 26px;margin-right: 4px; margin-left: 4px;" src="<?=base_url('static/Icon');?>/6.png" alt="">
             <button class="dropdown-toggle none" style="color:#FFFFFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <!--<span style="font-weight: 400;">Login</span>:--><span id="span_Login">Username</span>
            </button>
            <div class="dropdown-menu" style="font-size:1.5rem;" aria-labelledby="dropdownMenuButton">
               <a id="acc_logout" class="dropdown-item" href="#">Logout</a>
               <?php if( defined('TESTMODE') && TESTMODE == 'Y'): ?>
                 <h6 class="dropdown-header" style="font-size:1.875rem;">Test Menu</h6>
                 <!-- <a id="SetSession" class="dropdown-item" href="#">SetSession</a> -->
                 <a id="LogRefreshToken" class="dropdown-item" href="#">ConsoleLog : RefreshToken</a>
                 <a id="LogSessionToken" class="dropdown-item" href="#">ConsoleLog : SessionToken</a>
                 <a id="test_JWT" class="dropdown-item" href="#">ConsoleLog : Token</a>
                 <a id="test_JWTDecode" class="dropdown-item" href="#">ConsoleLog : DecodedToken</a>
                 <a id="test_JWTDecodeOBJ" class="dropdown-item" href="#">ConsoleLog : PayloadObject</a>
                 <a id="test_TokenEXP" class="dropdown-item" href="#">ConsoleLog : TokenExpired</a>
              <?php endif; ?>
           </div>

        </li>
     </ul>
  </div>
</div>

<div id="ManagementDashboard" class="content" style="position: relative;height:90%;">
 <!-- Management Content -->
 <?php
 if( isset($Data['Template_Content']) && count($Data['Template_Content'])>0 ){
  foreach($Data['Template_Content'] as $TemplateContent) : 
    $this->load->view($TemplateContent);
 endforeach;				
}
?>
<!-- /Management Content -->

</div>

<div id="management_sidepanel" class="sidenav_panel" style="height:calc(100% - 56px);">
 <div>
   <span class="mod-thin" style="font-size: 2.5rem;"></span>
   <h3 style="padding-left:1rem;">Management</h3>
   <div class="container-fluid" style="font-size: 1.5rem;">
     <ul class="nobullet" id='menu'>

      <!-- <li><img style="width: 26px" src="<?=base_url('static/Icon');?>/1.png" alt=""><a class="sidenav_url" href="./Filter/0"><button>คัดกรอง</button></a></li> -->
      <li><img style="width: 20px" src="<?=base_url('static/Icon');?>/2.png" alt=""><a class="sidenav_url menu" href="./AltDashboardlocation2" location="2" uid="1"><button>คิวทำประวัติและเปิดสิทธิ</button></a></li>
      <li><img style="width: 20px" src="<?=base_url('static/Icon');?>/3.png" alt=""><a class="sidenav_url menu" href="./Dashboardlocation2" location="2" uid="2"><button>คิวคัดกรอง</button></a></li>
      <li id="SetupBtnxxx"><img style="width: 20px" src="<?=base_url('static/Icon');?>/4.png" alt=""><a  href="<?=base_url(LOCALPATH.'/Management/Setup');?>"  target=""><button>ตั้งค่าเคาน์เตอร์</button></a></li>
   </ul>
</div>
</div>
</div>

</div>

<div id="Modal_Management_Setup" class="modal" tabindex="-1" role="dialog">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h2 class="modal-title">ตั้งค่าเคาน์เตอร์ <span id="setupTitle"></span></h2>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
   <h4>กรุณาเลือกช่องบริการ</h4>
   <div class="container-fluid">
     <div id="counterRow_Side" class="row">
	            	<!-- 
		                <div class="colBtn" >
		                    <a class="button medium block c_lightblue" data-tabcounter="1" data-tabaction="tabcounter">1</a>
		                </div>
                 -->
              </div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
       </div>
    </div>
 </div>
</div>


<div id="Modal_Alert_Setup" class="modal" tabindex="-1" role="dialog">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h2 class="modal-title">ไม่สามารถใช้งานได้ คุณยังไม่ได้ตั้งค่าหน้า Management <span id="setupTitle_Alert"></span></h2>
 </div>
 <div id="AlertSetup" class="modal-body">
   <div id="Counter_Alert">
     <h4>กรุณาเลือกช่องบริการ</h4>
     <div class="container-fluid">
       <div id="counterRow_Alert" class="row">
		            	<!-- 
			                <div class="colBtn" >
			                    <a class="button medium block c_lightblue" data-tabcounter="1" data-tabaction="tabcounter">1</a>
			                </div> 
                      -->
                   </div>
                </div>
             </div>
             <div id="Category_Alert">
              <h4>กรุณาเลือกประเภทคิว</h4>
              <div class="container-fluid">
                <div id="queuecateRow_Alert" class="row btn_row">
		            	<!--
							<a data-tabqueuecate="1" data-buttonaction="tabqueuecate"><button>A</button></a>
						-->
					</div>
           </div>
        </div>
     </div>
  </div>
</div>
</div>
