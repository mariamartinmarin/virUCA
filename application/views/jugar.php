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
    <link rel="stylesheet" href="<?=base_url()?>css/panel.css?id=124">
    <link rel="stylesheet" href="<?=base_url()?>css/tooltip.css">

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
        function AddFicha(idDiv, Texto) {
            document.getElementById(idDiv).innerHTML += Texto;
        }
    </script>
</head>

<body>
    <div id="preloader"><div id="loader">&nbsp;</div></div>

    <div class="body">
        <?php $this->load->view('menuj_view');?>
        <div role="main" class="main">       
            <div class="container">
               
                <!-- Errores de inserción. -->



                <?php if($this->session->flashdata('respuesta_ok')) { ?>
                     <div class="modal">
                        <div class="ventana">
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('respuesta_ok');?>
                            </div>
                            <span class="cerrar">Cerrar</span>
                        </div>
                    </div>
                <?php } ?>

                <?php if($this->session->flashdata('respuesta_ko')) { ?>
                    <div class="modal">
                        <div class="ventana">
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('respuesta_ko'); ?>
                                <span class="cerrar">Cerrar</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- Fin errores -->
                    
                <!-- Información de la partida -->
                <?php 
                    foreach ($partida as $jugador) {
                            $nJugadores = $jugador->nGrupos;
                            $iId_Partida = $jugador->iId;
                            $iTurno = $jugador->iTurno;
                            $iId_Panel = $jugador->iId_Panel;
                            $bFinalizada = $jugador->bFinalizada;
                        }
                ?>

                <?php if ($bFinalizada) {
                    echo "<br><blockquote><strong>La partida ha finalizado</strong>. En la siguiente tabla puedes ver cómo han quedado los grupos</blockquote>";
                    }
                ?>

                <div class="featured-box featured-box-primary">
                     <div class="box-content">
                        <?php
                            
                        echo "<div>";
                        // Hay que restablecer la partida.
                        foreach ($resumen as $equipo) {
                            echo "<div style='float:left; padding-left:30px;'>";
                            if ($equipo->iGrupo == $iTurno)
                                echo "<span class='rojo'><b>Grupo ".$equipo->iGrupo."</b></span><br>";
                            else 
                                echo "<span>Grupo ".$equipo->iGrupo."</span><br>";
                            echo "<img src='".base_url()."/assets/img/".$equipo->iGrupo.".png' aling='center'><br>";
                            if ($equipo->iCasilla == 0)
                                echo "Inicio";
                            else {
                                // Comprobamos si hay que poner las medallas y regalos.
                                echo "<div style='padding-top:5px;''>";
                                switch ($equipo->iPosJuego) {
                                    case '1':
                                        echo "<img src='".base_url()."/assets/img/gold.png' aling='center'><br>";
                                        break;
                                    case '2':
                                        echo "<img src='".base_url()."/assets/img/silver.png' aling='center'><br>";
                                        break;
                                    case '3':
                                        echo "<img src='".base_url()."/assets/img/bronze.png' aling='center'><br>";
                                        break;
                                    default:
                                        if ($equipo->iPosJuego != 0)
                                            echo "<img src='".base_url()."/assets/img/gift.png' aling='center'><br>";
                                        break;
                                }
                                echo "</div>";
                                if ($equipo->iPosJuego == 0)
                                    echo $equipo->iCasilla;
                            }
                            echo "</div>";
                        }
                        echo "</div>";
                        ?>
                        <br class="clear">
                    </div>
                </div>

                <!-- panel -->
                 
                <?php
                    // Botones
                    if ($bFinalizada == 0) { ?>
                    <input type="hidden" data-bb="pregunta">
                    <input type="button" class="btn btn-warning" 
                        data-bb="confirm" 
                        data-pn="<?=$iId_Panel;?>"
                        data-id="<?=$iId_Partida;?>"
                        data-gr="<?=$iTurno;?>"
                        value="Tirar Dado">

                    <input type="button" class="btn btn-warning" 
                        data-bb="confirm2" 
                        data-id="<?=$iId_Partida;?>"
                        value="Finalizar partida">

                    <input type="button" class="btn btn-warning" value="Salir" 
                        onclick="location.href='<?=base_url()?>index.php/jugar/salir/<?=$iId_Partida?>'">
                    <?php } else { ?>
                    <input type="button" class="btn btn-warning" value="Listado de partidas" 
                        onclick="location.href='<?=base_url()?>index.php/partidas'">
                    <?php } 

                    if (!$bFinalizada) {

                    // Pintamos el panel     
                    $contCasilla = 1;
                    echo "<br class='clear'><br><div data-toggle='tooltip' title='Inicio' class='test fade' style='float:left;'>
                        <img src='".base_url()."/assets/img/inicio.png' aling='center'></div>";
                    
                    foreach ($casillas as $casilla) {
                        // Pinto la casilla.
                        echo "<div data-toggle='tooltip' title='".$casilla->sCategoria."' id='casilla".$contCasilla."' class='test circulo fade' style='background:".$casilla->sColor."; border: 1px dotted black;'>";
                        echo "<h4 style='margin:0 !important;' class='fuego'><b>".$contCasilla."</b></h4>";
                        
                        // Dependiendo de la función de la casilla, pintaremos esa función.

                        switch ($casilla->eFuncion) {
                            case 'Viento':
                                echo "<div style='padding-left:30px;'><img src='".base_url()."/assets/img/wind.png' aling='center'></div>";
                                break;
                            case 'Retroceder':
                                echo "<div style='padding-left:30px;'><img src='".base_url()."/assets/img/syringe.png' aling='center'></div>";
                                
                            default:
                                # code...
                                break;
                        }

                        echo "</div>";
                        $contCasilla++;
                    } 

                    echo "<div data-toggle='tooltip' title='Meta!' class='test fade' style='float:left;'>
                        <img src='".base_url()."/assets/img/meta.png' aling='center'></div>";
                    
                    // Ahora colocamos las fichas en sus celdas.
                    
                    echo "<div>";
                    
                    // Hay que restablecer la partida.
                    
                    foreach ($resumen as $equipo) {
                        if ($equipo->iCasilla != 0) {
                            // Hay que colocar la ficha en la celda.
                            $ficha = '<div class=ficha><img src='.base_url().'assets/img/'.$equipo->iGrupo.'.png?id=6></div>';
                            echo "<script>";
                            echo "AddFicha('casilla$equipo->iCasilla', '$ficha')";
                            echo "</script>";
                        }
                    }
                    
                    // Fin de colocación de fichas.
                ?>
                
                <br class="clear">
                <hr class="short">
                
                <!-- Leyenda -->
                
                <blockquote>
                    <h4>Leyenda.</h4>
                    <ul>
                        <li><img src="<?=base_url()?>assets/img/6.png" align="middle">&nbsp;&nbsp;Indica, según tu color, la posición en la que estás en el juego.</li>
                        <li><img src="<?=base_url()?>assets/img/syringe.png" align="middle">&nbsp;&nbsp;Si aciertas la pregunta, guardas la posición, si no la aciertas vuelves a la casilla de <b>inicio</b></li>
                        <li><img src="<?=base_url()?>assets/img/wind.png" align="middle">&nbsp;&nbsp;Si aciertas la pregunta, vas a la siguiente casilla de <b>viento</b>. Si no aciertas, vuelves a la casilla anterior.</li>
                    </ul>
                </blockquote>

                <!-- Resumen de la partida -->

                <?php 
                }   // Cierra el if de la partida finalizada.

                if ($bFinalizada == 0) { ?>
                <input type="hidden" data-bb="pregunta">
                <input type="button" class="btn btn-warning" 
                        data-bb="confirm" 
                        data-pn="<?=$iId_Panel;?>"
                        data-id="<?=$iId_Partida;?>"
                        data-gr="<?=$iTurno;?>"
                        value="Tirar Dado">

                <input type="button" class="btn btn-warning" 
                        data-bb="confirm2" 
                        data-id="<?=$iId_Partida;?>"
                        value="Finalizar partida">

                <input type="button" class="btn btn-warning" value="Salir" 
                        onclick="location.href='<?=base_url()?>index.php/jugar/salir/<?=$iId_Partida?>'">
                <?php } else { ?>
                <input type="button" class="btn btn-warning" value="Listado de partidas" 
                        onclick="location.href='<?=base_url()?>index.php/partidas'">
                <?php } ?>
                   
            </div>
                
        </div>
        <?php $this->load->view('footer');?>
    </div>

    <script src="<?=base_url()?>vendor/jquery.appear.js"></script>
    <script src="<?=base_url()?>vendor/jquery.easing.js"></script>
    <script src="<?=base_url()?>vendor/jquery.cookie.js"></script>
    <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>

    <?php if ($this->session->flashdata('respuesta_ok') || $this->session->flashdata('respuesta_ko')) { 
        echo "<script type='text/javascript'>";
        echo "$(document).ready(function(){";
        echo "$('.modal').fadeIn();";
        echo "$('.cerrar').click(function(){";
        echo "$('.modal').fadeOut(300);";
        echo "});});";
        echo "</script>";
    }
    ?>
        
    <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
            $('body').css({'overflow':'visible'});
        });
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

    <!-- BOOT BOX -->
    <script src="<?=base_url()?>js/bootbox/boot.activate.js"></script>
    <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>
        
    <script type="text/javascript">

        function aleatorio(a,b) {return Math.round(Math.random()*(b-a)+parseInt(a));}

        bootbox.setDefaults({
          locale: "es"
        });

        $(function() {
            var cajas = {};
            var forzar = {};

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
                } else {
                    if (typeof forzar[type] === 'function') 
                    forzar[type](iId_Partida, iId_Grupo, iId_Panel);
                } 
            });

            cajas.confirm = function(id, gr, pn) {
                var tirada = aleatorio(1,6);
                //var tirada = 1;
                var innerTxt = "";

                innerTxt = innerTxt + '<div style="float:left; padding-left:5px; width:150px;"><img src="'
                        + '<?=base_url()?>' + 'assets/img/dado'+tirada+'.png' + '"></div>';
                innerTxt = innerTxt + '<div style="float:left; padding-left:10px; width:300px;"><blockquote><b>Grupo '+ gr +'</b>, has avanzado <b>'+tirada+'</b> posicion/es, a continuación vamos a formularte una pregunta ... ¿Preparado? </blockquote></div>';
            
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

            cajas.confirm2 = function(id, gr, pn) {
                var innerTxt = "Si finalizas la partida, no podrás volver a jugarla, el ranking de los jugadores quedará como hasta ahora. ¿Estás seguro/a que desea finalizar la partida de todos modos?";
            
                innerTxt += "<br class='clear'>";
                // Si confirma la tirada de dado, vamos a la página de preguntas.
                bootbox.confirm(innerTxt, function(result) {
                    if (result == true) {
                        location.href = '<?=base_url()?>index.php/jugar/finalizar/'
                            + id;
                    }
                });
            };
        });
        </script>
        <!-- FIN BOOT -->
        
    </body>
</html>
