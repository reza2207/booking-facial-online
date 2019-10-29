<main role="main" style="background:#f8f9fa !important">

  <div class="container bg-white" id="page-product">


    <div class="row">
      <div class="col-lg-10 offset-lg-2 col-sm-12">
        <div class="row">

        	<?php 
        	if($product->num_rows() > 0){
        	foreach($product->result() AS $row):?>
          <div class="col-sm-3">
            <div class="item-product border-primary">
              <div class="item-picture">
                <img src="<?= base_url().'gambar/'.$row->gambar;?>" style="">
              </div>
              <div class="item-name">
              	<?= $row->nama;?>
              </div>
              <div class="item-harga">
                Rp. <?= titik($row->harga).',-';?>
              </div>
              
              <div class="tombol-beli">
                <a href="<?= base_url().'product/beli/'.$row->id_produk;?>" class="btn btn-primary text-white">Detail</a>

              </div>
              
            </div>

          </div>
        <?php endforeach;
      	}else{; ?>
      		Barang tidak ada.
      	<?php }?>
        </div>
        <div class="row">
        	<div class="col-sm-12"><?= $pagination;?></div>
        </div>
      </div>
    </div>
  </div>

</main>