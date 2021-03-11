<?php

class StepProcessing extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
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

            ),
            'js' => array(
                'popper1' => 'js/popper.min.js',
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
                'dataTables' => 'kiosk/resources/datatable/jquery.dataTables.min.js'
            ),
            'node_modules' => array(
                'socket.io' => 'socket.io-client/dist/socket.io.js',
            )
        );
        $this->template_module->SlipTemplate($Template);
    }

    public function MainPage($page, $title, $script)
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

            ),
            'js' => array(
                'popper1' => 'js/popper.min.js',
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
                'dataTables' => 'kiosk/resources/datatable/jquery.dataTables.min.js'
            ),
            'node_modules' => array(
                'socket.io' => 'socket.io-client/dist/socket.io.js',
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


    public function CheckPayor()
    {
        $page = array('Main' => 'CheckPayor/CheckPayor_vw');
        $title = 'CheckPayor';
        $script = 'CheckPayor/CheckPayor_script';
        $this->MainPage($page, $title, $script);
    }

    public function Appointment()
    {
        $page = array('Main' => 'Appointment/Appointment_vw');
        $title = 'Appointment';
        $script = '';
        $this->MainPage($page, $title, $script);
    }

    public function ProcessService()
    {
        $page = array('Main' => 'ProcessService/ProcessService_vw');
        $title = 'ProcessService';
        $script = 'ProcessService/ProcessService_script';
        $this->MainPage($page, $title, $script);
    }

    public function ProcessServiceClear()
    {
        $page = array('Main' => 'ProcessServiceClear/ProcessServiceClear_vw');
        $title = 'ProcessServiceClear';
        $script = '';
        $this->MainPage($page, $title, $script);
    }

    public function PersonType()
    {
        $page = array('Main' => 'PersonType/PersonType_vw');
        $title = 'PersonType';
        $script = 'PersonType/PersonType_scripe';
        $this->MainPage($page, $title, $script);
    }


    public function CreateSession()
    {
        $data = $this->input->post('data');
        $sesData = array(
            'UserInfo' => $data
        );
        
        $this->session->set_userdata('SessionMain', $sesData);

        echo json_encode($data);
    }
}
