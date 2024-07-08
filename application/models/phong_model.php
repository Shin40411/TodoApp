<?php
class Phong_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_phong($limit, $offset){
        $this->db->order_by('id_phong','DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('phong');
        return $query->result_array();
    }

    public function add_phong($data){
        return $this->db->insert('phong', $data);
    }

    public function update_phong($id_phong, $data){
        $this->db->where('id_phong', $id_phong);
        return $this->db->update('phong', $data);
    }

    public function delete_phong($id_phong){
        return $this->db->delete('phong', array('id_phong' => $id_phong));
    }

    public function get_count() {
        return $this->db->count_all_results('phong');
    }

    public function get_phong_by_id($id_phong) {
        $query = $this->db->get_where('phong', array('id_phong' => $id_phong));
        return $query->row_array();
    }

    public function get_truong() {
        $query = $this->db->get('truong');
        return $query->result_array();
    }
}
?>
