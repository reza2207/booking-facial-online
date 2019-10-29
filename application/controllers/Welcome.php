<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		
		//$this->load->model('user_model');

		
		
	}

	public function index()
	{	
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{	

			$data = new stdClass();
			$data->title = 'FARINA BEAUTY CLINIC';
			$data->page_active = 'home';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->nama = $_SESSION['nama'];

			if($_SESSION['role'] == 'user'){
				$this->load->view('header', $data);

				$this->load->view('home');
			}else{
				$this->load->view('header_menu', $data);
				$this->load->view('home');
			}

		}else{
			$data = new stdClass();
			$data->title = 'FARINA BEAUTY CLINIC';
			$data->page_active = 'home';
			$this->load->view('header', $data);

			$this->load->view('home');
		}
	}
}
