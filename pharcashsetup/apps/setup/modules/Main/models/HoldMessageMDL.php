<?php
class HoldMessageMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_holdmessage($data = NULL)
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = hold_message.groupprocessuid) as groupprocessdesc');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('hold_message');
        return $query->result();
    }

    function get_holdmessage_group($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = hold_message.groupprocessuid) as groupprocessdesc');
        $this->db->where('groupprocessuid', $groupprocessuid);
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get('hold_message');
        return $query->result();
    }

    function get_holdmessage_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('hold_message');
        return $query->row();
    }

    function add_holdmessage($data){
        $sq_row = $this->db->select('MAX(sequence)')->from('hold_message')->where('groupprocessuid',$data['groupprocessuid'])->get()->row();
        if($sq_row){
            $data['sequence'] = 1;
        }else{
            $data['sequence'] = intval($sq_row->sequence)+1;
        }
        $this->db->reset_query();
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('hold_message',$data);
        return $result;
    }

    function update_holdmessage($data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('hold_message');
        return $result;
    }

    function del_holdmessage($data){
        $result = $this->db->delete('hold_message',$data);
        return $result;
    }
}
