
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-12 col-lg-12 text-center">
            <strong><h3>Kelola Data Facial</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
            <button class="btn btn-sm btn-primary" id="btn-tambah">[+] Tambah Data</button>
            <table class="table table-bordered">
              <thead class="bg-primary text-white text-center ">
                <tr>
                  <th>No.</th>
                  <th>Nama Facial</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th colspan="1">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($facial as $r) {?>
                <tr>
                  <td><?= $no++;?></td>
                  <td><?= $r->nama;?></td>
                  <td><?= $r->deskripsi;?></td>
                  <td><?= titik($r->harga);?></td>
                  <td><?= $r->status;?></td>
                 
                  <td><button class="btn btn-sm btn-warning text-white edit" data-id="<?= $r->id_facial;?>">Ubah</button></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?= form_open('',array('id'=>'form_tambah'));?>
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Facial</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Deskripsi</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="keterangan"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Harga</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="harga" min="1">
                    </div>
                  </div>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="simpan">Simpan</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?= form_open('',array('id'=>'form_edit'));?>
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Facial</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama" id="nama">
                      <input type="text" class="form-control sr-only" name="id" id="id_facial">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Deskripsi</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Harga</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="harga" min="1" id="harga">
                    </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Status</label>
                     <div class="col-sm-9">
                      <select name="status" class="form-control custom-select" id="status">
                        <option value="Aktif">Aktif</option>
                        <option value="Non Aktif">Non Aktif</option>
                      </select>
                     </div>
                  </div>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="btn-edit">Ubah</button>
          </div>
        </div>
      </div>
    </div>


    <script>

      $(document).ready(function() {
        let today;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            minDate: today
        });

        $('#btn-tambah').on('click', function(e){
          $('#modal-tambah').modal('show');
        })
        
        $('.edit').on('click', function(e){
          $('#modal-edit').modal('show');
          let id = $(this).attr('data-id');
          $.ajax({
            type: 'POST',
            data: {id:id, data:'facial'},
            url: '<?= base_url()."Kelola/get_data_id";?>',
            success: function(result){
              let data = JSON.parse(result);

              $("#status option[value='"+data.status+"']").prop('selected', true);
              $('#id_facial').val(data.id_facial);
              $('#nama').val(data.nama);
              $('#keterangan').val(data.deskripsi);
              $('#harga').val(data.harga);
            }
          })
          

        })
        $('#btn-edit').on('click', function(e){
          swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: $('#form_edit').serialize(),
              dataType: 'JSON',
              url: '<?= base_url()."kelola/edit_facial";?>',
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
        $('#simpan').on('click', function(e){
          e.preventDefault();
          swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: $('#form_tambah').serialize(),
              dataType: 'JSON',
              url: '<?= base_url()."kelola/submit_facial";?>',
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