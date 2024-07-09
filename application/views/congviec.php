<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-lg-offset-0">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 18px 0;">
                            <h4>Quản lý công việc</h4>
                        </div>
                        <div class="col-sm-8" style="margin: 10px 0;display: flex;justify-content: flex-end;">
                            <form method="get" style="width:100%" action="<?php echo site_url('congviec'); ?>">
                                <input type="text" width="100%" name="search" placeholder="Tìm kiếm....." autocomplete="OFF" id="search" style="margin: 10px 0;" class="form-control">
                            </form>
                            <div>
                                <a href="#addEmployeeModal" class="btn btn-success" onclick="autoChangeSchool('')" data-toggle="modal" style="height: 34px;display: flex;margin: 10px;"><i class="material-icons">&#xE147;</i> <span>Thêm việc</span></a>
                            </div>
                            <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Xóa</span></a>-->
                        </div>
                    </div>
                    <div class="row" id="advancedSort">
                        <form method="post" action="<?php echo site_url('congviec'); ?>">
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ngay_batdau">Ngày bắt đầu</label>
                                        <input type="date" name="ngay_batdau_sort" id="ngay_batdau_sort" value="<?php echo isset($sort_params['ngay_batdau']) ? $sort_params['ngay_batdau'] : ''; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ngay_ketthuc">Ngày kết thúc</label>
                                        <input type="date" name="ngay_ketthuc_sort" id="ngay_ketthuc_sort" value="<?php echo isset($sort_params['ngay_ketthuc']) ? $sort_params['ngay_ketthuc'] : ''; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-8">
                                    <label for="id_loai_sort">Loại công việc</label>
                                    <select name="id_loai_sort" id="id_loai_sort" class="form-control">
                                        <option value="">Tất cả</option>
                                        <?php foreach ($loai as $type) : ?>
                                            <option value="<?php echo $type['id_loai']; ?>" <?php echo isset($sort_params['id_loai']) && $sort_params['id_loai'] == $type['id_loai'] ? 'selected' : ''; ?>>
                                                <?php echo $type['ten_loai']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4" style="
                                    height: 55px;
                                    display: flex;
                                    justify-content: flex-end;
                                    align-items: end;
                                ">
                                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search" style="font-size: 15px;"></i>Lọc kết quả</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_truong_sort">Trường</label>
                                        <select name="id_truong_sort" id="id_truong_sort" class="form-control" onchange="autoSortSchool(this.value)">
                                            <option value="">Tất cả</option>
                                            <?php foreach ($truong_hoc as $type) : ?>
                                                <option value="<?php echo $type['id_truong']; ?>" <?php echo isset($sort_params['id_truong']) && $sort_params['id_truong'] == $type['id_truong'] ? 'selected' : ''; ?>>
                                                    <?php echo $type['ten_truong']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_phong_sort">Phòng</label>
                                        <select name="id_phong_sort" id="id_phong_sort" class="form-control">
                                            <option value="">Tất cả</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-4 d-flex-start">
                            <button class="btn btn-default" style="color: #000;" onclick="toggleSort()">
                                <i class="glyphicon glyphicon-align-left" style="font-size: 15px;"></i> Bộ lọc nâng cao
                            </button>
                        </div>
                        <div class="col-md-8 d-flex-end">
                            <!-- <a class="btn btn-warning" data-toggle="modal" href="#" disabled>
                                <i class="glyphicon glyphicon-plus" style="font-size: 15px;"></i>Nhân bản
                            </a> -->
                            <a class="btn btn-warning" data-toggle="modal" href="#importEmployeeModel">
                                <i class="glyphicon glyphicon-import" style="font-size: 15px;"></i>Import file
                            </a>
                            <a class="btn btn-warning" data-toggle="modal" id="exportFile" href="#exportEmployeeModel" disabled>
                                <i class="glyphicon glyphicon-export" style="font-size: 15px;"></i>Export file
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>#</th>
                            <th style="width: 50px;">Tên công việc</th>
                            <th style="width: 50px;">Loại công việc</th>
                            <th style="width: 200px;">Phòng</th>
                            <th style="width: 200px;">Trường</th>
                            <th>File đính kèm</th>
                            <th style="width: 200px;">Thời gian thực hiện</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1;
                        foreach ($congviec as $task) :
                            foreach ($loaicongviec as $key => $value) {
                                if ($key == $task['id_loai']) {
                                    $task['id_loai'] = $value['id_loai'];
                                    $task['ten_loai'] = $value['ten_loai'];
                                    break;
                                }
                            }
                            foreach ($phongs as $key => $value) {
                                if ($key == $task['id_phong']) {
                                    $task['id_phong'] = $value['id_phong'];
                                    $task['ten_phong'] = $value['ten_phong'];
                                    break;
                                }
                            }
                        ?>
                            <tr>
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox_<?php echo $task['id_congviec']; ?>" name="options[]" value="<?php echo $task['id_congviec']; ?>">
                                        <label for="checkboxChild"></label>
                                    </span>
                                </td>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo $task['ten_congviec']; ?></td>
                                <td>
                                    <?php echo $task['ten_loai']; ?>
                                </td>
                                <td>
                                    <?php echo $task['ten_phong']; ?>
                                </td>
                                <td><?php echo isset($ten_truongs[$task['id_congviec']]) ? $ten_truongs[$task['id_congviec']] : 'Kxđ'; ?></td>
                                <td>
                                    <?php if (in_array(pathinfo($task['file_dinhkem'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                        <img src="<?php echo base_url('uploads/' . $task['file_dinhkem']); ?>" alt="attachment" width="100">
                                    <?php else : ?>
                                        <a href="<?php echo base_url('uploads/' . $task['file_dinhkem']); ?>" data-toggle="tooltip" title="Tải về"><?php echo $task['file_dinhkem'] ?></a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($task['ngay_batdau'])); ?> - <?php echo date('d/m/Y', strtotime($task['ngay_ketthuc'])); ?>
                                </td>
                                <td>
                                    <a href="#editEmployeeModal" data-toggle="modal" class="edittask" data-id="<?php echo $task['id_congviec']; ?>">
                                        <i class="material-icons" data-toggle="tooltip" title="Sửa">&#xE254;</i>
                                    </a>
                                    <a href="#deleteEmployeeModal" class="deletetask" data-toggle="modal" data-id="<?php echo $task['id_congviec']; ?>">
                                        <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Hiển thị <b><?php echo count($congviec); ?></b> trên <b><?php echo $total_rows; ?></b> kết quả</div>
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo site_url('congviec/add'); ?>" method="post" class="my-4" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm công việc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten_congviec">Tên công việc</label>
                        <input type="text" name="ten_congviec" id="tencv_add" class="form-control" maxlength="80" autocomplete="OFF" required>
                        <div class="ten-count">
                            <span class="ten-current">0</span>
                            <span class="ten-maximum">/ 80</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="chitiet_congviec">Chi tiết công việc</label>
                        <textarea name="chitiet_congviec" class="form-control" maxlength="1000"></textarea>
                        <div class="the-count">
                            <span class="current">0</span>
                            <span class="maximum">/ 1000</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ngay_batdau">Ngày bắt đầu</label>
                        <input type="datetime-local" name="ngay_batdau" id="startdate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ngay_ketthuc">Ngày kết thúc</label>
                        <input type="datetime-local" name="ngay_ketthuc" id="enddate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_loai">Loại công việc</label>
                        <select name="id_loai" class="form-control" required>
                            <?php foreach ($loai as $type) : ?>
                                <option value="<?php echo $type['id_loai']; ?>"><?php echo $type['ten_loai']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_truong">Trường</label>
                        <select name="id_truong" class="form-control" onchange="autoChangeSchool(this.value)" required>
                            <option value="">Thuộc trường</option>
                            <?php foreach ($truong_hoc as $type) : ?>
                                <option value="<?php echo $type['id_truong']; ?>"><?php echo $type['ten_truong']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_loai">Phòng</label>
                        <select name="id_phong" class="form-control" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_dinhkem">File đính kèm</label>
                        <input type="file" name="file_dinhkem" class="form-control" accept=".zip,.jpg,.jpeg,.png,.gif">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Bỏ qua">
                    <input type="submit" class="btn btn-success" value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>
<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="editForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa công việc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_congviec" id="edit_id_congviec">
                    <div class="form-group">
                        <label for="ten_congviec">Tên công việc</label>
                        <input type="text" name="ten_congviec" id="ten_congviec" class="form-control" autocomplete="OFF" maxlength="80" required>
                        <div class="ten-count">
                            <span class="ten-current tenEdit">0</span>
                            <span class="ten-maximum">/ 80</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="chitiet_congviec">Chi tiết công việc</label>
                        <textarea name="chitiet_congviec" id="chitiet_congviec" maxlength="1000" class="form-control"></textarea>
                        <div class="the-count">
                            <span class="current totallength">0</span>
                            <span class="maximum">/ 1000</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ngay_batdau">Ngày bắt đầu</label>
                        <input type="datetime-local" name="ngay_batdau" id="ngay_batdau" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ngay_ketthuc">Ngày kết thúc</label>
                        <input type="datetime-local" name="ngay_ketthuc" id="ngay_ketthuc" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_loai">Loại công việc</label>
                        <select name="id_loai" id="id_loai" class="form-control" required>
                            <?php foreach ($loai as $type) : ?>
                                <option value="<?php echo $type['id_loai']; ?>"><?php echo $type['ten_loai']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_truong">Trường</label>
                        <select name="id_truong" class="form-control" onchange="autoChangeSchool(this.value)" required>
                            <option value="">Thuộc trường</option>
                            <?php foreach ($truong_hoc as $type) : ?>
                                <option value="<?php echo $type['id_truong']; ?>"><?php echo $type['ten_truong']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_loai">Phòng</label>
                        <select name="id_phong" class="form-control" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_dinhkem">File đính kèm</label>
                        <input type="file" name="file_dinhkem" id="file_dinhkem" class="form-control" accept=".zip,.jpg,.jpeg,.png,.gif">
                        <div id="file_container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Bỏ qua">
                    <input type="submit" class="btn btn-primary" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa công việc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chăc chắn muốn xóa công việc này?</p>
                    <!-- <p class="text-warning"><small>This action cannot be undone.</small></p> -->
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Bỏ qua">
                    <input type="submit" class="btn btn-danger" value="Xóa">
                </div>
            </form>
        </div>
    </div>
</div>
<div id="importEmployeeModel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('congviec/import'); ?>">
                <div class="modal-header">
                    <h4 class="modal-title">Import công việc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="excel_file" class="form-control" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Bỏ qua">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="exportEmployeeModel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo site_url('congviec/export'); ?>">
                <div class="modal-header">
                    <h4 class="modal-title">Export công việc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="exportValues" id="exportValues">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Tiến hành export</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Bỏ qua">
                </div>
            </form>
        </div>
    </div>
</div>