<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($email, $password, $nama, $jk, $telp, $tgllahir, $alamat, $role) {
		$this->load->library('encryption');

		$data = array (
			'id_user'=>uniqid(),
			'email'=>$email, 
			'password'=>$this->hash_password($password),
			'nama'=>$nama,
			'jenis_kelamin'=>$jk,
			'alamat'=>$alamat,
			'telepon'=>$telp,
			'tgl_lahir'=>$tgllahir,
			'peran'=>$role,
			//'status'=>'Non Active'
		);

		return $this->db->insert('tb_user', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($email, $password) {
		
		$this->db->select('password');
		$this->db->from('tb_user');
		$this->db->where('email', $email);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('username');
		$this->db->from('tb_user');
		$this->db->where('username', $username);

		return $this->db->get()->row('username');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($email = null, $params = null) {
		
		$this->db->select('`id_user`, `email`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `tgl_lahir`, `peran`, `status`, `no_member`');
		$this->db->from('tb_user');
		if($email !== null){
			$this->db->where('email', $email);
		}
		if($params !== null){
			$this->db->where('peran', $params);
		}
		return $this->db->get();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}

	public function edit_user($iduser, $nomember, $nama, $alamat, $telepon, $email, $jk, $tgllahir)
	{
		$data = array (
			'email'=>$email, 
			'nama'=>$nama,
			'jenis_kelamin'=>$jk,
			'alamat'=>$alamat,
			'telepon'=>$telepon,
			'tgl_lahir'=>$tgllahir,
			'no_member'=>$nomember
		);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_user', $data);
	}
	
	public function update_user($iduser, $email, $nama, $params = null, $jk = null, $telp = null, $tgllahir = null, $alamat = null)
	{
		if($params !== null){
			$data = array (
				'email'=>$email, 
				'nama'=>$nama,
			);
		}else{
			$data = array (
				'email'=>$email, 
				'nama'=>$nama,
				'jenis_kelamin'=>$jk,
				'alamat'=>$alamat,
				'telepon'=>$telp,
				'tgl_lahir'=>$tgllahir
			);
		}
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_user', $data);
	}

	public function update_password($iduser, $password){
		$data = array (
			'password'=>$this->hash_password($password)
		);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_user', $data);
	}

	public function get_data_user($iduser)
	{
		$this->db->select('`id_user`, `email`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `tgl_lahir`, `peran`, `status`, `no_member`');
		$this->db->from('tb_user');
		
		$this->db->where('id_user', $iduser);
		
		return $this->db->get();
	}

	public function make_token($iduser)
	{
		$date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))+12*60*60);
		$data = array('id_token'=>uniqid(),
			'expired'=>$date,
			'id_user'=>$iduser);
		return $this->db->insert('token', $data);
	}

	public function cek_token($iduser)
	{
		$this->db->from('token');
		$this->db->where('id_user', $iduser);
		$this->db->order_by('expired', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function cek_exp_token($token)
	{
		$this->db->select('id_token');
		$this->db->from('token');
		$this->db->where('id_token', $token);
		return $this->db->get();
	}

	public function update_status_user($iduser)
	{
		$data = array (
				
				'status'=>'Active'
			);
		
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_user', $data);
	}
}
