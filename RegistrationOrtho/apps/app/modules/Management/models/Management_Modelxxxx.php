<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management_Model extends CI_Model
{
  function __construct(){
    parent::__construct();
 }
    /*
        function GetTotalQueue($data){
            $this->db->select('*');
            $this->db->from('vw_patientqueue');
            $this->db->where($data, FALSE);
            $this->db->where('queueno is NOT NULL', NULL, FALSE);
            $this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
            $query = $this->db->get();
            return $query->result();
        }
    */
        function CountFilter(){
          $strquery = "
          SELECT count(DISTINCT(patientuid)) as count
          FROM public.vw_patientqueue
          WHERE selectvs is NOT NULL AND closequeue_vs is NOT NULL
          ";
          $query = $this->db->query($strquery)->row()->count;       
          return $query;
       }

       function GetFirstBuilding(){
          $this->db->select('uid');
          $this->db->from('tb_building');
          $this->db->where('tb_building.active','Y');
          $this->db->order_by('tb_building.uid', 'ASC');
          $this->db->limit('1');
          $query = $this->db->get();
          return $query->row();
       }

       function GetTotalQueue($data,$categoryUID = NULL){
          $this->db->select('*');
          $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
          $this->db->from('vw_patientqueue');
          $this->db->where($data, FALSE);
          $strquery = "";
          if($categoryUID != NULL){                
            if (strpos($categoryUID, '_') !== false) {
              $splitStr = explode('_', $categoryUID);
              $strquery = " ( ";
              foreach ($splitStr as $key => $value) {
                $strquery .= ($key > 0 ? ' OR ' : ' ');
                $strquery .= " queuecategoryuid = '".$value."' ";
             } 
             $strquery .= " ) ";
             $this->db->where($strquery, NULL,FALSE);
          }else{
           $strquery .= " queuecategoryuid = '".$categoryUID."' ";
        }
        $this->db->where($strquery, NULL,FALSE);
     }
     $this->db->order_by('cwhen','ASC');
        /////$this->db->order_by('queuecategoryorder','ASC');
        ////$this->db->order_by('queueno','ASC');
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
     $query = $this->db->get();
     return $query->result();
  }

  function GetTotalQueue_Visit($data,$categoryUID = NULL){
    $this->db->select('*');
    $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
    $this->db->from('vw_patientqueue');
    $this->db->where($data, FALSE);
    $strquery = "";
    if($categoryUID != NULL){                
      if (strpos($categoryUID, '_') !== false) {
        $splitStr = explode('_', $categoryUID);
        $strquery = " ( ";
        foreach ($splitStr as $key => $value) {
          $strquery .= ($key > 0 ? ' OR ' : ' ');
          $strquery .= " queuecategoryuid = '".$value."' ";
       } 
       $strquery .= " ) ";
       $this->db->where($strquery, NULL,FALSE);
    }else{
     $strquery .= " queuecategoryuid = '".$categoryUID."' ";
  }
  $this->db->where($strquery, NULL,FALSE);
}
$this->db->order_by('cwhen','DESC');
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
$query = $this->db->get();
return $query->result();
}

    /*
    function GetTotalQueue_Revert($data,$categoryUID = NULL){

        if($categoryUID != NULL){                
            if (strpos($categoryUID, '_') !== false) {
                $splitStr = explode('_', $categoryUID);
                $all_query = array();
                $count_split = count($splitStr);
                $limit_each = intval(100/intval($count_split));
                for ($i=0; $i < count($splitStr); $i++) {
                    $strquery = "";
                    $strquery .= " queuecategoryuid = '".$splitStr[$i]."' ";

                    $this->db->select('*');
                    $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
                    $this->db->from('vw_patientqueue');
                    $this->db->where($data, FALSE);
                    $this->db->where($strquery, NULL,FALSE);
                    $this->db->order_by('cwhen', 'DESC');
                    $this->db->limit($limit_each);
                    $all_query[$i] = $this->db->get_compiled_select();
                    $this->db->reset_query();
                }
                $final_query = "";
                for ($n=0; $n < count($all_query); $n++) { 
                    $final_query .= ($final_query == "" ? '' : ' UNION ');
                    $final_query .= ' ( ' . $all_query[$n] . ' ) ';
                }
                $final_query .= " ORDER BY queuecategoryorder ASC,cwhen ASC";
                $query = $this->db->query($final_query);
            }else{
                $strquery = " queuecategoryuid = '".$categoryUID."' ";
                $this->db->select('*');
                $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
                $this->db->from('vw_patientqueue');
                $this->db->where($data, FALSE);
                $this->db->where($strquery, NULL,FALSE);
                $this->db->order_by('cwhen', 'DESC');
                $this->db->limit(100);
                $query = $this->db->get();
            }
            //$this->db->where($strquery, NULL,FALSE);
        }else{
            $this->db->select('*');
            $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
            $this->db->from('vw_patientqueue');
            $this->db->where($data, FALSE);
            $this->db->order_by('cwhen', 'DESC');
            $this->db->limit(100);
            $query = $this->db->get();
        }
        return $query->result();
     }*/
     function GetTotalQueue_Revert($data,$categoryUID = NULL){
       $this->db->select('*');
       $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
       $this->db->from('vw_patientqueue');
       $this->db->where($data, FALSE);
       // var_dump($data);
       $strquery = "";
       if($categoryUID != NULL){                
         if (strpos($categoryUID, '_') !== false) {
           $splitStr = explode('_', $categoryUID);
           $strquery = " ( ";
           foreach ($splitStr as $key => $value) {
             $strquery .= ($key > 0 ? ' OR ' : ' ');
             $strquery .= " queuecategoryuid = '".$value."' ";
          } 
          $strquery .= " ) ";
          $this->db->where($strquery, NULL,FALSE);
       }else{
        $strquery .= " queuecategoryuid = '".$categoryUID."' ";
     }
     $this->db->where($strquery, NULL,FALSE);
  }
  $this->db->order_by('lastactionworklist', 'DESC');
        //$this->db->limit(100);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
  $query = $this->db->get();
  return $query->result();
}



    function GetTotalQueue_Revert2($data,$categoryUID = NULL){
       $this->db->select('*');
       $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
       $this->db->from('vw_patientqueue');
       $this->db->where($data, FALSE);
       $strquery = "";
       if($categoryUID != NULL){                
         if (strpos($categoryUID, '_') !== false) {
           $splitStr = explode('_', $categoryUID);
           $strquery = " ( ";
           foreach ($splitStr as $key => $value) {
             $strquery .= ($key > 0 ? ' OR ' : ' ');
             $strquery .= " queuecategoryuid = '".$value."' ";
          } 
          $strquery .= " ) ";
          $this->db->where($strquery, NULL,FALSE);
       }else{
        $strquery .= " queuecategoryuid = '".$categoryUID."' ";
     }
     $this->db->where($strquery, NULL,FALSE);
  }
  $this->db->order_by('lastactionworklist', 'DESC');
        //$this->db->limit(100);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
  $query = $this->db->get();
  return $query->result();
}




function GetQueueShowlocation2($data){
 $strquery = "
 SELECT *
 , ((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting
 FROM vw_patientqueue 
 WHERE queuelocation='2' AND
 active = 'Y' 
 AND
 -- (
 -- (selectvs is NOT NULL AND closequeue_vs is NOT NULL) OR
 -- (selectvs is NULL AND closequeue_vs is NULL)
 -- ) 
 -- AND
 -- selectnewhn is NOT NULL AND 
 closqueue_registerhn is NULL 
 AND 
 cancelqueue_registerhn is NULL 
 ";
 if(isset($data['patientuid']) && $data['patientuid'] != NULL){
   $strquery .= " AND patientuid = '".$data['patientuid']."' ";
}elseif(isset($data['queueno']) && $data['queueno'] != NULL){
   $strquery .= " AND queueno = '".$data['queueno']."' ";            
}else{
   $strquery .= "
   AND groupprocessuid = '".$data['groupprocessuid']."' 
   ";
   if (strpos($data['queuecategoryuid'], '_') !== false) {
     $splitStr = explode('_', $data['queuecategoryuid']);
     $strquery .= " AND ( ";
     foreach ($splitStr as $key => $value) {
       $strquery .= ($key > 0 ? ' OR ' : ' ');
       $strquery .= " queuecategoryuid = '".$value."' ";
    } 
    $strquery .= " ) ";
 }else{
  $strquery .= " AND queuecategoryuid = '".$data['queuecategoryuid']."' ";
}

}
$strquery .= " ORDER BY queuecategoryorder ASC,cwhen ASC";




        ////$strquery .= " ORDER BY queuecategoryorder ASC,queueno ASC";
        //$strquery .= " LIMIT 100 ";
$query = $this->db->query($strquery)->result();       
return $query;
}





function GetQueueNewHN($data){
 $strquery = "
 SELECT *
 , ((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting
 FROM vw_patientqueue 
 WHERE 
 active = 'Y' AND
 (
 (selectvs is NOT NULL AND closequeue_vs is NOT NULL) OR
 (selectvs is NULL AND closequeue_vs is NULL)
 ) AND
 selectnewhn is NOT NULL AND 
 closqueue_registerhn is NULL AND 
 cancelqueue_registerhn is NULL 
 ";
 if(isset($data['patientuid']) && $data['patientuid'] != NULL){
   $strquery .= " AND patientuid = '".$data['patientuid']."' ";
}elseif(isset($data['queueno']) && $data['queueno'] != NULL){
   $strquery .= " AND queueno = '".$data['queueno']."' ";            
}else{
   $strquery .= "
   AND groupprocessuid = '".$data['groupprocessuid']."' 
   ";
   if (strpos($data['queuecategoryuid'], '_') !== false) {
     $splitStr = explode('_', $data['queuecategoryuid']);
     $strquery .= " AND ( ";
     foreach ($splitStr as $key => $value) {
       $strquery .= ($key > 0 ? ' OR ' : ' ');
       $strquery .= " queuecategoryuid = '".$value."' ";
    } 
    $strquery .= " ) ";
 }else{
  $strquery .= " AND queuecategoryuid = '".$data['queuecategoryuid']."' ";
}

}
$strquery .= " ORDER BY queuecategoryorder ASC,cwhen ASC";
        ////$strquery .= " ORDER BY queuecategoryorder ASC,queueno ASC";
        //$strquery .= " LIMIT 100 ";
$query = $this->db->query($strquery)->result();       
return $query;
}

function GetQueueRegister($data){
 $strquery = "
 SELECT * 
 , ((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting
 FROM vw_patientqueue 
 WHERE 
 active = 'Y' AND
 (
 (selectvs is NOT NULL AND closequeue_vs is NOT NULL) OR
 (selectvs is NULL AND closequeue_vs is NULL)
 ) AND
 (
 (
 selectnewhn is NOT NULL AND 
 closqueue_registerhn is NOT NULL
 ) OR
 (
 selectnewhn is NULL
 )
 ) AND
 selectpayor is NOT NULL AND
 closqueue_register is NULL AND
 cancelqueue_register is NULL 
 ";
 if(isset($data['patientuid']) && $data['patientuid'] != NULL){
   $strquery .= " AND patientuid = '".$data['patientuid']."' ";
}elseif(isset($data['queueno']) && $data['queueno'] != NULL){
   $strquery .= " AND queueno = '".$data['queueno']."' ";            
}else{
   $strquery .= "
   AND groupprocessuid = '".$data['groupprocessuid']."' 
   ";
   if (strpos($data['queuecategoryuid'], '_') !== false) {
     $splitStr = explode('_', $data['queuecategoryuid']);
     $strquery .= " AND ( ";
     foreach ($splitStr as $key => $value) {
       $strquery .= ($key > 0 ? ' OR ' : ' ');
       $strquery .= " queuecategoryuid = '".$value."' ";
    } 
    $strquery .= " ) ";
 }else{
  $strquery .= " AND queuecategoryuid = '".$data['queuecategoryuid']."' ";
}

}
$strquery .= " ORDER BY queuecategoryorder ASC,cwhen ASC";
        ////$strquery .= " ORDER BY queuecategoryorder ASC,queueno ASC";
        //$strquery .= " LIMIT 100 ";
$query = $this->db->query($strquery)->result();       
return $query;
}




function GetQueueRegister2($data){
 $strquery = "
 SELECT * 
                        , ((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting
                        FROM vw_patientqueue 
                        WHERE 
                        active = 'Y' AND
                        (
                            (selectvs is NOT NULL AND closequeue_vs is NOT NULL) OR
                            (selectvs is NULL AND closequeue_vs is NULL)
                        ) AND
                        (
                            (
                                selectnewhn is NOT NULL AND 
                                closqueue_registerhn is NOT NULL
                            ) OR
                            (
                                selectnewhn is NULL
                            )
                        ) AND
                        selectpayor is NOT NULL AND
                        closqueue_register is NULL AND
                        cancelqueue_register is NULL 
 ";
 if(isset($data['patientuid']) && $data['patientuid'] != NULL){
   $strquery .= " AND patientuid = '".$data['patientuid']."' ";
}elseif(isset($data['queueno']) && $data['queueno'] != NULL){
   $strquery .= " AND queueno = '".$data['queueno']."' ";            
}else{
   $strquery .= "
   AND groupprocessuid = '".$data['groupprocessuid']."' 
   ";
   if (strpos($data['queuecategoryuid'], '_') !== false) {
     $splitStr = explode('_', $data['queuecategoryuid']);
     $strquery .= " AND ( ";
     foreach ($splitStr as $key => $value) {
       $strquery .= ($key > 0 ? ' OR ' : ' ');
       $strquery .= " queuecategoryuid = '".$value."' ";
    } 
    $strquery .= " ) ";
 }else{
  $strquery .= " AND queuecategoryuid = '".$data['queuecategoryuid']."' ";
}

}
$strquery .= " ORDER BY queuecategoryorder ASC,cwhen ASC";

// echo $strquery;
// exit();

// var_dump($strquery);
// exit();


        ////$strquery .= " ORDER BY queuecategoryorder ASC,queueno ASC";
        //$strquery .= " LIMIT 100 ";




$query = $this->db->query($strquery)->result();       
return $query;
}






function GetQueueRegister_Related($data){
 $strquery = "
 SELECT * 
 , ((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting
 FROM vw_patientqueue 
 WHERE 
 (
 (selectvs is NOT NULL AND closequeue_vs is NOT NULL) OR
 (selectvs is NULL AND closequeue_vs is NULL)
 ) AND
 (
 (
 selectnewhn is NOT NULL AND 
 closqueue_registerhn is NOT NULL
 ) OR
 (
 selectnewhn is NULL
 )
 ) AND
 selectpayor is NOT NULL AND
 closqueue_register is NULL AND
 cancelqueue_register is NULL 
 ";
 if(isset($data['queueno']) && $data['queueno'] != NULL){
   $strquery .= " 
   AND patientuid = (SELECT patientuid FROM vw_patientqueue WHERE queueno = '".$data['queueno']."' LIMIT 1)
   ";
}


$query = $this->db->query($strquery)->result();       
return $query;
}

function GetFilterQueueInfo($data){
 $this->db->select('*');
 $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
 $this->db->from('vw_patientqueue');
 $this->db->where($data, FALSE);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
 $this->db->order_by('cwhen','DESC');
 $this->db->limit(1);
 $query = $this->db->get();

 return $query->result();
}

function GetQueueInfo_All_Refno($refno){
 $this->db->select('*');
 $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
 $this->db->from('vw_patientqueue');
 $this->db->where('refno',$refno);
 $query = $this->db->get();
 return $query->result();
}

function GetCounterInfo($CounterID){
 $this->db->select('countername');
 $this->db->from('tb_counter');
 $this->db->where('uid',$CounterID);
 $this->db->where('active','Y');
 $query = $this->db->get();
 return $query->result();
}

function GetQueueInfo($QueueNumber){
 $this->db->select('*');
 $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
 $this->db->from('vw_patientqueue');
 $this->db->where('queueno',$QueueNumber);
 $this->db->where('queueno is NOT NULL', NULL, FALSE);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
 $query = $this->db->get();
 return $query->result();
}

function GetQueueInfo_Related($data){
 $this->db->select('*');
 $this->db->select("((date_part('epoch'::text, NOW()) * 1000::double precision) - lastworklist_cwhen) AS lastworklist_waiting");
 $this->db->from('vw_patientqueue');
 $this->db->where($data);
        //$this->db->where('queueno is NOT NULL', NULL, FALSE);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
 $this->db->order_by('cwhen','DESC');
 $this->db->limit(1);
 $query = $this->db->get();
 return $query->result();
}

function GetHoldMessage(){
 $this->db->select('*');
 $this->db->from('tb_message');
 $query = $this->db->get();
 return $query->result();
}

function GetHoldMessageGroup($groupprocessuid){
 $this->db->select('*');
 $this->db->from('tb_message');
 $this->db->where('groupprocessuid', $groupprocessuid);
 $this->db->where('active', 'Y');
 $query = $this->db->get();
 return $query->result();
}

function GetCounterData($location,$groupprocessuid){    	
 $this->db->select('counterno,countername,groupprocessuid');
 $this->db->from('tb_counter');
 $this->db->where('active', 'Y');
 $this->db->where('location_id',$location);
 $this->db->where('groupprocessuid',$groupprocessuid);
 $this->db->order_by('tb_counter.countername', 'ASC');

 $query = $this->db->get();
 return $query->result();
}

function GetCategoryData(){    	
 $this->db->select('uid,code,name,queuelocation');
 $this->db->from('tb_queuecategory');
 $this->db->where('queuelocation',1);
 $query = $this->db->get();
 return $query->result();
}


function GetCounterData2(){       
 $this->db->select('counterno,countername,groupprocessuid');
 $this->db->from('tb_counter');
 $this->db->where('active', 'Y');
 $this->db->order_by('tb_counter.countername', 'ASC');
 $query = $this->db->get();
 return $query->result();
}

function GetCategoryData2(){      
 $this->db->select('uid,code,name,queuelocation');
 $this->db->from('tb_queuecategory');
 $this->db->where('groupprocessuid',2);
 $this->db->where('queuelocation',2);
 $query = $this->db->get();
 return $query->result();
}






function GetPatientTypeData(){
 $this->db->select('uid,name');
 $this->db->from('tb_patienttype');
 $query = $this->db->get();
 return $query->result();
}

function GetPayorData(){
 $this->db->select('uid,name');
 $this->db->from('tb_payor');
 $query = $this->db->get();
 return $query->result();
}

function GetWorklistDescription($ID){
 $this->db->select('description');
 $this->db->from('tb_worklist');
 $this->db->where('uid',$ID);
 $query = $this->db->get();
 return $query->result();
}

function GetWorklistStatus($QueueNumber){
 $this->db->select('lastworklist');
 $this->db->from('vw_patientqueue');
 $this->db->where('queueno',$QueueNumber);
        //$this->db->where('cast(cwhen as date) = cast(NOW() as date)', NULL, FALSE);
 $query = $this->db->get();
 return $query->result();
}

function GetOPDClinic(){
 $this->db->select('*');
 $this->db->from('tb_opdclinic');
 $query = $this->db->get();
 return $query->result();
}

function InsertMessage($data){
 $checkData = array(
   'patientdetailuid' => $data['patientdetailuid'],
   'groupprocessuid' => $data['groupprocessuid'],
);
 $checkQuery = $this->db->select('*')
 ->from('tr_messagedetail')
 ->where($checkData)
 ->where('cast(cwhen as date) = cast(NOW() as date)',NULL,FALSE)
 ->get()
 ->num_rows();

 if( $checkQuery > 0 ){
   $this->db->set($data, FALSE);
   $this->db->where('patientdetailuid', $data['patientdetailuid']);
   $this->db->update('tr_messagedetail');
}
else{
   $this->db->insert('tr_messagedetail', $data);
}
}

function InsertProcessControl($data){
 $this->db->insert('tr_processcontrol', $data);
}

function CallQueue($data){
 $this->db->insert('tr_callqueue', $data);
}

function HoldQueue($data){
 $this->db->insert('tr_callqueue', $data);
}

function RemoveTR($SelectedTable,$data){
 $this->db->where($data);
 $this->db->where('cast(createdate as date) = cast(NOW() as date)', NULL, FALSE);
 $this->db->delete($SelectedTable);
}







function GetLocationCounterData($groupprocessuid){      
 $this->db->select('counterno,countername,groupprocessuid');
 $this->db->from('tb_counter');
 $this->db->where('groupprocessuid',$groupprocessuid);
 $this->db->where('active', 'Y');
 $query = $this->db->get();
 return $query->result();
}

function GetLocationCategoryData($groupprocessuid){     
 $this->db->select('uid,code,name,queuelocation');
 $this->db->from('tb_queuecategory');
 $this->db->where('groupprocessuid',$groupprocessuid);
 $this->db->where('queuelocation',1);
 $this->db->order_by('tb_queuecategory.order', 'ASC');
 $query = $this->db->get();
 return $query->result();
}

function CountClinic(){
 $query_str = "
 SELECT tb_opd.uid,count(tb_cc.uid) 
 FROM tb_opdclinic tb_opd 
 LEFT JOIN tb_cliniccount tb_cc 
 ON tb_cc.room_uid = tb_opd.uid 
 AND tb_cc.cwhen::date = NOW()::date 
 GROUP BY tb_opd.uid";
 $query = $this->db->query($query_str)->result_array();
 return $query;
}

function InsertClinicCount($Data){
 $InsertData = array(
   'room_uid' => $Data['room'],            
);
 if(isset($Data['log_id']) && $Data['log_id']){$InsertData['apistatus_uid'] = $Data['log_id'];}
 if( isset($Data['refno']) ){
   $query_refno = $this->db->select('uid')->from('tr_patient')->where('refno',$Data['refno'])->get();
   $InsertData['patient_uid'] = $query_refno->num_rows() > 0 ? $query_refno->row()->uid : false;
}
$this->db->reset_query();
$this->db->insert('tb_cliniccount',$InsertData);
return true;
        /*
            $URL = MIDURL . '/api/manage/refreshClinicCount';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic YXJtOjEyMzQ=',
            ));        
            curl_setopt($ch, CURLOPT_URL,$URL);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
        */
         }

         function InsertLogAPI($data){
        //$InsertStatus = "INSERT INTO tr_api_status(hn,idcard,cuser,refno,status_api,status_get,system_type) VALUES('".$data['p_run_hn'].'/'.$data['p_year_hn']."','".$data['pid']."','".$data['p_user_created']."','".$data['refno']."','".$data['code']."','".$data['code']."','management') RETURNING uid";
        //$result = $this->db->query($InsertStatus);

          $InsertData = array(
            'hn' => isset($data['p_run_hn'])&&isset($data['p_year_hn'])?$data['p_run_hn'].'/'.$data['p_year_hn']:'',
            'idcard' => $data['idcard'],
            'cuser' => $data['p_user_created'],
            'refno' => $data['refno'],
            'status_api' => $data['code'],
            'status_get' => $data['code'],
            'system_type' => 'management',
            'status_name' => $data['code'] == 200 || $data['code'] == 201 ? true : false,
         );
          $this->db->insert('tr_api_status',$InsertData);
          $InsertID = $this->db->insert_id();
          $this->db->reset_query();
          $InsertDetail = array(
            'apistatusuid' => $InsertID,
            'datajson' => $data['result']
         );
          $this->db->insert('tr_api_detail',$InsertDetail);
          return $InsertID;
       }

       function add_cliniccount($room_uid){
          $query = "INSERT INTO tb_cliniccount(room_uid) VALUES($room_uid)";
          return $this->db->query($query);
       }
       function remove_cliniccount($room_uid){
          $query = "DELETE FROM tb_cliniccount WHERE uid = (SELECT max(uid) FROM tb_cliniccount WHERE room_uid = $room_uid AND cwhen::date = NOW()::date AND patient_uid is NULL)";
          return $this->db->query($query);
       }
    // pool.query(`INSERT INTO tr_api_status(hn,idcard,cuser,refno,status_api,status_get) VALUES(${hn},${idcard},${cuser},${refno},${status_api},${status_get}) returning uid`, (err, result) => {
    //     if (err) {
    //         console.log('result insert error');
    //         console.log(err);
    //     } else {

    //         var result_id = parseInt(result.rows[0]['uid']);
    //         pool.query(`INSERT INTO tr_api_detail(apistatusuid,datajson) VALUES(${result_id},${data_main})`, (err2, result2) => {
    //             if (err2) {
    //                 console.log('insert error222');
    //                 console.log(err2);
    //             } else {
    //                 console.log('result insert22');
    //             }
    //         });
    //     }
    // });

    }