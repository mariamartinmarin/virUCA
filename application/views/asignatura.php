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

        <!-- Custom Loader -->
        <link rel="stylesheet" href="<?=base_url()?>css/loader.css">

        <!-- Responsive CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/theme-responsive.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/skins/default.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/custom.css">

        <!-- Head Libs -->
        <script src="<?=base_url()?>vendor/modernizr.js"></script>
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/tablesorter/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/busquedasimple.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            { 
                $("#table_asignaturas").tablesorter({sortList: [[1,0], [2,0]]} ); 
            } 
            );
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
                                    <li><a href="#">Curso</a></li>
                                    <li class="active">Gestión de Asignaturas</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Asignaturas</h2>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container">

                    <!-- Zona de errores -->
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
                    <!-- Fin zona de errores -->

                    <!-- Listado -->
                    <?php if ($asignatura != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de asignaturas');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>
                    <blockquote>
                        Administrar las diferentes asignaturas. Dichas asignaturas estarán obligatoriamente asociadas a una titulación.
                    </blockquote>
                    
                    <?=form_open(base_url().'index.php/asignatura/eliminar_todos/'.$npag);?>
                    
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                        </div>
                        <table class="table table-bordered table-striped" id="table_asignaturas">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Asignatura</th>
                                <th>Titulación</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($asignatura as $fila){ 
                                $cont = 0; 
                                ?>

                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="asignatura[]" value="<?=$fila->iId;?>">
                                    </span>
                                </th>
                                    
                                <td><?=$fila->sNombre;?></td>
                                <td><?=$fila->sTitulacion;?></td>   
                                <td>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <a href="<?=base_url("index.php/asignatura/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-pencil"></i></a>
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
                    
                    

                    <?=form_close();?>
                    
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Actualmente no hay ningún profesor en el sistema.
                    </div>
                    <?php 
                    }
                    ?>

                    <!-- Fin del listado -->

                    <?php if ($titulaciones != "") { ?>

                    <?=form_open(base_url().'index.php/asignatura/nueva');
                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sNombre') 
                    );

                    $sTitulaciones = array(
                    'name' => 'sTitulaciones',
                    'id' => 'sTitulaciones',
                    'size' => '50',
                    'class' => 'form-control input-lg',
                    'value' => set_value('sTitulaciones') 
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default'
                    );
                    ?>

                    <?php
                    echo form_fieldset('Añadir una nueva asignatura');
                    ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <?=form_label('Asignatura: '); ?>
                                <?=form_input($sNombre)?>
                                <?=form_error('sNombre','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                            <div class="col-md-6">                            
                                <?=form_label('Titulación: '); ?>
                                <?=form_dropdown('sTitulaciones', $titulaciones, '', 'class=form-control input-lg'); ?>
                                <?=form_error('sApellidos', '<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>
                    <?=form_submit($submit)?>
                    <?=form_close()?>

                   
                    <?php
                        echo form_fieldset_close();
                    ?>

                    <?php } else { ?>
                        <div class="alert alert-success">
                            Actualmente no hay ninguna <b>Titulación</b> dada de alta en el sistema. Para poder dar de alta una asignatura, necesitamos asignarla a una titulación.
                        </div>
                    <?php } ?>
                    <hr class="short">
                    

                </div>
            </div>
            <?php $this->load->view('footer');?>
        </div>

<!-- Libs -->
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
        
        <!-- Theme Initializer -->
        <script src="<?=base_url()?>js/theme.plugins.js"></script>
        <script src="<?=base_url()?>js/theme.js"></script>
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>

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
                bootbox.confirm("¿Estás seguro que quieres borrar esta asignatura?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/asignatura/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->

    </body>
</html>
