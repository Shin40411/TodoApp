<?php
class Congviec_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_congviec($limit, $offset, $search_query = null, $sort_params = array()) {
        if ($search_query) {
            $this->db->like('ten_congviec', $search_query);
        }

        if (!empty($sort_params['ngay_batdau']) && !empty($sort_params['ngay_ketthuc'])) {
            $this->db->where('ngay_batdau >=', $sort_params['ngay_batdau']);
            $this->db->where('ngay_ketthuc <=', $sort_params['ngay_ketthuc']);
        }

        if (!empty($sort_params['id_loai'])) {
            $this->db->where('id_loai', $sort_params['id_loai']);
        }

        $this->db->order_by('id_congviec','DESC');

        $this->db->limit($limit, $offset);
        $query = $this->db->get('congviec');
        return $query->result_array();
    }

    public function get_count($search_query = null, $sort_params = array()) {
        if ($search_query) {
            $this->db->like('ten_congviec', $search_query);
        }
        
        if (!empty($sort_params['ngay_batdau']) && !empty($sort_params['ngay_ketthuc'])) {
            $this->db->where('ngay_batdau >=', $sort_params['ngay_batdau']);
            $this->db->where('ngay_ketthuc <=', $sort_params['ngay_ketthuc']);
        }

        if (!empty($sort_params['id_loai'])) {
            $this->db->where('id_loai', $sort_params['id_loai']);
        }
        return $this->db->count_all_results('congviec');
    }

    public function get_congviec_by_id($id_congviec) {
        $query = $this->db->get_where('congviec', array('id_congviec' => $id_congviec));
        return $query->row_array();
    }

    public function get_congviecs_by_id_loai($id_loai){
        $query = $this->db->get_where('congviec', array('id_loai' => $id_loai));
        return $query->row_array();
    }

    public function add_congviec($congviec_data) {
        return $this->db->insert('congviec', $congviec_data);
    }

    public function delete_congviec($id_congviec) {
        $task = $this->get_congviec_by_id($id_congviec);
        if (!empty($task['file_dinhkem'])) {
            unlink('./uploads/' . $task['file_dinhkem']);
        }
        return $this->db->delete('congviec', array('id_congviec' => $id_congviec));
    }

    public function update_congviec($id_congviec, $congviec_data) {
        $this->db->where('id_congviec', $id_congviec);
        return $this->db->update('congviec', $congviec_data);
    }

    public function get_loai() {
        $query = $this->db->get('loaicongviec');
        return $query->result_array();
    }

    public function get_phong() {
        $query = $this->db->get('phong');
        return $query->result_array();
    }

    public function get_truong() {
        $query = $this->db->get('truong');
        return $query->result_array();
    }
}
?>
