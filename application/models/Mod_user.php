<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_user extends CI_Model {
    
    function user_register($data){
        $this->db->insert("user",$data);
        return $this->db->affected_rows();
    }
    
    function is_registered($username){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$username);
        $query = $this->db->get();
        return $query->result();
    }

    function user_detail($id){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_by_username($data){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$data);
        $query = $this->db->get();
        return $query->result();
    }
    
    function update_login_timestamp($id,$data){
        $this->db->where('id', $id);
        $this->db->update('user', $data);  
    }
    
    function last_login($id){
        $query_str = "select user.last_login from user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    } 

    function update_profil($id,$data){
        $this->db->where('id', $id);
        $this->db->update('user', $data);  
        return $this->db->affected_rows();
    }

}