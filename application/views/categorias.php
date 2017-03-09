<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
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
            <?php $this->load->view('menup_view');?>
            <div role="main" class="main">

                <section class="page-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li><a href="#">Partidas</a></li>
                                    <li class="active">Gestión de Categorías</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Categorías</h2>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container">

                    <?php 
                        if($this->session->flashdata('correcto')) { 
                    ?>
                    <div class="alert alert-success">
                    <?php
                       echo $this->session->flashdata('correcto');
                    ?>
                    </div>
                    <?php } ?>

                    <?php 
                        if($this->session->flashdata('incorrecto')) { 
                    ?>
                    <div class="alert alert-danger">
                    <?php
                        echo $this->session->flashdata('incorrecto');
                    ?>
                    </div>
                    <?php } ?>


                    <?=form_open(base_url().'index.php/categorias/nueva');
                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control input-lg',
                    'value' => set_value('sNombre'),
                    'style' => 'width:400px;'
                    );
                    $sDescripcion = array(
                    'name' => 'sDescripcion',
                    'id' => 'sDescripcion',
                    'size' => '50',
                    'class' => 'form-control input-lg',
                    'value' => set_value('sDescripcion'),
                    'style' => 'width:400px; height:100px;'
                    );
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <?=form_fieldset('Añadir una nueva categoría');?>

                    <label for="sNombre">Nombre:</label>
                    <?=form_input($sNombre)?><p><?=form_error('sNombre')?></p>
                    <label for="sDescripcion">Descripción:</label>
                    <?=form_textarea($sDescripcion)?><p><?=form_error('sDescripcion')?></p>
                    <?=form_submit($submit)?>
                    <?=form_close()?>

                    
                    <?=form_fieldset_close();?>

                    <hr class="short">
                    <?php echo form_fieldset('Listado');?>
                    <?php foreach($ver as $fila){ ?>

                        <div class="row show-grid">
                        <div class="col-md-1"><span class="show-grid-block"><?=$fila->iId;?></span></div>
                        <div class="col-md-3"><span class="show-grid-block"><?=$fila->sNombre;?></span></div>
                        <div class="col-md-5"><span class="show-grid-block"><?=$fila->sDescripcion;?></span></div>
                        <div class="col-md-3"><span class="show-grid-block">
                            <a href="<?=base_url("index.php/categorias/mod/$fila->iId")?>" class="btn btn-warning">Modificar</a>
                            <a href="<?=base_url("index.php/categorias/eliminar/$fila->iId")?>" class="btn btn-warning">Eliminar</a>
                        </span></div>
                        </div>
                    <?php
                    }
                    ?>

                    <hr class="short">


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
