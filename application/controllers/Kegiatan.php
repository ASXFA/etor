<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

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
        $this->load->model('model_kegiatan');
        $this->load->library('encrypt');
    }

    public function formKegiatan()
    {
        $this->twig->display('kegiatan/formKegiatan.html');
    }
    
    public function addKegiatan()
    {
        $operation = $this->input->post('operation');
        if ($operation == 'Tambah') {
            $data = array(
                'biro'=>$this->input->post('biro'),
                'bagian'=>$this->input->post('bagian'),
                'sub_bagian'=>$this->input->post('sub_bagian'),
                'lokasi'=>$this->input->post('lokasi'),
                'program'=>$this->input->post('program'),
                'kegiatan'=>$this->input->post('kegiatan'),
                'sub_kegiatan'=>$this->input->post('sub_kegiatan'),
                'anggaran'=>$this->input->post('anggaran'),
                'apbd_murni'=>$this->input->post('apbd_murni'),
                'apbd_perubahan'=>$this->input->post('apbd_perubahan'),
                'tanggal'=>$this->input->post('tanggal_pengisian'),
                'sifat_kegiatan'=>$this->input->post('sifat_kegiatan'),
                'nama_pengusul'=>$this->input->post('nama_pengusul'),
                'nip'=>$this->input->post('nip'),
                'latar_belakang'=>$this->input->post('latar_belakang'),
                'maksud_tujuan'=>$this->input->post('maksud_tujuan'),
                'sasaran'=>$this->input->post('sasaran'),
                'created_by'=>$this->nama
            );
            $proccess = $this->model_kegiatan->addKegiatan($data);
        }else if($operation == 'Edit'){
            $id = $this->input->post('kegiatan_id');
            $data = array(
                'biro'=>$this->input->post('biro'),
                'bagian'=>$this->input->post('bagian'),
                'sub_bagian'=>$this->input->post('sub_bagian'),
                'lokasi'=>$this->input->post('lokasi'),
                'program'=>$this->input->post('program'),
                'kegiatan'=>$this->input->post('kegiatan'),
                'sub_kegiatan'=>$this->input->post('sub_kegiatan'),
                'anggaran'=>$this->input->post('anggaran'),
                'apbd_murni'=>$this->input->post('apbd_murni'),
                'apbd_perubahan'=>$this->input->post('apbd_perubahan'),
                'tanggal'=>$this->input->post('tanggal_pengisian'),
                'sifat_kegiatan'=>$this->input->post('sifat_kegiatan'),
                'nama_pengusul'=>$this->input->post('nama_pengusul'),
                'nip'=>$this->input->post('nip'),
                'latar_belakang'=>$this->input->post('latar_belakang'),
                'maksud_tujuan'=>$this->input->post('maksud_tujuan'),
                'sasaran'=>$this->input->post('sasaran'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'updated_by'=>$this->nama
            );
            $proccess = $this->model_kegiatan->editKegiatan($id,$data);
        }
        echo json_encode($proccess);
    }

	public function listKegiatan()
	{
		$this->load->view('kegiatan/listKegiatan.html',$this->content);
    }
    
    public function kegiatanLists()
    {
        $this->load->model('model_users');
        $list = $this->model_kegiatan->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            $user = $this->model_users->getById($row->nama_pengusul)->row();
            $sub_data = array();
            $sub_data[] = $no;
            $sub_data[] = $row->kegiatan;
            $sub_data[] = $row->sub_kegiatan;
            $newTanggal = date('d F Y',strtotime($row->tanggal));
            $sub_data[] = $newTanggal;
            $sub_data[] = "Rp.".number_format($row->anggaran);
            if (!empty($user)) {
                $sub_data[] = $user->nama;
            }else{
                $sub_data[] = "<span class='text-danger'> USER SUDAH DI HAPUS ! </span>";
            }
            $sub_data[] = $row->created_by;
            $sub_data[] = "<button type='button' name='detail' class='btn btn-info btn-sm mr-2 detail' id='".$row->id."'> Detail </button><button type='button' name='edit' class='btn btn-warning btn-sm mr-2 update' id='".$row->id."'> Edit </button><button type='button' name='delete' class='btn btn-danger btn-sm delete' id='".$row->id."'> Delete </button>";
            $data[] = $sub_data;
        $no++;
        endforeach;     

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_kegiatan->get_all_data(),
            'recordsFiltered' => $this->model_kegiatan->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function kegiatanSaya()
    {
        $this->load->view('kegiatan/kegiatanSaya.html',$this->content);
    }

    public function kegiatanSayaLists()
    {
        $this->load->model('model_users');
        $list = $this->model_kegiatan->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            if ($row->nama_pengusul == $this->id) {
                $user = $this->model_users->getById($row->nama_pengusul)->row();
                $sub_data = array();
                $sub_data[] = $no;
                $sub_data[] = $row->kegiatan;
                $sub_data[] = $row->sub_kegiatan;
                $newTanggal = date('d F Y',strtotime($row->tanggal));
                $sub_data[] = $newTanggal;
                $sub_data[] = "Rp.".number_format($row->anggaran);
                if (!empty($user)) {
                    $sub_data[] = $user->nama;
                }else{
                    $sub_data[] = "<span class='text-danger'> USER SUDAH DI HAPUS ! </span>";
                }
                $sub_data[] = $row->created_by;
                $sub_data[] = "<button type='button' name='detail' class='btn btn-info btn-sm mr-2 detail' id='".$row->id."'> Detail </button>";
                $data[] = $sub_data;
                $no++;
            }
        endforeach;     

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_kegiatan->get_all_data(),
            'recordsFiltered' => $this->model_kegiatan->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function kegiatanById()
    {
        $id = $this->input->post('id');
        $role = $this->model_kegiatan->getById($id)->row();
        $output = array();
        $output['id'] = $role->id;
        $output['biro'] = $role->biro;
        $output['bagian'] = $role->bagian;
        $output['sub_bagian'] = $role->sub_bagian;
        $output['lokasi'] = $role->lokasi;
        $output['program'] = $role->program;
        $output['kegiatan'] = $role->kegiatan;
        $output['sub_kegiatan'] = $role->sub_kegiatan;
        $this->load->model('model_users');
        $user = $this->model_users->getById($role->nama_pengusul)->row();
        if ($this->input->post('type')){
            $output['anggaran'] = $role->anggaran;
            $output['apbd_murni'] = $role->apbd_murni;
            $output['apbd_perubahan'] = $role->apbd_perubahan;
            $output['tanggal'] = $role->tanggal;
            if (!empty($user)) {
                $output['nama_pengusul'] = $user->id;
            }else{
                $output['nama_pengusul'] = "User telah dihapus !";
            }
        }else{
            $output['anggaran'] = "Rp. ".number_format($role->anggaran);
            $output['apbd_murni'] = "Rp. ".number_format($role->apbd_murni);
            $output['apbd_perubahan'] = "Rp ".number_format($role->apbd_perubahan);
            $output['tanggal'] = date('d F Y', strtotime($role->tanggal));
            if (!empty($user)) {
                $output['nama_pengusul'] = $user->nama;
            }else{
                $output['nama_pengusul'] = "User telah dihapus !";
            }
        }
        $output['sifat_kegiatan'] = $role->sifat_kegiatan;
        $output['nip'] = $role->nip;
        $output['latar_belakang'] = $role->latar_belakang;
        $output['maksud_tujuan'] = $role->maksud_tujuan;
        $output['sasaran'] = $role->sasaran;
        echo json_encode($output);
    }

    // public function getRole()
    // {
    //     $role = $this->model_role->getAll();
    //     echo json_encode($role);
    // }

    // public function doRole()
    // {
    //     $operation = $this->input->post('operation');
    //     if ($operation == 'Add') {
    //         $data = array(
    //             'nama' => $this->input->post('nama'),
    //             'created_by' => $this->nama
    //         );
    //         $proccess = $this->model_role->addRole($data);
    //     }else if($operation == 'Edit'){
    //         $id = $this->input->post('role_id');
    //         $data = array(
    //             'nama' => $this->input->post('nama'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'updated_by' => $this->nama
    //         );
    //         $proccess = $this->model_role->editRole($id,$data);
    //     }
    //     echo json_encode($proccess);
    // }

    public function deleteKegiatan()
    {
        $id = $this->input->post('id');
        $process = $this->model_kegiatan->deleteKegiatan($id);
        echo json_encode($process);
    }
}
