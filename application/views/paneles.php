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

        <!-- Custom Loader -->
        <link rel="stylesheet" href="<?=base_url()?>css/loader.css">

        <!-- Libs -->
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        
       
        <!-- Current Page JS -->
        <script src="<?=base_url()?>js/views/view.contact.js"></script>
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>


        <!-- Head Libs -->
        <script src="<?=base_url()?>vendor/modernizr.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/busquedasimple.js"></script>
        <script type="text/javascript"> 
            $(window).load(function() { $(".loader").fadeOut("slow");});
        </script>

        <!--[if IE]>
            <link rel="stylesheet" href="css/ie.css">
        <![endif]-->

        <!--[if lte IE 8]>
            <script src="vendor/respond.js"></script>
        <![endif]-->


    </head>
    <body>
    <div id="preloader">
        <div id="loader">&nbsp;</div>
    </div>

        <div class="body">
            <?php $this->load->view('menup_view');?>
            <div role="main" class="main">

                <section class="page-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li><a href="#">Paneles</a></li>
                                    <li class="active">Listado</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Listado de paneles</h2>
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
                    <?php if ($paneles != "" && $categorias != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de paneles');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>
                    <blockquote>
                        Desde aquí, podrá crear <b>paneles de juego</b>. Una vez creado el panel, éste se creará con una serie de casillas, especificadas previamente, por defecto, por lo que se aconseja personalizar el panel una vez creado.
                    </blockquote>
                    
                    <?=form_open(base_url().'index.php/paneles/eliminar_todos/'.$npag);?>
                    <div class="input-group">
                        <span class="input-group-addon">Buscar</span>
                        <input id="filtrar" type="text" class="form-control" placeholder="Buscar en esta página">
                    </div>
                    <hr class="short">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                        </div>

                        
                        <table class="table table-bordered table-striped" id="table_preguntas">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Nombre</th>
                                <th>Casillas</th>
                                <th>Activo</th>
                                <th>Propietario</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody class="buscar">
                                <?php 
                                foreach($paneles as $fila){                                 
                                ?>

                                <tr><th>
                                    <?php if ($fila->bEliminar == 1) { ?>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="panel[]" value="<?=$fila->iId;?>">
                                    </span>
                                    <?php } ?>
                                </th>
                                    
                                <td><?=$fila->nombrePanel;?></td>
                                <td>
                                <?=$fila->iCasillas;?>
                                </td>
                                
                                <td>
                                <?php
                                    if ($fila->bActivo)
                                        echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
                                    else
                                        echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                                ?>    
                                </td>
                                <td>
                                    <span class="label label-warning"><?=$fila->sNombre.", ".$fila->sApellidos;?></span>
                                </td>
                                <td>
                                    <?php if ($fila->bEliminar == 1) { ?>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?=base_url("index.php/paneles/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-pencil"></i></a>
                                </td>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>

                    <input type="submit" class="btn btn-warning" value="Eliminar conjunto">
                    <input type="button" class="btn btn-warning" value="Dar de alta" onclick="location.href='<?=base_url()?>index.php/panelesalta'">
                    <br style="clear:both;">
                    <?php echo $this->pagination->create_links() ?>
                    <hr class="short">
                    
                    

                    <?=form_close();?>
                    
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Actualmente no hay ningún panel en el sistema, por lo que no podrá iniciar partida.
                    </div>
                    <?php 
                    }
                    ?>

                    <!-- Fin del listado -->

                </div>
            </div>
            <?php $this->load->view('footer');?>
        </div>

        <script src="<?=base_url()?>vendor/jquery.appear.js"></script>
        <script src="<?=base_url()?>vendor/jquery.easing.js"></script>
        <script src="<?=base_url()?>vendor/jquery.cookie.js"></script>
        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        
        <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
            $('body').css({'overflow':'visible'});
        })
        </script>

        <!-- BOOT BOX -->
        <script src="<?=base_url()?>js/bootbox/boot.activate.js"></script>
        <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>
        
        <script type="text/javascript">
        bootbox.setDefaults({
          locale: "es"
        });
        $(function() {
            var cajas = {};

            $(document).on("click", "a[data-bb]", function(e) {
                e.preventDefault();
                var type = $(this).data("bb");
                var id = $(this).data("id");
                var pg = $(this).data("pg");
                if (typeof cajas[type] === 'function') {
                    cajas[type](id, pg);
                }
            });

            cajas.confirm = function(id, pg) {
                bootbox.confirm("¿Estás seguro que quieres borrar el panel de juego?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/paneles/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->
        
    </body>
</html>
