<div class="container-fluid" style="background-color: #FFFFFF;width:60vw;max-width:60vw;height:40vh;max-height:40vh;margin:19.5vh 20vw 0vh 20vw;border-radius: 30px;padding:2% 5%;display: table;">
 <h1>Management</h1>

 <div class="container" style="vertical-align:middle;display: table-cell;">
   <h2>กรุณาเลือกสถานที่เวชระเบียน</h2>

   <div class="container-fluid">

      <div class="row btn_row">
        <!-- <a  data-link="location1" location="1"><button>เวชระเบียน ชั้น 1 ตึกเฉลิมพระเกียรติ</button></a> -->
        <a  data-link="location2" location="2"><button>เวชระเบียน ชั้น 1 ตึกออโธปิดิกส์</button></a>
     </div>
     <br>
     <h2>กรุณาเลือกหน่วยงาน</h2>
     <div class="row btn_row" id="location1Div">
      <a <?php /*href="<?=base_url(LOCALPATH.'/Management/Filter');?>"*/?> data-link-station="Cus" uid="3" location="1" ><button class="station">คัดกรอง</button></a>
      <a <?php /*href="<?=base_url(LOCALPATH.'/Management/AltDashboard');?>"*/?> data-link-station="AltDashboard" uid="1" location="1" ><button class="station">คิวทำประวัติผู้ป่วย</button></a>
      <a <?php /*href="<?=base_url(LOCALPATH.'/Management/Dashboard');?>"*/?> data-link-station="Dashboard"  uid="2" location="1"><button  class="station">คิวเปิดสิทธิ</button></a>
      <br>
   </div>
   
   <div class="row btn_row div_hidden" id="location2Div">

      <a  uid="1" location="2" data-link-station="Filterlocation2"><button >คิวทำประวัติผู้ป่วยเปิดสิทธิ</button></a>
      <a   uid="2" location="2" data-link-station="Dashboardlocation2"><button >คิวคัดกรอง</button></a>
      <br>
   </div>
</div>
<div id="filterDiv" class="div_hidden">
   <div class="container-fluid">
    <div id="filterRow" class="row">
     <div class="colBtn" >
      <a class="button medium block c_lightblue" href="./Filter/0" >ไปจุดให้บริการ</a>
   </div> 
</div>
</div>
<hr>
</div>
<br>
<div id="counterDiv" class="div_hidden">
   <h2>กรุณาเลือกช่องบริการ</h2>
   <div class="container-fluid">
    <div id="counterRow" class="row">
       
<!--       <div class="colBtn" >
        <a class="button medium block c_lightblue" data-tabcounter="1" data-tabaction="tabcounter">1</a>
     </div>  -->
     
  </div>
</div>
<hr>
</div>
        <?php /*
        <div class="container-fluid" style="margin:0 2.5% 2.5% 2.5%;">
            <div class="row">
                <div class="colBtn">
                    <a class="button medium block c_green" data-setup="save">บันทึก</a>
                </div>
                <!-- 
                    <div class="colBtn">
                        <a class="button medium block c_yellow" data-setup="clear">ยกเลิก</a>
                    </div> 
                -->
            </div>
        </div>
        */ ?>
     </div>
  </div>