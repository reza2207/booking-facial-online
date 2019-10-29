
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	<div class="container">
		<?php $attr = array('id'=>'form_register');?>
		<?= form_open('',$attr);?>
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Email</label>
					<div class="col-sm-9">
						<input type="email" class="form-control" name="email" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Kata Sandi</label>
					<div class="col-sm-9">
						<input type="password" id="pass" class="form-control" name="password">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Konfirmasi Kata Sandi</label>
					<div class="col-sm-9">
						<input type="password" id="confpass" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Lengkap</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="nama">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Jenis Kelamin</label>
					<div class="col-sm-9">
						<select class="form-control custom-select" name="jk">
							<option value="">-pilih-</option>
							<option value="Perempuan">Perempuan</option>
							<option value="Laki-laki">Laki-laki</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Telepon</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="telp">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Tanggal Lahir</label>
					<div class="col-sm-9">
						<input type="text" class="form-control datepicker" name="tgllahir">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Alamat</label>
					<div class="col-sm-9">
						<textarea type="text" class="form-control" name="alamat"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<input type="checkbox" id="checkbox" checked="true"> Saya menyetujui kebijakan pengguna dan perusahaan.
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12 text-right">
						<button type="reset" class="btn btn-warning">Cancel</button>
						<button class="btn btn-primary" type="submit" id="submit" disabled="true"><i class="fa fa-save"></i> Daftar</button>
					</div>
				</div>

			</div>
		</div>
		<?= form_close();?>
	</div>
</main>

<script>

	$(document).ready(function() {

		$('.datepicker').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy',
			maxDate: function(){
				var date = new Date();
				date.setDate(date.getDate()-1);
				return new Date(date.getFullYear(), date.getMonth(), date.getDate());
			}
		});

		if($('#checkbox').prop("checked") == true){
			$('#checkbox').prop("checked",false);
		}
		$('#checkbox').on('click', function(){

			if($(this). prop("checked") == true){
				$('#submit').attr('disabled', false);
			}else{
				$('#submit').attr('disabled',true);
			}
    })/*else{
          
		}*/
		$('#form_register').on('submit', function(e){

			e.preventDefault();
			let p = $('#pass').val();
			let cp = $('#confpass').val();

			if(p != cp){
				swal({
					type: 'error',
					text: 'Password tidak sama',
					allowOutsideClick: false
				})
			}else{
				$.ajax({
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'JSON',
					url: '<?= base_url()."User/submit_user";?>',
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
								if(result.iduser === undefined){
									window.location.href="<?=base_url();?>";
								}else{
								window.location.href="<?=base_url().'user/halaman_verifikasi/';?>"+result.iduser; 
								}
							})
						}
					}
				})
			}
		})


	})
</script>