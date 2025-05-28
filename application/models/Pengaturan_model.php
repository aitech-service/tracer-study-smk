<?php
class Pengaturan_model extends CI_Model {

    public function get_pengaturan() {
        return $this->db->get('pengaturan')->row();
    }

    public function update_pengaturan($data) {
        return $this->db->update('pengaturan', $data, ['id' => 1]);
    }
}