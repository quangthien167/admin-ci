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
                        <input type="hidden" name="uId" id="uId" value="<?= $byId['id'] ?>"/>
                            <label for="user_role_id">Loại tài khoản</label>
                            <select name="user_role_id" id="user_role_id" class="form-control" required>
                                <option value="">-- Loại tài khoản --</option>
                                <?php foreach($user_role_id as $rl) : ?>
                                <option value="<?= $rl['id'];?>"><?= $rl['name'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_name">Tài khoản</label>
                            <input type="text" class="form-control" id="user_name" name="user_name"
                                placeholder="Nhập tài khoản" required>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Mật khẩu</label>
                            <input type="password" class="form-control" id="user_password" name="user_password"
                                placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label for="date_entered">Ngày tạo</label>
                            <input type="text" class="form-control" id="date_entered" name="date_entered"
                                placeholder="YYYY-MM-DD" required>
                            <?= form_error('date_entered','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="form-group">
                            <label for="date_modified">Ngày sửa</label>
                            <input type="text" class="form-control" id="date_modified" name="date_modified"
                                placeholder="YYYY-MM-DD" required>
                            <?= form_error('date_modified','<p class="text-danger">','</p>');?>
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo base_url('users?');?>" class="btn btn-secondary">Trở về</a>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
       
       $(document).ready(function(){
        var uId = "<?= $byId['id']?>"
        $.ajax({
            type:"GET",
            url:"<?= base_url('admin/users/edit/') ?>" + uId +"/json",
            dataType:"JSON",
            success:function(response){
                $('[name="user_role_id"]').val(response.user_role_id).trigger('change');
                $('[name="user_name"]').val(response.user_name);
                $('[name=user_password]').val(response.user_password);
                $('[name=date_entered]').val(response.date_entered);
                $('[name=date_modified]').val(response.date_modified);
            },
        });
       });

       $(function(){
        $("#date_entered").datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4'
        });
        $("#date_modified").datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4'
        });
    });
    </script>
</body>

</html>