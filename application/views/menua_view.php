<header id="header">
	<div class="container">
		<h1 class="logo">
			<a href="index.html">
				<img alt="LogoVirUCA" width="111" height="54" data-sticky-width="82" data-sticky-height="40" src="img/logo.png">
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
				<li><?=anchor(base_url().'index.php/alumno', 'Inicio')?></li>

				<li class="dropdown">
					<a class="dropdown-toggle" href="#">Mis datos
						<i class="icon icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><?=anchor(base_url().'index.php/alumno_datos', 'Mis datos')?></li>
					</ul>
				</li>

				<li class="dropdown">
					<a class="dropdown-toggle" href="#">
						Preguntas
						<i class="icon icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><?=anchor(base_url().'index.php/alumno_pregunta_listado', 'Mis preguntas')?></li>
						<li><?=anchor(base_url().'index.php/alumno_pregunta_alta', 'Alta de preguntas')?></li>
					</ul>
				</li>

				

				<li><?=anchor(base_url().'index.php/login/logout_ci', 'Salir')?></li>
								
				<li class="dropdown mega-menu-item mega-menu-shop">
					<a class="dropdown-toggle mobile-redirect" href="shop-cart.html">
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
											<tr><td><h3 style="text-align: center">
													Usuario conectado: <?=$this->session->userdata('username')?></h3>
												</td>
											</tr>
											<tr>
												<td class="actions" colspan="6">
													<div class="actions-continue">
													<?php
														$submit = array('name' => 'submit', 
															'value' => 'Cerrar sesión →', 
															'title' => 'Cerrar sesión', 
															'class' => 'btn pull-right btn-primary');
													?>
													<?=form_open(base_url().'index.php/login/logout_ci')?>
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