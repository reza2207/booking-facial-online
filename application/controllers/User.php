<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){

		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('User_model');
		$this->load->helper('tanggal_helper');
		$this->load->helper('terbilang_helper');

	}	


	public function index()
	{

		if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true)
		{	

			$data = new stdClass();
			$data->title = 'Register';
			$data->role = $_SESSION['role'];
			$this->load->view('header', $data);
			if($_SESSION['role'] == 'admin'){

				$this->load->view('register_v');
			}else{
				$this->load->view('header', $data);
				$this->load->view('home');
			}

		}else{
			$data = new stdClass();
			$data->title = 'Login';

			$this->load->view('header', $data);
			$this->load->view('login_form');
		}
	
	}

	public function submit_user()
	{

		if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true)
		{	
			show_404();
			
		}else{
			
			if($this->input->post(null)){
				//initialize button submit
				
				$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|valid_email', 
						array('is_unique'=>'%s sudah terdaftar.',
							'valid_email'=>'%s harap masukkan email dengan benar'));
		        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[50]',
		                array('required' => '%s harap dimasukkan.',
		                	'min_length'=>'%s minimal 6 karakter.',
		                )
		        );
		        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[6]|max_length[50]|alpha_numeric_spaces',
		                array('required' => '%s harap dimasukkan.',
		                	'min_length'=>'%s minimal 6 karakter.',
		                	'max_length'=>'%s maksimal 50 karakter',
		                	'alpha_numeric_spaces'=>'%s tidak boleh mengandung angka atau karakter lain selain huruf'
		                )
		        );
		        $this->form_validation->set_rules('telp', 'Telepon', 'required|min_length[6]|max_length[50]|numeric',
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
		            echo json_encode($respons_ajax);

		        }else{

		        	$email = trim($this->input->post('email',TRUE));
					$password = $this->input->post('password');
					$nama = ucwords($this->input->post('nama', TRUE));
					$jk = $this->input->post('jk', TRUE);
					$telp = $this->input->post('telp', TRUE);
					$tgllahir = tanggal1($this->input->post('tgllahir', TRUE));
					$alamat = $this->input->post('alamat', TRUE);
					$role = 'user';//set default user
					//$this->input->post('role');
					//
					
					//
					if($this->User_model->create_user($email, $password, $nama, $jk, $telp, $tgllahir, $alamat, $role)){
						//$iduser = $this->User_model->get_user($email)->row('id_user');
						//$this->User_model->make_token($iduser);
						//$token = $this->get_token($iduser);
						//$this->_send_email_verification($iduser, $token, $email);
						$respons_ajax['type'] = 'success';
						$respons_ajax['pesan'] = 'Berhasil Terdaftar';
						//$respons_ajax['iduser'] = $iduser;
						echo json_encode($respons_ajax);
					}else{
						$respons_ajax['type'] = 'error';
						$respons_ajax['pesan'] = 'Gagal Terdaftar';
						echo json_encode($respons_ajax);
					}	
				}

			}
			
		}
		
	}
	public function submit_login() 
	{
		
		if($this->input->post() != NULL){
			// create the data object
			$data = new stdClass();
			
			// load form helper and validation library
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			// set validation rules
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == false) {
				
				$data->type = 'error';
				$data->pesan = validation_errors();
				echo json_encode($data);
			} else {

				// set variables from the form
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				
				if ($this->User_model->resolve_user_login($email, $password)) {
					
					$user    = $this->User_model->get_user($email)->row();
					
					if($user->status == 'Active'){
						// set session user datas
						$_SESSION['email']     = $user->email;
						$_SESSION['logged_in']    = (bool)true;
						$_SESSION['role']     = $user->peran;
						$_SESSION['nama'] = (string)$user->nama;
						$_SESSION['id_user'] = $user->id_user;

						$data->type = 'success';
						$data->pesan = "Selamat Datang ".$user->nama;
						$this->get_jumlah_data_keranjang($_SESSION['id_user']);
						echo json_encode($data);
					}else{

						//$this->halaman_verifikasi($user->id_user);
					}
					
				} else {
					
					// login failed
					$data->type = 'error';
					$data->pesan = 'Username atau Password Salah.';
					echo json_encode($data);
					
				}

			}
			
		}else{
			show_404();
		}
		
	}


	public function login(){

		if(isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] === true)
		{	

			$data = new stdClass();
			$data->title = 'Register';
			$data->role = $_SESSION['role'];
			$this->load->view('header', $data);
			
			$this->load->view('header', $data);
			$this->load->view('home');
			

		}else{
			$data = new stdClass();
			$data->title = 'Login';

			$this->load->view('header', $data);
			$this->load->view('login_form');
		}
	}

	public function register(){

		$data = new stdClass();
		$data->title = 'Register';

		$this->load->view('header', $data);
		$this->load->view('register_v');
	}

	public function logout()
	{
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in'])  AND $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			redirect(base_url());
			
		} else {
			
			redirect(base_url());
			
		}


	}

	protected function get_jumlah_data_keranjang($userid)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{	
			$this->load->model('Produk_model');
			$userid = $_SESSION['id_user'];
			$jml = $this->Produk_model->get_jumlah_data_keranjang($userid)->num_rows();
			$_SESSION['jml_keranjang'] = $jml;
			return true;
			
		}else{
			$_SESSION['jml_keranjang'] = null;
			return false;
		}
	}

	private function _send_email_verification($iduser, $token, $email)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('email');
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);

		$this->email->from('admin@bookingfacialfbc.com', 'Admin Farina');
		$this->email->to(array($email));
		/*$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');*/

		$this->email->subject('Email Verifikasi');
		$message = 'mohon klik di halaman ini www.bookingfacialfbc.com/user/verifikasi_email?id='.$iduser.'&token='.$token.'">klik disini</a>';
		$this->email->message($message);

		$this->email->send();
	}

	public function halaman_verifikasi($iduser)
	{
		$data = new stdClass();
		$data->title = 'Verifikasi Email';
		$data->email = $this->User_model->get_data_user($iduser)->row('email');
		$this->load->view('header', $data);
		$this->load->view('verifikasi_email');
	}


	public function verifikasi_email()
	{
		if(isset($_GET['id_user']) && isset($_GET['token'])){
			$id = $_GET['id_user'];
			$token = $_GET['token'];
			if($this->User_model->get_data_user($iduser)->row()->status == 'Non Active'){
				if(strtotime($this->cek_exp_token($token)->expired) < strtotime(date('Y-m-d H:i:s'))){
					echo 'Expired';
				}else{
					$this->update_status_user($id);
					?>
					Akun ada telah aktif, mohon login kembali <a href="<?= base_url().'login';?>">Login</a>
				<?php }
			}
		}
	}

	private function get_token($iduser){
		return $this->User_model->cek_token($iduser)->row()->id_token;
	}

	private function cek_exp_token($token){
		return $this->User_model->cek_exp_token($token)->row();
	}

	private function update_status_user($id)
	{
		return $this->User_model->update_status_user($iduser);
	}

	public function jajal_email()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('email');
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		$email = array('reza.2207@gmail.com');
		$this->email->from('admin@bookingfacialfbc.com', 'Admin Farina');
		$this->email->to($email);
		
		/*$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');*/

		$this->email->subject('Email Verifikasi');
		$message = 'tes';
		//$message = 'mohon klik di halaman ini <a href="wwww.bookingfacialfbc.com/user/verifikasi_email?id='.$iduser.'&token='.$token.'">klik disini</a>';
		$this->email->message($message);

		$this->email->send();
	}


}