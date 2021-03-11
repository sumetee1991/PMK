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
    // $this->db->order_by('order', 'asc');
    // $counter = $this->db->get('tb_opdclinic');
    // return $counter->result();

    $this->db->order_by('uid', 'asc');
    $counter = $this->db->get('tb_walkinlimit');
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

  function get_kiosk_data()
  {
    $this->db->order_by('uid', 'asc');
    $counter = $this->db->get('tb_kiosklocation');
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

  function add_kiosk($data)
  {
    $result = $this->db->insert('tb_kiosklocation', $data);
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

  
  function getKioskReport_spec($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->select('row_number() over (ORDER BY cwhen asc)as rownum',FALSE)
              ->select('cwhen::date as cwhendate',FALSE)
              ->select('cwhen::time(0) as cwhentime',FALSE)
              ->select('idcard')
              ->select('hn')
              ->select('refno')
              ->select("CASE newpatient WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as closequeue",FALSE)
              ->select('patienttypeid')
              ->select('patienttypename')
              ->select('payorid')
              ->select('payorname')
              ->select('worklistgroupname');
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_kiosk');
    return $data->result_array();
  }

  function getVisitReport_spec($From, $To)
  {
    // $start_date_now = $From . ' 00:00:00';
    // $end_date_now = $To . ' 23:59:59';
    // $this->db->select('row_number() over (ORDER BY cwhen asc)as rownum',FALSE)
    //           ->select('cwhen::date as cwhendate',FALSE)
    //           ->select('closewhen::time(0) as closewhentime',FALSE)
    //           ->select('idcard')
    //           ->select('hn')
    //           ->select('refno')
    //           ->select("CASE selectqueue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as selectqueue",FALSE)
    //           ->select("CASE closequeue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as closequeue",FALSE)
    //           ->select('closeuser')
    //           ->select('room_uid')
    //           ->select('room_name')
    //           ->select('building_uid')
    //           ->select('buildingname')
    //           ->select('api_status_name')
    //           ->select("api_status_desc::json->'visitNo' as visitNo",FALSE)
    //           ->select('api_cuser');
    // $this->db->where("cwhen >=", $start_date_now);
    // $this->db->where("cwhen <=", $end_date_now);
    // $data = $this->db->get('vw_report_management_visit');
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->select('row_number() over (ORDER BY cwhen asc)as rownum',FALSE)
              ->select('cwhen')
              ->select('refno')
              ->select('hn')
              ->select('idcard')
              ->select('fullname')
              ->select('patienttypename')
              ->select('payorid')
              ->select('worklistgroupname')
              // ->select('selectqueue_newhn')
              ->select("CASE selectqueue_newhn WHEN TRUE THEN 'ไม่ใช่' ELSE 'ใช่' END as selectqueue_newhn",FALSE)
              ->select('queuetype_newhn')
              ->select('queueno_newhn')
              ->select('first_called_newhn')
              ->select('last_called_newhn')
              ->select('calluser_newhn')

              ->select('callcounter_newhn')

              ->select('hold_when_newhn')
              ->select('hold_message_newhn')
              ->select('hold_user_newhn')
              ->select('closewhen_newhn')
              ->select('closeuser_newhn')
              // ->select('selectqueue_payor')
              ->select("CASE selectqueue_payor WHEN TRUE THEN 'ไม่ใช่' ELSE 'ใช่' END as selectqueue_payor",FALSE)
              ->select('queuetype_payor')
              ->select('queueno_payor')
              ->select('first_called_payor')
              ->select('last_called_payor')
              ->select('calluser_payor')

              ->select('callcounter_payor')

              ->select('hold_when_payor')
              ->select('hold_message_payor')
              ->select('hold_user_payor')
              ->select('closewhen_payor')
              ->select('closeuser_payor');
    // $this->db->distinct('uid');
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    // $this->db->group_by('uid');
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_kiosk_newhn_payor');
    return $data->result_array();
  }
  function getNewHNReport_spec($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->select('row_number() over (ORDER BY cwhen asc)as rownum',FALSE)
              // วันที่
              ->select('cwhen::date as cwhendate',FALSE)
              // เวลา
              ->select('cwhen::time(0) as cwhentime',FALSE)
              // idcard
              ->select('idcard')
              // hn
              ->select('hn')
              // refno
              ->select('refno')
              // ชื่อ นามสกุล fullname
              ->select('fullname')
              // มีขั้นตอนทำประวัติ / เปิดสิทธิ
              // ->select("CASE selectqueue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as selectqueue",FALSE)
              // มีคิวทำประวัติ
              // ->select("CASE queue_exist WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_exist",FALSE)
              // ประเภทคิว
              ->select('queuetype')
              // คิว
              ->select('queueno')
              // ถูกเรียกหรือไม่
              // ->select("CASE queue_called WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_called",FALSE)
              // เวลาเรียกครั้งแรก
              ->select('first_called::time(0) as firstcalledtime',FALSE)
              // เวลาเรียกครั้งสุดท้าย
              ->select('last_called::time(0) as lastcalledtime',FALSE)
              // userที่เรียก
              ->select('calluser')
              // counterที่เรียก
              ->select('callcounter')
              // ถูกholdหรือไม่
              // ->select("CASE queue_hold WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_hold",FALSE)
              // เวลาที่hold
              ->select('hold_when::time(0) as hold_whentime',FALSE)
              // ข้อความhold
              ->select('hold_message')
              // userที่hold
              ->select('hold_user')
              // เสร็จสิ้น
              // ->select("CASE closequeue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as closequeue",FALSE)
              // เวลาเสร็จสิ้น
              ->select('closewhen::time(0) as closewhentime',FALSE)
              // userเสร็จสิ้น
              // ->select('groupprocess');
              ->select('closeuser');

    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    // $this->db->where("selectqueue = TRUE");
    $eee = "2,1";
    $this->db->where("groupprocess =", $eee);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_management_newhn');
    return $data->result_array();
  }
  function getRegisterReport_spec($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->select('row_number() over (ORDER BY cwhen asc)as rownum',FALSE)
              // วันที่
              ->select('cwhen::date as cwhendate',FALSE)
              // เวลา
              ->select('cwhen::time(0) as cwhentime',FALSE)
              // idcard
              ->select('idcard')
              // hn
              ->select('hn')
              // refno
              ->select('refno')
              // มีขั้นตอนเปิดสิทธิ
              // ->select("CASE selectqueue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as selectqueue",FALSE)
              // มีคิวเปิดสิทธิ
              // ->select("CASE queue_exist WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_exist",FALSE)
              // ประเภทคิว
              ->select('queuetype')
              // คิว
              ->select('queueno')
              // ถูกเรียกหรือไม่
              // ->select("CASE queue_called WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_called",FALSE)
              // เวลาเรียกครั้งแรก
              ->select('first_called::time(0) as firstcalledtime',FALSE)
              // เวลาเรียกครั้งสุดท้าย
              ->select('last_called::time(0) as lastcalledtime',FALSE)
              // userที่เรียก
              ->select('calluser')
              // counterที่เรียก
              ->select('callcounter')
              // ถูกholdหรือไม่
              // ->select("CASE queue_hold WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as queue_hold",FALSE)
              // เวลาที่hold
              ->select('hold_when::time(0) as hold_whentime',FALSE)
              // ข้อความhold
              ->select('hold_message')
              // userที่hold
              ->select('hold_user')
              // เสร็จสิ้น
              // ->select("CASE closequeue WHEN TRUE THEN 'ใช่' ELSE 'ไม่ใช่' END as closequeue",FALSE)
              // เวลาเสร็จสิ้น
              ->select('closewhen::time(0) as closewhentime',FALSE)
              // userเสร็จสิ้น
              ->select('closeuser')
              
              ->select('worklistgroupname');

    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);

    // $this->db->where("queuetype =", null);
    
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_management_payor');
    return $data->result_array();
  }

  /*----------------------------------------------------------*/
  function getKioskStat($Date)
  {
    $sql_type = "
    ---- Type
    SELECT count(p.uid) as data, pt.name as labels,code 
    FROM tr_patient p
    LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid 
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    GROUP BY patienttypeid,pt.name,pt.code 
    ORDER BY data ASC;
    ";
    $sql_payor = "
    ---- Payor
    SELECT count(p.uid) as data, py.name as labels ,code 
    FROM tr_patient p
    LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    GROUP BY payorid,py.name,py.code 
    ORDER BY data ASC;
    ";
    $sql_Worklistgroup = "
    ---- Worklistgroup
    SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels,code 
    FROM (
      SELECT 
        CASE
          WHEN (wlg.uid = 2 OR wlg.uid = 5 OR wlg.uid = 6 OR wlg.uid = 7 OR wlg.uid = 9 OR wlg.uid = 10 OR wlg.uid = 12 OR wlg.uid = 15 OR wlg.uid = 16 OR wlg.uid = 17 OR wlg.uid = 19 OR wlg.uid = 20 OR wlg.uid = 21) THEN 'ผู้ป่วยเก่ามีนัด'
          WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8 OR wlg.uid = 11 OR wlg.uid = 14 OR wlg.uid = 18 OR wlg.uid = 22) THEN 'ผู้ป่วยเก่าไม่มีนัด'
          ELSE 'ผู้ป่วยใหม่'
        END as worklistgroupshort,
        CASE
              WHEN (wlg.uid = 2 OR wlg.uid = 5 OR wlg.uid = 6 OR wlg.uid = 7 OR wlg.uid = 9 OR wlg.uid = 10 OR wlg.uid = 12 OR wlg.uid = 15 OR wlg.uid = 16 OR wlg.uid = 17 OR wlg.uid = 19 OR wlg.uid = 20 OR wlg.uid = 21) THEN 'P22'
              WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8 OR wlg.uid = 11 OR wlg.uid = 14 OR wlg.uid = 18 OR wlg.uid = 22) THEN 'P02'
              ELSE 'P03'
            END as code
      FROM tr_patient p
      LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    ) sources
    GROUP BY worklistgroupshort,code 
    ORDER BY data ASC;
    ";

    // ---- Worklistgroup
    // SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels,code 
    // FROM (
    //   SELECT 
    //     CASE
    //       WHEN wlg.uid = 3 THEN 'ผู้ป่วยใหม่'
    //       WHEN (wlg.uid = 13 OR wlg.uid = 10 OR wlg.uid = 2) THEN 'ผู้ป่วยเก่าไม่มีนัด'
    //       ELSE 'ผู้ป่วยเก่ามีนัด'
    //     END as worklistgroupshort,
    //     CASE
    //           WHEN wlg.uid = 3 THEN 'P01'
    //           WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'P02'
    //           ELSE 'P03'
    //         END as code
    //   FROM tr_patient p
    //   LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // ) sources
    // GROUP BY worklistgroupshort,code 
    // ORDER BY data ASC;

    // $sql_Worklistgroup = " 
    //   SELECT count(p.uid) as data, py.worklistgroupname as labels 
    //   FROM tr_patient p
    //   LEFT JOIN tb_worklistgroup py ON py.uid::varchar = p.worklistgroupuid 
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY worklistgroupuid,py.worklistgroupname
    //   ORDER BY data ASC;
    // ";
    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM tr_patient p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY time_range
    ) Amount;
    ";
    
    $data['type'] = $this->db->query($sql_type)->result_array();
    
    $data['count'] =  array_sum(array_column($data['type'], 'data')); 

    $data['payor'] = $this->db->query($sql_payor)->result_array();

    
    $data['worklistgroup'] = $this->db->query($sql_Worklistgroup)->result_array();

    $data['amount'] = $this->db->query($sql_Amount)->result_array();

    return $data;
    // var_dump ($data['worklistgroup']);
  }

  function getVisitStat($Date)
  {
    $sql_type = "
    ---- Type
    -- SELECT count(p.uid) as data  , pt.name as labels
    -- FROM tr_patient p
    -- LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid 
    -- RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    --  AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
    -- WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    -- GROUP BY patienttypeid,pt.name;

    ---- NewType
    SELECT count(sources.labels) as data,sources.labels as labels,code
    FROM (
        SELECT cc.patient_uid as patientuid,pt.name as labels,code
        FROM tb_cliniccount cc
        JOIN tr_patient p ON p.uid = cc.patient_uid 
        LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid
        WHERE patient_uid is NOT NULL AND pt.name is NOT NULL
        AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
        GROUP BY cc.patient_uid,pt.name,code
      UNION
        SELECT p.uid as patientuid,pt.name as labels,code
        FROM tr_patient p
        LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid 
        RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
          AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
        WHERE pt.name is NOT NULL
        AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
        GROUP BY p.uid,pt.name,code
    )sources
    GROUP BY sources.labels,code 
    ORDER BY data ASC;
    ";
    $sql_payor = "
    ---- Payor
    -- SELECT count(p.uid) as data, py.name as labels
    -- FROM tr_patient p
    -- LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
    -- RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    --   AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
    -- WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    -- GROUP BY payorid,py.name;

    ---- NewPayor
    SELECT count(sources.labels) as data,sources.labels as labels,code
    FROM (
      SELECT cc.patient_uid as patientuid,py.name as labels,code
      FROM tb_cliniccount cc
      JOIN tr_patient p ON p.uid = cc.patient_uid 
      LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
        AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE patient_uid is NOT NULL AND py.name is NOT NULL
      AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY cc.patient_uid,py.name,code
      UNION
      SELECT p.uid as patientuid,py.name as labels,code
      FROM tr_patient p
      LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
        AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE py.name is NOT NULL
      AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY p.uid,py.name,code
    )sources
    GROUP BY sources.labels,code 
    ORDER BY data ASC;
    ";
    $sql_Worklistgroup = "
    -- SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels
    -- FROM (
    --   SELECT 
    --     CASE
    --       WHEN wlg.uid = 3 THEN 'ผู้ป่วยใหม่'
    --       WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'ผู้ป่วยเก่าไม่มีนัด'
    --       ELSE 'ผู้ป่วยเก่ามีนัด'
    --     END as worklistgroupshort
    --   FROM tr_patient p
    --   LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
    --   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    --     AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
    --   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    -- ) sources
    -- GROUP BY worklistgroupshort;

    ---- New Worklistgroup
    SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels,code 
    FROM (
      SELECT 
      CASE
        WHEN wlg.uid = 3 THEN 'ผู้ป่วยใหม่'
        WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'ผู้ป่วยเก่าไม่มีนัด'
        ELSE 'ผู้ป่วยเก่ามีนัด'
      END as worklistgroupshort,
      CASE
        WHEN wlg.uid = 3 THEN 'P01' --new
        WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'P02' --old
        ELSE 'P03' --appointment
      END as code
      FROM (
        SELECT cc.patient_uid as uid,p.worklistgroupuid
      FROM tb_cliniccount cc
      JOIN tr_patient p ON p.uid = cc.patient_uid 
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
        AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE patient_uid is NOT NULL 
      AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY cc.patient_uid,p.worklistgroupuid 
      UNION
      SELECT p.uid as uid,p.worklistgroupuid
      FROM tr_patient p
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
      AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY p.uid,p.worklistgroupuid
      ) p
      LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
    ) sources
    GROUP BY worklistgroupshort,code 
    ORDER BY data ASC;
    ";

    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM tr_patient p
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
        AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY time_range
    ) Amount;
    ";
    $sql_AmountWaiting = "
    ---- Amount Waiting
    -- SELECT Amount.count as data,Amount.minute_range as labels FROM (
    --  SELECT ROUND(extract(epoch FROM (pcc.createdate::time - p.cwhen::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc.createdate::time - p.cwhen::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    --  FROM tr_patient p
    --  JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid AND pcc.worklistuid = 11  AND pcc.createdate::date = p.cwhen::date
    --  WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    --  GROUP BY ROUND(extract(epoch FROM (pcc.createdate::time - p.cwhen::time))/(30* 60))
    -- ) Amount;

    ---- New Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที'  as labels FROM (
      SELECT ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
      FROM (
      --   SELECT cc.patient_uid as uid,p.worklistgroupuid,cc.cwhen as finisedtime,p.cwhen as cwhen
      -- FROM tb_cliniccount cc
      -- JOIN tr_patient p ON p.uid = cc.patient_uid 
      -- RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
      --   AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      -- WHERE patient_uid is NOT NULL 
      -- AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      -- GROUP BY cc.patient_uid,p.worklistgroupuid,cc.cwhen,p.cwhen
      -- UNION
      SELECT p.uid as uid,p.worklistgroupuid,pcc.cwhen as finisedtime,p.cwhen as cwhen
      FROM tr_patient p
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
      AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY p.uid,p.worklistgroupuid,pcc.cwhen,p.cwhen
      ) p
      GROUP BY ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))
    ) Amount
    WHERE minute_range is NOT NULL;
    ";
    $sql_ClinicCount = "
    ---- Clinic Count
    -- SELECT opd.clinic_code,opd.detail,count(cc.uid)  as count
    -- FROM tb_cliniccount cc
    -- LEFT JOIN tb_opdclinic opd ON opd.uid = cc.room_uid
    -- WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date' AND clinic_code is NOT NULL
    -- GROUP BY opd.clinic_code,opd.detail,cc.room_uid
    -- ORDER BY count desc;

    ---- New Clinic Count
    SELECT c.code as clinic_code,c.detail,count(c.detail)
    FROM(
      SELECT opd.code,opd.detail
        FROM tb_cliniccount cc
        LEFT JOIN tb_opdclinic opd ON opd.uid = cc.room_uid
        WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date' AND clinic_code is NOT NULL AND patient_uid is NOT NULL
        GROUP BY opd.code,opd.detail,cc.room_uid,cc.patient_uid) c
    GROUP BY c.code,c.detail
    ORDER BY count DESC
    ";
    
    $data['type'] = $this->db->query($sql_type)->result_array();
    $data['count'] =  array_sum(array_column($data['type'], 'data')); 
    $data['payor'] = $this->db->query($sql_payor)->result_array();
    $data['worklistgroup'] = $this->db->query($sql_Worklistgroup)->result_array();
    $data['amount'] = $this->db->query($sql_Amount)->result_array();
    $data['amountwaiting'] = $this->db->query($sql_AmountWaiting)->result_array();
    $data['cliniccount'] = $this->db->query($sql_ClinicCount)->result_array();
    return $data;
  }
  function getNewHNStat($Date)
  {
    // AND pq.groupprocessuid = 2
    // $sql_type = "
    // ---- Type
    // SELECT count(p.uid) as data  , qc.code as labels,code
    // FROM tr_patient p
    // JOIN tr_patientqueue pq ON pq.patientuid = p.uid AND pq.groupprocessuid = 2 
    // JOIN tb_queuecategory qc ON qc.uid = pq.queuecategoryuid
    // JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid AND pcc.createdate::date = p.cwhen::date 
    //     AND pcc.worklistuid = 19 
    // WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // GROUP BY qc.code;
    // ";

    $eee = "2,1";
    $sql_type = "
      SELECT count(uid) as data
      FROM vw_report_management_newhn
      WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND groupprocess = '$eee'
    ";

    $sql_type1 = "
      SELECT Amount.count as data,Amount.date_trunc as labels FROM (
        SELECT count(p.uid) as count,
            (CASE WHEN(p.queuetype) is not null  then 
                     (p.queuetype) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc 
                     FROM vw_report_management_newhn p
                     WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
                     AND p.groupprocess = '$eee'
                     GROUP BY p.queuetype) Amount;
    ";

    

    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM vw_report_management_newhn p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND groupprocess = '$eee'
      GROUP BY time_range
    ) Amount;
    ";

    // $sql_Amount = "
    // ---- Amount
    // SELECT Amount.count as data,Amount.time_range as labels FROM (
    //   SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
    //   FROM tr_patient p
    //   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    //     AND pcc.worklistuid = 19 AND pcc.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY time_range
    // ) Amount;
    // ";

    // $sql_AmountWaiting = "
    // ---- Amount Waiting
    //   SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //     SELECT ROUND(extract(epoch FROM 
    //     (p.closewhen::time - p.cwhen::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count

        


    //     FROM vw_report_management_newhn p
    //     WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //     AND groupprocess = '$eee'
    //     GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    //   ) Amount;
    // ";

    $sql_AmountWaiting = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
      SELECT count(p.uid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลเวลาเสร็จสิ้น' END)  as minute_range 
      FROM vw_report_management_newhn p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND groupprocess = '$eee'
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";

    // $sql_AmountWaiting = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 19  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 12  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))
    // ) Amount;
    // ";
    
    $data['type'] = $this->db->query($sql_type1)->result_array();

    $data['type1'] = $this->db->query($sql_type)->result_array();
    $data['count'] =  array_sum(array_column($data['type1'], 'data')); 

    $data['amount'] = $this->db->query($sql_Amount)->result_array();
    $data['amountwaiting'] = $this->db->query($sql_AmountWaiting)->result_array();
    return $data;
  }
  function getRegisterStat($Date)
  {
    // $sql_type = "
    // ---- Type
    // SELECT count(p.uid) as data  , qc.code as labels,code
    // FROM tr_patient p
    // JOIN tr_patientqueue pq ON pq.patientuid = p.uid AND pq.groupprocessuid = 2
    // JOIN tb_queuecategory qc ON qc.uid = pq.queuecategoryuid
    // JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid AND pcc.createdate::date = p.cwhen::date 
    //     AND pcc.worklistuid = 9 
    // WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // GROUP BY qc.code;
    // ";

    $sql_type = "
      SELECT count(uid) as data
      FROM vw_report_management_payor
      WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
    ";

    $sql_type1 = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.date_trunc as labels FROM (
      SELECT count(p.uid) as count,
          (CASE WHEN(p.queuetype) is not null  then 
                   (p.queuetype) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc 
                   FROM vw_report_management_payor p
                   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
                   GROUP BY p.queuetype) Amount;
    ";

    


    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM vw_report_management_payor p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY time_range
    ) Amount;
    ";

    // $sql_Amount = "
    // ---- Amount
    // SELECT Amount.count as data,Amount.time_range as labels FROM (
    //   SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
    //   FROM tr_patient p
    //   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    //     AND pcc.worklistuid = 9 AND pcc.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY time_range
    // ) Amount;
    // ";

    $sql_AmountWaiting_New = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
      SELECT count(p.uid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลเวลาเสร็จสิ้น' END)  as minute_range 
      FROM vw_report_management_payor p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND worklistgroupuid IN ('3', '13', '23')
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";

    $sql_AmountWaiting_Old = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
      SELECT count(p.uid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลเวลาเสร็จสิ้น' END)  as minute_range 
      FROM vw_report_management_payor p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND worklistgroupuid IN ('2', '12', '15', '16', '17', '19', '20', '21', '10', '9', '7', '6', '5')
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";

    $sql_AmountWaiting_Appointment = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
      SELECT count(p.uid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลเวลาเสร็จสิ้น' END)  as minute_range 
      FROM vw_report_management_payor p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND worklistgroupuid IN ('1', '11', '14', '18', '22', '8', '4')
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";


    // $sql_AmountWaiting_New = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END)))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM vw_report_management_payor p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid = 3
    //   LEFT JOIN tr_processcontrol pcc_visit ON pcc_visit.patientuid = p.uid AND pcc_visit.worklistuid = 11  AND pcc_visit.createdate::date = p.cwhen::date
    //   LEFT JOIN tr_processcontrol pcc_newhn ON pcc_newhn.patientuid = p.uid AND pcc_newhn.worklistuid = 10  AND pcc_newhn.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 7  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END)))/(30* 60))
    // ) Amount
    // ";

    // $sql_AmountWaiting_New = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END)))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid = 3
    //   LEFT JOIN tr_processcontrol pcc_visit ON pcc_visit.patientuid = p.uid AND pcc_visit.worklistuid = 11  AND pcc_visit.createdate::date = p.cwhen::date
    //   LEFT JOIN tr_processcontrol pcc_newhn ON pcc_newhn.patientuid = p.uid AND pcc_newhn.worklistuid = 10  AND pcc_newhn.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 7  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time WHEN pcc_visit.createdate IS NOT NULL THEN pcc_visit.createdate::time ELSE pcc_s.createdate::time END)))/(30* 60))
    // ) Amount
    // ";


    // $sql_AmountWaiting_Old = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8)
    //   LEFT JOIN tr_processcontrol pcc_newhn ON pcc_newhn.patientuid = p.uid AND pcc_newhn.worklistuid = 11  AND pcc_newhn.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 9  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))
    // ) Amount;
    // ";
    // $sql_AmountWaiting_Appointment = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid != 3 AND wlg.uid != 1 AND wlg.uid != 4 AND wlg.uid != 8
    //   LEFT JOIN tr_processcontrol pcc_newhn ON pcc_newhn.patientuid = p.uid AND pcc_newhn.worklistuid = 11  AND pcc_newhn.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 9  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - (CASE WHEN pcc_newhn.createdate IS NOT NULL THEN pcc_newhn.createdate::time ELSE pcc_s.createdate::time END) ))/(30* 60))
    // ) Amount;
    // ";
    
    $data['type'] = $this->db->query($sql_type1)->result_array();


    $data['type1'] = $this->db->query($sql_type)->result_array();
    $data['count'] =  array_sum(array_column($data['type1'], 'data')); 

    $data['amount'] = $this->db->query($sql_Amount)->result_array();


    $data['amountwaiting_new'] = $this->db->query($sql_AmountWaiting_New)->result_array();
    $data['amountwaiting_old'] = $this->db->query($sql_AmountWaiting_Old)->result_array();
    $data['amountwaiting_appointment'] = $this->db->query($sql_AmountWaiting_Appointment)->result_array();
    return $data;
  }

}
