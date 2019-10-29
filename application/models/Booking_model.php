<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Booking_model extends CI_Model {

	var $table = 'tb_booking';
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	public function jam_booking(){
		$this->db->from('tb_jam');
		return $this->db->get();
	}

	public function check_jadwal($tgl, $jam)
	{
		$this->db->select('id_booking');
		$this->db->from($this->table);
		$this->db->where('tanggal', $tgl);
		$this->db->where('jam', $jam);
		$this->db->where('status != ', 'batal');
		return $this->db->get();

	}

	public function check_tgl($tgl){
		$this->db->select('id_booking');
		$this->db->from($this->table);
		$this->db->where('tanggal', $tgl);
		$this->db->order_by('id_booking', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function new_data($id, $id_user, $nama, $tgl, $jam, $telp, $email, $idfacial, $harga){
		$data = array('id_booking'=>$id,
					'id_user'=>$id_user,
					'nama'=>$nama, 
					'tanggal'=>$tgl,
					'jam'=>$jam,
					'telepon'=>$telp,
					'email'=>$email,
					'id_facial'=>$idfacial,
					'status'=>'Dalam Proses',
					'harga'=>$harga);
		return $this->db->insert($this->table, $data);
	}

	public function get_data($userid = null, $params = null, $tgl = null)
	{	
		$this->db->select('tb_booking.id_booking, tb_booking.id_user, tb_booking.nama, tb_booking.telepon, tb_booking.email,  tb_facial.nama jenis_facial, tb_booking.tanggal, tb_booking.jam, tb_booking.status, tb_booking.harga, tb_booking.edit');
		$this->db->from($this->table);
		$this->db->join('tb_facial', 'tb_booking.id_facial = tb_facial.id_facial', 'LEFT');
		if($userid != null ){
			$this->db->where('id_user', $userid);
		}
		if($params !== NULL){
			if($params == 'selesai'){
				$this->db->where('tb_booking.status', 'Selesai');
				$this->db->or_where('tb_booking.status', 'Batal');
			}else{
				$this->db->where('tb_booking.status !=', 'Selesai');
				$this->db->where('tb_booking.status !=', 'Batal');
			}
		}
		if($tgl !== NULL){
			$this->db->where('tb_booking.tanggal', $tgl);
		}
		$this->db->order_by('tanggal_book', 'DESC');
		return $this->db->get();
	}

	public function get_report($tgl = null)
	{	
		$this->db->select('tb_booking.id_booking, tb_booking.id_user, tb_booking.nama, tb_booking.telepon, tb_booking.email,  tb_facial.nama jenis_facial, tb_booking.tanggal, tb_booking.jam, tb_booking.status, tb_booking.harga, tb_booking.edit');
		$this->db->from($this->table);
		$this->db->join('tb_facial', 'tb_booking.id_facial = tb_facial.id_facial', 'LEFT');
		
		$this->db->where('tb_booking.status', 'Selesai');
		$this->db->where('tb_booking.tanggal', $tgl);
		
		$this->db->order_by('tanggal_book', 'DESC');
		return $this->db->get();
	}

	public function batal($id)
	{
		$data = array(
			'status'=>'Batal');
		$this->db->where('id_booking', $id);
		return $this->db->update($this->table, $data);
	}

	public function list_booking($limit, $start, $params = null) 
	{
		$this->db->select('tb_booking.id_booking, tb_booking.id_user, tb_booking.nama, tb_booking.telepon, tb_booking.email,  tb_facial.nama jenis_facial, tb_booking.tanggal, tb_booking.jam, tb_booking.status, tb_booking.harga, tb_booking.edit');
		$this->db->from($this->table);
		$this->db->join('tb_facial', 'tb_booking.id_facial = tb_facial.id_facial', 'LEFT');
		if($params != null){
			$this->db->where('tb_booking.status', $params);
		}
		$this->db->order_by('tanggal_book', 'DESC');
		$this->db->limit($limit, $start);
		return $this->db->get();

	}
	public function selesai($id)
	{
		$data = array(
			'status'=>'Selesai');
		$this->db->where('id_booking', $id);
		return $this->db->update($this->table, $data);
	}

	public function update_selesai()
	{
		$data = array(
			'status'=>'Batal');
		$this->db->where('CURRENT_DATE() > tb_booking.tanggal ');
		return $this->db->update($this->table, $data);
	}

	public function get_data_id($id)
	{
		$this->db->select('tb_booking.id_booking, tb_booking.id_user, tb_booking.nama, tb_booking.telepon, tb_booking.email, tb_facial.nama jenis_facial, tb_booking.tanggal, tb_booking.jam, tb_booking.status, tb_booking.harga, tb_booking.edit, tb_booking.id_facial');
		$this->db->from($this->table);
		$this->db->join('tb_facial', 'tb_booking.id_facial = tb_facial.id_facial', 'LEFT');
		$this->db->where('tb_booking.id_booking', $id);
		return $this->db->get();

	}

	public function update_data($id, $tgl, $jam, $jenis, $harga)
	{
		$data = array(
			'tanggal'=>$tgl,
			'jam'=>$jam,
			'id_facial'=>$jenis,
			'harga'=>$harga);
		$this->db->where('id_booking', $id);

		return $this->db->update($this->table, $data);
	}

	public function get_harga($idfacial)
	{
		$this->db->select('harga');
		$this->db->from('tb_facial');
		$this->db->where('id_facial', $idfacial);
		return $this->db->get();
	}

	
}