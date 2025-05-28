<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Import class IOFactory dari PhpSpreadsheet
        use PhpOffice\PhpSpreadsheet\IOFactory;

class Pertanyaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pertanyaan_model');
        $this->load->library('session');
        is_admin(); // Middleware untuk admin
    }

    public function index()
    {
        $data['title'] = 'Pertanyaan Survey';
        $data['pertanyaan'] = $this->Pertanyaan_model->get_all_ordered();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('pertanyaan/index', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        $data = [
            'pertanyaan' => $this->input->post('pertanyaan'),
            'tipe' => $this->input->post('tipe'),
            'pilihan' => $this->input->post('pilihan'),
            'is_required' => $this->input->post('is_required') ? 1 : 0,
            'urutan' => $this->input->post('urutan'),
        ];

        $id = $this->input->post('id');
        if ($id) {
            $this->Pertanyaan_model->update($id, $data);
            $this->session->set_flashdata('success', 'Pertanyaan berhasil diperbarui.');
        } else {
            $this->Pertanyaan_model->insert($data);
            $this->session->set_flashdata('success', 'Pertanyaan berhasil ditambahkan.');
        }

        redirect('pertanyaan');
    }

    public function delete($id)
    {
        $this->Pertanyaan_model->delete($id);
        $this->session->set_flashdata('success', 'Pertanyaan berhasil dihapus.');
        redirect('pertanyaan');
    }

    public function import()
    {
        // Load autoloader PhpSpreadsheet manual
        require_once APPPATH . 'third_party/PhpSpreadsheet/autoload.php';

        // Import class IOFactory dari PhpSpreadsheet
        //use PhpOffice\PhpSpreadsheet\IOFactory;

        $file = $_FILES['file_excel']['tmp_name'];

        if (!$file) {
            $this->session->set_flashdata('error', 'File tidak ditemukan.');
            redirect('pertanyaan');
        }

        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $data_import = [];
            $row_num = 1;
            foreach ($sheet as $row) {
                if ($row_num < 7) {
                    $row_num++;
                    continue;
                }

                $data_import[] = [
                    'pertanyaan'   => $row['A'],
                    'tipe'         => $row['B'],
                    'pilihan'      => $row['C'],
                    'is_required'  => $row['D'] == 1 ? 1 : 0,
                    'urutan'       => (int)$row['E'],
                ];
                $row_num++;
            }

            if (!empty($data_import)) {
                $this->Pertanyaan_model->insert_batch($data_import);
                $this->session->set_flashdata('success', 'Berhasil mengimpor ' . count($data_import) . ' pertanyaan.');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data yang diimpor.');
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            $this->session->set_flashdata('error', 'Gagal membaca file: ' . $e->getMessage());
        }

        redirect('pertanyaan');
    }



}
