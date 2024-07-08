<?php
class Truong extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Truong_model');
        $this->load->helper('url');
    }

    public function index(){
        $this->load->library('pagination');

        $config = array();
        $config['base_url'] = site_url('truong/index');
        $config['total_rows'] = $this->Truong_model->get_count();
        $config['per_page'] = 2;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Trước';
        $config['last_link'] = 'Sau';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['truong'] = $this->Truong_model->get_truong($config['per_page'], $page);
        $data['content_view'] = 'truong/index';
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('layout/main', $data);
    }

    public function add(){
        $data = array(
            'ten_truong' => $this->input->post('ten_truong')
        );
        $this->Truong_model->add_truong($data);
        $this->session->set_flashdata('success', 'Trường đã được thêm thành công!');
        redirect('truong');
    }

    public function update($id_truong){
        $data = array(
            'ten_truong' => $this->input->post('ten_truong')
        );
        $this->Truong_model->update_truong($id_truong, $data);
        $this->session->set_flashdata('success', 'Trường đã được sửa thành công!');
        redirect('truong');
    }

    public function delete($id_truong){
        // $truongbyphong = $this->Truong_model->get_congviecs_by_id_loai($id_truong);
        // if ($truongbyphong){
        //     $this->session->set_flashdata('error', 'Trường học này đang được sử dụng!');
        //     redirect('truong');
        //     return;
        // }else{
            $this->Truong_model->delete_truong($id_truong);
            $this->session->set_flashdata('success', 'Trường học đã được xóa thành công!');
        // }
        redirect('truong');
    }

    public function get_by_id($id_truong) {
        $truong = $this->Truong_model->get_truong_by_id($id_truong);
        $truong['csrf_token_name'] = $this->security->get_csrf_token_name();
        $truong['csrf_token_hash'] = $this->security->get_csrf_hash();
        echo json_encode($truong);
    }

}
?>