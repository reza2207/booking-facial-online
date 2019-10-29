
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-12 col-lg-12 text-center">
            <strong><h3>Kelola Data Member</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
            <table class="table table-bordered">
              <thead class="bg-primary text-white text-center ">
                <tr>
                  <th>No.</th>
                  <th>No. Member</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Tgl. Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Status</th>
                  <th colspan="1">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($user->result() as $r) {?>
                <tr>
                  <td><?= $no++;?></td>
                  <td><?= $r->no_member;?></td>
                  <td><?= $r->nama;?></td>
                  <td><?= $r->alamat;?></td>
                 	<td><?= $r->telepon;?></td>
                 	<td><?= $r->email;?></td>
                  <td><?= $r->tgl_lahir;?></td>
                  <td><?= $r->jenis_kelamin;?></td>
                 	<td><?= $r->status;?></td>
                  <td><button class="btn btn-sm btn-warning text-white edit" data-id="<?= $r->email;?>">Ubah</button></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?= form_open('',array('id'=>'form_edit'));?>
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nomor Member</label>
                    <div class="col-sm-9">
                    	<input type="text" class="form-control" name="id_user" id="id_user_e" hidden>
                      <input type="text" class="form-control" name="no_member" id="no_member_e">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama" id="nama_e" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="alamat" id="alamat_e" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Telepon</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="telepon" id="telepon_e" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="email" id="email_e" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tgl. Lahir</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir_e" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                       <select class="form-control custom-select" name="jk" id="jk_e" readonly>
		                    <option value="">-pilih-</option>
		                    <option value="Perempuan">Perempuan</option>
		                    <option value="Laki-laki">Laki-laki</option>
		                  </select>
                    </div>
                  </div>
                  
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-edit">Simpan</button>
          </div>
        </div>
      </div>
    </div>
    
    

    <script>

      $(document).ready(function() {
        
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy'
        });


        $('#btn-tambah').on('click', function(e){
          $('#modal-tambah').modal('show');
        })
        
        $('.edit').on('click', function(e){
          $('#modal-edit').modal('show');
          let id = $(this).attr('data-id');
          $.ajax({
            type: 'POST',
            data: {id:id, data:'pasien'},
            url: '<?= base_url()."Kelola/get_data_id";?>',
            success: function(result){
              let data = JSON.parse(result);

              $("#jk_e option[value='"+data.jenis_kelamin+"']").prop('selected', true);
              $('#id_user_e').val(data.id_user);
              $('#nama_e').val(data.nama);
              $('#telepon_e').val(data.telepon);
              $('#email_e').val(data.email);
              $('#alamat_e').val(data.alamat);
              $('#no_member_e').val(data.no_member);
              $('#tgl_lahir_e').val(tanggal(data.tgl_lahir));
            }
          })
          

        })
        $('#btn-edit').on('click', function(e){
          swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: $('#form_edit').serialize(),
              dataType: 'JSON',
              url: '<?= base_url()."kelola/edit_user";?>',
              success: function(result){
                let message = result.pesan;
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
        

       
      })
    </script>