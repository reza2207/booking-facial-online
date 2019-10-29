<main role="main" style="background:#f8f9fa !important">

  <div class="container bg-white" id="page-product">

    <!-- desktop-->
    <div class="row">
      <div class="col-lg-10 offset-2">
        <div class="row">

        	<?php 
        	if($keranjang->num_rows() > 0){?>
            
        	<div class="col-sm-12">
            <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-2"><strong>Harga</strong></div>
              <div class="col-sm-2"><strong>Jumlah</strong></div>
              <div class="col-sm-2"><strong>Subtotal</strong></div>
            </div>
            <hr>
            <?= form_open('', array('id'=>'form_add'));?>
            <?php foreach($keranjang->result() AS $row):;?>
            <div class="row pt-2">
              <div class="col-sm-4 text-center">

                <img src="<?= base_url().'gambar/'.$row->gambar;?>" height="100" width="150px" class="rounded border border-primary">
                <div><b><?= $row->nama;?></b></div>
              </div>
              <div class="col-sm-2 pt-5">
               Rp. <?= titik($row->harga);?>
               <input type="number" name="harga[]" id="harga<?= $row->id_temp_trans;?>" value="<?= $row->harga;?>" hidden>
               <input type="text" name="idtemp[]" value="<?= $row->id_temp_trans;?>" hidden>
               <input type="text" name="idproduk[]" value="<?= $row->id_produk;?>" hidden>
              </div>
              <div class="col-sm-2 pt-5">
                <input type="number" name="jumlah[]" min="0" max="<?= $row->sisa;?>" class="form-control jumlah" id="jumlah" data-id="<?= $row->id_temp_trans;?>" value="1">
              </div>
              <div class="col-sm-2 pt-5">
                <span id="subtotal<?= $row->id_temp_trans;?>">Rp. <?= titik($row->harga);?></span>
                <input type="number" class="subtotal sr-only" id="subs<?= $row->id_temp_trans;?>" value="<?= $row->harga;?>">
              </div>
              <div class="col-sm-2 pt-5">
               <button class="btn btn-sm btn-danger hapus" data-id="<?= $row->id_temp_trans;?>"><i class="fa fa-trash"></i></button>
              </div>
            </div>
            <hr>
            <?php endforeach;?>
            <?= form_close();?>
            <div class="row bg-light">
              <div class="col-sm-4"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"><b>Total</b></div>
              <div class="col-sm-2"><b><span id="total">Rp. </span></b></div>
            </div>

            <div class="row pt-5">
              <div class="col-sm-4"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"><button class="btn btn-primary" id="belanja" disabled><i class="fa fa-shopping-cart"></i> Belanja</button></div>
            </div>
          </div>
          <?php 
        	}else{; ?>
        		tidak ada data.
        	<?php }?>
          </div>
        
      </div>
    </div>
  </div>

</main>

<script>
	 $(document).ready(function(){
	 	jml();
    $('.jumlah').on('keyup', function(e){
      let id = $(this).attr('data-id');
      let jumlah = this.value;
      let idharga = '#harga'+id;
      let harga = $(idharga).val();
      let subtotal = jumlah*harga;
      let idsub = '#subtotal'+id;
      let max = $(this).attr('max');
      let idsubs = '#subs'+id;
      
      if(jumlah >= max){
       
        $(idsubs).val(0);
      }else if(jumlah > 0){
        $(idsubs).val(subtotal);
        $(idsub).text('Rp. '+ bilangan(subtotal));

      }else{
        $(idsubs).val(0);
        $(idsub).text('Rp. 0');
      }
      
      jml();
    })
    $('.jumlah').on('change', function(e){
      let id = $(this).attr('data-id');
      let jumlah = this.value;
      let idharga = '#harga'+id;
      let harga = $(idharga).val();
      let subtotal = jumlah*harga;
      let idsub = '#subtotal'+id;
      let max = $(this).attr('max');
      let idsubs = '#subs'+id;
      
      if(jumlah >= max){
       
        $(idsubs).val(0);
      }else if(jumlah > 0){
        $(idsubs).val(subtotal);
        $(idsub).text('Rp. '+ bilangan(subtotal));

      }else{
        $(idsubs).val(0);
        $(idsub).text('Rp. 0');
      }
      
      jml();
    })
    
    function jml()
    {
      let total = 0;
      $('.subtotal').each(function(){
        let value = parseInt($(this).val(), 10);
        if (!isNaN(value)){
             total = total + value
        }
        if(total > 0){

	        $('#belanja').attr('disabled', false);
	      }else{
      		$('#belanja').attr('disabled', true);
      	}
      	$('#total').text('Rp. '+bilangan(total));
      })

    }

    $('.hapus').on('click', function(e){
    	e.preventDefault();
    	let id = $(this).attr('data-id');
    	$.ajax({
    		type: 'POST',
    		data: {id:id},
    		dataType: 'JSON',
    		url : '<?= base_url()."product/hapus_keranjang";?>',
    		success: function(result){
    			swal({
            type: result.type,
            text: result.pesan,
            allowOutsideClick: false
          }).then(function(){
            window.location.href=""; 
          })
    		}
    	})
    })

		$('#belanja').on('click', function(e){
			let id = $(this).attr('data-id');
			
			$.ajax({
				type: 'POST',
				data: $('#form_add').serialize(),
				dataType: 'JSON',
				url: '<?= base_url()."product/proses_keranjang";?>',
				success: function(result){
					if(result.type == 'error'){
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            }).then(function(){
            	 window.location.href=""; 
            })
          }else{
            swal({
              type: result.type,
              text: result.pesan,
              allowOutsideClick: false
            }).then(function(){
              window.location.href="<?=base_url().'product/ringkasan_pesanan/';?>"+result.id; 
            })
          }
				}

			})
		})
	})
</script>