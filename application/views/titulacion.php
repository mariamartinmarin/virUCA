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
                $("#table_titulacion").tablesorter({sortList: [[1,0], [2,0]]} ); 
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
                                    <li class="active">Gestión de Titulaciones</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Titulaciones</h2>
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
                    <?php if ($titulacion != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de titulaciones');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>
                    <blockquote>
                        Administrar las diferentes <b>titulaciones</b> que podrán participar en una partida de <b>VirUCA</b>
                    </blockquote>
                    
                    <?=form_open(base_url().'index.php/titulacion/eliminar_todos/'.$npag);?>
                    
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                        </div>
                        <table class="table table-bordered table-striped" id="table_titulacion">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Titulación</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($titulacion as $fila){ 
                                $cont = 0; 
                                ?>

                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="titulacion[]" value="<?=$fila->iId;?>">
                                    </span>
                                </th>
                                    
                                <td><?=$fila->sTitulacion;?></td>  
                                <td>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <a href="<?=base_url("index.php/titulacion/mod/$fila->iId/$npag")?>" 
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
                    Actualmente no hay ninguna titulación en el sistema.
                    </div>
                    <?php 
                    }
                    ?>

                    <!-- Fin del listado -->

                    
                    <?=form_open(base_url().'index.php/titulacion/nueva');
                    $sTitulacion = array(
                    'name' => 'sTitulacion',
                    'id' => 'sTitulacion',
                    'size' => '50',
                    'class' => 'form-control',
                    'style' => 'width:400px;',
                    'value' => set_value('sTitulacion') 
                    );
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default'
                    );
                    ?>

                    <?=form_fieldset('Añadir una nueva titulación');?>

                    <label for="sTitulacion">Titulación:</label>
                    <?=form_input($sTitulacion)?><p>
                    <?=form_error('sTitulacion','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?></p>
                    <?=form_submit($submit)?>
                    <?=form_close()?>

                    
                    <?=form_fieldset_close();?>

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
                bootbox.confirm("¿Estás seguro que quieres borrar la titulación?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/titulacion/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->
    </body>
</html>
