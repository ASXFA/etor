<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Belanja extends CI_Controller {

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
        $this->nama_role = $this->session->userdata('nama_role');
        $this->content = array(
            'base_url' => base_url(),
            'nama' => $this->nama,
            'nip' => $this->nip,
            'role' => $this->role,
            'nama_role' => $this->nama_role,
        );
        $this->load->model('model_belanja');
    }

	// public function listRole()
	// {
	// 	$this->load->view('role.html',$this->content);
    // }
    
    // public function roleLists()
    // {
    //     $this->load->model('model_users');
    //     $list = $this->model_role->make_datatables();
    //     $data = array();
    //     $no = 1;
    //     foreach($list as $row):
    //         $sub_data = array();
    //         $sub_data[] = $no;
    //         $sub_data[] = $row->nama_role;
    //         $sub_data[] = $row->created_by;
    //         if ($row->id > 3) {
    //             $sub_data[] = "<button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
    //         }else{
    //             $sub_data[] = "<button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button>";  
    //         }
    //         $data[] = $sub_data;
    //     $no++;
    //     endforeach;     

    //     $output = array(
    //         'draw' => intval($_POST['draw']),
    //         'recordsTotal' => $this->model_role->get_all_data(),
    //         'recordsFiltered' => $this->model_role->get_filtered_data(),
    //         'data' => $data
    //     );
    //     echo json_encode($output);
    // }

    // public function roleById()
    // {
    //     $id = $this->input->post('id');
    //     $role = $this->model_role->getById($id)->row();
    //     $output = array();
    //     $output['id'] = $role->id;
    //     $output['nama'] = $role->nama_role;
    //     echo json_encode($output);
    // }


    public function getK()
    {
        $getK = $this->model_belanja->getK();
        echo json_encode($getK);
    }
    public function getJ()
    {
        $K = $this->input->post('K');
        $getJ = $this->model_belanja->getJ($K);
        echo json_encode($getJ);
    }

    public function getO()
    {
        $K = $this->input->post('K');
        $J = $this->input->post('J');
        $getO = $this->model_belanja->getO($K,$J);
        echo json_encode($getO);
    }

    public function getRO()
    {
        $K = $this->input->post('K');
        $J = $this->input->post('J');
        $O = $this->input->post('O');
        $getRO = $this->model_belanja->getRO($K,$J,$O);
        echo json_encode($getRO);
    }

    public function getSRO()
    {
        $K = $this->input->post('K');
        $J = $this->input->post('J');
        $O = $this->input->post('O');
        $RO = $this->input->post('RO');
        $getSRO = $this->model_belanja->getSRO($K,$J,$O,$RO);
        echo json_encode($getSRO);
    }
    

    // public function doRole()
    // {
    //     $operation = $this->input->post('operation');
    //     if ($operation == 'Add') {
    //         $data = array(
    //             'nama_role' => $this->input->post('nama'),
    //             'created_by' => $this->nama
    //         );
    //         $proccess = $this->model_role->addRole($data);
    //     }else if($operation == 'Edit'){
    //         $id = $this->input->post('role_id');
    //         $data = array(
    //             'nama_role' => $this->input->post('nama'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'updated_by' => $this->nama
    //         );
    //         $proccess = $this->model_role->editRole($id,$data);
    //     }
    //     echo json_encode($proccess);
    // }

    // public function deleteRole()
    // {
    //     $id = $this->input->post('id');
    //     $process = $this->model_role->deleteRole($id);
    //     echo json_encode($process);
    // }
}
