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
                                <li><a href="#">Partida</a></li>
                                <li><a href="#">Paneles</a></li>
                                <li class="active">Modificar Panel</li>
                            </ul>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Modificar Panel</h2>
                            </div>
                        </div>
                    </div>
            </section>

            <div class="container">
                <!-- Errores de inserción. -->
                <?php if($this->session->flashdata('profesor_ok')) { ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('profesor_ok');?>
                    </div>
                <?php } ?>

                <?php if($this->session->flashdata('profesor_ko')) { ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('profesor_ko'); ?>
                    </div>
                <?php } ?>
                <!-- Fin errores -->

                <?php echo form_fieldset('Modificar panel en curso');?>
                

                
                    <!-- Listado -->
                    <?php if ($categorias != "") { ?>

                    <blockquote>
                        En el siguiente listado, se muestran las características asociadas a cada casilla del panel escogido. Podrás cambiar la <b>Categoría</b> y la <b>Función Especial</b> de la casilla. Una vez que hagas todos los cambios, haz clic en el botón <b>Guardar</b> ubicado en la parte baja de este formulario.
                    </blockquote>

                    

                    
                    <?php 
                    $atributos = array('id' => 'confpanel');
                    echo form_open(base_url().'index.php/paneles/eliminar_casillas/'.$this->uri->segment(3), $atributos);?>
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Configuración de Panel
                        </div>

                        
                        <table class="table table-bordered table-striped" id="table_preguntas">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Número</th>
                                <th>Función</th>
                                <th>Categoría</th>
                            </thead>
                            <tbody class="buscar">
                                <?php
                                $cont = 1; 
                                foreach($paneles as $fila){ 
                                echo "<input type='hidden' name='identificadores[]' value='".$fila->iId_Casilla."'>";                               
                                ?>
                                <?php if ($cont == 1) {
                                    $bActivo = array(
                                    'name' => 'bActivo',
                                    'id' => 'bActivo',
                                    'size' => '50',
                                    'class' => 'form-control',
                                    'value' => $fila->bActivo
                                    );
                                    echo "<tr><th colspan='4' align='right'>";     
                                    if ($fila->bActivo == 1) { ?>
                                        <b>&nbsp;Panel Activo&nbsp;</b><input type="checkbox" checked="true" name="bActivo[]" value="1">
                                    <?php } else { ?>
                                        <b>&nbsp;Panel Inactivo&nbsp;</b><input type="checkbox" name="bActivo[]" value="0">
                                    <?php }
                                    echo "</th></tr>"; 
                                }?>


                                <tr><th>
                                    <span class="show-grid-block">
                                        <input type="checkbox" name="panel[]" value="<?=$fila->iId_Casilla;?>">
                                    </span>
                                </th>
                                    
                                <td>Casilla <b><?=$cont;?></b></td>
                                <td>
                                    <select name="funciones[]" class="form-control">
                                    <?php
                                        if ($fila->eFuncion == "Ninguno")
                                            echo "<option value='Ninguno' selected>Ninguno</option>";
                                        else 
                                            echo "<option value='Ninguno'>Ninguno</option>";

                                        if ($fila->eFuncion == "Viento")
                                            echo "<option value='Viento' selected>Viento</option>";
                                        else 
                                            echo "<option value='Viento'>Viento</option>";

                                        if ($fila->eFuncion == "Retroceder")
                                            echo "<option value='Retroceder' selected>Retroceder</option>";
                                        else 
                                            echo "<option value='Retroceder'>Retroceder</option>";
                                    ?>
                                    </select>
                                </td>

                                <td>
                                    <select name="categorias[]" class="form-control">
                                    <?php
                                        foreach ($categorias as $i => $categoria) 
                                        if ($i == $fila->iId_Categoria)
                                            echo "<option value='".$i."' selected>".$categoria."</option>";
                                        else
                                            echo "<option value='".$i."'>".$categoria."</option>";
                                    ?>
                                    </select>   
                                </td>
                                
                                <?php
                                $cont++;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <input type="hidden" name="iId" id="iId" value="<?=$this->uri->segment(3);?>">

                    <?php if ($enpartida <= 0) { ?>

                    <input type="submit" class="btn btn-warning" value="Eliminar Casillas">
                    <input type="button" onclick="javascript: guardar(<?=$this->uri->segment(3);?>)" 
                        class="btn btn-warning" value="Guardar Configuración">

                    <?php } else { ?>
                    <div class="alert alert-success">
                    El panel está asociado a una o más partidas en curso y no se pueden modificar hasta que las partidas no se den por finalizadas.
                    </div>
                    <?php } ?>


                    <input type="button" class="btn btn-warning" value="Nuevo Panel" onclick="location.href='<?=base_url()?>index.php/panelesalta'">
                    <hr class="short">
                    
                    

                    <?=form_close();?>
                    
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Actualmente no hay ninguna categoría en el sistema, por lo que no podemos gestionar paneles. Le rogamos que contacte con el administrador del sitio o revise las categorías que actualmente hay en el sistema.
                    </div>
                    <?php 
                    }
                    ?>
                    <!-- Fin del listado -->
                
                <?=form_fieldset_close();?>

                <a href="<?=base_url()."index.php/paneles"?>" class="btn btn-warning">Listado</a>
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
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>

        <script type="text/javascript">
            function guardar(id) {
                url = '<?=base_url()?>'+'index.php/paneles/mod/'+id; 
                document.getElementById("confpanel").setAttribute("action", url);
                $("#confpanel").submit();
            }
        </script>

    </body>
</html>






