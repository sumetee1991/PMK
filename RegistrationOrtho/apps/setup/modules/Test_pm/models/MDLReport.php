<?php
class MDLReport extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getKioskReport($From,$To)
    {
        $this->db->where("cwhen BETWEEN '$From'::date AND '$To'::date");
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_kiosk');
        return $data->result();
    }
    
    function getVisitReport($From,$To)
    {
        $this->db->where("cwhen BETWEEN '$From'::date AND '$To'::date");
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_management_visit');
        return $data->result();
    }
    function getNewHNReport($From,$To)
    {
        $this->db->where("cwhen BETWEEN '$From'::date AND '$To'::date");
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_management_newhn');
        return $data->result();
    }
    function getRegisterReport($From,$To)
    {
        $this->db->where("cwhen BETWEEN '$From'::date AND '$To'::date");
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_management_payor');
        return $data->result();
    }
}
