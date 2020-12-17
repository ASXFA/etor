<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_belanja extends CI_Model{
    var $table = 'belanja';
    // var $select_column = array('id','nama_role','created_by');
    // var $order_column = array(null,'nama_role',null);

    public function getK()
    {
        $this->db->where('A','5');
        $this->db->where('K !=','');
        $this->db->where('J','');
        $this->db->where('O','');
        $this->db->where('RO','');
        $this->db->where('SRO','');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getJ($K)
    {
        $this->db->where('A','5');
        $this->db->where('K',$K);
        $this->db->where('J !=','');
        $this->db->where('O','');
        $this->db->where('RO','');
        $this->db->where('SRO','');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getO($K,$J)
    {
        $this->db->where('A','5');
        $this->db->where('K',$K);
        $this->db->where('J',$J);
        $this->db->where('O !=','');
        $this->db->where('RO','');
        $this->db->where('SRO','');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getRO($K,$J,$O)
    {
        $this->db->where('A','5');
        $this->db->where('K',$K);
        $this->db->where('J',$J);
        $this->db->where('O',$O);
        $this->db->where('RO !=','');
        $this->db->where('SRO','');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getSRO($K,$J,$O,$RO)
    {
        $this->db->where('A','5');
        $this->db->where('K',$K);
        $this->db->where('J',$J);
        $this->db->where('O',$O);
        $this->db->where('RO',$RO);
        $this->db->where('SRO !=','');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByKodering($kodering)
    {
        $this->db->where('ALL_90_M',$kodering);
        $query = $this->db->get($this->table);
        return $query->row();
    }

}

