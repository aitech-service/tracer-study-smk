<?php
class Survey_model extends CI_Model
{
    public function get_alumni($limit, $offset, $search = '')
    {
        $this->db->select('*');
        $this->db->from('alumni');

        if (!empty($search)) {
            $this->db->like('nama', $search);
        }

        $this->db->order_by('angkatan', 'ASC'); // ✅ urut dari angkatan terlama
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function count_alumni($search = '')
    {
        if ($search) {
            $this->db->like('nama', $search);
        }
        return $this->db->count_all_results('alumni');
    }

    public function get_jawaban_for_alumni_list($alumni_list)
    {
        $jawaban = [];
        $ids = array_column($alumni_list, 'id_alumni');
        if (empty($ids)) return [];

        $this->db->select('j.*, p.pertanyaan');
        $this->db->from('tracer_jawaban j');
        $this->db->join('tracer_pertanyaan p', 'p.id = j.pertanyaan_id');
        $this->db->where_in('j.id_alumni', $ids);
        $results = $this->db->get()->result();

        foreach ($results as $r) {
            $jawaban[$r->id_alumni][] = $r;
        }

        return $jawaban;
    }
}
