<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola extends CI_Controller {

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
		$this->load->model('Facial_model');
		$this->load->model('Produk_model');
		$this->load->helper('tanggal_helper');
		$this->load->helper('terbilang_helper');
		date_default_timezone_set('Asia/Bangkok');


	}

	public function index()
	{
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			$data = new stdClass();
			$data->title = 'Kelola';
			$data->page_active = 'kelola';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['id_user'])->row();
			$data->nama = $_SESSION['nama'];
			$data->facial = $this->get_facial('ok');
			$this->load->view('header_menu', $data);

			if($_SESSION['role'] == 'user'){
				$this->load->view('booking_user');

			}

		}else{
			$data = new stdClass();
			$data->title = 'FARINA BEAUTY CLINIC';
			$data->page_active = 'home';
			$this->load->view('header', $data);

			$this->load->view('home');
		}
	}

	public function facial()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user'){

				$data = new stdClass();
				$data->title = 'Kelola Facial';
				$data->page_active = 'kelola';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->facial = $this->get_facial('ok');
				$this->load->view('header_menu', $data);
				$this->load->view('kelola_facial', $data);


			}else{
				show_404();
			}

		}
	}

	public function produk()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user')
			{
				$data = new stdClass();
				$data->title = 'Kelola Produk';
				$data->page_active = 'kelola';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->produk = $this->Produk_model->get_data()->result();
				$this->load->view('header_menu', $data);
				$this->load->view('kelola_produk', $data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function submit_facial()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($this->input->post(null)){
				$data = new stdClass();
				$nama = trim($this->input->post('nama'));
				$keterangan = trim($this->input->post('keterangan'));
				$harga = $this->input->post('harga');

				$this->form_validation->set_rules('keterangan', 'Deskripsi', 'required|max_length[250]',
					array('required' => '%s harap diisi.',
						'max_length'=> '%s tidak boleh melebihi 250 karakter')
				);
				$this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tb_facial.nama]',
					array('required' => '%s harap diisi.',
							'is_unique'=>'%s sudah terdaftar.')
				);
				$this->form_validation->set_rules('harga', 'Harga', 'required',
					array('required' => '%s harap diisi.')
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;
				}else{

					$id = $this->_id_facial();

					if($this->Facial_model->new_data($id, $nama, $keterangan, $harga)){

						$data->type = 'success';
						$data->pesan = 'Berhasil';

					}else{
						$data->type = 'error';
						$data->pesan = 'Gagal';
					}

				}

				echo json_encode($data);

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function submit_produk()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($this->input->post(null))
			{
				//echo json_encode($this->input->post());
				//
				$data = new stdClass();
				

                $this->form_validation->set_rules('keterangan', 'Deskripsi', 'required|max_length[250]',
					array('required' => '%s harap diisi.',
						'max_length'=> '%s tidak boleh melebihi 250 karakter')
				);
				$this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tb_produk.nama]',
					array('is_unique'=>'%s sudah terdaftar.',
						'required' => '%s harap diisi.')
				);
				$this->form_validation->set_rules('harga', 'Harga', 'required',
					array('required' => '%s harap diisi.')
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;


				}else{
					$config['upload_path']    = './gambar';
	                $config['allowed_types']  = 'gif|jpg|png|jpeg|JPG|JPEG';
	                $config['encrypt_name']   = TRUE;
	                $config['max_size']       = 1000;
	                $this->load->library('upload', $config);


	                if ( ! $this->upload->do_upload('gambar'))
	                {
	                	$error = $this->upload->display_errors();
	                	$data->type = 'error';
	                	$data->pesan = $error;

	                }else{
	                	$datagambar = $this->upload->data();
	                	                
		                $gambar = $datagambar['file_name'];

		                $nama = trim($this->input->post('nama'));
		                $keterangan = trim($this->input->post('keterangan'));
		                $harga = $this->input->post('harga');
		                $id = uniqid();

		                if($this->Produk_model->new_data($id, $gambar, $nama, $harga, $keterangan)){

							$data->type = 'success';
							$data->pesan = 'Berhasil';

						}else{
							$data->type = 'error';
							$data->pesan = 'Gagal';
							$lokasi = $config['upload_path']."/".$gambar;
							unlink($lokasi);
						}

		            }
		        }
		            
		        echo json_encode($data);

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}


	public function get_facial($a = null)
	{

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($a = null){
				echo json_encode($this->Facial_model->get_facial()->result());
			}else{
				return $this->Facial_model->get_facial()->result();
			}
		}
	}

	protected function _id_facial()
	{

		$cek = $this->Facial_model->last_id();
		//mendapatkan id lamanya;

		if($cek->num_rows() > 0){
			$idlast = explode('-', $cek->row()->id_facial);
			$uniqid = $idlast[1];

			$id = 'facial-'.STR_PAD((int) $uniqid+1, 3, "0", STR_PAD_LEFT);
		}else{
			$id = 'facial-001';
		}
		//mengembalikan value $id;
		return $id;

	}

	public function get_data_id()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{	
				$id = $this->input->post('id');
				if($this->input->post('data') == 'facial'){
					echo json_encode($this->Facial_model->get_data_id($id)->row());
				}elseif($this->input->post('data') == 'produk'){
					echo json_encode($this->Produk_model->get_data_id($id)->row());
				}elseif($this->input->post('data') == 'pasien'){
					echo json_encode($this->User_model->get_user($id)->row());
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function edit_facial()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				$data = new stdClass();
				$nama = trim($this->input->post('nama'));
				$keterangan = trim($this->input->post('keterangan'));
				$harga = $this->input->post('harga');
				$status = $this->input->post('status');
				$id = $this->input->post('id');
				$this->form_validation->set_rules('keterangan', 'Deskripsi', 'required|max_length[250]',
					array('required' => '%s harap diisi.',
						'max_length'=> '%s tidak boleh melebihi 250 karakter')
				);
				if($this->input->post('nama') == $this->input->post('nama_lama')){
					$this->form_validation->set_rules('nama', 'Nama', 'required',
						array('required' => '%s harap diisi.')
					);
				}else{
					$this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tb_facial.nama]',
						array('required' => '%s harap diisi.',
								'is_unique'=>'%s sudah terdaftar.')
					);
				}
				$this->form_validation->set_rules('harga', 'Harga', 'required',
					array('required' => '%s harap diisi.')
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;
				}else{

					if($this->Facial_model->update_data($id, $nama, $keterangan, $harga, $status)){

						$data->type = 'success';
						$data->pesan = 'Berhasil';

					}else{
						$data->type = 'error';
						$data->pesan = 'Gagal';
					}

				}

				echo json_encode($data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function edit_produk()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				$data = new stdClass();
				$nama = trim($this->input->post('nama'));
				$keterangan = trim($this->input->post('keterangan'));
				$harga = $this->input->post('harga');
				$status = $this->input->post('status');
				$id = $this->input->post('id');
				$gambarlama = $this->input->post('gambarlama');
				

				$this->form_validation->set_rules('keterangan', 'Deskripsi', 'required|max_length[250]',
					array('required' => '%s harap diisi.',
						'max_length'=> '%s tidak boleh melebihi 250 karakter')
				);
				if($this->input->post('nama') == $this->input->post('nama_lama')){
					$this->form_validation->set_rules('nama', 'Nama', 'required',
						array('required' => '%s harap diisi.')
					);
				}else{
					$this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tb_produk.nama]',
						array('is_unique'=>'%s sudah terdaftar.',
							'required' => '%s harap diisi.')
					);
				}

				$this->form_validation->set_rules('harga', 'Harga', 'required',
					array('required' => '%s harap diisi.')
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;
				}else{
					//jika tidak ada gambar baru
					if(!file_exists($_FILES['gambar']['tmp_name']) || !is_uploaded_file($_FILES['gambar']['tmp_name'])) {

						$nama = trim($this->input->post('nama'));
		                $keterangan = trim($this->input->post('keterangan'));
		                $harga = $this->input->post('harga');

		                if($this->Produk_model->update_data($id, $gambarlama, $nama, $harga, $keterangan, $status)){

							$data->type = 'success';
							$data->pesan = 'Berhasil';

						}else{
							$data->type = 'error';
							$data->pesan = 'Gagal';
						}

		               
					}else{
						$config['upload_path']    = './gambar';
		                $config['allowed_types']  = 'gif|jpg|png|jpeg|JPG|JPEG';
		                $config['encrypt_name']   = TRUE;
		                $config['max_size']       = 1000;
		                $this->load->library('upload', $config);

						if ( ! $this->upload->do_upload('gambar'))
		                {
		                	$error = $this->upload->display_errors();
		                	$data->type = 'error';
		                	$data->pesan = $error;

		                }else{
		                	$datagambar = $this->upload->data();
		                	                
			                $gambar = $datagambar['file_name'];

			                if($this->Produk_model->update_data($id, $gambar, $nama, $harga, $keterangan, $status)){

								$data->type = 'success';
								$data->pesan = 'Berhasil';

								$lokasi = $config['upload_path']."/".$gambarlama;
								if(file_exists($lokasi)){
									unlink($lokasi);
								}

							}else{
								$data->type = 'error';
								$data->pesan = 'Gagal';
								$lokasi = $config['upload_path']."/".$gambar;
								if(file_exists($lokasi)){
									unlink($lokasi);
								}
							}

			            }
					}

				}

				echo json_encode($data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function edit_user()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{

				$this->form_validation->set_rules('email', 'Email', 'required|valid_email', 
						array('valid_email'=>'%s harap masukkan email dengan benar'));

		        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[6]|max_length[50]|alpha_numeric_spaces',
		                array('required' => '%s harap dimasukkan.',
		                	'min_length'=>'%s minimal 6 karakter.',
		                	'max_length'=>'%s maksimal 50 karakter',
		                	'alpha_numeric_spaces'=>'%s tidak boleh mengandung angka atau karakter lain selain huruf'
		                )
		        );
		        $this->form_validation->set_rules('telepon', 'Telepon', 'required|min_length[6]|max_length[50]|numeric',
		                array('required' => '%s harap dimasukkan.',
		                	'min_length'=>'%s minimal 6 karakter.',
		                	'numeric'=>'%s hanya boleh angka'
		                )
		        );
		        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|min_length[6]|max_length[50]',
		                array('required' => '%s harap dimasukkan.'
		                )
		        );
		        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required',
		                array('required' => '%s harap dimasukkan.'
		                )
		        );
		        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required',
		                array('required' => '%s harap dimasukkan.'
		                )
		        );
		        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[6]|max_length[250]',
		                array('required' => '%s harap dimasukkan.',
		                	'min_length'=>'%s minimal 6 karakter.'
		                )
		        );

				
		       	if ($this->form_validation->run() == FALSE){

		            $errors = validation_errors();
		            $respons_ajax['type'] = 'error';
		            $respons_ajax['pesan'] = $errors;
		            

		        }else{

					$iduser = $this->input->post('id_user');
					$nomember = $this->input->post('no_member');	
					$nama = $this->input->post('nama');
					$alamat = $this->input->post('alamat');
					$telepon = $this->input->post('telepon');
					$email = $this->input->post('email');
					$tgllahir = tanggal1($this->input->post('tgl_lahir'));
					$jk = $this->input->post('jk');

					if($this->User_model->edit_user($iduser, $nomember, $nama, $alamat, $telepon, $email, $jk, $tgllahir))
					{
						$respons_ajax['type'] = 'success';
						$respons_ajax['pesan'] = 'Berhasil';
					}else{
						$respons_ajax['type'] = 'error';
						$respons_ajax['pesan'] = 'Gagal';
					}
				}
				echo json_encode($respons_ajax);

			}

		}else{
			show_404();
		}
	}

	public function add_stok()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$data = new stdClass();
				$id = $this->input->post('id_produk');
				$jumlah = $this->input->post('jumlah');
				$idstok = uniqid();

				if($this->Produk_model->add_stok($idstok, $id, $jumlah))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';

				}else{
					$data->type = 'error';
					$data->pesan = 'Gagal';
				}

				echo json_encode($data);

			}else{

				show_404();
			}
		}else{
			show_404();
		}

	}

	public function member()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user'){

				$data = new stdClass();
				$data->title = 'Kelola Member';
				$data->page_active = 'kelola';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->user = $this->User_model->get_user(null, 'user');
				$this->load->view('header_menu', $data);
				$this->load->view('kelola_member', $data);


			}else{
				show_404();
			}

		}
	}






	
}
