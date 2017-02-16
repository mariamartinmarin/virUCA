<html lang="es">
<head>
	<title>VirUCA: Trivial</title>
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/960.css">
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/text.css">
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/reset.css">



	<!--<script type = 'text/javascript' src = "<?php echo base_url(); ?>js/sample.js"></script>-->
	<script src="http://code.jquery.com/jquery-1.8.3.js"></script>

	 <style type="text/css">
 
        body{
            background: #ffefef;
        }
        #consulta{
            display: none;
            font-size: 12px;
            background: #d5d8dd;
            margin-bottom: 15px;
        }
        .container_12{
            background: #1b89da;
            border: 5px solid #ccc;
        }
        #cuerpo{
            margin-top: 10px;
        }
        #cabecera{
            margin-top: 10px;
            background: #111;
            color: #ccc;
            margin-left: 0px;
        }
        .mostrar{
            color: #ccc;
            font-weight: bold;
            text-align: center;
            font-size: 22px;
            cursor: pointer;
        }
        pre{
            border: 1px solid #111;
            background: #ccc;
            margin-left: -60px;
            margin-right: 30px;
        }
        #consulta_sql{
            margin: 20px 0px;
        }
        h3{
            font-size: 18px;
            text-align: center;
            color: #9e0606;
        }
    </style>
</head>
<script type="text/javascript">
    $(document).ready(function(){
        $(".mostrar").click(function(){
            $(this).next('#consulta').slideToggle();
        });
    })
</script>
<body>

<div class="container_12">
	<div class="mostrar grid_12"></div>
        <div class="grid_12" id="consulta">
            <h2><?php echo $titulo; ?></h2>

            <div class="grid_12" id="cabecera">
                <div class="grid_1">Id</div>
                <div class="grid_1">Titulación</div>
            </div>

            <?php foreach ($titulaciones as $titulaciones_item): ?>

        <div style="float:left;"><?php echo $titulaciones_item['iId']; ?></div>
        <div style="float:left;"><?php echo $titulaciones_item['sTitulacion']; ?></div>
        <br style="clear: both;">
<?php endforeach; ?>

        
        </div>
   </div>




</body>
</html>