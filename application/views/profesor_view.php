<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>VirUCA <?=$this->session->userdata('is_logued_in');?></title>		
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Libs CSS -->
		<link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
		
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/theme.css">
		<link rel="stylesheet" href="<?=base_url()?>css/theme-elements.css">	
		<link rel="stylesheet" href="<?=base_url()?>css/theme-shop.css">

		<!-- Responsive CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/theme-responsive.css" />

		<link rel="stylesheet" href="<?=base_url()?>css/skins/default.css">
		<link rel="stylesheet" href="<?=base_url()?>css/custom.css">

		
		<script src="<?=base_url()?>vendor/modernizr.js"></script>
		
		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond.js"></script>
		<![endif]-->

	</head>
	<body>
		
		<div class="body">
			<?php $this->load->view('menup_view');?>

			<div role="main" class="main">


				<div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li class="active"><strong>Panel Principal</strong></li>
                        </ul>
                    </div>
                </div>
                </div>

				<div class="container">					
					<div class="row featured-boxes">
						<div class="col-md-4">
							<div class="featured-box featured-box-primary">
								<div class="box-content">
									<i class="icon-featured icon icon-user"></i>
									<h4>Añadir alumno</h4>
									<p>Añadir alumnos al curso actual.<a href="<?=base_url()?>index.php/alumnos" class="learn-more">Añadir + <i class="icon icon-angle-right"></i></a></p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="featured-box featured-box-secundary">
								<div class="box-content">
									<i class="icon-featured icon icon-book"></i>
									<h4>Revisión de preguntas</h4>
									<p>Revisar las preguntas de los alumnos antes de ser publicadas.<a href="<?=base_url()?>index.php/preguntas" class="learn-more">Revisar <i class="icon icon-angle-right"></i></a></p>
								</div>
							</div>
						</div>
	
						<div class="col-md-4">
							<div class="featured-box featured-box-quartenary">
								<div class="box-content">
									<i class="icon-featured icon icon-cogs"></i>
									<h4>Empezar partida</h4>
									<p>Selecciona una partida activa y empieza a jugar. <a href="<?=base_url()?>index.php/partidas" class="learn-more">Empezar! <i class="icon icon-angle-right"></i></a></p>
								</div>
							</div>
						</div>
					</div>								
				</div>
			</div>
			<?php $this->load->view('footer');?>
		</div>

		<!-- Libs -->
		<script src="<?=base_url()?>vendor/jquery.js"></script>
		<script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>

	</body>
</html>