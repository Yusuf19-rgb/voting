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
    
}else if($login=='loginpengawas'){
    redirect(base_url('?pesan=salah'));
}else if($login=='loginsiswa'){
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
                            <li><i class="fa fa-user"></i><a href="Datapem">Data Pemilih</a></li>
                            
                        </ul>
                        </li>

                    <li class="menu-item">
                        <a href="#" class="" data-toggle="" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart-o"></i>Hasil Pemilihan</a>
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
                    <a class="navbar-brand" href=""><img src="images/logo.png" alt="Logo"></a> 
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a> 
                </div> 
            </div>
            <div style="position: fixed;right: 30px; top: 8px;">
                    <a class="btn btn-outline-primary" style="" data-toggle="modal" data-target="#konfirmkeluar">Keluar</a>
            </div>
        </header><!-- /header -->
        <!-- Header-->
        <div class="content pb-0">

    
            
    
        <h1><i class="fa fa-bar-chart-o"> </i> Hasil Pemilihan <small id="liveStatus" class="live-status"><span class="live-dot"></span><span id="liveText">Memuat...</span></small></h1>
        <hr>
        <a class="btn btn-success" href="<?php echo base_url('Hasilpilih/export'); ?>"><i class="fa fa-print">
        </i> Cetak</a>
        <?php if(!$vs['selesai']): ?>
        <button type="button" class="btn btn-danger ml-1" data-toggle="modal" data-target="#konfirmselesai"><i class="fa fa-flag-checkered"></i> Selesaikan Voting</button>
        <?php else: ?>
        <button type="button" class="btn btn-warning ml-1" data-toggle="modal" data-target="#konfirmbuka"><i class="fa fa-unlock"></i> Buka Kembali Voting</button>
        <?php endif; ?>
        <?php if($this->session->flashdata('success_msg')){ ?>
        <div class="alert alert-success mt-3"><?php echo $this->session->flashdata('success_msg'); ?></div>
        <?php } ?>

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
              <div class="col-4"> DPT : <span data-live="dpt"><?php echo $nototal; ?></span> <br> Sudah absen belum memilih : <span data-live="absen_belum_memilih"><?php echo $sudahabsenbelummilih; ?></span> </div>
              <div class="col-4 text-center"> Sudah Memilih : <span data-live="sudah_memilih"><?php echo $sudahmemilih; ?></span><br>Sudah Absen : <span data-live="sudah_absen"><?php echo $sudahabsen; ?></span></div>
              <div class="col-4 text-right"> Belum Memilih : <span data-live="belum_memilih"><?php echo $belummemilih; ?></span><br>Belum Absen : <span data-live="belum_absen"><?php echo $belumabsen; ?></span></div>
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
                                <div class="card-header user-header alt bg-dark">
                                    <div class="media">
                                        <a href="#">
                                            <img class="align-self-center rounded-circle mr-3" style="width:56px; height:56px;" alt="" src="<?php echo base_url('upload/'.$foto)?>">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="text-light display-6"><?php echo $namacalon;?></h4>
                                            <p>Calon No <?php echo $no;?></p>
                                        </div>
                                    </div>
                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <center>
                                        <h1><br><span data-live-suara="<?php echo $id; ?>"><?php echo $totalsuara;?></span> Suara</h1>
                                        <h3><span data-live-persen="<?php echo $id; ?>"><?php $persen=($vs['selesai'])?(($vs['total_suara']>0)?($totalsuara/$vs['total_suara'])*100:0):(($nototal>0)?($totalsuara/$nototal)*100:0); echo round($persen,1); ?></span> %</h3><?php if($vs['selesai']){ echo '<small class="text-muted">dari suara masuk</small>'; } ?><?php if(in_array($id,$vs['pemenang_id'])){ echo '<h4><span class="badge badge-success">'.($vs['seri']?'SERI':'PEMENANG').'</span></h4>'; } ?>
                                        <br><br>
                                    </center>
                                    </li>
                                </ul>
                            </section>
                        </aside>
                    </div>


                <?php $no++; endforeach;?>
                </div>

        </div> <!-- .content -->
        <div class="clearfix"></div>


<!--Modal Selesaikan Voting -->
        <div class="modal fade" id="konfirmselesai" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Selesaikan voting sekarang?</h5>
                    </div>
                    <div class="modal-body">
                        <ul class="mb-0 pl-3">
                            <li>Pemilih <strong>tidak dapat masuk dan memilih lagi</strong>.</li>
                            <li><strong><?php echo $belummemilih; ?> pemilih</strong> yang belum memilih dianggap tidak memilih.</li>
                            <li>Hasil ditentukan dari <strong><?php echo $vs['total_suara']; ?> suara</strong> yang sudah masuk, dan pemenang ditampilkan di halaman ini.</li>
                            <li>Voting masih bisa dibuka kembali lewat tombol <em>Buka Kembali Voting</em>.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="<?php echo base_url('index.php/Hasilpilih/selesai'); ?>" method="post">
                            <input type="submit" class="btn btn-danger" value="Ya, Selesaikan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!--Modal Buka Kembali Voting -->
        <div class="modal fade" id="konfirmbuka" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buka kembali voting? Pemilih yang belum memilih bisa login lagi.</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <form action="<?php echo base_url('index.php/Hasilpilih/bukakembali'); ?>" method="post">
                            <input type="submit" class="btn btn-warning" value="Ya, Buka">
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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

    <script>

        jQuery(document).ready(function($) {
            "use strict"; 

            // Pie chart flotPie1 
            var piedata = [
                { label: "Desktop visits", data: [[1,32]], color: '#5c6bc0'},
                { label: "Tab visits", data: [[1,33]], color: '#ef5350'},
                { label: "Mobile visits", data: [[1,35]], color: '#66bb6a'}
            ];

            $.plot('#flotPie1', piedata, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.65,
                        label: {
                            show: true,
                            radius: 2/3,
                            threshold: 1
                        },
                        stroke: { 
                            width: 0
                        }
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });

            // Pie chart flotPie1  End




            var cellPaiChart = [
                { label: "Direct Sell", data: [[1,65]], color: '#5b83de'},
                { label: "Channel Sell", data: [[1,35]], color: '#00bfa5'} 
            ];
            $.plot('#cellPaiChart', cellPaiChart, {
                series: {
                    pie: {
                        show: true,
                        stroke: { 
                            width: 0
                        }
                    }
                },
                legend: {
                    show: false
                },grid: {
                    hoverable: true,
                    clickable: true
                }
                
            });















            // Line Chart  #flotLine5
            var newCust = [[0, 3], [1, 5], [2,4], [3, 7], [4, 9], [5, 3], [6, 6], [7, 4], [8, 10]];

            var plot = $.plot($('#flotLine5'),[{
                data: newCust,
                label: 'New Data Flow',
                color: '#fff'
            }],
            {
                series: {
                    lines: {
                        show: true,
                        lineColor: '#fff',
                        lineWidth: 2
                    },
                    points: {
                        show: true,
                        fill: true,
                        fillColor: "#ffffff",
                        symbol: "circle",
                        radius: 3
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    show: false
                },
                grid: {
                    show: false
                }
            });

             // Line Chart  #flotLine5 End


 


            // Traffic Chart using chartist
            if ($('#traffic-chart').length) {
                var chart = new Chartist.Line('#traffic-chart', {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                  series: [
                  [0, 18000, 35000,  25000,  22000,  0],
                  [0, 33000, 15000,  20000,  15000,  300],
                  [0, 15000, 28000,  15000,  30000,  5000]
                  ]
              }, {
                  low: 0,
                  showArea: true,
                  showLine: false,
                  showPoint: false,
                  fullWidth: true,
                  axisX: {
                    showGrid: true
                }
            });

                chart.on('draw', function(data) {
                    if(data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 2000 * data.index,
                                dur: 2000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
            }
            // Traffic Chart using chartist End

            


            //Traffic chart chart-js 
            if ($('#TrafficChart').length) {
                var ctx = document.getElementById( "TrafficChart" );
                ctx.height = 150;
                var myChart = new Chart( ctx, {
                    type: 'line',
                    data: {
                        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul" ],
                        datasets: [
                        {
                            label: "Visit",
                            borderColor: "rgba(4, 73, 203,.09)",
                            borderWidth: "1",
                            backgroundColor: "rgba(4, 73, 203,.5)",
                            data: [ 0, 2900, 5000, 3300, 6000, 3250, 0 ]
                        },
                        {
                            label: "Bounce",
                            borderColor: "rgba(245, 23, 66, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(245, 23, 66,.5)",
                            pointHighlightStroke: "rgba(245, 23, 66,.5)",
                            data: [ 0, 4200, 4500, 1600, 4200, 1500, 4000 ]
                        },
                        {
                            label: "Targeted",
                            borderColor: "rgba(40, 169, 46, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(40, 169, 46, .5)",
                            pointHighlightStroke: "rgba(40, 169, 46,.5)",
                            data: [1000, 5200, 3600, 2600, 4200, 5300, 0 ]
                        } 
                        ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }

                    }
                } );
            }
            //Traffic chart chart-js  End 



            // Bar Chart #flotBarChart
            $.plot("#flotBarChart", [{
                data: [[0, 18], [2, 8], [4, 5], [6, 13],[8,5], [10,7],[12,4], [14,6],[16,15], [18, 9],[20,17], [22,7],[24,4], [26,9],[28,11]],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fillColor: '#ffffff8a'
                }
            }], {
                grid: {
                    show: false
                }
            });
            // Bar Chart #flotBarChart End

        });  // End of Document Ready 
    </script>




<?php $this->load->view('live_hasil', array('live_url'=>base_url('Hasilpilih/data'), 'live_selesai'=>$vs['selesai'])); ?>
<div id="container">
  
 
  
</div>



</body>
</html>
