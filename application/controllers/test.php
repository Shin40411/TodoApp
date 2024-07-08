<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    public function index() {
        $this->load->database();
        $query = $this->db->query("SELECT DATABASE() AS dbname");
        $row = $query->row();
        echo "Connected to database: " . $row->dbname;
    }
}