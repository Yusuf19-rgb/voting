<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-KPOS</title>
    <meta name="description" content="Komisi Pemilihan Organisasi Santri">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="images/favicon.png">
    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">


    <link href="assets/weather/css/weather-icons.css" rel="stylesheet" />
    <link href="assets/calendar/fullcalendar.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/charts/chartist.min.css" rel="stylesheet"> 
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet"> 

    <link rel="stylesheet" type="text/css" href="assets/datatable/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="assets/datatable/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/datatable/css/dataTables.bootstrap.css">
</head>
<body>

<?php

$login=$this->session->userdata('status');
if($login=='loginadmin'){
    
}else if($login=='loginsiswa'){
    redirect(base_url('?pesan=salah'));
}else if($login=='loginpengawas'){
    redirect(base_url('?pesan=salah'));
}else{
    redirect(base_url('?pesan=belumlogin'));
}

?>
    <!-- Left Panel --> 
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default"> 
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="dasbor"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Menu</li><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-ul"></i>Data</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-id-badge"></i><a href="Datacal">Data Calon</a></li>
                            <li><i class="fa fa-eye"></i><a href="Datapeng">Data Pengawas</a></li>
                            <li><i class="fa fa-user"></i><a href="#">Data Pemilih</a></li>
                            
                        </ul>
                        </li>

                    <li class="menu-item">
                        <a href="Hasilpilih" class="" data-toggle="" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart-o"></i>Hasil Pemilihan</a>
                        <a href="" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#konfirmkeluar"> <i class="menu-icon fa fa-times"></i>Keluar</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->  
    <!-- Left Panel -->



    <!-- Right Panel --> 
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">  
            <div class="top-left">
                <div class="navbar-header"> 
                    <a class="navbar-brand" href=""><img src="images/logo" alt="Logo"></a> 
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a> 
                </div> 
            </div>
            <div style="position: fixed;right: 30px; top: 8px;">
                    <a class="btn btn-outline-primary" style="" data-toggle="modal" data-target="#konfirmkeluar">Keluar</a>
            </div>
        </header><!-- /header -->
        <!-- Header-->
        <div class="content pb-0">

    
            
    
        <h1><i class="fa fa-users"> </i> DATA PEMILIH <span class="badge badge-primary" style="font-size:45%; vertical-align:middle;"><?php echo $this->mp->label_sekolah(); ?></span></h1>
        <hr>
        <div class="row">

        <div class="col"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahdata" ><i class="fa fa-plus-circle"></i>&nbsp; Tambah</button> <a href="<?php echo base_url('datapem/export') ?>" class="btn btn-success" ><i class="fa fa-print"></i>&nbsp; Export</a> <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importdata"><i class="fa fa-upload"></i>&nbsp; Import</button> <select id="filterKelas" class="form-control d-inline-block" style="width:auto; vertical-align:middle;" title="Tampilkan per kelas"><option value="">Semua User</option><?php foreach($this->mp->daftar_kelas() as $kk){ echo '<option value="'.$kk.'">Kelas '.$kk.'</option>'; } ?><option value="Guru">Guru</option></select> <button type="button" class="btn btn-danger" id="btnhapusterpilih" data-toggle="modal" data-target="#hapusterpilih" disabled><i class="fa fa-trash"></i>&nbsp; Hapus Ditandai <span class="badge badge-light" id="jmlterpilih">0</span></button></div>
    	</div>
        <hr>
<?php if($this->session->flashdata('success_msg')){

            ?>
            <div class="alert alert-success"><center>
                <?php echo $this->session->flashdata('success_msg'); ?>                
            </center></div>
            <?php
        } ?>
        <?php if($this->session->flashdata('error_msg')){

            ?>
            <div class="alert alert-danger"><center>
                <?php echo $this->session->flashdata('error_msg'); ?>                
            </center></div>
            <?php
        } ?>
    
