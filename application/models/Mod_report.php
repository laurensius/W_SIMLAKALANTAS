<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Mod_report extends CI_Model {
    
    function report_insert($data){
        $this->db->insert("final_report",$data);
        return $this->db->affected_rows();
    }

    function report_select_by_station($station_id){
        $this->db->select("*");
        $this->db->from("incident");
        $this->db->join("final_report","incident.id = final_report.incident","inner");
        $this->db->join("user","user.id = incident.sender","inner");
        $this->db->where("incident.station='" .$station_id . "' and incident.last_stage='3'" );
        $query = $this->db->get();
        return $query->result();
    }

    function report_select_by_station_detail($station_id,$incident_id){
        $this->db->select("*");
        $this->db->from("incident");
        $this->db->join("final_report","incident.id = final_report.incident","inner");
        $this->db->join("user","user.id = incident.sender","inner");
        $this->db->where("incident.station='" .$station_id . "' and incident.last_stage='3' and final_report.incident='" .$incident_id . "'" );
        $query = $this->db->get();
        return $query->result();
    }

    //select DISTINCT(police_station.nama_kantor), police_station.id, (SELECT count(incident.station) from incident WHERE incident.station = police_station.id and incident.received_at BETWEEN '2018-08-07 00:00:00' and '2018-08-07 23:59:59') as jumlah FROM police_station, incident
    function report_count_by_day($day){
        $query = $this->db->query("select 
            DISTINCT(police_station.nama_kantor), 
            police_station.id, 
            police_station.address, 
            (SELECT count(incident.station) 
            from incident 
            WHERE incident.station = police_station.id and 
            incident.received_at BETWEEN '" . $day . " 00:00:00' and '" . $day . " 23:59:59') as jumlah 
            FROM police_station, incident");
        return $query->result();
    }
}
        
