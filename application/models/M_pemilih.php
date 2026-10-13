<?php

class M_pemilih extends CI_Model{

      function show_pemilih(){
            $hasil=$this->db->query("SELECT * FROM tb_siswa");
            return $hasil;
      }  


	function insert_data(){
		$kelas = $this->gabung_kelas($this->input->post('kelas'), $this->input->post('ruang'));
		if ($kelas === '') { return false; }
		$field = array(
			'id' => uniqid(),
			'nis' => $this->input->post('nis'),
			'password' => ($this->input->post('password')),
			'namasiswa' => $this->input->post('nama'),
			'kelas' => $kelas,
			'suara' => '0',
			'absen' => '0'

		);
		$this->db->insert('tb_siswa',$field);
		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function deletesiswa($id){
		$hasil=$this->db->query("SELECT suara  FROM tb_siswa where id='$id'");
		foreach($hasil->result_array() as $i):
                                $k=$i['suara'];

        $hasil2=$this->db->query("SELECT totalsuara  FROM tb_calon where id='$k'");
		foreach($hasil2->result_array() as $i):
                                $l=$i['totalsuara'];
                                $l=$l-1;

		$this->db->query("UPDATE tb_calon set totalsuara='$l' where id='$k'");
		endforeach;
		endforeach;
		
		$this->db->where('id',$id);
		$this->db->delete('tb_siswa');


		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}	
	public function truncate(){
		$this->db->query('TRUNCATE TABLE tb_siswa');

		$hasil=$this->db->query("SELECT *  FROM tb_calon");
		foreach($hasil->result_array() as $i):
                                $b=$i['id'];
        $this->db->query("UPDATE tb_calon set totalsuara='0' where id='$b'");
        endforeach;

		if($this->db->affected_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function editsiswa($id){
		$kelas = $this->gabung_kelas($this->input->post('kelas'), $this->input->post('ruang'));
		if ($kelas === '') { return false; }
		$this->db->where('id',$id);
		$field = array(
			'namasiswa' => $this->input->post('nama'),
			'kelas' => $kelas,
		);
		$this->db->update('tb_siswa',$field);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	}
	public function editabsen($id){
		$pengaw=$this->session->userdata('id');
        $field = array(
			'absen' => $id
		);

		$this->db->where('id',$id);
		$this->db->update('tb_siswa',$field);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	}
	public function editabsenbatal($id){
		$this->db->where('id',$id);
		$field = array(
			'absen' => '0'
		);
		$this->db->update('tb_siswa',$field);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}

	}
	public function reset($id){

		$hasil=$this->db->query("SELECT suara  FROM tb_siswa where id='$id'");
		foreach($hasil->result_array() as $i):
                                $k=$i['suara'];

        $hasil2=$this->db->query("SELECT totalsuara  FROM tb_calon where id='$k'");
		foreach($hasil2->result_array() as $i):
                                $l=$i['totalsuara'];
                                $l=$l-1;

		$this->db->query("UPDATE tb_calon set totalsuara='$l' where id='$k'");
		endforeach;
		endforeach;

		$this->db->where('id',$id);
		$field = array(
			'suara' => '0',
		);
		$this->db->update('tb_siswa',$field);

		if ($this->db->affected_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	/* ------------------------------------------------------------------
	 * IMPORT PEMILIH
	 * ------------------------------------------------------------------ */
	/**
	 * Sekolah aktif (dari session): 'mts' atau 'smk'.
	 * MTs : kelas 7-9  | SMK : kelas 10-12 | keduanya + "Guru".
	 * Kelas + ruang disimpan dalam satu kolom `kelas`, mis. "7A" / "10B".
	 */
	public function sekolah()
	{
		return ($this->session->userdata('sekolah') === 'smk') ? 'smk' : 'mts';
	}

	public function label_sekolah()
	{
		return ($this->sekolah() === 'smk') ? 'SMK' : 'MTs';
	}

	public function daftar_kelas()
	{
		return ($this->sekolah() === 'smk') ? array('10','11','12') : array('7','8','9');
	}

	public function template_import()
	{
		return ($this->sekolah() === 'smk') ? 'template_import_pemilih_smk.xlsx' : 'template_import_pemilih.xlsx';
	}

	// Jumlah digit angka kelas (MTs 1 digit, SMK 2 digit)
	private function digit_kelas()
	{
		return ($this->sekolah() === 'smk') ? 2 : 1;
	}

	/** Pecah nilai tersimpan ("10B") menjadi array(kelas, ruang). Guru => array('Guru',''). */
	public function pecah_kelas($kelas)
	{
		if ($kelas === 'Guru') { return array('Guru', ''); }
		$n = $this->digit_kelas();
		return array(substr($kelas, 0, $n), (string) substr($kelas, $n));
	}

	private $romawi = array('I'=>'1','II'=>'2','III'=>'3','IV'=>'4','V'=>'5','VI'=>'6','VII'=>'7','VIII'=>'8','IX'=>'9','X'=>'10','XI'=>'11','XII'=>'12');

	/**
	 * Gabungkan kelas + ruang. Mengembalikan "" bila tidak valid.
	 * $kelas boleh berisi "7", "VII", atau langsung "7A" / "7-A" / "VII A" (ruang boleh kosong).
	 */
	public function gabung_kelas($kelas, $ruang = '')
	{
		$kelas = strtoupper(trim((string) $kelas));
		$ruang = strtoupper(preg_replace('/[\s\-_.\/]+/', '', (string) $ruang));
		if ($kelas === '') { return ''; }
		// Guru bukan bagian dari kelas/ruang
		if ($kelas === 'GURU') { return 'Guru'; }

		if (preg_match('/^(\d{' . $this->digit_kelas() . '}|[IVX]+)[\s\-_.\/]*([A-Z0-9]{0,5})$/', $kelas, $m)) {
			$k = $m[1];
			if (isset($this->romawi[$k])) { $k = $this->romawi[$k]; }
			if (!in_array($k, $this->daftar_kelas(), true)) { return ''; }
			$r = $m[2] . $ruang; // ruang dari kolom kelas + kolom ruang
			if (strlen($r) > 5) { return ''; }
			return $k . $r;
		}
		return '';
	}

	/**
	 * Proses baris hasil baca spreadsheet.
	 * $mode: 'lewati' (ID yang sudah ada dilewati) atau 'perbarui' (nama & kelas diperbarui).
	 * Kolom: ID | Password (boleh kosong => sama dengan ID) | Nama Pemilih | Kelas (7-9) | Ruang (boleh kosong)
	 * Mengembalikan array: tambah, update, lewati, gagal, errors[]
	 */
	public function import_rows($rows, $mode)
	{
		$res = array('tambah' => 0, 'update' => 0, 'lewati' => 0, 'gagal' => 0, 'errors' => array());

		// ID yang sudah ada di database
		$ada = array();
		foreach ($this->db->query("SELECT id, nis FROM tb_siswa")->result_array() as $r) {
			$ada[strtolower($r['nis'])] = $r['id'];
		}

		$batch = array();
		$updates = array();
		$dalam_file = array();
		$mulai = 0;

		// Lewati baris judul jika ada
		foreach ($rows as $i => $r) {
			if ($this->row_empty($r)) { continue; }
			$c0 = strtolower(trim(isset($r[0]) ? $r[0] : ''));
			if ($c0 === 'id' || $c0 === 'nis' || $c0 === 'id pemilih') { $mulai = $i + 1; }
			break;
		}

		for ($i = $mulai; $i < count($rows); $i++) {
			$r = $rows[$i];
			if ($this->row_empty($r)) { continue; }
			$no = $i + 1; // nomor baris seperti di Excel

			$nis   = trim(isset($r[0]) ? $r[0] : '');
			$pass  = trim(isset($r[1]) ? $r[1] : '');
			$nama  = trim(preg_replace('/\s+/', ' ', isset($r[2]) ? $r[2] : ''));
			$kls   = trim(isset($r[3]) ? $r[3] : '');
			$ruang = trim(isset($r[4]) ? $r[4] : '');
			$kelas = $this->gabung_kelas($kls, $ruang);

			$err = '';
			if ($nis === '') {
				$err = 'ID kosong';
			} elseif (strlen($nis) > 18) {
				$err = 'ID lebih dari 18 karakter';
			} elseif (strlen($pass) > 50) {
				$err = 'Password lebih dari 50 karakter';
			} elseif ($nama === '') {
				$err = 'Nama pemilih kosong';
			} elseif (strlen($nama) > 50) {
				$err = 'Nama lebih dari 50 karakter';
			} elseif ($kelas === '') {
				$dk = $this->daftar_kelas();
				$err = 'Kelas "' . trim($kls . ' ' . $ruang) . '" tidak valid (kelas harus ' . $dk[0] . '-' . $dk[2] . ' atau Guru, ruang maks. 5 huruf/angka, mis. ' . $dk[0] . ' A)';
			}

			if ($err === '') {
				$key = strtolower($nis);
				if (isset($dalam_file[$key])) {
					$err = 'ID ganda di dalam file (sudah ada di baris ' . $dalam_file[$key] . ')';
				}
			}

			if ($err !== '') {
				$res['gagal']++;
				$res['errors'][] = 'Baris ' . $no . ': ' . $err;
				continue;
			}

			$dalam_file[strtolower($nis)] = $no;

			if (isset($ada[strtolower($nis)])) {
				if ($mode === 'perbarui') {
					$updates[] = array('id' => $ada[strtolower($nis)], 'namasiswa' => $nama, 'kelas' => $kelas);
					$res['update']++;
				} else {
					$res['lewati']++;
				}
				continue;
			}

			$batch[] = array(
				'id'        => uniqid() . str_pad(count($batch), 3, '0', STR_PAD_LEFT),
				'nis'       => $nis,
				'password'  => ($pass === '' ? $nis : $pass),
				'namasiswa' => $nama,
				'kelas'     => $kelas,
				'suara'     => '0',
				'absen'     => '0'
			);
			$res['tambah']++;
		}

		$this->db->trans_start();
		foreach (array_chunk($batch, 200) as $chunk) {
			$this->db->insert_batch('tb_siswa', $chunk);
		}
		if (!empty($updates)) {
			$this->db->update_batch('tb_siswa', $updates, 'id');
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$res['tambah'] = 0;
			$res['update'] = 0;
			$res['errors'][] = 'Gagal menyimpan ke database. Tidak ada data yang diubah.';
			$res['fatal'] = true;
		}
		return $res;
	}

	private function row_empty($r)
	{
		foreach ((array) $r as $c) {
			if (trim((string) $c) !== '') { return false; }
		}
		return true;
	}
}