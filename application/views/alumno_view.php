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
		
		<div class="body">
			<?php $this->load->view('menua_view');?>

			<div role="main" class="main">

				<div class="home-intro light">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="#">Viruca</a></li>
                            <li class="active">Panel Principal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

				<div class="container">					
					<div class="row featured-boxes">
						<div class="col-md-4">
							<div class="featured-box featured-box-primary">
								<div class="box-content">
									<i class="icon-featured icon icon-user"></i>
									<h4>Mis Datos</h4>
									<p>Ver/Modificar mis datos.<a href="<?=base_url()?>index.php/datosalumno" class="learn-more">Ir + <i class="icon icon-angle-right"></i></a></p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="featured-box featured-box-secundary">
								<div class="box-content">
									<i class="icon-featured icon icon-book"></i>
									<h4>Añadir pregunta</h4>
									<p>Añade las preguntas, junto con sus posibles respuestas al juego. Recuerda
									que esta acción es evaluable por el docente. Trabaja en la originalidad de
									tus preguntas.<a href="<?=base_url()?>index.php/pregunta" class="learn-more">Añadir pregunta + <i class="icon icon-angle-right"></i></a></p>
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

	</body>
</html>