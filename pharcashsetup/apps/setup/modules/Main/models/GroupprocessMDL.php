<?php
class GroupprocessMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_groupprocess($data = NULL)
    {
        $this->db->select('*');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('groupprocess');
        return $query->result();
    }

    function get_groupprocess_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('groupprocess');
        return $query->row();
    }

    function add_groupprocess($data){
        $data['cuser'] = $data['muser'];
        unset($data['cuser']);
        unset($data['muser']);
        $result = $this->db->insert('groupprocess',$data);
        return $result;
    }

    function update_groupprocess($data){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('groupprocess');
        return $result;
    }

    function del_groupprocess($data){
        $result = $this->db->delete('groupprocess',$data);
        return $result;
    }
}
