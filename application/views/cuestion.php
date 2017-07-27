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
    <link rel="stylesheet" href="<?=base_url()?>css/panel.css?id=107">
    <link rel="stylesheet" href="<?=base_url()?>css/timecircles/TimeCircles.css" />

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
        
    <!-- Custom JS -->
    <script src="<?=base_url()?>js/custom.js"></script>


    <!-- Head Libs -->
    <script src="<?=base_url()?>vendor/modernizr.js"></script>

    <!--[if IE]>
        <link rel="stylesheet" href="css/ie.css">
    <![endif]-->

    <!--[if lte IE 8]>
        <script src="vendor/respond.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function enviar(respuesta) {
            $('#respuesta').val(respuesta);
            $('#formRespuesta').submit();
        }
    </script>

</head>

<body>
    <div id="preloader"><div id="loader">&nbsp;</div></div>

    <div class="body">
        <?php $this->load->view('menuj_view');?>
        <div role="main" class="main">       
            <div class="container">
     
                <!-- Información de la partida -->
                
                <div class="featured-box featured-box-primary">
                     <div class="box-content">
                        <?php
                            
                        echo "<div>";
                        // Hay que restablecer la partida.
                        foreach ($resumen as $equipo) {
                            echo "<div style='float:left; padding-left:30px;'>";
                            if ($equipo->iGrupo == $this->session->userdata('iTurno'))
                                echo "<span class='rojo'><b>Grupo ".$equipo->iGrupo."</b></span><br>";
                            else 
                                echo "<span>Grupo ".$equipo->iGrupo."</span><br>";
                            echo "<img src='".base_url()."/assets/img/".$equipo->iGrupo.".png' aling='center'><br>";
                            if ($equipo->iCasilla == 0)
                                echo "Inicio";
                            else {
                                echo $equipo->iCasilla;
                            }
                            echo "</div>";
                        }
                        echo "</div>";
                        ?>
                        <br class="clear">
                    </div>
                </div>

                <!-- pregunta -->
                <div class="featured-box featured-box-primary"><div class="box-content">

                <div style="float:left; width: 600px;">
                    <blockquote><h5>Te vamos a hacer una pregunta sobre <b><?=$categoria;?></b>.
                    <?php
                        switch ($tipocasilla) {
                            case 'Viento':
                                echo "Además, has caído en una casilla de 'Viento', por lo que si aciertas esta pregunta, irás a la siguiente casilla de viento, si la hubiere. De lo contrario, volverás a la posición anterior.";
                                break;
                            case 'Retroceder':
                                echo "Oops! has caído en una casilla con una 'jeringuilla', por lo que si no aciertas la pregunta, volverás a la posición inicial ... ¡Suerte! :)";
                                break;
                            default:
                                break;
                        }
                    ?>
                    </h5></blockquote>
                
                <?php
                if ($pregunta != NULL) {
                    $preguntaTxt = 0;
                    $arrayRespuestas = array(
                        '0' => 'A',
                        '1' => 'B',
                        '2' => 'C',
                        '3' => 'D');
                    $cont = 0;
                    $iId_Pregunta = 0;
                    foreach ($pregunta as $respuesta) {
                        if ($preguntaTxt == 0) {
                            $iId_Pregunta = $respuesta->iId;
                            echo "<h4><b>¿".$respuesta->sPregunta."?</b></h4>";
                            $preguntaTxt = 1;
                        }
                        echo "<b>".$arrayRespuestas[$cont].")</b> ".$respuesta->sRespuesta."<br><br>";
                        if ($respuesta->bVerdadera == 1) $correcta = $arrayRespuestas[$cont];
                        $cont++;
                    }
                    $atributos = array('id' => 'formRespuesta');
                    echo form_open(base_url().'index.php/jugar/correccion', $atributos);
                        echo "<input type='hidden' name='iId_Pregunta' value='".$iId_Pregunta."'>";
                        echo "<input type='hidden' name='respuesta' value='' id='respuesta'>";
                        echo "<label><b>Haz clic en la respuesta que creas correcta:</b></label><br>";
                        echo "<input type='button' class='btn btn-default' value='Respuesta A' name='A' onclick='javascript:enviar(1)'>";
                        echo "<input type='button' class='btn btn-default' value='Respuesta B' name='B' onclick='javascript:enviar(2)' style='margin-left:10px;'>";
                        echo "<input type='button' class='btn btn-default' value='Respuesta C' name='C' onclick='javascript:enviar(3)' style='margin-left:10px;'>";
                        echo "<input type='button' class='btn btn-default' value='Respuesta D' name='D' onclick='javascript:enviar(4)' style='margin-left:10px;'>";
                        echo "<input type='button' class='btn btn-warning' value='Error' name='Error' onclick='javascript:enviar(5)' style='margin-left:10px;'>";
                    form_close();
                } else {
                    echo "<blockquote>Lo sentimos, hubo un problema al intentar recuperar la pregunta</blockquote>";
                }
                ?>
                </div>

                <div style="float:left; margin-left: 20px;">
                    <blockquote>
                        <div class="example stopwatch" data-date='00:00:60'></div>
                        <button type="button" class="btn btn-success start">Empezar</button>
                        <button type="button" class="btn btn-danger stop">Parar</button>
                        <button type="button" class="btn btn-info restart">Iniciar</button>
                    </blockquote>
                </div>

                <br class="clear">

                </div></div>
                
                <!-- Fin de pregunta -->
                
                <br class="clear">
                <input type="button" class="btn btn-warning" value="Intentar otra pregunta" 
                        onclick="location.href='<?=base_url()?>index.php/cuestion'">  
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
        });
    </script>

    <!-- BOOT BOX -->
    <script src="<?=base_url()?>js/bootbox/boot.activate.js"></script>
    <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>
    <script src="<?=base_url()?>js/timecircles/TimeCircles.js"></script>
        
    <script type="text/javascript">
        
        $(document).ready(function(){
            $(".start").click(function(){ $(".example.stopwatch").TimeCircles().start(); });
            $(".stop").click(function(){ $(".example.stopwatch").TimeCircles().stop(); });
            $(".restart").click(function(){ $(".example.stopwatch").TimeCircles().restart(); }); 

            $(".example.stopwatch").TimeCircles({
                "animation": "smooth",
                "bg_width": 1.2,
                "fg_width": 0.1,
                "total_duration": 60,
                "circle_bg_color": "#60686F",
                "time": {
                    "Days": {
                        "text": "Days",
                        "color": "#FFCC66",
                        "show": false
                    },
                    "Hours": {
                        "text": "Hours",
                        "color": "#99CCFF",
                        "show": false
                    },
                    "Minutes": {
                        "text": "Minutes",
                        "color": "#BBFFBB",
                        "show": false
                    },
                    "Seconds": {
                        "text": "Segundos",
                        "color": "#FF9999",
                        "show": true
                    }
                }
            });
            $(".example.stopwatch").TimeCircles().stop();
        });

        function aleatorio(a,b) {return Math.round(Math.random()*(b-a)+parseInt(a));}

        bootbox.setDefaults({
          locale: "es"
        });

        $(function() {
            var cajas = {};

            $(document).on("click", "input[data-bb]", function(e) {
                e.preventDefault();
                var type = $(this).data("bb");
                // Partida en curso
                var iId_Partida = $(this).data("id");
                // Grupo que tiene el turno
                var iId_Grupo = $(this).data("gr");
                // Panel
                var iId_Panel = $(this).data("pn");
                
                if (typeof cajas[type] === 'function') {
                    cajas[type](iId_Partida, iId_Grupo, iId_Panel);
                }
            });

            cajas.confirm = function(id, gr, pn) {
                var tirada = aleatorio(1,6);
                var innerTxt = "<h4>Grupo " + gr + ", has obtenido un ... "+ tirada + "</h4>";
                var imagen = 1;

                innerTxt = innerTxt + '<div style="float:left; padding-left:5px;"><img src="'
                        + '<?=base_url()?>' + 'assets/img/dado.gif' + '"></div>';
            
                innerTxt += "<br class='clear'>";
                // Si confirma la tirada de dado, vamos a la página de preguntas.
                bootbox.confirm(innerTxt, function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/jugar/'
                            + id
                            + '/'
                            + pn 
                            + '/'
                            + gr
                            + '/'
                            + tirada;
                    }
                });
            };
        });
        </script>
        <!-- FIN BOOT -->
        
    </body>
</html>
