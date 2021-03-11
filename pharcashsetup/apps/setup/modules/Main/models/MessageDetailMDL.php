<?php
class MessageDetailMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_holdmessage($data = NULL)
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = message.groupprocessuid) as groupprocessdesc');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('message');
        return $query->result();
    }

    function get_holdmessage_group($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = message.groupprocessuid) as groupprocessdesc');
        $this->db->where('groupprocessuid', $groupprocessuid);
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('message');
        return $query->result();
    }

    function get_holdmessage_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('message');
        return $query->row();
    }

    function add_holdmessage($data){
        $sq_row = $this->db->select('sequence')->from('message')->where($data)->order_by('sequence','DESC')->get()->row();
        if($sq_row){
            $data['sequence'] = intval($sq_row->sequence)+1;
        }else{
            $data['sequence'] = 1;
        }
        $this->db->reset_query();
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('message',$data);
        return $result;
    }

    function update_holdmessage($data){
        $uid = $data['uid'];
        unset($data['uid']);
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('message');
        return $result;
    }

    function del_holdmessage($data){
        $result = $this->db->delete('message',$data);
        return $result;
    }
}
