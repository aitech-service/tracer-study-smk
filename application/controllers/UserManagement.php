<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserManagement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
        is_admin();
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Management User - Tracer Study';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar_admin');
        $this->load->view('admin/user/index');
        $this->load->view('template/footer');
        
    }

    public function ajax_list() {
        $users = $this->User_model->get_all_users();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                $user->username,
                $user->email,
                ucfirst($user->role),
                ucfirst($user->status),
                '
                <button class="btn btn-sm btn-warning" onclick="editUser('.$user->id_user.')"><i class="bx bx-edit"></i>Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteUser('.$user->id_user.')"><i class="bx bx-trash"></i>Hapus</button>
                '
            ];
        }

        echo json_encode(['data' => $data]);
    }

    public function ajax_add() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => false, 'errors' => validation_errors()]);
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role'     => $this->input->post('role'),
                'status'   => $this->input->post('status')
            ];
            $this->User_model->insert_user($data);
            echo json_encode(['status' => true]);
        }
    }

    public function ajax_edit($id) {
        $data = $this->User_model->get_user_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update() {
        $data = [
            'email'  => $this->input->post('email'),
            'role'   => $this->input->post('role'),
            'status' => $this->input->post('status'),
        ];
        $this->User_model->update_user($this->input->post('id_user'), $data);
        echo json_encode(['status' => true]);
    }

    public function ajax_delete($id) {
        $this->User_model->delete_user($id);
        echo json_encode(['status' => true]);
    }
}
