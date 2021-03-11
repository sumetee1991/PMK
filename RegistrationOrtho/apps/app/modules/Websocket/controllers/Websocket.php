<?php

class Websocket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function connectSocket($midSocket,$urlAPP, $portAPP, $urlMID, $portMID, $localurl)
    {
        // $con = array(
        //     'socket' => 'io.connect( "http://'.LINKURL.':'.PORTAPP.'" )',
        //     'appSocket' => 'io.connect("http://'.LINKURL1.':'.PORTMID.'")',
        //     'pathUrl' => $path
        // );

        // return $con;

        $con = array(
            'appsocket' => 'io.connect( "'.$midSocket.'" )',
            'midSocket' => SOCKETURL,
            //'midSocket' => 'io.connect("http://' . $urlMID . ':' . $portMID . '")',
            'baseurlMid' => $midSocket,//'http://' . $urlMID . ':' . $portMID,
            'baselocal' => 'http://' . $localurl
        );

        return $con;
    }




    //SocketConnection
    public function SocketConnection()
    {
        $Connection = $this->connectSocket(SSLPREFIX.MIDURL,LINKURL, PORTAPP, LINKURL, PORTMID, LOCALURL);
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
        $html = ' var midSocket = ' . $url['socket'] . ';';
        $html .= ' var appSocket = ' . $url['appSocket'] . ';';
        $html .= ' var url = "http://' . LINKURL . ':' . PORTMID . '";';

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
        $pathAction = 'Qpmk/z_setup/';
        return "'/" . $pathAction . "'";
    }

    public function NextToPersonType()
    {
        $pathAction = 'Qpmk/z_setup/StepProcessing/PersonType';
        return "'/" . $pathAction . "'";
    }

    public function NextToCheckPayor()
    {
        $pathAction = 'Qpmk/z_setup/StepProcessing/CheckPayor';
        return "'/" . $pathAction . "'";
    }

    public function NextToProcessService()
    {
        $pathAction = 'Qpmk/z_setup/StepProcessing/ProcessService';
        return "'/" . $pathAction . "'";
    }

    public function NextToSlip()
    {
        $pathAction = 'Qpmk/z_setup/StepProcessing/Slip';
        return "'/" . $pathAction . "'";
    }

    public function NextToProcessServiceClear()
    {
        $pathAction = 'Qpmk/z_setup/StepProcessing/ProcessServiceClear';
        return "'/" . $pathAction . "'";
    }
}
