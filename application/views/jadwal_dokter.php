<body>
  <main role="main">

    <div class="container">

      <!-- desktop-->
      <div class="row">
        
        <div class="col-lg-12 hidden-md-down d-none d-lg-block">
          <h1 style="font-family: boulevard;" class="hellow text-center">- Farina Beauty Clinic -</h1>
          <h1 style="font-family: boulevard;" class="hellow text-center">Jakarta</h1>
         
          <br>
        </div>
        <div class="col-lg-12 d-lg-none text-center">
          <h4 style="font-family: boulevard;">- Farina Beauty Clinic -</h4>
          <h4 style="font-family: boulevard;">Jakarta</h4>
        </div>
      </div><!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <table class="table text-center table-hover table-striped table-bordered">
            <thead class="bg-dark text-white ">
              <tr>
                <th colspan="3">Jadwal Dokter</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td >Dokter Daisy</td>
                <td class="text-center">Senin, Selasa, Sabtu</td>
                <td class="text-center">11.00 sd 20.00 WIB</td>
              </tr>
              <tr>
                <td class="text-center">Dokter Martind</td>
                <td class="text-center">Rabu & Jumat</td>
                <td class="text-center">12.00 sd 20.00 WIB</td>
              </tr>
              <tr>
                <td class="text-center">Dokter Elsa</td>
                <td class="text-center">Kamis</td>
                <td class="text-center">11.00 sd 20.00 WIB</td>
              </tr>
           </tbody>
         </table>
       </div>
     </div>
       
       
     
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