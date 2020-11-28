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
        $this->load->model('model_role');
        $list = $this->model_users->make_datatables();
        $data = array();
        $no = 1;
        if (!empty($list)) {
            foreach($list as $row):
                $sub_data = array();
                if ($this->role == 1) {
                    if ($row->id != $this->id) {
                        $sub_data[] = $no;
                        $sub_data[] = $row->nip;
                        $sub_data[] = $row->nama;
                        $role = $this->model_role->getById($row->role)->row();
                        $sub_data[] = $role->nama;
                        if ($row->status == 1) {
                            $sub_data[] = "<span class='badge badge-success p-2'> Aktif </span>";
                        }else{
                            $sub_data[] = "<span class='badge badge-danger p-2'> Tidak Aktif </span>";
                        }
                        $sub_data[] = $row->created_by;
                        if ($row->status == 1) {
                            $sub_data[] = "<button type='button' name='changeStat' class='btn btn-danger btn-sm mr-2 status' id='".$row->id."' data-stat='0' title='ganti status tidak aktif'><i class='fa fa-times'></i></button><button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
                        }else{
                            $sub_data[] = "<button type='button' name='changeStat' class='btn btn-success btn-sm mr-2 status' id='".$row->id."' data-stat='1' title='ganti status aktif'><i class='fa fa-check'></i></button><button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
                        }
                        $data[] = $sub_data;
                    }
                }else if ($this->role == 2) {
                    if ($row->role == 3) {
                        $sub_data[] = $no;
                        $sub_data[] = $row->nip;
                        $sub_data[] = $row->nama;
                        $role = $this->model_role->getById($row->role)->row();
                        $sub_data[] = $role->nama;
                        if ($row->status == 1) {
                            $sub_data[] = "<span class='badge badge-success p-2'> Aktif </span>";
                        }else{
                            $sub_data[] = "<span class='badge badge-danger p-2'> Tidak Aktif </span>";
                        }
                        $sub_data[] = $row->created_by;
                        if ($row->status == 1) {
                            $sub_data[] = "<button type='button' name='changeStat' class='btn btn-danger btn-sm mr-2 status' id='".$row->id."' data-stat='0' title='ganti status tidak aktif'><i class='fa fa-times'></i></button><button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
                        }else{
                            $sub_data[] = "<button type='button' name='changeStat' class='btn btn-success btn-sm mr-2 status' id='".$row->id."' data-stat='1' title='ganti status aktif'><i class='fa fa-check'></i></button><button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
                        }
                        $data[] = $sub_data;
                    }
                }
            $no++;
            endforeach;
        }else{
            $data[] = "data belum ada";
        }

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

    public function doUser()
    {
        $operation = $this->input->post('operation');
        if ($operation == 'Add') {
            $data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'jabatan' => $this->input->post('jabatan'),
                'password' => password_hash($this->input->post('nip'),PASSWORD_BCRYPT),
                'role' => $this->input->post('role'),
                'status' => 0,
                'created_by' => $this->nama
            );
            $proccess = $this->model_users->tambahUsers($data);
        }else if($operation == 'Edit'){
            $id = $this->input->post('user_id');
            $data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'jabatan' => $this->input->post('jabatan'),
                'role' => $this->input->post('role'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->nama
            );
            $proccess = $this->model_users->editUsers($id,$data);
        }
        echo json_encode($proccess);
    }

    public function userById()
    {
        $id = $this->input->post('id');
        $role = $this->model_users->getById($id)->row();
        $output = array();
        $output['id'] = $role->id;
        $output['nip'] = $role->nip;
        $output['nama'] = $role->nama;
        $output['email'] = $role->email;
        $output['no_hp'] = $role->no_hp;
        $output['jabatan'] = $role->jabatan;
        $output['role'] = $role->role;
        echo json_encode($output);
    }

    

    public function changeStatusUser()
    {
        $id = $this->input->post('id');
        $data = array('status' => $this->input->post('status'));
        $process = $this->model_users->changeStatus($id,$data);
        return json_encode($process);
    }

    public function deleteUser()
    {
        $id = $this->input->post('id');
        $proccess = $this->model_users->deleteUsers($id);
        return $proccess;
    }

    public function getUserByRole()
    {
        $role = $this->input->post('role');
        $process = $this->model_users->getByRole($role);
        echo json_encode($process);
    }
}
