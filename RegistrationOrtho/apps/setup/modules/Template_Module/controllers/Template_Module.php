<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_Module extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }

    // ส่งค่า $templateData โดยใช้ array
    // 'Module' คือชื่อโมดูลที่เราจะใช้ดึงหน้า view ออกมา (view อยู่ในโมดูลไหน)
    // 'Site_Title' คือชื่อtitleของหน้านั้นๆที่ถูก โมดูล template เรียกไป
    // 'Content' คือหน้า view ที่ต้องการให้แสดงผล โดยกำหนดเป็น path ในโฟลเดอร์ view ของโมดูลนั้น
    // 'Script' คือหน้า view ที่เป็น Script ของโมดูลนั้น
    // 'css' คือไฟล์ css ที่ต้องการเรียกใช้จาก root/static โดยสามารถเปลี่ยนจาก static เป็น path อื่นได้โดยเปลี่ยนค่า $config['assets_path'] ใน config/assets.php
    // 'js' คือไฟล์ js ที่ต้องการเรียกใช้จาก root/static โดยสามารถเปลี่ยนจาก static เป็น path อื่นได้โดยเปลี่ยนค่า $config['assets_path'] ใน config/assets.php
    // 'node_modules' คือไฟล์ โมดูล node ที่ต้องการเรียกใช้จาก root/node_module โดยสามารถเปลี่ยนจาก node_module เป็น path อื่นได้โดยเปลี่ยนค่า $config['assets_node'] ใน config/assets.php
    // 'Data' คือข้อมูลที่ต้องการส่งผ่านจากโมดูลเข้ามาใช้ในview 
    // *Content/Script/css/js/node_modules/Data สามารถใส่จำนวนเท่าไหร่ก็ได้ เพราะตัว view template เรียกใช้งานโดยการวนลูปออกมาทั้งหมด
	//	สามารถระบุชื่อ Content ที่แสดงผลได้อิสระ เพื่อเป็นการโน้ตตัว view ใช้ทำงานอะไรได้
	//	ควรระบุ version ของไฟล์ assets ที่เรียกออกมาใช้ เพื่อให้สามารถเปลี่ยนแปลงเวอร์ชั่นได้ตลอดเวลาและไม่สับสน

    // Ex
    	//โมดูล Management
    	//เรียกใช้ view ชื่อ Manage.php
    	//มี view ที่เป็น script ชื่อ ManageScript.php
    	//เรียกใช้ file bootstrap จาก root/static/bootstrap/css/bootstrap.min.css 
    	//และ css เฉพาะของ view จาก root/static/css/dashboard_style.css 
    	//เรียกใช้ jquery จาก root/static/js/jquery-3.4.1.min.js
	/*
		$Template = array(
	        'Module' => 'Management',
	        'Site_Title' => 'DashQueue : Dashboard',
	        'Content' => array(
	            'Main' => 'Manage', 
	        ),
	        'Script' => array(
	            'Script' => 'ManageScript', 
	        ),
	        'css' => array(
	            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
	            'main' => 'css/dashboard_style.css', 
	        ),
	        'js' => array(
	            'popper1' => 'js/popper.min.js', 
	            'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
	            'jqueryDataTable' => 'jquerydataTable/js/jquery.dataTables.min.js', 
	        ),
	    );
	    $this->load->module('Template_Module');
        $this->template_module->MainTemplate($Template);
	*/

    public function MainTemplate($templateData){    	
        $this->load->module($templateData['Module']);
        $this->load->view('MainTemplate',$templateData);
    }

    public function PublicTemplate($templateData){        
        $this->load->module($templateData['Module']);
        $this->load->view('PublicTemplate',$templateData);
	}
	
	public function SlipTemplate($templateData){
		$this->load->module($templateData['Module']);
		$this->load->view('SlipTemplate',$templateData);
	}
}
