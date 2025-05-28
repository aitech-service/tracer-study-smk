<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'upload']);
        is_admin(); // hanya admin
        $this->load->model('Perusahaan_model');

    }

    public function index()
    {
        $data['title'] = 'Data Perusahaan';
        $data['perusahaan'] = $this->db->get('perusahaan')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('perusahaan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'email' => $this->input->post('email'),
            'no_telepon' => $this->input->post('no_telepon'),
            'website' => $this->input->post('website')
        ];

        // Upload logo jika ada
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path'] = './uploads/logo_perusahaan/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time();
            $this->upload->initialize($config);
            if ($this->upload->do_upload('logo')) {
                $upload_data = $this->upload->data();
                $data['logo'] = $upload_data['file_name'];
            }
        }

        $id = $this->input->post('id');

        if ($id) {
            // Update
            $this->db->where('id', $id)->update('perusahaan', $data);
            $this->session->set_flashdata('success', 'Data perusahaan berhasil diperbarui.');
        } else {
            // Insert
            $this->db->insert('perusahaan', $data);
            $this->session->set_flashdata('success', 'Data perusahaan berhasil ditambahkan.');
        }

        redirect('perusahaan');
    }

    public function delete($id = null)
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Metode tidak diizinkan', 405);
        }

        if (!$id) {
            show_404();
        }

        $perusahaan = $this->Perusahaan_model->get_by_id($id);
        if (!$perusahaan) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('perusahaan');
        }

        // Hapus logo jika ada
        if ($perusahaan->logo && file_exists(FCPATH . 'uploads/logo_perusahaan/' . $perusahaan->logo)) {
            unlink(FCPATH . 'uploads/logo_perusahaan/' . $perusahaan->logo);
        }

        $this->Perusahaan_model->delete($id);
        $this->session->set_flashdata('success', 'Data perusahaan berhasil dihapus.');
        redirect('perusahaan');
    }

}
