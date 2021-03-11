<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestJWT extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
    }

    public function index()
    {        
        $this->load->module('Template_Module');

        $Template = array(
            'Module' => 'TestJWT',
            'Site_Title' => 'Test',
            'Content' => array(
                'Main' => 'JWT_View'
            ),
            'Script' => array(
                'Script' => 'JWT_Script',
            ),
            'css' => array(
                'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css', 
                'fontawesome5.11.2' => 'fontawesome/css/all.css', 
            ),
            'js' => array(
                'popper1' => 'js/popper.min.js', 
                'jquery3.4.1' => 'js/jquery-3.4.1.min.js', 
                'bootstrap4.3.1' => 'bootstrap/js/bootstrap.min.js', 
            ),
            'node_modules' => array(
                'socket.io' => 'dist/socket.io.js',
            ),
        );
        $this->template_module->MainTemplate($Template);
    }

    public function refreshToken(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://service.healthyflow.xyz/hybrid-auth/api/refresh");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo json_encode($result);
    }
}
