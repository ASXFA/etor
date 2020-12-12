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
        // $this->load->library('encrypt');
    }

    public function semuaAnggaranKegiatan()
    {
        $this->twig->display('kegiatan/semuaAnggaranKegiatan.html',$this->content);
    }

    public function listSemuaAnggaranKegiatan()
    {
        $biro = "Biro Umum";
        $kegiatan = $this->model_kegiatan->getAll();
        $arr = array();
        $jumlahKegiatan = 0;
        $jumlah_sub_kegiatan = 0;
        $jumlahAnggaran = 0;
        foreach($kegiatan as $k):
            if (empty($arr)) {
                array_push($arr,$k->kegiatan);
                $jumlahKegiatan += 1;
                $jumlah_sub_kegiatan += 1;
                $jumlahAnggaran += $k->anggaran;
            }else if(in_array($k->kegiatan,$arr)){
                $jumlah_sub_kegiatan += 1;
                $jumlahAnggaran += $k->anggaran;
            }else{
                array_push($arr,$k->kegiatan);
                $jumlahKegiatan += 1;
                $jumlah_sub_kegiatan += 1;
                $jumlahAnggaran += $k->anggaran;
            }
        endforeach;
        $output = array();
        $output['biro'] = $biro;
        $output['jumlah_kegiatan'] = $jumlahKegiatan;
        $output['jumlah_sub_kegiatan'] = $jumlah_sub_kegiatan;
        $output['jumlah_anggaran'] = 'Rp. '.number_format($jumlahAnggaran);
        if ($this->role == 1) {
            $output['button'] = "<a href='".base_url()."listKegiatan' class='btn btn-success btn-sm text-white' title='List Kegiatan'><i class='fa fa-ellipsis-h'></i></a>";
        }else{
            
            $output['button'] = "<a href='".base_url()."kegiatanSaya' class='btn btn-success btn-sm text-white' title='List Kegiatan'><i class='fa fa-ellipsis-h'></i></a>";
        }
        echo json_encode($output);

    }

    public function formKegiatan()
    {
        $this->twig->display('kegiatan/formKegiatan.html',$this->content);
    }
    
    public function addKegiatan()
    {
        $this->load->model('model_bagian');
        $operation = $this->input->post('operation');
        $id_bagian = $this->input->post('bagian');
        $bagian = $this->model_bagian->getById($id_bagian)->row();
        if ($operation == 'Tambah') {
            $data = array(
                'biro'=>$this->input->post('biro'),
                'bagian'=>$bagian->nama_bagian,
                'sub_bagian'=>$this->input->post('sub_bagian'),
                'lokasi'=>$this->input->post('lokasi'),
                'program'=>$this->input->post('program'),
                'kegiatan'=>$this->input->post('kegiatan'),
                'sub_kegiatan'=>$this->input->post('sub_kegiatan'),
                'anggaran'=>$this->input->post('anggaran'),
                'tanggal'=>$this->input->post('tanggal_pengusulan'),
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
                'bagian'=>$bagian->nama_bagian,
                'sub_bagian'=>$this->input->post('sub_bagian'),
                'lokasi'=>$this->input->post('lokasi'),
                'program'=>$this->input->post('program'),
                'kegiatan'=>$this->input->post('kegiatan'),
                'sub_kegiatan'=>$this->input->post('sub_kegiatan'),
                'anggaran'=>$this->input->post('anggaran'),
                'tanggal'=>$this->input->post('tanggal_pengusulan'),
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

    public function detailKegiatan($id="")
    {
        if ($id == "") {
            echo "FORBIDDEN !";
        }else{
            $kegiatan = $this->model_kegiatan->getById($id)->row();
            if (empty($kegiatan)) {
                echo "Data yang anda cari tidak tersedia !";
            }else{
                $this->content['id'] = $id;
                $this->content['kegiatan'] = $kegiatan->kegiatan;
                $this->content['sub_kegiatan'] = $kegiatan->sub_kegiatan;
                $this->content['anggaran'] = "Rp. ".number_format($kegiatan->anggaran);
                if ($this->role != 3) {
                    $this->content['biro'] = $kegiatan->biro;
                    $this->load->model('model_bagian');
                    $bagian = $this->model_bagian->getById($kegiatan->bagian)->row();
                    $this->content['bagian'] = $bagian->nama_bagian;
                    $this->load->model('model_sub_bagian');
                    $sub_bagian = $this->model_sub_bagian->getById($kegiatan->sub_bagian);
                    $this->content['sub_bagian'] = $sub_bagian->nama_sub_bagian;
                    $this->content['lokasi'] = $kegiatan->lokasi;
                    $this->content['program'] = $kegiatan->program;
                    $this->content['tanggal'] = date('d F Y', strtotime($kegiatan->tanggal));
                    $this->load->model('model_users');
                    $user = $this->model_users->getById($kegiatan->nama_pengusul)->row();
                    $this->content['nama_pengusul'] = $user->nama;
                    $this->content['nip_kegiatan'] = $user->nip;
                    $user2 = $this->model_users->getById($kegiatan->nama_pemegang_kegiatan)->row();
                    if (empty($user2)) {
                        $this->content['nama_pemegang_kegiatan'] = "Belum Ada ";
                    }else{
                        $this->content['nama_pemegang_kegiatan'] = $user2->nama;
                    }
                    $this->content['latar_belakang'] = $kegiatan->latar_belakang;
                    $this->content['maksud_tujuan'] = $kegiatan->maksud_tujuan;
                    $this->content['sasaran'] = $kegiatan->sasaran;
                    $this->twig->display('kegiatan/detailKegiatan.html',$this->content);
                }else{
                    $this->twig->display('kegiatan/detailKegiatan.html',$this->content);
                }
            }
        }
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
            if ($this->input->post('page')) {
                $sub_data[] = "<div class='btn-group'>
                <button class='btn btn-success btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-list'></i>
                </button>
                <div class='dropdown-menu'>
                    <a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 printAll' id='".$row->id."'><i class='fa fa-print'></i> Export To PDF Keseluruhan</a>;
                </div>
              </div>";
            }else{
                $sub_data[] = "<div class='btn-group'>
                        <button class='btn btn-success btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fa fa-list'></i>
                        </button>
                        <div class='dropdown-menu'>
                        <a href='".base_url()."detailKegiatan/".$row->id."' name='tampilkan' class='dropdown-item mr-2 tampilkan' id='".$row->id."' title='tampilkan informasi Kegiatan'><i class='fa fa-plus-circle'></i> Tampilkan</a><a href='javascript:void(0)' name='edit' class='dropdown-item mr-2 update' id='".$row->id."'><i class='fa fa-edit'></i> Edit </a><a href='javascript:(0)' name='delete' class='dropdown-item mr-2 delete' id='".$row->id."'><i class='fa fa-trash'></i> Delete </a>;
                        </div>
                      </div>";
            }
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
                if ($row->nama_pemegang_kegiatan == NULL) {
                    $sub_data[] = "<span class='text-danger'> Belum ada </span>";
                    $sub_data[] = $row->created_by;
                    $sub_data[] = "<div class='btn-group'>
                    <button class='btn btn-secondary btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                      <i class='fa fa-list'></i>
                    </button>
                    <div class='dropdown-menu'>
                        <a href='javascript:void(0)' name='detail' class='dropdown-item detail' id='".$row->id."' title='Detail'><i class='fa fa-eye'></i> Detail </a><a href='".base_url()."detailKegiatan/".$row->id."' name='tampilkan' class='dropdown-item mr-2 tampilkan' id='".$row->id."' title='tampilkan informasi Kegiatan'><i class='fa fa-plus-circle'></i> Tampilkan</a><a href='javascript:void(0)' name='delegasi' class='dropdown-item mr-2 delegasi' id='".$row->id."' title='Delegasi'><i class='fa fa-user'></i> Delegasi</a>
                    </div>
                  </div>";
                }else{
                    $user2 = $this->model_users->getById($row->nama_pemegang_kegiatan)->row();
                    $sub_data[] = $user2->nama;
                    $sub_data[] = $row->created_by;
                    $sub_data[] = "<div class='btn-group'>
                    <button class='btn btn-success btn-sm text-white' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-list'></i>
                    </button>
                    <div class='dropdown-menu'>
                        <a href='javascript:void(0)' name='detail' class='dropdown-item detail' id='".$row->id."' title='Detail'><i class='fa fa-eye'></i> Detail </a><a href='".base_url()."detailKegiatan/".$row->id."' name='tampilkan' class='dropdown-item mr-2 tampilkan' id='".$row->id."' title='tampilkan informasi Kegiatan'><i class='fa fa-plus-circle'></i> Tampilkan</a><a href='javascript:void(0)' name='delegasi' class='dropdown-item mr-2 delegasi' id='".$row->id."' title='Delegasi'><i class='fa fa-user'></i> Delegasi</a>
                    </div>
                  </div>";
                }
                $data[] = $sub_data;
                $no++;
            }else if($row->nama_pemegang_kegiatan == $this->id){
                $user = $this->model_users->getById($row->nama_pengusul)->row();
                $sub_data = array();
                $sub_data[] = $no;
                $sub_data[] = $row->kegiatan;
                $sub_data[] = $row->sub_kegiatan;
                $sub_data[] = "Rp.".number_format($row->anggaran);
                // if (!empty($user)) {
                //     $sub_data[] = $user->nama;
                // }else{
                //     $sub_data[] = "<span class='text-danger'> USER SUDAH DI HAPUS ! </span>";
                // }
                // $user2 = $this->model_users->getById($row->nama_pemegang_kegiatan)->row();
                // $sub_data[] = $user2->nama;
                $sub_data[] = $row->created_by;
                $sub_data[] = "<a href='".base_url()."detailKegiatan/".$row->id."' name='tampilkan' class='btn btn-success btn-sm text-white' id='".$row->id."' title='tampilkan informasi Kegiatan'><i class='fa fa-poll-h'></i></a>";
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
        $this->load->model('model_bagian');
        $bagian = $this->model_bagian->getById($role->bagian)->row();
        $output['bagian'] = $bagian->nama_bagian;
        $this->load->model('model_sub_bagian');
        $sub_bagian = $this->model_sub_bagian->getById($role->sub_bagian);
        $output['sub_bagian'] = $sub_bagian->nama_sub_bagian;
        $output['lokasi'] = $role->lokasi;
        $output['program'] = $role->program;
        $output['kegiatan'] = $role->kegiatan;
        $output['sub_kegiatan'] = $role->sub_kegiatan;
        $this->load->model('model_users');
        $user = $this->model_users->getById($role->nama_pengusul)->row();
        if ($this->input->post('type')){
            $output['anggaran'] = $role->anggaran;
            $output['tanggal'] = $role->tanggal;
            if (!empty($user)) {
                $output['nama_pengusul'] = $user->id;
            }else{
                $output['nama_pengusul'] = "User telah dihapus !";
            }
        }else{
            $output['anggaran'] = "Rp. ".number_format($role->anggaran);
            $output['tanggal'] = date('d F Y', strtotime($role->tanggal));
            if (!empty($user)) {
                $output['nama_pengusul'] = $user->nama;
            }else{
                $output['nama_pengusul'] = "User telah dihapus !";
            }
        }
        $output['nip'] = $role->nip;
        if ($role->nama_pemegang_kegiatan == NULL) {
            $output['nama_pemegang_kegiatan'] = "";
        }else{
            $user2 = $this->model_users->getById($role->nama_pemegang_kegiatan)->row();
            $output['nama_pemegang_kegiatan'] = $user2->nama;
        }
        $output['latar_belakang'] = $role->latar_belakang;
        $output['maksud_tujuan'] = $role->maksud_tujuan;
        $output['sasaran'] = $role->sasaran;
        echo json_encode($output);
    }

    public function editAnggaranKegiatan()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $total_rincian = $this->input->post('total_rincian');
        $total_rincian_old = $this->input->post('total_rincian_old');
        $kegiatan = $this->model_kegiatan->getById($id_kegiatan)->row();
        $jumlah_anggaran = $kegiatan->anggaran;
        $count = $jumlah_anggaran - (int)$total_rincian_old;
        $total = $count + $total_rincian;
        $data = array('anggaran'=>$total);
        $query = $this->model_kegiatan->editKegiatan($id_kegiatan,$data);
        echo json_encode($query);
    }

    public function doPemegangKegiatan()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $data = array('nama_pemegang_kegiatan'=>$this->input->post('nama_pemegang_kegiatan'));
        $query = $this->model_kegiatan->editKegiatan($id_kegiatan,$data);
        echo json_encode($query);
    }

    public function deleteKegiatan()
    {
        $id = $this->input->post('id');
        $process = $this->model_kegiatan->deleteKegiatan($id);
        echo json_encode($process);
    }

    public function listPrintKegiatan()
    {
        $this->twig->display('report/printAll.html',$this->content);
    }

    public function printKegiatan()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $kegiatan = $this->model_kegiatan->getById($id_kegiatan)->row();
        $this->load->model('model_bagian');
        $bagian = $this->model_bagian->getById($kegiatan->bagian)->row();
        $this->load->model('model_sub_bagian');
        $sub_bagian = $this->model_sub_bagian->getById($kegiatan->sub_bagian);
        $this->content['id_kegiatan'] = $kegiatan->id;
        $this->content['biro'] = $kegiatan->biro;
        $this->content['bagian'] = $bagian->nama_bagian;
        $this->content['sub_bagian'] = $sub_bagian->nama_sub_bagian;
        $this->content['kegiatan'] = $kegiatan->kegiatan;
        $this->content['sub_kegiatan'] = $kegiatan->sub_kegiatan;
        $this->content['sasaran'] = $kegiatan->sasaran;
        $this->content['lokasi'] = $kegiatan->lokasi;
        $this->content['program'] = $kegiatan->program;
        $this->content['anggaran'] = "Rp.".number_format($kegiatan->anggaran);
        $this->load->model('model_indikator_kegiatan');
        $indikatorList = $this->model_indikator_kegiatan->getByKegiatanArr($kegiatan->id);
        $this->content['indikator'] = $indikatorList;
        $this->load->model('model_belanja');
        $this->load->model('model_tipe_belanja');
        $this->load->model('model_rincian_anggaran');
        $this->load->model('model_rincian_anggaran_koefisien');
        $tipe_belanja = $this->model_tipe_belanja->getByKegiatanId($kegiatan->id);
        $rincian_anggaran = $this->model_rincian_anggaran->getAllArr();
        $koefisien = $this->model_rincian_anggaran_koefisien->getAllArr();
        $kode1 = array();
        $kode2 = array();
        $kode3 = array();
        $kode4 = array();
        $jp = array();
        $belanja1 = array();
        $belanja2 = array();
        $belanja3 = array();
        $belanja4 = array();
        $judul = array();
        foreach($tipe_belanja as $tp):
            if (empty($kode1) && empty($kode2) && empty($kode3) && empty($kode4)) {
                
                array_push($kode1, $tp->belanja1);
                $uraian1 = $this->model_belanja->getBykodering($tp->belanja1);
                $where1 = array('belanja1'=>$uraian1->ALL_90_M);
                $total1 = $this->model_tipe_belanja->getTotal($where1)->row();
                $data1 = array(
                    'id' => $tp->id,
                    'kodering'=>$uraian1->ALL_90_M,
                    'uraian'=>$uraian1->URAIAN_90_M,
                    'total' => $total1->TOTAL
                );
                array_push($belanja1,$data1);
                
                array_push($jp,$tp->judul_pengajuan);
                $arrjudul = array(
                    'id'=>$tp->id,
                    'judul'=>$tp->judul_pengajuan,
                    'tipe'=>$tp->tipe_anggaran,
                    'total' => $tp->jumlah_anggaran
                );
                array_push($judul,$arrjudul);

                array_push($kode2, $tp->belanja2);
                $uraian2 = $this->model_belanja->getBykodering($tp->belanja2);
                $where2 = array('belanja1'=>$tp->belanja1,'belanja2'=>$uraian2->ALL_90_M);
                $total2 = $this->model_tipe_belanja->getTotal($where2)->row();
                $data2 = array(
                    'id' => $tp->id,
                    'kodering'=>$uraian2->ALL_90_M,
                    'uraian'=>$uraian2->URAIAN_90_M,
                    'total' => $total2->TOTAL
                );
                array_push($belanja2,$data2);

                array_push($kode3, $tp->belanja3);
                $uraian3 = $this->model_belanja->getBykodering($tp->belanja3);
                $where3 = array('belanja1'=>$uraian1->ALL_90_M,'belanja2'=>$uraian2->ALL_90_M,'belanja3'=>$uraian3->ALL_90_M);
                $total3 = $this->model_tipe_belanja->getTotal($where3)->row();
                $data3 = array(
                    'id' => $tp->id,
                    'kodering'=>$uraian3->ALL_90_M,
                    'uraian'=>$uraian3->URAIAN_90_M,
                    'total' => $total3->TOTAL
                );
                array_push($belanja3,$data3);
                array_push($kode4, $tp->belanja4);
                $uraian4 = $this->model_belanja->getBykodering($tp->belanja4);
                $data4 = array(
                    'id' => $tp->id,
                    'kodering'=>$uraian4->ALL_90_M,
                    'uraian'=>$uraian4->URAIAN_90_M,
                    'total' =>$tp->jumlah_anggaran,
                );
                array_push($belanja4,$data4);
            }else{
                array_push($jp,$tp->judul_pengajuan);
                $arrjudul = array(
                    'id'=>$tp->id,
                    'judul'=>$tp->judul_pengajuan,
                    'tipe'=>$tp->tipe_anggaran,
                    'total'=>$tp->jumlah_anggaran
                );
                array_push($judul,$arrjudul);
                if (!in_array($tp->belanja1,$kode1)) {
                    array_push($kode1,$tp->belanja1);
                    $uraian1 = $this->model_belanja->getBykodering($tp->belanja1);
                    $where1 = array('belanja1'=>$tp->belanja1);
                    $total1 = $this->model_tipe_belanja->getTotal($where1)->row();
                    $data1 = array(
                        'id' => $tp->id,
                        'kodering'=>$uraian1->ALL_90_M,
                        'uraian'=>$uraian1->URAIAN_90_M,
                        'total'=>$total1->TOTAL
                    );
                    array_push($belanja1,$data1);
                }
                if (!in_array($tp->belanja2,$kode2)) {
                    array_push($kode2,$tp->belanja2);
                    $uraian2 = $this->model_belanja->getBykodering($tp->belanja2);
                    $where2 = array('belanja1'=>$tp->belanja1,'belanja2'=>$tp->belanja2);
                    $total2 = $this->model_tipe_belanja->getTotal($where2)->row();
                    $data2 = array(
                        'id' => $tp->id,
                        'kodering'=>$uraian2->ALL_90_M,
                        'uraian'=>$uraian2->URAIAN_90_M,
                        'total'=>$total2->TOTAL
                    );
                    array_push($belanja2,$data2);
                }
                if (!in_array($tp->belanja3,$kode3)) {
                    array_push($kode3,$tp->belanja3);
                    $uraian3 = $this->model_belanja->getBykodering($tp->belanja3);
                    $where3 = array('belanja1'=>$tp->belanja1,'belanja2'=>$tp->belanja2,'belanja3'=>$tp->belanja3);
                    $total3 = $this->model_tipe_belanja->getTotal($where3)->row();
                    $data3 = array(
                        'id' => $tp->id,
                        'kodering'=>$uraian3->ALL_90_M,
                        'uraian'=>$uraian3->URAIAN_90_M,
                        'total'=>$total3->TOTAL
                    );
                    array_push($belanja3,$data3);
                }
                if (!in_array($tp->belanja4,$kode4)) {
                    array_push($kode4,$tp->belanja4);
                    $uraian4 = $this->model_belanja->getBykodering($tp->belanja4);
                    $data4 = array(
                        'id' => $tp->id,
                        'kodering'=>$uraian4->ALL_90_M,
                        'uraian'=>$uraian4->URAIAN_90_M,
                        'total'=>$tp->jumlah_anggaran
                    );
                    array_push($belanja4,$data4);
                }
            }
        endforeach;
        $this->content['belanja1'] = $belanja1;
        $this->content['belanja2'] = $belanja2;
        $this->content['belanja3'] = $belanja3;
        $this->content['belanja4'] = $belanja4;
        $this->content['rincian'] = $rincian_anggaran;
        $this->content['koefisien'] = $koefisien;
        $this->content['judul'] = $judul;
        $twig = new \Twig\Environment();
        $twig->addGlobal('indikator',$indikatorList);
        $twig->addGlobal('belanja1',$belanja1);
        $twig->addGlobal('belanja2',$belanja2);
        $twig->addGlobal('belanja3',$belanja3);
        $twig->addGlobal('belanja4',$belanja4);
        $twig->addGlobal('tipe_belanja',$tipe_belanja);
        $twig->addGlobal('rincian',$rincian_anggaran);
        $twig->addGlobal('koefisien',$koefisien);
        $mpdf = new \Mpdf\Mpdf();
		$data = $this->load->view('printKegiatan',$this->content,TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output('laporan.pdf','I');
        // $this->twig->display('printKegiatan.html',$this->content);
    }
}
