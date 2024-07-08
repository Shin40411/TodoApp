<?php
class Truong_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_truong($limit, $offset)
    {
        $this->db->order_by('id_truong', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('truong');
        return $query->result_array();
    }

    public function add_truong($data)
    {
        return $this->db->insert('truong', $data);
    }

    public function update_truong($id_truong, $data)
    {
        $this->db->where('id_truong', $id_truong);
        return $this->db->update('truong', $data);
    }

    public function delete_truong($id_truong)
    {
        return $this->db->delete('truong', array('id_truong' => $id_truong));
    }

    public function get_count()
    {
        return $this->db->count_all_results('truong');
    }

    public function get_truong_by_id($id_truong)
    {
        $query = $this->db->get_where('truong', array('id_truong' => $id_truong));
        return $query->row_array();
    }

    public function get_truongbyphong($id_phong)
    {
        $this->db->where('id_truong', $id_phong);
        $query = $this->db->get('truong');
        return $query->result_array();
    }
}
