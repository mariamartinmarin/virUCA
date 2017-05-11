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

        <link href="http://cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
        <link href="<?=base_url()?>js/colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        <script src="<?=base_url()?>js/colorpicker/dist/js/bootstrap-colorpicker.js"></script>

        <!-- Head Libs -->
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
                            <li><a href="#">Partidas</a></li>
                            <li class="active">Gestión de Categorías</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Gestión de Categorías</h2>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">

            <!-- Errores de inserción. -->
            <?php if($this->session->flashdata('categoria_ok')) { ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('categoria_ok');?>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('categoria_ko')) { ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('categoria_ko'); ?>
                </div>
            <?php } ?>
            <!-- Fin errores -->

            <!-- Listado -->
            <?php if ($categoria != "") { 
            // Obtener página.
            $npag =  $this->uri->segment(3);
            ?>

            <?php echo form_fieldset('Listado de categorías');
            $atributos = array('class' => 'navbar-form', 'role' => 'search');
            ?>

            <?=form_open(base_url().'index.php/categorias/eliminar_todos/'.$npag);?>
                    
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>&nbsp;</th>
                        <th>Color</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($categoria as $fila){ 
                        $cont = 0; 
                        ?>

                        <tr><th>
                        <span class="show-grid-block">
                            <input type="checkbox" name="categoria[]" value="<?=$fila->iId;?>">
                        </span>
                        </th>
                                    
                                <td style="background-color:<?=$fila->sColor;?> ">&nbsp;</td>
                                <td><?=$fila->sNombre;?></td>
                                <td>
                                    <?php 
                                    if ($fila->sDescripcion == "")
                                        echo "---";
                                    else echo substr($fila->sDescripcion,0,75)." ...";
                                ?>
                                </td>
                                <td>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <a href="<?=base_url("index.php/categorias/mod/$fila->iId/$npag")?>" 
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
                    Actualmente no hay ninguna categoría en el sistema.
                    </div>
                    <?php 
                    }
                    ?>

                    <!-- Fin del listado -->

                    <?=form_open(base_url().'index.php/categorias/nueva');
                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sNombre'),
                    'style' => 'width:400px;'
                    );
                    $sDescripcion = array(
                    'name' => 'sDescripcion',
                    'id' => 'sDescripcion',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sDescripcion'),
                    'style' => 'width:400px; height:80px;'
                    );
                    $sColor = array(
                    'name' => 'sColor',
                    'class' => 'form-control',
                    'value' => '#FF0000',
                    'type' => 'text'
                    );
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <?=form_fieldset('Añadir una nueva categoría');?>

                    <label for="sNombre">Categoría:</label>
                    <?=form_input($sNombre)?>
                    <p>
                        <?=form_error('sNombre','<div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>',
                            '</div>');
                        ?>    
                    </p>
                    <label for="sDescripcion">Descripción:</label>
                    <?=form_textarea($sDescripcion)?><p><?=form_error('sDescripcion')?></p>
                    <div id="cp8" data-format="alias" class="input-group colorpicker-component" style="width:150px;">
                        <?=form_input($sColor)?>
                        <span class="input-group-addon"><i></i></span>
                    </div>
                    <script>
                        $(function () {
                            $('#cp8').colorpicker({
                                colorSelectors: {
                                '#000000': '#000000',
                                '#ffffff': '#ffffff',
                                '#FF0000': '#FF0000',
                                '#00FF00': '#00FF00',
                                '#0000FF': '#0000FF',
                                '#FFFF00': '#FFFF00',
                                '#FF00FF': '#FF00FF',
                                '#800080': '#800080',
                                '#808000': '#808000',
                                '#008000': '#008000',
                                '#000080': '#000080'
                                }
                            });
                        });
                    </script>
                    <br>
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
                bootbox.confirm("¿Estás seguro que quieres borrar esta categoría?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/categorias/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->
        
</body>
</html>
