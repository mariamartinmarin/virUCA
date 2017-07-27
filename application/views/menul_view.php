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
					<li><?=anchor(base_url().'index.php/alumno', 'Inicio')?></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#">Ayuda
							<i class="icon icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><?=anchor(base_url().'index.php/contacto', 'Contacto')?></li>
							<li><?=anchor(base_url().'index.php/faqs', 'FAQS')?></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>