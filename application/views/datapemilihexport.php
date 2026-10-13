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
    
}else if($login=='loginsiswa'){
    redirect(base_url('?pesan=salah'));
}else if($login=='loginpengawas'){
    redirect(base_url('?pesan=salah'));
}else{
    redirect(base_url('?pesan=belumlogin'));
}

?>
   



        <div class="content">

    
            
    
        <h1><i class="fa fa-users"> </i> DATA PEMILIH</h1>
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
    
    <div class="clearfix">
        <table class="table table-striped table-bordered dataku">
            <thead>
                  <tr>
                  		<th>No</th>
                        <th>ID</th>
                        <th>Nama Pemilih</th>
                        <th>Kelas</th>
                        <th>Absen</th>
                        <th>Suara</th>
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
                  </tr>
                  <?php $no++; endforeach;?>
            </tbody>
        </table>
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
        window.print();
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.dataku').DataTable();
    });
	</script>




<div id="container">
  
 
  
</div>



</body>
</html>
