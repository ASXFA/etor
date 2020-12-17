<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_tipe_belanja extends CI_Model{
    var $table = 'tipe_belanja';
    var $select_column = array('id','id_kegiatan','belanja1','belanja2','belanja3','belanja4','judul_pengajuan','tipe_anggaran','jumlah_anggaran','created_by');
    var $order_column = array(null,'id_kegiatan','belanja1','belanja2','belanja3','belanja4','judul_pengajuan','tipe_anggaran','jumlah_anggaran',null);

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('belanja1',$_POST['search']['value']);
            $this->db->or_like('belanja2',$_POST['search']['value']);
            $this->db->or_like('belanja3',$_POST['search']['value']);
            $this->db->or_like('belanja4',$_POST['search']['value']);
            $this->db->or_like('tipe_anggaran',$_POST['search']['value']);
            $this->db->or_like('jumlah_anggaran',$_POST['search']['value']);
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
        $id = $this->session->userdata('id');
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

    // public function getAll()
    // {
    //     return $this->db->get($this->table)->result();
    // }

    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getByKegiatanId($id_kegiatan)
    {   
        $this->db->where('id_kegiatan',$id_kegiatan);
        $this->db->order_by('belanja1 ASC, belanja2 ASC, belanja3 ASC, belanja4 ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getTotal($where)
    {
        $this->db->select('SUM(jumlah_anggaran) as TOTAL');
        $this->db->from('tipe_belanja');
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function add($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function edit($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query; 
    }

    public function delete($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

    // public function getJoin()
    // {
    //     $id_kegiatan = 5;
    //     $this->db->select('*');
    //     $this->db->from('tipe_belanja a');
    //     $this->db->join('rincian_anggaran b', 'b.id_tipe_belanja = a.id','left');
    //     $this->db->join('rincian_anggaran_koefisien c','c.id_rincian_anggaran = b.id','right');
    //     $query = $this->db->get();
    //     if ($query->num_rows()) {
    //         return $query->result_array();
    //     }else{
    //         return FALSE;
    //     }
    // }

}