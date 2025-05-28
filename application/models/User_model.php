<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }
    public function get_by_username($username) {
 	   return $this->db->get_where('users', ['username' => $username])->row();
	}
	public function get_all_users() {
	    return $this->db->get('users')->result();
	}

	public function get_user_by_id($id) {
	    return $this->db->get_where('users', ['id_user' => $id])->row();
	}
	public function update_user($id, $data) {
	    return $this->db->where('id_user', $id)->update('users', $data);
	}

	public function delete_user($id) {
	    return $this->db->where('id_user', $id)->delete('users');
	}
}