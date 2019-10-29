<main role="main" style="background:#f8f9fa !important">

  <div class="container bg-white " id="page-product" style="height: 100vh">

    <!-- desktop-->
    <div class="row">
      <div class="col-lg-10 offset-2">
        <div class="row">

        	<?php 
        	if($product->num_rows() > 0){
            $row = $product->row();?>
        	
          <div class="col-sm-4">
            <div class="item-product-detail border-dark">
              <div class="item-picture-detail">
                <img src="<?= base_url().'gambar/'.$row->gambar;?>" style="">
              </div>
              
            </div>
          </div>
          <div class="col-sm-8">
            <div class="item-name-detail">
              <?= $row->nama;?>
            </div>
            <div class="item-detail">
              Rp. <?= titik($row->harga).',-';?>
            </div>
            <div class="item-detail">
              <?= $row->deskripsi;?>
            </div>
            <div class="item-detail">
              Stok: <?= $row->masuk - $row->keluar == 0 ? 'Kosong' : titik($row->masuk - $row->keluar). ' Pcs';?>
            </div>
            <?php 
            if(isset($_SESSION['role'])){?> 
            <div class="item-detail">
            	<?php if($row->masuk - $row->keluar > 0){?>
              <button data-id="<?= $row->id_produk;?>" class="btn btn-primary btn-block" id="btn-tambah"><i class="fa fa-shopping-cart"></i> Beli</button>
              <?php }?>
            </div>
          	<?php }?>
          </div>
        <?php 
      	}else{; ?>
      		Barang tidak ada.
      	<?php }?>
        </div>
        
      </div>
    </div>
  </div>

</main>

<script>
	 $(document).ready(function(){
		$('#btn-tambah').on('click', function(e){
			let id = $(this).attr('data-id');
			$.ajax({
				type: 'POST',
				data: {id:id},
				dataType: 'JSON',
				url: '<?= base_url()."product/keranjang";?>',
				success: function(result){
					if(result.type == 'error'){
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            }).then(function(){
            	 window.location.href="<?=base_url().'product/keranjang_belanja';?>"; 
            })
          }else{
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            }).then(function(){
              window.location.href="<?=base_url().'product';?>"; 
            })
          }
				}

			})
		})
	})
</script>