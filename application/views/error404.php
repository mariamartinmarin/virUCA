<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>

		<!-- Basic -->
        <meta charset="utf-8">
        <title><?=$titulo; ?></title>       
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
			

			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						
						<div class="row">
							<div class="col-md-12">
								<h2>VirUCA. Página no encontrada</h2>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

					<section class="page-not-found">
						<div class="row">
							<div class="col-md-5 col-md-offset-1">
								<div class="page-not-found-main">
								<img alt="WebNODisponible" src="<?=base_url()?>assets/img/virus_inactiva.png" width="390">
								
								</div>
							</div>
							<div class="col-md-6">
								<blockquote><b>Oops! página no encontrada.</b><br>El recurso que busca no está disponible en estos momentos. Si considera que esta información debería estar visible, contacte con el administrador del sitio para solucionar el problema tan pronto como sea posinle.<br><br>Perdone las molestias que este inconveniente haya podido causarle.</blockquote>
								<hr>
								<blockquote>
									<b>Mientras tanto puede acceder a ...</b>
									<ul>
										<li><a href="<?=base_url()?>">Página de inicio</a></li>
										<!--<li><a href="<?=base_url()?>index.php/faqs">FAQ'S</a></li>
										<li><a href="<?=base_url()?>index.php/help">Ayuda</a></li>-->
									</ul>
								</blockquote>
   							</div>
						</div>
					</section>

				</div>

			</div>

			<?php $this->load->view('footer_login');?>
		</div>

		
	</body>
</html>
