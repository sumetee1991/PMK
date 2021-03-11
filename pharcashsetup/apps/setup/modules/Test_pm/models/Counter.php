<?php
class Counter extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }
  function get_counter()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_counter');
    return $counter->result();
  }

  function get_clinic_data()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_opdclinic');
    return $counter->result();
  }

  function get_message()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_message');
    return $counter->result();
  }

  function get_queue_category()
  {
    $this->db->order_by('uid', 'desc');
    $counter = $this->db->get('tb_queuecategory');
    return $counter->result();
  }


  function get_queue_category_list($id)
  {

    $this->db->where('groupprocessuid', $id);
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_queuecategory');
    return $counter->result();
  }





  function get_catgory_detail($id)
  {
    $this->db->order_by('uid', 'desc');
    $this->db->where('queuecategoryuid', $id);
    $counter = $this->db->get('tb_queuecategorydetail');
    return $counter->result();
  }

  function get_patient_data()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_patienttype');
    return $counter->result();
  }

  function get_payor_data()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_payor');
    return $counter->result();
  }
  function get_building_data()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_building');
    return $counter->result();
  }

  function get_groupprocess()
  {
    $this->db->order_by('order', 'asc');
    $counter = $this->db->get('tb_groupprocess');
    return $counter->result();
  }

  function add_counter($data)
  {
    $result = $this->db->insert('tb_counter', $data);
    return $result;
  }

  function add_message($data)
  {
    $result = $this->db->insert('tb_message', $data);
    return $result;
  }


  function add_building($data)
  {
    $result = $this->db->insert('tb_building', $data);
    return $result;
  }

  function add_floor($data)
  {
    $result = $this->db->insert('tb_floor', $data);
    return $result;
  }

  function add_clinic($data)
  {
    $result = $this->db->insert('tb_opdclinic', $data);
    return $result;
  }

  function add_payor($data)
  {
    $result = $this->db->insert('tb_payor', $data);
    return $result;
  }


  function add_queue_category($data, $payor_id, $patient_type_data)
  {

    $this->db->trans_start();
    $this->db->insert('tb_queuecategory', $data);
    $this->db->trans_complete();
    $id = $this->db->insert_id();

    /*  $data_detail=array('queuecategoryuid'=>$id,
   'payoruid'=>$payor_id,
   'patienttypeuid'=>$patient_type_data,

);*/


    $payorid = count($_POST['payorid']['payorid']);

    $total_data = array();
    for ($i = 0; $i < $payorid; $i++) {
      $data_detail = array(
        'queuecategoryuid' => $id,
        'payoruid' => $_POST['payorid']['payorid'][$i],
        'patienttypeuid' => $_POST['patient_type_data']['patient_type_data'][$i],
      );
      array_push($total_data, $data_detail);
    }
    $unique_data = array_unique($total_data, SORT_REGULAR);
    foreach ($unique_data as $key => $value) {
      $result = $this->db->insert('tb_queuecategorydetail', $value);
    }
    return $result;
  }


  function add_patient_type($data)
  {
    $result = $this->db->insert('tb_patienttype', $data);
    return $result;
  }

  function add_groupprocess($data)
  {



    $result = $this->db->insert('tb_groupprocess', $data);
    return $result;
  }


  public function get_floor($PROVINCE_ID)
  {
    $query = $this->db->get_where('tb_floor', array('buildinguid' => $PROVINCE_ID));
    $this->db->order_by('uid=', 'desc');
    return $query->result();
  }

  public function get_floor_building($buildinguid)
  {
    $query = $this->db->get_where('tb_floor', array('buildinguid' => $buildinguid));
    $this->db->order_by('uid=', 'desc');
    return $query->result();
  }


  function get_contactno_data()
  {
    $this->db->order_by('order', 'asc');
    $contactno = $this->db->get('tb_groupprocess');
    return $contactno->result();
  }


  function getKioskReport($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_kiosk');
    return $data->result();
  }

  function getVisitReport($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $data = $this->db->get('vw_report_management_visit');
    return $data->result();
  }
  function getNewHNReport($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_management_newhn');
    return $data->result();
  }
  function getRegisterReport($From, $To)
  {

    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_management_payor');
    return $data->result();
  }
}
