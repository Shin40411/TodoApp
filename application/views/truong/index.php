<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4" style="margin: 18px 0;">
                            <h4>Quản lý trường học</h4>
                        </div>
                        <div class="col-sm-8" style="margin: 10px 0;display: flex;justify-content: flex-end;">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal" style="width:30%; height: 34px;display: flex;margin: 10px;justify-content:center"><i class="material-icons">&#xE147;</i> <span>Thêm trường</span></a>
                            <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Xóa</span></a> -->
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên trường</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        foreach ($truong as $school) : ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo $school['ten_truong']; ?></td>
                                <td>
                                    <a href="#editEmployeeModal" data-toggle="modal" class="edit_school" data-id="<?php echo $school['id_truong']; ?>">
                                        <i class="material-icons" data-toggle="tooltip" title="Sửa">&#xE254;</i>
                                    </a>
                                    <a href="#deleteEmployeeModal" class="delete_school" data-toggle="modal" data-id="<?php echo $school['id_truong']; ?>">
                                        <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Hiển thị <b><?php echo count($truong); ?></b> trên <b><?php echo $total_rows; ?></b> kết quả</div>
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo site_url('truong/add'); ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm trường</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên trường</label>
                        <input type="text" name="ten_truong" maxlength="80" autocomplete="OFF" class="form-control" required>
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
            <form method="post" id="editForm">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa trường</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_loai" id="edit_id_truong">
                    <div class="form-group">
                        <label>Tên trường</label>
                        <input type="text" name="ten_truong" maxlength="80" autocomplete="OFF" id="edit_ten_truong" class="form-control" required>
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
                    <h4 class="modal-title">Xóa trường</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chăc chắn muốn xóa trường này?</p>
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