<?php
// Pembaruan otomatis halaman hasil (tanpa refresh).
// Variabel: $live_url (alamat JSON), $live_selesai (status voting saat halaman dimuat)
?>
<style>
    .live-status { font-size: 13px; font-weight: 500; color: #6b7a8a; margin-left: 10px; vertical-align: middle; white-space: nowrap; }
    .live-dot { display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #9aa8a0; margin-right: 6px; }
    .live-dot.aktif { background: #1f9a4d; animation: liveDenyut 1.6s ease-in-out infinite; }
    .live-dot.putus { background: #f5b800; }
    .live-dot.mati  { background: #dc3545; }
    @keyframes liveDenyut { 0% { box-shadow: 0 0 0 0 rgba(31,154,77,.55); } 70% { box-shadow: 0 0 0 8px rgba(31,154,77,0); } 100% { box-shadow: 0 0 0 0 rgba(31,154,77,0); } }
    .live-flash { animation: liveKedip 1.3s ease-out; }
    @keyframes liveKedip { 0% { background: rgba(245,184,0,.55); } 100% { background: transparent; } }
</style>
<script>
(function () {
    var url = <?php echo json_encode($live_url); ?>;
    var selesaiAwal = <?php echo $live_selesai ? 'true' : 'false'; ?>;
    var JEDA = 5000;            // 5 detik
    var timer = null, henti = false;
    var dot  = document.querySelector('#liveStatus .live-dot');
    var teks = document.getElementById('liveText');

    function status(kelas, pesan) {
        if (dot)  { dot.className = 'live-dot ' + kelas; }
        if (teks) { teks.textContent = pesan; }
    }
    function isi(selector, nilai) {
        var els = document.querySelectorAll(selector);
        for (var i = 0; i < els.length; i++) {
            var baru = String(nilai);
            if (els[i].textContent !== baru) {
                els[i].textContent = baru;
                els[i].classList.add('live-flash');
                (function (el) { setTimeout(function () { el.classList.remove('live-flash'); }, 1400); })(els[i]);
            }
        }
    }
    function terapkan(d) {
        isi('[data-live="dpt"]', d.dpt);
        isi('[data-live="sudah_memilih"]', d.sudah_memilih);
        isi('[data-live="belum_memilih"]', d.belum_memilih);
        isi('[data-live="sudah_absen"]', d.sudah_absen);
        isi('[data-live="belum_absen"]', d.belum_absen);
        isi('[data-live="absen_belum_memilih"]', d.absen_belum_memilih);
        for (var i = 0; i < d.calon.length; i++) {
            var c = d.calon[i];
            isi('[data-live-suara="' + c.id + '"]', c.suara);
            isi('[data-live-persen="' + c.id + '"]', c.persen);
        }
        if (d.selesai !== selesaiAwal) {      // status voting berubah -> muat ulang (banner pemenang, tombol)
            status('aktif', 'Status voting berubah, memuat ulang...');
            henti = true;
            location.reload();
            return;
        }
        status('aktif', 'Otomatis diperbarui \u00b7 ' + d.waktu);
    }
    function jadwal() {
        if (henti) { return; }
        clearTimeout(timer);
        timer = setTimeout(ambil, JEDA);
    }
    function ambil() {
        if (document.hidden) { jadwal(); return; }     // tab tidak terlihat: jangan membebani server
        var x = new XMLHttpRequest();
        x.open('GET', url + (url.indexOf('?') > -1 ? '&' : '?') + 't=' + new Date().getTime(), true);
        x.setRequestHeader('Accept', 'application/json');
        x.onreadystatechange = function () {
            if (x.readyState !== 4) { return; }
            var d = null;
            if (x.status === 200) { try { d = JSON.parse(x.responseText); } catch (e) { d = null; } }
            if (d && d.calon) {
                terapkan(d);
            } else if (x.status === 401 || x.status === 403 || (x.status === 200 && !d)) {
                henti = true;
                status('mati', 'Sesi berakhir, muat ulang halaman');
                return;
            } else {
                status('putus', 'Koneksi terputus, mencoba lagi...');
            }
            jadwal();
        };
        x.send();
    }
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && !henti) { clearTimeout(timer); ambil(); }
    });
    status('aktif', 'Otomatis diperbarui');
    jadwal();
})();
</script>