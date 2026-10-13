<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasilpilih extends CI_Controller {
	function __construct(){
            parent::__construct();
            $this->load->model('M_calon','mc');
            $this->load->model('M_pemilih','mp');
            $this->load->model('M_pengaturan','mset');
      }
      public function index(){
            $x['data']=$this->mc->show_calon();
            $x['datapemilih']=$this->mp->show_pemilih();
            $x['vs']=$this->mset->ringkasan($this->mc->show_calon()->result_array());
            $this->load->view('hasilpemilihan',$x);
      }
      public function export(){
            $x['data']=$this->mc->show_calon();
            $x['datapemilih']=$this->mp->show_pemilih();
            $x['vs']=$this->mset->ringkasan($this->mc->show_calon()->result_array());
            $this->load->view('hasilpemilihanexport',$x);
      }

      // Selesaikan voting: pemilih tidak bisa memilih lagi, hasil menjadi final
      public function selesai(){
            if($this->session->userdata('status')!='loginadmin' || $this->input->method()!=='post'){
                  redirect(base_url('?pesan=belumlogin'));
            }
            $this->mset->selesaikan();
            $this->session->set_flashdata('success_msg','Voting telah diselesaikan. Hasil pemilihan sudah final.');
            redirect(base_url('Hasilpilih'));
      }
      // Buka kembali voting (bila diselesaikan terlalu cepat)
      public function bukakembali(){
            if($this->session->userdata('status')!='loginadmin' || $this->input->method()!=='post'){
                  redirect(base_url('?pesan=belumlogin'));
            }
            $this->mset->buka_kembali();
            $this->session->set_flashdata('success_msg','Voting dibuka kembali.');
            redirect(base_url('Hasilpilih'));
      }
}