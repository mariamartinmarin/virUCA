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
        <script type="text/javascript" src="<?=base_url()?>js/tablesorter/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/busquedasimple.js"></script>
        <script type="text/javascript">
            $(document).ready(function() { 
                $("#table_partidas").tablesorter( {sortList: [[1,0], [3,0]]} ); 
            }); 
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
                                    <li><a href="#">Partidas</a></li>
                                    <li class="active">Listado</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Listado de partidas (activas y no activas)</h2>
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
                    <blockquote>
                        Modifica los parámetros de las partidas, pero recuerda que sólo podrás hacerlo con aquellas partidas que no hayan empezado aún. En partidas ya acabadas o que estén empezadas (y no finalizadas) no se podrán modificar ninguno de los parámetros.
                    </blockquote>
                    
                    
                    <?php if ($partida != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de partidas');?>
                    
                    <?=form_open(base_url().'index.php/partidas/eliminar_todos/'.$npag);?>
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

                        
                        <table class="table table-bordered table-striped" id="table_partidas">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Fecha</th>
                                <th>Nº Grupos</th>
                                <th>Panel</th>
                                <th>Curso</th>
                                <th>Profesor</th>
                                <th>Finalizada</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody class="buscar">
                                <?php foreach($partida as $fila){ ?>

                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="partida[]" value="<?=$fila->iId;?>">
                                    </span>
                                </th>
                                <td><?=$fila->dFecha;?></td>
                                <td><?=$fila->nGrupos;?></td>    
                                <td><?=$fila->nombrePanel;?></td>
                                <td><?=$fila->nombreCurso;?></td>
                                <td><?=$fila->nombreProfesor;?></td>
                                <td>
                                <?php
                                    if ($fila->bFinalizada)
                                        echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
                                    else
                                        echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                                ?>    
                                </td>
                                
                                <td>

                                    <a href="#" 
                                        title="Eliminar"
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <?php if (!$fila->bFinalizada && !$fila->bEmpezada) { ?>
                                    <a title="Modificar" href="<?=base_url("index.php/partidas/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-pencil"></i></a>
                                    <?php } ?>

                                    <?php if (!$fila->bFinalizada) { ?>
                                    <a title="Empezar/Reanudar" 
                                        href="<?=base_url("index.php/jugar/$fila->iId/$fila->iId_Partida")?>" 
                                        class="btn-group-xs"><i class="icon icon-play"></i></a>
                                    <?php } else { ?>
                                    <a title="Ver clasificación" 
                                        href="<?=base_url("index.php/jugar/$fila->iId/$fila->iId_Partida")?>" 
                                        class="btn-group-xs"><i class="icon icon-eye"></i></a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>

                    <input type="submit" class="btn btn-warning" value="Eliminar conjunto">
                    <input type="button" class="btn btn-warning" value="Nueva partida" onclick="location.href='<?=base_url()?>index.php/partida'">
                    <br style="clear:both;">
                    <?php echo $this->pagination->create_links() ?>
                    <hr class="short">
                    
                    

                    <?=form_close();?>
                    
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Actualmente no hay ninguna <b>partida</b> en el sistema.
                    </div>

                    <input type="button" class="btn btn-warning" value="Crear Partida" onclick="location.href='<?=base_url()?>index.php/partida'">
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
                bootbox.confirm("Si eliminamos la partida, se eliminará el progreso de la misma, así como cualquier rastro de esta en el sistema. ¿Estás seguro que quieres borrar la partida?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/partidas/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->
        
    </body>
</html>