<?php $imp_err=$this->session->flashdata('import_errors');
if(!empty($imp_err)){ $imp_tot=(int)$this->session->flashdata('import_errors_total'); ?>
            <div class="alert alert-warning">
                <strong>Detail baris yang gagal:</strong>
                <ul class="mb-0" style="max-height:200px; overflow:auto;">
                <?php foreach($imp_err as $e){ echo '<li>'.htmlspecialchars($e).'</li>'; } ?>
                </ul>
                <?php if($imp_tot>count($imp_err)){ echo '<small>... dan '.($imp_tot-count($imp_err)).' baris lainnya.</small>'; } ?>
            </div>
<?php } ?>
    <div class="clearfix">
        <table class="table table-striped table-bordered dataku">
            <thead>
                  <tr>
                  		<th width="30" class="text-center"><input type="checkbox" id="cekSemua" title="Tandai semua data (termasuk halaman lain, sesuai pencarian)"></th>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Pemilih</th>
                        <th>Kelas</th>
                        <th>Daftar Hadir</th>
                        <th>Suara</th>
                        <th width="150"><button class="btn btn-danger" data-toggle="modal" data-target="#truncate" >Kosongkan</button></th>
                  </tr>
            </thead>
            <tbody>
                  <?php $no=1;
                        foreach($data->result_array() as $i):
                              $id=$i['id'];
                              $nis=$i['nis']; 
                              $namasiswa=$i['namasiswa']; 
                              $kelas=$i['kelas']; 
                              $suara=$i['suara'];
                              $absen=$i['absen'];        
                  ?>
                  <tr>
                  		<td class="text-center"><input type="checkbox" class="cek" value="<?php echo htmlspecialchars($id); ?>"></td>
                        <td><?php echo "$no"?></td>
                        <td><?php echo $nis;?> </td>
                        <td><?php echo $namasiswa;?> </td>
                        <td><?php echo $kelas;?> </td>
                        <td><?php
                            if ($absen=='0') {
                                ?>
                                    <button type="button" class="btn btn-warning">Belum Absen</button>
                                <?php
                            }else{
                                ?>
                                    <button type="button" class="btn btn-success">Telah Absen</button>
                                <?php
                            };
                        ?> </td>
                        <td><?php
                            if ($suara=='0') {
                                ?>
                                    <button type="button" class="btn btn-warning">Belum Memilih</button>
                                <?php
                            }else{
                                ?>
                                    <button type="button" class="btn btn-success">Telah Memilih</button>
                                <?php
                            };
                        ?> </td>
                        <td>

                        	<a class="btn btn-outline-primary" data-toggle="modal" data-target="#editdata<?php echo $id;?>"  href=""><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-outline-primary" href="datapem/edita/<?php echo $id;?>" title="Absen" href=""><i class="fa fa-check"></i></a>
                            <a class="btn btn-outline-primary" href="datapem/editbatal/<?php echo $id;?>" title="Batal Absen"  href=""><i class="fa fa-undo"></i></a>
                            <a class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Reset Pilihan" href="<?php echo  base_url('index.php/datapem/resetpilihan/'.$id);?>"><i class="fa fa-undo"></i></a>
                        	<a class="btn btn-outline-danger" href="<?php echo  base_url('index.php/datapem/delete/'.$id);?>"><i class="fa fa-trash"></i></a>
                           
                        </td>
                  </tr>
                  <?php $no++; endforeach;?>
            </tbody>
        </table>
    </div>



<!--Modal hapus ditandai-->
<div class="modal fade" id="hapusterpilih" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus <span id="jmlterpilih2">0</span> pemilih yang ditandai?<hr>Suara yang sudah masuk dari pemilih tersebut ikut dikurangi dari hasil pemilihan.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <form action="<?php echo base_url('index.php/datapem/hapusterpilih'); ?>" method="post" id="formhapusterpilih">
                    <input type="submit" class="btn btn-danger" value="Ya, Hapus">
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal import-->
<div class="modal fade" id="importdata" tabindex="-1" role="dialog" aria-labelledby="importLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h2><i class="fa fa-upload"></i>&nbsp; Import Pemilih</h2>
            </div>

            <form action="<?php echo base_url('index.php/datapem/import'); ?>" method="post" enctype="multipart/form-data" id="formimport">
            <div class="modal-body">

                <div class="alert alert-info">
                    <strong>Langkah:</strong>
                    <ol class="mb-1 pl-3">
                        <li>Unduh template, lalu isi data pemilih.</li>
                        <li>Upload file (.xlsx atau .csv) di bawah ini.</li>
                    </ol>
                    <a href="<?php echo base_url('assets/'.$this->mp->template_import()); ?>" class="btn btn-sm btn-outline-primary" download><i class="fa fa-download"></i>&nbsp; Unduh Template Excel</a>
                </div>

                <p class="mb-1"><strong>Kolom file:</strong></p>
                <table class="table table-sm table-bordered">
                    <thead><tr><th>ID</th><th>Password</th><th>Nama Pemilih</th><th>Kelas</th><th>Ruang</th></tr></thead>
                    <tbody><tr><td>S001</td><td><em>boleh kosong</em></td><td>Nama Siswa</td><td><?php $ks=$this->mp->daftar_kelas(); echo $ks[0]; ?></td><td>A</td></tr></tbody>
                </table>
                <small class="text-muted d-block mb-3">Password kosong = otomatis sama dengan ID. Kelas diisi angka <?php echo implode(', ', $ks); ?>, atau Guru. Ruang (sub kelas) boleh kosong dan dikosongkan untuk Guru. Penulisan seperti "<?php echo $ks[0]; ?>A" atau "<?php echo $ks[0]; ?>-A" di kolom Kelas juga dikenali.</small>

                <div class="form-group">
                    <label for="file_import" class="form-control-label"><strong>File Import</strong></label>
                    <input type="file" id="file_import" name="file_import" accept=".xlsx,.csv" required class="form-control-file">
                </div>

                <div class="form-group mb-0">
                    <label class="form-control-label"><strong>Jika ID sudah ada di data pemilih:</strong></label>
                    <div class="form-check">
                        <label class="form-check-label"><input type="radio" name="mode" value="lewati" checked class="form-check-input"> Lewati (data lama tidak diubah)</label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label"><input type="radio" name="mode" value="perbarui" class="form-check-input"> Perbarui nama &amp; kelas (absen, suara, dan password tetap)</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <input type="submit" value="Import" class="btn btn-primary" id="btnimport">
            </div>
            </form>
        </div>
    </div>
