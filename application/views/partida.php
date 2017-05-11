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
                                    <li><a href="#">Partida</a></li>
                                    <li class="active">Crear una nueva partida</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Empezar partida</h2>
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

                    <?php if ($cursos != "" && $paneles != "") { ?>

                    <blockquote>
                        Vamos a empezar una nueva partida de <b>VirUCA</b>, pero antes debemos saber cuántos grupos se han organizado para poder organizar los turnos del juego. Recuerda que este valor, ya no podrá cambiar una vez que la partida empiece. Además, también necesito saber a qué curso vamos a 
                    </blockquote>
                    

                    <?=form_open(base_url().'index.php/partida/nueva');
                    $nGrupos = array(
                    'name' => 'nGrupos',
                    'id' => 'nGrupos',
                    'size' => '50',
                    'class' => 'form-control',
                    'style' => 'width:100px;',
                    'value' => set_value('nGrupos') 
                    );

                    $sCursos = array(
                    'name' => 'sCursos',
                    'id' => 'sCursos',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sCursos') 
                    );

                    $sPaneles = array(
                    'name' => 'sPaneles',
                    'id' => 'sPaneles',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sPaneles') 
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Empezar partida!',
                    'title' => 'Empezar partida!',
                    'class' => 'btn btn-default'
                    );
                    ?>

                    <?=form_fieldset('Empezar nueva partida');?>

                    <div class="row">
                    <div class="form-group">
                    <div class="col-md-6">
                        <label for="nGrupos">¿Cuántos grupos se han organizado?</label>
                        <?=form_input($nGrupos)?>
                        <?=form_error('nGrupos','<br><div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>',
                            '</div>');?>
                    </div>
                    <div class="col-md-6">                            
                        <?=form_label('Curso: '); ?>
                        <?=form_dropdown('sCursos', $cursos, '', 'class=form-control input-lg'); ?><br>
                    </div>

                    </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <?=form_label('Seleccione un panel: '); ?>
                                <?=form_dropdown('sPaneles', $paneles, '', 'class=form-control input-lg'); ?><br>
                                <?=form_submit($submit)?>
                            </div>
                        </div>
                    </div>
                        

                    <?=form_close()?>
                    <?=form_fieldset_close();?>

                    <?php
                    } else {
                    ?>
                    <div class="alert alert-success">
                    Lo sentimos!! Asegúrate que en el sistema existe al menos un <b>curso académico</b> y un panel de juego activo, si no es así, no podremos empezar la partida
                    </div>
                    <?php
                    $gCursos = array(
                    'name' => 'gCursos',
                    'id' => 'gCursos',
                    'value' => 'Gestionar cursos académicos',
                    'class' => 'btn btn-default'
                    );
                    ?>
                    <?=form_open(base_url().'index.php/curso');?>
                    <?=form_submit($gCursos);?>
                    <?=form_close()?>
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
        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        <script src="<?=base_url()?>vendor/jquery.gmap.js"></script>
        <script src="<?=base_url()?>vendor/isotope/jquery.isotope.js"></script>
        <script src="<?=base_url()?>vendor/magnific-popup/magnific-popup.js"></script>
        <script src="<?=base_url()?>vendor/mediaelement/mediaelement-and-player.js"></script>
        
        <!-- Theme Initializer -->
        <script src="<?=base_url()?>js/theme.plugins.js"></script>
        <script src="<?=base_url()?>js/theme.js"></script>
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>

    </body>
</html>
