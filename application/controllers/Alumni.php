<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'alumni') {
            redirect('login');
        }
        is_logged_in(); // wajib login
    	is_alumni();    // harus alumni
        $this->load->model('User_model');
        $this->load->model('Alumni_model');
    }

    public function panel() {
        $data['title'] = 'Panel Alumni Tracer Study - SMK Muhammadiyah 3 Gresik';
        
        $id_user = $this->session->userdata('id_user');

        // Ambil data alumni berdasarkan user_id
        //$alumni = $this->db->get_where('alumni', ['id_user' => $id_user])->row();
        $alumni = $this->Alumni_model->get_by_user_id($id_user);

        // Redirect ke update profil jika data belum lengkap
        if (!$alumni) {
            $this->session->set_flashdata('warning', 'Silakan lengkapi profil terlebih dahulu.');
            redirect('alumni/update_profil');
        }

        $data['alumni'] = $alumni;

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar_alumni');
		$this->load->view('panel_alumni', $data);
		$this->load->view('template/footer');
    }
    public function profil() {
        $id_user = $this->session->userdata('id_user');
        $data['alumni'] = $this->db->get_where('alumni', ['id_user' => $id_user])->row();
        $data['title'] = 'Update Profil Alumni';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_alumni');
        $this->load->view('alumni/update_profil', $data);
        $this->load->view('template/footer');
    }

    public function update_profil()
    {
        $id_user = $this->session->userdata('id_user');
        $nama_alumni = $this->input->post('nama');
        $nama_sanitized = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nama_alumni));
        $nama_sanitized = preg_replace('/_+/', '_', $nama_sanitized);

        // Konfigurasi upload
        $config['upload_path']   = './uploads/foto_alumni/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 512;
        $config['file_name']     = 'foto_' . $nama_sanitized . '_' . time();

        $this->load->library('upload', $config);

        $status = $this->input->post('status_aktifitas');

        $data = [
            'nama'             => $this->input->post('nama'),
            'nis'              => $this->input->post('nis'),
            'angkatan'         => $this->input->post('angkatan'),
            'jurusan'          => $this->input->post('jurusan'),
            'email'            => $this->input->post('email'),
            'no_hp'            => $this->input->post('no_hp'),
            'alamat'           => $this->input->post('alamat'),
            'tahun_lulus'       => $this->input->post('tahun_lulus'),
            'jenis_kelamin'    => $this->input->post('jenis_kelamin'), // Tambahan di sini
            'status_aktifitas' => $status,
            'pekerjaan'        => ($status == 'Bekerja') ? $this->input->post('pekerjaan') : null,
            'tempat_kerja'     => ($status == 'Bekerja') ? $this->input->post('tempat_kerja') : null,
            'universitas'      => ($status == 'Kuliah') ? $this->input->post('universitas') : null,
            'prodi'            => ($status == 'Kuliah') ? $this->input->post('prodi') : null,
            'nama_usaha'       => ($status == 'Wirausaha') ? $this->input->post('nama_usaha') : null,
            'jenis_usaha'      => ($status == 'Wirausaha') ? $this->input->post('jenis_usaha') : null,
        ];

        // Proses upload jika ada foto baru
        if (!empty($_FILES['foto']['name'])) {
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];

                // Hapus foto lama
                /*$alumni = $this->db->get_where('alumni', ['id_user' => $id_user])->row();
                if ($alumni && $alumni->foto && file_exists('./uploads/foto_alumni/' . $alumni->foto)) {
                    unlink('./uploads/foto_alumni/' . $alumni->foto);
                }*/
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('alumni/profil');
            }
        }

        // Update data
        //$this->db->where('id_user', $id_user)->update('alumni', $data);
        $data['is_complete'] = 'yes';
        $this->Alumni_model->update_by_user_id($id_user, $data);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('alumni/panel');
    }

    public function hapus_foto()
    {
        $id_user = $this->session->userdata('id_user');
        $alumni = $this->db->get_where('alumni', ['id_user' => $id_user])->row();

        if ($alumni && $alumni->foto) {
            $foto_path = './uploads/foto_alumni/' . $alumni->foto;
            if (file_exists($foto_path)) {
                unlink($foto_path);
            }
            $this->db->where('id_user', $id_user)->update('alumni', ['foto' => null]);
            $this->session->set_flashdata('success', 'Foto berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Foto tidak ditemukan.');
        }

        redirect('alumni/profil');
    }

}
