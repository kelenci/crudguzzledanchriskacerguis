<?php

class Barang_m extends CI_Model
{
    public function getBarang($id = null)
    {
        $this->db->select('*');
        $this->db->from('p_item');
        if ($id != null) {
            $this->db->where('item_id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function deletebarang($id)
    {
        $this->db->where('item_id', $id);
        $this->db->delete('p_item');
        return $this->db->affected_rows();
    }

    public function addbarang($data)
    {
        $this->db->insert('p_item', $data);
        return $this->db->affected_rows();
    }

    public function editbarang($data, $id)
    {
        $this->db->update('p_item', $data, ['item_id' => $id]);
        return $this->db->affected_rows();
    }
}
