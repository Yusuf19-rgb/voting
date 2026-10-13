<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datacal extends CI_Controller {

	function __construct(){
            parent::__construct();
            $this->load->model('M_calon','mc');
      }
      public function index(){
            $x['data']=$this->mc->show_calon();
            $this->load->view('datacalon',$x);
      }

      function insert(){
		$result=$this->mc->insert_data();
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil ditambah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menambah data');
		}
		redirect(base_url('Datacal'));
	}
	public function edit($id){
		$result=$this->mc->editcalon($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Datacal'));
	}
	public function delete($id){
		$result=$this->mc->deletecalon($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil dihapus');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menghapus data');
		}
		redirect(base_url('Datacal'));}
	public function hapussemua(){
		$result=$this->mc->truncate();
		redirect(base_url('Datacal'));
	}
	
}
