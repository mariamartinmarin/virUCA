<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
    <head>

        <!-- Basic -->
        <meta charset="utf-8">
        <title><?=$titulo?></title>       
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
         <style type="text/css">
            .error{
            color: red !important;
            }
        </style>
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
                                <li><a href="#">Profesores</a></li>
                                <li class="active"><?=$titulo;?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2><?=$titulo?></h2>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container">
                <!-- Errores de inserción. -->
                <?php if($this->session->flashdata('profesor_ok')) { ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('profesor_ok');?>
                    </div>
                <?php } ?>

                <?php if($this->session->flashdata('profesor_ko')) { ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('profesor_ko'); ?>
                    </div>
                <?php } ?>
                <!-- Fin errores -->

                <?php echo form_fieldset('Modificar los datos de un profesor');?>
                 <?=form_open(base_url().'index.php/DatosProfesor/mod');?>
                <?php    
                    foreach ($verProfesor as $fila){ 
                    $tipo_usuario = 0;
                    echo form_hidden('iPerfil',$tipo_usuario);
                    echo form_hidden('iId',$iId = $this->session->userdata('id_usuario'));
                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sNombre,
                    'maxlength' => '100'
                    );

                    $sApellidos = array(
                    'name' => 'sApellidos',
                    'id' => 'sApellidos',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sApellidos
                    );

                    $sEmail = array(
                    'name' => 'sEmail',
                    'id' => 'sEmail',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sEmail
                    );

                    $sUsuario = array(
                    'name' => 'sUsuario',
                    'id' => 'sUsuario',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sUsuario
                    );
                    $sPassword_now = array(
                    'name' => 'sPassword_now',
                    'id' => 'sPassword_now',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => ''
                    );
                    $sPassword_new = array(
                    'name' => 'sPassword_new',
                    'id' => 'sPassword_new',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => ''
                    );
                    $sPassword_new_confirm = array(
                    'name' => 'sPassword_new_confirm',
                    'id' => 'sPassword_new_confirm',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => ''
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Modificar mis datos',
                    'title' => 'Modificar mis datos',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                               <blockquote>
                                   Por razones de seguridad, la contraseña no se muestra por pantalla. Si necesita cambiarla y no se acuerda de la contraseña, contacte con el administrador del sitio para solucionar el problema a la mayor brevedad.
                               </blockquote>
                            </div>
                        </div>
                    </div>

                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Nombre *</label>
                                <?=form_input($sNombre)?>
                                <?=form_error('sNombre','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <label>Apellidos *</label>
                                <?=form_input($sApellidos)?>
                                <?=form_error('sApellidos', '<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Usuario *</label>
                                <?=form_input($sUsuario)?>
                                <?=form_error('sUsuario','<div class= "error">','</div>');?>
                            </div>
                           
                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Constraseña actual</label>
                                <?=form_input($sPassword_now)?>
                                <?=form_error('sPassword_now','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-4">
                                <label>Nueva constraseña </label>
                                <?=form_input($sPassword_new)?>
                                <?=form_error('sPassword_new','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-4">
                                <label>Confirmar nueva contraseña</label>
                                <?=form_input($sPassword_new_confirm)?>
                                <?=form_error('sPassword_new_confirm','<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>E-mail</label>
                                <?=form_input($sEmail)?>
                                <?=form_error('sEmail','<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>  

                                         
                    <?=form_submit($submit)?>
                    <!-- Fin campos formulario -->
                   
                <?php } ?>
                </form>
                <?=form_fieldset_close();?>
                <hr>
                <a href="<?=base_url()."index.php/usuarios"?>" class="btn btn-warning">Volver</a>
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






