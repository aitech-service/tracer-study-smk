<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Alumni_model']);
        $this->load->library(['form_validation', 'session']);
    }

    private function redirect_if_logged_in() {
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            redirect($role === 'admin' ? 'admin/panel' : 'alumni/panel');
        }
    }

    public function register() {
        $this->redirect_if_logged_in();

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Register Tracer Study';
            $this->load->view('template/header', $data);
            $this->load->view('auth/register');
            $this->load->view('template/footer');
        } else {
            $email = $this->input->post('email', TRUE);
            $user_data = [
                'username' => $this->input->post('username', TRUE),
                'email'    => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role'     => 'alumni',
                'status'   => 'aktif',
            ];

            $this->User_model->insert_user($user_data);
            $id_user = $this->db->insert_id();

            $alumni_data = [
                'id_user' => $id_user,
                'email'   => $email,
            ];
            $this->Alumni_model->insert_alumni($alumni_data);

            $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
            redirect('auth/login');
        }
    }

    public function login() {
        $this->redirect_if_logged_in();

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Login Tracer Study';
            $this->load->view('template/header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/footer');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            if ($user->status === 'aktif') {
                // Set session user
                $this->session->set_userdata([
                    'id_user'   => $user->id_user,
                    'username'  => $user->username,
                    'role'      => $user->role,
                    'logged_in' => TRUE,
                ]);

                // Jika alumni, cari data alumni
                if ($user->role === 'alumni') {
                    $alumni = $this->db->get_where('alumni', ['id_user' => $user->id_user])->row();
                    if ($alumni) {
                        $this->session->set_userdata('id_alumni', $alumni->id_alumni ?? $alumni->id); // fallback ke 'id'

                        if ($alumni->is_complete !== 'yes') {
                            $this->session->set_flashdata('info', 'Lengkapi profil terlebih dahulu.');
                            redirect('alumni/profil');
                            return;
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Data alumni tidak ditemukan.');
                        redirect('auth/login');
                        return;
                    }
                }

                redirect($user->role === 'admin' ? 'admin/panel' : 'alumni/panel');
                return;
            } else {
                $this->session->set_flashdata('error', 'Akun Anda tidak aktif.');
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah.');
        }

        // Jika gagal login
        $data['title'] = 'Login Tracer Study';
        $this->load->view('template/header', $data);
        $this->load->view('auth/login');
        $this->load->view('template/footer');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
