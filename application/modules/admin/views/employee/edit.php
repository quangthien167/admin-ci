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
    <div class="container">
        <div class="row mt-2 justify-content-md-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <?php 
                            if($this->session->flashdata('success')){
                        ?>
                        <div class="alert alert-success"><?php echo $this->session->flashdata('success') ?></div>
                        <?php
                            }elseif($this->session->flashdata('error')){
                        ?>
                        <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
                        <?php
                            }
                        ?>
                        <?= form_open();?>
                        <div class="form-group">
                            <input type="hidden" name="uId" id="uId" value="<?= $byId['emp_number'] ?>" />
                            <label for="el_id">Mã nhân viên</label>
                            <input type="text" class="form-control" id="el_id" name="el_id"
                                placeholder="Nhập mã nhân viên" required>
                            <?= form_error('el_id','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Họ</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Nhập họ" required>
                            <?= form_error('lastname','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="middlename">Tên đệm</label>
                            <input type="text" class="form-control" id="middlename" name="middlename"
                                placeholder="Nhập tên đệm" required>
                            <?= form_error('middlename','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Tên</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="Nhập tên" required>
                            <?= form_error('firstname','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="nickname">Biệt Danh</label>
                            <input type="text" class="form-control" id="nickname" name="nickname"
                                placeholder="Nhập biệt danh" required>
                            <?= form_error('nickname','<p class="text-danger">','</p>');?>
                        </div>

                        <div class="form-group">
                            <label for="marital">Hôn nhân</label>
                            <input type="text" class="form-control" id="marital"
                                placeholder="Nhập tình trạng hôn nhân" required name="marital">
                            <?= form_error('marital','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="date">Ngày tạo</label>
                            <input type="text" class="form-control" id="date" placeholder="YYYY-MM-DD" required
                                name="date">
                            <?= form_error('date','<p class="text-danger">','</p>');?>
                        </div>
                        <div>
                            <input type="radio" name="gender" id="gender" value="1" required><label>Nam</label>
                            <input type="radio" name="gender" id="gender" value="0" required><label>Nữ</label>
                            <?= form_error('gender','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo base_url('employee?');?>" class="btn btn-secondary">Trở về</a>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var uId = "<?= $byId['emp_number']?>"
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/employee/edit/') ?>" + uId + "/json",
                dataType: "JSON",
                success: function(response) {
                    $('[name="el_id"]').val(response.employee_id);
                    $('[name="lastname"]').val(response.emp_lastname);
                    $('[name=middlename]').val(response.emp_middle_name);
                    $('[name=firstname]').val(response.emp_firstname);
                    $('[name=nickname]').val(response.emp_nick_name);
                    $('[name=marital]').val(response.emp_marital_status);
                    $('[name=date]').val(response.joined_date);
                    if (response.emp_gender == 'Nam') {
                        $('#gender').find(':radio[name=gender][value="1"]').prop('checked', true)
                    } else {
                        $('#gender').find(':radio[name=gender][value="0"]').prop('checked', true)
                    }
                },
            });
        });

        $(function(){
            $("#date").datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4'
            });
        });
    </script>
</body>

</html>