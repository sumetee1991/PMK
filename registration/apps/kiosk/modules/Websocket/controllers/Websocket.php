<?php

class Websocket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function connectSocket($midSocket,$urlMID, $portMID, $localurl, $portlocal, $linkapi)
    {
        // $con = array(
        //     'socket' => 'io.connect( "http://'.LINKURL.':'.PORTAP=P.'" )',
        //     'appSocket' => 'io.connect("http://'.LINKURL1.':'.PORTMID.'")',
        //     'pathUrl' => $path
        // );

        // return $con;

        $con = array(
            // 'appsocket' => 'io.connect( "https://pmk.express-apps.com/regissocket" )',
            // 'midSocket' => 'io.connect("https://pmk.express-apps.com/regissocket")',
            'midSocket' => SOCKETURL,
            //'midSocket' => 'io.connect("'.$midSocket.'",{secure:true,path:'."'/regissocket/socket.io'".'})',// . ':' . $portMID . '")',
            //'midSocket' => 'io.connect("'.$midSocket.'",{secure:true,resource:'."'/regissocket/socket.io'".'})',// . ':' . $portMID . '")',
	    //'midSocket' => 'io.connect("http://191.123.58.33:9000",{secure:true})',
            'baseurlMid' => $midSocket,//$urlMID . ':' . $portMID,
            'baselocal' => $localurl,// . ':' . $portlocal,
            'baseimgkiosk' => $localurl,// . ':' . $portlocal,
            'baselinkapi' => $linkapi,
        );

        return $con;
    }





    public function SocketConection()
    {
        $Connection = $this->connectSocket(SSLPREFIX.MIDURL,SSLPREFIX.LINKURL.MIDURI, PORTMID, LOCALURL, PORTLOCAL, LINKAPI);
        $this->load->view('socket_view', $Connection);
    }


    // public function socketManage()
    // {
    //     // $path = 'testemit';
    //     // $url = $this->connectSocket($path);
    //     // return $this->manageView($url);
    // }

    public function manageView($url)
    {
        // print_r($url); die();
        $html = ' var midSocket = ' . $url['socket'] . ';';
        $html .= ' var appSocket = ' . $url['appSocket'] . ';';
        $html .= ' var url = "'.SSLPREFIX.MIDURL.'"';//"https://' . LINKURL . '";';

        return $html;
    }

    public function render()
    {
        $this->load->module('Template_Module');
        $Template = array(
            'Module' => 'Websocket',
            'Content' => array(
                'Main' => 'manage_v',
            )
        );

        $this->template_module->MainTemplate($Template);
    }

    public function BaseContoller()
    {
        return "''";
        $pathAction = LOCALPJ . '/z_kiosk';
        return "'/" . $pathAction . "'";
    }

    public function ScannerPage()
    {
        return "'/Scanner/PIDScanner'";
        $pathAction = LOCALPJ . '/z_kiosk/Scanner/PIDScanner';
        return "'/" . $pathAction . "'";
    }

    public function Scanner_url()
    {
        $pathAction = 'api/kiosk';
        return "'/" . $pathAction . "'";
    }

    public function NextStepTwo()
    {
        return "'/StepProcessing/WelcomeNoHn'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/WelcomeNoHn';
        return "'/" . $pathAction . "'";
    }

    public function NextToPersonType()
    {
        return "'/StepProcessing/PersonType'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/PersonType';
        return "'/" . $pathAction . "'";
    }

    public function NextToPayor()
    {
        return "'/StepProcessing/Payor'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/Payor';
        return "'/" . $pathAction . "'";
    }

    public function NextToProcessService()
    {
        return "'/StepProcessing/ProcessService'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/ProcessService';
        return "'/" . $pathAction . "'";
    }

    public function NextToSlip()
    {
        return "'/StepProcessing/Slip'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/Slip';
        return "'/" . $pathAction . "'";
    }

    public function NextToProcessServiceClear()
    {
        return "'/StepProcessing/ProcessServiceClear'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/ProcessServiceClear';
        return "'/" . $pathAction . "'";
    }
    public function NextToAppointment()
    {
        return "'/StepProcessing/Appointment'";
        $pathAction = LOCALPJ . '/z_kiosk/StepProcessing/StepProcessing/Appointment';
        return "'/" . $pathAction . "'";
    }
}
