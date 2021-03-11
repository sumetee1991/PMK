<!DOCTYPE html>
<html>
	<head>
		<title><?=(isset($Site_Title) ? $Site_Title : (defined(SITE_TITLE) ? SITE_TITLE : "DashQueue"));?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<?=(isset($css) ? assets_css($css) : '');?>

		<?=single_js('js/viewport.js');?>		
	</head>
	<body>

	<div class="main-container" align="center">
   <div class="footer" style="    width: 90%; height: 8em;padding-top: 2.8em;border-bottom: 2px solid #606060;">
      <span class="item-1" style="">วัน พุธ ที่ 18 กันยายน พ.ศ. 2562</span>
   </div>

   <div class="second_header" align="left">

      <div class="logo-group" style="">
         <div style=" display: inline-block;">
            <div style="float:left;">

               <?= single_img('kiosk/resources/images/logo.png', array('style' => 'width: 7.4em;height: 9.5em;', 'class' => 'rotate-vert-center')) ?>
            </div>
            <div style="float:left;padding-top: 2%;text-shadow: 1px 0px 0px #676767;">
               <p class="primary">โรงพยาบาลพระมงกุฎเกล้า</p>
               <p class="secondary">Phamongkutklao Hospital</p>
            </div>
         </div>
      </div>
   </div>

   <div class="btn_back">
      <button type="" style="color: #000; font-size: 2.2em">
         < ย้อนกลับ</button> </div> <div class="second_body">

            <div class="" style=" height: 378px; margin-top: 11em;">
               <div class="w3-card" style="box-shadow: 0px 0px 13px 6px #b5b5b5;margin: auto 0; width:88%;padding-top: .1em; height: 100%;border-radius: .4em; background-color: #fefefe;">
                  <div class="head_wc" style="width: 88%; height: 24%; border-bottom: 3px solid #606060;">
                     <h1>ยินดีต้อนรับ</h1>
                  </div>
                  <div style="width: 30%;height: 44%;float: left; padding: 0px 20px;padding-top: 2em;">
                    
                     <?= single_img('kiosk/resources/images/user.png', array('style' => 'height:16em;')) ?>
                  </div>
                  <div class="ct_user2" style="width: 70%;height: 70%;float: left; text-align: left; padding: 28px 17px 0px 14px;">

                     <h4>คุณเบญจวรรณ รัตนเพิ่ม</h4>
                     <h6>เลขบัตรประชาชน : <a>1-2345-67890-12-3</a></h6>
                     <h6>วัน / เดือน / ปีเกิด : <a>1/11/2000</a></h6>
                     <h6>HN : <a>wwwwww</a></h6>
                  </div>
               </div>
            </div>
            <!-- user -->
            <div id="boxContent" style="width: 100%; height: 58%">
               <?php
					if (isset($Content) && count($Content) > 0) {
						foreach ($Content as $result) :
							$this->load->view($Module.'/'.$result);
						endforeach;
					}
               ?>
            </div>
   </div>



</div>

		<?php
			
		?>

		<?=(isset($js) ? assets_js($js) : '');?>
		<?=(isset($node_modules) ? assets_node($node_modules) : '');?>

		<?php 
			if( isset($Script) && count($Script)>0 ){
				foreach($Script as $result) : 
					$this->load->view($Module.'/'.$result);
				endforeach;
			}
		?>
		
	</body>
</html>
