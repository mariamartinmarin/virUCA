<header id="header">

	<div class="container">
		<h1 class="logo">
			<a href="<?=base_url()?>">
				<img alt="LogoVirUCA" width="111" height="54" data-sticky-width="82" data-sticky-height="40" 
					src="<?=base_url()?>assets/img/logo_viruca.jpg">
			</a>
		</h1>
															
		<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
			<i class="icon icon-bars"></i>
		</button>
	</div>

	<div class="navbar-collapse nav-main-collapse collapse">
		<div class="container">
			<nav class="nav-main mega-menu">
				<ul class="nav nav-pills nav-main" id="mainMenu">
					<li><?=anchor(base_url().'index.php/profesor', 'Inicio')?></li>

					<li class="dropdown">
						<a class="dropdown-toggle" href="#">Profesores<i class="icon icon-angle-down"></i></a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/usuarios', 'Gestión de Profesores')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a class="dropdown-toggle" href="#">Alumnos
							<i class="icon icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/alumnos', 'Gestión de Alumnos')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a class="dropdown-toggle" href="#">Curso
							<i class="icon icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/titulacion', 'Gestión de Titulaciones')?></li>
							<li><?=anchor(base_url().'index.php/asignatura', 'Gestión de Asignaturas')?></li>
							<li><?=anchor(base_url().'index.php/curso', 'Gestión de curso académico')?></li>
						</ul>
					</li>

					<li class="dropdown">
						<a class="dropdown-toggle" href="#">
							Preguntas<i class="icon icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/categorias', 'Gestionar categorías')?></li>
							<li><?=anchor(base_url().'index.php/preguntas', 'Listado de preguntas')?></li>
							<li><?=anchor(base_url().'index.php/preguntasalta', 'Alta de pregunta')?></li>
						</ul>
					</li>
					
					<li class="dropdown">
						<a class="dropdown-toggle" href="#">
							Partidas<i class="icon icon-angle-down"></i>
						</a>
					
						<ul class="dropdown-menu">
							<li class="dropdown-submenu">
								<a href="#">Paneles</a>
								<ul class="dropdown-menu">
									<li><?=anchor(base_url().'index.php/panelesalta', 'Crear Panel')?></li>
									<li><?=anchor(base_url().'index.php/paneles', 'Listado de Paneles')?></li>
								</ul>
							</li>
							<li><?=anchor(base_url().'index.php/partida', 'Crear Partida')?></li>
							<li><?=anchor(base_url().'index.php/partidas', 'Listado de Partidas')?></li>
						</ul>
						
					</li>				
				
					<li class="dropdown">
						<a class="dropdown-toggle" href="#">Configuración<i class="icon icon-angle-down"></i></a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/parametros', 'Parametros')?></li>
							<li><?=anchor(base_url().'index.php/accesos', 'Accesos')?></li>
						</ul>
					</li>

					<li><?=anchor(base_url().'index.php/login/logout_ci', 'Salir')?></li>
								
					<li class="dropdown mega-menu-item mega-menu-shop">
						<a class="dropdown-toggle mobile-redirect" href="#">
							<i class="icon icon-user"></i> Datos de la sesión
							<i class="icon icon-angle-down"></i>
						</a>

						<ul class="dropdown-menu">
							<li>
								<div class="mega-menu-content">
									<div class="row">
										<div class="col-md-12">
											<table cellspacing="0" class="cart">
											<tbody>
												<tr><td>
													<b>Usuario: <?=$this->session->userdata('username')?></b>
												</td></tr>
											
												<tr>
													<td class="actions" colspan="6">
														<div class="actions-continue">
														<?php
															$misDatos_url = "location.href='".base_url()."index.php/datosprofesor'";
															$misDatos = array('name' => 'misDatos',
															'value' => 'Mis Datos',
															'title' => 'Mis Datos',
															'class' => 'btn btn-primary',
															'content' => 'Mis Datos',
															'onclick' => $misDatos_url);

															$submit = array('name' => 'submit', 
															'value' => 'Cerrar sesión →', 
															'title' => 'Cerrar sesión', 
															'class' => 'btn pull-right btn-primary');
														?>
														<?=form_open(base_url().'index.php/login/logout_ci')?>
														<?=form_button($misDatos);?>
														<?=form_submit($submit)?>
														<?=form_close()?>
														</div>
													</td>
												</tr>
											</tbody>
											</table>
			
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>