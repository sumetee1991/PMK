<?php
class TicketMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_ticket()
    {
        $this->db->select('*');
        $this->db->select("(SELECT ticket_message.uid FROM ticket_message WHERE ticket_message.ticket_uid = ticket.uid) as messageuid");
        $this->db->order_by('sequence', 'desc');
        $query = $this->db->get('ticket');
        return $query->result();
    }

    function get_ticket_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('ticket');
        return $query->row();
    }

    function get_ticket_message_row($uid)
    {
        $this->db->select('*');
        $this->db->where('uid',$uid);
        $query = $this->db->get('ticket_message');
        return $query->row();
    }

    function get_ticket_message_queuelocation($queuelocationuid,$purpose = 1)
    {
        $this->db->select('*');
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->where('purpose',$purpose);
        $query = $this->db->get('ticket_message');
        return $query->row();
    }

    function add_ticket($data){
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('ticket',$data);
        return $result;
    }

    function update_ticket($data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('ticket');
        return $result;
    }

    function del_ticket($data){
        $result = $this->db->delete('ticket',$data);
        return $result;
    }

    function add_ticket_message($data){
        $data['cuser'] = $data['muser'];
        $result = $this->db->insert('ticket_message',$data);
        return $result;
    }

    function update_ticket_message($data){
        $data['mwhen'] = 'NOW()';
        $this->db->set($data, FALSE);
        $this->db->where('uid', $data['uid']);
        $result = $this->db->update('ticket_message');
        return $result;
    }
}
