<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/fpdf/fpdf.php';

class pdf extends FPDF
{
    public function __construct()
    {
        parent::__construct();
    }
}