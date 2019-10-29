<body id="container-home">
  <main role="main">

    <div class="container">

      <!-- desktop-->
      <div class="row">
        
        <?php if(isset($_SESSION['logged_in'])){ //jika sudah login?>
        <?php if($_SESSION['role']=='admin'){?>
        <div class="col-lg-9 offset-lg-3 hidden-md-down d-none d-lg-block text-center">
        <?php }else{?>
          <div class="col-lg-12 hidden-md-down d-none d-lg-block text-center">
        <?php }?>
          <h1 style="font-family: boulevard;" class="hellow">- Farina Beauty Clinic -</h1>
          <h1 style="font-family: boulevard;" class="hellow">Jakarta</h1>
          
          <h2 class="hellow">SELAMAT DATANG DI FARINA BEAUTY CLINIC JAKARTA</h2>
          <br>
          <h3>Booking facial dan produk tinggal klik !</h3>
        </div>
        <?php }else{ //jika belum login?>
        <div class="col-lg-8 hidden-md-down d-none d-lg-block text-center">
        	<?php if(isset($warning)){?>
        		<div class="alert alert-warning"><h1><?= $warning;?></h1></div>


        	<?php }else{?>
          <h1 style="font-family: boulevard;" class="hellow">- Farina Beauty Clinic -</h1>
          <h1 style="font-family: boulevard;" class="hellow">Jakarta</h1>
          <h2 class="hellow">Jl. Raya Bogor No. 04, RT. 2/RW.13, Cililitan, Kramatjati, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13640</h2>
          <h2 class="hellow">Telp. (021) 80872329</h2>
          <h2 class="hellow">HP. 0821 3920 5076</h2>
          
        
      	<?php }}?>
      	</div>
        <div class="col-lg-12  d-lg-none text-center">
          <h5 style="font-family: boulevard;" class="hellow">- Farina Beauty Clinic -</h5>
          <h5 style="font-family: boulevard;" class="hellow">- Jakarta -</h5>
          <h6 class="hellow">Jl. Raya Bogor No. 04, RT. 2/RW.13, Cililitan, Kramatjati, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13640</h6>
          <h6 class="hellow">Telp. (021) 80872329</h6>
          <h6 class="hellow">HP. 0821 3920 5076</h6>
        </div>
        <?php if(isset($_SESSION['logged_in']) === false){?>
        <div class="col-lg-4 ">
          <div class="card shadow-lg p-3 mb-5 rounded" id="cardLogin">
            <div class="card-header text-center font-weight-bold">
              Masuk
            </div>
            <div class="card-body">
              <?php $attr = array('id'=>'form_login');?>
              <?= form_open('',$attr);?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Masukkan Email">
                </div>
                <div class="form-group">
                  <label>Kata Sandi</label>
                  <input type="password" class="form-control" name="password" placeholder="Masukkan Kata Sandi">
                </div>
                <button type="submit" id='btn-submit' class="btn btn-primary btn-block">Masuk</button>
              <?= form_close();?>
            </div>
            <div class="text-center">
              <a href="buat-akun">Buat akun?</a>
              <br>
              <a href="lupa-sandi">Lupa sandi?</a>
            </div>
          </div>
        </div>
        <?php }?>
        <?php 
        if(isset($_SESSION['logged_in'])){
          if($_SESSION['role']=='admin'){?>
          <div class="col-lg-9 offset-lg-3 hidden-md-down d-none d-lg-block text-center">
          <?php }else{?>
            <div class="col-lg-12 hidden-md-down d-none d-lg-block text-center">
          <?php }}else{?>
             <div class="col-lg-12 hidden-md-down d-none d-lg-block text-center">
          <?php }?>
          <div class="text-center text-white" style="font-family: boulevard;">Follow US</div>
          <div id="social-media" class="text-center">
            <a href="http://www.instagram.com" title="instagram" target="_blank" style="color:orange"><i class="fa fa-instagram" style="font-size: 3em;margin: 10px" ></i></a>  
            <a href="http://www.twitter.com" title="twitter" target="_blank"><i class="fa fa-twitter-square" style="font-size: 3em;margin: 10px"></i></a>
            <a href="http://www.youtube.com" title="youtube"  style="color:red" target="_blank"><i class="fa fa-youtube-square" style="font-size: 3em;margin: 10px"></i></a>
            <a href="http://www.facebook.com" title="facebook" target="_blank"><i class="fa fa-facebook-square" style="font-size: 3em;margin: 10px"></i></a>
          </div>
        </div>
      </div>
    </div>

  </main>
</body>

<script>
  $(document).ready(function(){

    $('#form_login').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type:'POST',
        url:'<?= base_url()."User/submit_login";?>',
        dataType: 'JSON',
        data: $(this).serialize(),
        success: function(result){
          if(result.type == 'error'){
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            })
          }else{
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            }).then(function(){
              window.location.href=""; 
            })
          }
        }
      })
    })
  })
</script>