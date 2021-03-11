<?php

class Main extends MY_Controller
{
    protected $ModuleName = "Main";
    protected $MainFunction = "kiosk";
    protected $GroupprocessUID = array(
        'drugcharge' => 6,
        'cashier' => 1,
        'dispense' => 2
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }

    public function redirect_index($Module = NULL)
    {
        $Module = $Module?$Module:$this->ModuleName;
        redirect(APPNAME . "/$Module/index");
    }

    public function renderView($ViewData = array())
    {
        $this->load->model('MainMDL');
        $this->load->module('Template_Module');
        $ViewData['Module'] = $this->ModuleName;
        $this->template_module->SetupTemplate($ViewData);
    }

    public function index()
    {
        redirect(APPNAME . "/$this->MainFunction");
    }

    public function kiosk($queuelocationuid = NULL)
    {
        $ViewData = array(
            'Site_Title' => 'Kiosk Setup',
            'FunctionName' => 'Kiosk',
            'Script' => array(
                'Main' => 'Kiosk/kiosk_script',
            )
        );
        $ViewData = $this->kiosk_view($ViewData,$queuelocationuid);
        $this->renderView($ViewData);
    }
    public function kiosk_view($Template = NULL,$queuelocationuid = NULL)
    {
        $View = 'Kiosk/kiosk_view';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('TicketMDL');
        $this->load->model('KioskMDL');
        $this->load->model('MainMDL');
        $Template['Data']['thisQueuelocation'] = $queuelocationuid ? $this->MainMDL->get_row_queuelocation($queuelocationuid) : $this->MainMDL->get_first_queuelocation();
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();
        $Template['Data']['Ticket'] = $this->TicketMDL->get_ticket_message_queuelocation($Template['Data']['thisQueuelocation']->locationuid,1);
        $Template['Data']['KioskRow'] = $this->KioskMDL->get_kiosk_queuelocation($Template['Data']['thisQueuelocation']->locationuid);
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function kiosk_view_location($queuelocationuid = 1){
        $this->kiosk_view(NULL,$queuelocationuid);
    }
    public function add_ticket_message()
    {
        $Input = $this->input->post();
        $this->load->model('TicketMDL');
        return $this->TicketMDL->add_ticket_message($Input);
    }
    public function update_ticket_message()
    {
        $Input = $this->input->post();
        $this->load->model('TicketMDL');
        return $this->TicketMDL->update_ticket_message($Input);
    }
    public function update_kiosk_ticket()
    {
        $Input = $this->input->post();
        $Input['uid'] = 1;
        $this->load->model('TicketMDL');
        return $this->TicketMDL->update_ticket_message($Input);
    }
    public function update_kiosk($uid = NULL){
        $Input = $this->input->post();
        $this->load->model('KioskMDL');
        if($uid){
            $Input['uid'] = $uid;
        }
        return $this->KioskMDL->update_kiosk($Input);
    }
    public function update_kiosk_queuelocation($queuelocationuid){
        $Input = $this->input->post();
        $this->load->model('KioskMDL');
        return $this->KioskMDL->update_kiosk_queuelocation($queuelocationuid,$Input);
    }

    public function drugcharge($queuelocationuid = NULL)
    {
        $ViewData = array(
            'Site_Title' => 'DrugCharge Setup',
            'FunctionName' => 'คิดราคายา',
            'Script' => array(
                'Main' => 'Drugcharge/drugcharge_script',
            )
        );
        $ViewData = $this->drugcharge_view($ViewData,$queuelocationuid);
        $this->renderView($ViewData);
    }
    public function drugcharge_view($Template = NULL,$queuelocationuid = NULL)
    {
        $thisgroup = $this->GroupprocessUID['drugcharge'];
        $View = 'Drugcharge/drugcharge_view';        
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        $Template['Data']['thisQueuelocation'] = $queuelocationuid ? $this->MainMDL->get_row_queuelocation($queuelocationuid) : $this->MainMDL->get_first_queuelocation();
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();        
        $Template = $this->view_usercontrol_div($Template, $thisgroup, 'Extension');
        $Template = $this->view_printcontrol_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_countercontrol_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_holdmessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_navigatemessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_tvmessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function drugcharge_view_location($queuelocationuid = 1){
        $this->drugcharge_view(NULL,$queuelocationuid);
    }

    public function cashier($queuelocationuid = NULL)
    {
        $ViewData = array(
            'Site_Title' => 'Cashier Setup',
            'FunctionName' => 'การเงิน',
            'Script' => array(
                'Main' => 'Cashier/cashier_script',
            )
        );
        $ViewData = $this->cashier_view($ViewData,$queuelocationuid);
        $this->renderView($ViewData);
    }
    public function cashier_view($Template = NULL,$queuelocationuid = NULL)
    {
        $thisgroup = $this->GroupprocessUID['cashier'];
        $View = 'Cashier/cashier_view';        
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        $Template['Data']['thisQueuelocation'] = $queuelocationuid ? $this->MainMDL->get_row_queuelocation($queuelocationuid) : $this->MainMDL->get_first_queuelocation();
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();
        $Template = $this->view_countercontrol_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_holdmessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_tvmessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function cashier_view_location($queuelocationuid = 1){
        $this->cashier_view(NULL,$queuelocationuid);
    }

    public function dispense($queuelocationuid = NULL)
    {
        $ViewData = array(
            'Site_Title' => 'Dispense Setup',
            'FunctionName' => 'จ่ายยา',
            'Script' => array(
                'Main' => 'Dispense/dispense_script',
            )
        );
        $ViewData = $this->dispense_view($ViewData,$queuelocationuid);
        $this->renderView($ViewData);
    }
    public function dispense_view($Template = NULL,$queuelocationuid = NULL)
    {
        $thisgroup = $this->GroupprocessUID['dispense'];
        $View = 'Dispense/dispense_view';        
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        $Template['Data']['thisQueuelocation'] = $queuelocationuid ? $this->MainMDL->get_row_queuelocation($queuelocationuid) : $this->MainMDL->get_first_queuelocation();
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();
        $Template = $this->view_countercontrol_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        $Template = $this->view_holdmessage_div($Template, $thisgroup, $Template['Data']['thisQueuelocation']->locationuid);
        //$Template = $this->view_tvmessage_div($Template, $thisgroup);
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function dispense_view_location($queuelocationuid = 1){
        $this->dispense_view(NULL,$queuelocationuid);
    }

    public function patientcategory()
    {
        $ViewData = array(
            'Site_Title' => 'PatientCategory Setup',
            'FunctionName' => 'หมวดหมู่คิว',
            'Script' => array(
                'Main' => 'PatientCategory/patientcategory_script',
            )
        );
        $ViewData = $this->patientcategory_view($ViewData);
        $this->renderView($ViewData);
    }
    public function patientcategory_view($Template = NULL,$queuelocationuid = NULL)
    {
        $View = 'PatientCategory/patientcategory_view';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        $this->load->model('PatientCategoryMDL');
        $Template['Data']['thisQueuelocation'] = $queuelocationuid ? $this->MainMDL->get_row_queuelocation($queuelocationuid) : $this->MainMDL->get_first_queuelocation();
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();        
        $Template['Data']['PatientCategory'] = $this->PatientCategoryMDL->get_patientcategory(['queuelocationuid'=>$Template['Data']['thisQueuelocation']->locationuid]);
        $Template['Data']['Groupprocess'] = $this->MainMDL->get_groupprocess();
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function patientcategory_view_location($queuelocationuid = 1){
        $this->patientcategory_view(NULL,$queuelocationuid);
    }
    public function patientcategory_data($uid)
    {
        $this->load->model('PatientCategoryMDL');
        $query = $this->PatientCategoryMDL->get_patientcategory_row($uid);
        echo json_encode($query);
    }
    public function add_patientcategory()
    {
        $Input = $this->input->post();
        $this->load->model('PatientCategoryMDL');
        return $this->PatientCategoryMDL->add_patientcategory($Input);
    }
    public function update_patientcategory()
    {
        $Input = $this->input->post();
        $this->load->model('PatientCategoryMDL');
        return $this->PatientCategoryMDL->update_patientcategory($Input);
    }
    public function del_patientcategory()
    {
        $Input = $this->input->post();
        $this->load->model('PatientCategoryMDL');
        return $this->PatientCategoryMDL->del_patientcategory($Input);
    }

    public function tv()
    {
        $ViewData = array(
            'Site_Title' => 'TV Setup',
            'FunctionName' => 'หน้าจอจ่ายยา',
            'Script' => array(
                'Main' => 'TV/tv_script',
            )
        );
        $ViewData = $this->tv_view($ViewData);
        $this->renderView($ViewData);
    }
    public function tv_view($Template = NULL,$queuelocationuid = NULL)
    {
        $View = 'TV/tv_view';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        $this->load->model('TVMDL');
        if($queuelocationuid){
            $Template['Data']['TVQueuelocation'] = $this->MainMDL->get_row_queuelocation($queuelocationuid);
            $Template['Data']['TV'] = $this->TVMDL->get_tv_queuelocation($queuelocationuid);
        }else{
            $Template['Data']['TVQueuelocation'] = $this->MainMDL->get_first_queuelocation();
            $Template['Data']['TV'] = $this->TVMDL->get_tv();
        }
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();
        $Template['Data']['Groupprocess'] = $this->MainMDL->get_groupprocess();
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function tv_view_location($queuelocationuid){
        return $this->tv_view(NULL,$queuelocationuid);
    }
    public function tv_data($uid)
    {
        $this->load->model('TVMDL');
        $query = $this->TVMDL->get_tv_row($uid);
        echo json_encode($query);
    }
    public function add_tv()
    {
        $Input = $this->input->post();
        $this->load->model('TVMDL');
        return $this->TVMDL->add_tv($Input);
    }
    public function update_tv()
    {
        $Input = $this->input->post();
        $this->load->model('TVMDL');
        return $this->TVMDL->update_tv($Input);
    }
    public function del_tv()
    {
        $Input = $this->input->post();
        $this->load->model('TVMDL');
        return $this->TVMDL->del_tv($Input);
    }
    public function tv_message_data($tvuid)
    {
        $this->load->model('TVMDL');
        $query = $this->TVMDL->tv_message_data($tvuid);
        echo json_encode($query);
    }
    public function update_tv_message($uid)
    {
        $Input = $this->input->post();
        $Input['uid'] = $uid;
        $this->load->model('TVMDL');
        $update = $this->TVMDL->update_tv_message($Input);
        return $update;
    }
    public function trigger_tv_update($station,$location_id = NULL,$tvuid = NULL){
        $this->load->model('MainMDL');
        $location_id = $this->MainMDL->get_row_queuelocation($location_id)->locationuid;

        $url = DASHBOARDPHARCASH;
        $trigger = array(
            "drugcharge" => "/refresh_dashboard_drugappraisal?location_id=$location_id", //6
            "dispense" => "/refresh_dashboard_dispense?location_id=$location_id&tvuid=$tvuid", //2
            "cashier" => "/refresh_dashboard_cashier?location_id=$location_id" //1
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"{$url}{$trigger[array_flip($this->GroupprocessUID)[$station]]}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
        return $result;
    }
    
    public function queuelocation()
    {
        $ViewData = array(
            'Site_Title' => 'Queuelocation Setup',
            'FunctionName' => 'จอทีวีและเสียงของคิดราคายาและการเงิน',
            'Script' => array(
                'Main' => 'Queuelocation/queuelocation_script',
            )
        );
        $ViewData = $this->queuelocation_view($ViewData);
        $this->renderView($ViewData);
    }
    public function queuelocation_view($Template = NULL,$queuelocationuid = NULL)
    {
        $View = 'Queuelocation/queuelocation_view';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $this->load->model('MainMDL');
        if($queuelocationuid){
            $Template['Data']['LocationData'] = $this->MainMDL->get_row_queuelocation($queuelocationuid);
        }else{
            $Template['Data']['LocationData'] = $this->MainMDL->get_first_queuelocation();
        }
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();
        $Template['Data']['Groupprocess'] = $this->MainMDL->get_groupprocess();
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function queuelocation_view_location($queuelocationuid){
        return $this->queuelocation_view(NULL,$queuelocationuid);
    }
    public function queuelocation_update($queuelocationuid){
        $Input = $this->input->post();
        $this->load->model('MainMDL');
        return $this->MainMDL->update_queuelocation($Input,$queuelocationuid);        
    }

    /* -- Common View Extension -- */
    public function view_printcontrol_div($Template, $groupprocessuid, $queuelocationuid)
    {
        $this->load->model('PrintControlMDL');
        $Template['PrintControl']['groupprocessuid'] = $groupprocessuid;
        $Template['PrintControl']['queuelocationuid'] = $queuelocationuid;
        $Template['Data']['PrintControl'] = $this->PrintControlMDL->get(['groupprocessuid'=>$groupprocessuid,'queuelocationuid'=>$queuelocationuid]);
        $Template['Ext']['printcontrol'] = "$this->ModuleName/Extension/printcontrol/printcontrol_div";
        $Template['Script']['printcontrol'] = 'Extension/printcontrol/printcontrol_script';
        return $Template;
    }
        public function add_printcontrol($groupprocessuid,$queuelocationuid){
            $this->load->model('PrintControlMDL');
            return $this->PrintControlMDL->add(['groupprocessuid' => $groupprocessuid, 'queuelocationuid' => $queuelocationuid]);
        }
        public function update_printcontrol($uid){
            $Input = $this->input->post();
            $this->load->model('PrintControlMDL');
            return $this->PrintControlMDL->update($uid,$Input);
        }
    public function view_usercontrol_div($Template, $groupprocessuid, $ExtVar = 'Ext')
    {
        $this->load->model('UserAuthorizationMDL');
        $Template['Data']['AllUser'] = $this->UserAuthorizationMDL->get_user();
        $Template['Data']['CurrentAuth'] = $this->UserAuthorizationMDL->get_userauth();
        $Template['Data']['Queuelocation'] = !isset($Template['Data']['Queuelocation']) ? $this->MainMDL->get_queuelocation() : $Template['Data']['Queuelocation'];
        $Template[$ExtVar]['usercontrol'] = "$this->ModuleName/Extension/usercontrol/usercontrol_div";
        $Template['Script']['usercontrol'] = 'Extension/usercontrol/usercontrol_script';
        return $Template;
    }
        public function add_usercontrol(){
            $Input = $this->input->post();
            $this->load->model('UserAuthorizationMDL');
            return $this->UserAuthorizationMDL->add_userauth($Input);
        }
        public function update_usercontrol($uid){
            $Input = $this->input->post();
            $this->load->model('UserAuthorizationMDL');
            $Input['uid'] = $uid;
            return $this->UserAuthorizationMDL->update_userauth($Input);
        }
        public function remove_usercontrol($uid){
            $this->load->model('UserAuthorizationMDL');
            return $this->UserAuthorizationMDL->del_userauth(array('uid'=>$uid));
        }
    public function view_countercontrol_div($Template, $groupprocessuid, $queuelocationuid)
    {
        $this->load->model('CounterMDL');
        $Template['countercontrol']['groupprocessuid'] = $groupprocessuid;
        $Template['countercontrol']['queuelocationuid'] = $queuelocationuid;
        $Template['Data']['CurrentCounter'] = $this->CounterMDL->get_counter(['groupprocessuid'=>$groupprocessuid,'queuelocationuid'=>$queuelocationuid]);
        $Template['Data']['OccupiedCounter'] = array();
        foreach($Template['Data']['CurrentCounter'] as $currentcounter):
            array_push($Template['Data']['OccupiedCounter'],$currentcounter->counterno);
        endforeach; 
        $Template['Ext']['countercontrol'] = "$this->ModuleName/Extension/countercontrol/countercontrol_div";
        $Template['Script']['countercontrol'] = 'Extension/countercontrol/countercontrol_script';
        return $Template;
    }
        public function add_countercontrol($groupprocessuid,$queuelocationuid = NULL){
            $Input = $this->input->post();
            $Input['groupprocessuid'] = $groupprocessuid;
            $Input['queuelocationuid'] = $queuelocationuid;
            $this->load->model('CounterMDL');
            return $this->CounterMDL->add_counter($Input);
            //return $this->CounterMDL->add_countercontrol($groupprocessuid,$Input);
        }
        public function update_countercontrol($uid){
            $Input = $this->input->post();
            $Input['uid'] = $uid;
            $this->load->model('CounterMDL');
            return $this->CounterMDL->update_counter($Input);
            //return $this->CounterMDL->update_countercontrol($uid,$Input);
        }
        public function remove_countercontrol($uid){
            $this->load->model('CounterMDL');
            return $this->CounterMDL->remove_countercontrol($uid);
        }
    public function view_holdmessage_div($Template, $groupprocessuid, $queuelocationuid)
    {
        $this->load->model('MessageDetailMDL');
        $Template['holdmessage']['groupprocessuid'] = $groupprocessuid;
        $Template['holdmessage']['queuelocationuid'] = $queuelocationuid;
        $Template['Data']['CurrentHoldMessage'] = $this->MessageDetailMDL->get_holdmessage(['groupprocessuid'=>$groupprocessuid,'queuelocationuid'=>$queuelocationuid]);
        $Template['Ext']['holdmessage'] = "$this->ModuleName/Extension/holdmessage/holdmessage_div";
        $Template['Script']['holdmessage'] = 'Extension/holdmessage/holdmessage_script';
        return $Template;
    }
        public function add_holdmessage($groupprocessuid,$queuelocationuid = NULL){
            $Input = $this->input->post();
            $this->load->model('MessageDetailMDL');
            $Input['queuelocationuid'] = $queuelocationuid;
            $Input['groupprocessuid'] = $groupprocessuid;
            return $this->MessageDetailMDL->add_holdmessage($Input);
        }
        public function update_holdmessage($uid){
            $Input = $this->input->post();
            $this->load->model('MessageDetailMDL');
            $Input['uid'] = $uid;
            return $this->MessageDetailMDL->update_holdmessage($Input);
        }
        public function remove_holdmessage($uid){
            $this->load->model('MessageDetailMDL');
            return $this->MessageDetailMDL->del_holdmessage(array('uid'=>$uid));
        }
    public function view_navigatemessage_div($Template, $groupprocessuid, $queuelocationuid)
    {
        $this->load->model('NavigateMessageMDL');
        $Template['navigatemessage']['groupprocessuid'] = $groupprocessuid;
        $Template['navigatemessage']['queuelocationuid'] = $queuelocationuid;
        $Template['Data']['CurrentNavigateMessage'] = $this->NavigateMessageMDL->get_navigatemessage(['groupprocessuid'=>$groupprocessuid,'queuelocationuid'=>$queuelocationuid]);
        $Template['Ext']['navigatemessage'] = "$this->ModuleName/Extension/navigatemessage/navigatemessage_div";
        $Template['Script']['navigatemessage'] = 'Extension/navigatemessage/navigatemessage_script';
        return $Template;
    }
        public function add_navigatemessage($groupprocessuid,$queuelocationuid){
            $this->load->model('NavigateMessageMDL');
            return $this->NavigateMessageMDL->add(['groupprocessuid' => $groupprocessuid, 'queuelocationuid' => $queuelocationuid]);
        }
        public function update_navigatemessage($uid){
            $Input = $this->input->post();
            $this->load->model('NavigateMessageMDL');
            $Input['uid'] = $uid;
            return $this->NavigateMessageMDL->update_navigatemessage($Input);
        }
    public function view_tvmessage_div($Template, $groupprocessuid, $queuelocationuid)
    {
        $this->load->model('TVMessageMDL');
        $Template['tvmessage']['groupprocessuid'] = $groupprocessuid;
        $Template['tvmessage']['queuelocationuid'] = $queuelocationuid;
        $Template['Data']['TVMessage'] = $this->TVMessageMDL->get_tvmessage_row(['groupprocessuid'=>$groupprocessuid,'queuelocationuid'=>$queuelocationuid]);
        $Template['Ext']['tvmessage'] = "$this->ModuleName/Extension/tvmessage/tvmessage_div";
        $Template['Script']['tvmessage'] = 'Extension/tvmessage/tvmessage_script';
        return $Template;
    }
        public function add_tvmessage($groupprocessuid,$queuelocationuid){
            $this->load->model('TVMessageMDL');
            return $this->TVMessageMDL->add(['groupprocessuid' => $groupprocessuid, 'queuelocationuid' => $queuelocationuid]);
        }
        public function update_tvmessage($uid){
            $Input = $this->input->post();
            $this->load->model('TVMessageMDL');
            $Input['uid'] = $uid;
            return $this->TVMessageMDL->update_tvmessage($Input);
        }
    /* -- Common View Extension -- */

    
    /* -- Report / Statistic -- */
    //Report
    public function report()
    {
        $ViewData = array(
            'Site_Title' => 'Report',
            'FunctionName' => 'Report ตาราง',
            'Script' => array(
                'Main' => 'Report/report_vw_script',
            )
        );
        $ViewData = $this->report_view($ViewData);
        $this->renderView($ViewData);
    }
    public function report_view($Template = NULL,$queuelocationuid = NULL)
    {
        $this->load->model('MainMDL');
        $View = 'Report/report_vw';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();  
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function report_ajax(){
       $this->load->model('ReportMDL');
       $Input = $this->input->post();      
       header( "Content-Type: application/json" );
       $views = array();
       switch($Input['topic']){
            case 0: //Kiosk
                $views['Data'] = $this->ReportMDL->getKioskReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "kiosk_report";
                $output['html'] = $this->load->view('Report/ajax/kiosk',$views,TRUE);
                break;
            case 1: //คิดราคายา - Drugcharge
                $views['Data'] = $this->ReportMDL->getDrugChargeReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "drugcharge_report";
                $output['html'] = $this->load->view('Report/ajax/drugcharge',$views,TRUE);
                break;
            case 2: //ออกคิวยา - MedQueue
                $views['Data'] = $this->ReportMDL->getMedQueueReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "medqueue_report";
                $output['html'] = $this->load->view('Report/ajax/medqueue',$views,TRUE);
                break;
            case 3: //การเงิน - Cashier
                $views['Data'] = $this->ReportMDL->getCashierReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "cashier_report";
                $output['html'] = $this->load->view('Report/ajax/cashier',$views,TRUE);
                break;
            case 4: //จัดยา - Medication
                $views['Data'] = $this->ReportMDL->getMedicationReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "medication_report";
                $output['html'] = $this->load->view('Report/ajax/medication',$views,TRUE);
                break;
            case 5: //เช็คยา - CheckMed
                $views['Data'] = $this->ReportMDL->getCheckMedReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "checkmed_report";
                $output['html'] = $this->load->view('Report/ajax/checkmed',$views,TRUE);
                break;
            case 6: //จ่ายยา - Dispense
                $views['Data'] = $this->ReportMDL->getDispenseReport($Input['queuelocationuid'],$Input['date_from'],$Input['date_to']);
                $output['table'] = "dispense_report";
                $output['html'] = $this->load->view('Report/ajax/dispense',$views,TRUE);
                break;
            default:
                $output['html'] = "Please Select Valid Topic";
            break;
       }
       echo json_encode($output);      
    }
    //Statistic
    public function statistic()
    {
        $ViewData = array(
            'Site_Title' => 'Report',
            'FunctionName' => 'Report กราฟ',
            'Script' => array(
                'Main' => 'Statistic/statistic_vw_script',
            )
        );
        $ViewData = $this->statistic_view($ViewData);
        $this->renderView($ViewData);
    }
    public function statistic_view($Template = NULL,$queuelocationuid = NULL)
    {
        $this->load->model('MainMDL');
        $View = 'Statistic/statistic_vw';
        $returnArray = is_array($Template);
        if( !$returnArray ){
            $Template = array();
        }
        $Template['Data']['Queuelocation'] = $this->MainMDL->get_queuelocation();  
        if($returnArray){
            $Template['Content']['Main'] = $View;
            return $Template;
        }
        header("Content-Type: application/json");
        $output = array(
            'html' => $this->load->view($View, $Template, TRUE),
        );
        echo json_encode($output);
    }
    public function statistic_ajax(){
       $this->load->model('StatMDL');
       $Input = $this->input->post();      
       header( "Content-Type: application/json" );
       $views = array();
       switch($Input['topic']){
            case 0: //Kiosk
                $views['Data'] = $this->StatMDL->getKioskStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/kiosk',$views,TRUE);
                break;
            case 1: //คิดราคายา - Drugcharge
                $views['Data'] = $this->StatMDL->getDrugChargeStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/drugcharge',$views,TRUE);
                break;
            case 2: //ออกคิวยา - MedQueue //Disabled
                $output['html'] = "Please Select Valid Topic";
                break;
                $views['Data'] = $this->StatMDL->getMedQueueStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/medqueue',$views,TRUE);
                break;
            case 3: //การเงิน - Cashier
                $views['Data'] = $this->StatMDL->getCashierStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/cashier',$views,TRUE);
                break;
            case 4: //จัดยา - Medication
                $views['Data'] = $this->StatMDL->getMedicationStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/medication',$views,TRUE);
                break;
            case 5: //เช็คยา - CheckMed
                $views['Data'] = $this->StatMDL->getCheckMedStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/checkmed',$views,TRUE);
                break;
            case 6: //จ่ายยา - Dispense
                $views['Data'] = $this->StatMDL->getDispenseStat($Input['queuelocationuid'],$Input['date_select']);
                $output['stat'] = $views['Data'];
                $output['html'] = $this->load->view('Statistic/ajax/dispense',$views,TRUE);
                break;
            default:
                $output['html'] = "Please Select Valid Topic";
            break;
       }
       echo json_encode($output);      
    }

    /* -- Report / Statistic -- */

    /* -- Additional -- */
    public function get_queuelist()
    {
        $this->load->model('MainMDL');
        $query = $this->MainMDL->get_queuelist();
        echo json_encode($query);
    }
    /* -- Additional -- */
}
