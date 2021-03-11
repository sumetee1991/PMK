<?php
class UserAuthorizationMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_uid_userauthorization()
    {
        $this->db->select('uid');
        $query = $this->db->get('user_authorization');
        return $query->result();
    }

    // function get_user()
    // {
    //     $this->db->where('statusflag', 'Y');
    //     $query = $this->db->get('user_auth');
    //     return $query->result();
    // }

    function get_userauthorization($data = NULL)
    {
        $this->db->select('*');
        if ($data) {
            $this->db->where($data);
        }
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('user_authorization');
        return $query->result();
    }

    function get_userauthorization_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid', $uid);
        $query = $this->db->get('user_authorization');
        return $query->row();
    }

    function add_userauthorization($data)
    {
        // $data['username'] = $data['add_user'];
        // var_dump('add_user');
        $data['status'] = 'A';
        // $data['queuelocationuid'] = '0';
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('user_authorization', $data);
        return $result;
    }

    function update_userauthorization($data)
    {
        $data['mwhen'] = 'NOW()';
        $uid = $data['uid'];
        unset($data['uid']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('user_authorization');
        return $result;
    }

    function del_userauthorization($data)
    {
        $result = $this->db->delete('user_authorization', $data);
        return $result;
    }
}
