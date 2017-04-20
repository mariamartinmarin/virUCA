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
                                    <li><a href="#">Configuración</a></li>
                                    <li class="active">Accesos</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Accesos al Sistema</h2>
                            </div>
                        </div>
                    </div>
                </section>
               
                <div class="container">

                    <!-- Errores de inserción. -->
                     <?php if($this->session->flashdata('correcto')) { ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('correcto');?>
                        </div>
                    <?php } ?>

                    <?php if($this->session->flashdata('incorrecto')) { ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('incorrecto'); ?>
                        </div>
                    <?php } ?>
                    <!-- Fin errores -->

                    <!-- Listado -->

                    <?php if ($acceso != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de accesos al sistema');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>

                    <!-- Panel para búsquedas -->
                    <?=form_open(base_url().'index.php/accesos/buscar', $atributos);
                        $sBusqueda = array(
                        'name' => 'sBusqueda',
                        'id' => 'sBusqueda',
                        'style' => 'width:200px;',
                        'class' => 'form-control',
                        'value' => set_value('sBusqueda'),
                        'maxlength' => '512',
                        'placeholder' => '¿Qué buscamos?'
                        );
                        $submit = array(
                        'name' => 'submit',
                        'id' => 'submit',
                        'value' => 'Buscar',
                        'title' => 'Buscar',
                        'class' => 'btn btn-default' 
                        );
                        ?>
                        <div class="form-group">
                            <?=form_label('Búsqueda: ')?>
                            <?=form_input($sBusqueda);?>
                        </div>
                        <?=form_submit($submit);?>
                    <?=form_close()?>            
                    
                        
                    <br>
                    <!-- Fin del panel para búsquedas -->
                    
                    <?=form_open(base_url().'index.php/accesos/eliminar_todos/'.$npag);?>
                    
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Nombre completo</th>
                                <th>Fecha de conexión</th>
                                <th>IP</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($acceso as $fila){ 
                                $cont = 0; 
                                ?>

                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="acceso[]" value="<?=$fila->iId;?>">
                                    </span>
                                </th>
                                    
                                <td><?=$fila->sNombreCompleto;?></td>
                                <td><?=$fila->dFecha;?></td>
                                <td><?=$fila->sIP;?></td>   
                                <td>
                                    <a href="<?=base_url("index.php/accesos/eliminar/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-trash-o"></i></a>
                                    </span>
                                </td>
                                <?php
                                $cont++;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>

                    <input type="submit" class="btn btn-warning" value="Eliminar conjunto">
                    <br style="clear:both;">
                    <?php echo $this->pagination->create_links() ?>
                    <hr class="short">
                    
                    </div>

                    <?=form_close();?>
                    
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Actualmente no hay ninguna categoría activa.
                    </div>
                    <?php 
                    }
                    ?>


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

        <!-- Current Page JS -->
        <script src="<?=base_url()?>js/views/view.contact.js"></script>
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>

    </body>
</html>
