
<main role="main" class="col-lg-8 offset-lg-2 px-4" style="background:#f8f9fa !important;height: 100vh">
	<div class="container">
		<?= form_open('', array('id'=>'form_ubah'));?>
		<div class="row">
			
			<div class="col-lg-8 col-sm-12">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Kata Sandi Baru</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" value="<?= $user->id_user;?>" name="id_user" hidden>
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
			let p = $('#pass').val();
			let cp = $('#confpass').val();

			if(p != cp){
				swal({
					'type': 'error',
					'text': 'Password tidak sama',
					allowOutsideClick: false
				})
			}else{

				let form = this;
				swal({
					type: 'question',
					text: 'Yakin?',
					showCancelButton: true,
					allowOutsideClick: false
				}).then(function(){
					$.ajax({
						type: 'POST',
						data: $(form).serialize(),
						dataType: 'JSON',
						url: '<?= base_url()."profile/submit_ubah_password";?>',
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
			}
		})
	})
</script>