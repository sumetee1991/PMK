<?php
class UserAuthorizationMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_user(){
        $this->db->where('statusflag','Y');
        $query = $this->db->get('user_auth');
        return $query->result();
    }

    function get_userauth($data = NULL)
    {
        $this->db->select('*');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('user_authorization');
        return $query->result();
    }

    function get_userauth_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('user_authorization');
        return $query->row();
    }

    function add_userauth($data){
        $data['status'] = 'A';
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('user_authorization',$data);
        return $result;
    }

    function update_userauth($data){
        $uid = $data['uid'];
        unset($data['uid']);
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('user_authorization');
        return $result;
    }

    function del_userauth($data){
        $result = $this->db->delete('user_authorization',$data);
        return $result;
    }
}
