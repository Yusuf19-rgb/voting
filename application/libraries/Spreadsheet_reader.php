<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pembaca file spreadsheet sederhana (tanpa library eksternal).
 * Mendukung: .xlsx (butuh ekstensi PHP zip) dan .csv (pemisah koma / titik koma / tab).
 * Hasil: array baris, tiap baris berupa array sel (string), indeks mulai 0.
 */
class Spreadsheet_reader {

	public function read($path, $ext)
	{
		$ext = strtolower($ext);
		if ($ext === 'xlsx') {
			return $this->read_xlsx($path);
		}
		if ($ext === 'csv' || $ext === 'txt') {
			return $this->read_csv($path);
		}
		throw new Exception('Format file tidak didukung. Gunakan .xlsx atau .csv');
	}

	/* ---------------------------------------------------------- CSV */
	private function read_csv($path)
	{
		$content = file_get_contents($path);
		if ($content === false) {
			throw new Exception('File tidak dapat dibaca.');
		}
		// Buang BOM UTF-8
		if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
			$content = substr($content, 3);
		}
		// Konversi ke UTF-8 bila file berasal dari Excel lama (Windows-1252)
		if (!preg_match('//u', $content)) {
			$content = function_exists('mb_convert_encoding')
				? mb_convert_encoding($content, 'UTF-8', 'Windows-1252')
				: utf8_encode($content);
		}

		// Deteksi pemisah dari baris pertama
		$first = strtok($content, "\r\n");
		$delims = array(';' => substr_count($first, ';'), ',' => substr_count($first, ','), "\t" => substr_count($first, "\t"));
		arsort($delims);
		$delim = key($delims);
		if ($delims[$delim] == 0) {
			$delim = ',';
		}

		$rows = array();
		$fh = fopen('php://temp', 'r+');
		fwrite($fh, $content);
		rewind($fh);
		while (($r = fgetcsv($fh, 0, $delim)) !== false) {
			$rows[] = $r;
		}
		fclose($fh);
		return $rows;
	}

	/* ---------------------------------------------------------- XLSX */
	private function read_xlsx($path)
	{
		if (!class_exists('ZipArchive')) {
			throw new Exception('Ekstensi PHP "zip" belum aktif di server. Simpan file Excel sebagai CSV lalu import ulang.');
		}
		$zip = new ZipArchive();
		if ($zip->open($path) !== true) {
			throw new Exception('File .xlsx rusak atau bukan file Excel yang valid.');
		}

		// Shared strings
		$shared = array();
		$xml = $zip->getFromName('xl/sharedStrings.xml');
		if ($xml !== false) {
			$sx = @simplexml_load_string($xml);
			if ($sx) {
				foreach ($sx->si as $si) {
					$shared[] = $this->si_text($si);
				}
			}
		}

		// Cari file sheet pertama sesuai urutan di workbook
		$sheetFile = $this->first_sheet_file($zip);
		$xml = $zip->getFromName($sheetFile);
		$zip->close();
		if ($xml === false) {
			throw new Exception('Sheet pertama pada file Excel tidak ditemukan.');
		}
		$sx = @simplexml_load_string($xml);
		if (!$sx) {
			throw new Exception('Isi sheet Excel tidak dapat dibaca.');
		}

		$rows = array();
		foreach ($sx->sheetData->row as $row) {
			$cells = array();
			$maxCol = -1;
			foreach ($row->c as $c) {
				$col = $this->col_index((string) $c['r']);
				$type = (string) $c['t'];
				if ($type === 's') {
					$idx = (int) $c->v;
					$val = isset($shared[$idx]) ? $shared[$idx] : '';
				} elseif ($type === 'inlineStr') {
					$val = $this->si_text($c->is);
				} else {
					$val = (string) $c->v;
					// Angka bulat disimpan Excel seperti "7" / "1.0E3"; rapikan
					if ($type === '' && $val !== '' && is_numeric($val) && floor((float) $val) == (float) $val && abs((float) $val) < 1e15) {
						$val = sprintf('%.0f', (float) $val);
					}
				}
				$cells[$col] = $val;
				if ($col > $maxCol) $maxCol = $col;
			}
			$line = array();
			for ($i = 0; $i <= $maxCol; $i++) {
				$line[$i] = isset($cells[$i]) ? $cells[$i] : '';
			}
			$r = (int) $row['r'];
			// Pertahankan nomor baris asli agar laporan error sesuai nomor baris di Excel
			if ($r > 0) {
				$rows[$r - 1] = $line;
			} else {
				$rows[] = $line;
			}
		}
		// Isi baris kosong yang hilang agar indeks berurutan
		if (!empty($rows)) {
			$max = max(array_keys($rows));
			$out = array();
			for ($i = 0; $i <= $max; $i++) {
				$out[] = isset($rows[$i]) ? $rows[$i] : array();
			}
			// Buang baris kosong di bagian akhir (sisa pemformatan Excel)
			while (!empty($out)) {
				$last = end($out);
				if (trim(implode('', (array) $last)) !== '') break;
				array_pop($out);
			}
			return $out;
		}
		return $rows;
	}

	private function si_text($si)
	{
		if (isset($si->t)) {
			return (string) $si->t;
		}
		$text = '';
		if (isset($si->r)) {
			foreach ($si->r as $r) {
				$text .= (string) $r->t;
			}
		}
		return $text;
	}

	private function first_sheet_file($zip)
	{
		$wb = $zip->getFromName('xl/workbook.xml');
		$rels = $zip->getFromName('xl/_rels/workbook.xml.rels');
		if ($wb !== false && $rels !== false) {
			$wbx = @simplexml_load_string($wb);
			$rx = @simplexml_load_string($rels);
			if ($wbx && $rx && isset($wbx->sheets->sheet[0])) {
				$attrs = $wbx->sheets->sheet[0]->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships');
				$rid = (string) $attrs['id'];
				foreach ($rx->Relationship as $rel) {
					if ((string) $rel['Id'] === $rid) {
						$target = (string) $rel['Target'];
						return ltrim(strpos($target, '/') === 0 ? $target : 'xl/' . $target, '/');
					}
				}
			}
		}
		return 'xl/worksheets/sheet1.xml';
	}

	private function col_index($ref)
	{
		$letters = preg_replace('/[^A-Z]/', '', strtoupper($ref));
		$n = 0;
		for ($i = 0; $i < strlen($letters); $i++) {
			$n = $n * 26 + (ord($letters[$i]) - 64);
		}
		return $n - 1;
	}
}
