<?php

class Scanner extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }

    public function PIDScanner()
    {
        $this->load->module('Template_Module');
        $this->load->module('Websocket');

        $Template = array(
            'Module' => 'Scanner',
            'Site_Title' => 'Phramongkutklao',
            'Content' => array(
                'Main' => 'PID/Scanner',
            ),
            'Script' => array(
                'Script' => 'PID/Scanner_Script',

            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
                'fontawesome5.11.2' => 'fontawesome/css/all.css',
                'style_main' => 'kiosk/resources/css/style.css',
                'ModalCss'=> 'kiosk/resources/css/ModalCss.css',
                'loading'=>'kiosk/resources/css/loading.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js',
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
                'bootstrap4.3.1'=>'bootstrap/js/bootstrap.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            )
        );

        $this->template_module->MainTemplate($Template);
    }

    
}
