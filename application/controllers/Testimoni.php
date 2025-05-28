<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimoni extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Testimoni_model');
        $this->load->model('Alumni_model');
        $this->load->library('session');
        is_logged_in(); // wajib login
    }

    // ---------------------- Untuk Alumni ----------------------
    public function index()
    {
        is_alumni(); // hanya alumni yang boleh
        $data['testimoni'] = $this->Testimoni_model->get_all();
        $data['title'] = 'Testimoni Alumni - SMK Muhammadiyah 3 Gresik';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_alumni');
        $this->load->view('testimoni/index', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        is_alumni();
        $this->load->view('testimoni/tambah');
    }

    public function simpan()
    {
        is_alumni();

        $id_user = $this->session->userdata('id_user');
        $alumni = $this->Alumni_model->get_by_user_id($id_user);

        $data = [
            'id_alumni'   => $alumni->id_alumni,
            'isi'         => $this->input->post('isi'),
            'status'      => 'pending',
            'is_complete' => 'yes',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $this->Testimoni_model->insert($data);
        $this->session->set_flashdata('success', 'Testimoni berhasil disimpan dan menunggu validasi.');
        redirect('testimoni');
    }

    public function update()
    {
        is_alumni();
        $id = $this->input->post('id');

        $data = [
            'isi'         => $this->input->post('isi'),
            'status'      => 'pending',
            'updated_at'  => date('Y-m-d H:i:s'),
            'is_complete' => 'yes'
        ];

        $this->Testimoni_model->update($id, $data);
        $this->session->set_flashdata('success', 'Testimoni berhasil diperbarui dan menunggu validasi.');
        redirect('testimoni');
    }

    public function delete($id)
    {
        is_alumni();
        $this->Testimoni_model->delete($id);
        $this->session->set_flashdata('success', 'Testimoni berhasil dihapus.');
        redirect('testimoni');
    }

    // ---------------------- Untuk Admin ----------------------
    public function admin_index()
    {
        is_admin(); // hanya admin yang boleh
        $data['testimoni'] = $this->Testimoni_model->get_all_with_alumni();
        $data['title'] = 'Validasi Testimoni Alumni';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/testimoni_validasi', $data);
        $this->load->view('template/footer');
    }

    public function update_status($id)
    {
        is_admin(); // hanya admin yang boleh

        $status = $this->input->post('status');

        $data = [
            'status'      => $status,
            'updated_at'  => date('Y-m-d H:i:s'),
            'is_complete' => ($status === 'diterima') ? 'yes' : 'no'
        ];

        $this->Testimoni_model->update($id, $data);
        $this->session->set_flashdata('success', 'Status testimoni berhasil diperbarui.');
        redirect('testimoni/admin_index');
    }
}