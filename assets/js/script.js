var truongSelect = $('select[name="id_truong"]');

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    var checkbox = $('table tbody input[type="checkbox"]');

    var exportButton = $('#exportFile');

    var exportValues = $('#exportValues');


    function toggleExportButton() {
        if (checkbox.is(':checked')) {
            exportButton.removeAttr('disabled');
        } else {
            exportButton.attr('disabled', 'disabled');
        }
    }

    var arrCbx = [];
    $("#selectAll").click(function () {
        if (this.checked) {
            checkbox.each(function () {
                this.checked = true;
                if (!arrCbx.includes(this.value)) {
                    arrCbx.push(this.value);
                    exportValues.val(arrCbx);
                }
            });
        } else {
            checkbox.each(function () {
                this.checked = false;
            });
            arrCbx = [];
            exportValues.val(arrCbx);
        }
        toggleExportButton();
    });
    checkbox.click(function () {
        if (!this.checked) {
                
            var index = arrCbx.indexOf(this.value);
            if (index > -1) {
                arrCbx.splice(index, 1);
                exportValues.val(arrCbx);
            }
        } else {
            arrCbx.push(this.value);
            exportValues.val(arrCbx);
        }
        toggleExportButton();
    });

    $('.edit').on('click', function () {
        var id_loai = $(this).data('id');
        $('#edit_id_loai').val(id_loai);

        $.ajax({
            url: base_url + "index.php/loaicongviec/get_by_id/" + id_loai,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#edit_ten_loai').val(data.ten_loai);
                $('#edit_mota').val(data.mota);
                $('#editForm').attr('action', base_url + "index.php/loaicongviec/update/" + id_loai);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.edittask').on('click', function () {
        var id_congviec = $(this).data('id');
        $('#edit_id_congviec').val(id_congviec);

        $.ajax({
            url: base_url + "index.php/congviec/get_by_id/" + id_congviec,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#ten_congviec').val(data.ten_congviec);
                $('#chitiet_congviec').val(data.chitiet_congviec);
                $('#ngay_batdau').val(data.ngay_batdau);
                $('#ngay_ketthuc').val(data.ngay_ketthuc);
                $('#id_loai').val(data.id_loai);
                $('#id_phong').val(data.id_phong);

                autoChangeSchool(data.id_phong);

                var ten_congviec_value = $('#ten_congviec').val();
                var characterTenCount = ten_congviec_value.length;
                $('.ten-current.tenEdit').text(characterTenCount);

                var chitiet_congviec_value = $('#chitiet_congviec').val();
                var characterCount = chitiet_congviec_value.length;
                $('.current.totallength').text(characterCount);

                if (data.file_dinhkem != null) {
                    var fileUrl = base_url + 'uploads/' + data.file_dinhkem;
                    var fileExtension = data.file_dinhkem.split('.').pop().toLowerCase();
                    var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    var fileContainer = $('#file_container');
                    fileContainer.empty();

                    if (imageExtensions.includes(fileExtension)) {
                        fileContainer.append('<img src="' + fileUrl + '" alt="Task Attachment" style="max-width: 100%;">');
                    } else {
                        fileContainer.append('<a href="' + fileUrl + '" target="_blank">' + data.file_dinhkem + '</a>');
                    }
                }
                $('#editForm').attr('action', base_url + "index.php/congviec/update/" + id_congviec);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.edit_school').on('click', function () {
        var id_truong = $(this).data('id');
        $('#edit_id_truong').val(id_truong);

        $.ajax({
            url: base_url + "index.php/truong/get_by_id/" + id_truong,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#edit_ten_truong').val(data.ten_truong);
                $('#editForm').attr('action', base_url + "index.php/truong/update/" + id_truong);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.edit_room').on('click', function () {
        var id_phong = $(this).data('id');
        $('#edit_id_phong').val(id_phong);

        $.ajax({
            url: base_url + "index.php/phong/get_by_id/" + id_phong,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#edit_ten_phong').val(data.ten_phong);
                $('#editForm').attr('action', base_url + "index.php/phong/update/" + id_phong);
                $('#id_truong').val(data.id_truong);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.delete').on('click', function () {
        var id_loai = $(this).data('id');
        $.ajax({
            url: base_url + "index.php/loaicongviec/get_by_id/" + id_loai,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#deleteForm').attr('action', base_url + "index.php/loaicongviec/delete/" + id_loai);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.deletetask').on('click', function () {
        var id_congviec = $(this).data('id');
        $.ajax({
            url: base_url + "index.php/congviec/get_by_id/" + id_congviec,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#deleteForm').attr('action', base_url + "index.php/congviec/delete/" + id_congviec);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.delete_school').on('click', function () {
        var id_truong = $(this).data('id');
        $.ajax({
            url: base_url + "index.php/truong/get_by_id/" + id_truong,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#deleteForm').attr('action', base_url + "index.php/truong/delete/" + id_truong);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    $('.delete_room').on('click', function () {
        var id_truong = $(this).data('id');
        $.ajax({
            url: base_url + "index.php/phong/get_by_id/" + id_truong,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#deleteForm').attr('action', base_url + "index.php/phong/delete/" + id_truong);
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    });

    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;

    trigger.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
    });

    // for add
    $('#startdate').change(function () {
        var startDate = new Date($('#startdate').val());
        var endDate = new Date($('#enddate').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#enddate').val('');
        }
    });

    $('#enddate').change(function () {
        var startDate = new Date($('#startdate').val());
        var endDate = new Date($('#enddate').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#enddate').val('');
        }
    });

    $('#enddate').on('input', function () {
        var startDate = new Date($('#startdate').val());
        var endDate = new Date($('#enddate').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#enddate').val('');
        }
    });

    $('#startdate').on('input', function () {
        var startDate = new Date($('#startdate').val());
        var endDate = new Date($('#enddate').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#enddate').val('');
        }
    });

    // for edit
    $('#ngay_batdau').change(function () {
        var startDate = new Date($('#ngay_batdau').val());
        var endDate = new Date($('#ngay_ketthuc').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc').val('');
        }
    });

    $('#ngay_ketthuc').change(function () {
        var startDate = new Date($('#ngay_batdau').val());
        var endDate = new Date($('#ngay_ketthuc').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc').val('');
        }
    });

    $('#ngay_ketthuc').on('input', function () {
        var startDate = new Date($('#ngay_batdau').val());
        var endDate = new Date($('#ngay_ketthuc').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc').val('');
        }
    });

    $('#ngay_batdau').on('input', function () {
        var startDate = new Date($('#ngay_batdau').val());
        var endDate = new Date($('#ngay_ketthuc').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc').val('');
        }
    });

    //for sort
    $('#ngay_batdau_sort').change(function () {
        var startDate = new Date($('#ngay_batdau_sort').val());
        var endDate = new Date($('#ngay_ketthuc_sort').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc_sort').val('');
        }
    });

    $('#ngay_ketthuc_sort').change(function () {
        var startDate = new Date($('#ngay_batdau_sort').val());
        var endDate = new Date($('#ngay_ketthuc_sort').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc_sort').val('');
        }
    });

    $('#ngay_ketthuc_sort').on('input', function () {
        var startDate = new Date($('#ngay_batdau_sort').val());
        var endDate = new Date($('#ngay_ketthuc_sort').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc_sort').val('');
        }
    });

    $('#ngay_batdau_sort').on('input', function () {
        var startDate = new Date($('#ngay_batdau_sort').val());
        var endDate = new Date($('#ngay_ketthuc_sort').val());

        if (startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu');
            $('#ngay_ketthuc_sort').val('');
        }
    });
});

function autoChangeSchool(id) {
    truongSelect.empty();
    if (id){
        $.ajax({
            url: base_url + "index.php/congviec/get_truong_by_phong/" + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                truongSelect.empty();
                $.each(data, function (index, item) {
                    truongSelect.append('<option value="' + item.id_truong + '">' + item.ten_truong + '</option>');
                });
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText + '\n' + error;
                alert('Error fetching data - ' + errorMessage);
            }
        });
    }else{
        
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    const ngayBatdauInput = document.getElementById('ngay_batdau');
    const ngayKetthucInput = document.getElementById('ngay_ketthuc');
    const startdateInput = document.getElementById('startdate');
    const enddateInput = document.getElementById('enddate');

    const now = new Date();
    const formattedDate = `${pad(now.getDate())}/${pad(now.getMonth() + 1)}/${now.getFullYear()}`;
    ngayBatdauInput.value = formattedDate;
    ngayKetthucInput.value = formattedDate;
    startdateInput.value = formattedDate;
    enddateInput.value = formattedDate;

    ngayBatdauInput.addEventListener('blur', formatDate);
    ngayKetthucInput.addEventListener('blur', formatDate);
    startdateInput.addEventListener('blur', formatDate);
    enddateInput.addEventListener('blur', formatDate);
});

function formatDate(event) {
    const input = event.target;
    const parts = input.value.split('/');
    if (parts.length === 3) {
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);
        const date = new Date(year, month, day);

        if (!isNaN(date)) {
            const formattedDate = `${pad(date.getDate())}/${pad(date.getMonth() + 1)}/${date.getFullYear()}`;
            input.value = formattedDate;
        }
    }
}

function pad(number) {
    return number < 10 ? '0' + number : number;
}

$('textarea').keyup(function () {

    var characterCount = $(this).val().length,
        current = $('.current'),
        maximum = $('.maximum'),
        theCount = $('.the-count');

    current.text(characterCount);


    if (characterCount < 70) {
        current.css('color', '#666');
    }
    if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
    }
    if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
    }
    if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
    }
    if (characterCount > 120 && characterCount < 139) {
        current.css('color', '#8f0001');
    }

    if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        theCount.css('font-weight', 'bold');
    } else {
        maximum.css('color', '#666');
        theCount.css('font-weight', 'normal');
    }
});

$('#tencv_add').keyup(function () {

    var characterCount = $(this).val().length;
    var currents = $('.ten-current');
    var maximum = $('.ten-maximum');

    currents.text(characterCount);

    if (characterCount <= 70) {
        currents.css('color', '#666');
    } else if (characterCount > 70 && characterCount <= 80) {
        currents.css('color', '#6d5555');
    } else if (characterCount > 80 && characterCount <= 90) {
        currents.css('color', '#793535');
    } else if (characterCount > 90 && characterCount <= 100) {
        currents.css('color', '#841c1c');
    } else if (characterCount > 100 && characterCount <= 120) {
        currents.css('color', '#8f0001');
    } else if (characterCount > 120 && characterCount <= 139) {
        currents.css('color', '#8f0001');
    }

    if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        currents.css('color', '#8f0001');
        currents.css('font-weight', 'bold');
    } else {
        maximum.css('color', '#666');
        currents.css('font-weight', 'normal');
    }
});

$('#ten_congviec').keyup(function () {

    var characterCount = $(this).val().length;
    var currents = $('.ten-current');
    var maximum = $('.ten-maximum');

    currents.text(characterCount);

    if (characterCount <= 70) {
        currents.css('color', '#666');
    } else if (characterCount > 70 && characterCount <= 80) {
        currents.css('color', '#6d5555');
    } else if (characterCount > 80 && characterCount <= 90) {
        currents.css('color', '#793535');
    } else if (characterCount > 90 && characterCount <= 100) {
        currents.css('color', '#841c1c');
    } else if (characterCount > 100 && characterCount <= 120) {
        currents.css('color', '#8f0001');
    } else if (characterCount > 120 && characterCount <= 139) {
        currents.css('color', '#8f0001');
    }

    if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        currents.css('color', '#8f0001');
        currents.css('font-weight', 'bold');
    } else {
        maximum.css('color', '#666');
        currents.css('font-weight', 'normal');
    }
});


function toggleSort() {
    var advancedSort = document.getElementById('advancedSort');
    if (advancedSort.style.display === 'none' || advancedSort.style.display === '') {
        advancedSort.style.display = 'block';
    } else {
        advancedSort.style.display = 'none';
    }
}