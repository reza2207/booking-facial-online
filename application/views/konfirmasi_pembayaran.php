
<main role="main" class="col-md-9 ml-sm-auto col-lg-10">
	<div class="container">
		<hr>
		<div class="row">
			<div class="col-12 col-lg-12 text-center">
				<strong><h3>KONFIRMASI PEMBAYARAN</h3></strong>
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
							<th>Aksi</th>
							
						</tr>
					</thead>
					<tbody class="text-center">
						<?php $no = 1; foreach ($transaksi->result() AS $r) {?>
							<tr>
								<td><?= $no++;?></td>
								<td><a href="#" class="detailtrans"><?= $r->id_transaksi;?></a></td>
								<td><?= $r->tgl_transaksi;?></td>
								<td><?= 'Rp. '.titik($r->total+10000);?></td>
								<td><?= $r->status;?></td>
								<td>
									<?php if($r->status == 'Menunggu Pembayaran'){?>

										<button class="btn btn-sm btn-primary uploadbukti" data-id="<?= $r->id_transaksi;?>"><i class="fa fa-upload" data-trans="<?= $r->tgl_transaksi;?>"></i> Upload Bukti Pembayaran</button>
									<?php }?>

								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>

<div class="modal fade" id="modalupload" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Konfirmasi Pembayaran</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open_multipart('',array('id'=>'form_upload'));?>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">ID. Transaksi</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="idtransaksi" readonly id="idtransaksi">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Tanggal Transfer</label>
							<div class="col-sm-9">
								<input type="text" class="form-control datepicker" name="tgl">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Jumlah Transfer</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" name="jumlah">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Dari Bank</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="bank">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Rekening</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="nama">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Upload Bukti Transfer</label>
							<div class="col-sm-9">
								<input type="file" class="form-control-file" name="bukti" id="bukti">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" id="upload">Upload</button>
			</div>
			<?= form_close();?>
		</div>
	</div>
</div>

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
<script>

	$(document).ready(function() {
		let today;
		today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
		$('.datepicker').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy',
			minDate: today
		});

		
		$('.uploadbukti').on('click', function(e){
			let id = $(this).attr('data-id');
			$('#modalupload').modal('show');
			$('#form_upload')[0].reset();
			$('#idtransaksi').val(id);
		})
		
		$('.detailtrans').on('click', function(e){
			let id = $(this).text();
			$('#modaldetail').modal('show');
			$('#titleidtransaksi').text(id);
			detail_trans(id)
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
						"<td class='text-right'>Rp. "+bilangan(data[i].jumlah *data[i].harga)+"</td>"+
						"</tr>";
						total += Number(data[i].jumlah *data[i].harga) ;
					}
					html += "<tr style='border-top: 1px solid black'><td colspan='2' class='text-right'> <b>Subtotal</b></td>"+
					"<td class='text-right'>Rp. "+bilangan(total)+"</td>"+
					"</tr>";
					html += "<tr><td colspan='2' class='text-right'> <b>Ongkos Kirim</b></td>"+
					"<td class='text-right'>Rp. 10.000</td>"+
					"</tr>";
					html += "<tr style='border-top: 1px solid black'><td colspan='2' class='text-right'> <b>Total</b></td>"+
					"<td class='text-right'>Rp. "+bilangan(total+10000)+"</td>"+
					"</tr>";
					$('#tabledetail').html(html);

				}
			})
			
		}

		$('#form_upload').on('submit', function(e){
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
					url: '<?= base_url()."product/submit_konfirmasi_pembayaran";?>',
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