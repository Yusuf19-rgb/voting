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

    <link rel="stylesheet" href="<?php  echo base_url('assets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php  echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php  echo base_url('assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php  echo base_url('assets/css/themify-icons.css'); ?>">
    <link rel="stylesheet" href="<?php  echo base_url('assets/css/pe-icon-7-filled.css'); ?>">


    <link href="<?php  echo base_url('assets/weather/css/weather-icons.css'); ?>" rel="stylesheet" />
    <link href="<?php  echo base_url('assets/calendar/fullcalendar.css'); ?>" rel="stylesheet" />

    <link rel="stylesheet" href="<?php  echo base_url('assets/css/style.css'); ?>">
    <link href="<?php  echo base_url('assets/css/charts/chartist.min.css'); ?>" rel="stylesheet"> 
    <link href="<?php  echo base_url('assets/css/lib/vector-map/jqvmap.min.css'); ?>" rel="stylesheet"> 

    <link rel="stylesheet" type="text/css" href="assets/datatable/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="assets/datatable/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/datatable/css/dataTables.bootstrap.css">




</head>
<body>

<?php

$login=$this->session->userdata('status');
if($login=='loginadmin'){
    
}else if($login=='loginpengawas'){
    
}else if($login=='loginsiswa'){
    redirect(base_url('?pesan=salah'));
}else{
    redirect(base_url('?pesan=belumlogin'));
}

?>
    

        <!-- Header-->
        <div class="content pb-0">

    
            
    
        <h1><i class="fa fa-bar-chart-o"> </i> Hasil Pemilihan</h1>
        <?php $nototal=0;$belummemilih=0;$sudahmemilih=0;$sudahabsen=0;$belumabsen=0;$sudahabsenbelummilih=0;
            foreach($datapemilih->result_array() as $j):
                    $id=$j['id'];
                  $suara=$j['suara'];
                  $absen=$j['absen'];
            if ($suara!=0) {
                $sudahmemilih++;
            }
            if ($suara==0) {
                $belummemilih++;
            }
            if ($absen!=0){
                $sudahabsen++;
            }
            if ($absen==0) {
                $belumabsen++;
            }
            if ($suara==0 && $absen!=0) {
                $sudahabsenbelummilih++;
            };
            $nototal++;
            endforeach;
            
        ?>
        <hr> 
        <div class="container">
            <div class="row">
              <div class="col-4"> DPT : <?php echo $nototal; ?> <br> Sudah absen belum memilih : <?php echo $sudahabsenbelummilih; ?> </div>
              <div class="col-4 text-center"> Sudah Memilih : <?php echo $sudahmemilih; ?><br>Sudah Absen : <?php echo $sudahabsen; ?></div>
              <div class="col-4 text-right"> Belum Memilih : <?php echo $belummemilih; ?><br>Belum Absen : <?php echo $belumabsen; ?></div>
          </div>
        </div>
        <hr>
        <?php if($vs['selesai']): ?>
        <div class="alert alert-success text-center">
            <h4 class="mb-1"><i class="fa fa-flag-checkered"></i> VOTING TELAH SELESAI<?php if($vs['selesai_pada']!=''){ echo ' <small>('.htmlspecialchars($vs['selesai_pada']).')</small>'; } ?></h4>
            <?php if($vs['total_suara']==0): ?>
                Belum ada suara yang masuk.
            <?php elseif($vs['seri']): ?>
                Hasil <strong>SERI</strong> antara: <strong><?php echo htmlspecialchars(implode(', ',$vs['pemenang'])); ?></strong>
            <?php else: ?>
                Pemenang: <strong><?php echo htmlspecialchars($vs['pemenang'][0]); ?></strong>
            <?php endif; ?>
            <br><small>Suara masuk: <?php echo $vs['total_suara']; ?> dari <?php echo $nototal; ?> pemilih &middot; Tidak memilih: <?php echo $belummemilih; ?> (tidak dihitung dalam persentase)</small>
        </div>
        <?php endif; ?>

                <div class="row">

                    <?php $no=1;
                        foreach($data->result_array() as $i):
                                $id=$i['id'];
                              $visi=$i['visi'];
                              $misi=$i['misi']; 
                              $namacalon=$i['namacalon']; 
                              $foto=$i['foto']; 
                              $totalsuara=$i['totalsuara'];        
                  ?>


                <?php $no++; endforeach;?>
                </div>
                <div class="row justify-content-center">
                    <?php $no=1;
                        foreach($data->result_array() as $i):
                                $id=$i['id'];
                              $visi=$i['visi'];
                              $misi=$i['misi']; 
                              $namacalon=$i['namacalon']; 
                              $foto=$i['foto']; 
                              $totalsuara=$i['totalsuara'];        
                  ?>
                    <div class="col-12 col-md d-flex" style="min-width:240px;">
                        <aside class="profile-nav alt w-100">
                            <section class="card">
                                <form action="<?php echo base_url('index.php/form/pilih/'.$id.''); ?>">
                                <div class="card-header user-header alt bg-dark">
                                    <div class="media">                            
                                            <h3 class="text-light display-6"><?php echo $no.'. '.$namacalon;?></h3>
                                    </div>
                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <center>
                                        <h1>
                                            <img class="align-self-center" style="width:240px; height:320px;" alt="" src="<?php echo base_url('upload/'.$foto)?>">
                                        </h1>
                                        </center><br>
                                        <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <center>
                                        <h2><br><?php echo $totalsuara;?> Suara</h2>
                                        <h3><?php $persen=($vs['selesai'])?(($vs['total_suara']>0)?($totalsuara/$vs['total_suara'])*100:0):(($nototal>0)?($totalsuara/$nototal)*100:0); echo round($persen,1); ?> %</h3><?php if($vs['selesai']){ echo '<small class="text-muted">dari suara masuk</small>'; } ?><?php if(in_array($id,$vs['pemenang_id'])){ echo '<h4><span class="badge badge-success">'.($vs['seri']?'SERI':'PEMENANG').'</span></h4>'; } ?>
                                        <br><br>
                                    </center>
                                    </li>
                                </ul>
                                    </center>
                                    </li>
                                </ul>
                            </form>
                            </section>
                        </aside>
                    </div>
                    <?php $no++; endforeach;?>
                </div>
        </div> <!-- .content -->
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

<!--Modal Grafik -->
        <div class="modal fade" id="lihatgrafik" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="largeModalLabel"><center>Hasil Pemilihan</center></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                    <h4 class="mb-3"> </h4>
                                    <canvas id="doughutChart" height="300" width="601" class="chartjs-render-monitor" style="display: block; width: 601px; height: 300px;"></canvas>
                                </div>
                            </div>

                        </div>

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
                       Copyright &copy; Team - KPOS || 2025
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
        $('.dataku').DataTable();
    });
    </script>
    <script type="text/javascript">
        window.print();
    </script>

<div id="container">
  
 
  
</div>



</body>
</html>