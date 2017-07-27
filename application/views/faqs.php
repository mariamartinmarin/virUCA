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

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Ayuda</a></li>
									<li class="active">FAQ's</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h2>Preguntas Frecuentes (FAQ's)</h2>
							</div>
						</div>
					</div>
				</section>

				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p class="lead">
								En este apartado respondemos a las dudas que puedan surgirte cuando estés usando esta aplicación, así que, antes de visitar la sección de <strong>ayuda</strong>, que es más extensa, revisa las <strong>FAQ's</strong> para ahorrarte tiempo.
							</p>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12">

							<div class="toogle">
								<section class="toggle active">
									<label>¿Qué es <strong>VirUCA</strong>?</label>
									<p>Viruca es una plataforma de aprendizaje de la Universidad de Cádiz. Se trata de un juego de preguntas con funcionamiento similiar al <strong>trivial</strong>.<br/><br/>En él pueden participar alumnos de cualesquiera de las titulaciones impartidas tanto por la Universidad de Cádiz como por cualquier otra universidad que quiera participar. <strong>VirUCA</strong> es una herramienta didáctica que se utiliza, además, para evaluar el trabajo de los alumnos, ya que éstos, serán los que introducirán las preguntas que más tarde se utilizarán en el juego y que, posteriormente, serán evaluadas por los profesores de la asignatura.</p>
								</section>

								<section class="toggle">
									<label>¿Cómo puedo darme de alta en <strong>VirUCA</strong>?</label>
									<p>Para darte de alta en <strong>VirUCA</strong>, lo primero que debemos tener en cuenta es si eres "alumno" o "profesor". Si eres "alumno" será tu profesor el encargado de darte de alta tanto a ti, como a todos tus compañeros. Él ya os avisará de ello.<br/><br/>
									Si tienes cualquier problema con el alta, siempre puedes ponerte en contacto con nosotros a través del formulario de contacto habilitado para ello. En breve te respondemos.</p>
								</section>

								<section class="toggle">
									<label>Soy alumno, y no puedo modificar mis preguntas, ¿por qué?</label>
									<p>Si no puedes modificar las respuestas, es debido a que tu profesor ha desabilitado la edición de preguntas. Durante el curso, vuestro profesor os avisará cuando podéis dar de alta preguntas, así mismo, podréis modificarlas o eliminarlas, pero cuando los profesores empiecen a evaluar las preguntas, no será posible hacer ninguna de estas funcionalidades.<br/><br/>A partir de entonces, sólo podréis mirar las preguntas, pero en ningún caso eliminarlas o modificarlas.</p>
								</section>

								<section class="toggle">
									<label>No puedo entrar en el sistema, ni siquera puedo loguearme, ¿Qué pasa?</label>
									<p>A veces, el administrador del sitio parará la actividad de la web para realizar labores de mantenimiento. No te preocupes porque esto suele ser temporal. Y si lo que te preocupa son tus datos, no te preocupes, están a salvo y podrás acceder a ellos tan pronto como se restablezca el normal funcionamiento del sitio.</p>
								</section>

								<section class="toggle">
									<label>Estoy dado de alta en <strong>VirUCA</strong>, pero no puedo dar de alta preguntas de la asignatura que deseo, ¿qué está pasando?</label>
									<p>No te preocupes, si puedes entrar en el sistema, es que tu registro se ha completado con éxito, pero lo más probable es que tu profesor no te haya asignado aún la asignatura sobre la que quieres introducir preguntas. Si esta situación se prolonga, contacta con tu profesor o ponte en contacto con el administrador del sitio a través del formulario de contacto.</p>
								</section>

								<section class="toggle">
									<label>Estoy intentando comunicarme con el administrador a través del chat, pero siempre permanece "Desconectado", ¿qué pasa?</label>
									<p>Si el chat aparece como "Desconectado" es, sencillamente, porque no estamos en línea, es posible que el chat no esté activo las 24 horas, sino que sólo lo esté cuando realmente podemos contestar en línea a vuestras peticiones, de todas maneras, aunque aparezca desconectado, puedes enviarnos tu duda a través del chat, ya que los mensajes siempre llegan. Si aún así, esto no te parece suficiente, tienes a tu disposición el formulario de contacto al que puedes acceder desde el menú de "AYUDA".</p>
								</section>

								<section class="toggle">
									<label>Soy profesor, estoy intentando crear una partida, y para ello he creado un nuevo panel, pero cuando quiero crear la partida, este nuevo panel no aparece, ¿por qué?</label>
									<p>Esto te puede estar pasando porque los paneles, cuando se acaban de crear, están inicialmene inactivos. Es decir, que no aparecerá en el selector de "Paneles" a la hora de crear una partida. Esto es así porque cuando creas un panel, es de esperar que quieras configurarlo a tu antojo, y por esa razón es necesario que lo revises antes de activarlo.<br\><br\>
									Puedes activar el panel <strong>desmarcando la casilla "Panel Inactivo" dentro de la "Modificación de un panel".</p>
								</section>

								<section class="toggle">
									<label>Hace tiempo que envié una petición al administrador, pero aún no he tenido respuesta a la misma, ¿a qué es debido?</label>
									<p>Bueno, antes que nada queremos que te quede claro que <strong>NO nos hemos olvidado de ti</strong>, si no han contestado tu petición, posiblemente es porque haya muchas que antender y éstas hayan llegado antes que la tuya. Te recordamos que hay un plazo de 7 días para contestar una petición. Si pasado ese tiempo, no se ha contestado, probablemente sea por carga de trabajo, pero es poco probable que esto pase, así que, verás como en breve, recibes la ayuda que buscas.</p>
								</section>


								
							</div>

						</div>

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
