<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/PhpSpreadsheet/Spreadsheet.php';
require_once APPPATH . 'third_party/PhpSpreadsheet/Writer/Xlsx.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel {
    public function __construct() {
        // Konstruktor
    }

    public function createSpreadsheet() {
        return new Spreadsheet();
    }

    public function createWriter($spreadsheet) {
        return new Xlsx($spreadsheet);
    }
}
