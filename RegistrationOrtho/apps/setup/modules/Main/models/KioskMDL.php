<?php
class KioskMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_kiosk()
    {
        $this->db->select('*');
        $this->db->order_by('kiosk_location', 'asc');
        $query = $this->db->get('kiosk_control');
        return $query->result();
    }

    function get_kiosk_row($uid = NULL)
    {
        $this->db->select('*');
        if($uid){
            $this->db->where('uid',$uid);
        }
        $query = $this->db->get('kiosk_control');
        return $query->row();
    }

    function get_kiosk_queuelocation($queuelocationuid)
    {
        $this->db->select('*');
        $this->db->where('queuelocationuid',$queuelocationuid);
        $query = $this->db->get('kiosk_control');
        return $query->row();
    }

    function add_kiosk($data){
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('kiosk_control',$data);
        return $result;
    }

    function update_kiosk($data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        if(isset($data['uid'])){
            $this->db->where('uid', $data['uid']);
        }        
        $result = $this->db->update('kiosk_control');
        return $result;
    }

    function update_kiosk_queuelocation($queuelocationuid,$data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $result = $this->db->update('kiosk_control');
        return $result;
    }

    function del_kiosk($data){
        $result = $this->db->delete('kiosk_control',$data);
        return $result;
    }
}
