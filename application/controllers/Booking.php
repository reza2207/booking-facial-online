<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

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
		$this->load->model('Booking_model');
		$this->load->model('Facial_model');
		$this->load->helper('tanggal_helper');
		$this->load->helper('terbilang_helper');
		$this->update_selesai();
		date_default_timezone_set('Asia/Bangkok');


	}

	public function index()
	{
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			$data = new stdClass();
			$data->title = 'Booking';
			$data->page_active = 'booking';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['email'])->row();
			$data->nama = $_SESSION['nama'];
			$this->load->view('header_menu', $data);
			$this->load->view('booking_home',$data);

		}else{
			$data = new stdClass();
			$data->title = 'FARINA BEAUTY CLINIC';
			$data->page_active = 'home';

			$data->warning =  'Harap login terlebih dahulu';
			$this->load->view('header', $data);
			$this->load->view('home',$data);
		}
	}

	public function booking_baru()
	{
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			$data = new stdClass();
			$data->title = 'Booking Baru';
			$data->page_active = 'booking';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['email'])->row();
			$data->nama = $_SESSION['nama'];
			$data->jam = $this->Booking_model->jam_booking()->result();
			$data->facial = $this->get_facial('ok');
			$this->load->view('header_menu', $data);

			
			$this->load->view('booking_user');


		}else{
			$data = new stdClass();
			$data->title = 'FARINA BEAUTY CLINIC';
			$data->page_active = 'home';

			$data->warning =  'Harap login terlebih dahulu';
			$this->load->view('header', $data);
			$this->load->view('home',$data);
			/*$this->load->view('home');*/
		}
	}

	public function submit_booking()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){

				$data = new stdClass();
				$tgl = tanggal1($this->input->post('tanggal'));
				$jam = $this->input->post('jam');
				$nama = $this->input->post('nama');
				$telp = $this->input->post('telp');
				$email = $this->input->post('email');
				$id_facial = $this->input->post('jenis_facial');
				$harga = $this->get_harga($id_facial);
				$id_user = $_SESSION['id_user'];

				$this->form_validation->set_rules('tanggal', 'Tanggal Booking', 'required',
					array('required' => '%s harap dipilih.'
				)
				);
				$this->form_validation->set_rules('jam', 'Jam Booking', 'required',
					array('required' => '%s harap dipilih.'
				)
				);
				$this->form_validation->set_rules('jenis_facial', 'Jenis Facial', 'required',
					array('required' => '%s harap dipilih.'
				)
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;

				}elseif(strtotime($tgl.' '.$jam) < strtotime(date('Y-m-d H:i'))){
					$data->type = 'error';
					$data->pesan = 'Jam Tidak Valid';

				}elseif($this->_check_jadwal($tgl, $jam)){
					$data->type = 'error';
					$data->pesan = 'Booking sudah full';

				}else{
					
					$id = $this->_id_booking($tgl);

					if($this->Booking_model->new_data($id, $id_user, $nama, $tgl, $jam, $telp, $email, $id_facial, $harga)){

						$data->type = 'success';
						$data->pesan = 'Booking Berhasil';

					}else{
						$data->type = 'error';
						$data->pesan = 'Booking gagal';
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

	public function on_proses()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$data = new stdClass();
			$data->title = 'Booking Dalam Proses';
			$data->page_active = 'booking';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['email'])->row();
			$data->nama = $_SESSION['nama'];
			$data->facial = $this->get_facial('ok');
			$data->jam = $this->Booking_model->jam_booking()->result();
			$id_user = $_SESSION['id_user'];
			$params = 'belom';

			if($_SESSION['role'] == 'user'){
				$data->riwayat = $this->_get_data_booking($id_user, $params);
				$this->load->view('header_menu', $data);
				$this->load->view('booking_history');

			}else{

				$this->load->library('pagination');
				$config['total_rows'] = $this->_get_data_booking()->num_rows(); //total row
		        $config['per_page'] = 15;
		        $config["uri_segment"] = 3;
		        $choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice);
		        $config['use_page_numbers'] = TRUE;
		 		$config['attributes']['rel'] = FALSE;
		 		$config['reuse_query_string'] = TRUE;
			 	$config['first_url'] = base_url('booking');

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

		        $data->riwayat = $this->Booking_model->list_booking($config["per_page"], $data->page, 'Dalam Proses');
		        $data->pagination = $this->pagination->create_links();
		        $this->load->view('header_menu', $data);
				$this->load->view('booking_history_admin');

				/*
				$data->riwayat = $this->_get_data_booking();
				$this->load->view('header_menu', $data);
				$this->load->view('booking_history_admin');*/

			}
		}else{
			show_404();
		}
	}


	public function riwayat_booking()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			$data = new stdClass();
			$data->title = 'Riwayat Booking';
			$data->page_active = 'booking';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['email'])->row();
			$data->nama = $_SESSION['nama'];
			$data->facial = $this->get_facial('ok');
			$data->jam = $this->Booking_model->jam_booking()->result();
			$id_user = $_SESSION['id_user'];
			$params = 'selesai';

			if($_SESSION['role'] == 'user'){
				$data->riwayat = $this->_get_data_booking($id_user, $params);
				$this->load->view('header_menu', $data);
				$this->load->view('booking_history');

			}else{

				$this->load->library('pagination');
				$config['total_rows'] = $this->_get_data_booking()->num_rows(); //total row
		        $config['per_page'] = 15;
		        $config["uri_segment"] = 3;
		        $choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice);
		        $config['use_page_numbers'] = TRUE;
		 		$config['attributes']['rel'] = FALSE;
		 		$config['reuse_query_string'] = TRUE;
			 	$config['first_url'] = base_url('booking');

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

		        $data->riwayat = $this->Booking_model->list_booking($config["per_page"], $data->page, 'Selesai');
		        $data->pagination = $this->pagination->create_links();
		        $this->load->view('header_menu', $data);
				$this->load->view('booking_selesai');

				/*
				$data->riwayat = $this->_get_data_booking();
				$this->load->view('header_menu', $data);
				$this->load->view('booking_history_admin');*/

			}
		}else{
			show_404();
		}
	}

	protected function _get_data_booking($id_user = NULL, $params = NULL)
	{
		return $this->Booking_model->get_data($id_user, $params);
	}

	protected function _check_jadwal($tgl = NULL, $jam = NULL)
	{
		//mengecek jadwal jika dalam tanggal dan jam yang sama sudah 3 orang yang membooking dan tidak ada yang mengcancel;
		if($this->Booking_model->check_jadwal($tgl, $jam)->num_rows() == 3)
		{
			return true;
		}else{
			return false;
		}
	}

	protected function _id_booking($tgl)
	{
		$t = explode('-',$tgl);
		$newtgl = $t[2].'/'.$t[1].'/'.$t[0];
		$cek = $this->Booking_model->check_tgl($tgl);
		//mendapatkan id lamanya;

		if($cek->num_rows() > 0){
			$idlast = explode('/', $cek->row()->id_booking);
			$uniqid = $idlast[3];

			$id = $newtgl.'/'.STR_PAD((int) $uniqid+1, 2, "0", STR_PAD_LEFT);
		}else{
			$id = $newtgl.'/01';
		}
		//mengembalikan value $id;
		return $id;
	}

	public function batal()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$id = $this->input->post('id');

				if($this->Booking_model->batal($id))
				{
					$data = new stdClass();
					$data->status = 'ok';
					echo json_encode($data);
				}else{
					$data = new stdClass();
					$data->status = 'error';
					echo json_encode($data);
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}
	public function selesai()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$id = $this->input->post('id');

				if($this->Booking_model->selesai($id))
				{
					$data = new stdClass();
					$data->status = 'ok';
					echo json_encode($data);
				}else{
					$data = new stdClass();
					$data->status = 'error';
					echo json_encode($data);
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	private function update_selesai()
	{
		return $this->Booking_model->update_selesai();

	}


	public function get_data()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$id = $this->input->post('id');
				echo json_encode($this->Booking_model->get_data_id($id)->row());

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
				echo json_encode($this->Facial_model->get_facial('Aktif')->result());
			}else{
				return $this->Facial_model->get_facial('Aktif')->result();
			}
		}
	}

	public function edit_data_booking()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{

				$data = new stdClass();
				$id = $this->input->post('id');
				$jenis = $this->input->post('jenis_facial');
				$tgl = tanggal1($this->input->post('tanggal'));
				$jam = $this->input->post('jam');
				$harga = $this->get_harga($jenis);

				$this->form_validation->set_rules('tanggal', 'Tanggal Booking', 'required',
					array('required' => '%s harap dipilih.')
				);
				$this->form_validation->set_rules('jam', 'Tanggal Booking', 'required',
					array('required' => '%s harap dipilih.')
				);
				$this->form_validation->set_rules('jenis_facial', 'Jenis Facial', 'required',
					array('required' => '%s harap dipilih.')
				);

				if ($this->form_validation->run() == FALSE){
					$errors = validation_errors();
					$data->type = 'error';
					$data->pesan = $errors;

				}elseif(strtotime($tgl.' '.$jam) < strtotime(date('Y-m-d H:i'))){
					$data->type = 'error';
					$data->pesan = 'Jam Tidak Valid';

				}elseif($this->_check_jadwal($tgl, $jam)){
					$data->type = 'error';
					$data->pesan = 'Booking sudah full';

				}else{


					if($this->Booking_model->update_data($id, $tgl, $jam, $jenis, $harga)){

						$data->type = 'success';
						$data->pesan = 'Booking Berhasil diubah';

					}else{
						$data->type = 'error';
						$data->pesan = 'Booking gagal diubah';
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

	private function get_harga($id_facial)
	{
		return $this->Booking_model->get_harga($id_facial)->row()->harga;
	}
}
