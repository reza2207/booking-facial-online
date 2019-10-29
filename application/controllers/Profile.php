<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		$this->load->helper('tanggal');
		
		
	}

	public function index()
	{	
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{	

			$data = new stdClass();
			$data->title = 'Profile';
			$data->page_active = 'home';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->nama = $_SESSION['nama'];
			$data->user = $this->User_model->get_user($data->email)->row();
			if($_SESSION['role'] == 'user'){
				$this->load->view('header_menu', $data);

				$this->load->view('profile');
			}else{
				$this->load->view('header_menu', $data);
				$this->load->view('profile');
			}

		}else{
			show_404();
		}
	}

	public function ubah_data($iduser = null)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($iduser == $_SESSION['id_user']){
				$data = new stdClass();
				$data->title = 'Profile';
				$data->page_active = 'home';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->user = $this->User_model->get_user($data->email)->row();
				$this->load->view('header_menu', $data);

				$this->load->view('ubah_data');

			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function submit_ubah()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null)){
				if($_SESSION['role'] == 'user'){

					if($this->input->post('email') != $this->input->post('email_lama') ){
						$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|valid_email', 
							array('is_unique'=>'%s sudah terdaftar.',
								'valid_email'=>'%s harap masukkan email dengan benar'));
					}

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
					$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'required|min_length[6]|max_length[50]',
						array('required' => '%s harap dimasukkan.'
					)
					);
					$this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[6]|max_length[250]',
						array('required' => '%s harap dimasukkan.',
							'min_length'=>'%s minimal 6 karakter.'
						)
					);
					$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required',
						array('required' => '%s harap dipilih.'
					)
					);

					if ($this->form_validation->run() == FALSE){

						$errors = validation_errors();
						$respons_ajax['type'] = 'error';
						$respons_ajax['pesan'] = $errors;

					}else{

						$iduser = $this->input->post('id_user');
						$email = trim($this->input->post('email',TRUE));
						
						$nama = ucwords($this->input->post('nama', TRUE));
						$jk = $this->input->post('jk', TRUE);
						$telp = $this->input->post('telepon', TRUE);
						$tgllahir = tanggal1($this->input->post('tgllahir', TRUE));
						$alamat = $this->input->post('alamat', TRUE);

						if($this->User_model->update_user($iduser, $email, $nama, null, $jk, $telp, $tgllahir, $alamat)){
							$respons_ajax['type'] = 'success';
							$respons_ajax['pesan'] = 'Berhasil Terubah';
							$_SESSION['email'] = $email;
							$_SESSION['nama'] = $nama;
						}else{
							$respons_ajax['type'] = 'error';
							$respons_ajax['pesan'] = 'Gagal Terubah';
						}

					}
					echo json_encode($respons_ajax);

				}else{
					if($this->input->post('email') != $this->input->post('email_lama') ){
						$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|valid_email', 
							array('is_unique'=>'%s sudah terdaftar.',
								'valid_email'=>'%s harap masukkan email dengan benar'));
					}

					$this->form_validation->set_rules('nama', 'Nama', 'required|min_length[6]|max_length[50]|alpha_numeric_spaces',
						array('required' => '%s harap dimasukkan.',
							'min_length'=>'%s minimal 6 karakter.',
							'max_length'=>'%s maksimal 50 karakter',
							'alpha_numeric_spaces'=>'%s tidak boleh mengandung angka atau karakter lain selain huruf'
						)
					);

					if ($this->form_validation->run() == FALSE){

						$errors = validation_errors();
						$respons_ajax['type'] = 'error';
						$respons_ajax['pesan'] = $errors;

					}else{

						$iduser = $this->input->post('id_user');
						$email = trim($this->input->post('email',TRUE));
						
						$nama = ucwords($this->input->post('nama', TRUE));

						if($this->User_model->update_user($iduser, $email, $nama, 'edit')){
							$respons_ajax['type'] = 'success';
							$respons_ajax['pesan'] = 'Berhasil Terubah';
							$_SESSION['email'] = $email;
							$_SESSION['nama'] = $nama;
						}else{
							$respons_ajax['type'] = 'error';
							$respons_ajax['pesan'] = 'Gagal Terubah';
						}

					}
					echo json_encode($respons_ajax);
				}
			}

		}else{
			show_404();
		}
	}

	public function ubah_password($iduser)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			if($iduser == $_SESSION['id_user']){
				$data = new stdClass();
				$data->title = 'Profile';
				$data->page_active = 'home';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$data->user = $this->User_model->get_user($data->email)->row();
				$this->load->view('header_menu', $data);

				$this->load->view('ubah_password');

			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function submit_ubah_password()
	{
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[50]',
			array('required' => '%s harap dimasukkan.',
				'min_length'=>'%s minimal 6 karakter.',
			)
		);

		if ($this->form_validation->run() == FALSE){

			$errors = validation_errors();
			$respons_ajax['type'] = 'error';
			$respons_ajax['pesan'] = $errors;

		}else{

			$iduser = $this->input->post('id_user');
			
			$password = $this->input->post('password', TRUE);

			if($this->User_model->update_password($iduser, $password)){
				$respons_ajax['type'] = 'success';
				$respons_ajax['pesan'] = 'Berhasil Terubah';
			}else{
				$respons_ajax['type'] = 'error';
				$respons_ajax['pesan'] = 'Gagal Terubah';
			}

		}
		echo json_encode($respons_ajax);

	}
}
