<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Login - VINALED ERP SYSTEM</title>
    <?php $this->load->view('inc/head_init') ?>
</head>

<body>
    <div class="container">
        <div class="col-lg-4 offset-lg-4 col-md-8 col-xl-4">
            <img src="<?php echo base_url('public/images/logo.png') ?>" class="img-fluid mt-5">
            <hr />
            <h3 class="text-center font-weight-bold  mt-4">ĐĂNG NHẬP</h3>
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
            <form action="<?php echo base_url('auth/login/login?' . http_build_query($this->input->get())); ?>" method="POST"
                autocomplete="off">
                <!-- Email input -->
                <div class="form-outline mb-3">
                    <label class="form-label">Tài khoản: <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control form-control-sm" placeholder="Nhập tên tài khoản"
                        name="username" value="<?php echo isset($username) ? $username : '' ?>" required  />
                </div>
                <div class="text-danger"><?php echo form_error('username'); ?></div>
                
                <!-- Password input -->
                <div class="form-outline mb-3">
                    <label class="form-label">Mật khẩu: <small class="text-danger">(*)</small></label>
                    <input type="password" class="form-control form-control-sm" placeholder="Nhập mật khẩu"
                        name="password" value="<?php echo isset($password) ? $password : '' ?>" required  />
                </div>
                <div class="text-danger"><?php echo form_error('password'); ?></div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remine" value="1" checked />
                        <label class="form-check-label">
                            Ghi nhớ
                        </label>
                    </div>
                    <a href="#!" class="text-body">Quên mật khẩu?</a>
                </div>

                <div class="text-center text-lg-start my-4 pt-2">
                    <button type="submit" class="btn btn-info btn-sm"
                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                    <p class="mt-2 pt-1 mb-0"><strong>Bạn chưa có tài khoản? Vui lòng liên hệ với quản trị
                            viên.</strong></p>
                </div>

            </form>
        </div>
    </div>
</body>

</html>