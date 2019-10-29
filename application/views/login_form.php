   <div class="container pt-5" id="border-form" >
      <div class="row justify-content-md-center ">
        <div class="col-lg-5 col-sm-12 pt-5">
          <div class="card border-warning shadow p-3 mb-5 bg-white rounded">
            <div class="card-header text-center font-weight-bold">
              LOGIN
            </div>
            <div class="card-body">
              <?php $attr = array('id'=>'form_login');?>
              <?= form_open('',$attr);?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter Password">
                </div>
                <button type="submit" id='btn-submit' class="btn btn-primary btn-block">Submit</button>
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

    //login button on click
    $('#form_login').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type : 'POST',
        url : '<?=base_url()."user/submit_login";?>',
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
    })
  })

</script>
