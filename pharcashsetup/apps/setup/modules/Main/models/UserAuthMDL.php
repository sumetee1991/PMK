<?php
class UserAuthMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_uid_userauth()
    {
        $this->db->select('uid');
        $query = $this->db->get('user_auth');
        return $query->result();
    }

    function get_userauth()
    {
        $this->db->where('statusflag', 'Y');
        $query = $this->db->get('user_auth');
        return $query->result();
    }

    // function get_userauth($data = NULL)
    // {
    //     $this->db->select('*');
    //     if ($data) {
    //         $this->db->where($data);
    //     }
    //     $this->db->order_by('uid', 'asc');
    //     $query = $this->db->get('user_authorization');
    //     return $query->result();
    // }

    function get_userauth_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid', $uid);
        $query = $this->db->get('user_auth');
        return $query->row();
    }

    function add_userauth($data)
    {
        // $data['username'] = $data['add_user'];
        // var_dump('add_user');
        $data['statusflag'] = 'Y';
        // $data['queuelocationuid'] = '1';
        // $data['cwhen'] = 'NOW()';
        // $data['cuser'] = $data['muser'];
        $result = $this->db->insert('user_auth', $data);
        return $result;
    }

    function update_userauth($data)
    {
        // $data['mwhen'] = 'NOW()';
        $uid = $data['uid'];
        unset($data['uid']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('user_auth');
        return $result;
    }

    function del_userauth($data)
    {
        $result = $this->db->delete('user_auth', $data);
        return $result;
    }
}
