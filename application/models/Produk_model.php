<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Produk_model extends CI_Model {

	var $table = 'tb_produk';
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	public function new_data($id, $gambar, $nama, $harga, $keterangan){
		$data = array('id_produk'=>$id,
			'nama'=>$nama,
			'deskripsi'=>$keterangan,
			'harga'=>$harga,
			'status'=>'Aktif',
			'gambar'=>$gambar);
		return $this->db->insert($this->table, $data);
	}


	public function get_data_id($id)
	{
		$this->db->select('tb_produk.id_produk, tb_produk.nama, tb_produk.deskripsi, tb_produk.harga, tb_produk.gambar, tb_produk.status, a.masuk, b.keluar');
		$this->db->from($this->table);
		$this->db->join('(SELECT SUM(tb_stok.jumlah) masuk, id_produk FROM tb_stok GROUP BY id_produk) a','tb_produk.id_produk = a.id_produk', 'LEFT');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.jumlah) keluar, tb_detail_transaksi.id_produk FROM tb_detail_transaksi LEFT JOIN tb_transaksi ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi WHERE tb_transaksi.status = "Terkirim" OR tb_transaksi.status = "Menunggu Konfirmasi Alamat" OR tb_transaksi.status = "Menunggu Pembayaran" OR tb_transaksi.status = "Pembayaran Sedang Diverifikasi" OR tb_transaksi.status = "Pembayaran Lunas" OR tb_transaksi.status = "Pembayaran Lunas" OR tb_transaksi.status = "Menunggu Dikirim" OR tb_transaksi.status = "Dikirim" GROUP BY id_produk) b', 'tb_produk.id_produk = b.id_produk', 'LEFT');
		
		$this->db->where('tb_produk.id_produk', $id);
		return $this->db->get();

	}

	public function get_data($params = null)
	{	
		$this->db->select('tb_produk.id_produk, tb_produk.nama, tb_produk.deskripsi, tb_produk.harga, tb_produk.gambar, tb_produk.status, a.masuk, b.keluar');
		$this->db->from($this->table);
		$this->db->join('(SELECT SUM(tb_stok.jumlah) masuk, id_produk FROM tb_stok GROUP BY id_produk) a','tb_produk.id_produk = a.id_produk', 'LEFT');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.jumlah) keluar, tb_detail_transaksi.id_produk FROM tb_detail_transaksi LEFT JOIN tb_transaksi ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi WHERE tb_transaksi.status = "Terkirim" OR tb_transaksi.status = "Menunggu Konfirmasi Alamat" OR tb_transaksi.status = "Menunggu Pembayaran" OR tb_transaksi.status = "Pembayaran Sedang Diverifikasi" OR tb_transaksi.status = "Pembayaran Lunas" OR tb_transaksi.status = "Pembayaran Lunas" OR tb_transaksi.status = "Menunggu Dikirim" OR tb_transaksi.status = "Dikirim" GROUP BY id_produk) b', 'tb_produk.id_produk = b.id_produk', 'LEFT');

		if($params != null){
			$this->db->where('tb_produk.status', $params);
		}
		return $this->db->get();
	}

	public function update_data($id, $gambar, $nama, $harga, $keterangan, $status)
	{
		$data = array('nama'=>$nama,
			'deskripsi'=>$keterangan,
			'harga'=>$harga,
			'gambar'=>$gambar,
			'status'=>$status);
		$this->db->where('id_produk', $id);

		return $this->db->update($this->table, $data);
	}

	public function add_stok($idstok, $id, $jumlah)
	{
		$data = array(
			'id_stok'=>$idstok,
			'id_produk'=>$id,
			'jumlah'=>$jumlah,
			'tanggal_input'=>date('Y-m-d H:i:s'));
		return $this->db->insert('tb_stok', $data);
	}

	public function list_product($limit, $start, $params = null) 
	{
		$this->db->select('tb_produk.id_produk, tb_produk.nama, tb_produk.deskripsi, tb_produk.harga, tb_produk.gambar, tb_produk.status, IFNULL(a.masuk, 0) masuk, IFNULL(b.keluar, 0) keluar');
		$this->db->from($this->table);
		$this->db->join('(SELECT SUM(tb_stok.jumlah) masuk, id_produk FROM tb_stok GROUP BY id_produk) a','tb_produk.id_produk = a.id_produk', 'LEFT');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.jumlah) keluar, tb_detail_transaksi.id_produk FROM tb_detail_transaksi LEFT JOIN tb_transaksi ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi WHERE tb_transaksi.status = "terbayar" GROUP BY id_produk) b', 'tb_produk.id_produk = b.id_produk', 'LEFT');
		if($params != null){
			$this->db->where('tb_produk.status', $params);
		}
		$this->db->limit($limit, $start);
		return $this->db->get();

	}

	public function check_keranjang($idproduct, $userid){
		$this->db->from('tb_temp_trans');
		$this->db->where('id_user', $userid);
		$this->db->where('id_produk', $idproduct);
		return $this->db->get()->num_rows();
	}



	public function keranjang($id, $idproduct, $userid)
	{
		$data = array('id_temp_trans'=>$id,
			'id_user'=>$userid,
			'id_produk'=>$idproduct);
		return $this->db->insert('tb_temp_trans', $data);
	}

	public function get_jumlah_data_keranjang($userid)
	{	
		$this->db->select('tb_temp_trans.id_produk, tb_temp_trans.id_temp_trans, tb_produk.nama, tb_produk.gambar, tb_produk.harga, (IFNULL(a.masuk, 0)- IFNULL(b.keluar, 0)) AS sisa ');
		$this->db->from('tb_temp_trans');
		$this->db->join('tb_produk', 'tb_temp_trans.id_produk = tb_produk.id_produk', 'LEFT');
		$this->db->join('(SELECT SUM(tb_stok.jumlah) masuk, id_produk FROM tb_stok GROUP BY id_produk) a','tb_produk.id_produk = a.id_produk', 'LEFT');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.jumlah) keluar, tb_detail_transaksi.id_produk FROM tb_detail_transaksi LEFT JOIN tb_transaksi ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi WHERE tb_transaksi.status = "terbayar" GROUP BY id_produk) b', 'tb_produk.id_produk = b.id_produk', 'LEFT');
		$this->db->where('id_user', $userid);
		return $this->db->get();
	}

	public function hapus_keranjang($id)
	{
		return $this->db->delete('tb_temp_trans', array('id_temp_trans'=>$id));
	}

	public function get_id_trans()
	{
		$this->db->select('id_transaksi');
		$this->db->from('tb_transaksi');
		$this->db->order_by('id_transaksi', 'DESC');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function new_trans($id, $iduser )
	{
		$data = array('id_transaksi'=>$id,
			'id_user'=>$iduser,
			'status'=>'Menunggu Konfirmasi Alamat');
		return $this->db->insert('tb_transaksi', $data);
	}

	public function check_alamat($idtrans)
	{
		$this->db->select('nama');
		$this->db->from('tb_transaksi');
		$this->db->where('id_transaksi', $idtrans);
		return $this->db->get();
	}

	public function alamat_kirim($iduser)
	{
		$this->db->select('`id_alamat`, `id_user`, `nama`, `alamat`, `telepon`, `kecamatan`, `provinsi`, `kodepos`');
		$this->db->from('tb_alamat');
		$this->db->where('id_user', $iduser);
		$this->db->order_by('id_alamat');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function delete_temp($temp)
	{
		for($i = 0;$i < count($temp);$i++){

			$this->db->where('id_temp_trans', $temp[$i]);
			$this->db->delete('tb_temp_trans');
		}
	}

	public function get_trans($id)
	{
		$this->db->select('tb_detail_transaksi.id_detail_transaksi, tb_detail_transaksi.id_transaksi, tb_detail_transaksi.id_transaksi, tb_detail_transaksi.id_produk, tb_detail_transaksi.harga, tb_detail_transaksi.jumlah, tb_produk.nama, tb_produk.gambar, tb_transaksi.status, tb_transaksi.tgl_transaksi');
		$this->db->from('tb_detail_transaksi');
		$this->db->join('tb_transaksi', 'tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi', 'LEFT');
		$this->db->join('tb_produk', 'tb_detail_transaksi.id_produk = tb_produk.id_produk', 'LEFT');
		$this->db->where('tb_detail_transaksi.id_transaksi', $id);
		return $this->db->get();
	}

	public function data_on_proses($userid, $params = NULL)
	{
		$this->db->select('tb_transaksi.id_transaksi, tb_transaksi.tgl_transaksi, tb_transaksi.status, b.total');
		$this->db->from('tb_transaksi');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.harga* tb_detail_transaksi.jumlah) total, tb_detail_transaksi.id_transaksi FROM tb_detail_transaksi GROUP BY tb_detail_transaksi.id_transaksi ) b', 'tb_transaksi.id_transaksi = b.id_transaksi', 'LEFT');
		$this->db->where('status !=', 'Terkirim');

		if($params != NULL){
			$this->db->where('status !=', $params);
		}
		//$this->db->where('status !=', 'Batal');
		$this->db->where('id_user', $userid);
		$this->db->order_by('tb_transaksi.id_transaksi', 'DESC');
		return $this->db->get();
	}

	public function data_terkirim($userid)
	{
		$this->db->select('tb_transaksi.id_transaksi, tb_transaksi.tgl_transaksi, tb_transaksi.status, b.total');
		$this->db->from('tb_transaksi');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.harga* tb_detail_transaksi.jumlah) total, tb_detail_transaksi.id_transaksi FROM tb_detail_transaksi GROUP BY tb_detail_transaksi.id_transaksi ) b', 'tb_transaksi.id_transaksi = b.id_transaksi', 'LEFT');
		$this->db->where('status =', 'Terkirim');

		
		$this->db->where('id_user', $userid);
		$this->db->order_by('tb_transaksi.id_transaksi', 'DESC');
		return $this->db->get();
	}

	public function data_proses($userid = NULL, $params = NULL, $limit = NULL, $start = NULL)
	{
		$this->db->select('tb_transaksi.id_transaksi, tb_transaksi.tgl_transaksi, tb_transaksi.status, b.total');
		$this->db->from('tb_transaksi');
		$this->db->join('(SELECT SUM(tb_detail_transaksi.harga* tb_detail_transaksi.jumlah) total, tb_detail_transaksi.id_transaksi FROM tb_detail_transaksi GROUP BY tb_detail_transaksi.id_transaksi ) b', 'tb_transaksi.id_transaksi = b.id_transaksi', 'LEFT');

		if($params != NULL && $params == 'onproses'){
			$this->db->where('status !=', 'Terkirim');
			$this->db->where('status !=', 'Batal');
		}elseif($params != NULL && $params == 'pembayaran'){
			$this->db->where('status', 'Menunggu Pembayaran');

			$this->db->or_where('status', 'Pembayaran Sedang Diverifikasi');
			$this->db->or_where('status', 'Pembayaran Kurang');

		}elseif($params != NULL && $params == 'pengiriman'){
			$this->db->where('status', 'Pembayaran Lunas');
			$this->db->or_where('status', 'Menunggu Dikirim');
			$this->db->or_where('status', 'Dikirim');
			$this->db->or_where('status', 'Terkirim');
		}
		if($userid != NULL){
			$this->db->where('id_user', $userid);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('tb_transaksi.id_transaksi', 'DESC');
		return $this->db->get();
	}

	public function data_pembayaran($limit = null, $start = null)
	{
		$this->db->select('id_pembayaran, id_transaksi, tanggal_transfer, bank, nama_rekening, bukti_transfer, jumlah_transfer, tgl_submit, status_pembayaran');
		$this->db->from('tb_pembayaran');
		if($limit !== null && $start !== null){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('id_pembayaran', 'DESC');
		return $this->db->get();
	}

	public function tambah_alamat($idalamat, $iduser, $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos)
	{
		$data = array('id_alamat'=>$idalamat,
			'id_user'=>$iduser,
			'nama'=>$nama,
			'alamat'=>$alamat,
			'telepon'=>$telepon,
			'kecamatan'=>$kecamatan,
			'kodepos'=>$kodepos);
		return $this->db->insert('tb_alamat', $data);
	}

	public function update_alamat_trx($id){
		$data = array(
			'status'=>'Menunggu Pembayaran',
			'tgl_transaksi'=>date('Y-m-d H:i:s'));
		$this->db->where('id_transaksi', $id);
		return $this->db->update('tb_transaksi', $data);
	}

	

	public function update_alamat($id, $idalamat, $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos)
	{
		$data = array('nama'=>$nama,
			'alamat'=>$alamat,
			'telepon'=>$telepon,
			'kecamatan'=>$kecamatan,
			'provinsi'=>$provinsi,
			'kodepos'=>$kodepos,
		);
		$this->db->where('id_transaksi', $id);
		return $this->db->update('tb_transaksi', $data);
	}

	public function update_tb_alamat( $idalamat, $nama, $alamat, $telepon, $kecamatan, $provinsi, $kodepos)
	{
		$data = array('nama'=>$nama,
			'alamat'=>$alamat,
			'telepon'=>$telepon,
			'kecamatan'=>$kecamatan,
			'provinsi'=>$provinsi,
			'kodepos'=>$kodepos,
		);
		$this->db->where('id_alamat', $idalamat);
		return $this->db->update('tb_alamat', $data);
	}

	public function get_data_trans($id)
	{
		$this->db->select('`id_transaksi`, `tgl_transaksi`, `id_user`, `status`, `nama`, `alamat`, `telepon`, `kecamatan`, `provinsi`, `kodepos`');
		$this->db->from('tb_transaksi');
		$this->db->where('id_transaksi', $id);
		return $this->db->get();

	}

	public function update_batal()
	{
		$data = array('status'=>'Batal');
		$this->db->where('DATE_ADD(tgl_transaksi, INTERVAL 2 HOUR) < now()');
		$this->db->where('status', 'Menunggu Pembayaran');//false
		/*$this->db->where('status !=', 'Menunggu Konfirmasi Alamat');
		$this->db->where('status !=', '');*/
		$this->db->where('TIME(tgl_transaksi) != ', '00:00:00');

		return $this->db->update('tb_transaksi', $data);
	}

	public function check_id_trf($idtrx)
	{
		$this->db->select('id_pembayaran');
		$this->db->from('tb_pembayaran');
		$this->db->where('id_transaksi', $idtrx);
		$this->db->order_by('id_pembayaran');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function upload_bukti($id, $idtrx, $tgl, $jumlah, $bank, $nama, $gambar, $status)
	{
		$data = array('id_pembayaran'=>$id,
			'id_transaksi'=>$idtrx, 
			'tanggal_transfer'=>$tgl,
			'jumlah_transfer'=>$jumlah,
			'bank'=>$bank,
			'nama_rekening'=>$nama,
			'bukti_transfer'=>$gambar,
			'status_pembayaran'=>$status,
			'tgl_submit'=>date('Y-m-d h:i:s'));
		return $this->db->insert('tb_pembayaran', $data);
	}

	public function update_status($idtrx, $status)
	{
		$data = array('status'=>$status);
		$this->db->where('id_transaksi', $idtrx);
		return $this->db->update('tb_transaksi', $data);
	}

	public function update_status_pembayaran($idpembayaran, $status)
	{
		$data = array('status_pembayaran'=>$status);
		$this->db->where('id_pembayaran', $idpembayaran);
		return $this->db->update('tb_pembayaran', $data);
	}

	public function get_data_trf($id)
	{
		$this->db->select('`tb_pembayaran.id_pembayaran`, `tb_pembayaran.id_transaksi`, `tb_pembayaran.tanggal_transfer`, `tb_pembayaran.jumlah_transfer`, `tb_pembayaran.bank`, `tb_pembayaran.nama_rekening`, `tb_pembayaran.bukti_transfer`, `tb_pembayaran.tgl_submit`, `tb_pembayaran.status_pembayaran`, `a.total`, `b.jmltrf`');
		$this->db->from('tb_pembayaran');
		$this->db->join('(SELECT SUM(harga*jumlah) AS total, id_transaksi FROM tb_detail_transaksi GROUP BY id_transaksi) a', 'tb_pembayaran.id_transaksi = a.id_transaksi', 'LEFT');
		$this->db->join('(SELECT SUM(jumlah_transfer) AS jmltrf, id_transaksi FROM tb_pembayaran GROUP BY id_transaksi) b', 'tb_pembayaran.id_transaksi = b.id_transaksi', 'LEFT');
		$this->db->where('tb_pembayaran.id_pembayaran', $id);

		return $this->db->get();
	}

	public function update_trf($idpembayaran, $tgl, $jumlah, $bank, $nama)
	{
		$data = array('tanggal_transfer'=>$tgl,
			'jumlah_transfer'=>$jumlah,
			'bank'=>$bank,
			'nama_rekening'=>$nama
		);

		$this->db->where('id_pembayaran', $idpembayaran);
		return $this->db->update('tb_pembayaran', $data);
	}

	public function get_data_pembayaran_by_id($idtrx)
	{
		$this->db->select('`tb_pembayaran.id_pembayaran`, `tb_pembayaran.id_transaksi`, `tb_pembayaran.tanggal_transfer`, `tb_pembayaran.jumlah_transfer`, `tb_pembayaran.bank`, `tb_pembayaran.nama_rekening`, `tb_pembayaran.bukti_transfer`, `tb_pembayaran.tgl_submit`, `tb_pembayaran.status_pembayaran`');/*, `a.total`, `b.jmltrf`*/
		$this->db->from('tb_pembayaran');
		$this->db->where('tb_pembayaran.id_transaksi', $idtrx);
		return $this->db->get();

	}

	public function get_jml_trf()
	{
		$this->db->select('tb_pembayaran.id_pembayaran');
		$this->db->from('tb_pembayaran');
		$this->db->where('tb_pembayaran.status_pembayaran', 'Pembayaran Sedang Diverifikasi');
		return $this->db->get();

	}

	public function get_kecamatan()
	{
		$this->db->select('nama');
		$this->db->from('tb_kecamatan');
		return $this->db->get();
	}

	public function get_report($tgl)
	{
		$this->db->select('tb_detail_transaksi.id_detail_transaksi, tb_detail_transaksi.id_transaksi, tb_detail_transaksi.id_transaksi, tb_detail_transaksi.id_produk, tb_detail_transaksi.harga, tb_detail_transaksi.jumlah, tb_produk.nama, tb_produk.gambar, tb_transaksi.status, tb_transaksi.tgl_transaksi, SUM(tb_detail_transaksi.harga*tb_detail_transaksi.jumlah) as subtotal ');
		$this->db->from('tb_detail_transaksi');
		$this->db->join('tb_transaksi', 'tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi', 'LEFT');
		$this->db->join('tb_produk', 'tb_detail_transaksi.id_produk = tb_produk.id_produk', 'LEFT');
		$this->db->group_by('tb_detail_transaksi.id_produk');
		$this->db->where('tb_transaksi.status', 'Terkirim');
		$this->db->where('DATE(tb_transaksi.tgl_transaksi)', $tgl);
		$this->db->order_by('tb_detail_transaksi.id_produk');
		return $this->db->get();

	}
	
}