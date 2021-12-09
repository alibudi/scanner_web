<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Muslima Festival</title>
  <link rel="icon" href="https://i2.wp.com/www.hops.id/wp-content/uploads/2020/11/cropped-hops-favico1.png?fit=32%2C32&ssl=1" type="image/x-icon"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/AdminLTE.min.css">
  <!-- iCheck -->
   <!-- SweetAlert 2-->
    <link href="<?php echo base_url('assets/sweetalert/sweetalert2.min.css');?>" rel="stylesheet" type="text/css">
   
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0)"><b>Muslima Festival</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silakan Login</p>
    <?php if($this->session->flashdata('info')){ ?>
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('info'); ?>
                        </div>
                    <?php } ?>
    <?php echo form_open('auth/proses_login');?>
      <div class="form-group has-feedback">
        <input type="text"  placeholder="Username" name="username" id="username" class="form-control">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control form-password" name="password" id="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
    <!--    <input type="checkbox" class="form-checkbox"> Show password -->
      <div class="row">
        <div style="margin: 10px" class="login-box-msg">
         
        <button type="submit" name="login" value="Login" class="btn btn-primary btn-block btn-flat">Login</button><br>
         <!-- <a href="<?php echo base_url("auth/forgot_password");?>"class="login-box-msg">Lupa password</a> -->
        <!-- <input type="submit"  name="login" class="btn btn-lg btn-block main-bg shape"  value="Login"> -->
        </div>
        <!-- /.col -->
      </div>
    </form>

  
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>" type="text/javascript"></script>
<!-- iCheck -->
<!-- <script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script> -->
<script type="text/javascript">
  $(document).ready(function(){   
    $('.form-checkbox').click(function(){
      if($(this).is(':checked')){
        $('.form-password').attr('type','text');
      }else{
        $('.form-password').attr('type','password');
      }
    });
  });
</script>
  </body>
</html>