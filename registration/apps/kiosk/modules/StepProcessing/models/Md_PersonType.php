<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_PersonType extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->libraries('database');
    }

    public function update_queue()
    {

        $patient_uid = $this->input->post('patient_uid');
        $active = $this->input->post('active');

        $set = array(
            'active' => $active
        );

        $this->db->where('uid', $patient_uid)
            ->update('tr_patient', $set);
        
        $datapcc = array(
            'patientuid' => $patient_uid,
            'worklistuid' => '17',
            'createdate'=>date('Y-m-d H:i:s')
        );

        $this->db->insert('tr_processcontrol',$datapcc);    

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getworklist()
    {
        $patient_uid = $this->input->post('patient_uid');

        $this->db->select('*')
            ->from('vw_patientprocess')
            ->where('patientuid',$patient_uid)
            ->order_by('worklistuid','asc');
       
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getpersontype(){
        
        $this->db->select('*')
        ->from('tb_patienttype')
        ->order_by('order','ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function getpayor(){
        
        $this->db->select('*')
        ->from('tb_payor')
        ->order_by('order','ASC');
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    
    public function getPayorByType($data){
        //data
        //['type']['uidType']['idcard']['hn']['location']['kiosk_location']
        $Payor = $this->db->select('uid,code')
            ->from('tb_patienttype')
            //->where('code',$data['type'])
            ->order_by('order','ASC')
            ->get()->result_array();
        $this->db->reset_query();
        $Patient = $this->db->select('patienttypeid,idcard,payorid')
            ->from('tr_patient')
            ->where('patienttypeid',$data['uidType'])
            ->where('idcard',$data['idcard'])
            ->group_by('payorid,patienttypeid,idcard')->get()->result_array();
        
        $fullHN = explode('/',$data['hn'])[1] . '/' . explode('/',$data['hn'])[0];
        $PayorURL = CREDITAPI . '/' . $fullHN . '/null/' . date('Y-m-d');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YXJtOjEyMzQ=',
        ));        
		curl_setopt($ch, CURLOPT_URL,$PayorURL);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($httpcode == 200 || $httpcode == 201){
            if(count($result) > 0){
                $response = array(
                    'success' => TRUE,
                    'data' => $result[count($result)-2],
                    'data1' => $result,
                );
            }else{
                $response = array(
                    'success' => TRUE,
                    'data' => '',
                    'data1' => $result,
                );
            }
        }else if($httpcode == 404){
            $response = array(
                'success' => TRUE,
                'data' => '',
                'data1' => '',
            );
        }else if($httpcode == 500){
            $response = array(
                'success' => TRUE,
                'error' => 500,
                'data' => '',
                'data1' => '',
            );
        }
        $dataLastPayor = $response['data'];
        $dataLastPayorAll = $response['data1'];
        $r_data = array(
            'PayorURL' => $PayorURL,
            'location' => $data['location'],
            'kiosk_location' => $data['kiosk_location'],
            'Payor' => $Payor,
            'Patient' => $Patient,
            'dataLastPayor' => $dataLastPayor,
            'dataLastPayorAll' => $dataLastPayorAll,
        );
        return $r_data;
        
    }

}
