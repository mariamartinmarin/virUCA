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
                                <li><a href="#">Preguntas</a></li>
                                <li class="active">Alta de Preguntas</li>
                            </ul>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Alta de pregunta</h2>
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

                <?php echo form_fieldset('Modificar pregunta');?>
                <form action="" method="POST">
                <?php    
                    foreach ($mod as $fila){ 
                    echo form_hidden('iId_Usuario', $this->session->userdata('id_usuario'));
                    
                    $nPuntuacion = array(
                    'name' => 'nPuntuacion',
                    'id' => 'nPuntuacion',
                    'style' => 'width:100px;',
                    'class' => 'form-control',
                    'value' => $fila->nPuntuacion,
                    'maxlength' => '20'
                    );

                     $sPregunta = array(
                    'name' => 'sPregunta',
                    'id' => 'sPregunta',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sPregunta,
                    'maxlength' => '512'
                    );

                    $cont = 1;
                    foreach ($respuestas as $r) {
                    
                        ${"sResp".$cont} = array(
                        'name' => "sResp".$cont,
                        'id' => "sResp".$cont,
                        'size' => '50',
                        'class' => 'form-control',
                        'value' => $r->sRespuesta,
                        'maxlength' => '512');

                        ${"bVerdadera".$cont} = array(
                            'id' => $cont,
                            'name' => 'verdadera',
                            'value' => $cont,
                            'checked' => $r->bVerdadera
                        );
                        $cont++;
                    }

                    $sObservaciones = array(
                    'name' => 'sObservaciones',
                    'id' => 'sObservaciones',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sObservaciones,
                    'style' => 'width:400px; height:80px;'
                    );

                    $bActiva = array(
                    'name' => 'bActiva',
                    'id' => 'bActiva',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->bActiva
                    );
 
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );

                    ?>

                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Pregunta *</label>
                                <?=form_input($sPregunta)?>
                                <?=form_error('sPregunta','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <?=form_label('Categorías: '); ?>
                                <select name="iCategoria" class="form-control" style="width:400px;">
                                <?php
                                    foreach ($categorias as $i => $categoria) 
                                        if ($i == $fila->iId_Categoria)
                                            echo "<option value='".$i."' selected>".$categoria."</option>";
                                        else
                                            echo "<option value='".$i."'>".$categoria."</option>";   
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Respuesta A *</label>
                                <?=form_input($sResp1)?>
                                <?=form_error('sResp1','<div class= "error">','</div>');?>
                                <label>Respuesta B *</label>
                                <?=form_input($sResp2)?>
                                <?=form_error('sResp2','<div class= "error">','</div>');?>
                                <label>Respuesta C *</label>
                                <?=form_input($sResp3)?>
                                <?=form_error('sResp3','<div class= "error">','</div>');?>
                                <label>Respuesta D *</label>
                                <?=form_input($sResp4)?>
                                <?=form_error('sResp4','<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                               
                            <div class="col-md-6">
                                <label><b>¿Cuál es la respuesta verdadera?</b></label><br> 
                                <?php 
                                echo form_radio($bVerdadera1)." Respuesta A "." | ".
                                        form_radio($bVerdadera2)." Respuesta B"." | ".
                                        form_radio($bVerdadera3)." Respuesta C"." | ".
                                        form_radio($bVerdadera4)." Respuesta D";
                                form_error('rResp4','<div class= "error">','</div>');?>
                            </div>

                            </div>
                    </div>   

                    <div class="row">
                        <div class="form-group">
                               
                            <div class="col-md-6">
                                <label><b>Observaciones</b></label><br> 
                                <?php 
                                echo form_textarea($sObservaciones); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="bActiva[]"><b>¿Activar pregunta?</b></label>
                                <?php if ($fila->bActiva == 1) { ?>
                                <div class="alert alert-success">
                                    <p>La pregunta está activa y puede aparecer en el juego.</p>
                                </div>
                                <input type="checkbox" checked="true" name="bActiva[]" value="1">
                                
                                <?php } else { ?>
                                
                                <div class="alert alert-danger">
                                    <p>La pregunta está inactiva y no aparecerá en el juego.</p>
                                </div>
                                <input type="checkbox" name="bActiva[]" value="0">
                                <?php } ?>
                                <!-- -->
                            </div>
                            <div class="col-md-6">
                                <label><b>Puntuar pregunta [0-10]</b></label>
                                <?=form_input($nPuntuacion)?>
                                <?=form_error('nPuntuacion','<div class= "error">','</div>');?>
                                
                            </div>
                        </div>
                    </div>

                    <?=form_submit($submit)?>
                    <!-- Fin campos formulario -->
                   
                <?php } ?>
                </form>
                <?=form_fieldset_close();?>
                <hr>
                <a href="<?=base_url()."index.php/preguntas"?>" class="btn btn-warning">Listado</a>
                <a href="<?=base_url()."index.php/preguntasalta"?>" class="btn btn-warning">Dar de alta</a>
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






