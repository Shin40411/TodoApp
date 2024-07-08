<?php
class Phong extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Phong_model');
        $this->load->model('Truong_model');
        $this->load->helper('url');
    }

    public function index(){
        $this->load->library('pagination');

        $config = array();
        $config['base_url'] = site_url('phong/index');
        $config['total_rows'] = $this->Phong_model->get_count();
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
        $data['truong'] = $this->Phong_model->get_truong();
        $data['phong'] = $this->Phong_model->get_phong($config['per_page'], $page);

        $truonghoc = array();
        foreach ($data['phong'] as $task) {
            $truonghoc[$task['id_truong']] = $this->Truong_model->get_truong_by_id($task['id_truong']);
        }
        $data['truonghoc'] = $truonghoc;
        $data['content_view'] = 'phong/index';
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('layout/main', $data);
    }

    public function add(){
        $data = array(
            'ten_phong' => $this->input->post('ten_phong'),
            'id_truong' => $this->input->post('id_truong', true)
        );
        $this->Phong_model->add_phong($data);
        $this->session->set_flashdata('success', 'Phòng đã được thêm thành công!');
        redirect('phong');
    }

    public function update($id_phong){
        $data = array(
            'ten_phong' => $this->input->post('ten_phong'),
            'id_truong' => $this->input->post('id_truong', true)
        );
        $this->Phong_model->update_phong($id_phong, $data);
        $this->session->set_flashdata('success', 'Phòng đã được sửa thành công!');
        redirect('phong');
    }

    public function delete($id_phong){
        // $phongbyphong = $this->phong_model->get_congviecs_by_id_loai($id_phong);
        // if ($phongbyphong){
        //     $this->session->set_flashdata('error', 'Phòng này đang được sử dụng!');
        //     redirect('phong');
        //     return;
        // }else{
            $this->Phong_model->delete_phong($id_phong);
            $this->session->set_flashdata('success', 'Phòng đã được xóa thành công!');
        // }
        redirect('phong');
    }

    public function get_by_id($id_phong) {
        $phong = $this->Phong_model->get_phong_by_id($id_phong);
        $phong['csrf_token_name'] = $this->security->get_csrf_token_name();
        $phong['csrf_token_hash'] = $this->security->get_csrf_hash();
        echo json_encode($phong);
    }
}
?>