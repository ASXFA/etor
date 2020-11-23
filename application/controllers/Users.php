<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogin')!=1) {
            redirect('Auth');
        }
        $this->id = $this->session->userdata('id');
        $this->nama = $this->session->userdata('nama');
        $this->nip = $this->session->userdata('nip');
        $this->role = $this->session->userdata('role');
        $this->content = array(
            'base_url' => base_url(),
            'id' => $this->id,
            'nama' => $this->nama,
            'nip' => $this->nip,
            'role' => $this->role
        );
        $this->load->model('model_users');
    }

	public function listUsers()
	{
		$this->twig->display('users/listUsers.html',$this->content);
    }

    public function userLists()
    {
        $list = $this->model_users->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            $sub_data = array();
            $sub_data[] = $no;
            $sub_data[] = $row->nip;
            $sub_data[] = $row->nama;
            $sub_data[] = $row->role;
            $sub_data[] = $row->status;
            $sub_data[] = $row->created_by;
            $sub_data[] = "<button type='button' name='edit' class='btn btn-danger btn-sm' id='".$row->id."'> Edit </button>";
            $data[] = $sub_data;
        $no++;
        endforeach;

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_users->get_all_data(),
            'recordsFiltered' => $this->model_users->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
        // $list = $this->model_users->getAll()->result();
        // echo json_encode($list);
    }
    
    public function addUsers()
    {
        $data = array(
            'nip' => $this->input->post('nip'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'password' => password_hash($this->input->post('password'),PASSWORD_BCRYPT),
            'role' => $this->input->post('role'),
            'status' => 0,
            'created_by' => $this->nama
        );
        $proccess = $this->model_users->tambahUsers($data);
        return $proccess;
    }

    public function usersEdit()
    {
        $id = $this->input->post('id');
        $proccess = $this->model_users->getById($id)->result();
        return json_encode($proccess);
    }

    public function editUsers()
    {
        $data = array(
            'nip' => $this->input->post('nip'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'password' => password_hash($this->input->post('password'),PASSWORD_BCRYPT),
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->nama
        );
        $proccess = $this->model_users->editUsers($data);
        return $proccess;
    }

    public function deleteUsers()
    {
        $id = $this->input->post('id');
        $proccess = $this->model_users->deleteUsers($id);
        return $proccess;
    }
}
