<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/960.css" media="screen" />
		 <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/text.css" media="screen" />
		 <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css" media="screen" />
		 <style type="text/css">
		 	h1{
		 		font-size: 22px;
		 		text-align: center;
		 		margin: 20px 0px;
		 	}
		 	#login{
		 		background: #fefefe;
		 		min-height: 500px;
		 	}
		 	#formulario_login{
		 		font-size: 14px;
		 		border: 2px solid #aaa;		 		
		 	}
		 	label{
		 		display: block;
		 		font-size: 12px;
		 		color: #aaa;
		 		font-weight: bold;
		 	}
		 	input[type=text],input[type=password]{
		 		padding: 10px 6px;
		 		width: 400px;
		 	}
		 	input[type=submit]{
		 		margin-top: 10px;
		 		padding: 5px 40px;
		 		background: #fde765;
		 		color: #000;
		 	}
		 	#campos_login{
		 		margin: 50px 0px;
		 	}
		 	p{
		 		color: #f00;
		 		font-weight: bold;
		 	}
		 </style>
	</head>
	<body>
	<?php
	$username = array('name' => 'username', 'placeholder' => 'nombre de usuario');
	$password = array('name' => 'password',	'placeholder' => 'introduce tu password');
	$submit = array('name' => 'submit', 'value' => 'Acceder', 'title' => 'Acceder');
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
	</body>
</html>