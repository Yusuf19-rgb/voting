<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->model('M_login');
		$this->load->model('M_pengaturan','mset');
	}

	public function index()
	{
		$this->load->view('login');
	}

	function aksi_login(){
		$sekolah = ($this->input->post('sekolah')==='smk') ? 'smk' : 'mts';
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password
			);
		$where2 = array(
			'nis' => $username,
			'password' =>  ($password)
			);
		$cek = $this->M_login->cek_login("admin",$where)->num_rows();
		$cek2 = $this->M_login->cek_login("tb_siswa",$where2)->num_rows();
		$cek3 = $this->M_login->cek_login("tb_pengawas",$where)->num_rows();
		if($cek > 0){
 
			$data_session = array(
				'id' => "admin1",
				'nama' => $username,
				'status' => "loginadmin"
				);
 
			$this->session->set_userdata($data_session);
						$this->session->set_userdata('sekolah', $sekolah);
 
			redirect(base_url("Dasbor"));
 
		}else if($cek2 > 0){
		if($this->mset->voting_selesai()){
			redirect(base_url('?pesan=selesai&sekolah='.$sekolah));
		}
 
 		$hasil=$this->db->query("SELECT *  FROM tb_siswa where nis='$username'");
		foreach($hasil->result_array() as $i):
                                $k=$i['suara'];
                                $ab=$i['absen'];

                    if($ab!='0' && $k==0){
                    	$data_session = array(
							'nis' => $username,
							'nama' =>$i['namasiswa'],
							'status' => "loginsiswa"
							);
						$this->session->set_userdata($data_session);
						$this->session->set_userdata('sekolah', $sekolah);
						redirect(base_url("Form"));
                    }else if ($k==0 && $ab==0) {
                    	redirect(base_url("?pesan=belumabsen"));
                    }
                    else if ($k!='0' && $ab!='0') {
                    	redirect(base_url("?pesan=sudahmemilih"));
                    }
                    else{
                    	redirect(base_url("?pesan=gagal"));
                    }
		endforeach;
 
		}else if($cek3 > 0){
 
 		$hasil2=$this->db->query("SELECT *  FROM tb_pengawas where username='$username'");
		foreach($hasil2->result_array() as $i2):
                          
                    	$data_session = array(
                    		'id' => $i2['id'],
							'nama' =>$i2['namapengawas'],
							'status' => "loginpengawas"
							);
						$this->session->set_userdata($data_session);
						$this->session->set_userdata('sekolah', $sekolah);
						redirect(base_url("Pengawas"));
        
		endforeach;
 
		}else{
			redirect(base_url('?pesan=gagal'));
		}
	}
 
	function logout(){
		$sekolah = ($this->session->userdata('sekolah')==='smk') ? 'smk' : 'mts';
		$this->session->sess_destroy();
		redirect(base_url('?pesan=logout&sekolah='.$sekolah));	
	}
	
}