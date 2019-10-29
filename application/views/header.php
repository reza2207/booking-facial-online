<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pusat perawatan kulit wajah dan tubuh yang berada di bawah pengawasan kencatikan dan didukung oleh beautycian profesional.">
    <meta name="author" content="Reza, and Bootstrap contributors">
    <meta name="generator" content="farina beauty">
    <title><?= isset($title) ? $title : ''?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url().'assets/bootstrap-4.3.1-dist/css/bootstrap.css';?>" rel="stylesheet" >
    <link href="<?= base_url().'assets/css/style.css';?>" rel="stylesheet" >
    <link href="<?= base_url().'assets/css/datepicker-bootstrap.min.css';?>" rel="stylesheet" >
    <link href="<?= base_url().'assets/css/font-awesome.min.css';?>" rel="stylesheet" >
    
    <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
  </head>
  <header>
    <nav id="navbar" class="navbar navbar-expand-md navbar-dark fixed-top">
      <a class="navbar-brand" href="<?= base_url();?>">Farina Beauty Clinic Jakarta</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav" for="mobile">
          <li class="nav-item active d-lg-none">
            <a class="nav-link" href="<?= base_url().'product';?>">Produk</a>
          </li>
          <li class="nav-item active d-lg-none">
            <a class="nav-link" href="<?= base_url().'jadwal_dokter';?>">Jadwal Dokter</a>
          </li>
          <li class="nav-item active d-lg-none">
            <a class="nav-link" href="<?= base_url().'booking';?>">Booking</a>
          </li>
          <li class="nav-item active d-lg-none">
            <a class="nav-link" href="<?= base_url().'kontak';?>">Kontak</a>
          </li>
          <li class="nav-item active d-lg-none">
            <a class="nav-link" href="<?= base_url().'tentang';?>">Tentang</a>
          </li>
          
        </ul>
        <hr>
        <nav class="nav justify-content-center hidden-md-down d-none d-lg-block navbar-collapse" id="menunav" for="desktop"><!-- 
          <a class="nav-link" href="<?= base_url().'About';?>" style="margin-left: -130px;">About</a> -->
          <a class="nav-link" href="<?= base_url().'product';?>">Produk</a>
          <a class="nav-link" href="<?= base_url().'jadwal_dokter';?>">Jadwal Dokter</a>
          <a class="nav-link" href="<?= base_url().'booking';?>">Booking</a>
          <a class="nav-link" href="<?= base_url().'kontak';?>">Kontak</a>
          <a class="nav-link" href="<?= base_url().'tentang';?>">Tentang</a>
          
        </nav>
        <ul class="navbar-nav">
          
          <?php if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true){?>
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= base_url().'profile';?>">Profile</a>
          </li>
          <li class="nav-item">

            <a class="nav-link" href="<?= base_url().'logout';?>" id="sign_out"><i class="fa fa-sign-out"></i> Logout</a>
          </li>
          <?php }else{?>
					<li class="nav-item">

            <a class="nav-link text-light" href="<?= base_url().'login';?>">Login</a>
          </li>
          <li class="nav-item">

            <a class="nav-link text-light" href="<?= base_url().'buat-akun';?>">Buat Akun</a>
          </li>
          <?php }?>
        </ul>
      </div>
    </nav>
  
    </div>
  </header>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= base_url().'assets/js/jquery-3.3.1.min.js';?>"></script>
    <script src="<?= base_url().'assets/js/moment.js';?>"></script>
    <script src="<?= base_url().'assets/js/bootstrap-datetimepicker.min.js';?>"></script>
    <script src="<?= base_url().'assets/datatables/DataTables-1.10.18/js/jquery.dataTables.js';?>"></script>
    <script src="<?= base_url().'assets/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.js';?>"></script>
    <script src="<?= base_url().'assets/js/bootstrap.min.js';?>"></script>
    <script src="<?= base_url().'assets/js/popper.min.js';?>"></script>
    <script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
   
    <script src="<?= base_url().'assets/js/gijgo.min.js';?>"></script>
    <script>

    $(document).ready(function(){
      $('#btn-bars').on('click', function(){
        $('#nav-container').toggleClass('sr-only');
      })
      $('#sign_out').on('click', function(e){
        	e.preventDefault();
          swal({
            type: 'question',
            text: 'Yakin Keluar?',
            showCancelButton: 'true',
            allowOutsideClick: false
          }).then(function(){
            window.location.href="<?=base_url().'User/logout';?>"; 
          })
        })
    })
    </script>