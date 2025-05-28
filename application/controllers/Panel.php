<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

	
	public function index()
	{
		$data['title'] = 'Panel Tracer Study - SMK Muhammadiyah 3 Gresik';

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar_admin');
		$this->load->view('panel_admin');
		$this->load->view('template/footer');
	}
}
