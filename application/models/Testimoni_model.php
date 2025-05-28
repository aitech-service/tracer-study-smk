<?php
class Testimoni_model extends CI_Model
{
    private $table = 'testimoni';

    // Untuk alumni - hanya testimoni milik dirinya
    public function get_all()
    {
        $id_user = $this->session->userdata('id_user');
        $alumni = $this->db->get_where('alumni', ['id_user' => $id_user])->row();

        if (!$alumni) return [];

        $this->db->select('testimoni.*, alumni.nama');
        $this->db->from($this->table);
        $this->db->join('alumni', 'alumni.id_alumni = testimoni.id_alumni');
        $this->db->where('testimoni.id_alumni', $alumni->id_alumni);
        return $this->db->get()->result();
    }

    // Untuk admin - semua testimoni dari semua alumni
    public function get_all_with_alumni()
    {
        $this->db->select('testimoni.*, alumni.nama');
        $this->db->from($this->table);
        $this->db->join('alumni', 'alumni.id_alumni = testimoni.id_alumni');
        $this->db->order_by('testimoni.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_alumni($id_alumni)
    {
        return $this->db->get_where($this->table, ['id_alumni' => $id_alumni])->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Optional: Ambil satu testimoni (misal untuk modal edit admin)
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    public function get_testimoni_diterima()
    {
        $this->db->select('testimoni.*, alumni.nama, alumni.foto'); // Tambahkan alumni.foto
        $this->db->from('testimoni');
        $this->db->join('alumni', 'alumni.id_alumni = testimoni.id_alumni');
        $this->db->where('testimoni.status', 'diterima');
        $this->db->order_by('testimoni.created_at', 'DESC');
        return $this->db->get()->result();
    }

}
