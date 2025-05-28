<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    public function index() {

    	$this->load->model(['Pengaturan_model', 'Testimoni_model', 'Perusahaan_model']);
	    $data['pengaturan'] = $this->Pengaturan_model->get_pengaturan();
	    $data['testimoni'] = $this->Testimoni_model->get_testimoni_diterima();
	    $data['perusahaan'] = $this->Perusahaan_model->get_all();

        $this->load->view('landing_page', $data);
    }
}
