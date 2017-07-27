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

	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/597284b50d1bb37f1f7a54e4/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			})();
	</script>
	<!--End of Tawk.to Script-->


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

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Ayuda</a></li>
									<li class="active">Contacta</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h2>Contacta con nosotros!</h2>
							</div>
						</div>
					</div>
				</section>

				<!-- Google Maps -->
				<div id="googlemaps" class="google-map"></div>

				<div class="container">

					<div class="row">
						<div class="col-md-6">

							<div class="alert alert-success hidden" id="contactSuccess">
								<strong>Bien!</strong> Tu mensaje ha sido enviado con éxito.
							</div>

							<div class="alert alert-danger hidden" id="contactError">
								<strong>Oops!</strong> no se ha podido enviar tu mensaje, inténtalo más tarde.
							</div>

							<h2 class="short"><strong>Escríbenos!</strong></h2>
							<form id="contactForm" action="<?=base_url()?>assets/php/email.php" method="POST">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Tu nombre *</label>
											<input type="text" value="" data-msg-required="Nombre obligatorio." maxlength="100" class="form-control" name="name" id="name">
										</div>
										<div class="col-md-6">
											<label>Tu e-mail *</label>
											<input type="email" value="" data-msg-required="E-mail obligatorio." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Asunto</label>
											<input type="text" value="" data-msg-required="Asunto obligatorio." maxlength="100" class="form-control" name="subject" id="subject">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Mensaje *</label>
											<textarea maxlength="5000" data-msg-required="Mensaje obligatorio." rows="10" class="form-control" name="message" id="message"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit" value="Enviar mensaje" class="btn btn-primary btn-lg" data-loading-text="Loading...">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">
							<h4 class="push-top">¿Algún <strong>problema</strong>?</h4>
							<p>Si tienes alguna duda que no te haya quedado clara con la ayuda que te brindamos en la página, o quieres comentarnos o sugerirnos algo, ponte en contacto con nosotros. Te contestaremos a la mayor brevedad.</p>
							<p>Si lo prefieres, puedes usar el chat que puedes ver en esta misma página en la esquina inferior derecha.</p>

							<hr />

							<h4>¿Dónde <strong>estamos</strong>?</h4>
							<ul class="list-unstyled">
								<li><i class="icon icon-map-marker"></i> <strong>Dirección:</strong> Polígono Río San Pedro, 11510, Puerto Real, Cádiz.</li>
								<li><i class="icon icon-phone"></i> <strong>Teléfono:</strong> +34 956 016300</li>
								<li><i class="icon icon-phone"></i> <strong>Fax:</strong> +34 956 016288</li>
								<li><i class="icon icon-envelope"></i> <strong>Email:</strong> <a href="mailto:ciencias@uca.es">ciencias@uca.es</a></li>
							</ul>

							<hr />

							<h4>¿A qué hora <strong>encontrarnos?</strong></h4>
							<ul class="list-unstyled">
								<li><i class="icon icon-time"></i> Lunes - Viernes De 9:00 a 15:00</li>
								<li><i class="icon icon-time"></i> Fin de semana - Cerrado</li>
							</ul>

						</div>

					</div>

				</div>

			</div>

			<section class="call-to-action featured footer">
				<div class="container">
					<div class="row">
						<div class="center">
							<h3>No te quedes con las ganas, si tienes <strong>dudas</strong> ponte en contacto con <strong>nosotros</strong></span></h3>
						</div>
					</div>
				</div>
			</section>

			

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

		<!-- Current Page JS -->
		<script src="<?=base_url()?>js/views/view.contact.js"></script>
		
		<!-- Custom JS -->
		<script src="<?=base_url()?>js/custom.js"></script>

		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			// Map Markers
			var mapMarkers = [{
				address: "Facultad de Ciencias, Puerto Real",
				html: "<strong>Facultad de Ciencias</strong><br>Polígono Río San Pedro, 11510 Puerto Real",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				},
				popup: true
			}];

			// Map Initial Location
			var initLatitude = 36.531206;
			var initLongitude = -6.2132507;

			// Map Extended Settings
			var mapSettings = {
				controls: {
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 16
			};

			var map = $("#googlemaps").gMap(mapSettings);

			// Map Center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$("#googlemaps").gMap("centerAt", options);
			}

		</script>

	</body>
</html>
