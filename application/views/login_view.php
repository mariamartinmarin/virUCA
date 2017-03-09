<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>VirUCA</title>		
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Libs CSS -->
		<link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="<?=base_url()?>vendor/owl-carousel/owl.carousel.css" media="screen">
		<link rel="stylesheet" href="<?=base_url()?>vendor/owl-carousel/owl.theme.css" media="screen">
		<link rel="stylesheet" href="<?=base_url()?>vendor/magnific-popup/magnific-popup.css" media="screen">
		<link rel="stylesheet" href="<?=base_url()?>vendor/isotope/jquery.isotope.css" media="screen">
		<link rel="stylesheet" href="<?=base_url()?>vendor/mediaelement/mediaelementplayer.css" media="screen">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/theme.css">
		<link rel="stylesheet" href="<?=base_url()?>css/theme-elements.css">
		<link rel="stylesheet" href="<?=base_url()?>css/theme-blog.css">
		<link rel="stylesheet" href="<?=base_url()?>css/theme-shop.css">
		<link rel="stylesheet" href="<?=base_url()?>css/theme-animate.css">

		<!-- Responsive CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/theme-responsive.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/skins/default.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="<?=base_url()?>css/custom.css">

		<!-- Head Libs -->
		<script src="<?=base_url()?>vendor/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond.js"></script>
		<![endif]-->

	</head>
	<body>
		<?php
		$username = array('name' => 'username', 'placeholder' => 'nombre de usuario');
		$password = array('name' => 'password',	'placeholder' => 'introduce tu password');
		$submit = array('name' => 'submit', 'value' => 'Acceder', 'title' => 'Acceder');
		?>
		<div class="body">
			<?php $this->load->view('menul_view');?>

			<div role="main" class="main shop">

				<div class="container">

					<hr class="tall">

					<div class="row">
						<div class="col-md-12">

							<div class="row featured-boxes login">

								<div class="col-md-6">
									<div class="featured-box featured-box-secundary default">
									<div class="box-content">
									<h1>Bienvenidos a VirUCA</h1>
									<p>Accede a <b>VirUCA</b> como <b>Alumno</b>, para ingresar tus
									preguntas o como <b>Profesor</b>. Asegúrate, si eres alumno, que el
									docente te ha dado de alta en el sistema y te ha facilitado tus
									credenciales.
									</p>
									</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="featured-box featured-box-secundary default">
										<div class="box-content">
											<h4>Acceder a VirUCA</h4>
											<?php
											$username = array('name' => 'username', 
											'placeholder' => 'nombre de usuario', 
											'class' => 'form-control input-lg');

											$password = array('name' => 'password',	
											'placeholder' => 'introduce tu password',
											'class' => 'form-control input-lg');

											$submit = array('name' => 'submit', 
											'value' => 'Acceder', 
											'title' => 'Acceder',
											'class' => 'btn btn-default');
											?>
											<div class="container_12">
												<h1>Acceso a VirUCA</h1>
												<div class="grid_12" id="login">
													<div class="grid_8 push_2" id="formulario_login">
														<div class="grid_6 push_1" id="campos_login">
															<?=form_open(base_url().'index.php/login/new_user')?>
															<label for="username">Usuario:</label>
															<?=form_input($username)?><p><?=form_error('username')?></p>
															<label for="password">Contraseña:</label>
															<?=form_password($password)?><p><?=form_error('password')?></p>
															<?=form_hidden('token',$token)?>
															<?=form_submit($submit)?>
															<?=form_close()?>
															<?php 
																if($this->session->flashdata('usuario_incorrecto'))
																{
															?>
																<p><?=$this->session->flashdata('usuario_incorrecto')?></p>
															<?php
																}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>							
								
							</div>

						</div>
					</div>

				</div>

			</div>

			<?php $this->load->view('footer_login');?>
		</div>

		<!-- Libs -->
		<script src="<?=base_url()?>vendor/jquery.js"></script>
		<script src="<?=base_url()?>vendor/jquery.appear.js"></script>
		<script src="<?=base_url()?>vendor/jquery.easing.js"></script>
		<script src="<?=base_url()?>vendor/jquery.cookie.js"></script>
		<script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?=base_url()?>vendor/jquery.validate.js"></script>
		<script src="<?=base_url()?>vendor/jquery.stellar.js"></script>
		<script src="<?=base_url()?>vendor/jquery.knob.js"></script>
		<script src="<?=base_url()?>vendor/jquery.gmap.js"></script>
		<script src="<?=base_url()?>vendor/twitterjs/twitter.js"></script>
		<script src="<?=base_url()?>vendor/isotope/jquery.isotope.js"></script>
		<script src="<?=base_url()?>vendor/owl-carousel/owl.carousel.js"></script>
		<script src="<?=base_url()?>vendor/jflickrfeed/jflickrfeed.js"></script>
		<script src="<?=base_url()?>vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?=base_url()?>vendor/mediaelement/mediaelement-and-player.js"></script>
		
		<!-- Theme Initializer -->
		<script src="<?=base_url()?>js/theme.plugins.js"></script>
		<script src="<?=base_url()?>js/theme.js"></script>
		
		<!-- Custom JS -->
		<script src="<?=base_url()?>js/custom.js"></script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script type="text/javascript">
		
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-12345678-1']);
			_gaq.push(['_trackPageview']);
		
			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		
		</script>
		 -->

	</body>
</html>



<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
	</head>
	<body>
	
	</body>
</html>