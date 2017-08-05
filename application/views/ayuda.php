<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>Viruca</title>		
		<meta name="keywords" content="Viruca, trivial" />
		<meta name="description" content="Viruca">
		<meta name="author" content="María Martín Marín">

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
			<?php 
			$var = $this->session->userdata('admin');
			$perfil = $this->session->userdata('perfil');

			switch ($var) {
				case '1': $this->load->view('menup_view'); break;
				default:
					switch ($perfil) {
						case '1': $this->load->view('menua_view'); break;
						case '0':  $this->load->view('menup_view'); break;
						default: $this->load->view('menul_view'); break;
					}
					break;
			}
			?>

			<div role="main" class="main">

				<div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="#">Ayuda</a></li>
                            <li class="active"><strong>Ayuda de la Aplicación</strong></li>
                        </ul>
                    </div>
                </div>
                </div>

				<div class="container">
					<ul class="nav nav-pills sort-source" data-sort-id="portfolio" data-option-key="filter">
						<li data-option-value="*" class="active"><a href="#">Mostrar todo</a></li>
						<li data-option-value=".usuarios"><a href="#">Usuarios</a></li>
						<li data-option-value=".curso"><a href="#">Curso</a></li>
						<li data-option-value=".juego"><a href="#">Preguntas y Partidas</a></li>
						<li data-option-value=".miscelanea"><a href="#">Listados y Estadísticas</a></li>
					</ul>

					<hr />

					<div class="row">

						<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
							<li class="col-md-3 isotope-item usuarios">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Usuarios</span>
											<span class="thumb-info-type">PROFESORES</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item usuarios">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Usuarios</span>
											<span class="thumb-info-type">ALUMNOS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item curso">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Curso</span>
											<span class="thumb-info-type">UNIVERSIDADES</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item curso">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Curso</span>
											<span class="thumb-info-type">TITULACIONES</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item curso">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Curso</span>
											<span class="thumb-info-type">ASIGNATURAS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item curso">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Curso</span>
											<span class="thumb-info-type">CURSOS ACADÉMICOS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item juego">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Juego</span>
											<span class="thumb-info-type">CATEGORÍAS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
							<li class="col-md-3 isotope-item juego">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Juego</span>
											<span class="thumb-info-type">PREGUNTAS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>

							<li class="col-md-3 isotope-item juego">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Juego</span>
											<span class="thumb-info-type">PANELES</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>

							<li class="col-md-3 isotope-item juego">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Juego</span>
											<span class="thumb-info-type">PARTIDAS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>

							<li class="col-md-3 isotope-item miscelanea">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Miscelánea</span>
											<span class="thumb-info-type">LISTADOS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>

							<li class="col-md-3 isotope-item miscelanea">
								<div class="portfolio-item img-thumbnail">
									<a href="portfolio-single-project.html" class="thumb-info">
										<img alt="" class="img-responsive" src="<?=base_url()?>assets/img/ayuda/project.jpg">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">Miscelánea</span>
											<span class="thumb-info-type">ESTADÍSTICAS</span>
										</span>
										<span class="thumb-info-action">
											<span title="Universal" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
										</span>
									</a>
								</div>
							</li>
						</ul>
					</div>

				</div>

			</div>

			<?php 
			switch ($var) {
				case '1':
					$this->load->view('footer'); break;
				default:
					switch ($perfil) {
						case '1': $this->load->view('footer_login'); break;
						case '0': $this->load->view('footer'); break;
						default: $this->load->view('footer_login'); break;
					}
					break;
			}
			?>
		</div>

		<!-- Libs -->
		<script src="<?=base_url()?>vendor/jquery.js"></script>
		<script src="<?=base_url()?>vendor/jquery.appear.js"></script>
		<script src="<?=base_url()?>vendor/jquery.easing.js"></script>
		<script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?=base_url()?>vendor/jquery.validate.js"></script>
		<script src="<?=base_url()?>vendor/jquery.stellar.js"></script>
		<script src="<?=base_url()?>vendor/isotope/jquery.isotope.js"></script>
		
		<!-- Theme Initializer -->
		<script src="<?=base_url()?>js/theme.plugins.js"></script>
		<script src="<?=base_url()?>js/theme.js"></script>
		
		<!-- Custom JS -->
		<script src="<?=base_url()?>js/custom.js"></script>

	</body>
</html>
