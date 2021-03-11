<?php
class TVMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_tv()
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = tv.groupprocessuid) as groupprocessname');
        $this->db->select('(SELECT locationname_th FROM queuelocation WHERE queuelocation.uid = tv.queuelocationuid) as locationname');
        $this->db->where('tv.queuelocationuid = ','(SELECT MIN(uid) FROM queuelocation)',FALSE);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('tv');
        return $query->result();
    }

    function get_tv_queuelocation($queuelocationuid)
    {
        $this->db->select('*');
        $this->db->select('(SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = tv.groupprocessuid) as groupprocessname');
        $this->db->select('(SELECT locationname_th FROM queuelocation WHERE queuelocation.locationuid = tv.queuelocationuid) as locationname');
        $this->db->where('tv.queuelocationuid',$queuelocationuid);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('tv');
        return $query->result();
    }

    function get_tv_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('tv');
        return $query->row();
    }

    function add_tv($data){
        $data['cwhen'] = 'NOW()';
        $data['cuser'] = $data['muser'];
        unset($data['cuser']);
        unset($data['muser']);
        if($this->db->where('queuelocationuid',$data['queuelocationuid'])->get('tv')->num_rows() >= 5){
            return false;
        }
        $this->db->reset_query();
        $result = $this->db->insert('tv',$data);
        $tvuid = $this->db->insert_id();
        $this->tv_message_row_update($tvuid);
        return $result;
    }

    function update_tv($data){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('tv');
        $this->db->reset_query();
        if(isset($data['message_row']) && $data['message_row']){
            $this->db->set('qty_row', $data['message_row']);
            $this->db->where('tvuid', $data['uid']);
            $this->db->update('tv_settings');
        }
        $this->tv_message_row_update($data['uid']);
        return $result;
    }

    function del_tv($data){
        $this->db->where('uid',$data['uid']);
        $result = $this->db->delete('tv');
        $this->db->reset_query();
        $this->db->where('tvuid',$data['uid']);
        $this->db->delete('tv_settings');
        return $result;
    }
    
    function tv_message_row_update($tvuid,$muser = NULL){
        $this->db->reset_query();
        $this->db->select('message_qty');
        $this->db->select('(SELECT(count(uid)) FROM tv_settings WHERE tv_settings.tvuid = tv.uid ) as count_column');
        $this->db->from('tv');
        $this->db->where('uid',$tvuid);
        $tv_data = $this->db->get()->row();
        if($tv_data->count_column < $tv_data->message_qty){
            $this->db->reset_query();
            $data['tvuid'] = $tvuid;
            $data['sequence'] = intval($this->db->select('MAX(sequence) as sequence')->from('tv_settings')->where('tvuid',$tvuid)->get()->row()->sequence)+1;
            $data['status'] = intval(1);
            $data['qty'] = intval(1);
            $data['cwhen'] = 'NOW()';
            $data['mwhen'] = 'NOW()';
            $this->db->reset_query();
            $data['qty_row'] = intval($this->db->select('message_row')->from('tv')->where('uid',$tvuid)->get()->row()->message_row);
            $this->db->reset_query();
            $this->db->insert('tv_settings',$data);
            $this->tv_message_row_update($tvuid);
        }else if($tv_data->count_column > $tv_data->message_qty){
            $this->db->reset_query();
            $query = "DELETE FROM tv_settings WHERE uid IN (SELECT uid FROM tv_settings WHERE tvuid = $tvuid ORDER BY uid DESC LIMIT 1) ";
            $this->db->query($query);
            $this->tv_message_row_update($tvuid);
        }else{
            return true;
        }
    }

    function tv_message_data($tvuid)
    {
        $this->db->select('*');
        $this->db->where('tvuid',$tvuid);
        $this->db->order_by('uid','ASC');
        $query = $this->db->get('tv_settings');
        return $query->result();
    }
    
    function update_tv_message($data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('tv_settings');
        return $result;
    }
}
