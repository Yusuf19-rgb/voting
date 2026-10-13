
<?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
class M_pengawas extends CI_Model{	
	 function show_pengawas(){
            $hasil=$this->db->query("SELECT * FROM tb_pengawas");
            return $hasil;
      }  

	function insert_data(){
		$field = array(
			'id' => uniqid(),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'namapengawas' => $this->input->post('namapengawas')

		);
		$this->db->insert('tb_pengawas',$field);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function deletepengawas($id){
		$this->db->where('id',$id);
		$this->db->delete('tb_pengawas');


		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}	
	public function truncate(){
		$this->db->query('TRUNCATE TABLE tb_pengawas');
		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function editpengawas($id){
		$this->db->where('id',$id);
		$field = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'namapengawas' => $this->input->post('namapengawas')

		);
		$this->db->update('tb_pengawas',$field);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	}
}