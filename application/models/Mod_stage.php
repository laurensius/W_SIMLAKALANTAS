<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_stage extends CI_Model {
    
   
    function stage_detail($id){
        $this->db->select('*');
        $this->db->from('stage');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }
}