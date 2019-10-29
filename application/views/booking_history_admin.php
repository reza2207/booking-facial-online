
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
        	<div class="col-12 col-lg-12 text-center">
            <strong><h3>Data Booking Dalam Proses</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
            <table class="table text-center table-striped">
              <thead class="bg-primary text-white">
                <tr>
                  <th>No.</th>
                  <th>Order ID</th>
                  <th>Dibooking Oleh</th>
                  <th>Nama</th>
                  <th>Tanggal</th>
                  <th>Jam</th>
                  <th>Jenis</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach($riwayat->result() AS $row):?>
                  <tr>
                    <td><?= $no++;?></td>
                    <td><?= $row->id_booking;?></td>
                    <td><?= $row->bookby;?></td>
                    <td><?= $row->nama;?></td>
                    <td><?= tanggal($row->tanggal);?></td>
                    <td><?= $row->jam;?></td>
                    <td><?= $row->jenis_facial;?></td>
                    <td><?= 'Rp '.titik($row->harga).',-';?></td>
                    <td><?= $row->status;?></td>
                    <td>
                    
                    <?php if($row->status != 'Selesai'){;?>
                      <button class="btn btn-warning btn-sm edit text-white" data-id="<?= $row->id_booking;?>">UBAH</button>
                      <button class="btn btn-success btn-sm selesai text-white" data-id="<?= $row->id_booking;?>">SELESAI</button>
                      <button class="btn btn-danger btn-sm cancel text-white" data-id="<?= $row->id_booking;?>">BATAL</button>
                    <?php }?>

                    	
                    </td>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
         <div class="row">
        	<div class="col-sm-12"><?= $pagination;?></div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning text-white">
              <div class="d-flex flex-column bd-highlight">
                <h5 class="modal-title">Ubah Data</h5>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row" id="surat-jalan">
                <?= form_open('', array('id'=>'form_edit'));?>
                <div class="col-12 col-lg-12">
                  <div class="form-group row">
                    <input type="text" class="form-control sr-only" id="id" name="id">
                    <label class="col-sm-3 col-form-label">Jenis Facial</label>
                    <div class="col-sm-9">
                      <select class="form-control custom-select" name="jenis_facial" id="jenis">
                        <option value="">--pilih--</option>
                        <?php foreach($facial as $f):?>
                        <option value="<?= $f->id_facial;?>"><?= $f->nama.' | Rp. '.titik($f->harga).',-';?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tanggal</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control datepicker" id="tanggal" name="tanggal">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jam</label>
                    <div class="col-sm-9">
                      <select name="jam" id="jam" class="form-control custom-select">
                        <option value="">--pilih--</option>
                        <?php foreach($jam as $j):?>
                        <option value="<?= $j->jam;?>"><?= $j->jam;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <?= form_close();?>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-12 col-lg-12">
                  <button class="btn btn-sm btn-warning btn-approve" id="edit">Kirim</button>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>

    </main>

    <script>

      $(document).ready(function() {
        let today;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            minDate: today,
            allowOutsideClick: false
        });
        
        
        $(".edit").on('click', function(e){
          let id = $(this).attr('data-id');
          swal({
            type: 'question',
            text: 'Apakah yakin akan mengubah data? hanya 1 kali kesempatan',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
            $('#modal-edit').modal('show');
            $('#id').val(id);
            $.ajax({
              type: 'POST',
              data: {id:id},
              url: '<?= base_url()."Booking/get_data";?>',
              success: function(result){
                let data = JSON.parse(result);
                $("#jenis option[value='"+data.id_facial+"']").prop('selected', true);
                $('#tanggal').val(tanggal(data.tanggal));
                $('#jam').val(data.jam);
              }
            })
          })
        })

        $('#edit').on('click', function(e){
        	$.ajax({
        		type: 'POST',
        		data: $('#form_edit').serialize(),
        		url: '<?= base_url()."booking/edit_data_booking";?>',
        		success: function(result){
        			let data = JSON.parse(result);
        			if(data.type == 'error'){
        				swal({
			            type: data.type,
			            text: data.pesan,
			            allowOutsideClick: false
			          })
        			}else{
        				swal({
			            type: data.type,
			            text: data.pesan,
			            allowOutsideClick: false
			          }).then(function(){
			          	window.location.href="";
			          })
        			}
        			
        		}
        	})
        })



        $(".cancel").on('click', function(e){

          let id = $(this).attr('data-id');
          swal({
            type: 'question',
            text: 'Apakah yakin akan membatalkan?',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: {id:id},
              dataType: 'JSON',
              url: '<?= base_url()."Booking/batal";?>',
              success: function(result){
                window.location.href="";
              }
            })
          })
        })

        $(".selesai").on('click', function(e){
        	let id = $(this).attr('data-id');
          swal({
            type: 'question',
            text: 'Yakin?',
            showCancelButton: true,
            allowOutsideClick: false
          }).then(function(){
            $.ajax({
              type: 'POST',
              data: {id:id},
              dataType: 'JSON',
              url: '<?= base_url()."booking/selesai";?>',
              success: function(result){
                window.location.href="";
              }
            })
          })
        })

       
      })
    </script>