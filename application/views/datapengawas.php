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

    
            
    
        <h1><i class="fa fa-users"> </i> DATA PENGAWAS</h1>
        <hr>
        <div class="row">
        <div class="col"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahdata" ><i class="fa fa-plus-circle"></i>&nbsp; Tambah</button></div>
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
    
    <div class="clearfix">
        <table class="table table-striped table-bordered dataku">
            <thead>
                  <tr>
                  		<th>No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Nama Pengawas</th>
                        <th width="150"><button class="btn btn-danger" data-toggle="modal" data-target="#truncate" >Kosongkan</button></th>
                  </tr>
            </thead>
            <tbody>
                  <?php $no=1;
                        foreach($data->result_array() as $i):
                            $id=$i['id'];
                              $username=$i['username'];
                              $password=$i['password'];
                              $namapengawas=$i['namapengawas'];    
                  ?>
                  <tr>
                  		<td><?php echo "$no"?></td>
                        <td><?php echo $username;?> </td>
                        <td><?php echo $password;?> </td>
                        <td><?php echo $namapengawas;?> </td>
                        <td>

                        	<a class="btn btn-outline-primary" data-toggle="modal" data-target="#editdata<?php echo $id;?>"  href=""><i class="fa fa-pencil"></i></a>
                        	<a class="btn btn-outline-danger" href="<?php echo  base_url('datapeng/delete/'.$id);?>"><i class="fa fa-trash"></i></a>
                           
                        </td>
                  </tr>
                  <?php $no++; endforeach;?>
            </tbody>
        </table>
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
                            <h2><i class="fa fa-plus-circle"></i>&nbsp; Pengawas</h2>
                        </div>


                        <form action="datapeng/insert" method="post">
                        <div class="modal-body">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Username</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nis" name="username" placeholder="USERNAME" required class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password" name="password" placeholder="Password"  class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Nama Pengawas</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="namapengawas" name="namapengawas" class="form-control"></div>
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
                              $username=$i['username']; 
                              $password=$i['password'];
                              $namapengawas=$i['namapengawas']; 
                            
                              ?>
<div class="modal fade" id="editdata<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="smallmodalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h2><i class="fa fa-pencil"></i>&nbsp; Pengawas</h2>
                        </div>


                        <form action="<?php echo  base_url('datapeng/edit/'.$id);?>" method="post">
                        <div class="modal-body">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Username
                                </label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="nis" name="username" placeholder="NIS"  class="form-control"  value="<?php echo $username; ?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Passowrd</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password" name="password" placeholder="NIS"  class="form-control" value="<?php echo $password; ?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Nama Pengawas</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="namapengawas" name="namapengawas" placeholder="NAMA"  class="form-control" value="<?php echo $namapengawas; ?>"></div>
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
                        <form  action="<?php echo base_url('Welcome/logout'); ?>">
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
                            <h5 class="modal-title" id="staticModalLabel">Apakah anda yakin ingin menghapus semua data pengawas ?</h5>
                        </div>
                       <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <form  action="<?php echo base_url('datapeng/hapussemua') ?>">
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




<div id="container">
  
 
  
</div>



</body>
</html>
