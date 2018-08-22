<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_station extends CI_Model {
    
    function station_list(){
        $this->db->select('*');
        $this->db->from('police_station');
        $query = $this->db->get();
        return $query->result();
    }

    function station_detail($id){
        $this->db->select('*');
        $this->db->from('police_station');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

}