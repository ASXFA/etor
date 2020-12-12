<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_rincian_anggaran_koefisien extends CI_Model{
    var $table = 'rincian_anggaran_koefisien';
    var $select_column = array('id','id_rincian_anggaran','jumlah','type','created_by');
    var $order_column = array(null,'id_rincian_anggaran','jumlah','type',null);

    // function make_query()
    // {
    //     $this->db->select($this->select_column);
    //     $this->db->from($this->table);
    //     if (isset($_POST['search']['value'])) {
    //         $this->db->or_like('nama_role',$_POST['search']['value']);
    //     }
    //     if (isset($_POST['order'])) {
    //         $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
    //     }else{
    //         $this->db->order_by('id','DESC');
    //     }
    // }

    // public function make_datatables()
    // {
    //     $this->make_query();
    //     if ($_POST['length'] != -1) {
    //         $this->db->limit($_POST['length'],$_POST['start']);
    //     }
    //     $id = $this->session->userdata('id');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // function get_filtered_data()
    // {
    //     $this->make_query();
    //     $query = $this->db->get();
    //     return $query->num_rows();
    // }

    // function get_all_data()
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->table);
    //     return $this->db->count_all_results();
    // }

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    public function getAllArr()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getByIdRincian($id_rincian)
    {
        $this->db->where('id_rincian_anggaran',$id_rincian);
        $rincian = $this->db->get($this->table)->result();
        return $rincian;
    }

    // public function getById($id)
    // {
    //     $this->db->where('id',$id);
    //     return $this->db->get($this->table);
    // }

    public function addKoefisien($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editRincian($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query; 
    }

    public function deleteKoefisienRincian($id)
    {
        $this->db->where('id_rincian_anggaran',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}