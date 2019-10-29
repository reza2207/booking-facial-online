<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Facial_model extends CI_Model {

    var $table = 'tb_facial';
    
    public function __construct() {
        
        parent::__construct();
        $this->load->database();
        
    }

   
    public function get_facial($params = null)
    {   
        $this->db->from('tb_facial');
        if($params != null){
            $this->db->where('status', $params);
        }
        return $this->db->get();
    }

    public function get_data_id($id)
    {
         $this->db->from('tb_facial');
         $this->db->where('id_facial', $id);
         return $this->db->get();
    }

    public function new_data($id, $nama, $keterangan, $harga)
    {
        $data = array('id_facial'=>$id,
            'nama'=>$nama,
            'deskripsi'=>$keterangan,
            'harga'=>$harga,
            'status'=>'Aktif');
        return $this->db->insert($this->table, $data);
    }

    public function last_id()
    {
        $this->db->select('id_facial');
        $this->db->from($this->table);
        $this->db->order_by('id_facial', 'DESC');
        $this->db->limit('1');
        return $this->db->get();
    }

    public function update_data($id, $nama, $keterangan, $harga, $status)
    {
       $data = array('nama'=>$nama,
                    'deskripsi'=>$keterangan,
                    'harga'=>$harga,
                    'status'=>$status);
        $this->db->where('id_facial', $id);

        return $this->db->update($this->table, $data);
    }

    
}