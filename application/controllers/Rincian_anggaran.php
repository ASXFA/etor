<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rincian_anggaran extends CI_Controller {

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
        $this->load->model('model_rincian_anggaran');
    }

    public function rincianLists()
    {
        $id_tipe_belanja_global = $this->uri->segment('2');
        $this->load->model('model_rincian_anggaran_koefisien');
        $list = $this->model_rincian_anggaran->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            if ($row->id_tipe_belanja == $id_tipe_belanja_global) {
                $sub_data = array();
                $koefisien = $this->model_rincian_anggaran_koefisien->getByIdRincian($row->id);
                $sub_data[] = $no;
                $sub_data[] = $row->deskripsi;
                $koef = "";
                $count = count($koefisien);
                $nok = 1;
                foreach($koefisien as $k):
                    if ($nok == $count) {
                        $koef .= $k->jumlah.' '.$k->type;
                    }else{
                        $koef .= $k->jumlah.' '.$k->type.' x ';
                    }
                    $nok++;
                endforeach;
                $sub_data[] = $koef;
                $sub_data[] = $row->satuan;
                $sub_data[] = 'Rp.'.number_format($row->harga);
                $sub_data[] = $row->ppn.' %';
                $sub_data[] = 'Rp.'.number_format($row->jumlah_rincian);
                if ($row->telaahan == NULL) {
                    $sub_data[] = '-';
                }else{
                    $sub_data[] = "<span class='text-danger font-weight-bold'>".$row->telaahan."</span>";
                }
                if ($row->rekomendasi == NULL) {
                    $sub_data[] = '-';
                }else{
                    $sub_data[] = "<span class='text-danger font-weight-bold'>".$row->rekomendasi."</span>";
                }
                if ($row->status == 0) {
                    $sub_data[] = "<span class='badge badge-danger p-2'> Belum Disetujui</span>";
                }else{
                    $sub_data[] = "<span class='badge badge-success p-2'> Disetujui</span>";
                }
                if ($this->role == 1) {
                    if ($row->status == 0) {
                        $sub_data[] ="<div class='btn-group dropleft'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='rekomendasi' class='dropdown-item mr-2 editRekomendasi' id='".$row->id."' title='Rekomendasi'><i class='fa fa-bullhorn'></i> Beri Rekomendasi</a><a href='javascript:void(0)' name='changeStatus' class='dropdown-item mr-2 changeStatus' id='".$row->id."' data-status='1' title='Setujui'><i class='fa fa-check'></i> Disetujui</a></div></div>";
                    }else{
                        $sub_data[] ="<div class='btn-group dropleft'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='changeStatus' class='dropdown-item mr-2 changeStatus' id='".$row->id."' data-status='0' title='Belumdisetujui'><i class='fa fa-times'></i> Belum Disetujui</a></div></div>";
                    }
                }else if($this->role == 2){
                    if ($row->status == 0) {
                        $sub_data[] ="<div class='btn-group dropleft'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='telaahan' class='dropdown-item mr-2 editTelaahan' id='".$row->id."' title='Telaahan'><i class='fa fa-comments'></i> Telaah</a><a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 editRincian' id='".$row->id."' title='Edit Rincian'><i class='fa fa-edit'></i>Edit Rincian</a><a href='javascript:void(0)' name='delete' class='dropdown-item mr-2 hapusRincian' id='".$row->id."' title='Hapus Rincian'><i class='fa fa-trash'></i> Hapus Rincian</a></div></div>";
                    }else{
                        $sub_data[] ="<div class='btn-group dropleft'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' disabled>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='telaahan' class='dropdown-item mr-2 editTelaahan' id='".$row->id."' title='Telaahan'><i class='fa fa-comments'></i> Telaah</a><a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 editRincian' id='".$row->id."' title='Edit Rincian'><i class='fa fa-edit'></i>Edit Rincian</a><a href='javascript:void(0)' name='delete' class='dropdown-item mr-2 hapusRincian' id='".$row->id."' title='Hapus Rincian'><i class='fa fa-trash'></i> Hapus Rincian</a></div></div>";
                    }
                }else if($this->role == 3){
                    if ($row->status == 0) {
                        $sub_data[] ="<div class='btn-group'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 editRincian' id='".$row->id."' title='Edit Rincian'><i class='fa fa-edit'></i>Edit Rincian</a><a href='javascript:void(0)' name='delete' class='dropdown-item mr-2 hapusRincian' id='".$row->id."' title='Hapus Rincian'><i class='fa fa-trash'></i> Hapus Rincian</a> </div></div>";
                    }else{
                        $sub_data[] ="<div class='btn-group'>
                        <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' disabled>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'><a href='javascript:void(0)' name='telaahan' class='dropdown-item mr-2 editTelaahan' id='".$row->id."' title='Telaahan'><i class='fa fa-comments'></i> Telaah</a><a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 editRincian' id='".$row->id."' title='Edit Rincian'><i class='fa fa-edit'></i>Edit Rincian</a><a href='javascript:void(0)' name='delete' class='dropdown-item mr-2 hapusRincian' id='".$row->id."' title='Hapus Rincian'><i class='fa fa-trash'></i> Hapus Rincian</a></div></div>";
                    }
                }
                
                $data[] = $sub_data;
            }
            $no++;
        endforeach;     
        $output['draw'] = intval($_POST['draw']);
        if (empty($data)) {
            $output['recordsTotal'] = 0;
            $output['recordsFiltered'] = 0;
        }else{
            $output['recordsTotal'] = count($data);
            $output['recordsFiltered'] = count($data);
        }
        $output['data'] = $data;
        
        // $output = array(
        //     'draw' => intval($_POST['draw']),
        //     'recordsTotal' => $this->model_rincian_anggaran->get_all_data(),
        //     'recordsFiltered' => $this->model_rincian_anggaran->get_filtered_data(),
        //     'data' => $data
        // );
        echo json_encode($output);
    }

    public function rincianById()
    {
        $this->load->model('model_rincian_anggaran_koefisien');
        $id = $this->input->post('id');
        $rincian = $this->model_rincian_anggaran->getById($id)->row();
        $koefisien = $this->model_rincian_anggaran_koefisien->getByIdRincian($id);
        $output = array();
        $output['id_rincian'] = $rincian->id;
        $output['id_tipe_belanja_rincian'] = $rincian->id_tipe_belanja;
        $output['deskripsi'] = $rincian->deskripsi;
        $jumlah1;
        $jumlah2;
        $jumlah3;
        $jumlah4;
        $satuan1;
        $satuan2;
        $satuan3;
        $satuan4;
        $no=1;
        foreach($koefisien as $k):
            if ($no == 1) {
                $jumlah1 = $k->jumlah;
                $satuan1 = $k->type;
            }else if($no == 2){
                $jumlah2 = $k->jumlah;
                $satuan2 = $k->type;
            }else if($no == 3){
                $jumlah3 = $k->jumlah;
                $satuan3 = $k->type;
            }else{
                $jumlah4 = $k->jumlah;
                $satuan4 = $k->type;
            }
        $no++;
        endforeach;
        $output['jumlah1'] = $jumlah1;
        $output['satuan1'] = $satuan1;
        if (isset($jumlah2)) {
            $output['jumlah2'] = $jumlah2;
            $output['satuan2'] = $satuan2;
        }else if(isset($belanja3)){
            $output['jumlah3'] = $jumlah3;
            $output['satuan3'] = $satuan3;
        }else if(isset($jumlah4)){
            $output['jumlah4'] = $jumlah4;
            $output['satuan4'] = $satuan4;
        }
        $output['satuan'] = $rincian->satuan;
        $output['harga'] = $rincian->harga;
        $output['ppn'] = $rincian->ppn;
        $output['total_rincian'] = $rincian->jumlah_rincian;
        $output['telaahan'] = $rincian->telaahan;
        $output['rekomendasi'] = $rincian->rekomendasi;

        echo json_encode($output);
    }

    public function doRincian()
    {
        $this->load->model('model_rincian_anggaran_koefisien');
        $operation = $this->input->post('operation_rincian');
        $jumlah1 = $this->input->post('jumlah1');
        $jumlah2 = $this->input->post('jumlah2');
        $jumlah3 = $this->input->post('jumlah3');
        $jumlah4 = $this->input->post('jumlah4');
        $satuan1 = $this->input->post('satuan1');
        $satuan2 = $this->input->post('satuan2');
        $satuan3 = $this->input->post('satuan3');
        $satuan4 = $this->input->post('satuan4');
        if ($operation == 'Tambah') {
            $data = array(
                'id_tipe_belanja' => $this->input->post('id_tipe_belanja'),
                'deskripsi' => $this->input->post('deskripsi'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'ppn' => $this->input->post('ppn'),
                'jumlah_rincian' => $this->input->post('total'),
                'created_by' => $this->nama
            );
            $query = $this->model_rincian_anggaran->addRincian($data);
            if ($jumlah1 != 0 && $satuan1 !="") {
                $data_insert1 = array(
                    'id_rincian_anggaran' => $query,
                    'jumlah' => $jumlah1,
                    'type' => $satuan1,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert1);
            }
            if ($jumlah2 != 0 && $satuan2 !="") {
                $data_insert2 = array(
                    'id_rincian_anggaran' => $query,
                    'jumlah' => $jumlah2,
                    'type' => $satuan2,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert2);
            }
            if ($jumlah3 != 0 && $satuan3 !="") {
                $data_insert3 = array(
                    'id_rincian_anggaran' => $query,
                    'jumlah' => $jumlah3,
                    'type' => $satuan3,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert3);
            }
            if ($jumlah4 != 0 && $satuan4 !="") {
                $data_insert4 = array(
                    'id_rincian_anggaran' => $query,
                    'jumlah' => $jumlah4,
                    'type' => $satuan4,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert4);
            }
        }else if($operation == 'Edit'){
            $id = $this->input->post('id_rincian');
            $data = array(
                'id_tipe_belanja' => $this->input->post('id_tipe_belanja'),
                'deskripsi' => $this->input->post('deskripsi'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'ppn' => $this->input->post('ppn'),
                'jumlah_rincian' => $this->input->post('total'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->nama
            );
            $proccess = $this->model_rincian_anggaran->editRincian($id,$data);
            $del = $this->model_rincian_anggaran_koefisien->deleteKoefisienRincian($id);
            if ($jumlah1 != 0 && $satuan1 !="") {
                $data_insert1 = array(
                    'id_rincian_anggaran' => $id,
                    'jumlah' => $jumlah1,
                    'type' => $satuan1,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert1);
            }
            if ($jumlah2 != 0 && $satuan2 !="") {
                $data_insert2 = array(
                    'id_rincian_anggaran' => $id,
                    'jumlah' => $jumlah2,
                    'type' => $satuan2,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert2);
            }
            if ($jumlah3 != 0 && $satuan3 !="") {
                $data_insert3 = array(
                    'id_rincian_anggaran' => $id,
                    'jumlah' => $jumlah3,
                    'type' => $satuan3,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert3);
            }
            if ($jumlah4 != 0 && $satuan4 !="") {
                $data_insert4 = array(
                    'id_rincian_anggaran' => $id,
                    'jumlah' => $jumlah4,
                    'type' => $satuan4,
                );
                $proccess = $this->model_rincian_anggaran_koefisien->addKoefisien($data_insert4);
            }
        }
        echo json_encode($proccess);
    }

    public function addRekomendasiRincian()
    {
        $id_rincian = $this->input->post('id_rincian_rekomendasi');
        $data = array('rekomendasi'=>$this->input->post('rekomendasi'));
        $query = $this->model_rincian_anggaran->editRincian($id_rincian,$data);
        echo json_encode($query);
    }

    public function addTelaahanRincian()
    {
        $id_rincian = $this->input->post('id_rincian_telaahan');
        $data = array('telaahan'=>$this->input->post('telaahan'));
        $query = $this->model_rincian_anggaran->editRincian($id_rincian,$data);
        echo json_encode($query);
    }

    public function changeStatus()
    {
        $id = $this->input->post('id_rincian');
        $status = $this->input->post('status');
        $data = array('status' => $status);
        $query = $this->model_rincian_anggaran->editRincian($id,$data);
        echo json_encode($query);
    }

    public function deleteRincian()
    {
        $id = $this->input->post('id');
        $rincian = $this->model_rincian_anggaran->getById($id)->row();
        $this->load->model('model_tipe_belanja');
        $tb = $this->model_tipe_belanja->getById($rincian->id_tipe_belanja);
        $count = $tb->jumlah_anggaran - $rincian->jumlah_rincian;
        $data1 = array('jumlah_anggaran'=>$count);
        $this->model_tipe_belanja->edit($tb->id,$data1);
        $this->load->model('model_kegiatan');
        $kegiatan = $this->model_kegiatan->getById($tb->id_kegiatan)->row();
        $hitung = $kegiatan->anggaran - $rincian->jumlah_rincian;
        $data2 = array('anggaran'=>$hitung);
        $this->model_kegiatan->editKegiatan($kegiatan->id,$data2);
        $process = $this->model_rincian_anggaran->deleteRincian($id);
        echo json_encode($process);
    }

    public function getJoin()
    {
        $this->load->model('model_tipe_belanja');
        $data = $this->model_tipe_belanja->getJoin();
        echo json_encode($data);
    }
}
