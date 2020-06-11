<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo $this->config->item('ico')?>">
  <title><?php echo $this->config->item('title') ?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?php echo base_url()?>resource/plugins/animate/animate.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url()?>resource/dist/css/Google.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo base_url()?>">
        <img class="login-img" src="<?php echo base_url(); ?>resource/dist/img/logo/logo-productos-fernandez.png"/> 
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Ingrese sus credenciales para iniciar sesión</p>
      <?php echo form_open(base_url()); ?>
        <div class="form-group has-feedback <?php if (form_error('id_rut') !== '') {echo 'has-error';} ?>">
          <input type="text" class="form-control rut" name="id_rut" placeholder="Rut" value="<?php echo set_value('Rut', $this->input->get('usuario_rut'))?>">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo set_value('password', '')?>">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" class="radio_check"> Recordar
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
          </div>
        </div>
      <?php echo form_close(); ?>
      <?php echo validation_errors('<div class="alert alert-danger alert-with-icon" style="text-align: center;">','</div>'); ?>
    </div>
  </div>

  <!-- jQuery 3 -->
  <script src="<?php echo base_url()?>resource/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url()?>resource/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url()?>resource/plugins/iCheck/icheck.min.js"></script>
  <!-- Rut -->
  <script src="<?php echo base_url()?>resource/plugins/rut/jquery.rut.chileno.min.js"></script>
  <!-- Notify -->
  <script src="<?php echo base_url()?>resource/plugins/notify/bootstrap-notify.min.js"></script>

  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });

      $('.rut').rut({
        formatear :true,
        placeholder: false,
        fn_error : function(input){

        }
      });

      $('.rut').trigger('blur');
    });
  </script>
</body>
</html>
