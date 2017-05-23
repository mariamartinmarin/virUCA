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

        <link href="http://cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css" rel="stylesheet">
        <link href="<?=base_url()?>js/colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <script src="<?=base_url()?>vendor/jquery.js"></script>
        <script src="<?=base_url()?>js/colorpicker/dist/js/bootstrap-colorpicker.js"></script>


        <!--[if IE]>
            <link rel="stylesheet" href="css/ie.css">
        <![endif]-->

        <!--[if lte IE 8]>
            <script src="vendor/respond.js"></script>
        <![endif]-->

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

                <?php echo form_fieldset('Modificar categoría');?>
                <form action="" method="POST">
                <?php foreach ($mod as $fila){ 
                    echo form_hidden('iId',$fila->iId);
                    $sNombre = array(
                    'name' => 'sNombre',
                    'id' => 'sNombre',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sNombre,
                    'maxlength' => '100'
                    );

                    $sDescripcion = array(
                    'name' => 'sDescripcion',
                    'id' => 'sDescripcion',
                    'size' => '50',
                    'class' => 'form-control',
                    'value' => $fila->sDescripcion
                    );

                    $sColor = array(
                    'name' => 'sColor',
                    'class' => 'form-control',
                    'value' => $fila->sColor,
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

                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Nombre *</label>
                                <?=form_input($sNombre)?>
                                <?=form_error('sNombre','<div class= "error">','</div>');?>
                            </div>
                            <div class="col-md-6">
                                <label>Descripcion *</label>
                                <?=form_input($sDescripcion)?>
                                <?=form_error('sDescripcion', '<div class= "error">','</div>');?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div id="cp8" data-format="alias" class="input-group colorpicker-component" 
                                    style="width:150px;">
                                    <?=form_input($sColor)?>
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                <script>
                                    $(function () {
                                        $('#cp8').colorpicker({
                                            colorSelectors: {
                                            '#f44336': '#f44336',
                                            '#e91e63': '#e91e63',
                                            '#9c27b0': '#9c27b0',
                                            '#673ab7': '#673ab7',
                                            '#3f51b5': '#3f51b5',
                                            '#2196f3': '#2196f3',
                                            '#00bcd4': '#00bcd4',
                                            '#009688': '#009688',
                                            '#4caf50': '#4caf50',
                                            '#cddc39': '#cddc39',
                                            '#ff9800': '#ff9800'
                                            }
                                        });
                                    });
                                </script>
                                <br>
                            </div>
                        </div>
                    </div>
                    <?=form_submit($submit)?>
                    <!-- Fin campos formulario -->
                   
                    <?php } ?>
                </form>
                <?=form_fieldset_close();?>
                <hr>
                <a href="<?=base_url()."index.php/categorias"?>" class="btn btn-warning">Volver</a>
            </div>        
        </div>
        <?php $this->load->view('footer');?>
    </div>


    </body>
</html>






