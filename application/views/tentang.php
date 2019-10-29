<body>
  <main role="main">

    <div class="container">

      <!-- desktop-->
      <div class="row">
        
        <div class="col-lg-12 hidden-md-down d-none d-lg-block">
          <h1 style="font-family: boulevard;" class="hellow text-center">- Farina Beauty Clinic -</h1>
          <h1 style="font-family: boulevard;" class="hellow text-center">Jakarta</h1>
          <h2 class="hellow text-center">Sejarah Singkat Farina</h2>
          <h6 class="hellow text-justify">Farina Beauty Clinic didirikan oleh Dr. Virginia dkk pada tahun 2006 di Karawang atas dasar kepeduliannya terhadap kulit wanita yang berada di daerah tersebut karena Karawang memiliki karakteristik cuaca yang panas dan polusi yang tinggi. Seiring berjalannya waktu dan permintaan para pelanggan setia Farina, kini Farina Beauty Clinic sudah memiliki 13 cabang yang tersebar di JABODETABEK</h6>
          <br>
          <h2 class="hellow text-center">Visi & Misi Farina</h2>
          <h3 class="hellow text-center">Visi</h3>
          <ul class="text-justify" style="padding-left: 15px;">
            <li>Menjadikan Farina Beauty Clinic sebagai klinik perawatan wajah dan tubuh terbaik, penanganan dan tenaga yang paling prestisius dan ditambahkan, terbaik, terbesar dan terlengkap.</li>
          </ul>
          <h3 class="hellow text-center">Misi</h3>
          <ul class="text-justify" style="padding-left: 15px;">
            <li>Memperbaiki tingkat kesadaran masyarakat tentang pentingnya perawatan kulit wajah dan tubuh.</li>
            <li>Menjadikan Farina Klinik Kecantikan sebagai pusat perawatan wajah dan tubuh yang memiliki layanan ramah, nyaman, mewah, profseional, dengan harga terjangkau oleh semua lapisan masyarakat kota Karawang.</li>
            <li>Menyediakan perawatan wajah, tubuh dan rambut yang lengkap untuk memenuhi kebutuhan para wanita.</li>
            <li>Menjadi pilihan utama masyarakat Karawang untuk merawat wajah dan tubuh.</li>
          </ul>

          <br>

        </div>
        <div class="col-lg-12 d-lg-none">
          <h4 style="font-family: boulevard;" class=" text-center">- Farina Beauty Clinic -</h4>
          <h4 style="font-family: boulevard;" class=" text-center">Jakarta</h4>
          <h5 class="hellow text-center">Sejarah Singkat</h5>
          <h6 class="hellow text-justify">Farina Beauty Clinic didirikan oleh Dr. Virginia dkk pada tahun 2006 di Karawang atas dasar kepeduliannya terhadap kulit wanita yang berada di daerah tersebut karena Karawang memiliki karakteristik cuaca yang panas dan polusi yang tinggi. Seiring berjalannya waktu dan permintaan para pelanggan setia Farina, kini Farina Beauty Clinic sudah memiliki 13 cabang yang tersebar di JABODETABEK</h6>

          <h5 class="hellow text-center">Visi & Misi Farina</h5>
          <h6 class="hellow text-center">Visi</h6>
          <ul class="text-justify" style="padding-left: 15px;">
            <li>Menjadikan Farina Beauty Clinic sebagai klinik perawatan wajah dan tubuh terbaik, penanganan dan tenaga yang paling prestisius dan ditambahkan, terbaik, terbesar dan terlengkap.</li>
          </ul>
          <h6 class="hellow text-center">Misi</h6>
          <ul class="text-justify" style="padding-left: 15px;">
            <li>Memperbaiki tingkat kesadaran masyarakat tentang pentingnya perawatan kulit wajah dan tubuh.</li>
            <li>Menjadikan Farina Klinik Kecantikan sebagai pusat perawatan wajah dan tubuh yang memiliki layanan ramah, nyaman, mewah, profseional, dengan harga terjangkau oleh semua lapisan masyarakat kota Karawang.</li>
            <li>Menyediakan perawatan wajah, tubuh dan rambut yang lengkap untuk memenuhi kebutuhan para wanita.</li>
            <li>Menjadi pilihan utama masyarakat Karawang untuk merawat wajah dan tubuh.</li>
          </ul>
          
        </div>
      </div><!-- /.row -->
    </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">
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
              window.location.href="<?=base_url();?>"; 
            })
          }
        }
      })
    })
  })
</script>