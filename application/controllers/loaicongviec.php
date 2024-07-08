<?php
class LoaiCongViec extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('LoaiCongViec_model');
        $this->load->model('congviec_model');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index() {
        $this->load->library('pagination');
        $search_query = trim($this->input->post('search') ?: $this->input->get('search'));

        $config = array();
        $config['base_url'] = site_url('loaicongviec/index');
        $config['total_rows'] = $this->LoaiCongViec_model->get_count($search_query);
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

        $data['loaicongviec'] = $this->LoaiCongViec_model->get_categories($config['per_page'], $page, $search_query);
        $data['content_view'] = 'loaicongviec/index';
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('layout/main', $data);
    }

    public function add() {
        $data = array(
            'ten_loai' => $this->input->post('ten_loai'),
            'mota' => $this->input->post('mota')
        );
        $this->LoaiCongViec_model->add_categories($data);
        $this->session->set_flashdata('success', 'Loại công việc đã được thêm thành công!');
        redirect('loaicongviec');
    }

    public function delete($id_loai) {
        $congviecbyloai = $this->congviec_model->get_congviecs_by_id_loai($id_loai);
        if ($congviecbyloai){
            $this->session->set_flashdata('error', 'Loại công việc đang được sử dụng!');
            redirect('loaicongviec');
            return;
        }else{
            $this->LoaiCongViec_model->delete_categories($id_loai);
            $this->session->set_flashdata('success', 'Loại công việc đã được xóa thành công!');
        }
        redirect('loaicongviec');
    }

    public function edit($id_loai) {
        $data['categories'] = $this->LoaiCongViec_model->get_categories_by_id($id_loai);
        $this->load->view('loaicongviec/edit', $data);
    }

    public function update($id_loai) {
        $data = array(
            'ten_loai' => $this->input->post('ten_loai'),
            'mota' => $this->input->post('mota')
        );
        $this->LoaiCongViec_model->update_categories($id_loai, $data);
        $this->session->set_flashdata('success', 'Loại công việc đã được sửa thành công!');
        redirect('loaicongviec');
    }

    public function get_by_id($id_loai) {
        $this->load->model('LoaiCongViec_model');
        $loai_congviec = $this->LoaiCongViec_model->get_categories_by_id($id_loai);
        $loai_congviec['csrf_token_name'] = $this->security->get_csrf_token_name();
        $loai_congviec['csrf_token_hash'] = $this->security->get_csrf_hash();
        echo json_encode($loai_congviec);
    }
    
}
