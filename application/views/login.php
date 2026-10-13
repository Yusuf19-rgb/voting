<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | E-Voting OSIM &amp; OSIS</title>
    <meta name="description" content="Pemilihan Ketua OSIM / OSIS secara online">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/favicon.png">
    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet" type="text/css">

    <style>
        :root {
            --hijau: #14783a;
            --hijau-tua: #0b4a26;
            --hijau-muda: #1f9a4d;
            --emas: #f5b800;
            --tinta: #1d2b3a;
            --abu: #6b7a8a;
            --latar: #f3f8f4;
        }
        html, body { height: 100%; margin: 0; }
        body.edu { font-family: 'Poppins', 'Open Sans', Arial, sans-serif; background: var(--latar); color: var(--tinta); }
        .edu *, .edu *::before, .edu *::after { box-sizing: border-box; }

        .edu-wrap { display: grid; grid-template-columns: 1.1fr 1fr; min-height: 100vh; }

        /* ---------- Panel kiri (tema pendidikan) ---------- */
        .edu-hero {
            position: relative; overflow: hidden; color: #fff;
            padding: 48px 56px; display: flex; flex-direction: column; justify-content: center;
            background:
                radial-gradient(circle at 15% 12%, rgba(245,184,0,.22), transparent 38%),
                linear-gradient(145deg, var(--hijau-tua) 0%, var(--hijau) 55%, var(--hijau-muda) 100%);
        }
        /* garis seperti buku tulis */
        .edu-hero::before {
            content: ""; position: absolute; inset: 0; opacity: .10; pointer-events: none;
            background-image: repeating-linear-gradient(to bottom, transparent 0, transparent 35px, #fff 35px, #fff 36px);
        }
        .edu-hero::after {
            content: ""; position: absolute; left: 64px; top: 0; bottom: 0; width: 2px;
            background: rgba(255,120,120,.35); pointer-events: none;
        }
        .edu-hero > * { position: relative; z-index: 1; }

        .edu-badge {
            display: inline-flex; align-items: center; gap: 8px; align-self: flex-start;
            background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.28);
            padding: 7px 16px; border-radius: 999px; font-size: 13px; font-weight: 500; letter-spacing: .4px;
        }
        .edu-badge i { color: var(--emas); }
        .edu-badges { display: flex; flex-wrap: wrap; gap: 10px; align-self: flex-start; }
        .edu-badges .edu-badge { opacity: .6; transition: all .25s; }
        .edu-badges .edu-badge.aktif { opacity: 1; background: rgba(245,184,0,.22); border-color: var(--emas); box-shadow: 0 6px 18px rgba(0,0,0,.18); }
        .edu-hero h1 { font-size: 38px; line-height: 1.2; font-weight: 700; margin: 22px 0 12px; color: #fff; }
        .edu-hero h1 span { color: var(--emas); }
        .edu-hero p.lead-text { font-size: 15px; line-height: 1.7; max-width: 460px; color: rgba(255,255,255,.88); margin: 0 0 18px; }
        .edu-luber { display: flex; flex-wrap: wrap; gap: 10px; margin: 0 0 8px; padding: 0; list-style: none; }
        .edu-luber li {
            background: rgba(0,0,0,.16); border-radius: 10px; padding: 8px 14px; font-size: 13px; font-weight: 500;
        }
        .edu-luber li b { color: var(--emas); font-size: 15px; margin-right: 2px; }
        .edu-illus { width: 100%; max-width: 420px; margin: 18px 0 0; display: block; }

        /* ikon melayang */
        .edu-float { position: absolute; color: rgba(255,255,255,.16); animation: eduFloat 7s ease-in-out infinite; z-index: 0; }
        .edu-float.f1 { top: 9%;  right: 12%; font-size: 46px; }
        .edu-float.f2 { top: 30%; right: 5%;  font-size: 34px; animation-delay: -2s; }
        .edu-float.f3 { bottom: 14%; right: 14%; font-size: 40px; animation-delay: -4s; }
        .edu-float.f4 { bottom: 8%;  left: 18%;  font-size: 30px; animation-delay: -1s; }
        .edu-float.f5 { top: 6%;  left: 30%; font-size: 28px; animation-delay: -3s; }
        @keyframes eduFloat { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-14px) rotate(6deg); } }

        /* ---------- Panel kanan (form) ---------- */
        .edu-panel {
            display: flex; align-items: center; justify-content: center; padding: 32px 20px;
            background:
                radial-gradient(circle at 90% 8%, rgba(245,184,0,.16), transparent 30%),
                radial-gradient(circle at 5% 95%, rgba(20,120,58,.12), transparent 35%),
                var(--latar);
        }
        .edu-card {
            width: 100%; max-width: 430px; background: #fff; border-radius: 22px;
            padding: 34px 34px 26px; box-shadow: 0 18px 50px rgba(11,74,38,.14);
            border-top: 5px solid var(--emas);
        }
        .edu-logo { text-align: center; margin-bottom: 10px; }
        .edu-logo img { max-width: 100%; max-height: 74px; width: auto; height: auto; }
        .edu-card h2 { font-size: 22px; font-weight: 700; text-align: center; margin: 8px 0 4px; color: var(--tinta); }
        .edu-card p.sub { text-align: center; color: var(--abu); font-size: 13.5px; margin: 0 0 18px; }
        .edu-card .alert { font-size: 13.5px; border-radius: 10px; margin-bottom: 16px; }

        /* pilihan sekolah */
        .edu-seg { display: flex; gap: 4px; background: #eaf2ec; padding: 4px; border-radius: 12px; margin-bottom: 16px; }
        .edu-seg input { position: absolute; opacity: 0; pointer-events: none; }
        .edu-seg label {
            flex: 1; margin: 0; text-align: center; padding: 10px 8px; border-radius: 9px; cursor: pointer;
            font-weight: 600; font-size: 14px; color: var(--abu); transition: all .2s;
        }
        .edu-seg label i { margin-right: 6px; }
        .edu-seg input:checked + label { background: var(--hijau); color: #fff; box-shadow: 0 4px 12px rgba(20,120,58,.35); }
        .edu-seg input:focus-visible + label { outline: 3px solid var(--emas); outline-offset: 1px; }

        /* kolom isian */
        .edu-field { position: relative; margin-bottom: 14px; }
        .edu-field > i.ic { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #93a39a; font-size: 16px; pointer-events: none; }
        .edu-field input {
            width: 100%; height: 50px; padding: 0 46px 0 44px; font-size: 15px; font-family: inherit;
            border: 1.5px solid #dbe5de; border-radius: 12px; background: #f8fbf9; color: var(--tinta);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .edu-field input::placeholder { color: #9aa8a0; }
        .edu-field input:focus { outline: none; border-color: var(--hijau); background: #fff; box-shadow: 0 0 0 4px rgba(20,120,58,.14); }
        .edu-eye {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 38px; height: 38px;
            border: 0; background: transparent; color: #7d8d84; border-radius: 9px; cursor: pointer; font-size: 17px;
        }
        .edu-eye:hover { background: #eaf2ec; color: var(--hijau); }

        .edu-btn {
            width: 100%; height: 52px; margin-top: 6px; border: 0; border-radius: 12px; cursor: pointer;
            font-family: inherit; font-size: 15px; font-weight: 700; letter-spacing: .6px; color: #fff;
            background: linear-gradient(135deg, var(--hijau) 0%, var(--hijau-muda) 100%);
            box-shadow: 0 8px 20px rgba(20,120,58,.32); transition: transform .15s, box-shadow .15s;
        }
        .edu-btn:hover { transform: translateY(-1px); box-shadow: 0 12px 26px rgba(20,120,58,.4); }
        .edu-btn:active { transform: translateY(0); }
        .edu-btn i { margin-right: 8px; }

        .edu-foot { text-align: center; color: #98a69e; font-size: 12px; margin-top: 18px; }
        .edu-foot i { color: var(--emas); }

        /* ---------- Responsif ---------- */
        @media (max-width: 900px) {
            .edu-wrap { grid-template-columns: 1fr; min-height: 0; }
            .edu-hero { padding: 26px 22px 22px; }
            .edu-hero::after, .edu-float, .edu-luber, .edu-illus { display: none; }
            .edu-hero h1 { font-size: 24px; margin: 14px 0 6px; }
            .edu-hero p.lead-text { font-size: 13.5px; margin: 0; }
            .edu-panel { padding: 0 16px 28px; margin-top: -18px; background: transparent; }
            .edu-card { border-radius: 20px; padding: 26px 22px 20px; }
        }
        @media (prefers-reduced-motion: reduce) { .edu-float { animation: none; } .edu-btn { transition: none; } }
    </style>
</head>
<body class="edu">

<?php $sek = (isset($_GET['sekolah']) && $_GET['sekolah']==='smk') ? 'smk' : 'mts'; ?>

<div class="edu-wrap">

    <!-- ===== Panel kiri: tema pendidikan ===== -->
    <section class="edu-hero">
        <i class="fa fa-graduation-cap edu-float f1"></i>
        <i class="fa fa-lightbulb-o edu-float f2"></i>
        <i class="fa fa-flask edu-float f3"></i>
        <i class="fa fa-pencil edu-float f4"></i>
        <i class="fa fa-book edu-float f5"></i>

        <div class="edu-badges">
            <span class="edu-badge" id="badgeMts"><i class="fa fa-graduation-cap"></i> OSIM &middot; MTs Bustanul Thullab</span>
            <span class="edu-badge" id="badgeSmk"><i class="fa fa-graduation-cap"></i> OSIS &middot; SMK Bustanul Thullab</span>
        </div>
        <h1>Suaramu <span>Menentukan</span><br>Masa Depan Sekolah</h1>
        <p class="lead-text">Gunakan hak pilihmu dengan jujur, adil, dan bertanggung jawab. Satu suara dari setiap siswa membawa perubahan untuk sekolah kita.</p>

        <ul class="edu-luber">
            <li><b>L</b>angsung</li>
            <li><b>U</b>mum</li>
            <li><b>B</b>ebas</li>
            <li><b>R</b>ahasia</li>
            <li><b>J</b>ujur &amp; <b>A</b>dil</li>
        </ul>

        <svg class="edu-illus" viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Tumpukan buku dan topi toga">
            <ellipse cx="190" cy="226" rx="140" ry="12" fill="rgba(0,0,0,.18)"/>
            <!-- buku -->
            <rect x="100" y="190" width="180" height="30" rx="5" fill="#f5b800"/>
            <rect x="100" y="190" width="14" height="30" rx="4" fill="#c99700"/>
            <rect x="262" y="193" width="16" height="24" rx="2" fill="#fff4cc"/>
            <rect x="120" y="161" width="150" height="30" rx="5" fill="#ffffff"/>
            <rect x="120" y="161" width="12" height="30" rx="4" fill="#cfe8d7"/>
            <rect x="254" y="164" width="14" height="24" rx="2" fill="#eef6f0"/>
            <rect x="96" y="132" width="172" height="30" rx="5" fill="#0b4a26" stroke="rgba(255,255,255,.35)"/>
            <rect x="96" y="132" width="12" height="30" rx="4" fill="#073b1c"/>
            <rect x="124" y="143" width="70" height="4" rx="2" fill="rgba(255,255,255,.55)"/>
            <!-- topi toga -->
            <path d="M138 98 L138 122 Q182 146 226 122 L226 98 Z" fill="#2b3f52"/>
            <polygon points="182,52 264,84 182,116 100,84" fill="#1d2b3a"/>
            <polygon points="182,52 264,84 182,116 100,84" fill="none" stroke="rgba(255,255,255,.2)"/>
            <circle cx="182" cy="84" r="5" fill="#f5b800"/>
            <path d="M182 84 L250 92 L250 128" fill="none" stroke="#f5b800" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <rect x="245" y="126" width="10" height="20" rx="3" fill="#f5b800"/>
            <!-- pensil -->
            <g transform="translate(300,206) rotate(-42)">
                <rect x="-12" y="-7" width="12" height="14" rx="3" fill="#ff8a80"/>
                <rect x="0" y="-7" width="80" height="14" fill="#f5b800"/>
                <rect x="0" y="-7" width="80" height="4" fill="#ffd54f"/>
                <polygon points="80,-7 100,0 80,7" fill="#f6d6a8"/>
                <polygon points="93,-2.5 100,0 93,2.5" fill="#333"/>
            </g>
            <!-- bintang -->
            <polygon points="330,52 334,63 346,63 336,70 340,82 330,75 320,82 324,70 314,63 326,63" fill="#f5b800" opacity=".95"/>
            <circle cx="60" cy="90" r="4" fill="#fff" opacity=".7"/>
            <circle cx="350" cy="150" r="3" fill="#fff" opacity=".6"/>
            <circle cx="40" cy="170" r="3" fill="#f5b800" opacity=".8"/>
        </svg>
    </section>

    <!-- ===== Panel kanan: form login ===== -->
    <section class="edu-panel">
        <div class="edu-card">
            <div class="edu-logo">
                <a href="./">
                    <img id="logoOsim" src="images/logo_osim.png" alt="OSIM MTs Bustanul Thullab" <?php echo $sek==='smk' ? 'style="display:none"' : ''; ?>>
                    <img id="logoOsis" src="images/logo_osis.png" alt="OSIS SMK Bustanul Thullab" <?php echo $sek==='smk' ? '' : 'style="display:none"'; ?>>
                </a>
            </div>
            <h2>Selamat Datang</h2>
            <p class="sub">Masuk untuk menggunakan hak pilihmu</p>

            <?php
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger'>Login gagal! Username dan password salah.</div>";
                }else if($_GET['pesan'] == "logout"){
                    echo "<div class='alert alert-danger'>Anda telah logout.</div>";
                }else if($_GET['pesan'] == "salah"){
                    echo "<div class='alert alert-danger'>Anda tidak punya hak.</div>";
                }else if($_GET['pesan'] == "sudahmemilih"){
                    echo "<div class='alert alert-danger'>Maaf anda tidak dapat login karena telah memilih.</div>";
                }else if($_GET['pesan'] == "belumabsen"){
                    echo "<div class='alert alert-danger'>Maaf anda tidak dapat login. Silahkan absen terlebih dahulu.</div>";
                }else if($_GET['pesan'] == "selesai"){
                    echo "<div class='alert alert-info'>Voting telah selesai. Terima kasih atas partisipasi Anda.</div>";
                }else if($_GET['pesan'] == "terimakasih"){
                    echo "<div class='alert alert-success'>Terimakasih telah menggunakan hak pilih.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Silahkan login dulu.</div>";
                }
            }
            ?>

            <form method="POST" action="<?php echo base_url('Welcome/aksi_login'); ?>">
                <div class="edu-seg" role="radiogroup" aria-label="Pilih sekolah">
                    <input type="radio" id="sek-mts" name="sekolah" value="mts" <?php echo $sek==='mts'?'checked':''; ?>>
                    <label for="sek-mts"><i class="fa fa-book"></i>MTs</label>
                    <input type="radio" id="sek-smk" name="sekolah" value="smk" <?php echo $sek==='smk'?'checked':''; ?>>
                    <label for="sek-smk"><i class="fa fa-graduation-cap"></i>SMK</label>
                </div>

                <div class="edu-field">
                    <i class="fa fa-user ic"></i>
                    <input type="text" name="username" placeholder="ID Pemilih" autocomplete="username" aria-label="ID Pemilih">
                </div>

                <div class="edu-field">
                    <i class="fa fa-lock ic"></i>
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="current-password" aria-label="Password">
                    <button type="button" class="edu-eye" id="togglePassword" title="Lihat password" aria-label="Lihat password" tabindex="-1">
                        <i class="fa fa-eye" id="iconPassword"></i>
                    </button>
                </div>

                <button type="submit" class="edu-btn"><i class="fa fa-sign-in"></i>MASUK</button>
            </form>

            <div class="edu-foot"><i class="fa fa-shield"></i> Suaramu aman &amp; rahasia &middot; &copy; <?php echo date('Y'); ?></div>
        </div>
    </section>

</div>

<script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
<script>
    // Tombol lihat / sembunyikan password
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var icon  = document.getElementById('iconPassword');
        var tampil = input.type === 'password';
        input.type = tampil ? 'text' : 'password';
        icon.className = tampil ? 'fa fa-eye-slash' : 'fa fa-eye';
        this.title = tampil ? 'Sembunyikan password' : 'Lihat password';
        input.focus();
    });

    // Lencana sekolah di panel kiri: yang dipilih disorot
    (function () {
        var radios = document.querySelectorAll('input[name="sekolah"]');
        var mts = document.getElementById('badgeMts');
        var smk = document.getElementById('badgeSmk');
        function perbarui() {
            var pilihSmk = document.getElementById('sek-smk').checked;
            smk.className = 'edu-badge' + (pilihSmk ? ' aktif' : '');
            mts.className = 'edu-badge' + (pilihSmk ? '' : ' aktif');
        }
        for (var i = 0; i < radios.length; i++) { radios[i].addEventListener('change', perbarui); }
        perbarui();
    })();
</script>
<script>
(function () {
    var osim = document.getElementById('logoOsim');
    var osis = document.getElementById('logoOsis');
    var mts  = document.getElementById('sek-mts');
    var smk  = document.getElementById('sek-smk');
    function ganti() {
        var pilihSmk = smk.checked;
        osim.style.display = pilihSmk ? 'none' : '';
        osis.style.display = pilihSmk ? '' : 'none';
    }
    mts.addEventListener('change', ganti);
    smk.addEventListener('change', ganti);
    ganti();
})();
</script>
</body>
</html>
