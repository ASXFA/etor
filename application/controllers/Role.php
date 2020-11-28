<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

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
            'nama' => $this->nama,
            'nip' => $this->nip,
            'role' => $this->role
        );
        $this->load->model('model_role');
    }

	public function listRole()
	{
		$this->load->view('role.html',$this->content);
    }
    
    public function roleLists()
    {
        $list = $this->model_role->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            $sub_data = array();
            $sub_data[] = $no;
            $sub_data[] = $row->nama;
            $sub_data[] = $row->created_by;
            if ($row->id > 3) {
                $sub_data[] = "<button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
            }else{
                $sub_data[] = "<button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button>";  
            }
            $data[] = $sub_data;
        $no++;
        endforeach;     

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_role->get_all_data(),
            'recordsFiltered' => $this->model_role->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function roleById()
    {
        $id = $this->input->post('id');
        $role = $this->model_role->getById($id)->row();
        $output = array();
        $output['id'] = $role->id;
        $output['nama'] = $role->nama;
        echo json_encode($output);
    }

    public function getRole()
    {
        if ($this->role == 2) {
            $role = $this->model_role->getById(3)->result();
        }else if($this->role == 1){
            $role = $this->model_role->getAll()->result();
        }
        echo json_encode($role);
    }

    public function doRole()
    {
        $operation = $this->input->post('operation');
        if ($operation == 'Add') {
            $data = array(
                'nama' => $this->input->post('nama'),
                'created_by' => $this->nama
            );
            $proccess = $this->model_role->addRole($data);
        }else if($operation == 'Edit'){
            $id = $this->input->post('role_id');
            $data = array(
                'nama' => $this->input->post('nama'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->nama
            );
            $proccess = $this->model_role->editRole($id,$data);
        }
        echo json_encode($proccess);
    }

    public function deleteRole()
    {
        $id = $this->input->post('id');
        $process = $this->model_role->deleteRole($id);
        echo json_encode($process);
    }
}
