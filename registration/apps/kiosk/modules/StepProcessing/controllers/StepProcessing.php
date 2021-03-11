<?php

class StepProcessing extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('assets');
		// $this->load->module('StepProcessing/PersonType');
	}


	public function SlipMainPage($page, $title, $script)
	{
		$this->load->module('Template_Module');
		$this->load->module('Websocket');
		// $data['content'][0] = 'CheckTreatment/CheckTreatment_vw';
		// $this->load->view('StepProcessing_vw',$data);

		$Template = array(
			'Module' => 'StepProcessing',
			'Site_Title' => $title,
			'Content' => $page,
			'Script' => array(
				'Script' => $script
			),
			'css' => array(
				'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
				'fontawesome5.11.2' => 'fontawesome/css/all.css',
				'style_main' => 'kiosk/resources/css/second_style.css',
				'flexboxgrid' => 'kiosk/resources/css/flexboxgrid.css',
				'w3c' => 'kiosk/resources/css/w3c.css',
				'font-awesome' => 'kiosk/resources/font-awesome/css/font-awesome.min.css',
				'ModalCss' => 'kiosk/resources/css/ModalCss.css'
			),
			'js' => array(
				'popper1' => 'js/popper.min.js',
				'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
				'dataTables' => 'kiosk/resources/datatable/jquery.dataTables.min.js',
				'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js',

			),
			'node_modules' => array(
				'socket.io' => 'dist/socket.io.js',
			)
		);
		$this->template_module->SlipTemplate($Template);
	}

	public function publictemplate($page, $title, $script, $data = array())
	{
		$this->load->module('Template_Module');
		$this->load->module('Websocket');

		// $data['content'][0] = 'CheckTreatment/CheckTreatment_vw';
		// $this->load->view('StepProcessing_vw',$data);

		$Template = array(
			'Module' => 'StepProcessing',
			'Site_Title' => $title,
			'Content' => $page,
			'Script' => array(
				'Script' => $script,
			),
			'css' => array(
				'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
				'fontawesome5.11.2' => 'fontawesome/css/all.css',
				'style_main' => 'kiosk/resources/css/second_style.css',
				'flexboxgrid' => 'kiosk/resources/css/flexboxgrid.css',
				'w3c' => 'kiosk/resources/css/w3c.css',
				'main_css' => 'kiosk/resources/css/main_css.css',
				'font-awesome' => 'kiosk/resources/font-awesome/css/font-awesome.min.css',
				'ModalCss' => 'kiosk/resources/css/ModalCss.css'

			),
			'js' => array(
				'popper1' => 'js/popper.min.js',
				'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
				'dataTables' => 'kiosk/resources/datatable/jquery.dataTables.min.js',
				'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js'
			),
			'Data' => $data,
			'node_modules' => array(
				'socket.io' => 'dist/socket.io.js',
			)
		);
		$this->template_module->PublicTemplate($Template);
	}



	public function Slip()
	{
		$page = array('Main' => 'Slip/Slip_vw');
		$title = 'Slip';
		$script = 'Slip/Slip_script';
		$this->SlipMainPage($page, $title, $script);
	}


	public function Payor()
	{
		$page = array('Main' => 'Payor/Payor_vw');
		$title = 'Payor';
		$script = 'Payor/Payor_script';
		$this->publictemplate($page, $title, $script);
	}

	public function Appointment()
	{
		$page = array('Main' => 'Appointment/Appointment_vw');
		$title = 'Appointment';
		$script = 'Appointment/Appointment_script';
		$this->publictemplate($page, $title, $script);
	}

	public function ProcessService()
	{
		//extend :convert from api/worklist/process 
		//$worklistgroup = isset($this->session->userdata('SessionMain')['worklistgroup'])?$this->session->userdata('SessionMain')['worklistgroup']:$this->session->userdata('SessionMain')['UserInfo']['worklistgroup'];
		//$this->load->module('cv_api');
		//$data['worklist_process'] = $this->cv_api->worklist_process($worklistgroup);
		$data = array();
		$page = array('Main' => 'ProcessService/ProcessService_vw');
		$title = 'ProcessService';
		$script = 'ProcessService/ProcessService_script';
		$this->publictemplate($page, $title, $script, $data);
	}

	public function ProcessServiceClear()
	{
		//echo json_encode($this->session->userdata());die();9

		$page = array('Main' => 'ProcessServiceClear/ProcessServiceClear_vw');
		$title = 'ProcessServiceClear';
		$script = 'ProcessServiceClear/ProcessServiceClear_script';
		$this->publictemplate($page, $title, $script);
	}

	public function PersonType()
	{
		$page = array('Main' => 'PersonType/PersonType_vw');
		$title = 'PersonType';
		$script = 'PersonType/PersonType_scripe';
		$this->publictemplate($page, $title, $script);
	}

	public function WelcomeNoHn()
	{
		$page = array('Main' => 'WelcomeNoHn/WelcomeNoHn_vw');
		$title = 'WelcomeNoHn';
		$script = 'WelcomeNoHn/WelcomeNoHn_script';
		$this->publictemplate($page, $title, $script);
	}


	public function ClearSessionAll()
	{
		$this->session->unset_userdata('PatientInfo');
		$this->session->unset_userdata('SessionMain');
		$this->session->unset_userdata('SessionClinicName');
		echo json_encode("TRUE");

		return true;
	}

	public function ClearSessionOffline()
	{
		$this->session->unset_userdata('PatientInfo');
		$this->session->unset_userdata('SessionOfflineMode');
		echo json_encode("TRUE");
		return true;
	}

	public function CreateSession()
	{


		if (!$this->session->userdata('SessionMain')) {
			$data = $this->input->post('data');

			if ($data['step'] == 'next3') {
				$sesData = array(
					'PatientNewOrOld' => array(
						'PatientNewOrNoHn' => 'PatientOld',
					),
					'UserInfo' => $data
				);
			} else {
				$sesData = array(
					'UserInfo' => $data
				);
			}

			$this->session->set_userdata('SessionMain', $sesData);

			echo json_encode($this->session->userdata('SessionMain'));
		} else {
			echo json_encode($this->session->userdata('SessionMain'));
		}
	}

	public function CreateSesInfoPageNoHn()
	{
		// echo "<pre>"; print_r($this->input->post('patient')); die();
		$data = $this->input->post('patient');
		
		$sesData = array(
			'UserInfo' => $data
		);

		$this->session->set_userdata('SessionMain', $sesData);

		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function CreateSesPagePersonType()
	{
		$typeval = $this->input->post('typeval');
		$sesData = array(
			'PersonType' => $typeval
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['PersonType'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($typeval);
	}

	public function CreateSesPagePayor()
	{
		$payor_active = $this->input->post('payor_active');
		$sesData = array(
			'PayorActive' => $payor_active
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['PayorActive'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function CreateSesPageNoHnNew()
	{
		$data = $this->input->post('data');
		$sesData = array(
			'PatientNewOrNoHn' => $data
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['PatientNewOrOld'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($data);
	}


	public function CreateSesPageNoHnNo()
	{
		if (empty($this->session->userdata('SessionMain')['PatientNewOrOld'])) {
			$data = $this->input->post('data');
			$sesData = array(
				'PatientNewOrOld' => $data
			);

			$GetSession = $this->session->userdata('SessionMain');

			$GetSession['PatientNewOrNoHn'] = $sesData;

			echo json_encode($this->session->set_userdata('SessionMain', $GetSession));
		} else {
			echo json_encode($this->session->set_userdata('SessionMain', $GetSession));
		}
	}


	public function CreateSesPagePtOld()
	{

		$data = $this->input->post('data');
		$sesData = array(
			'PatientNewOrNoHn' => $data
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['PatientNewOrOld'] = $sesData;

		echo json_encode($this->session->set_userdata('SessionMain', $GetSession));
	}


	public function CreatePtAppointment()
	{
		$data = $this->input->post('appointment');
		$sesData = array(
			'Appointment' => $data
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['Appointment'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($data);
	}


	public function CreateSesQueueNew()
	{
		$data = $this->input->post('QueueNew');
		$typeuid = $this->input->post('Typeuid');
		$patientuid = $this->input->post('Patientuid');
		$sesData = array(
			'QueueNew' => $data,
			'Typeuid' => $typeuid,
			'Patientuid' => $patientuid
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['QueueNew'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}


	public function CreateSesPtShow()
	{

		$data = $this->input->post('PtDetail');

		//echo json_encode($data); exit();
		$sesData = array(
			'PtDetail' => $data
		);

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['PtDetail'] = $sesData;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}


	public function CreateSesNumberPage()
	{

		$data = '5';

		$sesData = array(
			'NumberPage' => $data,
			'NowPage' => '1'
		);

		$GetSession['NumberPage'] = $sesData;

		$this->session->set_userdata('SessionNumPage', $GetSession);


		echo json_encode($this->session->userdata('SessionNumPage'));
	}

	public function CreateSesNumberPageUpdate()
	{

		$data = '5';
		$data_page_now = $this->input->post('pagenow');
		$sesData = array(
			'NumberPage' => $data,
			'NowPage' => $data_page_now
		);

		$GetSession = $this->session->userdata('SessionNumPage');

		$GetSession['NumberPage'] = $sesData;

		$this->session->set_userdata('SessionNumPage', $GetSession);


		echo json_encode($this->session->userdata('SessionNumPage'));
	}


	// public function UpdateUserInfo()
	// {

	// 	$data = $this->input->post('worklistgroup');

	// 	$GetSession = $this->session->userdata('SessionMain');

	// 	$GetSession['UserInfo']['worklistgroup'] = $data;

	// 	$this->session->set_userdata('SessionMain', $GetSession);


	// 	echo json_encode($this->session->userdata('SessionMain'));
	// }


	// NEW
	public function UpdateUserInfo()
	{

		$data = $this->input->post('worklistgroup');

		$oldworklistgroup = $this->input->post('oldworklistgroup');

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['UserInfo']['worklistgroup'] = $data;
		$GetSession['UserInfo']['oldworklistgroup'] = $oldworklistgroup;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function UpdateUserInfotoOld()
	{

		$data = $this->input->post('worklistgroup');

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['UserInfo']['worklistgroup'] = $data;
		$GetSession['UserInfo']['oldworklistgroup'] = '';

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}
	// END NEW


	public function CreateSesKioskLocation()
	{
		$location_id = $this->input->get('location_id');

		$data = array('kiosk_location' => $location_id);

		$this->session->set_userdata($data);

		// var_dump($this->session->userdata('kiosk_location'));
		// die();
		redirect(PROJECTPATH);
		exit(0);
	}


	public function CreateclinicName()
	{
		$Appointment = $this->input->post('Appointment');
		$clinicName = $this->input->post('clinicName');

		$data = array('Appointment' => $Appointment, 'clinicName' => $clinicName);

		$this->session->set_userdata('SessionClinicName', $data);

		echo json_encode($this->session->userdata('SessionClinicName'));
	}


	public function demotest()
	{
		$json = file_get_contents(APPPATH.'modules/StepProcessing/views/cadit_example.json');
		$obj  = json_decode($json);
		echo json_encode($obj);
	}

	public function CreateOffline()
	{

		$data = array('OfflineMode' => 'Manual', 'With' => 'Patient_HIS');

		$this->session->set_userdata('SessionOfflineMode', $data);

		echo json_encode($this->session->userdata('SessionOfflineMode'));
	}

	public function CreateOfflineApiErrorAppointment()
	{
		// echo "<pre>"; print_r($this->input->post('data')); die();
		// $info = $this->input->post('infoData');
		$data = array('OfflineMode' => 'Manual', 'With' => 'Appointment');

		$this->session->set_userdata('SessionOfflineMode', $data);

		echo json_encode($this->session->userdata('SessionOfflineMode'));
	}

	public function groupSesOffline()
	{
		$data = $this->input->post('group');

		$GetSession = $this->session->userdata('SessionMain');
		// $GetSession['UserInfo']['worklistgroup'] = $data;
		$GetSession['worklistgroup'] = $data;

		$this->session->set_userdata('SessionMain', $GetSession);
		// var_dump($this->session->userdata('SessionMain')); die();


		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function changeOldPatientGroupAppointOffline()
	{
		$data = $this->input->post('group');

		$GetSession = $this->session->userdata('SessionMain');

		if(!isset($GetSession['UserInfo']) || $GetSession['UserInfo'] == '' || $GetSession['UserInfo'] == null){
			$GetSession['worklistgroup'] = $data;
		}else{
			$GetSession['UserInfo']['worklistgroup'] = $data;
		}
		$GetSession['worklistgroup'] = $data;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function changeOldPatientNoNutGroupAppointOffline()
	{
		$data = $this->input->post('group');

		$GetSession = $this->session->userdata('SessionMain');

		$GetSession['UserInfo']['worklistgroup'] = $data;
		$GetSession['worklistgroup'] = $data;

		$this->session->set_userdata('SessionMain', $GetSession);


		echo json_encode($this->session->userdata('SessionMain'));
	}

	public function openVisit()
	{
		$hn = $this->input->post('HN');

		$hn_get = curl_init();  
		// $get = "http://27.254.59.21/ords/pmkords/hlab/credit-master/".$hn;
		// print_r($get); die();

		$APIURL = "http://191.123.95.38:8181/ords/pmkords/hlab/credit-master/".$hn;
 
	    curl_setopt($hn_get,CURLOPT_URL,$APIURL);
        curl_setopt($hn_get, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YXJtOjEyMzQ=',
        ));        
		curl_setopt($hn_get,CURLOPT_RETURNTRANSFER,1);
		// curl_setopt($hn_get, CURLOPT_HTTPHEADER, array(
		// 	'Content-Type: application/json'
		// ));
		curl_setopt($hn_get, CURLOPT_TIMEOUT, 3);

		$result = curl_exec($hn_get);
		// echo "<pre>"; print_r($result); die();
		curl_close($hn_get);

		echo json_encode($result);
		// echo "TEST";
	}

	public function getOpenAuto(){
		$postData = $this->input->post();
		$this->load->model('Md_PersonType');
		$response = $this->Md_PersonType->getPayorByType($postData);
		//$this->session->set_userdata('user_payor',$response);
		echo json_encode($response);
		return true;
	}

}
