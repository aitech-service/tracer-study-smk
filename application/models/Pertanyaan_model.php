<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pertanyaan_model extends CI_Model
{
    private $table = 'tracer_pertanyaan';

    // Ambil semua pertanyaan diurutkan berdasarkan kolom 'urutan' ASC
    public function get_all_ordered()
    {
        return $this->db->order_by('urutan', 'asc')->get('tracer_pertanyaan')->result();
    }

    // Ambil pertanyaan berdasarkan ID (bisa untuk edit jika perlu)
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Insert pertanyaan baru
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update pertanyaan
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus pertanyaan
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
}
