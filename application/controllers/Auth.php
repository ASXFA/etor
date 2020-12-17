<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
  
    public function __construct()
    {
        parent::__construct();
        $this->content = array(
            'base_url' => base_url()
        );
    }

    public function index()
    {
        if ($this->session->userdata('isLogin')==1) {
            redirect('listUsers');
        }else{
            $this->twig->display('login.html',$this->content);
        }
    }

    public function action_login()
    {
        $this->load->model('model_users');
        $nip = $this->input->post('nip');
        $cek = $this->model_users->getByNip($nip);
        $pesan = array();
        if ($cek->num_rows() > 0) {
            $user = $cek->row();
            $pass = $this->input->post('pass');
            if (password_verify($pass,$user->password)) {
                if ($user->status == 1) {
                    $this->load->model('model_role');
                    $role = $this->model_role->getById($user->role)->row();
                    $session = array(
                        'isLogin' => 1,
                        'id' => $user->id,
                        'nip' => $user->nip,
                        'nama' => $user->nama,
                        'role' => $user->role,
                        'nama_role' => $role->nama_role,
                        'status' => $user->status
                    );
                    $role = $user->role;
                    $this->session->set_userdata($session);
                    if ($role == 1) {
                        // $this->session->set_flashdata('msgLogin','Halo, Selamat Datang ');
                        $pesan['condition'] = 2;
                        $pesan['pesan'] = "Login Berhasil !";
                        $pesan['url'] = 'semuaAnggaranKegiatan';
                        echo json_encode($pesan);
                    }else if($role == 2){
                        // $this->session->set_flashdata('msgLogin','Halo, Selamat Datang ');
                        $pesan['condition'] = 2;
                        $pesan['pesan'] = "Login Berhasil !";
                        $pesan['url'] = 'semuaAnggaranKegiatan';
                        echo json_encode($pesan);
                    }else if($role == 3){
                        // $this->session->set_flashdata('msgLogin','Halo, Selamat Datang ');
                        $pesan['condition'] = 2;
                        $pesan['pesan'] = "Login Berhasil !";
                        $pesan['url'] = 'semuaAnggaranKegiatan';
                        echo json_encode($pesan);
                    }
                }else{
                    $pesan['condition'] = 1;
                    $pesan['pesan'] = "Login Gagal ! Akun anda Masih dinonaktifkan !";
                    echo json_encode($pesan);
                }
            }else{
                // $this->session->set_flashdata('msgLogin','Password tidak cocok !');
                $pesan['condition'] = 1;
                $pesan['pesan'] = "Login Gagal ! Password Tidak Cocok";
                echo json_encode($pesan);
            }
        }else{
            // $this->session->set_flashdata('msgLogin','NIP Tidak terdaftar !');
            $pesan['condition'] = 0;
            $pesan['pesan'] = "Login Gagal ! NIP Tidak tersedia !";
            echo json_encode($pesan);
        }
    }

    public function logout()
    {
        $this->session->set_userdata('isLogin',0);
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
