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
        <link rel="stylesheet" href="<?=base_url()?>vendor/magnific-popup/magnific-popup.css" media="screen">
        <link rel="stylesheet" href="<?=base_url()?>vendor/isotope/jquery.isotope.css" media="screen">
        
        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/theme.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-elements.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-shop.css">
        
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
        <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/tablesorter/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/busquedasimple.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            { 
                $("#table_alumnos").tablesorter( {sortList: [[1,0], [2,0], [3,0]]} ); 
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
                                    <li><a href="#">Alumnos</a></li>
                                    <li class="active">Gestión de Alumnos</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Alumnos</h2>
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

                    <?php if ($alumnos != "" && $cursos != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de alumnos');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>
                    <blockquote>
                        Administrar y crear usuarios <b>Alumnos</b> en el sistema. En la parte inferior tiene el formulario para dar de alta nuevos usuarios.
                    </blockquote>
                    
                    <?=form_open(base_url().'index.php/alumnos/eliminar_todos/'.$npag);?>
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
                        <table class="table table-bordered table-striped"  id="table_alumnos">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Curso Académico</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody class="buscar">
                                <?php 
                                foreach($alumnos as $fila){ 
                                ?>

                                <tr><td>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="alumnos[]" value="<?=$fila->iId;?>">
                                    </span>
                                </td>
                                    
                                <td><?=$fila->sNombre;?></td>
                                <td><?=$fila->sApellidos;?></td>  
                                <td><?=$fila->sCurso;?></td> 
                                <td>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>

                                    <a href="<?=base_url("index.php/alumnos/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-pencil"></i></a>
                                </td>
                                <?php
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
                            Actualmente no hay ningún alumno activo.
                        </div>
                        <?php
                        if ($cursos == '') {
                        ?>
                        <div class="alert alert-success">
                            No se pueden dar de alta alumnos si no hay ningún <b>Curso Académico</b> en el sistema.
                        </div>
                        <?php
                        } 
                    }
                    ?>

                    <!-- Fin del listado -->

                    <?php if ($cursos != '') { ?>
                        

                   <?=form_open(base_url().'index.php/alumnos/nueva');
                   $tipo_usuario = 1;
                   echo form_hidden('iPerfil',$tipo_usuario);

                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sNombre'),
                    'maxlength' => '100'
                    );

                    $sApellidos = array(
                    'name' => 'sApellidos',
                    'id' => 'sApellidos',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sApellidos')
                    );

                    $sEmail = array(
                    'name' => 'sEmail',
                    'id' => 'sEmail',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sEmail')
                    );

                    $sUsuario = array(
                    'name' => 'sUsuario',
                    'id' => 'sUsuario',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sUsuario')
                    );
                    $sPassword = array(
                    'name' => 'sPassword',
                    'id' => 'sPassword',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sPassword')
                    );

                    $sCursos = array(
                    'name' => 'sCursos',
                    'id' => 'sCursos',
                    'size' => '50',
                    'class' => 'form-control input-lg',
                    'value' => set_value('sCursos') 
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>
                    
                    <?=form_fieldset('Añadir nuevo alumno.');?>

                    <!--- formulario organizado con validación -->

                   <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Nombre *</label>
                                <?=form_input($sNombre)?>
                                <?=form_error('sNombre','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <label>Apellidos *</label>
                                <?=form_input($sApellidos)?>
                                <?=form_error('sApellidos', '<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Usuario *</label>
                                <?=form_input($sUsuario)?>
                                <?=form_error('sUsuario','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <label>Contraseña *</label>
                                <?=form_input($sPassword)?>
                                <?=form_error('sPassword','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>E-mail</label>
                                <?=form_input($sEmail)?>
                                <?=form_error('sEmail','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                            <div class="col-md-6">                            
                                <?=form_label('Curso Académico: '); ?>
                                <?=form_dropdown('sCursos', $cursos, '', 'class=form-control input-lg'); ?>
                                
                            </div>
                        </div>
                    </div>                      
                    <?=form_submit($submit)?>
                    <?=form_close()?>

                    <!-- Fin del formulario organizado -->
                    
                    <?=form_fieldset_close();?>

                    <?php

                    } 
                    ?>
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
        
        <!-- Theme Initializer -->
        <script src="<?=base_url()?>js/theme.plugins.js"></script>
        <script src="<?=base_url()?>js/theme.js"></script>

        <!-- Current Page JS -->
        <script src="<?=base_url()?>js/views/view.contact.js"></script>
        
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
                bootbox.confirm("¿Estás seguro que quieres borrar a este alumno?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/alumnos/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->

    </body>
</html>
