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
                <h3>Quản lý tài khoản</h3>
                <a href="<?php echo base_url('/admin/users/create');?>"><button type="button" class="btn btn-info" style="margin: 20px;">
                        Thêm tài khoản
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
                                        <label for="name">Loại tài khoản</label>
                                        <input type="text" class="form-control" id="roleView" name="roleView" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_name">Tài khoản</label>
                                        <input type="text" class="form-control" id="usernameView" name="usernameView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_enteredView">Ngày tạo</label>
                                        <input type="text" class="form-control" id="date_enteredView" name="date_enteredView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_modifiedView">Ngày sửa</label>
                                        <input type="text" class="form-control" id="date_modifiedView" name="date_modifiedView"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <input type="text" class="form-control" id="statusView" name="statusView"
                                            readonly>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main">
                    <form action="#" action="" id="form-filter" autocomplete="off">
                        <div class="form-group col-md-12">
                            <select id="role" class="form-control col-md-2">
                                <option value="">-- Loại tài khoản --</option>
                                <?php foreach($role as $rl) : ?>
                                <option value="<?= $rl['id'];?>"><?= $rl['name'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group has-search">
                            <input type="text" id="user_name" class="form-control col-md-3" placeholder="Tài khoản">
                        </div>
                        <div class="form-group has-search">
                            <input type="text" id="date_entered" class="form-control col-md-3" placeholder="YYYY-MM-DD" >
                        </div>
                        <div class="form-group has-search col-md-6">
                            <button type="submit" class="btn btn-info form-control col-md-3" id="search_btn">Tìm
                                kiếm</button>&nbsp;
                            <button type="submit" class="btn btn-warning form-control col-md-3" id="reset_btn">Đặt
                                lại</button>
                        </div>
                    </form>
                </div>
                <?= $this->session->flashdata('');?>
                <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loại tài khoản</th>
                            <th>Tài khoản</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Loại tài khoản</th>
                            <th>Tài khoản</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
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
                "url": "<?php echo base_url('admin/users/getData')?>",
                "type": "POST",
                "data": function(data) {
                    data.user_role_id = $('#role').val();
                    data.user_name = $('#user_name').val();
                    data.date_entered = $('#date_entered').val();
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


    $(function(){
        $("#date_entered").datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4'
        });
    });

    var modalView = $('#modalView');
    function view(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/users/byIdView/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                $('[name="idView"]').val(response.id);
                $('[name="roleView"]').val(response.name);
                $('[name="usernameView"]').val(response.user_name);
                $('[name="usernameView"]').val(response.user_name);
                $('[name="date_enteredView"]').val(response.date_entered);
                $('[name="date_modifiedView"]').val(response.date_modified);
                $('[name="statusView"]').val(response.status);
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

        function deleteQuestion(id, name) {
            Swal.fire({
                title: 'Xóa tài khoản?',
                text: "Tài khoản " + name + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    deleteData(id);
                }
            })
        }

    function byid(id, type) {
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/users/byid/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    if (type == 'delete') {
                        deleteQuestion(response.id, response.user_name);
                    }
                },
                error: function() {
                    message('error', 'No');
                }
            });
        }

    function deleteData(id) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/users/delete/')?>" + id,
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