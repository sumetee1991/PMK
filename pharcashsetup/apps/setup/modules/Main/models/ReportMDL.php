<?php
class ReportMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getKioskReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('queueno, fullname, cwhen, pharmacyqueueno, worklistdatetime15, processstatus');
        $this->db->select("(CASE WHEN queueno = '0' THEN '' else queueno END) as queueno");
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        if($_POST['queuelocationuid'] != 4){
            $this->db->where("queueno is NOT NULL", NULL, FALSE);
            $this->db->where("queueno::integer <> 0", NULL, FALSE);
        }
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getDrugChargeReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        // $this->db->select('queueno, cwhen,fullname, worklistdatetime14, worklistcreateby14, callcounter6, messagedetail6, messagedetailcreateby6, worklistdatetime15, worklistcreateby15, callbeforedate6, callafterdate6, callby6');
        // $this->db->select('( SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        // $this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 6 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen6');
        // $this->db->select('( SELECT h.createdate FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS worklistdatetime22');
        // $this->db->select('( SELECT h.createby FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS  worklistcreateby22');
        $this->db->select('*');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where("queueno is NOT NULL", NULL, FALSE);
        $this->db->where("queueno::integer <> 0", NULL, FALSE);
        $this->db->where('queuelocationuid', $queuelocationuid);
        //$this->db->where("groupprocessuid", 6);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getMedQueueReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $this->db->select('vnpharmacy, en, hn, fullname, queueno , patientcategoryshortname, pharmacyqueueno, worklistdatetime15, worklistcreateby15, cancelqueuedate, processstatus');
        // $this->db->select('(SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategory');
        $this->db->select("(CASE WHEN patienttype = 'ติดต่อการเงิน' THEN 'Y' ELSE 'N' END) as contact");
        // $this->db->select('(SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        $this->db->select("(CASE WHEN queueno = '0' THEN '' else queueno END) as queueno");
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        // if($_POST['cancelqueuedate'] == null){
        //     $this->db->where("cancelqueuedate is NULL", NULL, TRUE);
        // }
        $this->db->where("pharmacyqueueno is NOT NULL", NULL, FALSE);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getMedQueueReport_count($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('count(worklistdatetime15) as ac_count');
        //   $this->db->select('worklistdatetime15 , cancelqueuedate');
        $this->db->where("cancelqueuedate is NULL", NULL, FALSE);
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $data = $this->db->get('vw_report_overall');
        $res = $data->result();  // this returns an object of all results
        $row = $res[0];
        $data_count = $row->ac_count;
        return $data_count;

        // select count (worklistdatetime15) as ac from vw_report_overall
        // WHERE cancelqueuedate is NULL
        // AND queuelocationuid = $queuelocationuid
        // AND to_char(cwhen::date , 'YYYY-MM-DD') >= $From
        // AND to_char(cwhen::date , 'YYYY-MM-DD') <= $To
        // ";

        // $data['amount'] = $this->db->query($sql_Amount_MedQueue)->result_array();
        // var_dump( $data['amount'] );
        // $data['count_MedQueue'] =  array_sum(array_column($data['amount'], 'data'));
        // return $data;


    }


    function getCashierReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $or_where = NULL;
        // $allcol = ["pharmacyqueueno","worklistdatetime15","worklistdatetime12","worklistcreateby12","callcounter1","messagedetail1","messagedetailcreateby1","worklistdatetime13","worklistcreateby13","worklistdatetime19","worklistcreateby19","callbeforedate1","callafterdate1","callby1"];
        // $this->db->select("pharmacyqueueno , queueno, hn, vnpharmacy, en,fullname, worklistdatetime12, worklistcreateby12, callcounter1, messagedetail1, messagedetailcreateby1, worklistdatetime13, worklistcreateby13, worklistdatetime15, worklistdatetime19, worklistcreateby19 , callbeforedate1, callafterdate1, callby1, cancelqueuedate");
        $this->db->select("(SELECT CASE WHEN creditname IS NULL THEN 'ไม่มีสิทธิ' ELSE creditname END FROM patientdetail pd WHERE pd.uid = vw_report_overall.patientdetailuid) as creditname");
        // $this->db->select("(SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 1 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen1");
        $this->db->select("(CASE WHEN queueno = '0' THEN '' END) as queueno");
        $this->db->where("patienttype = 'ติดต่อการเงิน'");
        $this->db->where("cancelqueuedate is NULL", NULL, TRUE);
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        // foreach($allcol as $col){
        //     $or_where .= ($or_where? " OR ":"") . "$col IS NOT NULL";
        // }
        // $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 1);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getMedicationReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $or_where = NULL;
        // $allcol = ["worklistdatetime15", "worklistdatetime3", "worklistcreateby3"];
        // $this->db->select('pharmacyqueueno , queueno, hn, vnpharmacy, en, fullname, worklistdatetime3, worklistcreateby3, worklistdatetime15, his_druging_finished_date, cancelqueuedate');
        // $this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 3 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1) ) as status');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL", NULL, FALSE);
        $this->db->where("cancelqueuedate is NULL", NULL, TRUE);
        // foreach ($allcol as $col) {
        //     $or_where .= ($or_where ? " OR " : "") . "$col IS NOT NULL";
        // }
        // $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 3);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getCheckMedReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $or_where = NULL;
        // $allcol = ["worklistdatetime15", "worklistdatetime5", "worklistcreateby5"];
        // $this->db->select('pharmacyqueueno , queueno, hn, vnpharmacy, en, fullname, worklistdatetime5, worklistcreateby5 , worklistdatetime15, his_drugchecked_finished_date, cancelqueuedate');
        // $this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 5 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1)) as status');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL", NULL, FALSE);
        $this->db->where("cancelqueuedate is NULL", NULL, TRUE);
        // foreach ($allcol as $col) {
        //     $or_where .= ($or_where ? " OR " : "") . "$col IS NOT NULL";
        // }
        // $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 4);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getDispenseReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $or_where = NULL;
        // $allcol = ["worklistdatetime15", "worklistdatetime16", "worklistdatetime17", "worklistcreateby16", "worklistcreateby17", "callcounter2", "messagedetail2", "messagedetailcreateby2", "worklistdatetime20", "worklistcreateby20", "callbeforedate2", "callafterdate2", "callby2"];
        // $this->db->select('pharmacyqueueno , queueno, hn, vnpharmacy, en, fullname, worklistdatetime16, worklistdatetime17, worklistcreateby16, worklistcreateby17, callcounter2, messagedetail2, messagedetailcreateby2, worklistdatetime20, worklistcreateby20, worklistdatetime15, callbeforedate2, callafterdate2, callby2 ,cancelqueuedate');
        // $this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 2 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen2');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL", NULL, FALSE);
        $this->db->where("cancelqueuedate is NULL", NULL, TRUE);
        // $this->db->where("pharmacyqueueno is NOT NULL", NULL, FALSE);
        // foreach ($allcol as $col) {
        //     $or_where .= ($or_where ? " OR " : "") . "$col IS NOT NULL";
        // }
        // $this->db->where("( $or_where )", NULL, FALSE);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getTotalReport($queuelocationuid, $From, $To)
    {
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('*');
        // $this->db->select('queueno, cwhen,fullname, worklistdatetime14, worklistcreateby14, callcounter6, messagedetail6, messagedetailcreateby6, worklistdatetime15, worklistcreateby15, callbeforedate6, callafterdate6, callby6');
        // $this->db->select('( SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        // $this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 6 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen6');
        // $this->db->select('( SELECT h.createdate FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS worklistdatetime22');
        //$this->db->select('( SELECT h.createby FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS  worklistcreateby22');
        // $this->db->select("( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 1 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen1");
        $this->db->select("( SELECT CASE WHEN creditname IS NULL THEN 'ไม่มีสิทธิ' ELSE creditname END FROM patientdetail pd WHERE pd.uid = vw_report_overall.patientdetailuid) as creditname");
        //$this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 3 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1) ) as medicationstatus');  
        //$this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 5 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1)) as checkmedstatus');
        //$this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 2 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen2');   
        //$this->db->select('(SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategory');
        // $this->db->select('(SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        $this->db->select("(CASE WHEN patienttype = 'ติดต่อการเงิน' THEN 'Y' ELSE 'N' END) as contact");
        $this->db->select("(CASE WHEN queueno = '0' THEN '' else queueno END) as kiosqueueno");
        $this->db->select("(CASE WHEN queueno = '0' THEN '' else queueno END) as medqueueno");

        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid', $queuelocationuid);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }
    
}
