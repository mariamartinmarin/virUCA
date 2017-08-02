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

        <!-- Fuente  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Libs CSS -->
        <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
       
        <link rel="stylesheet" href="<?=base_url('js/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

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
                                    <li><a href="#">Preguntas</a></li>
                                    <li class="active">Gestión de preguntas</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de preguntas</h2>
                            </div>
                        </div>
                    </div>
                </section>
               
                <div class="container">

                    <button class="btn btn-success" onclick="add_pregunta()">
                        <i class="glyphicon glyphicon-plus"></i> Pregunta
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(pregunta))">
                        <i class="glyphicon glyphicon-trash"></i> Eliminar todos
                    </button>
                    <button class="btn btn-default" onclick="reload_table()">
                        <i class="glyphicon glyphicon-refresh"></i> Refrescar
                    </button>

                    <br />
                    <br />

                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Pregunta</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Categoría</th>
                        <th>Puntuación</th>
                        <th style="width:200px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Pregunta</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Categoría</th>
                            <th>Puntuación</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    </table>

                </div>
                </div>
            <?php $this->load->view('footer');?>
        </div>

        <script src="<?=base_url('vendor/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?=base_url('js/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('js/datatables/js/dataTables.bootstrap.js')?>"></script>
        <script src="<?=base_url()?>js/bootbox/boot.activate.js"></script>
        <script src="<?=base_url()?>js/bootbox/bootbox.min.js"></script>

        <script type="text/javascript">
            bootbox.setDefaults({
                locale: "es"
            });

            var save_method; // Para el uso del método save.
            var table;

            $(document).ready(function() {

                //datatables
                table = $('#table').DataTable({ 
                    "language": {
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "search": "Buscar pregunta: ",
                        "lengthMenu": "Mostrando _MENU_ preguntas por página.",
                        "loadingRecords": "Cargando preguntas",
                        "processing": "Cargando preguntas",
                        "zeroRecords": "No se han encontrado preguntas",
                        "emptyTable": "No hay preguntas disponibles",
                        "info": "Mostrando _START_ de _END_ preguntas, de un total de _TOTAL_",
                        "infoEmpty": "Mostrando 0 de 0 preguntas",
                        "aria": {
                            "sortAscending": ": ordenar columna ascendentemente",
                            "sortDescending": ": ordenar columna descendentemente"
                        }
                    },
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('index.php/Preguntas/ajax_list')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ -1 ], //last column
                        "orderable": false, //set not orderable
                    },
                    ],

                });

                //set input/textarea/select event when change value, remove class error and remove text help block 
                $("input").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });

            });

            function add_pregunta()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                cargar_titulaciones();
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Añadir pregunta'); // Set Title to Bootstrap modal title
            }

            function editar_pregunta(iId)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/ajax_edit/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {

                        $('[name="iId"]').val(data.iId);
                        $('[name="sPregunta"]').val(data.sPregunta); 
                        $('[name="iId_Universidad"]').val(data.iId_Universidad);
                        //scargar_titulaciones();
                        $('[name="iId_Titulacion"]').val(data.iId_Titulacion);
                        $('[name="iId_Asignatura"]').val(data.iId_Asignatura);
                        $('[name="iId_Categoria"]').val(data.iId_Categoria);

                        $('[name="sObservaciones"]').val(data.sObservaciones);
                        $('[name="nPuntuacion"]').val(data.nPuntuacion);                           
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaba editar la pregunta.');
                    }
                });

                $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/ajax_editA/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="sResp1"]').val(data.sRespuesta);                                
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaban recuperar las respuestas.');
                    }
                });

                $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/ajax_editB/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="sResp2"]').val(data.sRespuesta);                                
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaban recuperar las respuestas.');
                    }
                });

                $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/ajax_editC/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="sResp3"]').val(data.sRespuesta);                                
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaban recuperar las respuestas.');
                    }
                });

                 $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/ajax_editD/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="sResp4"]').val(data.sRespuesta);                                
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaban recuperar las respuestas.');
                    }
                });

                $.ajax({
                    url : "<?php echo site_url('index.php/Preguntas/obtener_verdadera/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        switch (data.iOrden) {
                            case '1':  $("#bVerdadera1").prop("checked", true); break;
                            case '2':  $("#bVerdadera2").prop("checked", true); break;
                            case '3':  $("#bVerdadera3").prop("checked", true); break;
                            case '4':  $("#bVerdadera4").prop("checked", true); break;
                            default:  $("#bVerdadera1").prop("checked", true); break;
                        }
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Editar pregunta'); // Set title to Bootstrap modal title
                                            
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaban recuperar las respuestas.');
                    }
                });
            }

            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }

            function eliminar_todos(pregunta) {
                bootbox.confirm("¿Estás seguro/a que quieres eliminar las preguntas? Recuerde que si existen dependencias, no podrá eliminarse el registro.",

                function(result) {
                    if (result == true) {
                        $.ajax({
                            url : "<?php echo site_url('index.php/Preguntas/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.pregunta:checked').serialize(),
                            success: function(data) {

                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    bootbox.alert("Operación realizada con éxito.");
                                    reload_table();

                                } else {
                                    bootbox.alert({
                                        message: data.error_string
                                    });
                                } 
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                bootbox.alert('Error al eliminar el registro. Asegúrese que ha señalado algún registro.');
                            }
                        });
                    }
                });
            }

            function save()
            {
                $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                $('#btnSave').attr('disabled',true); // Desactivar botón.
                var url;

                if(save_method == 'add') {
                    url = "<?php echo site_url('index.php/Preguntas/ajax_add')?>";
                } else {
                    url = "<?php echo site_url('index.php/Preguntas/ajax_update')?>";
                }

                // AJAX añade datos a la base de datos.
                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status) //if success close modal and reload ajax table
                        {
                            $('#modal_form').modal('hide');
                            bootbox.alert("Operación realizada con éxito.");
                            reload_table();
                        }
                        else
                        {
                            for (var i = 0; i < data.inputerror.length; i++) 
                            {
                                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                            }
                        }
                        $('#btnSave').text('Guardar');
                        $('#btnSave').attr('disabled',false); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Se ha producido un error al intentar añadir/modificar el registro.');
                        $('#btnSave').text('Guardar');
                        $('#btnSave').attr('disabled',false); 
                    }
                });
            }

            function borrar_pregunta(iId)
            {
                bootbox.confirm("¿Estás seguro/a que desea eliminar esta pregunta? Debe saber, que si lo hace, se eliminará la pregunta del seguimiento de las partidas y no podrá ser recuperada de nuevo.", 
                function(result){ 
                    if (result == true) {
                        // AJAX borra los datos de la base de datos.
                        $.ajax({
                            url : "<?php echo site_url('index.php/Pregunta/ajax_delete')?>/"+iId,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    bootbox.alert("Operación realizada con éxito.");
                                    reload_table();
                                } else {
                                    bootbox.alert({
                                        message: data.error_string
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                bootbox.alert('Error al eliminar la pregunta. Inténtelo más tarde.');
                            }
                        });
                    } 
                });
            }

            // Para los selects

            // Para recargar titulaciones

            function cargar_titulaciones(iId)
            {  
                var iId_Universidad = $("#universidades option:selected").attr("value");
                $.get("<?php echo site_url('index.php/Preguntas/ajax_recarga_titulaciones')?>",
                    {"universidad":iId_Universidad}, function(data) {
                        var titulaciones = "";
                        var titulacion = JSON.parse(data);
                        for (datos in titulacion.titulaciones) {
                            titulaciones += '<option value="'+titulacion.titulaciones[datos].iId+'">'+
                            titulacion.titulaciones[datos].sTitulacion+'</option>';
                        }
                        $('select#titulaciones').html(titulaciones);
                        cargar_asignaturas();
                    });
            } 

            // Para recargar titulaciones

            function cargar_asignaturas(iId)
            {  
                var iId_Titulacion = $("#titulaciones option:selected").attr("value");

                $.get("<?php echo site_url('index.php/Preguntas/ajax_recarga_asignaturas')?>",
                    {"titulacion":iId_Titulacion}, function(data) {
                        var asignaturas = "";
                        var asignatura = JSON.parse(data);
                        for (datos in asignatura.asignaturas) {
                            asignaturas += '<option value="'+asignatura.asignaturas[datos].iId+'">'+
                            asignatura.asignaturas[datos].sNombre+'</option>';
                        }
                        $('select#asignaturas').html(asignaturas);
                        cargar_categorias();
                    });
            }

            // Para cargar las categorias

            function cargar_categorias(iId)
            {  
                var iId_Asignatura = $("#asignaturas option:selected").attr("value");

                $.get("<?php echo site_url('index.php/Preguntas/ajax_recarga_categorias')?>",
                    {"asignatura":iId_Asignatura}, function(data) {
                        var categorias = "";
                        var categoria = JSON.parse(data);
                        for (datos in categoria.categorias) {
                            categorias += '<option value="'+categoria.categorias[datos].iId+'">'+
                            categoria.categorias[datos].sCategoria+'</option>';
                        }
                        $('select#categorias').html(categorias);
                    });
            }
        </script>

        <!-- Bootstrap modal -->
      <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Alta de pregunta</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="iId"/> 
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?=form_label('Pregunta * '); ?>
                                        <input name="sPregunta" placeholder="Pregunta" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-9">
                                        <?php $atributos = 'class=form-control id="universidades" onChange="cargar_titulaciones();"'; ?>
                                        <?=form_label('Universidad * '); ?>
                                        <?=form_dropdown('iId_Universidad', $universidades, '', $atributos); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?php $atributos2 = 'class=form-control id="titulaciones"
                                        onChange="cargar_asignaturas();"'; ?>
                                        <?=form_label('Titulación * '); ?>
                                        <?=form_dropdown('iId_Titulacion', $titulaciones, '', $atributos2); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?php $atributos3 = 'class=form-control id="asignaturas"
                                        onChange="cargar_categorias();"'; ?>
                                        <?=form_label('Asignatura * '); ?>
                                        <?=form_dropdown('iId_Asignatura', $asignaturas, '', $atributos3); ?>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Categorías * '); ?>
                                        <?php $atributos4 = 'class=form-control id="categorias"' ?>
                                        <?=form_dropdown('iId_Categoria', $categorias, '', $atributos4); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?=form_label('Respuesta A * '); ?>
                                        <input name="sResp1" placeholder="" class="form-control" type="text">
                                        <span class="help-block"></span>
                                        <?=form_label('Respuesta B * '); ?>
                                        <input name="sResp2" placeholder="" class="form-control" type="text">
                                        <span class="help-block"></span>
                                        <?=form_label('Respuesta C * '); ?>
                                        <input name="sResp3" placeholder="" class="form-control" type="text">
                                        <span class="help-block"></span>
                                        <?=form_label('Respuesta D * '); ?>
                                        <input name="sResp4" placeholder="" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('¿Cuál es la respuesta verdadera? '); ?><br> 
                                        <input type="radio" id="bVerdadera1" name="bVerdadera" value="1" checked="">&nbsp;A
                                        <input type="radio" id="bVerdadera2" name="bVerdadera" value="2" 
                                                                        style="margin-left:15px;">&nbsp;B
                                        <input type="radio" id="bVerdadera3" name="bVerdadera" value="3" 
                                                                        style="margin-left:15px;">&nbsp;C
                                        <input type="radio" id="bVerdadera4" name="bVerdadera" value="4" 
                                                                        style="margin-left:15px;">&nbsp;D
                                        
                                    </div>
                                </div>  
                                
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('Observaciones '); ?>
                                        <textarea name="sObservaciones" placeholder="Observaciones" 
                                            class="form-control" type="text" rows="4"></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Puntuación '); ?>
                                        <input name="nPuntuacion" placeholder="" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <sub><b>*</b> Datos obligatorios.</sub>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->

                <!-- AJAX -->



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

       
    </body>
</html>
