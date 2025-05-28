<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TracerSurvey extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Pertanyaan_model', 'Jawaban_model']);
        $this->load->library('session');
        // Pastikan user login sebagai alumni (buat fungsi helper is_alumni() di helpers)
        is_alumni();
    }

    public function index()
    {
        $id_alumni = $this->session->userdata('id_alumni');

        $data['pertanyaan'] = $this->Pertanyaan_model->get_all_ordered();
        $data['jawaban_terisi'] = $this->Jawaban_model->get_by_alumni($id_alumni);

        $data['title'] = 'Isi Survey Tracer Study';
        $data['pertanyaan'] = $this->Pertanyaan_model->get_all_ordered();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_alumni');
        $this->load->view('tracer_survey/form', $data);
        $this->load->view('template/footer');
    }

    public function submit()
    {
        $id_alumni = $this->session->userdata('id_alumni');

        if (!$id_alumni) {
            $this->session->set_flashdata('error', 'Session alumni tidak ditemukan.');
            redirect('tracerSurvey');
            return;
        }

        $pertanyaan = $this->input->post('pertanyaan');
        if (!$pertanyaan) {
            $this->session->set_flashdata('error', 'Form tidak valid.');
            redirect('tracerSurvey');
            return;
        }

        foreach ($pertanyaan as $id => $jawaban) {
            $jawaban_text = is_array($jawaban) ? implode(',', $jawaban) : $jawaban;

            // Simpan atau update jawaban melalui model
            $this->Jawaban_model->simpan_atau_update($id_alumni, $id, $jawaban_text);
        }

        $this->session->set_flashdata('success', 'Survey berhasil dikirim.');
        redirect('tracerSurvey');
    }
}
    