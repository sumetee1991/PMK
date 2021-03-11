<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

class Management extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }

    public function index(){
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'Management',
            'Site_Title' => '',
            'Script' => array(
                'ManagementScript' => 'Index_Script',

            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
            ),
        );
        $this->template_module->MainTemplate($Template);

        //$this->Setup();
    }

    public function Setup()
    {
        $this->load->module('Template_Module');
        
        $Template = array(
            'Module' => 'Management',
            'Site_Title' => '',
            'Content' => array(
                'Main' => 'Setup/Setup', 
            ),
            'Script' => array(       
                'Config_Variable' => 'Setup/Setup_JS_Var', 
                'Function' => 'Setup/Setup_JS_Function', 
                'Script' => 'Setup/Setup_Script', 
                'ManagementScript' => 'Management_Script',           
            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
        );

        $this->template_module->MainTemplate($Template);
    }

    public function AltDashboard()
    {        
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'Management',
            'Site_Title' => '',
            'Content' => array(
                'Main' => 'Management_Body', 
                'Additional_Modal' => 'ALT_Dashboard/ALT_Dashboard_Modal',
                //'Additional' => 'ALT_Dashboard/ALT_Dashboard_Mini', 
            ),
            'Script' => array(
                'Config_Variable' => 'ALT_Dashboard/ALT_Dashboard_JS_Var', 
                'Function' => 'ALT_Dashboard/ALT_Dashboard_JS_Function', 
                'Script' => 'QueueDashboard_Script', 
                'ManagementScript' => 'Management_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
            'Data' => array(
                'TitleText' => 'คิวทำประวัติ',
                'Template_Content' => array(
                    'Main' => 'Management/ALT_Dashboard/ALT_Dashboard',
                ),
            ),
        );
        $this->template_module->MainTemplate($Template);
    }

    public function Dashboard()
    {        
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'Management',
            'Site_Title' => '',
            'Content' => array(
                'Main' => 'Management_Body', 
                'Additional_Modal' => 'Dashboard/Dashboard_Modal', 
                //'Additional' => 'Dashboard/Dashboard_Mini', 
            ),
            'Script' => array(
                'Config_Variable' => 'Dashboard/Dashboard_JS_Var', 
                'Function' => 'Dashboard/Dashboard_JS_Function', 
                'Script' => 'QueueDashboard_Script', 
                'ManagementScript' => 'Management_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
            'Data' => array(
                'TitleText' => 'คิวเปิดสิทธิ',
                'Template_Content' => array(
                    'Main' => 'Management/Dashboard/Dashboard',
                ),
            ),
        );
        $this->template_module->MainTemplate($Template);
    }

    public function Filter($BuildingUID = '0')
    {
        $this->load->module('Template_Module');
        $this->load->model('Management_Model');
        $this->load->model('TB_Management_Model');
        
        if($BuildingUID == '0'){
            $BuildingUID = $this->Management_Model->GetFirstBuilding()->uid;
        }
        $Template = array(
            'Module' => 'Management',
            'Site_Title' => '',
            'Content' => array(
                'Main' => 'Management_Body',  
            ),
            'Script' => array(
                'Config_Variable' => 'Filter/Filter_JS_Var', 
                'Function' => 'Filter/Filter_JS_Function', 
                'Script' => 'Filter/Filter_Script', 
                'ManagementScript' => 'Management_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
            'Data' => array(
                'TitleText' => 'คิวคัดกรอง',
                'Template_Content' => array(
                    'Main' => 'Management/Filter/Filter',
                ),
                'Building' => $this->TB_Management_Model->GetBuilding(),
                'Building_Floor' => $this->TB_Management_Model->GetBuildingFloor($BuildingUID),
                'Building_Room' => ( $BuildingUID == 0 ? $this->TB_Management_Model->GetAllRoom():$this->TB_Management_Model->GetBuildingRoom($BuildingUID) ),
                'Room' => $this->Management_Model->GetOPDClinic(),
                'Count' => $this->Management_Model->CountFilter(),
                'CountClinic' => $this->Management_Model->CountClinic(),
            ),
        );

        if(isset($BuildingUID)){
            $Template['Data']['BuildingUID'] = $BuildingUID;
        }

        $this->template_module->MainTemplate($Template);
    }

    public function Revert_Dashboard($SelectedLocation)
    {        
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'Management',
            'Site_Title' => 'Revert '.($SelectedLocation == 2 ? 'Register': ($SelectedLocation == 1 ? 'RegisterNewHN' : '')),
            'Content' => array(
                'Main' => 'Management_Body',
            ),
            'Script' => array(
                'Script' => 'Revert_Dashboard/Revert_Dashboard_Script', 
                'ManagementScript' => 'Management_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
            'Data' => array(
                'SelectedgroupprocessUID' => $SelectedLocation,
                'TitleText' => ($SelectedLocation == 2 ? 'คิวเปิดสิทธิ' : ($SelectedLocation == 1 ? 'คิวทำประวัติ' : '')),
                'Template_Content' => array(
                    'Main' => 'Management/Revert_Dashboard/Revert_Dashboard',
                ),
                'JSConstant' => array(
                    'GroupprocessUID' => $SelectedLocation,
                    'WorklistUID' => ($SelectedLocation == 2 ? '9' : ($SelectedLocation == 1 ? '10' : '99')),
                    'InitModel' => 'initRevertComplete',
                ),
                'JSCondition' => array(
                    'ColumnCondition' => ($SelectedLocation == 2 ? 'closqueue_register' : ($SelectedLocation == 1 ? 'closqueue_registerhn' : '')),
                ),
                'MenuButton' => array(
                    'BackButton' => array(
                        'URL' => ($SelectedLocation == 2 ? 'Dashboard' : ($SelectedLocation == 1 ? 'AltDashboard' : '99')),
                        'Text' => 'รอเรียก',
                        'Class' => '',
                    ),
                    'RevertComplete' => array(
                        'URL' => 'Revert_Dashboard/'.$SelectedLocation,
                        'Text' => 'คิวที่เสร็จสิ้นแล้ว',
                        'Class' => 'active',
                    ),
                    'RevertCancel' => array(
                        'URL' => 'Revert_Cancel/'.$SelectedLocation,
                        'Text' => 'คิวที่ถูกยกเลิก',
                        'Class' => '',
                    ),
                )
            ),
        );
        $this->template_module->MainTemplate($Template);
    }

    public function Revert_Cancel($SelectedLocation)
    {        
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'Management',
            'Site_Title' => 'Revert Cancel '.($SelectedLocation == 2 ? 'Register': ($SelectedLocation == 1 ? 'RegisterNewHN' : '')),
            'Content' => array(
                'Main' => 'Management_Body',
            ),
            'Script' => array(
                'Script' => 'Revert_Dashboard/Revert_Dashboard_Script', 
                'ManagementScript' => 'Management_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.css', 
                'main' => 'css/management_style.css', 
                'fontswitcher' => 'css/cssfont/cssswitcher.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
                'jqueryDataTable' => 'jquerydataTable/datatables.min.js', 
                'axios0.19.0' => 'axios/axios.min.js',
                'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
                'main_function' => 'js/management_function.js', 
                //'jwt-decode1.2.0' => 'jwt-decode/jwt-js-decode.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
            'Data' => array(
                'SelectedgroupprocessUID' => $SelectedLocation,
                'TitleText' => ($SelectedLocation == 2 ? 'คิวเปิดสิทธิ' : ($SelectedLocation == 1 ? 'คิวทำประวัติ' : '')),
                'Template_Content' => array(
                    'Main' => 'Management/Revert_Dashboard/Revert_Dashboard',
                ),
                'JSConstant' => array(
                    'GroupprocessUID' => $SelectedLocation,
                    'WorklistUID' => ($SelectedLocation == 2 ? '14' : ($SelectedLocation == 1 ? '15' : '99')),
                    'InitModel' => 'initRevertCancel',
                ),
                'JSCondition' => array(
                    'ColumnCondition' => ($SelectedLocation == 2 ? 'cancelqueue_register' : ($SelectedLocation == 1 ? 'cancelqueue_registerhn' : '')),
                ),
                'MenuButton' => array(
                    'BackButton' => array(
                        'URL' => ($SelectedLocation == 2 ? 'Dashboard' : ($SelectedLocation == 1 ? 'AltDashboard' : '99')),
                        'Text' => 'รอเรียก',
                        'Class' => '',
                    ),
                    'RevertComplete' => array(
                        'URL' => 'Revert_Dashboard/'.$SelectedLocation,
                        'Text' => 'คิวที่เสร็จสิ้นแล้ว',
                        'Class' => '',
                    ),
                    'RevertCancel' => array(
                        'URL' => 'Revert_Cancel/'.$SelectedLocation,
                        'Text' => 'คิวที่ถูกยกเลิก',
                        'Class' => 'active',
                    ),
                )
            ),
        );
        $this->template_module->MainTemplate($Template);
    }

    public function ManagementViews($groupprocessUID,$CategoryUID){
        $this->load->model('Management_Model');
        $queryData = array(
                'queuecategoryuid' => $CategoryUID,
                'groupprocessuid' => $groupprocessUID,
            );
        switch($groupprocessUID){
            case '1':
                //NEWHN
                $data = $this->Management_Model->GetQueueNewHN($queryData);
                $view = 'Management/ALT_Dashboard/Table';
                break;
            case '2':
                //REGISTER
                $data = $this->Management_Model->GetQueueRegister($queryData);
                $view = 'Management/Dashboard/Table';
                break;
        }
        $Template = array(    
            'Data' => array(
                'Queue' => $data,
            ),
        );
        
        header( "Content-Type: application/json" );
        $output = array(
            'html'=>$this->load->view($view,$Template,TRUE),
        );
        echo json_encode($output);
    }

    public function ManagementViews_Revert($groupprocessUID,$CategoryUID,$WorklistUID){
        $this->load->model('Management_Model');        

        $selectWorklist = ($WorklistUID == 9 ? 'selectpayor is NOT NULL' : ($WorklistUID == 10 ? 'selectnewhn is NOT NULL' : ($WorklistUID == 14 ? 'selectpayor is NOT NULL' : ($WorklistUID == 15 ? 'selectnewhn is NOT NULL' : '99') ) ) );
        $cancelWorklist = ($WorklistUID == 9 ? 'closqueue_register is NOT NULL' : ($WorklistUID == 10 ? 'closqueue_registerhn is NOT NULL' : ($WorklistUID == 14 ? 'cancelqueue_register is NOT NULL' : ($WorklistUID == 15 ? 'cancelqueue_registerhn is NOT NULL' : '99') ) ) );
        
        $whereQuery = $WorklistUID == 14 || $WorklistUID == 15 ? "( (".$selectWorklist." AND ".$cancelWorklist.") OR active = 'N') " : " (".$selectWorklist." AND ".$cancelWorklist.") ";
        
        $queryData = array(
            $whereQuery => NULL,
            //($WorklistUID == 9 ? 'closqueue_register is NOT NULL' : ($WorklistUID == 10 ? 'closqueue_registerhn is NOT NULL' : ($WorklistUID == 14 ? 'cancelqueue_register is NOT NULL' : ($WorklistUID == 15 ? 'cancelqueue_registerhn is NOT NULL' : '99')) )) => NULL,
            //'groupprocessuid' => $groupprocessUID,
        );
        $data = $this->Management_Model->GetTotalQueue_Revert($queryData,$CategoryUID);
        $view = 'Management/Revert_Dashboard/Table';

        $Template = array(    
            'Data' => array(
                'SelectedgroupprocessUID' => $groupprocessUID,
                'JSConstant' => array(
                    'GroupprocessUID' => $groupprocessUID,
                    'WorklistUID' => ($groupprocessUID == 2 ? '14' : ($groupprocessUID == 1 ? '15' : '99')),
                    'InitModel' => 'initRevertCancel',
                ),
                'JSCondition' => array(
                    'ColumnCondition' => ($groupprocessUID == 2 ? 'cancelqueue_register' : ($groupprocessUID == 1 ? 'cancelqueue_registerhn' : '')),
                ),
                'Queue' => $data,
            ),
        );
        
        header( "Content-Type: application/json" );
        $output = array(
            'html'=>$this->load->view($view,$Template,TRUE),
        );
        echo json_encode($output);
    }

    public function initManagement_NewHN($groupprocessUID,$CategoryUID){
        $this->load->model('Management_Model');
        $queryData = array(
                'queuecategoryuid' => $CategoryUID,
                'groupprocessuid' => $groupprocessUID,
            );
        $data = $this->Management_Model->GetQueueNewHN($queryData);
        echo json_encode($data);
    }

    public function GetQueueInfo_NewHN($PatientUID){
        $this->load->model('Management_Model');
        $queryData = array(
                'patientuid' => $PatientUID,
            );
        $data = $this->Management_Model->GetQueueNewHN($queryData);
        echo json_encode($data);        
    }

    public function GetQueueInfo_NewHN_Queueno($QueueNumber){
        $this->load->model('Management_Model');
        $queryData = array(
                'queueno' => $QueueNumber,
            );
        $data = $this->Management_Model->GetQueueNewHN($queryData);
        echo json_encode($data);        
    }

    public function initManagement($groupprocessUID,$CategoryUID){
        $this->load->model('Management_Model');
        $queryData = array(
                'queuecategoryuid' => $CategoryUID,
                'groupprocessuid' => $groupprocessUID,
            );
        $data = $this->Management_Model->GetQueueRegister($queryData);
        echo json_encode($data);
    }

    public function GetQueueInfo_Register($PatientUID){
        $this->load->model('Management_Model');
        $queryData = array(
                'patientuid' => $PatientUID,
            );
        $data = $this->Management_Model->GetQueueRegister($queryData);
        echo json_encode($data);        
    }

    public function GetQueueInfo_Register_Queueno($QueueNumber){
        $this->load->model('Management_Model');
        $queryData = array(
                'queueno' => $QueueNumber,
            );
        $data = $this->Management_Model->GetQueueRegister($queryData);
        echo json_encode($data);        
    }

    public function GetQueueRegister_RelatedQueueno($QueueNumber){
        $this->load->model('Management_Model');
        $queryData = array(
                'queueno' => $QueueNumber,
            );
        $data = $this->Management_Model->GetQueueRegister_Related($queryData);
        echo json_encode($data);        
    }

    /*
        public function initManagement_NewHN($groupprocessUID,$CategoryUID){
            $this->load->model('Management_Model');
            $queryData = array(
                'queuecategoryuid' => $CategoryUID,
                'selectnewhn is NOT NULL' => NULL,
                'closqueue_registerhn is NULL' => NULL,
                'cancelqueue_registerhn is NULL' => NULL,
                //'selectvs is NOT NULL' => NULL,
                //'closequeue_vs is NOT NULL' => NULL,
                'groupprocessuid' => $groupprocessUID,
            );
            $data = $this->Management_Model->GetTotalQueue($queryData);
            echo json_encode($data);
        }
        
        public function initManagement($groupprocessUID,$CategoryUID){
            $this->load->model('Management_Model');
            $queryData = array(
                'queuecategoryuid' => $CategoryUID,
                //'selectpayor is NOT NULL' => NULL,
                //'selectpatienttype is NOT NULL' => NULL,
                'closqueue_register is NULL' => NULL,
                'cancelqueue_register is NULL' => NULL,
                'groupprocessuid' => $groupprocessUID,
            );
            $data = $this->Management_Model->GetTotalQueue($queryData);
            echo json_encode($data);
        }
    */

    public function initRevertComplete($groupprocessUID,$CategoryUID,$WorklistUID){
        $this->load->model('Management_Model');

        $queryData = array(
            ($WorklistUID == 9 ? 'closqueue_register is NOT NULL' : ($WorklistUID == 10 ? 'closqueue_registerhn is NOT NULL' : '99')) => NULL,
            //'groupprocessuid' => $groupprocessUID,
        );
        $data = $this->Management_Model->GetTotalQueue_Revert($queryData,$CategoryUID);
        echo json_encode($data);
    }

    public function initRevertCancel($groupprocessUID,$CategoryUID,$WorklistUID){
        $this->load->model('Management_Model');

        $queryData = array(
            ($WorklistUID == 14 ? "cancelqueue_register is NOT NULL or active = 'N' " : ($WorklistUID == 15 ? "cancelqueue_registerhn is NOT NULL or active = 'N' " : '99')) => NULL,
            //'groupprocessuid' => $groupprocessUID,
        );
        $data = $this->Management_Model->GetTotalQueue_Revert($queryData,$CategoryUID);
        echo json_encode($data);
    }

    public function GetFilterQueueInfo($Refno){
        $this->load->model('Management_Model');
        $queryData = array(
            'refno' => $Refno,
            'selectvs is NOT NULL' => NULL,
            //'closequeue_vs is NULL' => NULL, 
            //'groupprocessuid' => $groupprocessUID,
        );
        $data = $this->Management_Model->GetTotalQueue_Visit($queryData);
        echo json_encode($data);        
    }

    public function GetFilterQueueInfoHN($RefHN){
        $this->load->model('Management_Model');
        $RefHN = str_replace('_', '/', $RefHN);
        $queryData = array(
            'hn' => $RefHN,
            'selectvs is NOT NULL' => NULL,
            //'closequeue_vs is NULL' => NULL, 
            //'groupprocessuid' => $groupprocessUID,
        );
        $data = $this->Management_Model->GetTotalQueue_Visit($queryData);
        echo json_encode($data);        
    }

    public function GetCounterInfo($CounterID){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetCounterInfo($CounterID);
        echo json_encode($data);        
    }

    public function GetQueueInfo($QueueNumber){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetQueueInfo($QueueNumber);
        echo json_encode($data);        
    }

    public function GetQueueInfo_PUID($PUID){
        $this->load->model('Management_Model');
        $query = array(
            'refno' => $PUID,
        );
        $data = $this->Management_Model->GetQueueInfo_Related($query);
        echo json_encode($data);        
    }

    public function GetQueueInfo_HN($HN){
        $this->load->model('Management_Model');
        $HN = str_replace('_', '/', $HN);
        $query = array(
            'hn' => $HN,
        );
        $data = $this->Management_Model->GetQueueInfo_Related($query);
        echo json_encode($data);        
    }

    public function GetHoldMessage(){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetHoldMessage();
        echo json_encode($data);        
    }

    public function getSetupData_JSON(){
        $this->load->model('Management_Model');

        $data = array(
            'Counter' => $this->Management_Model->GetCounterData(),
            'Category' => $this->Management_Model->GetCategoryData(),
        );
        echo json_encode($data);
    }

    public function getTypePayorData_JSON(){
        $this->load->model('Management_Model');

        $data = array(
            'Type' => $this->Management_Model->GetPatientTypeData(),
            'Payor' => $this->Management_Model->GetPayorData(),
        );
        echo json_encode($data);
    }

    public function GetCategoryDetailData_JSON(){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetCategoryData();
        echo json_encode($data);
    }

    public function GetWorklistDescription($WorklistUID){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetWorklistDescription($WorklistUID);
        echo json_encode($data);
    }
    
    public function GetWorklistStatus($QueueNumber){
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetWorklistStatus($QueueNumber);
        echo json_encode($data);
    }

    public function RemoveTR($SelectedTable){
        $this->load->model('Management_Model');
        $postData = $this->input->post();
        $this->Management_Model->RemoveTR($SelectedTable,$postData);
        echo json_encode("SUCCESS");
    }

    public function InsertMessage(){
        $this->load->model('Management_Model');
        $postData = $this->input->post();

        $data = array(
            'cwhen' => 'NOW()',
        );
        foreach($postData as $key => $value){
            $data[$key] = $value;
        }

        $this->Management_Model->InsertMessage($data);
        echo json_encode("SUCCESS");

    }

    //CallQueue NewHN = 12 / WithHN = 7
    public function CallQueue($WorklistUID){
        $this->load->model('Management_Model');
        $postData = $this->input->post();

        $data = array(
            'cwhen' => 'NOW()',
        );
        foreach($postData as $key => $value){
            $data[$key] = $value;
        }
        $this->Management_Model->CallQueue($data);

        $data_process = array(
            'patientuid' => $postData['patientdetailuid'],
            'queueno' => $postData['queueno'],
            'worklistuid' => $WorklistUID,
            'createdate' => 'NOW()',
            'cuser' => $postData['cuser'],
        );
        $this->Management_Model->InsertProcessControl($data_process);
        
        echo json_encode("SUCCESS");
    }

    public function Call_Curl(){
        $postData = $this->input->post();
        $call_queue_num = $postData['queueno'];
        $call_counter = $postData['counter'];
        $call_location = $postData['location'];

		$string = str_split($call_queue_num,1);
        $strings = implode($string,'|');

        //$text = 'TH'.'|เชิญหมายเลข|'.$strings.'|ที่ช่องบริการ|'.$call_counter.'|ค่ะ';
		$text = 'TH'.'|'.$strings.'|ที่ช่องบริการ|'.$call_counter;
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL,"http://192.168.0.97:7000/call");
		curl_setopt($ch, CURLOPT_URL,CURLURL."/call");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"queuestring=$text&counter=$call_counter&queue=$call_queue_num&type=$string[0]&locationid=$call_location");
        //curl_setopt($ch, CURLOPT_POSTFIELDS,"queuestring=$text&counter='1'&queue='G004'&code='G'&locationid='2'");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//echo $postData;
        $result = curl_exec($ch);
        echo json_encode($result);
    }

    public function Hold_Curl(){
        $postData = $this->input->post();
        $call_queue_num = $postData['queueno'];
        $call_counter = $postData['counter'];
        $call_location = $postData['location'];

        $string = str_split($call_queue_num,1);
        $strings = implode($string,'|');

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL,"http://192.168.0.97:7000/hold");
        curl_setopt($ch, CURLOPT_URL,CURLURL."/hold");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"counter=$call_counter&queue=$call_queue_num&type=$string[0]&locationid=$call_location");
        //curl_setopt($ch, CURLOPT_POSTFIELDS,"queuestring=$text&counter='1'&queue='G004'&code='G'&locationid='2'");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //echo $postData;
        $result = curl_exec($ch);
        echo json_encode($result);
    }

    //HoldQueue NewHN = 13 / WithHN = 8
    public function HoldQueue($WorklistUID){
        $this->load->model('Management_Model');
        $postData = $this->input->post();

        $data_process = array(
            'patientuid' => $postData['patientdetailuid'],
            'queueno' => $postData['queueno'],
            'worklistuid' => $WorklistUID,
            'createdate' => 'NOW()',
            'cuser' => $postData['cuser'],
        );
        $this->Management_Model->InsertProcessControl($data_process);

        echo json_encode("SUCCESS");
    }

    public function CompleteQueue1($groupprocessUID){
        // $rr = $this->Management_Model->GetQueueNewHN1($WorklistUID);
        // echo $rr;
        $queryData = array(
            'groupprocessuid' => $groupprocessUID,
        );
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetQueueNewHN1($queryData);
        // echo $data;
        // $cars=array($data);
        $cars=array("Volvo","BMW","Toyota");
        // $Template = array(    
        //     'Data' => array(
        //         'Queue' => $data,
        //     ),
        // );
        echo $data;
    }

    public function CompleteQueue2($groupprocessUID){
        // $rr = $this->Management_Model->GetQueueNewHN1($WorklistUID);
        // echo $rr;
        $queryData = array(
            'groupprocessuid' => $groupprocessUID,
        );
        $this->load->model('Management_Model');
        $data = $this->Management_Model->GetQueueRegister1($queryData);
        // echo $data;
        // $cars=array($data);
        // $cars=array("Volvo","BMW","Toyota");
        // $Template = array(    
        //     'Data' => array(
        //         'Queue' => $data,
        //     ),
        // );
        echo $data;
    }

    //HoldQueue NewHN = 10 / WithHN = 9
    public function CompleteQueue($WorklistUID){
        $this->load->model('Management_Model');
        $postData = $this->input->post();

        $data_process = array(
            'patientuid' => $postData['patientdetailuid'],
            'queueno' => $postData['queueno'],
            'worklistuid' => $WorklistUID,
            'createdate' => 'NOW()',
            'cuser' => $postData['cuser'],
        );
        $this->Management_Model->InsertProcessControl($data_process);
        echo json_encode("SUCCESS");
    }


    //HoldQueue NewHN = 10 / WithHN = 9
    public function CancelQueue($WorklistUID){
        $this->load->model('Management_Model');
        $postData = $this->input->post();

        $data_process = array(
            'patientuid' => $postData['patientdetailuid'],
            'queueno' => $postData['queueno'],
            'worklistuid' => $WorklistUID,
            'createdate' => 'NOW()',
            'cuser' => $postData['cuser'],
        );
        $this->Management_Model->InsertProcessControl($data_process);

        echo json_encode("SUCCESS");
    }

    //Get Counter/QueueCategory of groupprocessuid
    public function locationAvailable_JSON($groupprocessuid){
        $this->load->model('TB_Management_Model');

        $data = array(
            'Counter' => $this->TB_Management_Model->GetLocationCounterData($groupprocessuid),
            'Category' => $this->TB_Management_Model->GetLocationCategoryData($groupprocessuid),
        );
        echo json_encode($data);
    }

    public function refreshCountClinic(){
        $this->load->model('Management_Model');
        echo json_encode($this->Management_Model->CountClinic());
    }

    public function printRoom(){
        $this->load->model('Management_Model');
        $this->load->model('TB_Management_Model');
        $postData = $this->input->post();
        $QueueArray = array();
        if( isset($postData['refno']) ){
            $queryData = array(
                'refno' => $postData['refno'],
                'selectvs is NOT NULL' => NULL,
            );
            $Queueno  = $this->Management_Model->GetTotalQueue($queryData);
            $QueueString = '';
            foreach($Queueno as $refnoqueuedata){
                $Refno = $refnoqueuedata->refno;
                //Case merge queueno to string 
                if( $refnoqueuedata->queueno != null && strlen($refnoqueuedata->queueno) > 0){
                    $QueueString .= (strlen($QueueString) > 0 ? ',' : '');
                    $QueueString .= $refnoqueuedata->queueno;                
                }
                //Case queueno with groupprocess as array
                if( $refnoqueuedata->queueno != null && $refnoqueuedata->queueno != ''){
                    $pushArray = array(
                        'queueno' => $refnoqueuedata->queueno,
                        'groupprocess' => $refnoqueuedata->groupprocessuid,
                    );
                    array_push($QueueArray,$pushArray);               
                }
            }
        }
        $this->Management_Model->InsertClinicCount($postData);
        $Building = $this->TB_Management_Model->GetBuilding_ID($postData['building']);
        $BuildingFloor = $this->TB_Management_Model->GetBuildingFloor_ID($postData['floor']);
        $BuildingRoom = $this->TB_Management_Model->GetBuildingRoom_ID($postData['room']);
        $data = array(
            'Refno' => (isset($postData['refno']) && $postData['refno'] != null ? trim($postData['refno']) : ''),
            'Queueno' => (isset($QueueString) && $QueueString != null ? $QueueString : ''),
            'QueuenoGroupprocess' => $QueueArray,
            'Building' => (isset($Building) && $Building->building_name != null ? $Building->building_name : ''),
            'Floor' => (isset($BuildingFloor) && $BuildingFloor->floor_number != null ? $BuildingFloor->floor_number : ''),
            'Room' => (isset($BuildingRoom) && $BuildingRoom->detail != null ? $BuildingRoom->detail : ''),
            'Time' => $postData['hour'] . ':' . $postData['minutes'],
            'Year' => $postData['year'],
            'openvisit' => $postData['openvisit'],
        );

        echo json_encode($data);
        return true;
    }

    public function printRoom_pure(){        
        $this->load->model('Management_Model');
        $this->load->model('TB_Management_Model');
        $postData = $this->input->post();
        $this->Management_Model->InsertClinicCount($postData);
        $Building = $this->TB_Management_Model->GetBuilding_ID($postData['building']);
        $BuildingFloor = $this->TB_Management_Model->GetBuildingFloor_ID($postData['floor']);
        $BuildingRoom = $this->TB_Management_Model->GetBuildingRoom_ID($postData['room']);
        $data = array(
            'Building' => (isset($Building) && $Building->building_name != null ? $Building->building_name : ''),
            'Floor' => (isset($BuildingFloor) && $BuildingFloor->floor_number != null ? $BuildingFloor->floor_number : ''),
            'Room' => (isset($BuildingRoom) && $BuildingRoom->detail != null ? $BuildingRoom->detail : ''),
            'Time' => $postData['hour'] . ':' . $postData['minutes'],
            'Year' => $postData['year'],
            //'openvisit' => 1,
        );

        echo json_encode($data);
        return true;
    }

    public function printCurl(){
        $postData = $this->input->post();

        $locationid = 1;
        $printwhen = date("d/m") . "/" . $postData['year'] . " " . $postData['time'] . " น";
        $department = $postData['room'];
        $station = "ชั้น " . $postData['floor'] . " " . "อาคาร" . $postData['building'];
        $refno = ( isset($postData['refno']) ? $postData['refno'] : '');
        $queue = $postData['queuewithgroup'];
        $printlocation = $postData['locationid'];

        $postCURL = [
            "locationid" => $printlocation,
            "printwhen" => $printwhen,
            "department" => $department,
            "station" => $station,
            "refno" => trim($refno),
            "queue" => ($queue == '' ? [] : $queue )
        ];
        if( !isset($postData['openvisit']) || (isset($postData['openvisit']) && $postData['openvisit'] != 0) ){
            $postCURL['openvisit'] = $postData['openvisit'];
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,CURLURL."/printscreening");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postCURL));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $message = array(
            'result' => json_encode($result),
            'postData' => json_encode($postCURL),
        );
        echo json_encode($message);
    }

    public function visitCurl(){
        $this->load->model('Management_Model');
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
            'result' => $result,
            'code' => $httpcode,
            'postData' => $postCURL,
        );
        echo json_encode($message);
        $postData['code'] = $message['code'];
        $postData['result'] = $message['result'];
        $BuildingUID = $this->Management_Model->InsertLogAPI($postData);
    }
}
