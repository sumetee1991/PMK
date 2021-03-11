<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MDL_patient extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->libraries('database');
    }

    public function SearchPatient($Input){
        $this->db->select('*')
            ->from('tr_patient')
            ->or_where('idcard',$Input)
            ->or_where('hn',$Input)
            ->or_where('refno',$Input)
            ->order_by('uid','DESC')
            ->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function chkPatientDB($data){
        $this->db->select('*')
            ->from('tr_patient')
            ->where($data)
            ->where('cwhen::date = now()::date',NULL,FALSE)
            ->order_by('uid','DESC')
            ->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function InsertPatientDB($data){
        

    }
}
