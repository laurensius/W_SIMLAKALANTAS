<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->logout_message = array(
			"severity" => "success",
			"message" => "Anda baru saja logout"
		);
		$this->login_message = array(
			"severity" => "success",
			"message" => "Selamat datang, silakan login"
		); 
		$this->login_danger = array(
			"severity" => "danger",
			"message" => "Anda tidak diperkenankan akses halaman ini tanpa login"
		); 

	}

	public function index(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header');
			$this->load->view('apps/body_template');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}

	public function laporan_polsek(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header');
			$this->load->view('apps/body_laporan_polsek');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}

	public function laporan_polsek_detail(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header');
			$this->load->view('apps/body_laporan_polsek_detail');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}

	public function laporan_polsek_cetak(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header_cetak');
			$this->load->view('apps/body_laporan_polsek_cetak');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}

	public function laporan_harian(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header');
			$this->load->view('apps/body_laporan_harian');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}

	public function laporan_harian_cetak(){
		if($this->session->userdata("session_appssystem_code")){
			$this->load->view('apps/header_cetak');
			$this->load->view('apps/body_laporan_harian_cetak');
		}else{
			$this->load->view('apps/login',$this->login_message);
		}
	}


	public function logout(){
		if($this->session->userdata("session_appssystem_code")){
			$this->session->sess_destroy();
		}
		header('location:'. site_url());
	}
}
