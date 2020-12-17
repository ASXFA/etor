<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe_Belanja extends CI_Controller {

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
        $this->load->model('model_tipe_belanja');
    }
    
	public function listTipeBelanja()
	{
		$this->load->view('role.html',$this->content);
    }
    
    public function tipeBelanjaList()
    {
        $id_kegiatan_global = $this->uri->segment('2');
        $this->load->model('model_kegiatan');
        $this->load->model('model_belanja');
        $list = $this->model_tipe_belanja->make_datatables();
        $data = array();
        $no = 1;
        foreach($list as $row):
            if ($row->id_kegiatan == $id_kegiatan_global) {
                $sub_data = array();
                $sub_data[] = $no;
                $belanja1 = $this->model_belanja->getByKodering($row->belanja1);
                $sub_data[] = $belanja1->URAIAN_90_M;
                $belanja2 = $this->model_belanja->getByKodering($row->belanja2);
                $sub_data[] = $belanja2->URAIAN_90_M;
                $belanja3 = $this->model_belanja->getByKodering($row->belanja3);
                $sub_data[] = $belanja3->URAIAN_90_M;
                $belanja4 = $this->model_belanja->getByKodering($row->belanja4);
                $sub_data[] = $belanja4->URAIAN_90_M;
                $sub_data[] = $row->tipe_anggaran;
                $sub_data[] = "Rp. ".number_format($row->jumlah_anggaran);
                $sub_data[] = $row->created_by;
                if ($this->role != 1) {
                    $sub_data[] = "<div class='btn-group'>
                        <button class='btn btn-secondary btn-sm' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'>
                        <a href='".base_url()."detailTipeBelanja/".$row->id."' name='tambahUsulan' class='dropdown-item tambahUsulan' id='".$row->id."' title='Tambah Usulan'><i class='fa fa-eye'></i> Lihat Usulan </a>
                            <a href='javascript:void(0)' name='editTipeBelanja' class='dropdown-item editTipeBelanja' id='".$row->id."' title='Edit Usulan'><i class='fa fa-edit'></i> Edit Tipe Belanja </a>
                            <a href='javascript:void(0)' name='deleteTipeBelanja' class='dropdown-item deleteTipeBelanja' id='".$row->id."' title='Delete Usulan'><i class='fa fa-trash'></i> Hapus Tipe Belanja </a>
                        </div>
                        </div>";
                }else{
                    $sub_data[] = "<div class='btn-group'>
                        <button class='btn btn-secondary btn-sm' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'>
                        <a href='".base_url()."detailTipeBelanja/".$row->id."' name='tambahUsulan' class='dropdown-item tambahUsulan' id='".$row->id."' title='Tambah Usulan'><i class='fa fa-eye'></i> Lihat Usulan </a>
                        </div>
                        </div>";
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
            $output['recordsTotal'] = $this->model_tipe_belanja->get_all_data();
            $output['recordsFiltered'] = $this->model_tipe_belanja->get_filtered_data();
        }
        $output['data'] = $data;
        echo json_encode($output);
    }

    public function doTipeBelanja()
    {
        $operation = $this->input->post('operation');
        $id_kegiatan = $this->input->post('id_kegiatan_anggaran');
        $belanja1 = $this->input->post('tipe_belanja');
        $belanja2 = $this->input->post('tipe_belanja_sub');
        $belanja3 = $this->input->post('tipe_belanja_sub_sub');
        $belanja4 = $this->input->post('tipe_belanja_sub_sub_sub');
        $tipe_anggaran = $this->input->post('tipe_anggaran');
        $judul_pengajuan = $this->input->post('judul_pengajuan');
        if ($operation == "Tambah") {
            $data = array(
                'id_kegiatan' => $id_kegiatan,
                'belanja1' => $belanja1,
                'belanja2' => $belanja2,
                'belanja3' => $belanja3,
                'belanja4' => $belanja4,
                'judul_pengajuan' => $judul_pengajuan,
                'tipe_anggaran' => $tipe_anggaran,
                'jumlah_anggaran' => 0,
                'created_by' => $this->nama
            );
            $query = $this->model_tipe_belanja->add($data);
            echo json_encode($query);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_tipe_belanja');
            $data = array(
                'id_kegiatan' => $id_kegiatan,
                'belanja1' => $belanja1,
                'belanja2' => $belanja2,
                'belanja3' => $belanja3,
                'belanja4' => $belanja4,
                'judul_pengajuan' => $judul_pengajuan,
                'tipe_anggaran' => $tipe_anggaran,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->nama
            );
            $query = $this->model_tipe_belanja->edit($id,$data);
            echo json_encode($query);
        }
    }

    public function editTipeBelanja()
    {
        $id = $this->input->post('id');
        $row = $this->model_tipe_belanja->getById($id);
        $output = array();
        $output['id_belanja'] = $row->id;
        $output['id_kegiatan'] = $row->id_kegiatan;
        $output['belanja1'] = $row->belanja1;
        $output['belanja2'] = $row->belanja2;
        $output['belanja3'] = $row->belanja3;
        $output['belanja4'] = $row->belanja4;
        $output['tipe_anggaran'] = $row->tipe_anggaran;
        $output['jumlah_anggaran'] = $row->jumlah_anggaran;
        echo json_encode($output);
    }

    public function deleteTipeBelanja()
    {
        $id = $this->input->post('id');
        $tb = $this->model_tipe_belanja->getById($id);
        $this->load->model('model_kegiatan');
        $kegiatan = $this->model_kegiatan->getById($tb->id_kegiatan)->row();
        $hitung = $kegiatan->anggaran - $tb->jumlah_anggaran;
        $data2 = array('anggaran'=>$hitung);
        $this->model_kegiatan->editKegiatan($kegiatan->id,$data2);
        $process = $this->model_tipe_belanja->delete($id);
        echo json_encode($process);
    }

    public function detailEditTipe()
    {
        $id = $this->input->post('id');
        $tipe_belanja = $this->model_tipe_belanja->getById($id);
        $output = array();
        $output['id_tipe_belanja'] = $tipe_belanja->id;
        $output['kodering1'] = $tipe_belanja->belanja1;
        $output['kodering2'] = $tipe_belanja->belanja2;
        $output['kodering3'] = $tipe_belanja->belanja3;
        $output['kodering4'] = $tipe_belanja->belanja4;
        $output['judul_pengajuan'] = $tipe_belanja->judul_pengajuan;
        $output['tipe_anggaran'] = $tipe_belanja->tipe_anggaran;
        echo json_encode($output);
    }

    public function detailTipeBelanja($id="")
    {
        if ($id=="") {
            echo "FORBIDDEN";
        }else{
            $tipe_belanja = $this->model_tipe_belanja->getById($id);
            if (empty($tipe_belanja)) {
                echo "DATA TIDAK ADA !";
            }else{
                $this->content['id_kegiatan_tipe_belanja'] = $tipe_belanja->id_kegiatan;
                $this->content['id_tipe_belanja'] = $id;
                $this->load->model('model_kegiatan');
                $kegiatan = $this->model_kegiatan->getById($tipe_belanja->id_kegiatan)->row();
                $this->content['kegiatan'] = $kegiatan->kegiatan;
                $this->content['sub_kegiatan'] = $kegiatan->sub_kegiatan;
                $this->load->model('model_belanja');
                $belanja1 = $this->model_belanja->getByKodering($tipe_belanja->belanja1);
                $this->content['kodering1'] = $belanja1->ALL_90_M;
                $this->content['belanja1'] = $belanja1->URAIAN_90_M;
                $belanja2 = $this->model_belanja->getByKodering($tipe_belanja->belanja2);
                $this->content['kodering2'] = $belanja2->ALL_90_M;
                $this->content['belanja2'] = $belanja2->URAIAN_90_M;
                $belanja3 = $this->model_belanja->getByKodering($tipe_belanja->belanja3);
                $this->content['kodering3'] = $belanja3->ALL_90_M;
                $this->content['belanja3'] = $belanja3->URAIAN_90_M;
                $belanja4 = $this->model_belanja->getByKodering($tipe_belanja->belanja4);
                $this->content['kodering4'] = $belanja4->ALL_90_M;
                $this->content['belanja4'] = $belanja4->URAIAN_90_M;
                $this->content['judul_pengajuan'] = $tipe_belanja->judul_pengajuan;
                $this->content['tipe_anggaran'] = $tipe_belanja->tipe_anggaran;
                $this->content['jumlah_anggaran'] = "Rp.".number_format($tipe_belanja->jumlah_anggaran);
                $this->twig->display('tipe_belanja/detailTipeBelanja.html',$this->content);
            }
        }
    }

    public function editAnggaranTipeBelanja()
    {
        $id_tipe_belanja = $this->input->post('id_tipe_belanja');
        $total_rincian = $this->input->post('total_rincian');
        $total_rincian_old = $this->input->post('total_rincian_old');
        $tipe_belanja = $this->model_tipe_belanja->getById($id_tipe_belanja);
        $count =0;
        $count += $tipe_belanja->jumlah_anggaran;
        $count = $count - $total_rincian_old;
        $count += $total_rincian;
        $data = array('jumlah_anggaran'=>$count);
        $query = $this->model_tipe_belanja->edit($id_tipe_belanja,$data);
        echo json_encode($query);
    }

}
