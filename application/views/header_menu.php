<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Pusat perawatan kulit wajah dan tubuh yang berada di bawah pengawasan kencatikan dan didukung oleh beautycian profesional.">
	<meta name="author" content="Reza, and Bootstrap contributors">
	<meta name="generator" content="farina beauty">

	<link rel="icon" href="../../../../favicon.ico">

	<title><?= isset($title) ? $title : 'untitled' ;?></title>

	<!-- Bootstrap core CSS -->

	<link href="<?= base_url().'assets/css/bootstrap.min.css';?>" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?= base_url().'assets/css/dashboard.css';?>" rel="stylesheet">
	<link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">

	<link href="<?= base_url().'assets/css/datepicker-bootstrap.min.css';?>" rel="stylesheet" >

	<link href="<?= base_url().'assets/select2-4.0.4/dist/css/select2.min.css';?>" rel="stylesheet">
	<!-- Datatables -->
	<link href="<?= base_url().'assets/datatables/datatables.min.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css';?>"/>
	<link href="<?= base_url().'assets/css/style.css';?>" rel="stylesheet" >
	<link href="<?= base_url().'assets/css/font-awesome.min.css';?>" rel="stylesheet" >
</head>

<body >

	<nav class="navbar navbar-dark navbar-expand-lg fixed-top flex-md-nowrap p-0 shadow " id="navbar">
		<button class="navbar-toggler" type="button" id="btn-menu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand col-9 col-md-2 col-lg-2" href="<?= base_url();?>">Farina Beauty Clinic Jakarta</a>

		<div class="collapse navbar-collapse" id="navbarCollapse">
			<?php if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true){?>
				<?php if($_SESSION['role'] == 'user'):?>
					<ul class="navbar-nav">
						<li class="nav-item active d-lg-none">
							<a class="nav-link" href="<?= base_url().'product';?>" style="margin-left: -130px;">Produk</a>
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
					<nav class="nav justify-content-center hidden-md-down d-none d-lg-block navbar-collapse" id="menunav">
						<a class="nav-link" href="<?= base_url().'product';?>" style="margin-left: -130px;">Produk</a>
						<a class="nav-link" href="<?= base_url().'jadwal_dokter';?>">Jadwal Dokter</a>
						<a class="nav-link" href="<?= base_url().'booking';?>">Booking</a>
						<a class="nav-link" href="<?= base_url().'kontak';?>">Kontak</a>
						<a class="nav-link" href="<?= base_url().'tentang';?>">Tentang</a>

					</nav>

					<ul class="navbar-nav ">
						<li class="nav-item">
							<a class="nav-link text-light" href="<?= base_url().'profile';?>">Profile</a>
						</li>

						<li class="nav-item">

							<a class="nav-link text-light" href="<?= base_url().'logout';?>" id="sign_out"><i class="fa fa-sign-out"></i> Logout</a>
						</li>

					</ul>
				<?php endif;?>
			<?php }else{?>

			<?php }?>
		</div>
	</nav>


	<div class="container-fluid" >
		<div class="row">
			<!-- <nav class="col-3 col-md-2 d-none bg-light sidebar"> -->
				<nav class="col-6 col-md-2 bg-light sidebar d-md-block d-none d-lg-block" id="navbarNavDropdown">
					<div class="sidebar-sticky">
						<ul class="nav flex-column">

							<li class="nav-item">

								<li class="nav-item">
									<a class="nav-link" href="<?= base_url().'profile';?>"><i class="fa fa-user"></i> Hi <b><?= $nama;?></b> !</a>
								</li>
								<div class="dropdown-divider"></div>
								<?php if($_SESSION['role'] == 'user'){?>

									<?php if($page_active == 'booking'){?>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'booking/booking_baru';?>" style="padding-left: 13px"><i class="fa fa-pencil-square-o "></i> Booking Baru</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'booking/on_proses';?>" style="padding-left: 13px"><i class="fa fa-history"></i> Dalam Proses</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'booking/riwayat_booking';?>" style="padding-left: 13px"><i class="fa fa-history"></i> Riwayat Booking</a>
										</li>
										<div class="dropdown-divider"></div>
										<li class="nav-item d-none d-lg-block d-xl-none">
											<a class="nav-link" href="<?= base_url().'product';?>" style="padding-left: 13px"><i class="fa fa-shopping-cart"></i> Produk</a>
										</li>
										<div class="dropdown-divider"></div>
										<li class="nav-item d-none d-lg-block d-xl-none">
											<a class="nav-link" href="<?= base_url().'logout';?>" style="padding-left: 13px"><i class="fa fa-sign-out"></i> Logout</a>
										</li>
									<?php }elseif($page_active == 'product'){?>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'product/keranjang_belanja';?>" style="padding-left: 13px"><i class="fa fa-shopping-cart"></i> Keranjang Belanja <span class="badge badge-primary"><?= $_SESSION['jml_keranjang'];?></span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'product/konfirmasi_pembayaran';?>" style="padding-left: 13px"><i class="fa fa-pencil"></i> Konfirmasi Pembayaran <span class="badge badge-primary"><?= $_SESSION['jml_on_pembayaran'];?></span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'product/on_proses';?>" style="padding-left: 13px"><i class="fa fa-send"></i> Dalam Proses <span class="badge badge-primary"><?= $_SESSION['jml_on_proses'];?></span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'product/terkirim';?>" style="padding-left: 13px"><i class="fa fa-check"></i> Terkirim</a>
										</li>
										<div class="dropdown-divider"></div>
										<li class="nav-item d-none d-lg-block d-xl-none">
											<a class="nav-link" href="<?= base_url().'booking';?>" style="padding-left: 13px"><i class="fa fa-pencil-square-o "></i> Booking</a>
										</li>
										<div class="dropdown-divider"></div>
										<li class="nav-item d-none d-lg-block d-xl-none">
											<a class="nav-link" href="<?= base_url().'logout';?>" style="padding-left: 13px" id="sign_out"><i class="fa fa-sign-out"></i> Logout</a>
										</li>
									<?php }elseif($page_active == 'profile'){?>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'profile/ubah_data/'.$_SESSION['id_user'];?>" style="padding-left: 13px"><i class="fa fa-pencil"></i> Ubah Data</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="<?= base_url().'profile/ubah_password/'.$_SESSION['id_user'];?>" style="padding-left: 13px"><i class="fa fa-key"></i> Ubah Password</a>
										</li>
									<?php }?>
								<?php }else{ ;?>
									<!-- menu admin-->
									<div class="accordion">
										<button class="btn btn-link" href="#" data-toggle="collapse" data-target="#booking-menu">
											Booking
											<i class="fa fa-angle-down"></i>
										</button>
									</div>
									<div id="booking-menu" class="collapse">
										<a href="<?= base_url().'booking/booking_baru';?>" class="nav-link"><i class="fa fa-pencil"></i> Booking Baru</a>
										<a class="nav-link" href="<?= base_url().'booking/on_proses';?>" style="padding-left: 13px"><i class="fa fa-history"></i> Dalam Proses</a>
										<a href="<?= base_url().'booking/riwayat_booking';?>" class="nav-link"><i class="fa fa-book"></i> Riwayat Booking</a>
									</div>
									<div class="accordion">
										<button class="btn btn-link" href="#" data-toggle="collapse" data-target="#produk-menu">
											Produk
											<i class="fa fa-angle-down"></i>
										</button>
									</div>
									<div id="produk-menu" class="collapse">
										<a href="<?= base_url().'product/konfirmasi_pembayaran';?>" class="nav-link"><i class="fa fa-angle-right"></i> Konfirmasi Status Pembayaran</a>
										<a href="<?= base_url().'product/konfirmasi_pengiriman';?>" class="nav-link"><i class="fa fa-angle-right"></i> Konfirmasi Status Pengiriman</a>
									</div>
									<div class="dropdown-divider"></div>
									<div class="divider"></div>
									<div class="accordion">
										<button class="btn btn-link" href="#" data-toggle="collapse" data-target="#kelola-menu">
											Kelola Data
											<i class="fa fa-angle-down"></i>
										</button>
									</div>
									<div id="kelola-menu" class="collapse">
										<a href="<?= base_url().'kelola/member';?>" class="nav-link"><i class="fa fa-book"></i> Member</a>
										<a href="<?= base_url().'kelola/produk';?>" class="nav-link"><i class="fa fa-book"></i> Produk</a>
										<a href="<?= base_url().'kelola/facial';?>" class="nav-link"><i class="fa fa-book"></i> Facial</a>
									</div>
									<div class="accordion">
										<button class="btn btn-link" href="#" data-toggle="collapse" data-target="#laporan-menu">
											Laporan
											<i class="fa fa-angle-down"></i>
										</button>
									</div>
									<div id="laporan-menu" class="collapse">
										<a href="<?= base_url().'laporan/booking';?>" class="nav-link"><i class="fa fa-clipboard"></i> Booking</a>
										<a href="<?= base_url().'laporan/penjualan';?>" class="nav-link"><i class="fa fa-clipboard"></i> Penjualan Produk</a>
									</div>
									<div class="dropdown-divider"></div>
									<li class="nav-item">
										<a class="nav-link" href="<?= base_url().'profile/ubah_data/'.$_SESSION['id_user'];?>" style="padding-left: 13px"><i class="fa fa-pencil"></i> Ubah Data</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?= base_url().'profile/ubah_password/'.$_SESSION['id_user'];?>" style="padding-left: 13px"><i class="fa fa-key"></i> Ubah Password</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="<?= base_url().'logout';?>" style="padding-left: 13px" id="sign_out"><i class="fa fa-sign-out"></i> Logout</a>
									</li>
								<?php }?>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>

	</body>
	</html>


    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->

    	<script src="<?= base_url().'assets/js/jquery-3.3.1.min.js';?>"></script>

    	<script src="<?= base_url().'assets/select2-4.0.4/dist/js/select2.min.js';?>"></script>
    	<script src="<?= base_url().'assets/js/moment.js';?>"></script>
    	<script src="<?= base_url().'assets/js/bootstrap.min.js';?>"></script>
    	<script src="<?= base_url().'assets/datatables/DataTables-1.10.18/js/jquery.dataTables.js';?>"></script>
    	<script src="<?= base_url().'assets/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.js';?>"></script>
    	<script src="<?= base_url().'assets/js/gijgo.min.js';?>"></script>

    <!-- 
    	<script src="<?= base_url().'assets/js/popper.min.js';?>"></script> -->
    	<script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>

    	<!-- <script src="<?= base_url().'assets/fontawesome-free-5.5.0-web/js/all.min.js';?>"></script> -->
    	<script type="text/javascript" src="<?= base_url().'assets/datatables/Buttons-1.5.4/js/dataTables.buttons.js';?>"></script>
    	<script src="<?= base_url().'assets/datatables/Buttons-1.5.4/js/buttons.html5.min.js';?>"></script>
    	<script src="<?= base_url().'assets/js/test.js';?>"></script>
    	<script src="<?= base_url().'assets/datatables/Buttons-1.5.4/js/buttons.colVis.min.js';?>"></script>


    	<script>
    		$(document).ready(function(){

    			$("#btn-menu").on('click', function(){
    				$("#navbarNavDropdown").toggle('slow').removeClass('d-none d-lg-block');
    			})

    			$("#btn-menu-lg").on('click', function(){
    				$("#navbarNavDropdown").toggleClass('sr-only');
    				$('#main').toggleClass('col-lg-12');


    			})


    			$('#sign_out').on('click', function(e){
    				e.preventDefault();
    				swal({
    					type: 'question',
    					text: 'Yakin Keluar?',
    					showCancelButton: 'true',
    				}).then(function(){
    					window.location.href="<?=base_url().'User/logout';?>"; 
    				})
    			})
    		})
    	</script>
    	<!-- Icons -->
    <!-- <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
  -->
