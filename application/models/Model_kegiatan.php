<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_kegiatan extends CI_Model{
    var $table = 'kegiatan';
    var $select_column = array('id','kegiatan','sub_kegiatan','tanggal','anggaran','nama_pengusul','nama_pemegang_kegiatan','created_by');
    var $order_column = array(null,'kegiatan','sub_kegiatan','tanggal','anggaran','nama_pengusul','nama_pemegang_kegiatan',null,null);

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('kegiatan',$_POST['search']['value']);
            $this->db->or_like('sub_kegiatan',$_POST['search']['value']);
            $this->db->or_like('anggaran',$_POST['search']['value']);
            $this->db->or_like('nama_pengusul',$_POST['search']['value']);
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

    public function getRekap()
    {
        $this->db->select('*');
        $this->db->from('kegiatan');
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('kegiatan',$_POST['search']['value']);
            $this->db->or_like('sub_kegiatan',$_POST['search']['value']);
            $this->db->or_like('belanja4',$_POST['search']['value']);
            $this->db->or_like('jumlah_anggaran',$_POST['search']['value']);
        }
        $this->db->join('tipe_belanja','tipe_belanja.id_kegiatan = kegiatan.id','right');
        $this->db->join('rincian_anggaran','rincian_anggaran.id_tipe_belanja = tipe_belanja.id','left');
        // if (isset($_POST['order'])) {
        //     $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        // }else{
            
        // }
        // $this->db->join('rincian_anggaran_koefisien','rincian_anggaran_koefisien.id_rincian_anggaran = rincian_anggaran.id','right');
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'],$_POST['start']);
        }
        $this->db->order_by('belanja4','ASC');
        return $this->db->get()->result();
    }

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    public function getById($id)
    {
        $this->db->where('id',$id);
        return $this->db->get($this->table);
    }

    public function addKegiatan($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editKegiatan($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query; 
    }

    public function deleteKegiatan($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}