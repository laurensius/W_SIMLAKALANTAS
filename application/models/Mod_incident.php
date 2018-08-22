<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_incident extends CI_Model {
    
    function incident_insert($data){
        $this->db->insert("incident",$data);
        return $this->db->affected_rows();
    }

    function incident_select_by_sender($sender){
        $this->db->select('*');
        $this->db->from('incident');
        $this->db->where('incident.sender',$sender);
        $query = $this->db->get();
        return $query->result();
    }

    function incident_select_by_station($station){
        $this->db->select('*');
        $this->db->from('incident');
        $this->db->where('station',$station);
        $query = $this->db->get();
        return $query->result();
    }

    function incident_select_by_station_stage($parameter){
        $this->db->select('*');
        $this->db->from('incident');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query->result();
    }

    function incident_update_stage($id ,$data){
        $this->db->where('id', $id);
        $this->db->update('incident', $data); 
    }

    function incident_detail($id){
        $this->db->select('*');
        $this->db->from('incident');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

}
