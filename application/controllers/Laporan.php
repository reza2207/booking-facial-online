<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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
		$this->load->model('Booking_model');
		$this->load->helper('tanggal_helper');
		$this->load->helper('terbilang_helper');
		$this->load->library('Pdf');
		date_default_timezone_set('Asia/Bangkok');


	}

	public function index()
	{
		//check session here

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{

			$data = new stdClass();
			$data->title = 'Kelola';
			$data->role = $_SESSION['role'];
			$data->email = $_SESSION['email'];
			$data->logged_in = $_SESSION['logged_in'];
			$data->user = $this->User_model->get_user($_SESSION['email'])->row();
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

	public function booking()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user')
			{

				$data = new stdClass();
				$data->title = 'Laporan Booking Facial';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$this->load->view('header_menu', $data);
				$this->load->view('laporan_booking', $data);

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function penjualan()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user')
			{

				$data = new stdClass();
				$data->title = 'Laporan Booking Facial';
				$data->role = $_SESSION['role'];
				$data->email = $_SESSION['email'];
				$data->logged_in = $_SESSION['logged_in'];
				$data->nama = $_SESSION['nama'];
				$this->load->view('header_menu', $data);
				$this->load->view('laporan_produk', $data);

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function facial()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user'){

				$data = new stdClass();
				$data->title = 'Kelola Facial';
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


	public function report()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user')
			{

				if($this->input->post(null)){

					$tgl = tanggal1($this->input->post('tgl'));

					if($this->input->post('report') == 'booking'){
						
						echo json_encode($this->Booking_model->get_report($tgl)->result());
					}else{
						echo json_encode($this->Produk_model->get_report($tgl)->result());
					}
				}
			}
		}
	}


	public function cetak($tgl = null, $params = null)
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($_SESSION['role'] != 'user')
			{
				if($params == 'product'){
					$pdf = new FPDF('P','mm','A4');
				        // membuat halaman baru
			        $pdf->AddPage();
			        // setting jenis font yang akan digunakan
			        $pdf->SetFont('Arial','B',16);
			        // mencetak string 
			        $pdf->Cell(190,7,'LAPORAN PENJUALAN PRODUCT',0,1,'C');
			        $pdf->Cell(190,7,'FARINA BEAUTY CLINIC JAKARTA',0,1,'C');
			        $pdf->SetFont('Arial','B',12);
			        $pdf->Cell(190,7,'Per '.tanggal_indo(tanggal1($tgl)),0,1,'C');
			        // Memberikan space kebawah agar tidak terlalu rapat
			        $pdf->Cell(10,7,'',0,1);
			        $pdf->SetFont('Arial','B',10);
			        $pdf->Cell(15,6,'No',1,0,'C');
			        $pdf->Cell(30,6,'ID. Produk',1,0, 'C');
			        $pdf->Cell(60,6,'Nama',1,0,'C');
			        $pdf->Cell(30,6,'Harga',1,0,'C');  
			        $pdf->Cell(30,6,'Qty',1,0,'C');
			        $pdf->Cell(30,6,'Jumlah',1,1,'C');
			        $pdf->SetFont('Arial','',10);
			        $result = $this->Produk_model->get_report(tanggal1($tgl))->result();
			        $no = 0;
			        foreach ($result as $row){
			        	$no++;
			            $pdf->Cell(15,6,titik($no),1,0,'C');
			            $pdf->Cell(30,6,$row->id_produk,1,0, 'C');
			            $pdf->Cell(60,6,$row->nama,1,0,'C');
			            $pdf->Cell(30,6,'Rp. '.titik($row->harga),1,0,'R');
			            $pdf->Cell(30,6,titik($row->jumlah),1,0,'R');
			            $pdf->Cell(30,6,titik($row->subtotal),1,1,'R');
			            $total[] = $row->subtotal;
			        }
			        $pdf->Cell(165,6,'TOTAL',1,0,'C');
			        $pdf->Cell(30,6,'Rp. '.titik(array_sum($total)),1,1,'R'); 

			        $namafile = 'LAPORAN PENJUALAN PRODUK '.$tgl.'.pdf';
			        $pdf->Output('',$namafile);
				}else{
					$pdf = new FPDF('P','mm','A4');
				        // membuat halaman baru
			        $pdf->AddPage();
			        // setting jenis font yang akan digunakan
			        $pdf->SetFont('Arial','B',16);
			        // mencetak string 
			        $pdf->Cell(190,7,'LAPORAN BOOKING FACIAL',0,1,'C');
			        $pdf->Cell(190,7,'FARINA BEAUTY CLINIC JAKARTA',0,1,'C');
			        $pdf->SetFont('Arial','B',12);
			        $pdf->Cell(190,7,'Per '.tanggal_indo(tanggal1($tgl)),0,1,'C');
			        // Memberikan space kebawah agar tidak terlalu rapat
			        $pdf->Cell(10,7,'',0,1);
			        $pdf->SetFont('Arial','B',10);
			        $pdf->Cell(15,6,'No',1,0,'C');
			        $pdf->Cell(60,6,'ID. Booking',1,0, 'C');
			        $pdf->Cell(27,6,'Tanggal',1,0,'C');
			        $pdf->Cell(55,6,'Nama Facial',1,0,'C');  
			        $pdf->Cell(30,6,'Harga',1,1,'C');
			        $pdf->SetFont('Arial','',10);
			        $result = $this->Booking_model->get_report(tanggal1($tgl))->result();
			        $no = 0;
			        foreach ($result as $row){
			        	$no++;
			            $pdf->Cell(15,6,titik($no),1,0,'C');
			            $pdf->Cell(60,6,$row->id_booking,1,0, 'C');
			            $pdf->Cell(27,6,$tgl,1,0,'C');
			            $pdf->Cell(55,6,$row->jenis_facial,1,0,'C');
			            $pdf->Cell(30,6,'Rp. '.titik($row->harga),1,1,'R');
			            $total[] = $row->harga;
			        }
			        $pdf->Cell(162,6,'TOTAL',1,0,'C');
			        $pdf->Cell(25,6,'Rp. '.titik(array_sum($total)),1,1,'R'); 

			        $namafile = 'LAPORAN BOOKING FACIAL '.$tgl.'.pdf';
			        $pdf->Output('',$namafile);
			    }

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	

	
}
