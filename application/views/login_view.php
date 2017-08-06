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
		<div role="main" class="main">
			<section class="page-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li><a href="#">Login</a></li>
                                    <li class="active">Acceder al sistema</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Acceder al sistema</h2>
                            </div>
                        </div>
                    </div>
                </section>
			<div class="container">
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
														<?=form_input($username)?>
														<p>
														<?=form_error('username','<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;
															</span>','</div>');?>

														</p>
														<label for="password">Contraseña:</label>
														<?=form_password($password)?>
														<p>
														<?=form_error('password','<div class="alert alert-danger"
														 	role="alert"><span class="glyphicon 
														 	glyphicon-exclamation-sign" aria-hidden="true">&nbsp;
														 	</span>','</div>');?>	
														 </p>
														<?=form_hidden('token',$token)?>
														<?=form_submit($submit)?>
															
														<?=form_close()?>
														
														<!-- Tratamiento de otros errores -->
											
											
														<?php 
														if($this->session->flashdata('usuario_incorrecto'))
														{
														?>
															<p><div class="alert alert-danger" role="alert">
															<span class="glyphicon glyphicon-exclamation-sign"aria-hidden="true">&nbsp;</span>
														 	<?=$this->session->flashdata('usuario_incorrecto')?>
														 	</div></p>
														<?php
														}
														if($this->session->flashdata('SESSION_ERR'))
														{
														?>
															<p><div class="alert alert-danger" role="alert">
															<span class="glyphicon glyphicon-exclamation-sign"aria-hidden="true">&nbsp;</span>
														 	<?=$this->session->flashdata('SESSION_ERR')?>
														 	</div></p>
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

			<?php $this->load->view('footer');?>
		</div>

		<!-- Libs -->
		<script src="<?=base_url()?>vendor/jquery.js"></script>
		

	</body>
</html>
