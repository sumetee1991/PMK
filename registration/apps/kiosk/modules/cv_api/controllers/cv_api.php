<?php

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
            'success' => $result?json_decode($result,TRUE)['success']:false,
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
        $this->load->model('MDL_patient');
        $Input = $this->input->post();
        $chkOldPatientData = array(
            'hn' => 'null/null',
            'idcard' => $Input['citizenid']
        );
        $chkOldPatient = $this->API_OldPatient($chkOldPatientData);
        $response = array();
        if($chkOldPatient['success'] && $chkOldPatient['code'] == 200){
            //OldPatient
            $PatientData = $chkOldPatient['result'];
            $chkPatientDB = $this->MDL_patient->chkPatientDB(array('idcard'=>$PatientData['pid']));
            if($chkPatientDB->num_rows() > 0){
                //Reprint

            }else{
                //NewQueue
                $chkAppointment = $this->API_AppointmentData($PatientData);
                if($chkAppointment['success'] && $chkAppointment['code'] == 200){
                    //Have Appointment
                }elseif(!$chkAppointment['success'] && $chkAppointment['code'] == 404){
                    //No Appointment
                }else{
                    //Can't Access API:OldPatient
                }

            }
        }elseif(!$chkOldPatient['success'] && $chkOldPatient['code'] == 404){
            //NotOldPatient
        }else{
            //Can't Access API:OldPatient
        }
        $response['api_his'] = isset($chkOldPatient)?$chkOldPatient['success']:false;
        $response['api_appointment'] = isset($chkAppointment)?$chkAppointment['success']:false;
        $response['Data'] = array(
            'scan' => true,
            'idcard' => $Input['citizenid'],
            'prename' => $Input['prefixname_th'],
            'forename' => $Input['firstname_th'],
            'surname' => $Input['lastname_th'],
            'dob' => date('d/m/Y',strtotime($Input['dob'])),
            'gender' => $Input['gender'], //1 = Male
        );
        $this->session->set_userdata('PatientInfo',$response); //Set PatientInfo Session
        return true;
    }

    public function manualInput(){
        $this->load->model('MDL_patient');
        $Input = $this->input->post();
        $chkOldPatientData = array(
            'hn' => 'null/null',
            'idcard' => $Input['input']
        );
        $chkOldPatient = $this->API_OldPatient($chkOldPatientData);
        $response = array();
        if($chkOldPatient['success'] && $chkOldPatient['code'] == 200){
            //OldPatient
            $PatientData = $chkOldPatient['result'];
            $chkPatientDB = $this->MDL_patient->chkPatientDB(array('idcard'=>$PatientData['pid']));
            if($chkPatientDB->num_rows() > 0){
                //Reprint

            }else{
                //NewQueue
                $chkAppointment = $this->API_AppointmentData($PatientData);
                if($chkAppointment['success'] && $chkAppointment['code'] == 200){
                    //Have Appointment
                }elseif(!$chkAppointment['success'] && $chkAppointment['code'] == 404){
                    //No Appointment
                }else{
                    //Can't Access API:OldPatient
                }

            }
        }elseif(!$chkOldPatient['success'] && $chkOldPatient['code'] == 404){
            //NotOldPatient
        }else{
            //Can't Access API:OldPatient
        }
        $response['api_his'] = isset($chkOldPatient)?$chkOldPatient['success']:false;
        $response['api_appointment'] = isset($chkAppointment)?$chkAppointment['success']:false;
        $response['Data'] = array(
            'scan' => false,
            'idcard' => isset($PatientData)?$PatientData['idcard']:$Input['input'],
            'prename' => isset($PatientData)?$PatientData['prename']:'',
            'forename' => isset($PatientData)?$PatientData['forename']:'-',
            'surname' => isset($PatientData)?$PatientData['surname']:'',
            'dob' => isset($PatientData)?date('d/m/Y',strtotime($PatientData['dob'])):'',
            'gender' => isset($PatientData)?($PatientData['gender'] == '????????????' || $PatientData['gender'] == 'Female' || $PatientData['gender'] == 'female' ? '2' : '1') : '0',
        );
        $this->session->set_userdata('PatientInfo',$response); //Set PatientInfo Session
        return true;
    }

}
