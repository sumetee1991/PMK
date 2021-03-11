<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

class Api_visit_ortho extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('assets');
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

// var_dump(json_encode($postCURL));
// exit();

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
$postData['code'] = $message['code'];
$postData['result'] = $message['result'];
$LogAPI = $this->Management_Model->InsertLogAPI($postData);
$message['log_id'] = $LogAPI;
echo json_encode($message);

}
}