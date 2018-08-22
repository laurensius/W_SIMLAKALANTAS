<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mod_user');
		$this->load->model('mod_incident');
		$this->load->model('mod_station');
		$this->load->model('mod_stage');
		$this->load->model('mod_notif');
		$this->load->model('mod_report');
		header('Content-type:json');
	}

	public function index(){
		echo "hi";
	}

	function verifikasi_web(){
        if($this->input->post()!=null){
            $data = array(
            "username" => $this->input->post('username'),
            "password" => md5($this->input->post('password')));
            $resultcek = $this->get_user_by_username($data["username"]);
            if($resultcek==null){
                $return = array(
                    "code" => "NOT FOUND",
                    "message" => "Username tidak terdaftar",
                    "severity" => "danger",
                    "data_user" => null
                );
            }else{
                $return = $this->matching($data,$resultcek);
            } 
        }else{
            $return = array(
                "code" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server",
                "severity"  => "danger",
                "data_user" => null
            );
        }
		echo json_encode(array("response"=>$return));
    }
    
    function get_user_by_username($data){
        return $this->mod_user->get_user_by_username($data);
    }
    
    function matching($data,$resultcek){
        if($data["username"] == $resultcek[0]->username && $data["password"] == $resultcek[0]->password){
            $code = "MATCH";
			$message = "Username dan password sesuai";
			$severity = "success";
			$this->buat_session($resultcek);
        }else{
            $code = "NOT MATCH";
            $message = "Username dan password tidak sesuai";
            $severity = "warning";
        }
        $return = array(
            "code" => $code,
            "message" => $message,
            "severity" => $severity,
            "data_user" => $resultcek
        );
        return $return;
    }

    function buat_session($resultcek){
        $waktu = date("Y-m-d H:i:s");
		$this->update_login_timestamp($resultcek[0]->id,array("last_login" => $waktu));
        $data_session = array(
            "session_appssystem_code"=>"SeCuRe".date("YmdHis")."#".date("YHmids"),
            "session_appssystem_id"=>$resultcek[0]->id,
            "session_appssystem_username"=>$resultcek[0]->username,
            "session_appssystem_full_name"=>$resultcek[0]->full_name,
            "session_appssystem_address"=>$resultcek[0]->address,
            "session_appssystem_phone"=>$resultcek[0]->phone,
            "session_appssystem_email"=>$resultcek[0]->email,
            "session_appssystem_last_login"=>$waktu
		);
        $this->session->set_userdata($data_session);
	}
	
	function update_login_timestamp($id,$data){
        $this->mod_user->update_login_timestamp($id,$data);
	}
	
	public function verifikasi(){ //postman
		if($this->input->post('username') == null && $this->input->post('password') == null){
			$login = file_get_contents('php://input');
			$json = json_decode($login);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server";
				$data_count = "0";
				$data = array();
				$username = null;
				$password = null;
			}else{
				$username = $json->username;
				$password = $json->password;
			}
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		}
		if($username != null && $password != null ){
			$check = $this->mod_user->is_registered($username);
			if(sizeof($check) > 0){
				if($check[0]->password == md5($password)){
					$severity = "success";
					$message = "Login berhasil";
					$data_count = (string)sizeof($check);
					$data = $check;
				}else{
					$severity = "warning";
					$message = "Nama pengguna dan kata sandi tidak sesuai";
					$data_count = "0";
					$data = array();
				}
			}else{
				$severity = "danger";
				$message = "Nama pengguna tidak terdaftar";
				$data_count = "0";
				$data = $check;
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data_count = "0";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data_count" => $data_count,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function user_register(){
		if($this->input->post('username') == null && 
		$this->input->post('password') == null && 
		$this->input->post('full_name') == null && 
		$this->input->post('address') == null && 
		$this->input->post('phone') == null && 
		$this->input->post('email') == null ){
			$insert = file_get_contents('php://input');
			$json = json_decode($insert);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server";
				$data = array();
				$username = null;
				$password = null;
				$full_name = null;
				$address = null;
				$phone = null;
				$email = null;
			}else{
				$username = $json->username;
				$password = $json->password;
				$full_name = $json->full_name;
				$address = $json->address;
				$phone = $json->phone;
				$email = $json->email;
			}
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$full_name = $this->input->post('full_name');
			$address = $this->input->post('address');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
		}
		if($username != null && $password != null && $full_name != null && 
		$address != null && $phone !=null && $email!=null){
			$waktu = date("Y-m-d H:i:s");
			$data_insert = array(
				"username" => $username,
				"password" => md5($password),
				"full_name" => $full_name,
				"address" => $address,
				"phone" => $phone,
				"email" => $email,
				"is_officer" => "false",
				"station" => "0",
				"last_login" => $waktu
			);
			$check = $this->mod_user->is_registered($username);
			if(sizeof($check) > 0){
				$severity = "warning";
				$message = "Nama pengguna sudah terdaftar";
				$data = array();
			}else{
				$insert_data = $this->mod_user->user_register($data_insert);
				if($insert_data > 0){
					$severity = "success";
					$message = "Registrasi berhasil";
					$data = array();
				}else{
					$severity = "warning";
					$message = "Registrasi gagal, silakan coba lagi";
					$data = array();
				}
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function profil_update(){
		if($this->uri->segment(3) != null){
			$detail = $this->mod_user->user_detail($this->uri->segment(3));
			if(sizeof($detail) > 0){
				//----------------
				if($this->input->post('password') == null && 
				$this->input->post('full_name') == null && 
				$this->input->post('address') == null && 
				$this->input->post('phone') == null && 
				$this->input->post('email') == null ){
					$insert = file_get_contents('php://input');
					$json = json_decode($insert);
					if($json == null){
						$severity = "warning";
						$message = "Tidak ada data dikirim ke server";
						$data = array();
						$password = null;
						$full_name = null;
						$address = null;
						$phone = null;
						$email = null;
					}else{
						$password = $json->password;
						$full_name = $json->full_name;
						$address = $json->address;
						$phone = $json->phone;
						$email = $json->email;
					}
				}else{
					$password = $this->input->post('password');
					$full_name = $this->input->post('full_name');
					$address = $this->input->post('address');
					$phone = $this->input->post('phone');
					$email = $this->input->post('email');
				}
				if($password != null && $full_name != null && 
				$address != null && $phone !=null && $email!=null){
					if($password != $detail[0]->password && md5($password) != $detail[0]->password){
						$password = md5($password);
					}
					$data_update = array(
						"password" => $password,
						"full_name" => $full_name,
						"address" => $address,
						"phone" => $phone,
						"email" => $email
					);
					$update_response = $this->mod_user->update_profil($this->uri->segment(3),$data_update);
					if($update_response > 0){
						$severity = "success";
						$message = "Update profil berhasil";
						$data = array();
					}else{
						$severity = "warning";
						$message = "Update profil gagal, silakan coba lagi";
						$data = array();
					}
				}else{
					$severity = "warning";
					$message = "Tidak ada data dikirim ke server";
					$data = array();
				}
				//--------------------
			}else{
				$severity = "warning";
				$message = "User tidak ditemukan";
				$data = array();
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada ID User dikirim ke server";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//_________________INCIDENT_________________INCIDENT_________________INCIDENT_________________
	public function incident_insert(){ //postman
		if($this->input->post('sender') == null && 
		$this->input->post('image') == null && 
		$this->input->post('description') == null && 
		$this->input->post('latitude') == null && 
		$this->input->post('longitude') == null && 
		$this->input->post('station') == null ){
			$insert = file_get_contents('php://input');
			$json = json_decode($insert);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server";
				$data = array();
				$sender = null;
				$image = null;
				$description = null;
				$latitude = null;
				$longitude = null;
				$station = null;
			}else{
				$sender = $json->sender;
				$image = $json->image;
				$description = $json->description;
				$latitude = $json->latitude;
				$longitude = $json->longitude;
				$station = $json->station;
			}
		}else{
			$sender = $this->input->post('sender');
			$image = $this->input->post('image');
			$description = $this->input->post('description');
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			$station = $this->input->post('station');
		}
		if($sender != null && $image != null && $description != null && 
		$latitude != null && $longitude !=null && $station!=null){
			$waktu = date("Y-m-d H:i:s");
			$data_insert = array(
				"sender" => $sender,
				"image" => $image,
				"description" => $description,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"received_at" => $waktu,
				"last_stage" => "1",
				"last_stage_datetime" => $waktu,
				"processed_by" => "0",	
				"station" => $station
			);
			$insert_data = $this->mod_incident->incident_insert($data_insert);
			if($insert_data > 0){
				$severity = "success";
				$message = "Laporan berhasil dikirim";
				$data = array();
			}else{
				$severity = "warning";
				$message = "Laporan gagal dikirim";
				$data = array();
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function incident_select_by_sender(){ //postman
		if($this->uri->segment(3) != null){
			$select = $this->mod_incident->incident_select_by_sender($this->uri->segment(3));
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function incident_select_by_station(){ //postman
		if($this->uri->segment(3) != null){
			$select = $this->mod_incident->incident_select_by_station($this->uri->segment(3));
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function incident_detail_full(){ //postman
		if($this->uri->segment(3) != null){
			$select_incident = $this->mod_incident->incident_detail($this->uri->segment(3));
			if(sizeof($select_incident) > 0){
				$select_sender = $this->mod_user->user_detail($select_incident[0]->sender);
				$select_officer = $this->mod_user->user_detail($select_incident[0]->processed_by);
				$select_stage = $this->mod_stage->stage_detail($select_incident[0]->last_stage);
				$select_station = $this->mod_station->station_detail($select_incident[0]->station);
			}else{
				$select_sender = array();
				$select_officer = array();
				$select_stage = array();
				$select_station = array();
			}
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => array(
					"incident" => $select_incident,
					"sender" => $select_sender,
					"officer" => $select_officer,
					"stage" => $select_stage,
					"station" => $select_station
				)
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function incident_select_by_station_stage(){ //postman
		if($this->uri->segment(3) != null && $this->uri->segment(4) != null){
			$parameter = array(
				"station" => $this->uri->segment(3),
				"last_stage" => $this->uri->segment(4)
			);
			$select = $this->mod_incident->incident_select_by_station_stage($parameter);
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	function incident_update_stage(){
		///3:id/4:stage/
		if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null){
			$parameter = array(
				"last_stage" => $this->uri->segment(4),
				"last_stage_datetime" => date("Y-m-d H:i:s"),
				"processed_by" => $this->uri->segment(5),
			);
			$select = $this->mod_incident->incident_update_stage($this->uri->segment(3) ,$parameter);
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}


	//_________________STATION_________________STATION_________________STATION_________________
	public function station_list(){ //postman
		$select = $this->mod_station->station_list();
		if(sizeof($select) > 0){
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Load data gagal",
				"data" => array()
			);
		}
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function station_detail(){ //
		if($this->uri->segment(3) != null){
			$select = $this->mod_station->station_detail($this->uri->segment(3));
			if(sizeof($select) > 0){
				$response = array(
					"severity" => "success",
					"message" => "Load data berhasil",
					"data" => $select
				);
			}else{
				$response = array(
					"severity" => "warning",
					"message" => "Load data gagal atau data tidak ditemukan",
					"data" => array()
				);
			}
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}
	
	//_________________NOTIF_________________NOTIF_________________NOTIF_________________
	public function notif_select_recent(){ //postman
		//$select = $this->mod_notif->notif_select_recent();
		if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null){
			$select = $this->mod_notif->notif_select_recent(
				$this->uri->segment(3),
				$this->uri->segment(4),
				$this->uri->segment(5)
			);
			if(sizeof($select) > 0){
				$response = array(
					"severity" => "success",
					"message" => "Load data berhasil",
					"data" => $select
				);
			}else{
				$response = array(
					"severity" => "warning",
					"message" => "Load data gagal atau data tidak ditemukan",
					"data" => array()
				);
			}
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}	
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function notif_detail(){ //
		if($this->uri->segment(3) != null){
			$select = $this->mod_notif->notif_detail($this->uri->segment(3));
			if(sizeof($select) > 0){
				$response = array(
					"severity" => "success",
					"message" => "Load data berhasil",
					"data" => $select
				);
			}else{
				$response = array(
					"severity" => "warning",
					"message" => "Load data gagal atau data tidak ditemukan",
					"data" => array()
				);
			}
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}		
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function notif_delete(){ //postman
		$this->mod_notif->notif_delete($this->uri->segment(3));
	}

//_________________REPORT_________________REPORT_________________REPORT_________________
	public function report_insert(){ //postman
		if($this->input->post('incident') == null && 
		$this->input->post('chronology') == null && 
		$this->input->post('accident_victim') == null && 
		$this->input->post('damage') == null && 
		$this->input->post('action') == null){
			$insert = file_get_contents('php://input');
			$json = json_decode($insert);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server!";
				$data = array();
				$incident = null;
				$chronology = null;
				$accident_victim = null;
				$damage = null;
				$action = null;
			}else{
				$incident = $json->incident;
				$chronology = $json->chronology;
				$accident_victim = $json->accident_victim;
				$damage = $json->damage;
				$action = $json->action;
			}
		}else{
			$incident = $this->input->post('incident');
			$chronology = $this->input->post('chronology');
			$accident_victim = $this->input->post('accident_victim');
			$damage = $this->input->post('damage');
			$action = $this->input->post('action');
		}
		if($incident != null && $chronology != null && $accident_victim != null && 
		$damage != null && $action !=null){
			$waktu = date("Y-m-d H:i:s");
			$data_insert = array(
				"incident" => $incident,
				"chronology" => $chronology,
				"accident_victim" => $accident_victim,
				"damage" => $damage,
				"action" => $action,
				"datetime" => $waktu
			);
			$insert_data = $this->mod_report->report_insert($data_insert);
			if($insert_data > 0){
				$severity = "success";
				$message = "Laporan berhasil dikirim";
				$data = array();
			}else{
				$severity = "warning";
				$message = "Laporan gagal dikirim";
				$data = array();
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	function report_select_by_station(){
		if($this->uri->segment(3) != null){
			$select = $this->mod_report->report_select_by_station($this->uri->segment(3));
			if(sizeof($select) > 0){
				$response = array(
					"severity" => "success",
					"message" => "Load data berhasil",
					"data" => $select
				);
			}else{
				$response = array(
					"severity" => "success",
					"message" => "Belum ada laporan",
					"data" => array()
				);
			}
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}	
		echo json_encode($response,JSON_PRETTY_PRINT);

	}

	function report_select_by_station_detail(){
		if($this->uri->segment(3) != null && $this->uri->segment(4) != null){
			$select = $this->mod_report->report_select_by_station_detail($this->uri->segment(3),$this->uri->segment(4));
			if(sizeof($select) > 0){
				$response = array(
					"severity" => "success",
					"message" => "Load data berhasil",
					"data" => $select
				);
			}else{
				$response = array(
					"severity" => "success",
					"message" => "Belum ada laporan",
					"data" => array()
				);
			}
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter URL tidak lengkap",
				"data" => array()
			);
		}	
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	function report_count_by_day(){
		if($this->uri->segment(3) != null){
			$day = $this->uri->segment(3);
		}else{
			$day = date("Y-m-d");
		}
		$select = $this->mod_report->report_count_by_day($day);
		if(sizeof($select) > 0){
			$response = array(
				"severity" => "success",
				"message" => "Load data berhasil",
				"data" => $select
			);
		}else{
			$response = array(
				"severity" => "success",
				"message" => "Belum ada laporan",
				"data" => array()
			);
		}
		echo json_encode($response,JSON_PRETTY_PRINT);
	}
}
