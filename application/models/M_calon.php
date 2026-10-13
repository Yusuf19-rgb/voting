<?php

class M_calon extends CI_Model{

	private $_table = "tb_calon";

    public $id;
    public $namacalon;
	public $visi;
	public $misi;
    public $foto = "default.jpg";
      function show_calon(){

            $hasil=$this->db->query("SELECT * FROM tb_calon");
            return $hasil;

      }   
      function insert_data(){
		$post = $this->input->post();
		$this->id = uniqid();
        $this->namacalon = $post["namacalon"];
        $this->visi = $post["visi"];
        $this->misi = $post["misi"];
        $this->foto = $this->_uploadImage();
        $this->db->insert('tb_calon', $this);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function deletecalon($id){
		$hasil=$this->db->query("SELECT *  FROM tb_siswa");
		foreach($hasil->result_array() as $i):
								$r=$i['id'];
                                $k=$i['suara'];
        if ($k==$id) {
        	$this->db->query("UPDATE tb_siswa set suara='0' where id='$r'");
        };
		endforeach;

		$this->db->where('id',$id);
		$this->db->delete('tb_calon');
		// $this->_deleteImage($id);
		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function truncate(){
		$hasil=$this->db->query("SELECT *  FROM tb_siswa");
		foreach($hasil->result_array() as $i):
                                $b=$i['id'];
        $this->db->query("UPDATE tb_siswa set suara='0' where id='$b'");
        endforeach;

		$this->db->query('TRUNCATE TABLE tb_calon');
		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function editcalon($id){
		$this->db->where('id',$id);
		$post = $this->input->post();
		$this->id = uniqid();
        $this->namacalon = $post["namacalon"];
        $this->visi = $post["visi"];
        $this->misi = $post["misi"];
        if (!empty($_FILES["foto"]["name"])) {
			$this->foto = $this->_uploadImage();
		} else {
			$this->foto = $post["old_image"];
		};
		$this->db->update('tb_calon', $this);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	} 

	public function pilihcalon($id){

		$hasil=$this->db->query("SELECT totalsuara  FROM tb_calon where id='$id'");
		foreach($hasil->result_array() as $i):
                                $k=$i['totalsuara'];
                                $k=$k+1;
		$this->db->query("UPDATE tb_calon set totalsuara='$k' where id='$id'");
		endforeach;


		$loginnis=$this->session->userdata('nis');
		$field2 = array(
			'suara' => $id
		);
		$this->db->where('nis',$loginnis);
		$this->db->update('tb_siswa',$field2);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	}
// 	private function _uploadImage()
// {
// 	$data=$this->input->post();
//     $config['upload_path']          = './upload';
//     $config['allowed_types']        = 'gif|jpg|png';
//     $config['file_name']            = $data['upfoto'];
//     $config['overwrite']			= true;

//     $this->load->library('upload', $config);
//     $hasil=$this->upload->do_upload('upfoto');

//     if ($hasil) {
//         return $this->upload->$hasil("file_name");
//     }else
//     return "default.jpg";
	

// 	}
private function _uploadImage()
	{
		$config['upload_path']          = './upload/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name']            = $this->id;
		$config['overwrite']			= true;
		// $config['max_size']             = 1024; // 1MB
    // $config['max_width']            = 1024;
    // $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('upfoto')) {
        return $this->upload->data("file_name");
    }
    
    return "default.jpg";
	}

	// private function _deleteImage($id)
	// {
	// 	$product = $this->$id;
	// 	if ($product->image != "default.jpg") {
	// 		$filename = explode(".", $product->image)[0];
	// 		return array_map('unlink', glob(FCPATH."upload/$filename.*"));
	// 	}
	// }

}