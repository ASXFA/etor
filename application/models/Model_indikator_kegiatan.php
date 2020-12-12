<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_indikator_kegiatan extends CI_Model{
    var $table = 'indikator_kegiatan';
    // var $select_column = array('id','nama_role','created_by');
    // var $order_column = array(null,'nama_role',null);

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

    // public function getAll()
    // {
    //     return $this->db->get($this->table)->result();
    // }

    public function getByKegiatan($id_kegiatan)
    {
        $this->db->where('id_kegiatan',$id_kegiatan);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByKegiatanArr($id_kegiatan)
    {
        $this->db->where('id_kegiatan',$id_kegiatan);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function getById($id)
    {
        $this->db->where('id',$id);
        $indikator = $this->db->get($this->table);
        return $indikator;
    }

    // public function getById($id)
    // {
    //     $this->db->where('id',$id);
    //     return $this->db->get($this->table);
    // }

    public function addIndikator($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editIndikator($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query; 
    }

    // public function deleteRole($id)
    // {
    //     $this->db->where('id',$id);
    //     $query = $this->db->delete($this->table);
    //     return $query;
    // }

}