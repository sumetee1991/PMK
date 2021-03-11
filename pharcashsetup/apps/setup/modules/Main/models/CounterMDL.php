<?php
class CounterMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_available($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->order_by('sq', 'asc');
        $this->db->where('groupprocessuid is NULL',NULL,FALSE);
        $query = $this->db->get('counter');
        return $query->result();
    }

    function get_counter($data = NULL)
    {
        $this->db->select('*');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('sq', 'asc');
        $query = $this->db->get('counter');
        return $query->result();
    }

    function get_counter_group($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->where('groupprocessuid', $groupprocessuid);
        $this->db->order_by('sq', 'asc');
        $query = $this->db->get('counter');
        return $query->result();
    }

    function get_counter_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('counter');
        return $query->row();
    }

    function add_counter($data){
        
        $sq_row = $this->db->select('sq')->from('counter')->where('groupprocessuid',$data['groupprocessuid'])->where('queuelocationuid',$data['queuelocationuid'])->order_by('sq','DESC')->get()->row();
        if($sq_row){
            $data['sq'] = intval($sq_row->sq)+1;
        }else{
            $data['sq'] = 1;
        }
        
        $this->db->reset_query();
        
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        unset($data['cuser']);
        unset($data['muser']);
        $result = $this->db->insert('counter',$data);
        return $result;
    }

    function update_counter($data){
        $uid = $data['uid'];
        $data['mwhen'] = 'NOW()';
        unset($data['uid']);
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('counter');
        return $result;
    }

    function del_counter($data){
        $result = $this->db->delete('counter',$data);
        return $result;
    }

    function add_countercontrol($groupprocessuid,$data){
        $emptyslot = $this->db->select('uid,MIN(counterno)')
                                ->from('counter')
                                ->where('groupprocessuid IS NULL',NULL,FALSE)
                                ->group_by('uid')
                                ->get();
        if($emptyslot->num_rows() > 0){
            $emptyslot_id = $emptyslot->row()->uid;
            $this->db->reset_query();
            $sq_row = $this->db->select('MAX(sq)')->from('counter')->where('groupprocessuid',$groupprocessuid)->get()->row();
            if($sq_row){
                $data['sq'] = 1;
            }else{
                $data['sq'] = intval($sq_row->sq)+1;
            }
            
            $data['groupprocessuid'] = $groupprocessuid;
            $data['mwhen'] = 'NOW()';
            unset($data['muser']);
            $this->db->reset_query();
            $this->db->set($data, FALSE)
                        ->where('uid', $emptyslot_id)
                        ->update('counter');
            return $emptyslot_id;
        }else{
            return false;
        }
    }

    function update_countercontrol($uid,$Input){
        $CounterUID = $Input['uid'];
        $query = "
        UPDATE counter
        SET groupprocessuid = (SELECT groupprocessuid FROM counter WHERE uid = $uid)
        WHERE uid = $CounterUID
        ";
        $this->db->query($query);
        $this->db->reset_query();
        $remove_query = "
        UPDATE counter
        SET groupprocessuid = NULL
        WHERE uid = $uid
        ";
        $this->db->query($remove_query);
        return true;
    }

    function remove_countercontrol($uid){
        return $this->db->set('groupprocessuid','NULL', FALSE)
                    ->where('uid',$uid)
                    ->update('counter');    
    }
    
}
