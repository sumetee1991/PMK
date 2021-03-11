<?php
class StatMDL extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getKioskStat($queuelocationuid, $Date)
    {
        $sql_Amount = "
        ---- Amount
        SELECT count(queueno) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE queueno is NOT NULL
        AND queueno::integer <> 0  
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";

        $sql_Amount_lo4_Kiosk_free  = "
        ---- Amount
        SELECT count(cwhen) as labels
        FROM vw_report_overall
        WHERE worklistdatetime15 is NULL
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        ";

        $sql_Amount_lo4_Kiosk_total  = "
        ---- Amount
        SELECT count(worklistdatetime15) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";

        $sql_Amount_lo4_Kiosk  = "
        ---- Amount
        SELECT count(worklistdatetime15) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE queueno is NOT NULL
        AND queueno::integer <> 0  
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";

        $sql_Amount_lo4_Walk_in = "
        ---- Amount
        SELECT count(worklistdatetime15) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE processstatus = 'W'
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";

        $sql_Amount_lo4_Online = "
        ---- Amount
        SELECT count(worklistdatetime15) as data,date_trunc('hour', cwhen::time) || '-' || date_trunc('hour', cwhen::time + interval '1 hour') as labels
        FROM vw_report_overall
        WHERE processstatus = 'O'
        AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels
        ";
        
        $data['amount_lo4_Kiosk_free'] = $this->db->query($sql_Amount_lo4_Kiosk_free)->result_array();
        $data['amount_lo4_Kiosk_total'] = $this->db->query($sql_Amount_lo4_Kiosk_total)->result_array();
        $data['amount_lo4_Kiosk'] = $this->db->query($sql_Amount_lo4_Kiosk)->result_array();
        $data['amount_lo4_Walk_in'] = $this->db->query($sql_Amount_lo4_Walk_in)->result_array();
        $data['amount_lo4_Online'] = $this->db->query($sql_Amount_lo4_Online)->result_array();
        $data['count_lo4'] =  array_sum(array_column($data['amount_lo4_Kiosk_total'], 'data'));
        $data['count_lo4_free'] =  array_sum(array_column($data['amount_lo4_Kiosk_free'], 'labels'));
        
        
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data'));
        return $data;
    }

    function getDrugChargeStat($queuelocationuid, $Date)
    {
        $sql_AmountWaiting = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (ROUND(extract(epoch FROM 
            (cwhen::time - callbeforedate6::time))/(30* 60))*5 || '-' || 
            (ROUND(extract(epoch FROM (cwhen::time - callbeforedate6::time))/(30* 60))+1)*5) is not null  then 
            (ROUND(extract(epoch FROM (cwhen::time - callbeforedate6::time))/(30* 60))*5 || '-' || 
            (ROUND(extract(epoch FROM (cwhen::time - callbeforedate6::time))/(30* 60))+1)*5)  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as minute_range 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND queueno is NOT NULL 
            AND queueno::integer <> 0
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (cwhen::time - callbeforedate6::time))/(30* 60))
        )   Amount  ;
       
        ";
        // Amount where Amount.minute_range is not null;
        $sql_Amount = "
        ---- Amount 
        SELECT Amount.count as data,Amount.date_trunc || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', callbeforedate6::time) || '-' || date_trunc('hour', callbeforedate6::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', callbeforedate6::time) || '-' || date_trunc('hour', callbeforedate6::time + interval '1 hour'))  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND queueno is NOT NULL 
            AND queueno::integer <> 0
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', callbeforedate6::time) || '-' || 
        date_trunc('hour', callbeforedate6::time + interval '1 hour'))
        )   Amount  ;
        ";

        $sql_Type = "
        ---- Type
        SELECT count(worklistdatetime15) as data,patienttype as labels
        FROM vw_report_overall
        WHERE cancelqueuedate is NULL 
        AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";

        $sql_Type_lo4 = "
        ---- Type
        SELECT count(worklistdatetime15) as data,processstatus as labels
        FROM vw_report_overall
        WHERE cancelqueuedate is NULL 
        AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";

        $sql_Queuecatee = "
        ---- CateType
        SELECT count(cwhen) as data, patientcategoryshortname as labels
        FROM vw_report_overall
        WHERE cancelqueuedate is NULL 
        AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
        AND queuelocationuid = $queuelocationuid
        GROUP BY labels;
        ";

        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['type'] = $this->db->query($sql_Type)->result_array();
        $data['type_lo4'] = $this->db->query($sql_Type_lo4)->result_array();
        $data['queuecate'] = $this->db->query($sql_Queuecatee)->result_array();
        $data['count_DrugCharge'] =  array_sum(array_column($data['amount'], 'data'));
        $data['count_Cashier'] =  array_sum(array_column($data['type'], 'data'));
        $data['count_Kiosk'] =  array_sum(array_column($data['type_lo4'], 'data'));
        return $data;
    }

    function getMedQueueStat($queuelocationuid,$Date)
    {
    }

    function getCashierStat($queuelocationuid, $Date)
    {
        $sql_Queuecatee = "
        ---- CateType
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(cwhen) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc 
                         FROM vw_report_overall
                         WHERE patienttype = 'ติดต่อการเงิน'
                         AND cancelqueuedate is NULL 
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;
        ";

        $sql_Credit = "
        ---- Credit
        SELECT count(cwhen) as data,(
            SELECT CASE WHEN creditname IS NULL 
                THEN 'ไม่มีสิทธิ' ELSE creditname END FROM patientdetail pd 
                WHERE pd.uid = vw_report_overall.patientdetailuid) as labels
                FROM vw_report_overall
                WHERE patienttype = 'ติดต่อการเงิน'
                AND cancelqueuedate is NULL 
                AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                AND queuelocationuid = $queuelocationuid
                GROUP BY labels; 
        ";

        $sql_AmountWaiting = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.minute_range || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (ROUND(extract(epoch FROM 
            (callbeforedate1::time - worklistdatetime15::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (callbeforedate1::time - worklistdatetime15::time))/(30* 60))+1)*10) is not null  then 
            (ROUND(extract(epoch FROM (callbeforedate1::time - worklistdatetime15::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (callbeforedate1::time - worklistdatetime15::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as minute_range 
            FROM vw_report_overall
            WHERE patienttype = 'ติดต่อการเงิน'
            AND cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (callbeforedate1::time - worklistdatetime15::time))/(30* 60))
        )   Amount  ;
        ";

        $sql_Amount = "
        ---- Amount 
        SELECT Amount.count as data,Amount.date_trunc || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour'))  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as date_trunc 
            FROM vw_report_overall
            WHERE patienttype = 'ติดต่อการเงิน'
            AND cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', worklistdatetime15::time) || '-' || 
        date_trunc('hour', worklistdatetime15::time + interval '1 hour'))
        )Amount  ;
        ";

        $data['queuecate'] = $this->db->query($sql_Queuecatee)->result_array();
        $data['credit'] = $this->db->query($sql_Credit)->result_array();
        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data'));
        return $data;
    }

    function getMedicationStat($queuelocationuid, $Date)
    {
        $sql_AmountWaiting_HIS = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(ROUND(extract(epoch FROM (worklistdatetime15::time - his_druging_finished_date::time))/(30* 60))+1) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc
                         FROM vw_report_overall
                         WHERE cancelqueuedate is NULL 
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;
        ";

        $sql_Amount_HIS = "
        ---- Amount
        SELECT Amount.count as data,Amount.date_trunc || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', his_druging_finished_date::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', his_druging_finished_date::time + interval '1 hour'))  else 'ไม่มีข้อมูลการแสกน (ครั้งแรก)' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', his_druging_finished_date::time + interval '1 hour'))
        )Amount  ;
        ";

        $sql_AmountWaiting = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(ROUND(extract(epoch FROM (worklistdatetime15::time - worklistdatetime3::time))/(30* 60))+1) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc
                         FROM vw_report_overall
                         WHERE cancelqueuedate is NULL 
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;
        ";

        $sql_Amount = "
        ---- Amount
        SELECT Amount.count as data,Amount.date_trunc || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime3::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime3::time + interval '1 hour'))  else 'ไม่มีข้อมูลการแสกน (ครั้งแรก)' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime3::time + interval '1 hour'))
        )Amount  ;
        ";
        $data['waiting_his'] = $this->db->query($sql_AmountWaiting_HIS)->result_array();
        $data['amount_his'] = $this->db->query($sql_Amount_HIS)->result_array();
        $data['count_his'] =  array_sum(array_column($data['amount_his'], 'data'));

        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data'));
        return $data;
    }

    function getCheckMedStat($queuelocationuid, $Date)
    {
        $sql_Type = "
        ---- Type
        SELECT sources.data, CASE WHEN (sources.labels is NOT NULL AND  sources.labels <> '') THEN sources.labels WHEN (sources.labels = 'ตรวจยาเสร็จแล้ว') THEN 'ยาถูกต้อง' ELSE 'ไม่มีสถานะ' END as labels
        FROM (
            SELECT count(cwhen) as data,(SELECT worklistdescription FROM worklist wl WHERE wl.uid = (SELECT worklistuid FROM processcontrol pcc WHERE worklistuid = 5 AND pcc.patientdetailuid = patientdetailuid ORDER BY cwhen DESC LIMIT 1)) as labels
            FROM vw_report_overall
            WHERE worklistdatetime5 is NOT NULL 
            AND cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY labels
        )sources
        ";

        $sql_AmountWaiting_Queue = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (ROUND(extract(epoch FROM 
            (worklistdatetime15::time - worklistdatetime5::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (worklistdatetime15::time - worklistdatetime5::time))/(30* 60))+1)*10) is not null  then 
            (ROUND(extract(epoch FROM (worklistdatetime15::time - worklistdatetime5::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (worklistdatetime15::time - worklistdatetime5::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลวันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)' END)  as minute_range 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (worklistdatetime15::time - worklistdatetime5::time))/(30* 60))
        )   Amount  ;
        ";

        $sql_Amount_Queue = "
        ---- Amount
        SELECT Amount.count as data,Amount.date_trunc || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour'))  else 'ไม่มีข้อมูลวันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', worklistdatetime15::time) || '-' || date_trunc('hour', worklistdatetime15::time + interval '1 hour'))
        )   Amount  ;
        ";


        $sql_Amount_HIS = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.minute_range || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (ROUND(extract(epoch FROM 
            (his_drugchecked_finished_date::time - worklistdatetime15::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (his_drugchecked_finished_date::time - worklistdatetime15::time))/(30* 60))+1)*10) is not null  then 
            (ROUND(extract(epoch FROM (his_drugchecked_finished_date::time - worklistdatetime15::time))/(30* 60))*10 || '-' || 
            (ROUND(extract(epoch FROM (his_drugchecked_finished_date::time - worklistdatetime15::time))/(30* 60))+1)*10)  else 'ไม่มีข้อมูลวันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)' END)  as minute_range 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (his_drugchecked_finished_date::time - worklistdatetime15::time))/(30* 60))
        )   Amount  ;
        ";

        $sql_AmountWaiting_HIS = "
        ---- Amount
        SELECT Amount.count as data,Amount.date_trunc || ' นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', his_drugchecked_finished_date::time) || '-' || date_trunc('hour', his_drugchecked_finished_date::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', his_drugchecked_finished_date::time) || '-' || date_trunc('hour', his_drugchecked_finished_date::time + interval '1 hour'))  else 'ไม่มีข้อมูลวันที่-เวลา ที่เช็คยา (ครั้งสุดท้าย)' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', his_drugchecked_finished_date::time) || '-' || date_trunc('hour', his_drugchecked_finished_date::time + interval '1 hour'))
        )   Amount  ;
        ";

        $data['type'] = $this->db->query($sql_Type)->result_array();
        $data['waiting_queue'] = $this->db->query($sql_AmountWaiting_Queue)->result_array();
        $data['amount_queue'] = $this->db->query($sql_Amount_HIS)->result_array();
        $data['waiting_his'] = $this->db->query($sql_AmountWaiting_HIS)->result_array();
        $data['amount_his'] = $this->db->query($sql_Amount_Queue)->result_array();
        $data['count_total'] =  array_sum(array_column($data['type'], 'data'));
        $data['count_queue'] =  array_sum(array_column($data['amount_queue'], 'data'));
        $data['count_his'] =  array_sum(array_column($data['amount_his'], 'data'));
        return $data;
    }

    function getDispenseStat($queuelocationuid, $Date)
    {
        $sql_AmountWaiting = "
        ---- Amount Waiting 
        SELECT Amount.count as data,Amount.minute_range || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (ROUND(extract(epoch FROM 
            (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))*5 || '-' || 
            (ROUND(extract(epoch FROM (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))+1)*5) is not null  then 
            (ROUND(extract(epoch FROM (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))*5 || '-' || 
            (ROUND(extract(epoch FROM (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))+1)*5)  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as minute_range 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND messagecwhen2 is NULL
            AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY ROUND(extract(epoch FROM (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))
        )   Amount  ;
        ";

        $sql_TypeTime = "
        ---- TypeTime
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(ROUND(extract(epoch FROM (callbeforedate2::time - worklistdatetime15::time))/(30* 60))+1) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc
                         FROM vw_report_overall
                         WHERE cancelqueuedate is NULL 
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;
        ";

        $sql_Amount = "
        ---- Amount
        SELECT Amount.count as data,Amount.date_trunc || 'นาที' as labels FROM  (
            SELECT count(cwhen) as count, (case when  
            (date_trunc('hour', callbeforedate2::time) || '-' || date_trunc('hour', callbeforedate2::time + interval '1 hour')) is not null  then 
            (date_trunc('hour', callbeforedate2::time) || '-' || date_trunc('hour', callbeforedate2::time + interval '1 hour'))  else 'ไม่มีข้อมูลวันที่-เวลา กดเรียกคิวครั้งแรก' END)  as date_trunc 
            FROM vw_report_overall
            WHERE cancelqueuedate is NULL 
            AND to_char( cwhen::date , 'DD/MM/YYYY') = '$Date'
            AND queuelocationuid = $queuelocationuid
            GROUP BY (date_trunc('hour', callbeforedate2::time) || '-' || 
        date_trunc('hour', callbeforedate2::time + interval '1 hour'))
        )Amount  ;
        ";

        $sql_AmountQueueCateTime = "
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(ROUND(extract(epoch FROM (callbeforedate2::time - his_drugchecked_finished_date::time))/(30* 60))+1) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc
                         FROM vw_report_overall
                         WHERE cancelqueuedate is NULL 
                         AND messagecwhen2 is NULL
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;      
        ";

        $sql_AmountQueueTime = "
        SELECT Amount.count as data,Amount.date_trunc as labels FROM (
            SELECT count(ROUND(extract(epoch FROM (cwhen::time - callbeforedate2::time))/(30* 60))+1) as  count,
                (CASE WHEN(patientcategoryshortname) is not null  then 
                         (patientcategoryshortname) else 'ไม่มีข้อมูลประเภทคิว' END) as date_trunc
                         FROM vw_report_overall
                         WHERE cancelqueuedate is NULL 
                         AND queueno is NOT NULL
                         AND messagecwhen2 is NULL
                         AND queueno::integer <> 0  
                         AND to_char(cwhen::date , 'DD/MM/YYYY') = '$Date'
                         AND queuelocationuid = $queuelocationuid
                         GROUP BY patientcategoryshortname) Amount;       
        ";

        $data['waiting'] = $this->db->query($sql_AmountWaiting)->result_array();
        $data['typetime'] = $this->db->query($sql_TypeTime)->result_array(); //$data['typetime'] = [array('labels'=>[],'data'=>[])];
        $data['amount'] = $this->db->query($sql_Amount)->result_array();
        $data['amountqueuecatetime'] = $this->db->query($sql_AmountQueueCateTime)->result_array(); //$data['amountqueuecatetime'] = [array('labels'=>[],'data'=>[])];
        $data['amountqueuetime'] = $this->db->query($sql_AmountQueueTime)->result_array();
        $data['count'] =  array_sum(array_column($data['amount'], 'data'));
        return $data;
    }
}
