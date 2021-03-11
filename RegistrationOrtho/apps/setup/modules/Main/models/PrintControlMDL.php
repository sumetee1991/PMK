<?php
class PrintControlMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($data = NULL)
    {
        $this->db->select('*');
        $this->db->select(' (SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = printcontrol.groupprocessuid) as groupprocessdesc');
        if($data){
            $this->db->where($data);
        }
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('printcontrol');
        return $query->result();
    }

    function get_by_groupprocess($groupprocessuid)
    {
        $this->db->select('*');
        $this->db->select(' (SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = printcontrol.groupprocessuid) as groupprocessdesc');
        $this->db->where('groupprocessuid', $groupprocessuid);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('printcontrol');
        return $query->result();
    }

    function get_row($uid)
    {
        $this->db->select('*');
        $this->db->select(' (SELECT groupprocessdesc FROM groupprocess WHERE groupprocess.uid = printcontrol.groupprocessuid) as groupprocessdesc');
        $this->db->where('uid', $uid);
        $this->db->order_by('uid', 'asc');
        $query = $this->db->get('printcontrol');
        return $query->row();
    }

    function add($data){
        $sql = "
        INSERT INTO printcontrol(purpose,printcontroldesc,groupprocessuid,queuelocationuid)
        VALUES
            (1,'สำหรับผู้ปวย',{$data['groupprocessuid']},{$data['queuelocationuid']}),
            (2,'สำหรับเจ้าหน้าที่',{$data['groupprocessuid']},{$data['queuelocationuid']})
        ";
        $query = $this->db->query($sql);
    }

    function update($uid,$data){
        $data['mwhen'] = 'NOW()';
        unset($data['muser']);
        $this->db->set($data, FALSE);
        $this->db->where('uid', $uid);
        $result = $this->db->update('printcontrol');
        return $result;
    }

    function delete($data){
        $result = $this->db->delete('printcontrol',$data);
        return $result;
    }
}
