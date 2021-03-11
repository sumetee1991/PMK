<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MDL_worklist extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->libraries('database');
    }

    public function process($worklistgroupuid){
        $this->db->select('*')
            ->from('vw_worklistprocess vwlp')
            ->where('vwlp.worklistgroup',$worklistgroupuid)
            ->order_by('worklistgroup')
            ->order_by('worklistuid');
        $query = $this->db->get();
        return $query;
    }

    public function process_clear($patientuid){
        $this->db->select('*')
            ->from('vw_process_sv_clear')
            ->where('patientuid',$patientuid);
        $query = $this->db->get();
        return $query;
    }
}
/*
    //Create
    -- View: public.vw_process_sv_clear

    -- DROP VIEW public.vw_process_sv_clear;

    CREATE OR REPLACE VIEW public.vw_process_sv_clear AS
    SELECT DISTINCT c.uid AS patientuid,
        c.clinicname,
        c.refno,
        b.allcounter,
        c.cwhen AS patient_cwhen,
        a.cwhen,
        b.worklistuid,
        b.groupprocessuid,
        ( SELECT tr_patientqueue.queueno
            FROM tr_patientqueue
            WHERE tr_patientqueue.patientuid = a.patientuid AND tr_patientqueue.groupprocessuid = max(b.groupprocessuid)
            LIMIT 1) AS queueno,
        a.call_location,
        b.worklistgroup,
        b.worklistgroupname,
        b.processname,
        b.flowname,
        c.prename,
        c.forename,
        c.surname,
        c.idcard,
        c.hn,
        c.dob AS birthdate,
            CASE
                WHEN b.worklistuid = 1 THEN 1
                ELSE NULL::integer
            END AS closeselectone,
            CASE
                WHEN b.worklistuid = 2 THEN ( SELECT pcc.createdate
                FROM tr_processcontrol pcc
                WHERE pcc.patientuid = a.patientuid AND pcc.worklistuid = 11
                LIMIT 1)
                ELSE NULL::timestamp with time zone
            END AS closevs,
            CASE
                WHEN b.worklistuid = 3 THEN ( SELECT pcc.createdate
                FROM tr_processcontrol pcc
                WHERE pcc.patientuid = a.patientuid AND pcc.worklistuid = 10
                LIMIT 1)
                ELSE NULL::timestamp with time zone
            END AS closenewhn,
            CASE
                WHEN b.worklistuid = 5 THEN ( SELECT pcc.createdate
                FROM tr_processcontrol pcc
                WHERE pcc.patientuid = a.patientuid AND pcc.worklistuid = 9
                LIMIT 1)
                ELSE NULL::timestamp with time zone
            END AS closepayor,
            CASE
                WHEN b.worklistuid = 3 THEN ( SELECT count(*) AS count
                FROM vw_patientqueue pp
                WHERE pp.active::text = 'Y'::text AND pp.cwhen <= a.cwhen AND pp.groupprocessuid = 1 AND (( SELECT tr_patientqueue.queuecategoryuid
                        FROM tr_patientqueue
                        WHERE tr_patientqueue.patientuid = a.patientuid AND tr_patientqueue.groupprocessuid = 1
                        LIMIT 1)) = pp.queuecategoryuid AND pp.closqueue_registerhn IS NULL AND pp.callnewhn IS NULL AND pp.cancelqueue_registerhn IS NULL)
                ELSE NULL::bigint
            END AS count_patient_newhn,
            CASE
                WHEN b.worklistuid = 5 THEN ( SELECT count(*) AS count
                FROM vw_patientqueue pp
                WHERE pp.groupprocessuid = 2 AND (( SELECT tr_patientqueue.queuecategoryuid
                        FROM tr_patientqueue
                        WHERE tr_patientqueue.patientuid = a.patientuid AND tr_patientqueue.groupprocessuid = 2
                        LIMIT 1)) = pp.queuecategoryuid AND pp.active::text = 'Y'::text AND pp.cwhen <= a.cwhen AND pp.closqueue_register IS NULL AND pp.callqueue IS NULL AND pp.cancelqueue_register IS NULL)
                ELSE NULL::bigint
            END AS count_patient_payor,
            CASE
                WHEN b.worklistuid = 5 THEN ( SELECT pcc.createdate
                FROM tr_processcontrol pcc
                WHERE pcc.patientuid = a.patientuid AND pcc.worklistuid = 14)
                ELSE NULL::timestamp with time zone
            END AS cancelregister,
            CASE
                WHEN b.worklistuid = 3 THEN ( SELECT pcc.createdate
                FROM tr_processcontrol pcc
                WHERE pcc.patientuid = a.patientuid AND pcc.worklistuid = 15)
                ELSE NULL::timestamp with time zone
            END AS cancelnewhn,
        b.tltle AS title
    FROM vw_worklistprocess b
        LEFT JOIN tr_patient c ON c.worklistgroupuid = b.worklistgroup
        LEFT JOIN tr_patientqueue a ON c.uid = a.patientuid
    GROUP BY a.patientuid, a.cwhen, a.groupprocessuid, a.call_location, b.worklistuid, b.tltle, b.allcounter, b.groupprocessuid, b.worklistgroup, b.worklistgroupname, b.processname, b.flowname, c.uid
    ORDER BY b.worklistuid;

    ALTER TABLE public.vw_process_sv_clear
        OWNER TO postgres;
    COMMENT ON VIEW public.vw_process_sv_clear
        IS 'For Reprint
    using in ProcessServiceClear';


*/