</div>

<!--Modal tambah-->
<div class="modal fade" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="smallmodalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h2><i class="fa fa-plus-circle"></i>&nbsp; Pemilih</h2>
                        </div>


                        <form action="datapem/insert" method="post">
                        <div class="modal-body">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">ID</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nis" name="nis" placeholder="ID" required class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password" name="password" placeholder="Password"  class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Nama Pemilih</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nama" name="nama" placeholder="NAMA"  class="form-control"></div>
                            </div>

                            <div class="row form-group">
                                 <div class="col col-md-3"><label class=" form-control-label">User</label></div>
                                     <div class="col-12 col-md-9">
                                        <select name="kelas" required class="form-control">
                                            <option value="">-- Pilih User --</option>
                                            <?php foreach($this->mp->daftar_kelas() as $kk): ?>
                                            <option value="<?php echo $kk; ?>">Kelas <?php echo $kk; ?></option>
                                            <?php endforeach; ?>
                                            <option value="Guru">Guru</option>
                                        </select>
                                     </div>
                                 </div>
                            <div class="row form-group">
                                 <div class="col col-md-3"><label class=" form-control-label">Ruang</label></div>
                                     <div class="col-12 col-md-9">
                                        <input type="text" name="ruang" maxlength="5" placeholder="Contoh: A (boleh kosong)" class="form-control" value="">
                                     </div>
                                 </div>
                             
                             </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <input type="submit" value="Tambah" class="btn btn-primary">
                        </div>
                        </form>
                    </div>
                </div>
            </div>



<!--Modal Edit-->
    
  <?php
        foreach($data->result_array() as $i):
                              $id=$i['id'];
                              $nis=$i['nis']; 
                              $password=$i['password'];
                              $namasiswa=$i['namasiswa']; 
                              $kelas=$i['kelas']; 
                              list($k_kelas,$k_ruang)=$this->mp->pecah_kelas($kelas);
                              $suara=$i['suara'];
                              ?>
<div class="modal fade" id="editdata<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="smallmodalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h2><i class="fa fa-pencil"></i>&nbsp; Pemilih</h2>
                        </div>


                        <form action="<?php echo  base_url('index.php/datapem/edit/'.$id);?>" method="post">
                        <div class="modal-body">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">ID</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nis" name="nis" placeholder="ID"  class="form-control" readonly value="<?php echo $nis; ?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Passowrd</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password" name="password" placeholder="NIS"  readonly class="form-control" value="<?php echo $password; ?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Nama Pemilih</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nama" name="nama" placeholder="NAMA"  class="form-control" value="<?php echo $namasiswa; ?>"></div>
                            </div>

                            <div class="row form-group">
                                 <div class="col col-md-3"><label class=" form-control-label">User</label></div>
                                     <div class="col-12 col-md-9">
                                        <select name="kelas" required class="form-control">
                                            <option value="">-- Pilih User --</option>
                                            <?php foreach($this->mp->daftar_kelas() as $kk): ?>
                                            <option value="<?php echo $kk; ?>"<?php echo $k_kelas==$kk?' selected':''; ?>>Kelas <?php echo $kk; ?></option>
                                            <?php endforeach; ?>
                                            <option value="Guru"<?php echo $k_kelas=='Guru'?' selected':''; ?>>Guru</option>
                                        </select>
                                     </div>
                                 </div>
                            <div class="row form-group">
                                 <div class="col col-md-3"><label class=" form-control-label">Ruang</label></div>
                                     <div class="col-12 col-md-9">
                                        <input type="text" name="ruang" maxlength="5" placeholder="Contoh: A (boleh kosong)" class="form-control" value="<?php echo htmlspecialchars($k_ruang); ?>">
                                     </div>
                                 </div>
           
                             </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <input type="submit" value="Ubah" class="btn btn-primary">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <div class="clearfix"></div>


