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
            <?php $this->load->view('menua_view');?>
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
                    <?php if ($pregunta != "") { 
                    // Obtener página.
                    $npag =  $this->uri->segment(3);
                    ?>

                    <?php echo form_fieldset('Listado de preguntas');
                    $atributos = array('class' => 'navbar-form', 'role' => 'search');
                    ?>
                    <blockquote>
                        Desde aquí podrás gestionar tus propias preguntas, y ver si los profesores han validado tu pregunta para que aparezca en el juego. Recuerda, que una vez que la pregunta esté validada y/o puntuada, no podrás ni modificarla ni eliminarla.
                    </blockquote>
                    
                    <?=form_open(base_url().'index.php/preguntas/eliminar_todos/'.$npag);?>
                    
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Se están mostrando un total de <b><?=$num_filas;?> registros</b>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Texto de la pregunta</th>
                                <th>Activa</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($pregunta as $fila){ 
                                $cont = 0; 
                                ?>

                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="pregunta[]" value="<?=$fila->iId;?>">
                                    </span>
                                </th>
                                    
                                <td><?=substr($fila->sPregunta,0,75)." ...";?></td>
                                <td>
                                <?php
                                    if ($fila->bActiva)
                                        echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
                                    else
                                        echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                                ?>    
                                </td>

                                <?php 
                                if ($fila->bActiva == 1) { ?>
                                    <td>
                                    <a href="<?=base_url("index.php/pregunta/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-eye"></i></a>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                    <a href="#" 
                                        data-bb="confirm" 
                                        data-id="<?=$fila->iId;?>"
                                        data-pg="<?=$npag?>" 
                                        class="btn-group-xs">
                                            <i class="icon icon-trash-o"></i>
                                    </a>
                                    <a href="<?=base_url("index.php/pregunta/mod/$fila->iId/$npag")?>" 
                                    class="btn-group-xs"><i class="icon icon-pencil"></i></a>
                                    </td>
                                <?php } ?>
                                
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
                    Actualmente no hay ninguna pregunta en el sistema.
                    </div>
                    <?php 
                    }
                    ?>

                    <!-- Fin del listado -->


                     
                    <!-- Formulario de alta -->
                    <?=form_open(base_url().'index.php/pregunta/nueva');
                   $activa = 0;
                   echo form_hidden('bActiva',$activa);
                   echo form_hidden('iId_Usuario', $this->session->userdata('id_usuario'));
                   echo form_hidden('nPuntuacion', 0);

                    $sPregunta = array(
                    'name' => 'sPregunta',
                    'id' => 'sPregunta',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sPregunta'),
                    'maxlength' => '512'
                    );

                    $sResp1 = array(
                    'name' => 'sResp1',
                    'id' => 'sResp1',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sResp1'),
                    'maxlength' => '512'
                    );

                    $sResp2 = array(
                    'name' => 'sResp2',
                    'id' => 'sResp2',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sResp2'),
                    'maxlength' => '512'
                    );

                    $sResp3 = array(
                    'name' => 'sResp3',
                    'id' => 'sResp3',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sResp3'),
                    'maxlength' => '512'
                    );

                    $sResp4 = array(
                    'name' => 'sResp4',
                    'id' => 'sResp4',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sResp4'),
                    'maxlength' => '512'
                    );

                    $bVerdadera1 = array(
                        'id'=>'1',
                        'name'=>'verdadera', 
                        'value'=>'1',
                        'checked' => TRUE);  
                    
                    $bVerdadera2 = array(
                        'id'=>'2',
                        'name'=>'verdadera', 
                        'value'=>'2');  
                    
                    $bVerdadera3 = array(
                        'id'=>'3',
                        'name'=>'verdadera', 
                        'value'=>'3');  
                    
                    $bVerdadera4 = array(
                        'id'=>'4',
                        'name'=>'verdadera', 
                        'value'=>'4');  
                    
                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <?=form_fieldset('Añadir nueva pregunta.');?>

                    <!--- formulario organizado con validación -->
                    <?php if ($categorias != "") { ?>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Pregunta *</label>
                                <?=form_input($sPregunta)?>
                                <?=form_error('sPregunta','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <label>Categorías *</label>
                                <?=form_label('Categorías: '); ?>
                                <?=form_dropdown('sCategorias', $categorias, '', 'class=form-control'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Respuesta A *</label>
                                <?=form_input($sResp1)?>
                                <?=form_error('sResp1','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                                <label>Respuesta B *</label>
                                <?=form_input($sResp2)?>
                                <?=form_error('sResp2','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                                <label>Respuesta C *</label>
                                <?=form_input($sResp3)?>
                                <?=form_error('sResp3','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                                <label>Respuesta D *</label>
                                <?=form_input($sResp4)?>
                                <?=form_error('sResp4','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
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
                                form_error('rResp4','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>

                            </div>
                        </div>
                                        
                    <?=form_submit($submit)?>

                    <?php
                    } else {
                    ?>
                    <div class="alert alert-success">
                    Para poder introducir preguntas, es necesario poder asignarla a una categoría, y actualmente no existe ninguna categoría en el sistema. Coméntalo con tu profesor para que las habiliten. Después, podrás agregar cuantas preguntas quieras.
                    </div>
                    <?php 
                    }
                    ?>

                    <?=form_close()?>

                    <!-- Fin del formulario organizado -->
                    
                    
                    <?=form_fieldset_close();?>

                    <hr class="short">
                    <!-- Fin Formulario de alta -->
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
                bootbox.confirm("¿Estás seguro que quieres borrar la pregunta?", function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/pregunta/eliminar/'+id+'/'+pg;
                    }
            });
            };
  
        });

        </script>
        <!-- FIN BOOT -->

    </body>
</html>