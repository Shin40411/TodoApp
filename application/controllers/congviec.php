<?php
class Congviec extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Spreadsheet');
        $this->load->model('congviec_model');
        $this->load->model('loaicongviec_model');
        $this->load->model('truong_model');
        $this->load->model('phong_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('upload');
        $this->load->library("pxl");
    }

    public function index()
    {
        $this->load->library('pagination');
        $search_query = trim($this->input->post('search') ?: $this->input->get('search'));

        $sort_params = array(
            'ngay_batdau' => trim($this->input->post('ngay_batdau_sort')),
            'ngay_ketthuc' => trim($this->input->post('ngay_ketthuc_sort')),
            'id_loai' => trim($this->input->post('id_loai_sort'))
        );

        $config = array();
        $config['base_url'] = site_url('congviec/index');
        $config['total_rows'] = $this->congviec_model->get_count($search_query, $sort_params);
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

        if (!empty($sort_params)) {
            $this->session->set_userdata('sort_params', $sort_params);
        } else {
            $sort_params = $this->session->userdata('sort_params');
        }

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['congviec'] = $this->congviec_model->get_congviec($config['per_page'], $page, $search_query, $sort_params);
        $data['loai'] = $this->congviec_model->get_loai();
        $data['phong'] = $this->congviec_model->get_phong();
        $data['truong_hoc'] = $this->congviec_model->get_truong();

        $loaicongviec = array();
        $phongs = array();
        $truong = array();
        foreach ($data['congviec'] as $task) {
            $loaicongviec[$task['id_loai']] = $this->loaicongviec_model->get_categories_by_id($task['id_loai']);
            $phongs[$task['id_phong']] = $this->phong_model->get_phong_by_id($task['id_phong']);
            $truongData = $this->truong_model->get_truongbyphong($task['id_phong']);
            foreach ($truongData as $t) {
                $truong[$t['id_truong']] = $t;
            }
        }

        $data['loaicongviec'] = $loaicongviec;
        $data['phongs'] = $phongs;
        $data['truong'] = $truong;
        $data['sort_params'] = $sort_params;
        $data['content_view'] = 'congviec';
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('layout/main', $data);
    }

    public function get_truong_by_phong($id_phong)
    {
        $truong_options = $this->truong_model->get_truongbyphong($id_phong);
        echo json_encode($truong_options);
    }


    public function add()
    {
        $this->load->library('upload');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('ten_congviec', 'Tên công việc', 'required|max_length[80]');
        $this->form_validation->set_rules('chitiet_congviec', 'Chi tiết công việc', 'required|max_length[1000]');
        $this->form_validation->set_rules('ngay_batdau', 'Ngày bắt đầu', 'required');
        $this->form_validation->set_rules('ngay_ketthuc', 'Ngày kết thúc', 'required');
        $this->form_validation->set_rules('id_loai', 'Loại công việc', 'required');
        $this->form_validation->set_rules('id_phong', 'Phòng', 'required');

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'zip|jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        $file_name = '';

        if (!empty($_FILES['file_dinhkem']['name'])) {
            if ($this->upload->do_upload('file_dinhkem')) {
                $upload_data = $this->upload->data();
                $extension = pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
                $file_name = 'congviec_' . date('dmY') . '_' . rand() . '.' . $extension;
                rename($upload_data['full_path'], $config['upload_path'] . $file_name);
            } else {
                $this->session->set_flashdata('error', 'File đính kèm bị lỗi!');
                redirect('/');
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/');
            return;
        }

        $congviec_data = array(
            'ten_congviec' => $this->input->post('ten_congviec', true),
            'chitiet_congviec' => $this->input->post('chitiet_congviec', true),
            'ngay_batdau' => $this->input->post('ngay_batdau', true),
            'ngay_ketthuc' => $this->input->post('ngay_ketthuc', true),
            'id_loai' => $this->input->post('id_loai', true),
            'id_phong' => $this->input->post('id_phong', true),
            'file_dinhkem' => $file_name
        );

        $this->congviec_model->add_congviec($congviec_data);

        $this->session->set_flashdata('success', 'Công việc đã được thêm thành công!');
        redirect('/');
    }


    public function delete($id_congviec)
    {
        $old_task = $this->congviec_model->get_congviec_by_id($id_congviec);

        if ($old_task) {
            $this->congviec_model->delete_congviec($id_congviec);

            if (!empty($old_task['file_dinhkem'])) {
                unlink('./uploads/' . $old_task['file_dinhkem']);
            }
            $this->session->set_flashdata('success', 'Công việc đã được xóa thành công!');
        } else {
            $this->session->set_flashdata('error', 'Không tìm thấy công việc!');
        }

        redirect('/');
    }


    public function edit($id_congviec)
    {
        $data['congviec'] = $this->congviec_model->get_congviec_by_id($id_congviec);
        $data['loai'] = $this->congviec_model->get_loai();
        $this->load->view('congviec/edit', $data);
    }

    public function update($id_congviec)
    {
        $this->load->library('upload');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('ten_congviec', 'Tên công việc', 'required');
        $this->form_validation->set_rules('chitiet_congviec', 'Chi tiết công việc', 'required');
        $this->form_validation->set_rules('ngay_batdau', 'Ngày bắt đầu', 'required');
        $this->form_validation->set_rules('ngay_ketthuc', 'Ngày kết thúc', 'required');
        $this->form_validation->set_rules('id_loai', 'Loại công việc', 'required');
        $this->form_validation->set_rules('id_phong', 'Phòng', 'required');

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'zip|jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        $file_name = '';

        if (!empty($_FILES['file_dinhkem']['name'])) {
            if ($this->upload->do_upload('file_dinhkem')) {
                $upload_data = $this->upload->data();
                $extension = pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
                $file_name = 'congviec_' . date('dmY') . '_' . rand() . '.' . $extension;
                rename($upload_data['full_path'], $config['upload_path'] . $file_name);

                $old_task = $this->congviec_model->get_congviec_by_id($id_congviec);
                if (!empty($old_task['file_dinhkem'])) {
                    unlink('./uploads/' . $old_task['file_dinhkem']);
                }
            } else {
                $this->session->set_flashdata('error', 'File đính kèm sai định dạng!');
                redirect('/');
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/');
            return;
        }

        $congviec_data = array(
            'ten_congviec' => $this->input->post('ten_congviec', true),
            'chitiet_congviec' => $this->input->post('chitiet_congviec', true),
            'ngay_batdau' => $this->input->post('ngay_batdau', true),
            'ngay_ketthuc' => $this->input->post('ngay_ketthuc', true),
            'id_loai' => $this->input->post('id_loai', true),
            'id_phong' => $this->input->post('id_phong', true)
        );

        if ($file_name != '') {
            $congviec_data['file_dinhkem'] = $file_name;
        }

        $this->congviec_model->update_congviec($id_congviec, $congviec_data);

        $this->session->set_flashdata('success', 'Công việc đã được sửa thành công!');
        redirect('/');
    }


    public function get_by_id($id_congviec)
    {
        $this->load->model('congviec_model');
        $congviec = $this->congviec_model->get_congviec_by_id($id_congviec);
        $congviec['csrf_token_name'] = $this->security->get_csrf_token_name();
        $congviec['csrf_token_hash'] = $this->security->get_csrf_hash();
        echo json_encode($congviec);
    }

    public function import()
    {
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = 2048;

        if (!empty($_FILES['excel_file']['name'])) {
            if ($_FILES['excel_file']['size'] > $config['max_size'] * 1024) {
                $this->session->set_flashdata('error', 'File quá lớn! Kích thước tối đa là 2MB.');
                redirect('/');
                return;
            }

            $file_ext = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);
            if (!in_array($file_ext, explode('|', $config['allowed_types']))) {
                $this->session->set_flashdata('error', 'Định dạng file không hợp lệ! Chỉ chấp nhận xlsx hoặc xls.');
                redirect('/');
                return;
            }

            $tmpFile = tmpfile();
            $tmpFilePath = stream_get_meta_data($tmpFile)['uri'];
            move_uploaded_file($_FILES['excel_file']['tmp_name'], $tmpFilePath);

            try {
                $spreadsheet = PHPExcel_IOFactory::load($tmpFilePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rowData = [];

                $congviec_data = [];
                $firstRow = true;
                foreach ($sheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    if ($firstRow) {
                        $firstRow = false;
                        continue;
                    }

                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }

                    $congviec_data = array(
                        'ten_congviec' => $this->security->xss_clean($rowData[0]),
                        'chitiet_congviec' => $this->security->xss_clean($rowData[1]),
                        'ngay_batdau' => date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($rowData[2])),
                        'ngay_ketthuc' => date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($rowData[3])),
                        'id_loai' => $this->security->xss_clean($rowData[4])
                    );
                }

                $this->congviec_model->add_congviec($congviec_data);


                $this->session->set_flashdata('success', 'Import thành công!');
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Đã xảy ra lỗi trong quá trình import: ' . $e->getMessage());
            }
        }
        redirect('/');
    }

    public function export()
    {
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();

        $congviec_ids = explode(",", $this->input->post("exportValues"));

        $sheet->setCellValue('A1', 'Thứ tự');
        $sheet->setCellValue('B1', 'Tên công việc');
        $sheet->setCellValue('C1', 'Chi tiết công việc');
        $sheet->setCellValue('D1', 'Ngày bắt đầu');
        $sheet->setCellValue('E1', 'Ngày kết thúc');
        $sheet->setCellValue('F1', 'Loại công việc');

        $headerStyle = array(
            'font' => array(
                'bold' => true,
                'size' => 12,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('rgb' => 'A9A9A9'),
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => [
                    'rgb' => 'FFFF00',
                ],
            )
        );

        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);

        $row = 2;

        try {
            foreach ($congviec_ids as $congviec_id) {
                $task = $this->congviec_model->get_congviec_by_id($congviec_id);

                $sheet->setCellValue('A' . $row, $row - 1);
                $sheet->setCellValue('B' . $row, $task['ten_congviec']);
                $sheet->setCellValue('C' . $row, $task['chitiet_congviec']);
                $sheet->setCellValue('D' . $row, date('Y-m-d', strtotime($task['ngay_batdau'])));
                $sheet->setCellValue('E' . $row, date('Y-m-d', strtotime($task['ngay_ketthuc'])));

                $getLoai = $this->loaicongviec_model->get_categories_by_id($task['id_loai']);
                if ($getLoai) {
                    $sheet->setCellValue('F' . $row, $getLoai['ten_loai']);
                }

                $dataStyle = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('rgb' => 'A9A9A9'),
                        ),
                    ),
                );
                $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($dataStyle);
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $row++;
            }
            $filename = 'congviec_' . date('dmY') . '_' . rand() . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit();

            $this->session->set_flashdata('success', 'Export thành công!');
        } catch (Exception $ex) {
            $this->session->set_flashdata('error', 'Đã xảy ra lỗi trong quá trình Export: ' . $ex->getMessage());
        }
        redirect('/');
    }
}
