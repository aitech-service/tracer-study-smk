<?php
class Jawaban_model extends CI_Model
{
    public function insert($data)
    {
        return $this->db->insert('tracer_jawaban', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('tracer_jawaban', $data);
    }

    public function sudah_mengisi($id_alumni)
    {
        return $this->db->get_where('tracer_jawaban', ['id_alumni' => $id_alumni])->num_rows() > 0;
    }

    public function get_by_alumni($id_alumni)
    {
        return $this->db->get_where('tracer_jawaban', ['id_alumni' => $id_alumni])->result();
    }

    // Ambil jawaban berdasarkan id_alumni dan pertanyaan_id
    public function get_by_alumni_and_pertanyaan($id_alumni, $pertanyaan_id)
    {
        return $this->db->get_where('tracer_jawaban', [
            'id_alumni' => $id_alumni,
            'pertanyaan_id' => $pertanyaan_id
        ])->row();
    }

    // Simpan baru atau update jika jawaban sudah ada
    public function simpan_atau_update($id_alumni, $pertanyaan_id, $jawaban)
    {
        $existing = $this->get_by_alumni_and_pertanyaan($id_alumni, $pertanyaan_id);

        $data = [
            'id_alumni' => $id_alumni,
            'pertanyaan_id' => $pertanyaan_id,
            'jawaban' => $jawaban,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            // Update data lama
            $this->update($existing->id, $data);
        } else {
            // Insert data baru
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->insert($data);
        }
    }
    public function get_all_jawaban()
       {
        $this->db->select('
            tracer_jawaban.*,
            alumni.nama AS nama_alumni,
            tracer_pertanyaan.pertanyaan,
            tracer_pertanyaan.tipe
        ');
        $this->db->from('tracer_jawaban');
        $this->db->join('alumni', 'alumni.id_alumni = tracer_jawaban.id_alumni', 'left');
        $this->db->join('tracer_pertanyaan', 'tracer_pertanyaan.id = tracer_jawaban.pertanyaan_id', 'left');
        $this->db->order_by('alumni.nama, tracer_pertanyaan.urutan');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_jawaban_grouped_by_alumni()
    {
        $this->db->select('
            tracer_jawaban.*,
            tracer_pertanyaan.pertanyaan,
            tracer_pertanyaan.tipe,
            alumni.id_alumni AS id_alumni
        ');
        $this->db->from('tracer_jawaban');
        $this->db->join('tracer_pertanyaan', 'tracer_pertanyaan.id = tracer_jawaban.pertanyaan_id', 'left');
        $this->db->join('alumni', 'alumni.id_alumni = tracer_jawaban.id_alumni', 'left');
        $this->db->order_by('alumni.nama, tracer_pertanyaan.urutan');
        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->id_alumni][] = $row;
        }
        return $result;
    }


}
