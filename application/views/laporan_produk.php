
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-12 col-lg-12 text-center">
            <strong><h3>Laporan Harian Penjualan Produk</h3></strong>
          </div>
          <div class="col-12 col-lg-12">
          	<div class="form-group row">
          		<label class="col-sm-1 col-form-label">Tanggal</label>
              <div class="col-sm-2">
                <input type="text" class="form-control datepicker" id="tgl" value="<?= date('d-m-Y');?>">
              </div>
              <div class="col-sm-2">
              	<button id="cari" class="btn btn-primary"><i class="fa fa-search"></i> </button>
              </div>
            </div>

          </div>
          <div class="col-12 col-lg-12">
            <table class="table table-bordered sr-only">
              <thead class="bg-primary text-white text-center ">
                <tr>
                  <th>No.</th>
                  <th>Id. Produk</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody id="tbody" class="text-center">
                
              </tbody>
            </table>
          </div>
          <div class="col-12 col-lg-12 text-right">
          	<button id="cetak" class="btn btn-primary sr-only"><i class="fa fa-print"></i> Cetak</button>
          </div>
        </div>
      </div>
    </main>

    
    

    <script>

      $(document).ready(function() {
        
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy'
        });

        $('#cari').on('click', function(e){
        	if($('#tgl').val() == ''){
	        	swal({
	        		type: 'error',
	        		text: 'Pilih terlebih dahulu tanggal',
	        		allowOutsideClick: false
	        	})
	        }else{
	        	$('#tbody').html('');
	        	let tgl = $('#tgl').val();
	        	$.ajax({
	        		type: 'POST',
	        		url: '<?= base_url()."laporan/report";?>',
	        		dataType: 'JSON',
	        		data: {tgl:tgl, report: 'penjualan'},
	        		success: function(result){
	        			$('.table').removeClass('sr-only');
	        			$('#cetak').addClass('sr-only');
	        			let html = '';
	        			let i = 0;
	        			let no = 0;
	        			if(result.length > 0){
	        				for(i;i<result.length;i++){
	        				no++;
		        			html += "<tr>"+
				                  "<td>"+no+"</td>"+
				                  "<td>"+result[i].id_produk+"</td>"+
				                  "<td>"+result[i].nama+"</td>"+
				                  "<td> Rp. "+bilangan(result[i].harga)+"</td>"+
				                  "<td>"+bilangan(result[i].jumlah)+"</td>"+
				                  "<td>"+bilangan(result[i].subtotal)+"</td>"+
				                "</tr>";
				              }
				          $('#tbody').html(html);
				          $('#cetak').removeClass('sr-only');
	        			}
	        			

	        		}
	        	})
	        }
        })
       	$('#cetak').on('click', function(e){
       		if($('#tgl').val() == ''){
	        	swal({
	        		type: 'error',
	        		text: 'Pilih terlebih dahulu tanggal',
	        		allowOutsideClick: false
	        	})
	        }else{
	        	let tanggal = $('#tgl').val();
            window.open("<?= base_url().'laporan/cetak/';?>"+tanggal+'/product', '_blank');
          }

       	})
      })
    </script>