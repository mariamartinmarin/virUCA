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
                                <li><a href="#">Preguntas</a></li>
                                <li class="active">Listado</li>
                            </ul>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Modificación de los parámetros de la partida.</h2>
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

                <?php echo form_fieldset('Modificar partida');?>

                <blockquote>
                    Puedes modificar el número de grupos que conforman la partida, el panel que se va a usar durante la partida y el curso académico al que pertenece el panel. Pero recuerda, que una vez que de comienzo la partida, no se podrán eliminar ninguno de estos parámetros.
                </blockquote>

                <form action="" method="POST">
                <?php    
                    foreach ($mod as $fila){ 
                    
                    $nGrupos = array(
                    'name' => 'nGrupos',
                    'id' => 'nGrupos',
                    'style' => 'width:100px;',
                    'class' => 'form-control',
                    'value' => $fila->nGrupos,
                    'maxlength' => '2'
                    );
 
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Guardar Panel',
                    'title' => 'Guardar Panel',
                    'class' => 'btn btn-default' 
                    );

                    ?>

                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>Grupos *</label>
                                <?=form_input($nGrupos)?>
                                <?=form_error('nGrupos','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-5">
                                <?=form_label('Panel * '); ?>
                                <select name="iPanel" class="form-control">
                                <?php
                                    foreach ($paneles as $i => $panel) 
                                        if ($i == $fila->iId_Panel)
                                            echo "<option value='".$i."' selected>".$panel."</option>";
                                        else
                                            echo "<option value='".$i."'>".$panel."</option>";   
                                ?>
                                </select>
                            </div>

                            <div class="col-md-5">
                                <?=form_label('Curso académico * '); ?>
                                <select name="iCurso" class="form-control">
                                <?php
                                    foreach ($cursos as $i => $curso) 
                                        if ($i == $fila->iId_Curso)
                                            echo "<option value='".$i."' selected>".$curso."</option>";
                                        else
                                            echo "<option value='".$i."'>".$curso."</option>";   
                                ?>
                                </select>
                            </div>

                        </div>
                    </div>

                
                    

                    <?=form_submit($submit)?>
                    <!-- Fin campos formulario -->
                   
                <?php } ?>
                </form>
                <?=form_fieldset_close();?>
                <hr>
                <a href="<?=base_url()."index.php/partidas"?>" class="btn btn-warning">Listado</a>
                <a href="<?=base_url()."index.php/partida"?>" class="btn btn-warning">Dar de alta</a>
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






