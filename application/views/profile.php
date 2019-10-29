
<main role="main" class="col-lg-8 offset-lg-2 px-4" style="background:#f8f9fa !important;height: 100vh">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-sm-12">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Email : </label>
					<div class="col-sm-8">
            <input type="text" class="form-control" value="<?= $user->email;?>" readonly>
          </div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama :</label>
					<div class="col-sm-8">
					 	<input type="text" class="form-control" value="<?= $user->nama;?>" readonly>
					</div>
				</div>
				<?php if($_SESSION['role'] == 'user'){?>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Jenis Kelamin :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->jenis_kelamin;?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Telepon :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->telepon;?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Tanggal Lahir :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= tanggal($user->tgl_lahir);?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Alamat :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->alamat;?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">No. Member :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $user->no_member;?>" readonly>
					</div>
				</div>
				<?php }?>
			</div>
			
		</div>

	</div>
</main>
