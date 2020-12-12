<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_rincian_anggaran extends CI_Model{
    var $table = 'rincian_anggaran';
    var $select_column = array('id','id_tipe_belanja','deskripsi','satuan','harga','ppn','jumlah_rincian','telaahan','rekomendasi','status','created_by');
    var $order_column = array(null,'id_tipe_belanja','deskripsi','satuan','harga','ppn','jumlah_rincian','telaahan','rekomendasi','status',null);

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('deskripsi',$_POST['search']['value']);
            $this->db->or_like('satuan',$_POST['search']['value']);
            $this->db->or_like('harga',$_POST['search']['value']);
            $this->db->or_like('ppn',$_POST['search']['value']);
            $this->db->or_like('jumlah_rincian',$_POST['search']['value']);
            $this->db->or_like('telaahan',$_POST['search']['value']);
            $this->db->or_like('rekomendasi',$_POST['search']['value']);
            $this->db->or_like('status',$_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id','DESC');
        }
    }

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'],$_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    public function getAllArr()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getById($id)
    {
        $this->db->where('id',$id);
        $bagian = $this->db->get($this->table);
        return $bagian;
    }

    public function getByTipeId($id_tipe)
    {
        $this->db->where('id_tipe_belanja',$id_tipe);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function addRincian($data)
    {
        $query = $this->db->insert($this->table,$data);
        $getId = $this->db->insert_id();
        return $getId;
    }

    public function editRincian($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query; 
    }

    public function deleteRincian($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}