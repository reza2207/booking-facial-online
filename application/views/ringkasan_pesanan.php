<style>
	#tbl-ringkasan tr td:first-child{
		font-weight: bolder
	}
</style>
<main role="main" style="background:#f8f9fa !important">

  <div class="container bg-white" id="page-product">

    <!-- desktop-->

    <?php if($status == null){?>
    <div class="row">
			<div class="col-12 col-lg-12 text-center">
        <strong><h3>Ringkasan Pesanan</h3></strong>
      </div>
      <div class="col-lg-10 offset-2">
        <div class="row">
          <div class="col-sm-6 pt-5">
            
            <div class="row">
            	<div class="col-sm-12">
            		<?= form_open('', array('id'=>'form_alamat'));?>
            		<input type="text" class="form-control" name="idtransaksi" value="<?= $produk->row()->id_transaksi;?>" hidden>
	            	<div class="form-group row">
	                <label class="col-sm-3 col-form-label">Nama Penerima</label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" name="nama" value="<?= $alt->num_rows() == 0 ? '' : $alt->row()->nama;?>">
	                </div>
	              </div>
	              
	              <div class="form-group row">
	                <label class="col-sm-3 col-form-label">Alamat Kirim</label>
	                <div class="col-sm-9">
	                  <input type="text" name="alamat" class="form-control" value="<?= $alt->num_rows() == 0  ? '' : $alt->row()->alamat;?>">
	                </div>
	              </div>
	              <div class="form-group row">
	                <label class="col-sm-3 col-form-label">Telepon</label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" name="telepon" value="<?= $alt->num_rows() == 0  ? '' : $alt->row()->telepon;?>">
	                </div>
	              </div>
	              <div class="form-group row">
	                <label class="col-sm-3 col-form-label">Kecamatan</label>
	                <div class="col-sm-9">
	                	<select name="kecamatan" id="sel-kec" class="form-control custom-select">
	                		<option value="">--pilih--</option>
	                		<?php foreach($kecamatan AS $kec):?>
	                			
	                			<?php if($alt->num_rows() != 0){?>
	                				<option value="<?= $kec->nama;?>" <?= $alt->row()->kecamatan == $kec->nama ? 'Selected' : '';?>><?= $kec->nama;?></option>
	                			<?php }else{?>
	                				<option value="<?= $kec->nama;?>"><?= $kec->nama;?></option>
	                			<?php }?>
	                		<?php endforeach;?>
	                	</select>
	                  <!-- <input type="text" class="form-control" name="kecamatan" value="<?= $alt->num_rows() == 0  ? '' : $alt->row()->kecamatan;?>"> -->
	                </div>
	              </div>
	              <div class="form-group row">
	                <label class="col-sm-3 col-form-label">Provinsi</label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" name="provinsi" value="DKI Jakarta" readonly>
	                </div>
	              </div>
	              <div class="form-group row">
	                <label class="col-sm-3 col-form-label">Kode POS</label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" name="kodepos" value="<?= $alt->num_rows() == 0 ? '' : $alt->row()->kodepos;?>">
	                </div>
	              </div>
	              <?= form_close();?>
	            </div>
	          </div>
          </div>
          <div class="col-sm-6 pt-5">
          	<table>
          		<?php foreach($produk->result() as $p){?>
          		<tr>
          			<td><?= $p->jumlah;?>x </td>
          			<td><?= $p->nama;?></td>
          			<td style="padding-left: 50px"><?= 'IDR. '.titik($p->harga*$p->jumlah);?></td>
          		</tr><?php $total[] = $p->harga*$p->jumlah;?>
          	<?php }?>

          		<tr style="border-top: 1px solid black">
          			<td colspan="2" class="text-right">Subtotal</td>
          			<td style="padding-left: 50px"><?= 'IDR. '.titik(array_sum($total));?></td>
          		</tr>
          		<tr>
          			<td colspan="2" class="text-right">Ongkos Kirim</td>
          			<td class="text-right">IDR. 10.000</td>
          		</tr>
          		<tr style="border-top: 1px solid black">
          			<td colspan="2" class="text-right">Total</td>
          			<td style="padding-left: 50px"><?= 'IDR. '.titik(array_sum($total)+10000);?></td>
          		</tr>

          	</table>
          </div>
        </div>
        <div class="row ">
        	<button class="btn btn-primary" id="submit">Selesai Belanja</button>
        </div>
            
        
      </div>
    </div>
    <?php }elseif($status == 'ada' && $produk->row()->status == 'Menunggu Pembayaran'){?>
		<div class="row">
			<div class="col-12 col-lg-10 offset-2 text-center">
        <strong><h3>Ringkasan Pesanan</h3></strong>
      </div>
      <div class="col-lg-10 offset-2">
        <div class="row">
          <div class="col-sm-6 pt-4">
          	<table style="margin-bottom: 50px" id="tbl-ringkasan">
          		<tr>
          			<td width="200px">Nama</td>
          			<td width="50px">:</td>
          			<td><?= $alamat->nama;?></td>
          		</tr>
          		<tr>
        				<td>Alamat</td>
        				<td>:</td>
        				<td><?= $alamat->alamat;?></td>
        			</tr>
        			<tr>
        				<td>Telepon</td>
        				<td>:</td>
        				<td><?= $alamat->telepon;?></td>
        			</tr>
        			<tr>
        				<td>Kecamatan</td>
        				<td>:</td>
        				<td><?= $alamat->kecamatan;?></td>
        			</tr>
        			<tr>
        				<td>Provinsi</td>
        				<td>:</td>
        				<td><?= $alamat->provinsi;?></td>
        			</tr>
        			<tr>
        				<td>Kode POS</td>
        				<td>:</td>
        				<td><?= $alamat->kodepos;?></td>
        			</tr>
          	</table>
          	<table class="pt-4">
          		<?php foreach($produk->result() as $p){?>
          		<tr>
          			<td><?= $p->jumlah;?>x </td>
          			<td><?= $p->nama;?></td>
          			<td style="padding-left: 50px"><?= 'IDR. '.titik($p->harga*$p->jumlah);?></td>
          		</tr><?php $total[] = $p->harga*$p->jumlah;?>
          	<?php }?>

          		<tr style="border-top: 1px solid black">
          			<td colspan="2" class="text-right">Subtotal</td>
          			<td style="padding-left: 50px"><?= 'IDR. '.titik(array_sum($total));?></td>
          		</tr>
          		<tr>
          			<td colspan="2" class="text-right">Ongkos Kirim</td>
          			<td class="text-right">IDR. 10.000</td>
          		</tr>
          		<tr style="border-top: 1px solid black">
          			<td colspan="2" class="text-right"><b>Total</b></td>
          			<td style="padding-left: 50px"><b><?= 'IDR. '.titik(array_sum($total)+10000);?></b></td>
          		</tr>

          	</table>
          </div>
        </div>
            
      </div>
      <div class="col-lg-10 offset-2 pt-5">
        <div class="row ">
        	<div class="col-12 col-lg-12 text-center">
	        	Batas Waktu pembayaran adalah 3 jam terhitung sejak anda "Selesai Belanja". Apabila sampai batas waktu yang ditentukan Anda tidak melakukan pembayaran, maka secara otomatis pesanan akan terbatalkan oleh sistem.
	        </div>
        </div>
        <div class="row  text-center">
        	<div class="col-12 col-lg-12 text-center">
	        	Waktu Kadaluarsa Pembayaran : <b><?= $tgl_expired;?></b>
	        </div>
        </div>
        <div class="row text-center">
        	<div class="col-12 col-lg-12 text-center">
        		Pembayaran ditransfer ke rekening:
        	</div>
        </div>
        <div class="row text-center">
        	<div class="col-12 col-lg-12 text-center">
        		BCA - PT. Virginia Estetika 086768247
        	</div>
        </div>
      </div>

    </div>
    <?php }elseif($produk->row()->status == 'Batal'){?>
    	<div class="row">
    		<div class="col-12 col-lg-10 offset-2 text-center">
	        <strong><h3>Ringkasan Pesanan</h3></strong>
	      </div>
	      <div class="col-lg-10 offset-2">
	      	Pesanan Dibatalkan / Waktu pembayaran sudah expired.
	      </div>
    	</div>
    <?php }?>
  </div>

</main>

<script>
	 $(document).ready(function(){

	 	$('#submit').on('click', function(e){
	 		e.preventDefault();
	 		$.ajax({
	 			type: 'POST',
	 			data: $('#form_alamat').serialize(),
	 			dataType: 'JSON',
	 			url: '<?= base_url()."product/submit_alamat";?>',
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
</script>