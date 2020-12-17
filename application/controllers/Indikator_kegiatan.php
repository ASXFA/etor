<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indikator_kegiatan extends CI_Controller {

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
        $this->load->model('model_indikator_kegiatan');
    }
    
    public function indikatorList()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $indikator_kegiatan = $this->model_indikator_kegiatan->getByKegiatan($id_kegiatan);
        echo json_encode($indikator_kegiatan);
    }


    public function doIndikator()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $indikator = $this->input->post('indikator');
        $tolak_ukur_kinerja = $this->input->post('tolak_ukur_kinerja');
        $target_kinerja = $this->input->post('target_kinerja');
        for($i=0; $i<count($indikator); $i++){
            $data = array(
                'id_kegiatan' => $id_kegiatan,
                'indikator' => $indikator[$i],
                'tolak_ukur_kinerja' => $tolak_ukur_kinerja[$i],
                'target_kinerja' => $target_kinerja[$i],
                'created_by' => $this->nama
            );
            $query = $this->model_indikator_kegiatan->addIndikator($data);
        }

        if ($query) {
            redirect('detailKegiatan/'.$id_kegiatan);
        }
    }

    public function getIndikatorById()
    {
        $id = $this->input->post('id');
        $indikator = $this->model_indikator_kegiatan->getById($id)->row();
        $output = array();
        $output['id'] = $indikator->id;
        $output['indikator'] = $indikator->indikator;
        $output['tolak_ukur_kinerja'] = $indikator->tolak_ukur_kinerja;
        $output['target_kinerja'] = $indikator->target_kinerja;
        echo json_encode($output);
    }

    public function editIndikator()
    {
        $id = $this->input->post('id_indikator');
        $indikator = $this->input->post('indikator');
        $tolak_ukur_kinerja = $this->input->post('tolak_ukur_kinerja');
        $target_kinerja = $this->input->post('target_kinerja');
        $data = array(
            'indikator' => $this->input->post('indikator'),
            'tolak_ukur_kinerja' => $this->input->post('tolak_ukur_kinerja'),
            'target_kinerja' => $this->input->post('target_kinerja'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->nama
        );
        $query = $this->model_indikator_kegiatan->editIndikator($id,$data);
        echo json_encode($query);
    }

    // public function getBagian()
    // {
    //     $bagian = $this->model_bagian->getAll();
    //     echo json_encode($bagian);
    // }

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
