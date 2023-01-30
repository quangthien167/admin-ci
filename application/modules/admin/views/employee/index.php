<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'VINALED HRM System' ?></title>
    <?php $this->load->view('inc/head') ?>
</head>

<body>
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Quản lý nhân viên</h3>
                <a href="<?php echo base_url('/admin/employee/create'); ?>"><button type="button" class="btn btn-info"
                        style="margin: 20px;">
                        Thêm nhân viên
                    </button></a>
                <div class="modal fade" id="modalView" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">View</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <input type="hidden" id="idView" name="idView" value="">
                                    <div class="form-group">
                                        <label for="el_idView">Mã nhân viên</label>
                                        <input type="text" class="form-control" id="el_idView" name="el_idView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="fullnameView">Họ và tên</label>
                                        <input type="text" class="form-control" id="fullnameView" name="fullnameView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nicknameView">Biệt Danh</label>
                                        <input type="text" class="form-control" id="nicknameView" name="nicknameView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="genderView">Giới tính</label>
                                        <input type="text" class="form-control" id="genderView" name="genderView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="maritalView">Hôn nhân</label>
                                        <input type="text" class="form-control" id="maritalView" name="maritalView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="dateView">Ngày tạo</label>
                                        <input type="text" class="form-control" id="dateView" name="dateView" readonly>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">

                    <div class="main">
                        <form action="#" action="" class="row col-md-12" id="form-filter" autocomplete="off">
                            <div class="form-group has-search">
                                <input type="text" id="empId" class="form-control col-md-10"
                                    placeholder="Mã nhân viên">
                            </div>
                            <div class="form-group has-search">
                                <input type="text" id="name" class="form-control col-md-10 name"
                                    placeholder="Họ và tên">
                            </div>
                            <div class="form-group has-search">
                                <input type="text" id="nickname" class="form-control col-md-10"
                                    placeholder="Biệt danh">
                            </div>
                            <div class="form-group has-search">
                                <input type="text" id="date" class="form-control col-md-10" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="form-group has-search col-md-10">
                                <button type="submit" class="btn btn-info form-control col-md-2" id="search_btn">Tìm
                                    kiếm</button>&nbsp;
                                <button type="submit" class="btn btn-warning form-control col-md-2" id="reset_btn">Đặt
                                    lại</button>
                            </div>
                        </form>
                    </div>

                </div>
                <?= $this->session->flashdata('');?>
                <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã nhân viên</th>
                            <th>Họ và tên</th>
                            <th>Biệt danh</th>
                            <th>Giới tính</th>
                            <th>Ngày tạo</th>
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Mã nhân viên</th>
                            <th>Họ và tên</th>
                            <th>Biệt danh</th>
                            <th>Giới tính</th>
                            <th>Ngày tạo</th>
                            <th>...</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
    var table = $('#myTable');
    $(document).ready(function() {
        table.DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('admin/employee/getData')?>",
                "type": "POST",
                "data": function(data) {
                    data.employee_id = $('#empId').val();
                    data.fullname = $('#name').val();
                    data.emp_nick_name = $('#nickname').val();
                    data.joined_date = $('#date').val();
                }
            },
            "columnDefs": [{
                "orderable": false
            }, ],
        });
        $('#search_btn').click(function() {
            table.DataTable().ajax.reload();
        });
        $('#reset_btn').click(function() {
            $('#form-filter')[0].reset();
            table.DataTable().ajax.reload();
        });
    });

    $(function() {
        $("#date").datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4'
        });
    });

    var modalView = $('#modalView');

    function view(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/employee/byIdViewEmployee/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                $('[name="idView"]').val(response.emp_number);
                $('[name="el_idView"]').val(response.employee_id);
                $('[name="fullnameView"]').val(response.fullname);
                $('[name="nicknameView"]').val(response.emp_nick_name);
                $('[name="genderView"]').val(response.emp_gender);
                $('[name="maritalView"]').val(response.emp_marital_status);
                $('[name="dateView"]').val(response.joined_date);
                modalView.modal('show');
            }
        });
    }

    function message(icon, text) {
        Swal.fire({
            icon: icon,
            title: 'Xóa',
            text: text,
            showConfirmButton: false,
            showCancelButton: false,
            timer: 1500,
            timerProgressBar: true,
        });
    }

    function deleteQuestion(emp_number, employee_id) {
        Swal.fire({
            title: 'Xóa nhân viên?',
            text: "Nhân viên " + employee_id + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.value) {
                deleteData(emp_number);
            }
        })
    }

    function byid(emp_number, type) {
        $.ajax({
            type: "GET",
            url: "<?= base_url('admin/employee/byid/') ?>" + emp_number,
            dataType: "JSON",
            success: function(response) {
                if (type == 'delete') {
                    deleteQuestion(response.emp_number, response.employee_id);
                }
            },
            error: function() {
                message('error', 'No');
            }
        });
    }

    function deleteData(emp_number) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/employee/delete/')?>" + emp_number,
            dataType: "JSON",
            success: function(response) {
                table.DataTable().ajax.reload();
                message('success', 'Ok');
            },
            error: function() {
                message('error', 'No');
            }
        });
    }
    </script>
</body>

</html>