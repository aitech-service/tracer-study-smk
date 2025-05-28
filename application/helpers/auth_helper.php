<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_logged_in() {
    $CI =& get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('login');
    }
}

function is_admin() {
    $CI =& get_instance();
    if ($CI->session->userdata('role') !== 'admin') {
        show_404(); // atau redirect('forbidden');
    }
}

function is_alumni() {
    $CI = &get_instance();
        if (!$CI->session->userdata('logged_in') || $CI->session->userdata('role') !== 'alumni') {
            redirect('login');
        }
}

function get_foto_alumni($foto)
    {
        return $foto ? base_url('uploads/foto_alumni/' . $foto) : base_url('uploads/foto_alumni/default.png');
    }
