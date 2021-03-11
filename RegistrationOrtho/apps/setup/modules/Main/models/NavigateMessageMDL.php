<?php
class NavigateMessageMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_navigatemessage($data = NULL)
    {
        $this->db->select('*');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('navigate_message');
        return $query->result();
    }

    function get_navigatemessage_group($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->where('groupprocessuid', $groupprocessuid);
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('navigate_message');
        return $query->result();
    }

    function get_navigatemessage_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('navigate_message');
        return $query->row();
    }

    function add($data){
        $sql = "
        INSERT INTO navigate_message(sequence,groupprocessuid,queuelocationuid)
        VALUES
            (0,{$data['groupprocessuid']},{$data['queuelocationuid']}),
            (1,{$data['groupprocessuid']},{$data['queuelocationuid']})
        ";
        $query = $this->db->query($sql);
    }

    function add_navigatemessage($data){
        $data['cuser'] = $data['muser'];
        unset($data['cuser']);
        unset($data['muser']);
        $result = $this->db->insert('navigate_message',$data);
        return $result;
    }

    function update_navigatemessage($data){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('navigate_message');
        return $result;
    }

    function del_navigatemessage($data){
        $result = $this->db->delete('navigate_message',$data);
        return $result;
    }
}
