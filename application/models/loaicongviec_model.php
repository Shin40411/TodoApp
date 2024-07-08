<?php
class LoaiCongViec_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_categories($limit, $offset, $search_query = null) {
        $this->db->limit($limit, $offset);
        if ($search_query) {
            $this->db->like('ten_loai', $search_query);
        }
        $this->db->order_by('id_loai','DESC');
        $query = $this->db->get('loaicongviec');
        return $query->result_array();
    }

    public function get_count($search_query = null) {
        if ($search_query) {
            $this->db->like('ten_loai', $search_query);
        }
        return $this->db->count_all_results('loaicongviec');
    }

    public function add_categories($data) {
        return $this->db->insert('loaicongviec', $data);
    }

    public function delete_categories($id_loai) {
        return $this->db->delete('loaicongviec', array('id_loai' => $id_loai));
    }

    public function update_categories($id_loai, $data) {
        $this->db->where('id_loai', $id_loai);
        return $this->db->update('loaicongviec', $data);
    }

    public function get_categories_by_id($id_loai) {
        $query = $this->db->get_where('loaicongviec', array('id_loai' => $id_loai));
        return $query->row_array();
    }
}
?>
