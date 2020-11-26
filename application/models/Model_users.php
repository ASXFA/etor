<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model {
    var $table = 'users';
    var $select_column = array('id','nip','nama','role','status','created_by');
    var $order_column = array(null,'nip','nama','role','status',null);

    function make_query()
    {
        $this->db->select($this->select_column);
        $id = $this->session->userdata('id');
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->like('nip',$_POST['search']['value']);
            $this->db->or_like('nama',$_POST['search']['value']);
            $this->db->or_like('role',$_POST['search']['value']);
            $this->db->or_like('status',$_POST['search']['value']);
        }
        $this->db->not_like('id',$id);
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
        $id = $this->session->userdata('id');
        $this->db->not_like('id',$id);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	public function getByNip($nip)
	{
        $this->db->where('nip',$nip);
        $query = $this->db->get('users');
        return $query;
    }

    
	public function getByRole($role)
	{
        $this->db->where('role',$role);
        $this->db->where('status',1);
        $query = $this->db->get('users')->result();
        return $query;
    }

    
    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('users');
        return $query;
    }

    public function getAll()
    {
        $this->db->not_like('id',$this->session->userdata('id'));
        $query = $this->db->get('users');
        return $query;
    }

    public function tambahUsers($data)
    {
        $query = $this->db->insert('users',$data);
        return $query;
    }

    public function changeStatus($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update('users',$data);
        return $query;
    }

    public function editUsers($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update('users',$data);
        return $query;
    }

    public function deleteUsers($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete('users');
        return $query;
    }
}
