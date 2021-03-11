<?php
class PatientCategoryMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_patientcategory($data = NULL)
    {
        $this->db->select('*');        
        if($data){
            $this->db->where($data);
        }
        $this->db->where('(groupprocessuid != 6 OR groupprocessuid is NULL)',NULL,FALSE);
        $this->db->where('uid <>',11,FALSE);
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('patientcategory');
        return $query->result();
    }

    function get_patientcategory_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('patientcategory');
        return $query->row();
    }

    function add_patientcategory($data){
        $data['sequence'] = intval($this->db->select('MAX(sequence) as sequence')->from('patientcategory')->get()->row()->sequence)+1;
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        unset($data['cuser']);
        unset($data['muser']);
        $this->db->reset_query();
        $result = $this->db->insert('patientcategory',$data);
        return $result;
    }

    function update_patientcategory($data){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('patientcategory');
        return $result;
    }

    function del_patientcategory($data){
        $result = $this->db->delete('patientcategory',$data);
        return $result;
    }
}
