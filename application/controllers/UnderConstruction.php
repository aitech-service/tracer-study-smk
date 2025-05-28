<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnderConstruction extends CI_Controller {

	
	public function index()
	{
		$data['title'] = 'Under Construction';

		$this->load->view('template/header', $data);
		$this->load->view('under_construction');
		$this->load->view('template/footer');
	}
}
