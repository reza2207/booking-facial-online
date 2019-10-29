<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){

		parent::__construct();

		$this->load->model('User_model');
		$this->load->model('Produk_model');
		$this->load->helper('terbilang');
		$this->load->helper('tanggal_helper');
		date_default_timezone_set('ASIA/Jakarta');

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$this->get_jumlah_data_keranjang($_SESSION['id_user']);
			$this->get_jml_proses($_SESSION['id_user'], 'onproses');
			$this->get_jml_proses($_SESSION['id_user'], 'pembayaran');
			$this->update_batal();

		}
	}

	public function index()
	{
		//check session here

		$this->load->library('pagination');
		$data = new stdClass();
		//konfigurasi pagination
        $config['base_url'] = base_url('Product/p/'); //site url
        $config['total_rows'] = $this->Produk_model->get_data('Aktif')->num_rows(); //total row
        $config['per_page'] = 15;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['use_page_numbers'] = TRUE;
        $config['attributes']['rel'] = FALSE;
        $config['reuse_query_string'] = TRUE;
        $config['first_url'] = base_url('Product');
	 	//style bootstrap
	 	//
        $config['first_link']       = 'Awal';
        $config['last_link']        = 'Akhir';
        $config['next_link']        = 'Selanjutnya';
        $config['prev_link']        = 'Sebelumnya';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        //init
        $this->pagination->initialize($config);

        $data->page = ($this->uri->segment(3)) ? ($this->uri->segment(3)-1)*$config['per_page'] : 0;

        $data->product = $this->Produk_model->list_product($config["per_page"], $data->page);
        $data->pagination = $this->pagination->create_links();



        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
        {

        	$data->title = 'Product';
        	$data->page_active = 'product';
        	$data->role = $_SESSION['role'];
        	$data->email = $_SESSION['email'];
        	$data->logged_in = $_SESSION['logged_in'];
        	$data->nama = $_SESSION['nama'];
        	$this->load->view('header_menu', $data);

        	$this->load->view('product_v', $data);

		}else{ //jika belum login
			$data->title = 'Product';
			$this->load->view('header', $data);

			$this->load->view('product_v', $data);
		}

	}

	protected function get_product()
	{
		return $this->Produk_model->get_data();
	}

	public function beli($id = null)
	{
		$data = new stdClass();
		$data->title = 'Detail Produk';
		$data->product = $this->get_detail_id($id);

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			
			$data->page_active = 'product';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];

			$data->nama = $_SESSION['nama'];

			$this->load->view('header_menu', $data);

			$this->load->view('product_detail', $data);

		}else{
			$data->title = 'Product';
			$this->load->view('header', $data);

			$this->load->view('product_detail', $data);
		}

	}

	public function keranjang()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($this->input->post(null)){

				$idproduct = $this->input->post('id');
				$userid = $_SESSION['id_user'];
				$id = uniqid();
				$data = new stdClass();
				//check
				if($this->Produk_model->check_keranjang($idproduct, $userid) > 0){

					$data->type = 'error';
					$data->pesan = 'Produk Sudah ada di keranjang belanja';
				}else{
					if($this->Produk_model->keranjang($id, $idproduct, $userid)){
						$data->type = 'success';
						$data->pesan = 'Produk ditambahkan ke keranjang';
						$this->get_jumlah_data_keranjang($userid);
					}else{
						$data->type = 'error';
						$data->pesan = 'Gagal menambahkan data';
					}
				}
				echo json_encode($data);

			}else{
				show_404();
			}
		}else{
			echo 'Maaf harus login terlebih dahulu';
		}
	}

	public function keranjang_belanja()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$data = new stdClass();
			$data->title = 'Keranjang Belanja';
			$data->page_active = 'product';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];

			$data->nama = $_SESSION['nama'];
			$userid = $_SESSION['id_user'];
			$data->keranjang = $this->get_data_keranjang($userid);
			$this->load->view('header_menu', $data);

			$this->load->view('keranjang_belanja', $data);


		}else{
			show_404();
		}
	}

	protected function get_detail_id($id)
	{

		return $this->Produk_model->get_data_id($id);
	}

	protected function get_jumlah_data_keranjang($userid)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$userid = $_SESSION['id_user'];
			$jml = $this->Produk_model->get_jumlah_data_keranjang($userid)->num_rows();
			$_SESSION['jml_keranjang'] = $jml;
			return true;

		}else{
			$_SESSION['jml_keranjang'] = null;
			return false;
		}
	}

	public function hapus_keranjang()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				$data = new stdClass();
				$id = $this->input->post('id');

				if($this->Produk_model->hapus_keranjang($id)){
					$data->type = 'success';
					$data->pesan = 'Berhasil';
				}else{
					$data->type = 'error';
					$data->pesan = 'Gagala';
				}

				echo json_encode($data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}

	}

	protected function get_data_keranjang($userid)
	{
		return $this->Produk_model->get_jumlah_data_keranjang($userid);
	}

	public function proses_keranjang()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				$data = new stdClass();

				$harga = $this->input->post('harga');
				$iduser = $_SESSION['id_user'];

				$i = 0;
				$id = $this->id_transaksi() ;//belom
				$temp = $this->input->post('idtemp');
				for($i;$i < count($harga); $i++){
					$result[] = array(
						"id_detail_transaksi" => $id.'-'.STR_PAD((int) $i, 3, "0", STR_PAD_LEFT),
						"id_transaksi"=>$id,
						"id_produk"  => $_POST['idproduk'][$i],
						"harga"  => $_POST['harga'][$i],
						"jumlah"  => $_POST['jumlah'][$i],

					);
	     			/*$temp[] = array(
	     				"id_temp_trans"=>$_POST['idtemp'][$i]
	     			);*/
	     		}
	     		$this->Produk_model->delete_temp($temp);

	     		if($this->db->insert_batch('tb_detail_transaksi', $result) && $this->Produk_model->new_trans($id, $iduser) ){

	     			$data->id = $id;
	     			$data->type = 'success';
	     			$data->pesan = 'Success';

	     		}else{
	     			$data->type = 'error';
	     			$data->pesan = 'Failed';
	     		}

	     		echo json_encode($data);


	     	}else{
	     		show_404();
	     	}
	     }else{
	     	show_404();
	     }

	 }

	 private function id_transaksi()
	 {

	 	if($this->Produk_model->get_id_trans()->num_rows() == 0 ){
	 		$id = 'trx-'.date('Ymd-').'0001';

	 	}else{

	 		$lastid = $this->Produk_model->get_id_trans()->row('id_transaksi');
	 		$exp = explode('-', $lastid);
	 		$urut = $exp[2];
	 		$id = 'trx-'.date('Ymd-').STR_PAD((int) $urut+1, 4, "0", STR_PAD_LEFT);
	 	}
	 	return $id;
	 }

	 public function ringkasan_pesanan($id = NULL)
	 {

	 	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
	 	{

	 		if($this->Produk_model->check_alamat($id)->num_rows() > 0){

	 			$data = new stdClass();
	 			$iduser = $_SESSION['id_user'];

	 			$data->alamat = $this->get_trans('editdong', $id);
	 			$data->alt = $this->Produk_model->alamat_kirim($iduser);
	 			$data->kecamatan = $this->get_kecamatan()->result();

	 			if($this->Produk_model->check_alamat($id)->row()->nama == ''){

	 				$data->status = null;

	 			}else{

	 				$data->status = 'ada';
	 			}

	 			$expired = strtotime($this->Produk_model->get_trans($id)->row()->tgl_transaksi) + 3*60*60;
				/*
				if($expired < strtotime(date('Y-m-d H:i:s'))){
					$data->expired = 'expired';
					$this->Produk_model->update_exp($id);
				}else{
					$data->expired = 'Belum';
				}*/
				$data->title = 'Ringkasan Pemesanan';
				$data->page_active = 'product';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->tgl_expired = date('Y-m-d H:i:s', $expired);
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->produk = $this->Produk_model->get_trans($id);
				$this->load->view('header_menu', $data);
				$this->load->view('ringkasan_pesanan', $data);

			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function on_proses()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$data = new stdClass();
			$data->page_active = 'product';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->title = 'Pesanan Dalam Proses';
			$userid = $_SESSION['id_user'];
			$data->kecamatan = $this->get_kecamatan()->result();
			$data->transaksi = $this->Produk_model->data_on_proses($userid);
			$data->nama = $_SESSION['nama'];
			$this->load->view('header_menu', $data);
			$this->load->view('on_proses', $data);


		}else{
			show_404();
		}
	}

	public function submit_alamat()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$data = new stdClass();
			if($this->input->post(null)){

				$this->form_validation->set_rules('nama', 'Nama', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('telepon', 'Telepon', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('alamat', 'Alamat', 'required|max_length[200]',
					array('required'=>'%s harap dimasukkan.',
						'max_length'=>'%s tidak boleh melebihi 200 karakter'));
				$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('provinsi', 'Provinsi', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('kodepos', 'Kode POS', 'required|max_length[5]|numeric',
					array('required'=>'%s harap dimasukkan.',
						'max_length'=>'%s tidak boleh melebihi 5 karakter',
						'numeric'=>'%s hanya diperbolehkan angka'));

				if ($this->form_validation->run() == FALSE){

					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;
					echo json_encode($data);

				}else{
					$iduser = $_SESSION['id_user'];
					$id = $this->input->post('idtransaksi');
					if($this->Produk_model->alamat_kirim($iduser)->num_rows() == 0)
					{

						$nama = trim($this->input->post('nama'));
						$telepon = trim($this->input->post('telepon'));
						$alamat = trim($this->input->post('alamat'));
						$kecamatan = trim($this->input->post('kecamatan'));
						$provinsi = trim($this->input->post('provinsi'));
						$kodepos = trim($this->input->post('kodepos'));

						$idalamat = $this->id_alamat($iduser);
						$this->Produk_model->tambah_alamat($idalamat, $iduser, $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos);

					}else{
						$idalamat = $this->Produk_model->alamat_kirim($iduser)->row()->id_alamat;
						$nama = $this->input->post('nama');
						$telepon = $this->input->post('telepon');
						$alamat = $this->input->post('alamat');
						$kecamatan = $this->input->post('kecamatan');
						$provinsi = $this->input->post('provinsi');
						$kodepos = $this->input->post('kodepos');

						//jika ada di tb alamat, alamat kirimnya , kita update alamat di tb transaksi

						$this->Produk_model->update_alamat($id, $idalamat,  $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos);

						//update juga di tb alamat
						$this->Produk_model->update_tb_alamat($idalamat, $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos);

					}

					if($this->Produk_model->update_alamat_trx($id)){
						$data->type = 'success';
						$data->pesan = 'Success';

					}else{
						$data->type = 'error';
						$data->pesan = 'Failed';
					}

					echo json_encode($data);
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}


	private function id_alamat($iduser)
	{
		if($this->Produk_model->alamat_kirim($iduser)->num_rows() == 0 ){
			$id = 'alt-'.$iduser.'-001';

		}else{

			$lastid = $this->Produk_model->alamat_kirim($iduser)->row()->id_alamat;
			$exp = explode('-', $lastid);
			$urut = $exp[2];
			$id = 'alt-'.$iduser.'-'.STR_PAD((int) $urut+1, 3, "0", STR_PAD_LEFT);
		}
		return $id;

	}

	private function get_jml_proses($userid, $process)
	{

		$jml = $this->Produk_model->data_proses($_SESSION['id_user'], $process)->num_rows();
		if($process == 'pembayaran'){
			$_SESSION['jml_on_pembayaran'] = $jml;
		}elseif($process == 'onproses'){
			$_SESSION['jml_on_proses'] = $jml;
		}
	}

	public function konfirmasi_pembayaran()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($_SESSION['role'] == 'user'){
				$data = new stdClass();
				$data->page_active = 'product';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->title = 'Konfirmasi Pembayaran';
				$userid = $_SESSION['id_user'];
				$data->transaksi = $this->Produk_model->data_proses($userid, 'pembayaran');
				$data->nama = $_SESSION['nama'];
				$this->load->view('header_menu', $data);
				$this->load->view('konfirmasi_pembayaran', $data);

			}elseif($_SESSION['role'] == 'admin'){

				$this->load->library('pagination');
				$data = new stdClass();
				//konfigurasi pagination
		        $config['base_url'] = base_url('product/konfirmasi_pembayaran/p/'); //site url
		        $config['total_rows'] = $this->Produk_model->data_pembayaran()->num_rows(); //total row
		        $config['per_page'] = 15;
		        $config["uri_segment"] = 3;
		        $choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice);
		        $config['use_page_numbers'] = TRUE;
		        $config['attributes']['rel'] = FALSE;
		        $config['reuse_query_string'] = TRUE;
		        $config['first_url'] = base_url('Product');
			 	//style bootstrap
			 	//
		        $config['first_link']       = 'Awal';
		        $config['last_link']        = 'Akhir';
		        $config['next_link']        = 'Selanjutnya';
		        $config['prev_link']        = 'Sebelumnya';
		        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		        $config['full_tag_close']   = '</ul></nav></div>';
		        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		        $config['num_tag_close']    = '</span></li>';
		        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['prev_tagl_close']  = '</span>Next</li>';
		        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		        $config['first_tagl_close'] = '</span></li>';
		        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['last_tagl_close']  = '</span></li>';

		        //init
		        $this->pagination->initialize($config);

		        $data->page = ($this->uri->segment(3)) ? ($this->uri->segment(3)-1)*$config['per_page'] : 0;

		        $data->transaksi = $this->Produk_model->data_pembayaran($config["per_page"], $data->page);
		        $data->pagination = $this->pagination->create_links();

		        $data->title = 'Konfirmasi Pembayaran';
		        $data->page_active = 'product';
		        $data->role = $_SESSION['role'];
		        $data->email = $_SESSION['email'];
		        $data->logged_in = $_SESSION['logged_in'];
		        $data->nama = $_SESSION['nama'];
		        /*$data->product = $this->get_product();*/
		        $this->load->view('header_menu', $data);

		        $this->load->view('konfirmasi_pembayaran_admin');
		    }

		}else{
			show_404();
		}
	}

	public function get_trans($edit = NULL, $id = null)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$data = new stdClass();
				if($edit == NULL){
					$data->alamatkirim =$this->Produk_model->get_data_trans($id)->row();
					$data->detail = $this->Produk_model->get_trans($id)->result();
					$data->bayar = $this->Produk_model->get_data_pembayaran_by_id($id)->result();
					echo json_encode($data);
				}elseif($edit != NULL){
					$data = $this->Produk_model->get_data_trans($id)->row();
					echo json_encode($data);
				}
			}else{
				$data = new stdClass();
				if($edit == NULL){
					$data->alamatkirim =$this->Produk_model->get_data_trans($id)->row();
					$data->detail = $this->Produk_model->get_trans($id)->result();
					return $data;
				}elseif($edit != NULL){
					$data = $this->Produk_model->get_data_trans($id)->row();
					return $data;
				}
			}
		}else{
			show_404();
		}

	}

	public function submit_konfirmasi_pembayaran()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($this->input->post(null)){
				$data = new stdClass();

				$this->form_validation->set_rules('nama', 'Nama', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('jumlah', 'Jumlah', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('bank', 'Bank', 'required',
					array('required'=>'%s harap dimasukkan.'));
				$this->form_validation->set_rules('tgl', 'Tgl. Transfer', 'required',
					array('required'=>'%s harap dimasukkan.'));

				if ($this->form_validation->run() == FALSE){

					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;
					echo json_encode($data);

				}else{

					$config['upload_path']    = './gambar/bukti';
					$config['allowed_types']  = 'gif|jpg|png|jpeg|JPG|JPEG';
					$config['encrypt_name']   = TRUE;
					$config['max_size']       = 500;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('bukti'))
					{
						$error = $this->upload->display_errors();
						$data->type = 'error';
						$data->pesan = $error;

					}else{

						$datagambar = $this->upload->data();

						$gambar = $datagambar['file_name'];
		                //belom nih
						$idtrx = $this->input->post('idtransaksi');

						$id = $this->id_bayar($idtrx);


						$tgl = tanggal1($this->input->post('tgl'));
						$jumlah = $this->input->post('jumlah');
						$bank = $this->input->post('bank');
						$nama = $this->input->post('nama');
						$status = 'Pembayaran Sedang Diverifikasi';

						if($this->Produk_model->upload_bukti($id, $idtrx, $tgl, $jumlah, $bank, $nama, $gambar, $status) && $this->update_status($idtrx, $status))
						{
							$data->type = 'success';
							$data->pesan = 'Konfirmasi Terkirim !';

						}else{
							$data->type = 'error';
							$data->pesan = 'Failed';
							unlink('gambar/bukti/'.$gambar);
						}

					}
					echo json_encode($data);
				}

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	private function update_batal()
	{
		return $this->Produk_model->update_batal();
	}

	private function id_bayar($idtrx)
	{
		$query = $this->Produk_model->check_id_trf($idtrx);
		if($query->num_rows() == 0){

			$id = 'trf-'.$idtrx.'-001';
		}else{
			$lastid = $query->row('id_pembayaran');
			$e = explode('-', $lastid);
			$id = 'trf'.$idtrx.'-'.STR_PAD((int) $e[4]+1, 3, '0', STR_PAD_LEFT);

		}

		return $id;
	}

	private function update_status($idtrx, $status)
	{
		return $this->Produk_model->update_status($idtrx, $status);

	}

	public function img($gambar = NULL)
	{

		echo "<img src='".base_url().'gambar/bukti/'.$gambar."'>";
	}

	public function submit_data_pembayaran()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$idpembayaran = $this->input->post('id');
				$datas = $this->input->post('data');
				$idtrx = $this->input->post('idtrx');

				if($this->input->post('jumlah') !== NULL){
					$jml = $this->input->post('jumlah');

				}

				if($datas == 'lunas'){
					$status = 'Pembayaran Lunas';
				}elseif($datas == 'decline'){
					$status = 'Pembayaran Ditolak';
				}
				$data = new stdClass();
				if($this->Produk_model->update_status($idtrx, $status) && $this->Produk_model->update_status_pembayaran($idpembayaran, $status))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';
				}else{
					$data->type = 'error';
					$data->pesan = 'Gagal';
				}

				echo json_encode($data);
			}
		}else{
			show_404();
		}
	}

	public function get_data_trf()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$id = $this->input->post('id');

				echo json_encode($this->Produk_model->get_data_trf($id)->row());

			}

		}else{
			show_404();
		}
	}

	public function ubah_trf()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($this->input->post(null))
			{
				$data = new stdClass();

				$idpembayaran = $this->input->post('idpembayaran');
				$tgl = tanggal1($this->input->post('tgl'));
				$jumlah = $this->input->post('jumlah');
				$bank = $this->input->post('bank');
				$nama = $this->input->post('nama');

				if($this->Produk_model->update_trf($idpembayaran, $tgl, $jumlah, $bank, $nama))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';
				}else{
					$data->type = 'error';
					$data->pesan = 'Gagal';
				}

				echo json_encode($data);

			}


		}else{
			show_404();
		}
	}

	public function konfirmasi_pengiriman()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($_SESSION['role'] == 'admin'){

				$this->load->library('pagination');
				$data = new stdClass();
				//konfigurasi pagination
		        $config['base_url'] = base_url('Product/p/'); //site url
		        $config['total_rows'] = $this->Produk_model->get_data('Aktif')->num_rows(); //total row
		        $config['per_page'] = 15;
		        $config["uri_segment"] = 3;
		        $choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice);
		        $config['use_page_numbers'] = TRUE;
		        $config['attributes']['rel'] = FALSE;
		        $config['reuse_query_string'] = TRUE;
		        $config['first_url'] = base_url('Product');
			 	//style bootstrap
			 	//
		        $config['first_link']       = 'Awal';
		        $config['last_link']        = 'Akhir';
		        $config['next_link']        = 'Selanjutnya';
		        $config['prev_link']        = 'Sebelumnya';
		        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		        $config['full_tag_close']   = '</ul></nav></div>';
		        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		        $config['num_tag_close']    = '</span></li>';
		        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['prev_tagl_close']  = '</span>Next</li>';
		        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		        $config['first_tagl_close'] = '</span></li>';
		        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		        $config['last_tagl_close']  = '</span></li>';

		        //init
		       	$this->pagination->initialize($config);

		        $data->page = ($this->uri->segment(3)) ? ($this->uri->segment(3)-1)*$config['per_page'] : 0;

		        $data->transaksi = $this->Produk_model->data_proses(null, 'pengiriman', $config["per_page"], $data->page );
		        $data->pagination = $this->pagination->create_links();

        		$data->title = 'Konfirmasi Pengiriman';
		        $data->page_active = 'product';
		        $data->role = $_SESSION['role'];
		        $data->email = $_SESSION['email'];
		        $data->logged_in = $_SESSION['logged_in'];
		        $data->nama = $_SESSION['nama'];
				$this->load->view('header_menu', $data);
				$this->load->view('konfirmasi_pengiriman_admin', $data);
			}else{
				show_404();
			}


		}
	}

	private function get_jml_trf()
	{
		return $this->Produk_model->get_jml_trf()->num_rows();
	}

	public function submit_data_pengiriman()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($_SESSION['role'] == 'admin')
			{
				if($this->input->post(null))
				{
					$data = new stdClass();

					$id = $this->input->post('id');
					$status = $this->input->post('data');

					if($this->update_status($id, $status))
					{
						$data->type = 'success';
						$data->pesan = 'Berhasil';
					}else{
						$data->type = 'error';
						$data->pesan = 'Gagal';
					}

					echo json_encode($data);


				}

			}

		}else{
			show_404();
		}
	}

	public function terkirim()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] == 'user')
			{
				$data = new stdClass();
				$data->title = 'Produk Terkirim';
				$data->page_active = 'product';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];

				$data->nama = $_SESSION['nama'];
				$userid = $_SESSION['id_user'];
				$data->keranjang = $this->get_data_keranjang($userid);
				$data->transaksi = $this->Produk_model->data_terkirim($userid);
				$this->load->view('header_menu', $data);

				$this->load->view('terkirim', $data);
			}
		}else{
			show_404();
		}
	}

	

	private function get_kecamatan()
	{
		return $this->Produk_model->get_kecamatan();
	}
}
