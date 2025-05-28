<?php
class SurveyAlumni extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Survey_model');
    }

    public function index()
    {
    	$data['title'] = 'Hasil Survey';
    	$this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/survey_alumni_index');
        $this->load->view('template/footer');
        
    }

    public function load_data()
    {
        $search = $this->input->get('search');
	    $limit = 10;
	    $page = (int)$this->input->get('page', true);
	    $offset = $page * $limit;

	    $data['alumni_list'] = $this->Survey_model->get_alumni($limit, $offset, $search);
	    $data['jawaban'] = $this->Survey_model->get_jawaban_for_alumni_list($data['alumni_list']);
	    $data['total'] = $this->Survey_model->count_alumni($search);
	    $data['limit'] = $limit;
	    $data['offset'] = $offset; // ✅ tambahkan ini
	    $data['page'] = $page;     // (opsional, kalau mau dipakai di view)

        $this->load->view('admin/survey_alumni_data', $data);
    }
}

?>