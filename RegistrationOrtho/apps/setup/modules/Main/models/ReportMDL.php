<?php
class ReportMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getKioskReport($queuelocationuid,$From, $To)
    {
      $start_date_now = $From . ' 00:00:00';
      $end_date_now = $To . ' 23:59:59';
      $this->db->select('queueno,fullname,cwhen');
      $this->db->where("cwhen >=", $start_date_now);
      $this->db->where("cwhen <=", $end_date_now);
      $this->db->where("queueno is NOT NULL",NULL,FALSE);
      $this->db->where('queuelocationuid',$queuelocationuid);
      $this->db->order_by('cwhen', 'asc');
      $data = $this->db->get('vw_report_overall');
      return $data->result();
    }

    function getDrugChargeReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('queueno, fullname, worklistdatetime14, worklistcreateby14, callcounter6, messagedetail6, messagedetailcreateby6, worklistdatetime15, worklistcreateby15');
        $this->db->select('( SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        $this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 6 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen6');
        $this->db->select('( SELECT h.createdate FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS worklistdatetime22');
        $this->db->select('( SELECT h.createby FROM vw_processcontrol_report h WHERE h.patientdetailuid = vw_report_overall.patientdetailuid AND h.worklistuid = 22 ORDER BY h.uid DESC LIMIT 1) AS  worklistcreateby22');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where("queueno is NOT NULL",NULL,FALSE);
        $this->db->where("queueno::integer <> 0",NULL,FALSE);
        $this->db->where('queuelocationuid',$queuelocationuid);
        //$this->db->where("groupprocessuid", 6);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getMedQueueReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $this->db->select('en, hn, fullname, pharmacyqueueno, worklistdatetime15, worklistcreateby15');
        $this->db->select('(SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategory');
        $this->db->select("(CASE WHEN patienttype = '???????????????????????????????????????' THEN 'Y' ELSE 'N' END) as contact");
        $this->db->select('(SELECT locationname_th FROM queuelocation ql WHERE ql.locationuid = vw_report_overall.queuelocationuid) as location');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where("pharmacyqueueno is NOT NULL",NULL,FALSE);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getCashierReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $or_where = NULL;
        $allcol = ["worklistdatetime12","worklistcreateby12","callcounter1","messagedetail1","messagedetailcreateby1","worklistdatetime17","worklistcreateby17","worklistdatetime19","worklistcreateby19"];
        $this->db->select("pharmacyqueueno as queueno, fullname, worklistdatetime12, worklistcreateby12, callcounter1, messagedetail1, messagedetailcreateby1, worklistdatetime17, worklistcreateby17, worklistdatetime19, worklistcreateby19");
        $this->db->select("(SELECT CASE WHEN creditname IS NULL THEN '??????????????????????????????' ELSE creditname END FROM patientdetail pd WHERE pd.uid = vw_report_overall.patientdetailuid) as creditname");
        $this->db->select("( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 1 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen1");         
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL",NULL,FALSE);
        foreach($allcol as $col){
            $or_where .= ($or_where? " OR ":"") . "$col IS NOT NULL";
        }
        $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 1);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getMedicationReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $or_where = NULL;
        $allcol = ["worklistdatetime3","worklistcreateby3"];
        $this->db->select('pharmacyqueueno as queueno, fullname, worklistdatetime3, worklistcreateby3');
        $this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 3 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1) ) as status');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL",NULL,FALSE);
        foreach($allcol as $col){
            $or_where .= ($or_where? " OR ":"") . "$col IS NOT NULL";
        }
        $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 3);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getCheckMedReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $or_where = NULL;
        $allcol = ["worklistdatetime5","worklistcreateby5"]; 
        $this->db->select('pharmacyqueueno as queueno, fullname, worklistdatetime5, worklistcreateby5');
        $this->db->select('( SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 5 AND pcc.patientdetailuid = vw_report_overall.patientdetailuid ORDER BY cwhen DESC LIMIT 1)) as status');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL",NULL,FALSE);
        foreach($allcol as $col){
            $or_where .= ($or_where? " OR ":"") . "$col IS NOT NULL";
        }
        $this->db->where("( $or_where )", NULL, FALSE);
        //$this->db->where("groupprocessuid", 4);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }

    function getDispenseReport($queuelocationuid,$From, $To){
        $start_date_now = $From . ' 00:00:00';
        $end_date_now = $To . ' 23:59:59';
        $or_where = NULL;
        $allcol = ["worklistdatetime16","worklistdatetime17","worklistcreateby16","worklistcreateby17","callcounter2","messagedetail2","messagedetailcreateby2","worklistdatetime17","worklistcreateby17","worklistdatetime20","worklistcreateby20"];  
        $this->db->select('pharmacyqueueno as queueno, fullname, worklistdatetime16, worklistdatetime17, worklistcreateby16, worklistcreateby17, callcounter2, messagedetail2, messagedetailcreateby2, worklistdatetime17, worklistcreateby17, worklistdatetime20, worklistcreateby20');
        $this->db->select('( SELECT a.cwhen FROM vw_getmessagedetail_report a WHERE a.patientdetailuid = vw_report_overall.patientdetailuid AND a.groupprocessuid = 2 ORDER BY a.uid DESC LIMIT 1) AS messagecwhen2');
        $this->db->where("cwhen >=", $start_date_now);
        $this->db->where("cwhen <=", $end_date_now);
        $this->db->where('queuelocationuid',$queuelocationuid);
        $this->db->where("pharmacyqueueno is NOT NULL",NULL,FALSE);
        foreach($allcol as $col){
            $or_where .= ($or_where? " OR ":"") . "$col IS NOT NULL";
        }
        $this->db->where("( $or_where )", NULL, FALSE);
        $this->db->order_by('cwhen', 'asc');
        $data = $this->db->get('vw_report_overall');
        return $data->result();
    }
}