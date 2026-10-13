<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datapem extends CI_Controller {

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
            $this->load->view('datapemilih',$x);
      }
      public function export(){
            $x['data']=$this->mp->show_pemilih();
            $this->load->view('datapemilihexport',$x);
      }

	function insert(){
		$result=$this->mp->insert_data();
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil ditambah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menambah data');
		}
		redirect(base_url('Datapem'));
	}
	public function edit($id){
		$result=$this->mp->editsiswa($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Datapem'));
	}
	public function delete($id){
		$result=$this->mp->deletesiswa($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil dihapus');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menghapus data');
		}
		redirect(base_url('Datapem'));
	}
	public function resetpilihan($id){
		$result=$this->mp->reset($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data pemilih berhasil direset');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mereset data pemilih');
		}
		redirect(base_url('Datapem'));
	}
	public function hapussemua(){
		$result=$this->mp->truncate();
		redirect(base_url('Datapem'));
	}
	public function edita($id){
		$result=$this->mp->editabsen($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Datapem'));
	}
	public function editbatal($id){
		$result=$this->mp->editabsenbatal($id);
		if($result){
			$this->session->set_flashdata('success_msg','Data berhasil diubah');
		}else{
			$this->session->set_flashdata('error_msg','Gagal mengubah data');
		}
		redirect(base_url('Datapem'));
	}

	/**
	 * Import data pemilih dari file Excel (.xlsx) / CSV
	 */
	public function import(){
		if($this->session->userdata('status')!='loginadmin'){
			redirect(base_url('?pesan=belumlogin'));
		}
		if($this->input->method()!=='post'){
			redirect(base_url('Datapem'));
		}

		$mode = ($this->input->post('mode')=='perbarui') ? 'perbarui' : 'lewati';

		if(!isset($_FILES['file_import']) || $_FILES['file_import']['error']==UPLOAD_ERR_NO_FILE){
			$this->session->set_flashdata('error_msg','Pilih file terlebih dahulu');
			redirect(base_url('Datapem'));
		}
		if($_FILES['file_import']['error']!==UPLOAD_ERR_OK){
			$this->session->set_flashdata('error_msg','Upload gagal (kode '.$_FILES['file_import']['error'].'). Pastikan ukuran file tidak terlalu besar.');
			redirect(base_url('Datapem'));
		}

		$ext = strtolower(pathinfo($_FILES['file_import']['name'], PATHINFO_EXTENSION));
		if(!in_array($ext, array('xlsx','csv'))){
			$this->session->set_flashdata('error_msg','Format file harus .xlsx atau .csv');
			redirect(base_url('Datapem'));
		}

		try{
			$this->load->library('Spreadsheet_reader');
			$rows = $this->spreadsheet_reader->read($_FILES['file_import']['tmp_name'], $ext);
		}catch(Exception $e){
			$this->session->set_flashdata('error_msg',$e->getMessage());
			redirect(base_url('Datapem'));
		}

		if(count($rows) > 5000){
			$this->session->set_flashdata('error_msg','Maksimal 5000 baris per import');
			redirect(base_url('Datapem'));
		}

		$res = $this->mp->import_rows($rows, $mode);

		if($res['tambah']==0 && $res['update']==0 && $res['gagal']==0 && $res['lewati']==0){
			$this->session->set_flashdata('error_msg','File kosong, tidak ada data yang dapat diimport');
			redirect(base_url('Datapem'));
		}

		$ringkas = 'Import selesai: '.$res['tambah'].' ditambah';
		if($res['update']>0){ $ringkas .= ', '.$res['update'].' diperbarui'; }
		if($res['lewati']>0){ $ringkas .= ', '.$res['lewati'].' dilewati (ID sudah ada)'; }
		if($res['gagal']>0){ $ringkas .= ', '.$res['gagal'].' gagal'; }

		if($res['gagal']>0 || !empty($res['fatal'])){
			$this->session->set_flashdata('error_msg',$ringkas);
		}else{
			$this->session->set_flashdata('success_msg',$ringkas);
		}
		if(!empty($res['errors'])){
			$this->session->set_flashdata('import_errors', array_slice($res['errors'],0,50));
			$this->session->set_flashdata('import_errors_total', count($res['errors']));
		}
		redirect(base_url('Datapem'));
	}

	/**
	 * Hapus pemilih yang ditandai (checkbox)
	 */
	public function hapusterpilih(){
		if($this->session->userdata('status')!='loginadmin'){
			redirect(base_url('?pesan=belumlogin'));
		}
		$ids = $this->input->post('ids');
		if($this->input->method()!=='post' || empty($ids) || !is_array($ids)){
			$this->session->set_flashdata('error_msg','Tidak ada pemilih yang ditandai');
			redirect(base_url('Datapem'));
		}
		$n = $this->mp->hapus_banyak($ids);
		if($n>0){
			$this->session->set_flashdata('success_msg',$n.' data pemilih berhasil dihapus');
		}else{
			$this->session->set_flashdata('error_msg','Gagal menghapus data pemilih yang ditandai');
		}
		redirect(base_url('Datapem'));
	}
}
