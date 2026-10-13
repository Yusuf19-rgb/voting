<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_calon','mc');
		$this->load->model('M_pengaturan','mset');
	}

	public function index()
	{
		$this->_cek_boleh_memilih();
		$x['data']=$this->mc->show_calon();
		$this->load->view('formpemilihan',$x);
	}
	public function pilih($id){
		$this->_cek_boleh_memilih(true);
		if($this->db->where('id',$id)->count_all_results('tb_calon')==0){
			redirect(base_url('Form'));
		}
		$result=$this->mc->pilihcalon($id);
		// if($result){
		// 	$this->session->set_flashdata('success_msg','Data berhasil diubah');
		// }else{
		// 	$this->session->set_flashdata('error_msg','Gagal mengubah data');
		// }
		redirect(base_url("?pesan=terimakasih"));
	}

	// Hanya pemilih yang login, voting belum selesai, dan belum memilih
	private function _cek_boleh_memilih($cek_suara=false){
		if($this->session->userdata('status')!='loginsiswa'){
			redirect(base_url('?pesan=belumlogin'));
		}
		if($this->mset->voting_selesai()){
			$sekolah=($this->session->userdata('sekolah')==='smk')?'smk':'mts';
			$this->session->sess_destroy();
			redirect(base_url('?pesan=selesai&sekolah='.$sekolah));
		}
		if($cek_suara){
			$q=$this->db->get_where('tb_siswa',array('nis'=>$this->session->userdata('nis')))->row_array();
			if(empty($q) || $q['suara']!='0'){
				redirect(base_url('?pesan=sudahmemilih'));
			}
		}
	}
}