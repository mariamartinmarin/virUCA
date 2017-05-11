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
        <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap-theme.css">
        <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
      
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

        <!-- Libs -->
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        
        <!-- Theme Initializer -->
        <script src="<?=base_url()?>js/theme.plugins.js"></script>
        <script src="<?=base_url()?>js/theme.js"></script>

       <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>


        <!-- Head Libs -->
        <script src="<?=base_url()?>vendor/modernizr.js"></script>
        <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/tablesorter/jquery.tablesorter.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
    { 
        $("#table_preguntas").tablesorter( {sortList: [[1,0], [3,0]]} ); 
    } 
); 
        </script>


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
                                    <li><a href="#">Paneles</a></li>
                                    <li class="active">Alta de Paneles de Juego</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Alta de paneles</h2>
                            </div>
                        </div>
                    </div>
                </section>
               
                <div class="container">

                    <!-- Formulario de alta -->

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

        
                    <?php echo form_fieldset('Alta de panel de juego');?>
                    <blockquote>
                        Por defecto, el panel que cree, no estará activo. Se creará con tantas casillas como indique en este primer paso, y posteriormente, podrá personalizar las casillas del panel o bien dejar las que el juego crea por defecto.
                    </blockquote>
                    
                   <?=form_open(base_url().'index.php/panelesalta/nueva');

                   $activo = 0;
                   echo form_hidden('bActivo',$activo);
                   echo form_hidden('iId_Propietario', $this->session->userdata('id_usuario'));

                    $iCasillas = array(
                    'name' => 'iCasillas',
                    'id' => 'iCasillas',
                    'type' => 'number',
                    'style' => 'width:100px;',
                    'class' => 'form-control',
                    'value' => set_value('iCasillas'),
                    'maxlength' => '20',
                    'autocomplete' => 'off'
                    );

                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => set_value('sNombre'),
                    'required' => 'true',
                    'autocomplete' => 'off',
                    'maxlength' => '512'
                    );

                    $submit = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'value' => 'Enviar',
                    'title' => 'Enviar',
                    'class' => 'btn btn-default' 
                    );
                    ?>

                    <?php if ($categorias != "") { ?>

                   <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Nombre del panel *</label>
                                <?=form_input($sNombre)?>
                                <?=form_error('sNombre','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                            </div>
                           <div class="col-md-6">
                                <label>Número de casillas* <b>[>5]</b></label>
                                <?=form_input($iCasillas)?>
                                <?=form_error('iCasillas','<br><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">&nbsp;</span>','</div>');?>
                                
                            </div>
                            
                        </div>
                    </div>
                                        
                    <?=form_submit($submit)?>

                    <?php
                    } else {
                    ?>
                    <div class="alert alert-success">
                    Para poder crear un panel, es necesario poder asignar cada una de sus celdas a una categoría, y actualmente no existe ninguna categoría en el sistema.
                    </div>
                    <?php 
                    }
                    ?>

                    <?=form_close()?>

                    <!-- Fin del formulario organizado -->
                    
                    
                    <?=form_fieldset_close();?>

                    <hr class="short">
                    <input type="button" class="btn btn-warning" value="Ver paneles" onclick="location.href='<?=base_url()?>index.php/paneles'">
                    <!-- Fin del formulario de alta -->

                </div>
            </div>
            <?php $this->load->view('footer');?>
        </div>

        
    </body>
</html>
