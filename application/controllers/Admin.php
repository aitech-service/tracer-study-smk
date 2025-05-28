<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        is_logged_in(); // wajib login
    	is_admin();     // harus admin
        $this->load->library('upload');
    }

    public function panel() {
    	$this->load->model('Alumni_model');

        $data['title'] = 'Panel Admin Tracer Study - SMK Muhammadiyah 3 Gresik';

        // Ambil semua angkatan unik untuk dropdown filter
        $data['angkatan_list'] = $this->Alumni_model->get_all_angkatan();

        // Tangkap filter angkatan dari parameter GET
        $angkatan_filter = $this->input->get('angkatan');
        $data['selected_angkatan'] = $angkatan_filter;

        // Tangkap filter angkatan jurusan dari parameter GET (untuk pie chart)
        $angkatan_filter_jurusan = $this->input->get('angkatan_jurusan');
        $data['selected_angkatan_jurusan'] = $angkatan_filter_jurusan;

        // Data status aktivitas alumni (difilter)
        $status_counts = $this->Alumni_model->count_status_aktifitas($angkatan_filter);

        $labels_status = [];
        $counts_status = [];
        foreach ($status_counts as $row) {
            $labels_status[] = $row->status_aktifitas;
            $counts_status[] = (int) $row->total;
        }

        // Data alumni per jurusan (difilter jika ada angkatan jurusan)
        $jurusan_counts = $this->Alumni_model->count_alumni_per_jurusan($angkatan_filter_jurusan);

        $labels_jurusan = [];
        $counts_jurusan = [];
        foreach ($jurusan_counts as $row) {
            $labels_jurusan[] = $row->jurusan;
            $counts_jurusan[] = (int) $row->total;
        }

        // Encode ke JSON untuk Chart.js
        $data['chart_labels_status'] = json_encode($labels_status);
        $data['chart_data_status'] = json_encode($counts_status);

        $data['chart_labels_jurusan'] = json_encode($labels_jurusan);
        $data['chart_data_jurusan'] = json_encode($counts_jurusan);

        // Load view
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('panel_admin', $data);
        $this->load->view('template/footer');

    }
    public function list_alumni()
    {
        $this->load->model('Alumni_model');
        $data['title'] = 'Data Alumni';
        $data['alumni'] = $this->Alumni_model->get_all_alumni();

          // ✅ Ambil daftar angkatan unik
        $data['angkatan_list'] = $this->db
            ->distinct()
            ->select('angkatan')
            ->where('angkatan IS NOT NULL')
            ->where('angkatan !=', '')
            ->order_by('angkatan', 'DESC')
            ->get('alumni')
            ->result_array();

        // ✅ Ambil daftar jurusan unik
        $data['jurusan_list'] = $this->db
            ->distinct()
            ->select('jurusan')
            ->where('jurusan IS NOT NULL')
            ->where('jurusan !=', '')
            ->get('alumni')
            ->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/list_alumni', $data);
        $this->load->view('template/footer');
    }

    public function detail_alumni($id_user)
    {
        $this->load->model('Alumni_model');
        $data['title'] = 'Detail Alumni';
        $data['alumni'] = $this->Alumni_model->get_alumni_by_user_id($id_user);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/detail_alumni', $data);
        $this->load->view('template/footer');
    }
    
    public function pengaturan_aplikasi() {
        $this->load->model('Pengaturan_model');
        $data['title'] = 'Pengaturan Aplikasi';
        $data['pengaturan'] = $this->Pengaturan_model->get_pengaturan();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $update = [
                'nama_sekolah'    => $this->input->post('nama_sekolah'),
                'status_sekolah'  => $this->input->post('status_sekolah'),
                'alamat'          => $this->input->post('alamat'),
                'kecamatan'       => $this->input->post('kecamatan'),
                'kabupaten'       => $this->input->post('kabupaten'),
                'provinsi'        => $this->input->post('provinsi'),
            ];

            $config['upload_path']   = './uploads/logo/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 512; // Maks 512Kb
            $config['overwrite']     = true;

            $this->load->library('upload', $config);

            // Logo Sekolah
            if (!empty($_FILES['logo_sekolah']['name'])) {
                $config['file_name'] = 'logo-sekolah';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo_sekolah')) {
                    $update['logo_sekolah'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload logo sekolah: ' . $this->upload->display_errors('', ''));
                    redirect('admin/pengaturan_aplikasi');
                }
            }

            // Logo BKK
            if (!empty($_FILES['logo_bkk']['name'])) {
                $config['file_name'] = 'logo-bkk';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo_bkk')) {
                    $update['logo_bkk'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload logo BKK: ' . $this->upload->display_errors('', ''));
                    redirect('admin/pengaturan_aplikasi');
                }
            }

            $this->Pengaturan_model->update_pengaturan($update);
            $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui');
            redirect('admin/pengaturan_aplikasi');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/pengaturan_aplikasi', $data);
        $this->load->view('template/footer');
    }

    public function export_pdf()
    {
        $this->load->model('Pengaturan_model');
        $this->load->model('Alumni_model');

        $pengaturan = $this->Pengaturan_model->get_pengaturan();

        $nama_sekolah = $pengaturan->nama_sekolah ?? 'Nama Sekolah';
        $status_sekolah = $pengaturan->status_sekolah ?? '';
        $alamat = $pengaturan->alamat ?? '';
        $kecamatan = $pengaturan->kecamatan ?? '';
        $kabupaten = $pengaturan->kabupaten ?? '';
        $provinsi = $pengaturan->provinsi ?? '';
        $logo_sekolah = isset($pengaturan->logo_sekolah) ? FCPATH . 'uploads/logo/' . $pengaturan->logo_sekolah : '';
        $logo_bkk = isset($pengaturan->logo_bkk) ? FCPATH . 'uploads/logo/' . $pengaturan->logo_bkk : '';

        $this->load->library('pdf');
        $pdf = new PDF('P', 'mm', 'A4'); // Portrait

        // Fungsi untuk menghitung ukuran proporsional logo
        $getProportionalSize = function ($imagePath, $maxSize) {
            list($width, $height) = getimagesize($imagePath);
            if ($width > $height) {
                $newWidth = $maxSize;
                $newHeight = ($height / $width) * $maxSize;
            } else {
                $newHeight = $maxSize;
                $newWidth = ($width / $height) * $maxSize;
            }
            return [$newWidth, $newHeight];
        };

        // Header tabel (fungsi agar bisa dipanggil ulang saat page baru)
        $headerTable = function ($pdf) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
            $pdf->Cell(60, 8, 'Nama', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Angkatan', 1, 0, 'C', true);
            $pdf->Cell(65, 8, 'Jurusan', 1, 0, 'C', true);
            $pdf->Cell(25, 8, 'Status', 1, 1, 'C', true);
        };

        $alamat_lengkap = $alamat . ', Kec. ' . $kecamatan . ', ' . $kabupaten . ', ' . $provinsi;
        $maxLogoSize = 25;
        $maxRowsPerPage = 25;
        $rowCount = 0;
        $no = 1;

        // Pastikan fungsi ini ada di model: get_all_alumni_sorted()
        $alumni = $this->Alumni_model->get_all_alumni_sorted(); // sudah diurutkan ASC berdasarkan angkatan, nama

        $newPage = function () use (
            &$pdf,
            $logo_sekolah,
            $logo_bkk,
            $nama_sekolah,
            $alamat_lengkap,
            $status_sekolah,
            $getProportionalSize,
            $maxLogoSize,
            $headerTable
        ) {
            $pdf->AddPage();

            // Logo sekolah kiri
            if (file_exists($logo_sekolah)) {
                list($w, $h) = $getProportionalSize($logo_sekolah, $maxLogoSize);
                $pdf->Image($logo_sekolah, 10, 10, $w, $h);
            }

            // Logo BKK kanan
            if (file_exists($logo_bkk)) {
                list($w, $h) = $getProportionalSize($logo_bkk, $maxLogoSize);
                $x = 210 - 10 - $w;
                $pdf->Image($logo_bkk, $x, 10, $w, $h);
            }

            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 7, strtoupper($nama_sekolah), 0, 1, 'C');

            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 6, $alamat_lengkap, 0, 1, 'C');
            if ($status_sekolah) {
                $pdf->Cell(0, 6, 'Status Sekolah: ' . $status_sekolah, 0, 1, 'C');
            }

            // Garis pembatas ganda
            $pdf->Ln(4); // jarak sebelum garis

            // Garis atas (tipis)
            $pdf->SetLineWidth(0.2);
            $y = $pdf->GetY();
            $pdf->Line(10, $y, 200, $y);

            // Garis bawah (tebal)
            $pdf->SetLineWidth(0.8);
            $y += 1.2; // beri jarak sedikit dari garis atas
            $pdf->Line(10, $y, 200, $y);

            // Reset ke lebar garis default
            $pdf->SetLineWidth(0.2);

            $pdf->Ln(4); // jarak setelah garis bawah
            

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'DATA ALUMNI', 0, 1, 'C');

            $headerTable($pdf);
            $pdf->SetFont('Arial', '', 10);
        };

        $newPage();

        foreach ($alumni as $row) {
            if ($rowCount == $maxRowsPerPage) {
                $rowCount = 0;
                $newPage();
            }

            $pdf->Cell(10, 8, $no++, 1, 0, 'C');
            $pdf->Cell(60, 8, $row->nama, 1);
            $pdf->Cell(30, 8, $row->angkatan, 1);
            $pdf->Cell(65, 8, $row->jurusan, 1);
            $pdf->Cell(25, 8, $row->status_aktifitas, 1, 1);
            $rowCount++;
        }

        $filename = 'Data Alumni - ' . str_replace(' ', ' ', $nama_sekolah) . ' - ' . date('Y-m-d') . '-' . time() . '.pdf';
        $pdf->Output('D', $filename);
    }
    public function hasil_survey()
    {
        $this->load->model('Jawaban_model');
        $this->load->model('Alumni_model');

        // Ambil semua alumni yang sudah mengisi survey
        $alumni_list = $this->Alumni_model->get_alumni_with_jawaban();

        // Ambil jawaban semua alumni
        $jawaban_all = $this->Jawaban_model->get_all_jawaban_grouped_by_alumni();

        $data['alumni_list'] = $alumni_list;
        $data['jawaban'] = $jawaban_all;
        $data['title'] = 'Hasil Survey';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/hasil_survey', $data);
        $this->load->view('template/footer');
}


}
