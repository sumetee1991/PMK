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
    // $closeuser = "11";
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->where("selectqueue = true" );
    // $this->db->where("closeuser =", null);
    $data = $this->db->get('vw_report_management_visit');
    return $data->result();
  }

  function getMedQueueReport_count($From, $To)
  {

      $start_date_now = $From . ' 00:00:00';
      $end_date_now = $To . ' 23:59:59';
      $this->db->select('count(uid) as ac_count');
      $this->db->where("cwhen >=", $start_date_now);
      $this->db->where("cwhen <=", $end_date_now);
      $this->db->where("selectqueue = true" );
      $data = $this->db->get('vw_report_management_visit');
      $res = $data->result(); 
      $row = $res[0];
      $data_count = $row->ac_count;
      return $data_count;
  }

  function getNewHNReport($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->where("selectqueue = true" );
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
    $this->db->where("queue_exist = true" );
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_management_payor');
    return $data->result();
  }
  function getReportAll($From, $To)
  {
    $start_date_now = $From . ' 00:00:00';
    $end_date_now = $To . ' 23:59:59';
    $this->db->where("cwhen >=", $start_date_now);
    $this->db->where("cwhen <=", $end_date_now);
    $this->db->order_by('cwhen', 'asc');
    $data = $this->db->get('vw_report_kiosk_visit_newhn_payor');
    return $data->result();
  }
  /*----------------------------------------------------------*/
  function getKioskStat($Date)
  {
    $sql_type = "
    ---- Type
    SELECT count(p.uid) as data, pt.name as labels
    FROM tr_patient p
    LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid 
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    GROUP BY patienttypeid,pt.name;
    ";
    $sql_payor = "
    ---- Payor
    SELECT count(p.uid) as data, py.name as labels
    FROM tr_patient p
    LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    GROUP BY payorid,py.name;
    ";
    $sql_Worklistgroup = "
    ---- Worklistgroup
    SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels
    FROM (
      SELECT 
        CASE
          WHEN wlg.uid = 3 THEN 'ผู้ป่วยใหม่'
          WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'ผู้ป่วยเก่าไม่มีนัด'
          ELSE 'ผู้ป่วยเก่ามีนัด'
        END as worklistgroupshort
      FROM tr_patient p
      LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    ) sources
    GROUP BY worklistgroupshort;
    ";
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
    SELECT count(sources.labels) as data,sources.labels as labels
    FROM (
        SELECT cc.patient_uid as patientuid,pt.name as labels
        FROM tb_cliniccount cc
        JOIN tr_patient p ON p.uid = cc.patient_uid 
        LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid
        WHERE patient_uid is NOT NULL AND pt.name is NOT NULL
        AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
        GROUP BY cc.patient_uid,pt.name
      UNION
        SELECT p.uid as patientuid,pt.name as labels
        FROM tr_patient p
        LEFT JOIN tb_patienttype pt ON pt.uid::varchar = p.patienttypeid 
        RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
          AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
        WHERE pt.name is NOT NULL
        AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
        GROUP BY p.uid,pt.name
    )sources
    GROUP BY sources.labels;
    ";

    $sql_type1 = "
    SELECT count(sources.labels) as data,sources.labels as labels
    FROM (
      SELECT p.patientypename as labels
          FROM vw_report_management_visit p
          WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
          AND selectqueue = true
      )sources
    GROUP BY sources.labels;
    ";

    $sql_type2 = "
      SELECT count(p.patientuid) as data, p.patientuid as labels
          FROM vw_report_management_visit p
          WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
          AND selectqueue = true
          GROUP BY p.patientuid,p.patientuid;
    ";

    $sql_payor = "
    SELECT count(sources.labels) as data,sources.labels as labels
    FROM (
      SELECT p.payorname as labels
          FROM vw_report_management_visit p
          WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
          AND selectqueue = true
      )sources
    GROUP BY sources.labels;
    ";

    // $sql_payor = "
    // ---- Payor
    // -- SELECT count(p.uid) as data, py.name as labels
    // -- FROM tr_patient p
    // -- LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
    // -- RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    // --   AND pcc.worklistuid = 11 AND pcc.createdate::date = p.cwhen::date
    // -- WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // -- GROUP BY payorid,py.name;

    // ---- NewPayor
    // SELECT count(sources.labels) as data,sources.labels as labels
    // FROM (
    //   SELECT cc.patient_uid as patientuid,py.name as labels
    //   FROM tb_cliniccount cc
    //   JOIN tr_patient p ON p.uid = cc.patient_uid 
    //   LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid
    //   WHERE patient_uid is NOT NULL AND py.name is NOT NULL
    //   AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY cc.patient_uid,py.name
    //   UNION
    //   SELECT p.uid as patientuid,py.name as labels
    //   FROM tr_patient p
    //   LEFT JOIN tb_payor py ON py.uid::varchar = p.payorid 
    //   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    //     AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
    //   WHERE py.name is NOT NULL
    //   AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY p.uid,py.name
    // )sources
    // GROUP BY sources.labels;
    // ";
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
    --     AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
    --   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    -- ) sources
    -- GROUP BY worklistgroupshort;

    ---- New Worklistgroup
    SELECT count(sources.worklistgroupshort) as data , sources.worklistgroupshort as labels
    FROM (
      SELECT 
      CASE
        WHEN wlg.uid = 3 THEN 'ผู้ป่วยใหม่'
        WHEN (wlg.uid = 1 OR wlg.uid = 4 OR wlg.uid = 8) THEN 'ผู้ป่วยเก่าไม่มีนัด'
        ELSE 'ผู้ป่วยเก่ามีนัด'
      END as worklistgroupshort
      FROM (
        SELECT cc.patient_uid as uid,p.worklistgroupuid
      FROM tb_cliniccount cc
      JOIN tr_patient p ON p.uid = cc.patient_uid 
      WHERE patient_uid is NOT NULL 
      AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY cc.patient_uid,p.worklistgroupuid
      UNION
      SELECT p.uid as uid,p.worklistgroupuid
      FROM tr_patient p
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
      AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY p.uid,p.worklistgroupuid
      ) p
      LEFT JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid 
    ) sources
    GROUP BY worklistgroupshort;
    ";

    // $sql_Amount = "
    // ---- Amount
    // SELECT Amount.count as data,Amount.time_range as labels FROM (
    //   SELECT count(p.uid) as count,
    //   (case when
    //   date_trunc('hour', p.closewhen::time) || '-' || date_trunc('hour', p.closewhen::time + interval '1 hour') is not null  then
    //   date_trunc('hour', p.closewhen::time) || '-' || date_trunc('hour', p.closewhen::time + interval '1 hour') else 'ไม่มีข้อมูลเวลาเสร็จสิ้น' END)
    //   as time_range
    //   FROM tr_patient p
    //   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    //     AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
    //   WHERE to_char( p.closewhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY time_range
    // ) Amount;
    // ";

    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT count(patientuid) as count,

      CASE
      WHEN (closewhen IS NOT NULL)
        THEN date_trunc('hour', closewhen::time) || '-' || date_trunc('hour', closewhen::time + interval '1 hour')
      WHEN (closewhen IS NULL)
        THEN 'ไม่มีข้อมูลเวลา'
      END AS time_range

      

      FROM vw_report_management_visit p
      WHERE to_char( closewhen::date , 'DD/MM/YYYY') = '$Date'
      AND selectqueue = true
      GROUP BY time_range
    ) Amount;
    ";

    // $sql_Amount = "
    // ---- Amount
    // SELECT Amount.count as data,Amount.time_range as labels FROM (
    //   SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
    //   FROM tr_patient p
    //   RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
    //     AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    //   GROUP BY time_range
    // ) Amount;
    // ";

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
    SELECT Amount.count as data,Amount.minute_range as labels FROM (
      SELECT ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
      FROM (
        SELECT cc.patient_uid as uid,p.worklistgroupuid,cc.cwhen as finisedtime,p.cwhen as cwhen
      FROM tb_cliniccount cc
      JOIN tr_patient p ON p.uid = cc.patient_uid 
      WHERE patient_uid is NOT NULL 
      AND to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY cc.patient_uid,p.worklistgroupuid,cc.cwhen,p.cwhen
      UNION
      SELECT p.uid as uid,p.worklistgroupuid,pcc.cwhen as finisedtime,p.cwhen as cwhen
      FROM tr_patient p
      RIGHT JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid 
      AND pcc.worklistuid = 2 AND pcc.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      GROUP BY p.uid,p.worklistgroupuid,pcc.cwhen,p.cwhen
      ) p
      GROUP BY ROUND(extract(epoch FROM (p.finisedtime::time - p.cwhen::time))/(30* 60))
    ) Amount
    WHERE minute_range is NOT NULL;
    ";

    $sql_AmountWaiting1 = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
      SELECT count(p.patientuid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลเวลาสแกนคิว' END)  as minute_range 
      FROM vw_report_management_visit p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND selectqueue = true
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";
    $sql_ClinicCount = "
    ---- Clinic Count
    SELECT opd.clinic_code,opd.detail,count(cc.uid)  as count
    FROM tb_cliniccount cc
    LEFT JOIN tb_opdclinic opd ON opd.uid = cc.room_uid
    WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date' AND clinic_code is NOT NULL
    GROUP BY opd.clinic_code,opd.detail,cc.room_uid
    ORDER BY count desc;
    ";
    
    $data['type'] = $this->db->query($sql_type1)->result_array();

    $data['type2'] = $this->db->query($sql_type2)->result_array();
    $data['count'] =  array_sum(array_column($data['type2'], 'data')); 

    $data['payor'] = $this->db->query($sql_payor)->result_array();
    $data['worklistgroup'] = $this->db->query($sql_Worklistgroup)->result_array();
    $data['amount'] = $this->db->query($sql_Amount)->result_array();
    $data['amountwaiting'] = $this->db->query($sql_AmountWaiting1)->result_array();
    $data['cliniccount'] = $this->db->query($sql_ClinicCount)->result_array();
    return $data;
  }
  function getNewHNStat($Date)
  {
    $sql_type = "
    ---- Type
    SELECT count(p.uid) as data  , qc.code as labels
    FROM tr_patient p
    JOIN tr_patientqueue pq ON pq.patientuid = p.uid AND pq.groupprocessuid = 1
    JOIN tb_queuecategory qc ON qc.uid = pq.queuecategoryuid
    JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid AND pcc.createdate::date = p.cwhen::date 
        AND pcc.worklistuid = 2 
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    GROUP BY qc.code;
    ";
    $sql_Amount1 = "
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
    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM vw_report_management_newhn p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND selectqueue = true
      GROUP BY time_range
    ) Amount;
    ";
    $sql_AmountWaiting = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range as labels FROM (
      SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
      FROM tr_patient p
      JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 3  AND pcc_s.createdate::date = p.cwhen::date
      JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 10  AND pcc_e.createdate::date = p.cwhen::date
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
      GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))
    ) Amount;
    ";

    $sql_AmountWaiting1 = "
    ---- Amount Waiting
    SELECT Amount.count as data,Amount.minute_range as labels FROM (
      SELECT count(p.uid) as count , (case when 
      (ROUND(extract(epoch FROM 
      (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10) is not null  then 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*10 || '-' || 
      (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*10)  else 'ไม่มี วันที่-เวลา เสร็จสิ้น' END)  as minute_range 
      FROM vw_report_management_newhn p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
      AND selectqueue = true
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";

    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM vw_report_management_newhn p
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   AND selectqueue = true
    //   GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    // ) Amount;
    
    $data['type'] = $this->db->query($sql_type)->result_array();
    $data['count'] =  array_sum(array_column($data['type'], 'data')); 
    $data['amount'] = $this->db->query($sql_Amount)->result_array();
    $data['amountwaiting'] = $this->db->query($sql_AmountWaiting1)->result_array();
    return $data;
  }
  function getRegisterStat($Date)
  {
    // $sql_type = "
    // ---- Type
    // SELECT count(p.uid) as data  , qc.code as labels
    // FROM tr_patient p
    // JOIN tr_patientqueue pq ON pq.patientuid = p.uid AND pq.groupprocessuid = 2
    // JOIN tb_queuecategory qc ON qc.uid = pq.queuecategoryuid
    // JOIN tr_processcontrol pcc ON pcc.patientuid = p.uid AND pcc.createdate::date = p.cwhen::date 
    //     AND pcc.worklistuid = 9 
    // WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // GROUP BY qc.code;
    // ";

    // $sql_type = "
    // ---- Type
    // SELECT count(p.uid) as data  , qc.code as labels
    // FROM vw_report_management_payor p
    // JOIN tr_patientqueue pq ON pq.patientuid = p.uid AND pq.groupprocessuid = 2
    // JOIN tb_queuecategory qc ON qc.uid = pq.queuecategoryuid
    // WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    // GROUP BY qc.code;
    // ";

    $sql_type = "
    ---- Type
    SELECT count(p.uid) as data  , p.queuetype as labels
    FROM vw_report_management_payor p
    WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
    AND queue_exist = true
    GROUP BY p.queuetype;
    ";

    $sql_Amount = "
    ---- Amount
    SELECT Amount.count as data,Amount.time_range as labels FROM (
      SELECT date_trunc('hour', p.cwhen::time) || '-' || date_trunc('hour', p.cwhen::time + interval '1 hour') as time_range,count(p.uid) as count
      FROM vw_report_management_payor p
      WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date'
      AND queue_exist = true
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

    // $sql_AmountWaiting_New = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid = 3
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 9  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))
    // ) Amount;
    // ";
    // $sql_AmountWaiting_Old = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid != 3
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 9  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))
    // ) Amount;
    // ";
    // $sql_AmountWaiting_Appointment = "
    // ---- Amount Waiting
    // SELECT Amount.count as data,Amount.minute_range as labels FROM (
    //   SELECT ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))*30 || '-' || (ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))+1)*30 as minute_range , count(p.uid) as count
    //   FROM tr_patient p
    //   JOIN tb_worklistgroup wlg ON wlg.uid = p.worklistgroupuid AND wlg.uid != 1 AND wlg.uid != 4 AND wlg.uid != 8
    //   JOIN tr_processcontrol pcc_s ON pcc_s.patientuid = p.uid AND pcc_s.worklistuid = 5  AND pcc_s.createdate::date = p.cwhen::date
    //   JOIN tr_processcontrol pcc_e ON pcc_e.patientuid = p.uid AND pcc_e.worklistuid = 9  AND pcc_e.createdate::date = p.cwhen::date
    //   WHERE to_char( p.cwhen::date , 'DD/MM/YYYY') = '$Date' 
    //   GROUP BY ROUND(extract(epoch FROM (pcc_e.createdate::time - pcc_s.createdate::time))/(30* 60))
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
      AND queue_exist = true
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
      AND worklistgroupuid IN ('2', '12', '15', '16', '17', '19', '20', '21', '10', '9', '7', '6', '5' )
      AND queue_exist = true
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
      AND queue_exist = true
      GROUP BY ROUND(extract(epoch FROM (p.closewhen::time - p.cwhen::time))/(30* 60))
    ) Amount;
    ";
    
    $data['type'] = $this->db->query($sql_type)->result_array();
    $data['count'] =  array_sum(array_column($data['type'], 'data')); 
    $data['amount'] = $this->db->query($sql_Amount)->result_array();
    $data['amountwaiting_new'] = $this->db->query($sql_AmountWaiting_New)->result_array();
    $data['amountwaiting_old'] = $this->db->query($sql_AmountWaiting_Old)->result_array();
    $data['amountwaiting_appointment'] = $this->db->query($sql_AmountWaiting_Appointment)->result_array();
    return $data;
  }

}
