
<main role="main" class="col-lg-9 offset-lg-2">
	<div class="container">
		<?= form_open('Booking/submit_booking',array('id'=>'form_booking'));?>
		<div class="row">
			<div class="col-lg-8 col-sm-12">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Lengkap</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="nama" value="<?= $role == 'user' ? $user->nama : '';?>" <?= $role == 'user' ? 'readonly' : '';?>>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Handphone</label>
					<div class="col-sm-9">
						<input type="text" value="<?= $role == 'user' ?$user->telepon : '';?>" class="form-control" name="telp" <?= $role == 'user' ? 'readonly' : '';?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Email</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="email" value="<?= $role == 'user' ? $user->email : '';?>" <?= $role == 'user' ? 'readonly' : '';?>>
					</div>
				</div>
              <!-- <div class="form-group row">
                <label class="col-sm-3 col-form-label">No. Member</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="no_member" value="<?= $user->no_member;?>" readonly>
                </div>
              </div> -->
              <div class="form-group row">

              	<label class="col-sm-3 col-form-label">Jenis Facial</label>
              	<div class="col-sm-9">
              		<select class="form-control custom-select" name="jenis_facial">
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
              		<input type="text" class="form-control datepicker" name="tanggal">
              	</div>
              </div>
              <div class="form-group row">
              	<label class="col-sm-3 col-form-label">Jam</label>
              	<div class="col-sm-9">
              		<select name="jam" class="form-control custom-select">
              			<option value="">--pilih--</option>
              			<?php foreach($jam as $j):?>
              				<option value="<?= $j->jam;?>"><?= $j->jam;?></option>
              			<?php endforeach;?>
              		</select>
              	</div>
              </div>
              <div class="form-group row">
              	<div class="col-sm-12 text-right">
              		<button type="reset" class="btn btn-warning">Cancel</button>
              		<button class="btn btn-primary" type="submit" id="submit"><i class="fa fa-save"></i> kirim</button>
              	</div>
              </div>

            </div>
          </div>
          <?= form_close();?>
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
      			//disableDaysOfWeek: [0, 6],
      			maxDate: function(){
      				var date = new Date();
		            date.setDate(date.getDate()+150);
		            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
      			}
      		});

      		
      		$('#form_booking').on('submit', function(e){
      			let form = $(this);
      			e.preventDefault();
      			swal({
      				type: 'question',
      				text: 'Apakah data sudah benar?',
      				showCancelButton: true,
      				allowOutsideClick: false
      			}).then(function(){
      				$.ajax({
      					type: 'POST',
      					data: form.serialize(),
      					dataType: 'JSON',
      					url: '<?= base_url()."booking/submit_booking";?>',
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
      								window.location.href="<?=base_url().'booking/on_proses';?>"; 
      							})
      						}
      					}
      				})
      			})
      			
      		})

      		
      	})
      </script>