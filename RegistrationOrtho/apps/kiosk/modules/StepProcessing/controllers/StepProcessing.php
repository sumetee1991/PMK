<?php

class StepProcessing extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('assets');
		// $this->load->module('StepProcessing/PersonType');
		$this->load->model('Md_PersonType');
	}

public function show_get_worklistprocess($worklistgroup_id){
   $this->load->model('Md_PersonType');
  $data= $this->Md_PersonType->worklist_process($worklistgroup_id);

}

public function visitCurl(){
	
	$postData = $this->input->post();
   
	$p_run_hn = $this->input->post('p_run_hn');
	$p_year_hn = $this->input->post('p_year_hn');
	$p_opd = $this->input->post('p_opd');
	$p_user_created = $this->input->post('p_user_created');
	$p_visit_type = $this->input->post('p_visit_type');
   
	$postCURL = [
	  'p_run_hn'=> intval($p_run_hn),
	  'p_year_hn'=> intval($p_year_hn),
	  'p_opd'=> $p_opd,
	  'p_user_created'=> $p_user_created,
	  'p_visit_type'=> $p_visit_type
   ];
 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,VISITAPI);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postCURL));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $result = curl_exec($ch);
   $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   
   $message = array(
	  'code' => $httpcode,
	  'postData' => $postCURL,
	  'result' => isset($result)?$result:false,
   );
