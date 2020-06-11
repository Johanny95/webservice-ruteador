<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="icon" href="<?php echo $this->config->item('ico')?>">
  	
	
	<title><?php echo $this->config->item('title') ?></title>
	<?php echo put_headers() ?>
	<script>$.widget.bridge('uibutton', $.ui.button);</script>
	<?php echo put_headers_dy() ?>
		
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/dist/css/AdminLTE.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/dist/css/skins/_all-skins.min.css')?>">
</head>
<body class="hold-transition skin-black sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo site_url('inicio')?>" class="logo">
				<!-- Logo PF -->
				<div class="logo-mini logo-img">
					<img class="logo-img" src="<?php echo base_url(); ?>resource/dist/img/logo/logo_pf.png"/>
				</div>
				<!-- Logo PF Alimento -->
				<span class="logo-lg logo-img">
					<img class="logo-img" src="<?php echo base_url(); ?>resource/dist/img/logo/logo-productos-fernandez-betan.png"/>
				</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<?php if ($this->session->login == TRUE || $this->session->login != NULL): ?>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="hidden-xs"><?php echo $this->session->nombre ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- Menu Footer-->
									<li class="user-header">
										<img src="<?php echo base_url()?>resource/dist/img/logo/logo_pf_user.png" class="img-circle" alt="User Image">

										<p>
											<?php echo $this->session->nombre ?>
											<small><?php echo $this->session->departamento?></small>
										</p>
									</li>
									<li class="user-body">
										<div class="row">
											<div class="col-xs-12 text-center">
												<a href="<?php echo site_url('perfil')?>">Perfil</a>
											</div>
										</div>
									</li>
									<li class="user-footer">
										<div class="pull-right">
											<a href="<?php echo site_url('cerrar_sesion')?>" class="btn btn-default btn-flat">Salir</a>
										</div>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
							</li>
						</ul>
					</div>
				<?php endif ?>
			</nav>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<?php if ($this->session->login == TRUE || $this->session->login != NULL): ?>
					<?php echo $this->menu->render(); ?>
				<?php endif ?>
			</section>
			<!-- /.sidebar -->
		</aside>
		<aside class="control-sidebar control-sidebar-dark">
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li class="active"><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane" id="control-sidebar-home-tab">
				</div><div id="control-sidebar-theme-demo-options-tab" class="tab-pane active"><div></div></div>
				<div class="tab-pane" id="control-sidebar-stats-tab"></div>
			</div>
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">