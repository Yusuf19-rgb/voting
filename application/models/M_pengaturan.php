<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengaturan pemilihan (disimpan di tabel tb_pengaturan, per database sekolah).
 * Tabel dibuat otomatis saat pertama kali dipakai, jadi tidak perlu import SQL.
 *
 * PENTING: jangan memakai $this->db di __construct(), karena database sekolah
 * (MTs/SMK) baru dipilih setelah controller selesai dibuat (lihat hooks/Sekolah_db.php).
 */
class M_pengaturan extends CI_Model {

	private $siap = false;

	private function pastikan_tabel()
	{
		if ($this->siap) { return; }
		$debug = $this->db->db_debug;
		$this->db->db_debug = FALSE;
		$this->db->query("CREATE TABLE IF NOT EXISTS `tb_pengaturan` (
			`nama` varchar(50) NOT NULL,
			`nilai` varchar(255) NOT NULL,
			PRIMARY KEY (`nama`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1");
		$this->db->db_debug = $debug;
		$this->siap = true;
	}

	public function ambil($nama, $default = '')
	{
		$this->pastikan_tabel();
		$debug = $this->db->db_debug;
		$this->db->db_debug = FALSE;
		$q = $this->db->query("SELECT nilai FROM tb_pengaturan WHERE nama = ?", array($nama));
		$this->db->db_debug = $debug;
		if ($q && $q->num_rows() > 0) {
			$r = $q->row_array();
			return $r['nilai'];
		}
		return $default;
	}

	public function simpan($nama, $nilai)
	{
		$this->pastikan_tabel();
		return $this->db->query(
			"INSERT INTO tb_pengaturan (nama, nilai) VALUES (?, ?) ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)",
			array($nama, $nilai)
		);
	}

	public function voting_selesai()
	{
		return $this->ambil('voting_status', 'buka') === 'selesai';
	}

	public function selesaikan()
	{
		$dt = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		$this->simpan('voting_selesai_pada', $dt->format('d-m-Y H:i') . ' WIB');
		return $this->simpan('voting_status', 'selesai');
	}

	public function buka_kembali()
	{
		$this->simpan('voting_selesai_pada', '');
		return $this->simpan('voting_status', 'buka');
	}

	/**
	 * Ringkasan hasil untuk ditampilkan di halaman hasil.
	 * $calon : array hasil show_calon()->result_array()
	 * Pemenang = calon dengan suara terbanyak (seri bila suara tertinggi sama dan > 0).
	 */
	public function ringkasan($calon)
	{
		$total = 0;
		$max = 0;
		foreach ($calon as $c) {
			$total += (int) $c['totalsuara'];
			if ((int) $c['totalsuara'] > $max) { $max = (int) $c['totalsuara']; }
		}
		$ids = array();
		$nama = array();
		if ($max > 0) {
			foreach ($calon as $c) {
				if ((int) $c['totalsuara'] === $max) {
					$ids[] = $c['id'];
					$nama[] = $c['namacalon'];
				}
			}
		}
		$selesai = $this->voting_selesai();
		return array(
			'selesai'      => $selesai,
			'selesai_pada' => $selesai ? $this->ambil('voting_selesai_pada', '') : '',
			'total_suara'  => $total,
			'pemenang_id'  => $selesai ? $ids : array(),
			'pemenang'     => $nama,
			'seri'         => (count($ids) > 1)
		);
	}
}