//    $postData['code'] = $message['code'];
//    $postData['result'] = $message['result'];
//    $LogAPI = $this->Management_Model->InsertLogAPI($postData);
//    $message['log_id'] = $LogAPI;
   echo json_encode($message);
   
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
		$worklistgroup = isset($this->session->userdata('SessionMain')['worklistgroup']) ? $this->session->userdata('SessionMain')['worklistgroup'] : $this->session->userdata('SessionMain')['UserInfo']['worklistgroup'];
		//$this->load->module('cv_api');
		$data['worklist_process'] = $this->worklist_process($worklistgroup);
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


	public function ClearSessionAll() // zaza
	{
		$ClearSessionAll = $this->input->post('frompccsvclear');

		if (gettype($ClearSessionAll) == null) {
			$this->session->unset_userdata('PatientInfo');
		}

		$this->session->unset_userdata('pageredirect');
		$this->session->unset_userdata('Createoldnoappoint');
		$this->session->unset_userdata('APISession');
		$this->session->unset_userdata('SessionMain');
		$this->session->unset_userdata('SessionClinicName');
		$this->session->unset_userdata('usepayor');
		$this->session->unset_userdata('patientOldNoAppoint');
		$this->session->unset_userdata('sesPayorRoom');

		

		$data['indexpagenow'] = 0;
		$data['worklistgroup'] = null;
		$listpage = array(
			['lasturi' => 'Kiosk', 'fullurl' => APPURL]
		);
		$data['listpage'] = $listpage;

		$this->session->set_userdata('pageredirect', $data);

		echo json_encode($this->session->userdata('pageredirect'));
	}

	public function ClearSessionOffline()
	{
		$this->session->unset_userdata('pageredirect');
		$this->session->unset_userdata('Createoldnoappoint');
		$this->session->unset_userdata('APISession');
		$this->session->unset_userdata('PatientInfo');
		$this->session->unset_userdata('SessionOfflineMode');
		$this->session->unset_userdata('usepayor');
		$this->session->unset_userdata('patientOldNoAppoint');
		$this->session->unset_userdata('sesPayorRoom');

		$data['indexpagenow'] = 0;
		$data['worklistgroup'] = null;
		$listpage = array(
			['lasturi' => 'Kiosk', 'fullurl' => APPURL]
		);
		$data['listpage'] = $listpage;

		$this->session->set_userdata('pageredirect', $data);

		echo json_encode($this->session->userdata('pageredirect'));
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

    $queuelocation=$this->session->userdata('queuelocation');

     // var_dump($queuelocation);
     // exit();
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


  $get_roompayor = $this->Md_PersonType->getpayorroom($payor_active);

  $data2['PayorRoom'] = $get_roompayor[0]['counter'];

  $this->session->set_userdata('sesPayorRoom', $data2);


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

// คนไข้มีนัดไหม  อายุกรรม
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

public function CreateSesNumberPageoff()
{
  $data = '4';
  $sesData = array(
   'NumberPage' => $data,
   'NowPage' => '2'
);
  $GetSession['NumberPage'] = $sesData;

  $this->session->set_userdata('SessionNumPage', $GetSession);

  echo json_encode($this->session->userdata('SessionNumPage'));
}



public function CreateSesNumberPage()
{
  $data = '4';
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
  $data = '4';
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
// var_dump($data);
// exit();
  $oldworklistgroup = $this->input->post('oldworklistgroup');

  $GetSession = $this->session->userdata('SessionMain');

  $GetSession['UserInfo']['worklistgroup'] = $data;
  $GetSession['UserInfo']['oldworklistgroup'] = $oldworklistgroup;

  $this->session->set_userdata('SessionMain', $GetSession);
// echo '<pre>';
// var_dump($this->session->userdata('SessionMain'));
// echo '</pre>';
// exit();
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

// หน้าแรก Kios
public function CreateSesKioskLocation()
{
 $this->load->model('Md_PersonType');
  $location_id = $this->input->get('location_id');
 
  $queuelocation = $this->Md_PersonType->check_kiosklocation($location_id);
  $data = array('kiosk_location' => $location_id,
   'queuelocation' => $queuelocation[0]->queuelocation_id);
  $this->session->set_userdata($data);
		// var_dump($this->session->userdata('queuelocation'));
		// die();
  redirect(PROJECTPATH);
  exit(0);
}
// หน้าแรก Kios

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
 $json = file_get_contents(APPPATH . 'modules/StepProcessing/views/cadit_example.json');
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

public function Createoldnoappoint()
{

 $data = array('oldnoappoint' => 'true');

 $this->session->set_userdata('Createoldnoappoint', $data);

 echo json_encode($this->session->userdata('Createoldnoappoint'));
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

 if (!isset($GetSession['UserInfo']) || $GetSession['UserInfo'] == '' || $GetSession['UserInfo'] == null) {
   $GetSession['worklistgroup'] = $data;
} else {
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

 $APIURL = APIURL . "/credit-master/" . $hn;

 curl_setopt($hn_get, CURLOPT_URL, $APIURL);
 curl_setopt($hn_get, CURLOPT_HTTPHEADER, array(
   'Authorization: Basic YXJtOjEyMzQ=',
));
 curl_setopt($hn_get, CURLOPT_RETURNTRANSFER, 1);
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

public function updateoldnoappoint()
{
 $group = $this->input->post('group');

 $GetSession = $this->session->userdata('SessionMain');

 $GetSession['UserInfo']['worklistgroup'] = $group;
 $GetSession['worklistgroup'] = $group;

 $this->session->set_userdata('SessionMain', $GetSession);


 echo json_encode($this->session->userdata('SessionMain'));
}

public function getOpenAuto()
{
 $postData = $this->input->post();
 $this->load->model('Md_PersonType');
 $response = $this->Md_PersonType->getPayorByType($postData);
		//$this->session->set_userdata('user_payor',$response);
 echo json_encode($response);
 return true;
}

public function API_OldPatient($data)
{
		$IDCard = $data['idcard']; //'3101401946651';
		$HN = $data['hn']; //'44800/62';
		$SearchIDCard = $IDCard;
		$SearchHN = explode('/', $HN)[1] . '/' . explode('/', $HN)[0];
		$URL = PATIENTAPI . '/' . $SearchHN . '/' . $SearchIDCard;
// var_dump($URL);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Basic YXJtOjEyMzQ=',
		));
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = array(
			'success' => $result ? true : false,
			'code' => $httpcode,
			'result' => json_decode($result, TRUE)
		);
		return $response;
	}

	public function API_AppointmentData($data)
	{
		$AppointmentDate = isset($data['appointmentdate']) ? $data['appointmentdate'] : date('Y-m-d'); //'2019-11-25';
		$HN = $data['hn']; //'44800/62';
		$SearchDate = $AppointmentDate;
		$SearchHN = explode('/', $HN)[1] . '/' . explode('/', $HN)[0];
		$URL =  APPOINTMENTAPI . '/' . $SearchDate . '/null/' . $SearchHN;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Basic YXJtOjEyMzQ=',
		));
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = array(
			'success' => $result ? true : false,
			'code' => $httpcode,
			'result' => json_decode($result, TRUE)
		);
		return $response;
	}

	public function API_LastPayorHN($data)
	{
		$PayorDate = isset($data['payordate']) ? $data['payordate'] : date('Y-m-d'); //'2020-01-31';
		$HN = $data['hn']; //'13333/99';
		$SearchDate = $PayorDate;
		$SearchHN = explode('/', $HN)[1] . '/' . explode('/', $HN)[0];
		$URL = CREDITAPI . '/' . $SearchHN . '/null/' . $SearchDate;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Basic YXJtOjEyMzQ=',
		));
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = array(
			'success' => $result ? true : false,
			'code' => $httpcode,
			'result' => json_decode($result, TRUE)
		);
		return $response;
	}

	public function API_CreditMasterHN($data)
	{
		$HN = $data['hn']; //'13333/99';
		$SearchHN = explode('/', $HN)[1] . '/' . explode('/', $HN)[0];
		$URL = CREDITMASTERAPI . '/' . $SearchHN;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Basic YXJtOjEyMzQ=',
		));
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = array(
			'success' => $result ? true : false,
			'code' => $httpcode,
			'result' => json_decode($result, TRUE)
		);
		return $response;
	}

	public function APICHECK($data)
	{
		//Check Appointment
		$AppointmentAPI = $this->API_AppointmentData($data);
		if ($AppointmentAPI['success'] && $AppointmentAPI['code'] == 200 && $AppointmentAPI['result']) {
			$API['Appointment'] = $AppointmentAPI['result'];
		} else {
			$API['Appointment'] = false;
		}
		//Check LastPayor
		$LastPayorAPI = $this->API_LastPayorHN($data);
		if ($LastPayorAPI['success'] && $LastPayorAPI['code'] == 200 && $LastPayorAPI['result']) {
			$API['LastPayor'] = $LastPayorAPI['result'];
		} else {
			$API['LastPayor'] = false;
		}
		//Check CreditMaster
		$CreditMasterAPI = $this->API_CreditMasterHN($data);
		if ($CreditMasterAPI['success'] && $CreditMasterAPI['code'] == 200 && $CreditMasterAPI['result']) {
			$API['CreditMaster'] = $LastPayorAPI['result'];
		} else {
			$API['CreditMaster'] = false;
		}
		return $API;
	}

	public function scanInput()
	{
	
		$this->load->model('Md_PersonType');
		$Input = $this->input->post();
		
		$chkOldPatientData = array(
			'hn' => 'null/null',
			'idcard' => $Input['citizenid']
		);
		$chkOldPatient = $this->API_OldPatient($chkOldPatientData);
		if ($chkOldPatient['success'] && $chkOldPatient['code'] == 200 && $chkOldPatient['result']) {
			$PatientData = isset($chkOldPatient['result'][0]) ? $chkOldPatient['result'][0] : $chkOldPatient['result'];
		}

if($Input['gender']==1){
$gender='m';
}else if($Input['gender']==2){
	$gender='f';
}else{
	$gender='n';
}

		$response['data'] = array(
			'scan' => true,
			'idcard' => $Input['citizenid'],
			'hn' => isset($PatientData) ? $PatientData['hn'] : '',
			'prename' => $Input['prefixname_th'],
			'forename' => $Input['firstname_th'],
			'surname' => $Input['lastname_th'],
			'dob' => $Input['dob'],
			'gender' => $gender, //1 = Male
		);
		$response['data']['pidxxx'] = substr($response['data']['idcard'], 0, 4) . 'xxxxx' . substr($response['data']['idcard'], 9, 4);
		$this->session->set_userdata('PatientInfo', $response); //Set PatientInfo Session
		echo json_encode($response);

		//////////////////
		// API SECTION //
		//////////////////

		if (isset($PatientData)) {
			$API = $this->APICHECK(array('hn' => isset($PatientData) ? $PatientData['hn'] : $Input['input']));
			$APISession = array(
				'Appointment' => $API['Appointment'],
				'Payor' => array(
					'Payor' => $this->Md_PersonType->getpayor(),
					'dataLastPayorAll' => $API['LastPayor'],
					'dataLastPayor' => end($API['LastPayor']),
				)
			);
			$this->session->set_userdata('APISession', $APISession);
		}

		return true;
	}

	public function manualInput()
	{
		$this->load->model('Md_PersonType');
		$Input = $this->input->post();
		$explode_input = explode('r', $Input['input']);


		if (strlen($Input['input']) == 13) {
			$inputType = 0;
			$chkOldPatientData = array(
				'hn' => 'null/null',
				'idcard' => $Input['input']
			);
		} else if (count($explode_input) == 2) {

			$result = $this->Md_PersonType->getPatientRefno($Input['input']);
			$inputType = 3;
			$chkOldPatientData = array(
				'hn' =>  $result[0]['hn'],
				'idcard' => $result[0]['idcard']
			);
		} else {
			$inputType = 1;
			$chkOldPatientData = array(
				'hn' => $Input['input'],
				'idcard' => 'null'
			);
		}
		$chkOldPatient = $this->API_OldPatient($chkOldPatientData);
		if ($chkOldPatient['success'] && $chkOldPatient['code'] == 200 && $chkOldPatient['result']) {
			$PatientData = isset($chkOldPatient['result'][0]) ? $chkOldPatient['result'][0] : $chkOldPatient['result'];
		}
		$response['data'] = array(
			'scan' => false,
			'idcard' => isset($PatientData) ? $PatientData['pid'] : (($inputType == 0 || $inputType == 3) ? $Input['input'] : ''),
			'hn' => isset($PatientData) ? $PatientData['hn'] : (($inputType == 1 || $inputType == 3) ? $Input['input'] : ''),
			'prename' => isset($PatientData) ? $PatientData['preName'] : '',
			'forename' => isset($PatientData) ? $PatientData['firstName'] : '',
			'surname' => isset($PatientData) ? $PatientData['lastName'] : '',
			'dob' => isset($PatientData) ? date('d/m/Y', strtotime($PatientData['birthDate'] . "+543 year")) : '',
			'gender' => isset($PatientData) ? ($PatientData['gender'] == 'หญิง' || $PatientData['gender'] == 'Female' || $PatientData['gender'] == 'female' ? 'f' : 'm') : '0',
		);
		$response['data']['pidxxx'] = substr($response['data']['idcard'], 0, 4) . 'xxxxx' . substr($response['data']['idcard'], 9, 4);
		$this->session->set_userdata('PatientInfo', $response); //Set PatientInfo Session
		echo json_encode($response);

		//////////////////
		// API SECTION //
		//////////////////

		if (isset($PatientData) || $inputType == 1) {
			$API = $this->APICHECK(array('hn' => isset($PatientData) ? $PatientData['hn'] : $Input['input']));
			$APISession = array(
				'Appointment' => $API['Appointment'],
				'Payor' => array(
					'Payor' => $this->Md_PersonType->getpayor(),
					'dataLastPayorAll' => $API['LastPayor'],
					'dataLastPayor' => end($API['LastPayor']),
				)
			);
			$this->session->set_userdata('APISession', $APISession);
		}

		return true;
	}

	public function worklist_process($worklistgroupuid)
	{
		$this->load->model('MDL_worklist');
		$query = $this->MDL_worklist->process($worklistgroupuid);
		return $query->num_rows() > 0 ? $query->result() : false;
	}

	public function worklist_process_clear($patientuid)
	{
		$this->load->model('MDL_worklist');
		$query = $this->MDL_worklist->process_clear($patientuid);
		return $query->num_rows() > 0 ? $query->result() : false;
	}

	public function clearpageredirect()
	{
		$this->session->unset_userdata('pageredirect');
		return true;
	}

	public function createPageRedirect()
	{

		$fullurl 	= 	$this->input->post('fullurl');
		$worklistgroup 	= 	$this->input->post('worklistgroup');



		if ($this->session->userdata('pageredirect') == null || $this->session->userdata('pageredirect')['indexpagenow'] == 0) {


			$data['worklistgroup'] = $worklistgroup;
			$data['listpage'] = array();

			if ($worklistgroup == '3') { //ผู่ป่วยใหม่
				$data['indexpagenow'] = 1;
				$listpage = array(
					['lasturi' => 'Kiosk', 'fullurl' => APPURL],
					['lasturi' => 'WelcomeNoHn', 'fullurl' => $fullurl . 'WelcomeNoHn'],
					['lasturi' => 'PersonType', 'fullurl' => $fullurl . 'PersonType'],
					['lasturi' => 'Payor', 'fullurl' => $fullurl . 'Payor'],
					['lasturi' => 'ProcessService', 'fullurl' => $fullurl . 'ProcessService'],
					['lasturi' => 'Slip', 'fullurl' => $fullurl . 'Slip']
				);
			} else if ($worklistgroup == '1') { //ผู้ป่วยเก่า/ไม่มีนัดหมาย
				$data['indexpagenow'] = 1;
				$listpage = array(
					['lasturi' => 'Kiosk', 'fullurl' => APPURL],
					['lasturi' => 'WelcomeNoHn', 'fullurl' => $fullurl . 'WelcomeNoHn'],
					['lasturi' => 'PersonType', 'fullurl' => $fullurl . 'PersonType'],
					['lasturi' => 'Payor', 'fullurl' => $fullurl . 'Payor'],
					['lasturi' => 'ProcessService', 'fullurl' => $fullurl . 'ProcessService'],
					['lasturi' => 'Slip', 'fullurl' => $fullurl . 'Slip']
				);
			} else if ($worklistgroup == '2') { //ผู้ป่วยเก่า/มีนัดหมาย
				$data['indexpagenow'] = 1;
				$listpage = array(
					['lasturi' => 'Kiosk', 'fullurl' => APPURL],
					['lasturi' => 'Appointment', 'fullurl' => $fullurl . 'Appointment'],
					['lasturi' => 'PersonType', 'fullurl' => $fullurl . 'PersonType'],
					['lasturi' => 'Payor', 'fullurl' => $fullurl . 'Payor'],
					['lasturi' => 'ProcessService', 'fullurl' => $fullurl . 'ProcessService'],
					['lasturi' => 'Slip', 'fullurl' => $fullurl . 'Slip']
				);
			} else if ($worklistgroup == 'offlinemode') {
				$data['indexpagenow'] = 1;
				$listpage = array(
					['lasturi' => 'Kiosk', 'fullurl' => APPURL],
					['lasturi' => 'WelcomeNoHn', 'fullurl' => $fullurl . APPNAME . '/StepProcessing/WelcomeNoHn'],
					['lasturi' => 'PersonType', 'fullurl' => $fullurl . APPNAME . '/StepProcessing/PersonType'],
					['lasturi' => 'Payor', 'fullurl' => $fullurl . APPNAME . '/StepProcessing/Payor'],
					['lasturi' => 'ProcessService', 'fullurl' => $fullurl . APPNAME . '/StepProcessing/ProcessService'],
					['lasturi' => 'Slip', 'fullurl' => $fullurl . APPNAME . '/StepProcessing/Slip']
				);
			}
			$data['listpage'] = $listpage;
		} else {
			$indexpage = $this->input->post('indexpage');
			$tem_url = $this->input->post('tem_url');

			if ($indexpage == null) {
				$data['indexpagenow'] = $this->session->userdata('pageredirect')['indexpagenow'];
			} else {

				if ($this->session->userdata('pageredirect')['listpage'][$indexpage]['lasturi'] == $tem_url) { //กันการกดย้ำๆ
					$data['indexpagenow'] = intval($indexpage + 1);
				} else {
					$data['indexpagenow'] = $this->session->userdata('pageredirect')['indexpagenow'];
				}
			}

			$data['worklistgroup'] = $this->session->userdata('pageredirect')['worklistgroup'];
			$data['listpage'] = $this->session->userdata('pageredirect')['listpage'];
		}


      $this->session->set_userdata('pageredirect', $data);

      echo json_encode($this->session->userdata('pageredirect'));
   }

   public function backPageRedirect()
   {

	$indexpage = $this->session->userdata('pageredirect')['indexpagenow'];

    $lasturl_now = $this->input->post('tem_url');

    if ($indexpage != 0) {
      $data['indexpagenow'] = intval($indexpage - 1);
      $data['worklistgroup'] = $this->session->userdata('pageredirect')['worklistgroup'];
      $data['listpage'] = $this->session->userdata('pageredirect')['listpage'];

      $this->session->set_userdata('pageredirect', $data);
      if (($lasturl_now == 'WelcomeNoHn' && $indexpage == 2) || ($lasturl_now == 'Appointment' && $indexpage == 2)) {
        echo json_encode($data['listpage'][0]['fullurl']);
     } else {
        echo json_encode($data['listpage'][$data['indexpagenow']]['fullurl']);
     }
  } else if ($indexpage == 0) {

   $data['listpage'] = $this->session->userdata('pageredirect')['listpage'];

   echo json_encode($data['listpage'][0]['fullurl']);
}
}

