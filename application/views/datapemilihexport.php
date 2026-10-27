<?php
// Hanya admin yang login
$login=$this->session->userdata('status');
if($login=='loginsiswa' || $login=='loginpengawas'){
    redirect(base_url('?pesan=salah'));
}else if($login!='loginadmin'){
    redirect(base_url('?pesan=belumlogin'));
}

// Sekolah aktif -> nama organisasi & logo kartu
$smk       = ($this->session->userdata('sekolah')==='smk');
$organisasi = $smk ? 'OSIS SMK Bustanul Thullab' : 'OSIM MTs Bustanul Thullab';
$logo       = base_url('images/'.($smk ? 'logo_osis.png' : 'logo_osim.png'));
$alamat     = rtrim(preg_replace('#^https?://#','',base_url()),'/');

// Urutkan per kelas lalu nama, supaya mudah dibagikan per kelas
$daftar = $data->result_array();
usort($daftar, function($a,$b){
    $c = strnatcasecmp($a['kelas'],$b['kelas']);
    return ($c!==0) ? $c : strnatcasecmp($a['namasiswa'],$b['namasiswa']);
});
if(!function_exists('e_kartu')){ function e_kartu($t){ return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); } }
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartu Pemilih - <?php echo e_kartu($organisasi); ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.png'); ?>">
    <style>
        @page { size: A4; margin: 8mm; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #1d2b3a; background: #f3f6f4; }

        /* bilah atas (tidak ikut tercetak) */
        .bar { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; padding: 12px 18px; background: #fff; border-bottom: 1px solid #dfe7e2; }
        .bar h1 { font-size: 18px; margin: 0; flex: 1 1 auto; }
        .bar small { color: #6b7a8a; display: block; font-weight: normal; font-size: 12px; margin-top: 2px; }
        .bar a, .bar button { font-family: inherit; font-size: 14px; font-weight: 600; padding: 9px 16px; border-radius: 10px; border: 0; cursor: pointer; text-decoration: none; }
        .bar .cetak { background: #14783a; color: #fff; }
        .bar .cetak:hover { background: #0b4a26; }
        .bar .kembali { background: #eaf2ec; color: #14783a; }
        .bar .kembali:hover { background: #cfe3d6; }

        /* lembar kartu: 3 kolom x 6 baris = 18 kartu per halaman A4 */
        .lembar { display: grid; grid-template-columns: repeat(3, 1fr); width: 194mm; margin: 14px auto; background: #fff; }
        .kartu { height: 46mm; padding: 2.5mm 3mm 2mm; border: 1px dashed #8a948f; display: flex; flex-direction: column; page-break-inside: avoid; break-inside: avoid; overflow: hidden; }
        .kartu-atas { display: flex; align-items: center; gap: 6px; padding-bottom: 3px; border-bottom: 2px solid #14783a; }
        .kartu-atas img { height: 7mm; width: auto; }
        .kartu-atas .judul { font-size: 8.5px; line-height: 1.25; color: #4c5c54; }
        .kartu-atas .judul b { display: block; font-size: 10.5px; color: #14783a; letter-spacing: .5px; }
        .kartu-nama { margin-top: 3px; font-size: 11.5px; font-weight: 700; line-height: 1.2; max-height: 2.4em; overflow: hidden; text-transform: uppercase; }
        .kartu-kelas { font-size: 9px; color: #6b7a8a; margin: 1px 0 3px; }
        .kartu-akun { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; }
        .kartu-akun div { border: 1px solid #14783a; border-radius: 5px; padding: 2px 5px; background: #f3faf5; }
        .kartu-akun span { display: block; font-size: 7.5px; color: #6b7a8a; text-transform: uppercase; letter-spacing: .5px; }
        .kartu-akun b { display: block; font-family: "Courier New", Courier, monospace; font-size: 13px; letter-spacing: .3px; word-break: break-all; }
        .kartu-bawah { margin-top: auto; font-size: 7px; color: #4c5c54; line-height: 1.3; text-align: center; }
        .kosong { padding: 40px; text-align: center; color: #6b7a8a; }

        @media print {
            body { background: #fff; }
            .bar { display: none; }
            .lembar { margin: 0; width: 100%; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="bar">
    <h1>Kartu Pemilih &middot; <?php echo e_kartu($organisasi); ?>
        <small><?php echo count($daftar); ?> kartu &middot; 18 kartu per lembar A4 &middot; gunting mengikuti garis putus-putus &middot; urut per kelas</small>
    </h1>
    <a class="kembali" href="<?php echo base_url('Datapem'); ?>">&larr; Kembali</a>
    <button class="cetak" type="button" onclick="window.print()">Cetak Kartu</button>
</div>

<?php if(empty($daftar)){ ?>
    <div class="kosong">Belum ada data pemilih.</div>
<?php } else { ?>
<div class="lembar">
    <?php foreach($daftar as $i){ ?>
    <div class="kartu">
        <div class="kartu-atas">
            <img src="<?php echo $logo; ?>" alt="" onerror="logoGagal(this)">
            <div class="judul"><b>KARTU PEMILIH</b><?php echo e_kartu($organisasi); ?></div>
        </div>
        <div class="kartu-nama"><?php echo e_kartu($i['namasiswa']); ?></div>
        <div class="kartu-kelas"><?php echo ($i['kelas']==='Guru') ? 'Guru' : 'Kelas '.e_kartu($i['kelas']); ?></div>
        <div class="kartu-akun">
            <div><span>ID</span><b><?php echo e_kartu($i['nis']); ?></b></div>
            <div><span>Password</span><b><?php echo e_kartu($i['password']); ?></b></div>
        </div>
        <div class="kartu-bawah">Buka <b><?php echo e_kartu($alamat); ?></b>, pilih <b><?php echo $smk ? 'SMK' : 'MTs'; ?></b>, masuk dengan ID &amp; password di atas. Rahasiakan kartu ini.</div>
    </div>
    <?php } ?>
</div>
<?php } ?>

<script>
    // Bila logo sekolah tidak ada di server: coba logo.png, kalau tetap gagal sembunyikan (agar tidak tercetak ikon rusak)
    function logoGagal(img) {
        if (!img.getAttribute('data-coba')) {
            img.setAttribute('data-coba', '1');
            img.src = '<?php echo base_url('images/logo.png'); ?>';
        } else {
            img.style.display = 'none';
        }
    }
</script>
<script>
    // Cetak otomatis setelah logo selesai dimuat
    window.addEventListener('load', function () { setTimeout(function () { window.print(); }, 300); });
</script>

</body>
</html>