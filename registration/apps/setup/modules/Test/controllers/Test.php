<?php

class Test extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }
    public function index(){ 
       $this->load->module('Template_Module');    
        $Template = array(
            'Module' => 'Test',
            'Site_Title' => 'test monk',
            'Content' => array(
               'testtest' => 'test_vw',
            ),
            'Script' => array(
               'testscript' => 'test_script',
            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
                'fontawesome5.11.2' => 'fontawesome/css/all.css',
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js',
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            ),
            'node_modules' => array(
                'socket.io' => 'socket.io-client/dist/socket.io.js',
            )
        );
        $this->template_module->MainTemplate($Template);
    }

}
