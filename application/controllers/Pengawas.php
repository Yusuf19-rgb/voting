<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengawas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
            parent::__construct();
            $this->load->model('M_pemilih','mp');

      }
      public function index(){
            $x['data']=$this->mp->show_pemilih();
            $this->load->view('viewpengawas',$x);
      }
	public function edit($id){
		$result=$this->mp->editabsen($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Pengawas'));
	}
	public function editbatal($id){
		$result=$this->mp->editabsenbatal($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Pengawas'));
	}
	public function hasilpemilihan(){
			$this->load->model('M_calon','mc');
			$this->load->model('M_pengaturan','mset');
			$x['data']=$this->mc->show_calon();
			$x['vs']=$this->mset->ringkasan($this->mc->show_calon()->result_array());
            $x['datapemilih']=$this->mp->show_pemilih();
            $this->load->view('hasilpemilihanpeng',$x);
	}
}