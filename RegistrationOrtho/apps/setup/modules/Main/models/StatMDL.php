<?php
class StatMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getKioskStat($queuelocationuid,$Date)
    {
        $sql_Amount = "
        ---- Amount
        SELECT count(queueno) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE queueno is NOT NULL AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";
        
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }

    function getDrugChargeStat($queuelocationuid,$Date)
    {
        $sql_AmountWaiting = "
        ---- Amount Waiting 
        -- 2 -> 15
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
            SELECT ROUND(extract(epoch FROM (worklistdatetime15::time - cwhen::time))/(30* 60))*5 || '-' || (ROUND(extract(epoch FROM (worklistdatetime15::time - cwhen::time))/(30* 60))+1)*5 as minute_range , count(worklistdatetime15) as count
            FROM vw_report_overall
            WHERE worklistdatetime15 is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (worklistdatetime15::time - cwhen::time))/(30* 60))
        ) Amount;
        ";
        
        $sql_Amount = "
        ---- Amount 
        SELECT count(worklistdatetime15) as data,date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE worklistdatetime15 is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $sql_Type = "
        ---- Type
        SELECT count(worklistdatetime15) as data,patienttype as labels
        FROM vw_report_overall
        WHERE worklistdatetime15 is NOT NULL AND patienttype is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $sql_Queuecatee = "
        ---- CateType
        SELECT count(worklistdatetime15) as data,(SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as labels
        FROM vw_report_overall
        WHERE worklistdatetime15 is NOT NULL AND patienttype is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['type'] = $this->db->query($sql_Type)->result_array();
        $data['queuecate'] = $this->db->query($sql_Queuecatee)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }

    function getMedQueueStat($queuelocationuid,$Date)
    {
    }

    function getCashierStat($queuelocationuid,$Date)
    {
        $sql_Queuecatee = "
        ---- CateType
        SELECT count(worklistdatetime17) as data,(SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as labels
        FROM vw_report_overall
        WHERE worklistdatetime17 is NOT NULL AND patienttype is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";

        $sql_Credit = "
        ---- Credit
        SELECT count(worklistdatetime17) as data,(SELECT CASE WHEN creditname IS NULL THEN 'ไม่มีสิทธิ' ELSE creditname END FROM patientdetail pd WHERE pd.uid = vw_report_overall.patientdetailuid) as labels
        FROM vw_report_overall
        WHERE worklistdatetime17 is NOT NULL AND patienttype is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";        

        $sql_AmountWaiting = "
        ---- Amount Waiting 
        -- 15 -> 17
        -- cwhen -> 17
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
            SELECT ROUND(extract(epoch FROM (worklistdatetime17::time - (CASE WHEN worklistdatetime15 is NOT NULL THEN worklistdatetime15 ELSE cwhen END)::time))/(30* 60))*10 || '-' || (ROUND(extract(epoch FROM (worklistdatetime17::time - (CASE WHEN worklistdatetime15 is NOT NULL THEN worklistdatetime15 ELSE cwhen END)::time))/(30* 60))+1)*10 as minute_range , count(worklistdatetime17) as count
            FROM vw_report_overall
            WHERE worklistdatetime15 is NOT NULL AND worklistdatetime17 is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (worklistdatetime17::time - (CASE WHEN worklistdatetime15 is NOT NULL THEN worklistdatetime15 ELSE cwhen END)::time))/(30* 60))
        ) Amount;
        ";
        
        $sql_Amount = "
        ---- Amount 
        SELECT count(worklistdatetime17) as data,date_trunc('hour', worklistdatetime17::time) || '-' || date_trunc('hour', worklistdatetime17::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE worklistdatetime17 is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $data['queuecate'] = $this->db->query($sql_Queuecatee)->result_array();
        $data['credit'] = $this->db->query($sql_Credit)->result_array();
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }

    function getMedicationStat($queuelocationuid,$Date)
    {
        $sql_AmountWaiting = "
        ---- Amount Waiting 
        SELECT round(avg(time_range)) as data ,patientcategoryname as labels 
        FROM (
            SELECT 
                patientdetailuid,
                ((extract(epoch from worklistdatetime17) - extract(epoch from worklistdatetime3))/60) as time_range,
                (SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategoryname
            FROM vw_report_overall
            WHERE worklistdatetime3::varchar || worklistdatetime17::varchar is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
        )sources
        GROUP BY labels
        ";
        
        $sql_Amount = "
        ---- Amount
        SELECT count(worklistdatetime3) as data,date_trunc('hour', worklistdatetime3::time) || '-' || date_trunc('hour', worklistdatetime3::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE worklistdatetime3 is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }

    function getCheckMedStat($queuelocationuid,$Date)
    {
        $sql_Type = "
        ---- Type
        SELECT sources.data, CASE WHEN (sources.labels is NOT NULL AND  sources.labels <> '') THEN sources.labels WHEN (sources.labels = 'ตรวจยาเสร็จแล้ว') THEN 'ยาถูกต้อง' ELSE 'ไม่มีสถานะ' END as labels
        FROM (
            SELECT count(worklistdatetime5) as data,(SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 5 AND pcc.patientdetailuid = patientdetailuid ORDER BY cwhen DESC LIMIT 1)) as labels
            FROM vw_report_overall
            WHERE worklistdatetime5 is NOT NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY labels
        )sources
        ";

        $sql_AmountWaiting = "
        ---- Amount Waiting 
        -- 3 -> 5
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
            SELECT ROUND(extract(epoch FROM (worklistdatetime5::time - worklistdatetime3::time))/(30* 60))*10 || '-' || (ROUND(extract(epoch FROM (worklistdatetime5::time - worklistdatetime3::time))/(30* 60))+1)*10 as minute_range , count(worklistdatetime5) as count
            FROM vw_report_overall
            WHERE worklistdatetime5 is NOT NULL AND worklistdatetime3 is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (worklistdatetime5::time - worklistdatetime3::time))/(30* 60))
        ) Amount;
        ";
        
        $sql_Amount = "
        ---- Amount
        SELECT count(worklistdatetime5) as data,date_trunc('hour', worklistdatetime5::time) || '-' || date_trunc('hour', worklistdatetime5::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE worklistdatetime5 is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";
        
        $data['type'] = $this->db->query($sql_Type)->result_array();
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }

    function getDispenseStat($queuelocationuid,$Date)
    {
        $sql_AmountWaiting = "
        ---- Amount Waiting 
        -- 5 -> 17
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM (
            SELECT ROUND(extract(epoch FROM (worklistdatetime17::time - worklistdatetime5::time))/(30* 60))*5 || '-' || (ROUND(extract(epoch FROM (worklistdatetime17::time - worklistdatetime5::time))/(30* 60))+1)*5 as minute_range , count(worklistdatetime5) as count
            FROM vw_report_overall
            WHERE worklistdatetime17 is NOT NULL AND worklistdatetime5 is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (worklistdatetime17::time - worklistdatetime5::time))/(30* 60))
        ) Amount;
        ";
        
        $sql_TypeTime = "
        ---- TypeTime
        SELECT round(avg(time_range)) as data ,patientcategoryname as labels 
        FROM (
            SELECT 
                ((extract(epoch from worklistdatetime17) - extract(epoch from worklistdatetime15))/60) as time_range,
                (SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategoryname
            FROM vw_report_overall
            WHERE worklistdatetime17::varchar || worklistdatetime15::varchar is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
        )sources
        GROUP BY labels
        ";
        
        $sql_Amount = "
        ---- Amount
        SELECT count(worklistdatetime17) as data,date_trunc('hour', worklistdatetime17::time) || '-' || date_trunc('hour', worklistdatetime17::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE worklistdatetime17 is NOT NULL 
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";

        $sql_AmountQueueCateTime = "
        SELECT round(avg(time_range)) as data ,patientcategoryname as labels 
        FROM (
            SELECT 
                ((extract(epoch from worklistdatetime17) - extract(epoch from worklistdatetime14))/60) as time_range,
                (SELECT patientcategoryname FROM patientcategory pc WHERE pc.uid = vw_report_overall.patientcategoryuid) as patientcategoryname
            FROM vw_report_overall
            WHERE worklistdatetime17::varchar || worklistdatetime14::varchar is NOT NULL
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
        )sources
        GROUP BY labels;        
        ";
        
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['typetime'] = $this->db->query($sql_TypeTime)->result_array();//$data['typetime'] = [array('labels'=>[],'data'=>[])];
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['amountqueuecatetime'] = $this->db->query($sql_AmountQueueCateTime)->result_array();//$data['amountqueuecatetime'] = [array('labels'=>[],'data'=>[])];
        $data['count'] =  array_sum(array_column($data['amount'], 'data')); 
        return $data;
    }
}
