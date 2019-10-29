
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-12 col-lg-12 text-center">
            <strong><h3>Terkirim</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
            
            <table class="table table-bordered">
              <thead class="bg-primary text-white text-center ">
                <tr>
                  <th>No.</th>
                  <th>ID. Transaksi</th>
                  <th>Tgl. Transaksi</th>
                  <th>Total</th>
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tbody class="text-center">
               <?php $no = 1; foreach ($transaksi->result() AS $r) {?>
               <tr>
                 <td><?= $no++;?></td>
                 <td><a href="#" class="detailtrans"><?= $r->id_transaksi;?></a></td>
                 <td><?= $r->tgl_transaksi == '0000-00-00 00:00:00' ? '-' : $r->tgl_transaksi;?></td>
                 <td><?= 'IDR. '.titik($r->total+10000);?></td>
                 <td><?= $r->status;?></td>
                 
               </tr>
               <?php }?>
             </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- modal ubah-->
      <div class="modal fade" id="modaledit" role="dialog">
      	<div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="titleeditidtransaksi">Ubah Alamat</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	          	<div class="row">
	              <div class="col-sm-12">
	                <?= form_open('', array('id'=>'form_alamat'));?>
	                <input type="text" class="form-control" name="idtransaksi" id="idtransaksi_e" value="" hidden>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Nama Penerima</label>
	                  <div class="col-sm-9">
	                    <input type="text" class="form-control" name="nama" id="nama_e" value="">
	                  </div>
	                </div>
	                
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Alamat Kirim</label>
	                  <div class="col-sm-9">
	                    <textarea type="text" name="alamat" class="form-control" id="alamat_e"></textarea>
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Telepon</label>
	                  <div class="col-sm-9">
	                    <input type="text" class="form-control" name="telepon" value="" id="telepon_e">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Kecamatan</label>
	                  <div class="col-sm-9">
	                    <select name="kecamatan" id="kecamatan_e" class="form-control custom-select">
	                		<option value="">--pilih--</option>
	                		<?php foreach($kecamatan AS $kec):?>
	                		
	                				<option value="<?= $kec->nama;?>"><?= $kec->nama;?></option>
	                		<?php endforeach;?>
	                		</select>
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Provinsi</label>
	                  <div class="col-sm-9">
	                    <input type="text" class="form-control" name="provinsi" value="DKI Jakarta" readonly id="provinsi_e">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Kode POS</label>
	                  <div class="col-sm-9">
	                    <input type="text" class="form-control" name="kodepos" value="" id="kodepos_e">
	                  </div>
	                </div>
	                <?= form_close();?>
	              </div>
	            </div>
	          </div>
	          <div class="modal-footer">
	          	<div class="row">
	          		<div class="col-sm-12">
	          			<button id="editalamat" class="btn btn-sm btn-warning ">Ubah Alamat</button>
	          		</div>
	          	</div>
	          </div>
	        </div>
	      </div>

      </div>
      <!-- modal detail-->
	    <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="titleidtransaksi"></h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <div class="row">
	              <div class="col-sm-12">
	                <table>
	                  <tr>
	                    <td width="200px">Nama</td>
	                    <td width="50px">:</td>
	                    <td id="nama">NamaCust</td>
	                  </tr>
	                  <tr>
	                    <td>Alamat</td>
	                    <td>:</td>
	                    <td id="alamat">AlamatCust</td>
	                  </tr>
	                  <tr>
	                    <td>Telepon</td>
	                    <td>:</td>
	                    <td id="telp">TelpCust</td>
	                  </tr>
	                  <tr>
	                    <td>Kecamatan</td>
	                    <td>:</td>
	                    <td id="kecamatan">Kecamatan</td>
	                  </tr>
	                  <tr>
	                    <td>Provinsi</td>
	                    <td>:</td>
	                    <td id="provinsi">Provinsi</td>
	                  </tr>
	                  <tr>
	                    <td>Kode POS</td>
	                    <td>:</td>
	                    <td id="kodepos">Kodepos</td>
	                  </tr>
	                </table>
	                <hr>
	                <table id="tabledetail" width="100%">
	                  

	                </table>
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
            minDate: today
        });
        $('.detailtrans').on('click', function(e){
          let id = $(this).text();
          $('#modaldetail').modal('show');
          $('#titleidtransaksi').text(id);
          detail_trans(id)
        })
        $('#btn-tambah').on('click', function(e){
          $('#modal-tambah').modal('show');
          $('#form_tambah')[0].reset();
        })
        $('.edit').on('click', function(){
        	let id = $(this).attr('data-id');
					$('#modaledit').modal('show');
				})

        $('.edit').on('click', function(e){
          let id = $(this).attr('data-id');
          $.ajax({
            type: 'POST',
            data: {id:id, data:'produk'},
            dataType: 'JSON',
            url: '<?= base_url()."product/get_trans/editdong";?>',
            success: function(result){
             
             	$('#idtransaksi_e').val(result.id_transaksi);
							$('#nama_e').val(result.nama);
							$('#alamat_e').val(result.alamat);
							$('#telepon_e').val(result.telepon);
							$('#kecamatan_e').val(result.kecamatan);
							$('#provinsi_e').val(result.provinsi);
							$('#kodepos_e').val(result.kodepos);


            }
          })
          
        })

        $('#editalamat').on('click', function(e){
        	
        	$.ajax({
        		type: 'POST',
        		url: '<?= base_url()."product/submit_alamat";?>',
        		dataType: 'JSON',
        		data: $('#form_alamat').serialize(),
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

        function detail_trans(id){
          $.ajax({
            type: 'POST',
            data: {id: id},
            dataType: 'JSON',
            url: '<?= base_url()."product/get_trans";?>',
            success: function(result){
              let datak = result.alamatkirim;
              $('#nama').text(datak.nama);
              $('#alamat').text(datak.alamat);
              $('#telp').text(datak.telepon);
              $('#kecamatan').text(datak.kecamatan);
              $('#provinsi').text(datak.provinsi);
              $('#kodepos').text(datak.kodepos);
              let data = result.detail;
              let html = "";
              let i;
              let total = 0;
              for(i = 0;i < data.length; i++){
              html += "<tr><td>"+data[i].jumlah+" x </td>"+
                           "<td>"+data[i].nama+"</td>"+
                           "<td class='text-right'>IDR. "+bilangan(data[i].jumlah *data[i].harga)+"</td>"+
                      "</tr>";
                      total += Number(data[i].jumlah *data[i].harga) ;
              }
              html += "<tr style='border-top: 1px solid black'><td colspan='2' class='text-right'> <b>Subtotal</b></td>"+
                        "<td class='text-right'>IDR. "+bilangan(total)+"</td>"+
                        "</tr>";
              html += "<tr><td colspan='2' class='text-right'> <b>Ongkos Kirim</b></td>"+
                        "<td class='text-right'>IDR. 10.000</td>"+
                        "</tr>";
              html += "<tr style='border-top: 1px solid black'><td colspan='2' class='text-right'> <b>Total</b></td>"+
                        "<td class='text-right'>IDR. "+bilangan(total+10000)+"</td>"+
                        "</tr>";
              $('#tabledetail').html(html);

            }
          })
            
        }

       
      })
    </script>