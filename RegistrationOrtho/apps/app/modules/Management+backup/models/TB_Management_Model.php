<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TB_Management_Model extends CI_Model
{
    function __construct(){
        parent::__construct();
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
        $this->db->select('uid,code,name');
        $this->db->from('tb_queuecategory');
        $this->db->where('groupprocessuid',$groupprocessuid);
        $this->db->order_by('tb_queuecategory.order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetAllRoom(){
        $active_date_condition = 
        "(
            ( trim(to_char(CURRENT_TIMESTAMP, 'Day'))=ANY(tb_opdclinic.active_date) ) 
            OR 
            ( tb_opdclinic.active_date is null)
        )";
        $this->db->select('*');
        $this->db->from('tb_opdclinic');
        $this->db->order_by('tb_opdclinic.order', 'ASC');
        $this->db->where('tb_opdclinic.active','Y');
        $this->db->where($active_date_condition,NULL,FALSE);
        $query = $this->db->get();
        return $query->result();            
    }

    function GetBuilding(){
        $this->db->select('uid,building_name');
        $this->db->from('tb_building');
        $this->db->where('tb_building.active','Y');
        $this->db->order_by('tb_building.uid', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetBuilding_ID($BuildingUID){
        $this->db->select('uid,building_name');
        $this->db->from('tb_building');
        $this->db->where('tb_building.uid',$BuildingUID);
        $this->db->where('tb_building.active','Y');
        $this->db->order_by('tb_building.uid', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    function GetBuildingFloor($BuildingUID){
        $this->db->select('uid,floor_number,buildinguid');
        $this->db->from('tb_floor');
        $this->db->where('tb_floor.active','Y');
        $this->db->where('tb_floor.buildinguid',$BuildingUID);
        $this->db->order_by('tb_floor.uid', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetBuildingFloor_ID($BuildingFloorUID){
        $this->db->select('uid,floor_number,buildinguid');
        $this->db->from('tb_floor');
        $this->db->where('tb_floor.active','Y');
        $this->db->where('tb_floor.uid',$BuildingFloorUID);
        $this->db->order_by('tb_floor.uid', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    function GetBuildingRoom($BuildingUID){
        $active_date_condition = 
        "(
            ( trim(to_char(CURRENT_TIMESTAMP, 'Day'))=ANY(tb_opdclinic.active_date) ) 
            OR 
            ( tb_opdclinic.active_date is null)
        )";
        $this->db->select('*');
        $this->db->from('tb_opdclinic');
        $this->db->where('tb_opdclinic.buildinguid',$BuildingUID);
        $this->db->where('tb_opdclinic.active','Y');
        $this->db->where($active_date_condition,NULL,FALSE);
        $this->db->order_by('tb_opdclinic.order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetBuildingRoom_ID($BuildingRoomUID){
        $this->db->select('uid,code,detail,buildinguid,flooruid');
        $this->db->from('tb_opdclinic');
        $this->db->where('tb_opdclinic.uid',$BuildingRoomUID);
        $this->db->order_by('tb_opdclinic.flooruid', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }
}