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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="#">Configuración</a></li>
                            <li class="active"><strong>Parámetros de Configuración de la Aplicación</strong></li>
                        </ul>
                    </div>
                </div>
                </div>

            <div class="container">
                
                <!-- Errores de inserción. -->
                <?php if($this->session->flashdata('parametros_ok')) { ?>
                <div class="alert alert-success">
                     <?php echo $this->session->flashdata('parametros_ok');?>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('parametros_ko')) { ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('parametros_ko'); ?>
                    </div>
                <?php } ?>
                <!-- Fin errores -->

                <?=form_open(base_url().'index.php/parametros/mod');?>
                <?php foreach ($parametros as $fila){ 
                    $iActiva = array(
                    'name' => 'iActiva',
                    'id' => 'iActiva',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->iActiva
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Activar cambios',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <!-- Campos del formulario -->
                    <?php echo form_fieldset('Activar / Desactivar aplicación');?>
                
                    <div class="row">
                        <div class="col-md-12">
                            <span class="show-grid-block">
                            <?php if ($fila->iActiva == 1) { ?>
                                <blockquote>
                                    En estos momentos la aplicación se encuentra <b>ACTIVA</b>, esto quiere decir
                                    que los alumnos podrán introducir preguntas y trabajar con la plataforma con
                                    total normalidad.
                                    Para hacer la aplicación <b>INACCESIBLE TEMPORALMENTE</b> para los alumnos, 
                                    desmarque el <i>checkbox</i> y guarde los cambios.                        
                                </blockquote>
                                <input type="checkbox" checked="true" name="iActiva[]" value="1">
                            <?php } else { ?>
                                <blockquote>
                                    En estos momentos la aplicación se encuentra <b>INACTIVA</b>, esto quiere decir que los alumnos no podrán introducir preguntas ni registrarse en la 
                                    plataforma.
                                    Para cambiar esta situación y que la aplicación sea accesible para todo el
                                    mundo, marque el <i>checkbox</i> y guarde los cambios.
                                </blockquote>
                                
                                <input type="checkbox" name="iActiva[]" value="0">
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <?php echo form_fieldset('Activar / Desactivar edición de preguntas (alumnos)');?>
                
                    <div class="row">
                        <div class="col-md-12">
                            <span class="show-grid-block">
                            <?php if ($fila->iEdicion == 1) { ?>
                                <blockquote>
                                    En estos momentos, los alumnos pueden modificar las preguntas que han introducido en el sistema con total normalidad. Para deshacer esta eventualidad y que los alumnos <b>NO PUEDAN MODIFICA LAS PREGUNTAS</b>, desmarque el <i>checkbox</i> y guarde los cambios.
                                </blockquote>
                                <input type="checkbox" checked="true" name="iEdicion[]" value="1">
                            <?php } else { ?>
                                <blockquote>
                                    En estos momentos, los alumnos no pueden modificar las preguntas que han introducido. Para deshacerlo y que puedan volver a hacerlo, marque el <i>checkbox</i> y guarde los cambios.
                                </blockquote>
                                <input type="checkbox" name="iEdicion[]" value="0">
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                    <?=form_submit($submit)?>
                    <!-- Fin campos formulario -->
                   
                    <?php } ?>
                </form>
                <?=form_fieldset_close();?>
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






