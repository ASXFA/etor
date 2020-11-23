<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogin')!=1) {
            redirect('login');
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
            $sub_data[] = "<button type='button' name='edit' class='btn btn-danger btn-sm' id='".$row->id."'> Edit </button>";
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

    public function roleForm()
    {
        $this->twig->display('formRole.html');
    }

    public function addRole()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'created_by' => $this->nama
        );
        $proccess = $this->model_role->addRole($data);
        return $proccess;
    }
}
