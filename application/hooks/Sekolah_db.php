<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Memilih database sesuai sekolah (MTs / SMK).
 * Sekolah dibaca dari session (server-side, tidak bisa dipalsukan lewat cookie biasa).
 * Saat proses login, sekolah diambil dari pilihan di form login.
 *   mts => grup database 'default'
 *   smk => grup database 'smk'  (lihat config/database.php)
 */
class Sekolah_db {

	public function pilih()
	{
		$CI =& get_instance();
		$sekolah = $CI->session->userdata('sekolah');

		if (strtolower($CI->router->class) === 'welcome' && strtolower($CI->router->method) === 'aksi_login') {
			$p = $CI->input->post('sekolah');
			if ($p === 'mts' || $p === 'smk') {
				$sekolah = $p;
			}
		}
		if ($sekolah !== 'smk') {
			$sekolah = 'mts';
		}

		if ($sekolah === 'smk') {
			$CI->db = $CI->load->database('smk', TRUE);
		}
	}
}