
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-12 col-lg-12 text-center">
            <strong><h3>Kelola Data Produk</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
            <button class="btn btn-sm btn-primary" id="btn-tambah">[+] Tambah Data</button>
            <table class="table table-bordered">
              <thead class="bg-primary text-white text-center ">
                <tr>
                  <th>No.</th>
                  <th>Gambar</th>
                  <th>Nama Produk</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Jumlah Masuk</th>
                  <th>Jumlah Keluar</th>
                  <th>Sisa</th>
                  <th>Status</th>
                  <th colspan="1">Aksi</th>
                </tr>
              </thead>
              <tbody>
               <?php $no = 1; foreach ($produk AS $r) {?>
               <tr>
                 <td><?= $no++;?></td>
                 <td><img width="100px" height="100px" src="<?= base_url().'gambar/'.$r->gambar;?>" alt="gambar tidak ditemukan"></td>
                 <td><?= $r->nama;?></td>
                 <td><?= $r->deskripsi;?></td>
                 <td class="text-right"><?= titik($r->harga);?></td>
                 <td class="text-right"><?= titik($r->masuk);?></td>
                 <td class="text-right"><?= titik($r->keluar);?></td>
                 <td class="text-right"><?= titik($r->masuk - $r->keluar);?></td>
                 <td class="text-center"><?= $r->status;?></td>
                
                 <td class="text-center"><button class="btn btn-sm btn-warning text-white edit" data-id="<?= $r->id_produk;?>">Ubah</button><button class="btn btn-sm btn-secondary text-white stok" data-id="<?= $r->id_produk;?>">Tambah Stok</button></td>
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
          <?= form_open_multipart('',array('id'=>'form_tambah'));?>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Produk</label>
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
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gambar</label>
                  <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="gambar" id="gambar" value="ss">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
          </div>
          <?= form_close();?>
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
          <?= form_open('',array('id'=>'form_edit'));?>
          <div class="modal-body">
            
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Produk</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="nama" id="nama">
                      <input type="text" class="form-control sr-only" name="id" id="id_produk">
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
	                  <label class="col-sm-3 col-form-label">Gambar Lama</label>
	                  <div class="col-sm-9">
	                  	<input type="text" class="form-control" name="gambarlama" readonly id="gambarlama">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Gambar Baru</label>
	                  <div class="col-sm-9">
	                    <input type="file" class="form-control-file" name="gambar">
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
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning" id="btn-edit">Ubah</button>
          </div>
          <?= form_close();?>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-stok" tabindex="-1" role="dialog">
      <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?= form_open_multipart('',array('id'=>'form_tambah_stok'));?>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jumlah</label>
                  <div class="col-sm-9">
                  	<input type="text" id="id_produk_stok" name="id_produk" hidden>
                    <input type="number" class="form-control" name="jumlah" min="1">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
          </div>
          <?= form_close();?>
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
          $('#form_tambah')[0].reset();
        })
        
        $('.edit').on('click', function(e){
          $('#modal-edit').modal('show');
          let id = $(this).attr('data-id');
          $.ajax({
            type: 'POST',
            data: {id:id, data:'produk'},
            url: '<?= base_url()."Kelola/get_data_id";?>',
            success: function(result){
              let data = JSON.parse(result);

              $("#status option[value='"+data.status+"']").prop('selected', true);
              $('#id_produk').val(data.id_produk);
              $('#nama').val(data.nama);
              $('#keterangan').val(data.deskripsi);
              $('#harga').val(data.harga);
              $('#gambarlama').val(data.gambar);
            }
          })
          

        })
        $('#form_edit').on('submit', function(e){
        	e.preventDefault();
        	let form = this;
          swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: new FormData(form),
              dataType: 'JSON',
              contentType: false,
              cache: false,
              processData:false,
              url: '<?= base_url()."kelola/edit_produk";?>',
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
                  }).then(function(){
                    window.location.href=""; 
                  })
                }
              }
            })
          })
        })
        
        $('.stok').on('click', function(e){
        	e.preventDefault();
        	let id = $(this).attr('data-id');
        	$('#id_produk_stok').val(id);
        	$('#modal-stok').modal('show');
        })

        $('#form_tambah_stok').on('submit', function(e){
        	e.preventDefault();
        	let form = this;
        	swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
	        	$.ajax({
	        		type: 'POST',
	        		url: '<?= base_url()."Kelola/add_stok";?>',
	        		dataType: 'JSON',
	        		data: $(form).serialize(),
	        		success: function(result){
	              if(result.type == 'error'){
	                swal({
	                  type: result.type,
	                  text: result.pesan,
	                })
	              }else{
	                swal({
	                  type: result.type,
	                  text: result.pesan,
	                }).then(function(){
	                  window.location.href=""; 
	                })
	              }
	        		}
	        	})
	        })
        })

        $('#form_tambah').on('submit', function(e){
          e.preventDefault();
          let form = this;
          swal({
            type: 'question',
            text: 'Apakah data sudah benar?',
            showCancelButton: true,
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: new FormData(form),
              dataType: 'JSON',
              contentType: false,
              cache: false,
              processData:false,
              url: '<?= base_url()."kelola/submit_produk";?>',
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


       
      })
    </script>