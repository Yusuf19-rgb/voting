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
    redirect(base_url('?pesan=salah'));
}else if($login=='loginpengawas'){
    redirect(base_url('?pesan=salah'));
}else if($login=='loginsiswa'){
    
}else{
    redirect(base_url('?pesan=belumlogin'));
}
?>
    <div class="content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <div class="row">
                    <div class="col-3"><img src="<?php echo base_url('images/logo bt'); ?>"></div>
                    <div class="col text-left"><b>Halo : <?php echo $this->session->userdata('nama'); ?> </b><br>Silahkan tentukan pilihanmu!</div>
                </div>
            </li>
        </ol>
        <hr>
        

                

                
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
                    <div class="col-md-3">
                        <aside class="profile-nav alt">
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
                                        <div>
                                            <a class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#pilih<?php echo $id;?>"  href="">Visi Misi</a>
                                        </div>
                                    </center>
                                    </li>
                                </ul>
                            </form>
                            </section>
                        </aside>
                    </div>
                    <?php $no++; endforeach;?>
                </div>
                
<!--Modal VISIMISI-->
<?php
$no=1;
        foreach($data->result_array() as $i):
                            $id=$i['id'];
                              $visi=$i['visi'];
                              $misi=$i['misi']; 
                              $namacalon=$i['namacalon']; 
                              $foto=$i['foto']; 
                              $totalsuara=$i['totalsuara'];  ?>

<div class="modal fade" id="pilih<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="largemodalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="<?php echo  base_url('index.php/form/pilih/'.$id);?>" method="post">
                        <div class="modal-body">

                           <div class="card-header user-header alt bg-dark">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <div class="media">                            
                                            <h1 class="text-light display-6"><?php echo $no.'. '.$namacalon;?></h1>
                                    </div>

                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                    
                                        <div class="row">
                                            <div class="col">
                                            <img class="align-self-center" style="width:240px; height:320px;" alt="" src="<?php echo base_url('upload/'.$foto)?>">
                                            </div>
                                            
                                        </div>
										<br>
										<div class="row">
                                            
                                            <div class="col">
                                                </h1>
                                                <div class="box"><h3>Visi :</h3><hr>
                                                <p><?php echo $visi;?></p></div>
                                                <hr>
                                                <div class="box"><h3>Misi :</h3><hr>
                                                <p><?php echo $misi;?></p></div>
                                            </div>
                                        </div>
                                    
                                    </li>
                                </ul>

                        </div>
                        
                        <div class="modal-footer">
                        <input type="submit" class="btn btn-success btn-lg btn-block" value="Pilih">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php $no++; endforeach;?>
            <center><div class="footer-inner bg-white">
               Copyright &copy; Team - KPOS || 2025
            </div></center>
        </div> <!-- .content -->
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





</body>
</html>
