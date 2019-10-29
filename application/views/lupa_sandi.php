   <div class="container pt-5" id="border-form" >
      <div class="row justify-content-md-center ">
        <div class="col-lg-5 col-sm-12 pt-5">
          <div class="card border-warning shadow p-3 mb-5 bg-white rounded">
            <div class="card-header text-center font-weight-bold">
              LUPA SANDI
            </div>
            <div class="card-body" id="card-awal">
              <?php $attr = array('id'=>'form_ubah');?>
              <?= form_open('',$attr);?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                  <label>Tanggal Lahir</label>
                  <input type="text" class="form-control datepicker" name="tgl">
                </div>
                <button type="submit" id='btn-submit' class="btn btn-primary btn-block">Submit</button>
              <?= form_close();?>
            </div>

            <div class="card-body sr-only" id="card-pass">
              <?php $attr = array('id'=>'form_ubah_pass');?>
              <?= form_open('',$attr);?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" id="email" readonly>
                </div>
                <div class="form-group">
                  <label>Password Baru</label>
                  <input id="password_baru" type="password" class="form-control" name="password">
                </div>
                 <div class="form-group">
                  <label>Password Konfirmasi</label>
                  <input id="password_baru_conf" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
              <?= form_close();?>
            </div>

          </div>
        </div>
      </div>
    </div>

  <!-- FOOTER -->

</main>

<script>
   $(document).ready(function(){
     let today;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            
        });
    //login button on click
    $('#form_ubah').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type : 'POST',
        url : '<?=base_url()."user/cek_req_lupa";?>',
        dataType: 'JSON',
        data : $(this).serialize(),
        success: function(result){
          console.log(result);
          if(result.type == 'error'){
            swal({
              type: result.type,
              text: result.pesan,
            })

            $('#card-pass').addClass('sr-only');
          }else{
            $('#email').val(result.pesan);
           $('#card-pass').removeClass('sr-only');
           $('#card-awal').addClass('sr-only');
          }
        }
      })
    })

    //login button on click
    $('#form_ubah_pass').on('submit', function(e){

      let pb = $('#password_baru').val();
      let pc = $('#password_baru_conf').val();

      e.preventDefault();

      if(pb != pc){
        swal({
          type: 'error',
          text: 'Password tidak sama',
        })
      }else{
        $.ajax({
          type : 'POST',
          url : '<?=base_url()."user/pass_baru";?>',
          dataType: 'JSON',
          data : $(this).serialize(),
          success: function(result){
            console.log(result);
            if(result.type == 'error'){
              swal({
                type: result.type,
                text: result.pesan,
              })
            }else{
              swal({
                type: result.type,
                text: result.pesan,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
              }).then(function(){
                window.location.href="<?=base_url().'Welcome';?>"; 
              })
            }
          }
        })
      }
    })
  })

</script>
