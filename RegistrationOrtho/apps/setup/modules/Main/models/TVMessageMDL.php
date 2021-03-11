<?php
class TVMessageMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_tvmessage($data = NULL)
    {
        $data['locationid'] = $data['queuelocationuid'];
        unset($data['queuelocationuid']);
        $this->db->where($data);
        $this->db->select('*');
        $query = $this->db->get('tv_message');
        return $query->result();
    }
    
    function get_tvmessage_row($data)
    {        
        $data['locationid'] = $data['queuelocationuid'];
        unset($data['queuelocationuid']);
        $this->db->where($data);
        $query = $this->db->get('tv_message');
        return $query->row();
    }

    function add($data){
        $sql = "
        INSERT INTO tv_message(groupprocessuid,locationid)
        VALUES({$data['groupprocessuid']},{$data['queuelocationuid']})
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_tvmessage($data){
        $uid = $data['uid'];
        unset($data['uid']);
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('tv_message');
        return $result;
    }
}
