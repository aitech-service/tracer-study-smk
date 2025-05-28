<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni_model extends CI_Model {

    /**
     * Ambil data alumni berdasarkan ID user
     */
    public function get_by_user_id($id_user) {
        return $this->db->get_where('alumni', ['id_user' => $id_user])->row();
    }

    /**
     * Update data alumni berdasarkan ID user
     */
    public function update_by_user_id($id_user, $data) {
        return $this->db->where('id_user', $id_user)->update('alumni', $data);
    }

    /**
     * Hapus foto alumni dari direktori dan database
     */
    public function delete_foto($id_user) {
        $alumni = $this->get_by_user_id($id_user);
        if ($alumni && $alumni->foto) {
            $foto_path = './uploads/foto_alumni/' . $alumni->foto;
            if (file_exists($foto_path)) {
                unlink($foto_path);
            }

            // Update database: set kolom foto menjadi null
            return $this->update_by_user_id($id_user, ['foto' => null]);
        }

        return false;
    }

    /**
     * Insert data alumni (misalnya saat registrasi baru)
     */
    public function insert_alumni($data) {
        return $this->db->insert('alumni', $data);
    }

    /**
     * Ambil semua data alumni yang sudah melengkapi profil
     */
    public function get_all_alumni() {
        return $this->db->select('a.*, u.username, u.email')
                        ->from('alumni a')
                        ->join('users u', 'u.id_user = a.id_user')
                        ->where('a.is_complete', 'yes')
                        ->get()
                        ->result();
    }

    /**
     * Ambil detail alumni berdasarkan user ID
     */
    public function get_alumni_by_user_id($id_user) {
        return $this->db->select('a.*, u.username, u.email')
                        ->from('alumni a')
                        ->join('users u', 'u.id_user = a.id_user')
                        ->where('a.id_user', $id_user)
                        ->get()
                        ->row();
    }

    /**
     * Filter alumni berdasarkan status, angkatan, jurusan
     * Semua parameter opsional (bisa satuan)
     */
    public function filter_alumni($status = null, $angkatan = null, $jurusan = null) {
        $this->db->select('a.*, u.username, u.email');
        $this->db->from('alumni a');
        $this->db->join('users u', 'u.id_user = a.id_user');
        $this->db->where('a.is_complete', 'yes');

        if (!empty($status)) {
            $this->db->where('a.status_aktifitas', $status);
        }

        if (!empty($angkatan)) {
            $this->db->where('a.angkatan', $angkatan);
        }

        if (!empty($jurusan)) {
            $this->db->where('a.jurusan', $jurusan);
        }

        return $this->db->get()->result();
    }
    public function get_all_angkatan() {
        return $this->db->distinct()->select('angkatan')->order_by('angkatan', 'DESC')->get('alumni')->result();
    }

    public function count_status_aktifitas($angkatan = null) {
        $this->db->select('status_aktifitas, COUNT(*) as total');
        $this->db->from('alumni');
        if ($angkatan) {
            $this->db->where('angkatan', $angkatan);
        }
        $this->db->group_by('status_aktifitas');
        return $this->db->get()->result();
    }

    public function count_alumni_per_jurusan($angkatan = null)
    {
        $this->db->select('jurusan, COUNT(*) as total');
        $this->db->from('alumni');
        $this->db->where('is_complete', 'yes');

        if (!empty($angkatan)) {
            $this->db->where('angkatan', $angkatan);
        }

        $this->db->group_by('jurusan');
        return $this->db->get()->result();
    }
    public function get_all_alumni_sorted()
    {
        $this->db->select('a.nama, a.angkatan, a.jurusan, a.status_aktifitas');
        $this->db->from('alumni a');
        $this->db->order_by('a.angkatan', 'ASC');
        $this->db->order_by('a.nama', 'ASC');
        return $this->db->get()->result();
    }
    public function get_alumni_with_jawaban()
    {
        $this->db->select('alumni.*');
        $this->db->from('alumni');
        $this->db->join('tracer_jawaban', 'tracer_jawaban.id_alumni = alumni.id_alumni');
        $this->db->group_by('alumni.id_alumni');
        return $this->db->get()->result();
    }


}
