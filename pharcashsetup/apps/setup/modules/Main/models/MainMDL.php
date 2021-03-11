<?php
class MainMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_first_queuelocation(){
        return $this->db->select('*')->from('queuelocation')->group_by('uid')->order_by('uid','ASC')->get()->row();
    }
    
    function get_row_queuelocation($queuelocationuid){
        return $this->db->select('*')->from('queuelocation')->where('locationuid',$queuelocationuid)->get()->row();
    }

    function get_queuelocation($queuelocationuid = NULL){
        $this->db->select('*');
        if($queuelocationuid){
            $this->db->where('queuelocationuid',$queuelocationuid);
        }
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('queuelocation');
        return $query->result();
    }

    function get_groupprocess(){
        $this->db->select('*');
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('groupprocess');
        return $query->result();
    }
    
    function get_queuelist(){
        $this->db->select('patientcategoryshortname AS queuecode');
        $this->db->where('patientcategoryshortname !=','');
        $this->db->where('patientcategoryshortname IS NOT NULL',NULL,FALSE);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('patientcategory');
        return $query->result();
    }    

    function get_queuelist_queuelocation($queuelocationuid){
        $this->db->select('patientcategoryshortname AS queuecode');
        $this->db->where('patientcategoryshortname !=','');
        $this->db->where('patientcategoryshortname IS NOT NULL',NULL,FALSE);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('patientcategory');
        return $query->result();
    }    

    function get_print_active(){
        $this->db->select('*');
        $this->db->select(' (SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = printcontrol.groupprocessuid) as groupprocessdesc');
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('printcontrol');
        return $query->result();
    }

    function update_print_active($data,$uid){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('printcontrol');
        return $result;
    }

    function update_queuelocation($data,$uid){
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('queuelocation');
        return $result;
    }
}
?>