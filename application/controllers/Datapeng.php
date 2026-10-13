<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datapeng extends CI_Controller {

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
            $this->load->model('M_pengawas','mp');

      }
      public function index(){
            $x['data']=$this->mp->show_pengawas();
            $this->load->view('datapengawas',$x);
      }

	function insert(){
		$result=$this->mp->insert_data();
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil ditambah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menambah data');
		}
		redirect(base_url('Datapeng'));
	}
	public function edit($id){
		$result=$this->mp->editpengawas($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Datapeng'));
	}
	public function delete($id){
		$result=$this->mp->deletepengawas($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil dihapus');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menghapus data');
		}
		redirect(base_url('Datapeng'));
	}
	public function hapussemua(){
		$result=$this->mp->truncate();
		redirect(base_url('Datapeng'));
	}
}