public function callsespageredirect()
{
 echo json_encode($this->session->userdata('pageredirect'));
}

public function CreateLogPayor()
{
 $hiscode = $this->input->post('hiscode');
 $statusauto = $this->input->post('statusauto');

 $data['hiscode'] = $hiscode;
 $data['statusauto'] = $statusauto;

 $this->session->set_userdata('usepayor', $data);

 echo json_encode($this->session->userdata('usepayor'));
}

public function GetLogPayor()
{
 $kiosk_location = $this->session->userdata('SessionMain')['UserInfo']['kiosk_location'];
 $messionmain = $this->session->userdata('SessionMain')['UserInfo']['data'][0];
 $usepayor = $this->session->userdata('usepayor');

 $data['hn'] = $messionmain['hnno'];
 $data['idcard'] = $messionmain['idcard'];
 $data['hiscode'] = $usepayor['hiscode'];
 $data['statusauto'] = $usepayor['statusauto'];
 $data['kiosk_location'] = $kiosk_location;

 echo json_encode($data);
}

public function callsesmain()
{
 echo json_encode($this->session->userdata('SessionMain'));
}
public function callsesoffline()
{
 echo json_encode($this->session->userdata('SessionOfflineMode'));
}
public function insertlogpayor()
{

 $result = $this->Md_PersonType->insertLogPayor();

 echo json_encode($result);
}

public function createPtNoAppoint()
{
 $worklistgroup = $this->input->post('worklistgroup');

 $data['status'] = 'ptnoappointment';
 $data['worklistgroupdf'] = $worklistgroup;

 $this->session->set_userdata('patientOldNoAppoint', $data);

 echo json_encode($this->session->userdata('patientOldNoAppoint'));
}

public function callSesPtOldNoApp()
{
 echo json_encode($this->session->userdata('patientOldNoAppoint'));
}
}
