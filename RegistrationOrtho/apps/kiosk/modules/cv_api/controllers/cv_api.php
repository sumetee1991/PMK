<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cv_api extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
        // $this->load->module('StepProcessing/PersonType');
    }

    public function worklist_process($worklistgroupuid){
        $this->load->model('MDL_worklist');
        $query = $this->MDL_worklist->process($worklistgroupuid);
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function worklist_process_clear($patientuid){
        $this->load->model('MDL_worklist');
        $query = $this->MDL_worklist->process_clear($patientuid);
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    //chkApiOldPatient
    public function API_OldPatient($data){
        $IDCard = $data['idcard'];//'3101401946651';
        $HN = $data['hn'];//'44800/62';
        $SearchIDCard = $IDCard;
        $SearchHN = explode('/',$HN)[1] . '/' . explode('/',$HN)[0];
        $URL = PATIENTAPI . '/' . $SearchHN . '/' . $SearchIDCard;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YXJtOjEyMzQ=',
        ));        
		curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = array(
            'success' => $result?true:false,
            'code' => $httpcode,
            'result' => json_decode($result,TRUE)
        );
        return $response;
        // $result = curl_exec($ch);
        // return $result && json_decode($result,TRUE)['success'] ? json_decode($result,TRUE)['data'] : false;
    }

    //getAppointmentDataAPI
    public function API_AppointmentData($data){
        $AppointmentDate = isset($data['appointmentdate'])?$data['appointmentdate']:date('Y-m-d');//'2019-11-25';
        $HN = $data['hn'];//'44800/62';
        $SearchDate = date('Y-m-d',strtotime($AppointmentDate));
        $SearchHN = explode('/',$HN)[1] . '/' . explode('/',$HN)[0];
        $URL =  APPOINTMENTAPI .'/' . $SearchDate . '/null/' .$SearchHN;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YXJtOjEyMzQ=',
        ));        
		curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = array(
            'success' => $result?json_decode($result,TRUE)['success']:false,
            'code' => $httpcode,
            'result' => json_decode($result,TRUE)
        );
        return $response;
        // $result = curl_exec($ch);
        // return $result && json_decode($result,TRUE)['success'] ? json_decode($result,TRUE)['data'] : false;
    }

    //getLastPayorByHN
    public function API_LasyPayorHN($data){
        $AppointmentDate = isset($data['appointmentdate'])?$data['appointmentdate']:date('Y-m-d');//'2020-01-31';
        $HN = $data['hn'];//'13333/99';
        $SearchDate = date('Y-m-d',strtotime($AppointmentDate));
        $SearchHN = explode('/',$HN)[1] . '/' . explode('/',$HN)[0];
        $URL = CREDITAPI . '/' . $SearchHN . '/null/' . $SearchDate;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YXJtOjEyMzQ=',
        ));        
		curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = array(
            'success' => $result?json_decode($result,TRUE)['success']:false,
            'code' => $httpcode,
            'result' => json_decode($result,TRUE)
        );
        return $response;
    }

    public function scanInput(){
        $Input = $this->input->post();
        $chkOldPatientData = array(
            'hn' => 'null/null',
            'idcard' => $Input['citizenid']
        );
        $chkOldPatient = $this->API_OldPatient($chkOldPatientData);
        if($chkOldPatient['success'] && $chkOldPatient['code'] == 200 && $chkOldPatient['result']){
            $PatientData = $chkOldPatient['result'][0];
        }
        $response['data'] = array(
            'scan' => true,
            'idcard' => $Input['citizenid'],
            'hn' => isset($PatientData)?$PatientData['hn']:'',
            'prename' => $Input['prefixname_th'],
            'forename' => $Input['firstname_th'],
            'surname' => $Input['lastname_th'],
            'dob' => $Input['dob'],
            'gender' => ($Input['gender'] == 1?'m':'f'), //1 = Male
        );
        $response['data']['pidxxx'] = substr($response['data']['idcard'],0,4).'xxxxx'.substr($response['data']['idcard'],9,4);
        $this->session->set_userdata('PatientInfo',$response); //Set PatientInfo Session
        echo json_encode($response);
        return true;
    }

    public function manualInput(){
        $Input = $this->input->post();
        if( strlen($Input['input']) == 13){
            $inputType = 0;
            $chkOldPatientData = array(
                'hn' => 'null/null',
                'idcard' => $Input['input']
            );
        }else{
            $inputType = 1;
            $chkOldPatientData = array(
                'hn' => $Input['input'],
                'idcard' => 'null'
            );
        }        
        $chkOldPatient = $this->API_OldPatient($chkOldPatientData);
        if($chkOldPatient['success'] && $chkOldPatient['code'] == 200 && $chkOldPatient['result']){
            $PatientData = $chkOldPatient['result'][0];
        }
        $response['data'] = array(
            'scan' => false,
            'idcard' => isset($PatientData)?$PatientData['pid']:($inputType == 0?$Input['input']:''),
            'hn' => isset($PatientData)?$PatientData['hn']:($inputType == 1?$Input['input']:''),
            'prename' => isset($PatientData)?$PatientData['preName']:'',
            'forename' => isset($PatientData)?$PatientData['firstName']:'',
            'surname' => isset($PatientData)?$PatientData['lastName']:'',
            'dob' => isset($PatientData)?$PatientData['birthDate']:'',
            'gender' => isset($PatientData)?($PatientData['gender'] == 'หญิง' || $PatientData['gender'] == 'Female' || $PatientData['gender'] == 'female' ? 'f' : 'm') : '0',
        );
        $response['data']['pidxxx'] = substr($response['data']['idcard'],0,4).'xxxxx'.substr($response['data']['idcard'],9,4);
        $this->session->set_userdata('PatientInfo',$response); //Set PatientInfo Session
        echo json_encode($response);
        return true;
    }

}

