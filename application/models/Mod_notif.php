<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_notif extends CI_Model {

    function notif_detail($id){
        $this->db->select('*');
        $this->db->from('notification');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function notif_select_recent($agent,$agent_id,$limit){
        $this->db->select('*');
        $this->db->from('notification');
        $this->db->where($agent,$agent_id);
        $this->db->order_by('id','desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    function notif_delete($id){
        $this->db->where('id',$id);
        $this->db->delete('notification');
    }

    function notif_update_open($id,$data){
        $this->db->where('id', $id);
        $this->db->update('notification', $data); 
        return $this->db->affected_rows();
    }

}