<!--Modal Keluar -->
       <div class="modal fade" id="konfirmkeluar" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticModalLabel">Apakah anda yakin ingin keluar?</h5>
                        </div>
                       <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <form  action="<?php echo base_url('index.php/Welcome/logout'); ?>">
                        <input type="submit" class="btn btn-primary" value="Ya">
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal truncate -->
       <div class="modal fade" id="truncate" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticModalLabel">Jika Anda menghapus semua data pemilih maka hasil pemilihan juga akan direset...<hr>Apakah anda yakin ingin menghapus semua data pemilih ?</h5>
                        </div>
                       <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <form  action="<?php echo base_url('index.php/datapem/hapussemua') ?>">
                        <input type="submit" class="btn btn-primary" value="Ya">
                    </form>
                    </div>
                </div>
            </div>
        </div>
<br>
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
              
                    </div>
                    <div class="col-sm-6 text-right">
                       Copyright &copy; KPOS PP. Darul Falah Cijati || 2025
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- /#right-panel -->

           

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>


    <!--Chartist Chart-->
    <script src="assets/js/lib/chartist/chartist.min.js"></script>
    <script src="assets/js/lib/chartist/chartist-plugin-legend.js"></script> 

    
    <script src="assets/js/lib/flot-chart/jquery.flot.js"></script>
    <script src="assets/js/lib/flot-chart/jquery.flot.pie.js"></script>
    <script src="assets/js/lib/flot-chart/jquery.flot.spline.js"></script>


    <script src="assets/weather/js/jquery.simpleWeather.min.js"></script>
    <script src="assets/weather/js/weather-init.js"></script>


    <script src="assets/js/lib/moment/moment.js"></script>
    <script src="assets/calendar/fullcalendar.min.js"></script>
    <script src="assets/calendar/fullcalendar-init.js"></script>

    <script type="text/javascript" src="assets/datatable/js/jquery.js"></script>
    <script type="text/javascript" src="assets/datatable/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
        var tabel = $('.dataku').DataTable({
            order: [[1, 'asc']],
            columnDefs: [{ targets: 0, orderable: false, searchable: false }]
        });

        // Ruang dinonaktifkan jika kelas = Guru
        $(document).on('change', 'select[name="kelas"]', function(){
            var r = $(this).closest('form').find('input[name="ruang"]');
            if (this.value === 'Guru') { r.val('').prop('disabled', true); } else { r.prop('disabled', false); }
        });
        $('select[name="kelas"]').trigger('change');

        // Filter per kelas (kolom Kelas = indeks 4)
        $('#filterKelas').on('change', function(){
            tabel.column(4).search(this.value ? '^' + this.value : '', true, false).draw();
            updateTerpilih();
        });

        // Hitung & aktifkan tombol Hapus Ditandai
        function updateTerpilih(){
            var n = tabel.$('input.cek:checked').length;
            var total = tabel.$('input.cek').length;
            $('#jmlterpilih, #jmlterpilih2').text(n);
            $('#btnhapusterpilih').prop('disabled', n === 0);
            $('#cekSemua').prop('checked', n > 0 && n === total)
                          .prop('indeterminate', n > 0 && n < total);
        }
        // Tandai semua = semua data hasil pencarian, di semua halaman
        $('#cekSemua').on('change', function(){
            var c = this.checked;
            tabel.rows({ search: 'applied' }).nodes().to$().find('input.cek').prop('checked', c);
            updateTerpilih();
        });
        $('.dataku tbody').on('change', 'input.cek', updateTerpilih);
        // Kirim semua ID yang ditandai (termasuk yang ada di halaman lain)
        $('#formhapusterpilih').on('submit', function(){
            var f = $(this).find('input[name="ids[]"]').remove().end();
            tabel.$('input.cek:checked').each(function(){
                $('<input>').attr({ type: 'hidden', name: 'ids[]', value: this.value }).appendTo(f);
            });
        });
        $('#formimport').on('submit',function(){ $('#btnimport').prop('disabled',true).val('Memproses...'); });
    });
	</script>




<div id="container">
  
 
  
</div>



</body>
</html>