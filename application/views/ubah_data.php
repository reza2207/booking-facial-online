
<main role="main" class="col-lg-8 offset-lg-2 px-4" style="background:#f8f9fa !important;height: 100vh">
	<div class="container">
		<?= form_open('', array('id'=>'form_ubah'));?>
		<div class="row">
			
			<div class="col-lg-8 col-sm-12">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Email : </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->id_user;?>" name="id_user" hidden>
						<input type="text" class="form-control" value="<?= $user->email;?>" name="email">
						<input type="text" class="form-control" value="<?= $user->email;?>" name="email_lama" hidden>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->nama;?>" name="nama">
					</div>
				</div>
				<?php if($_SESSION['role'] == 'user'){?>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Jenis Kelamin :</label>
						<div class="col-sm-8">
							<select class="form-control custom-select" name="jk">
								<option value="">-pilih-</option>
								<option value="Perempuan" <?= $user->jenis_kelamin == 'Perempuan' ? 'Selected' : '';?>>Perempuan</option>
								<option value="Laki-laki"<?= $user->jenis_kelamin == 'Laki-laki' ? 'Selected' : '';?>>Laki-laki</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Telepon :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= $user->telepon;?>" name="telepon">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Tanggal Lahir :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control datepicker" value="<?= tanggal($user->tgl_lahir);?>" name="tgllahir">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Alamat :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= $user->alamat;?>" name="alamat">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">No. Member :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= $user->no_member;?>" readonly>
						</div>
					</div>
				<?php }?>
				<div class="form-group row">
					<div class="col-sm-12 text-right">
						<button type="submit" class="btn btn-warning">Ubah</button>
					</div>
				</div>
			</div>
			
		</div>
		<?= form_close();?>
	</div>
</main>

<script>
	$(document).ready(function(){
		$('.datepicker').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy',
			maxDate: function(){
				var date = new Date();
				date.setDate(date.getDate()-1);
				return new Date(date.getFullYear(), date.getMonth(), date.getDate());
			}
		});
		$('#form_ubah').on('submit', function(e){
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
					data: $(form).serialize(),
					dataType: 'JSON',
					url: '<?= base_url()."profile/submit_ubah";?>',
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
								window.location.href="<?= base_url().'profile';?>"; 
							})
						}
					}
				})
			})
		})
	})
</script>