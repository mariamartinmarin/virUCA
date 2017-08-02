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
                                    <li><a href="#">Paneles</a></li>
                                    <li class="active">Listado</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de paneles</h2>
                            </div>
                        </div>
                    </div>
                </section>
               
                <div class="container">
                   
                    <button class="btn btn-success" onclick="add_panel()">
                        <i class="glyphicon glyphicon-plus"></i> Panel
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(panel))">
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
                        <th>Nombre</th>
                        <th>Nº Casillas</th>
                        <th>Titulación</th>
                        <th>Asignatura</th>
                        <th>Activo</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Nº Casillas</th>
                            <th>Titulación</th>
                            <th>Asignatura</th>
                            <th>Activo</th>
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
                        "search": "Buscar panel: ",
                        "lengthMenu": "Mostrando _MENU_ paneles por página.",
                        "loadingRecords": "Cargando paneles",
                        "processing": "Cargando paneles",
                        "zeroRecords": "No se han encontrado paneles",
                        "emptyTable": "No hay paneles disponibles",
                        "info": "Paneles del _START_ al _END_, (total de _TOTAL_)",
                        "sInfoFiltered":   "",
                        "infoEmpty": "Mostrando 0 de 0 paneles",
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
                        "url": "<?php echo site_url('index.php/Paneles/ajax_list')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ -1, 0, 5 ], //last column
                        "orderable": false, //set not orderable
                    },
                    ],

                });
            });

            function add_panel()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                cargar_titulaciones();
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Añadir panel'); // Set Title to Bootstrap modal title
            }

             function save()
            {
                $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                $('#btnSave').attr('disabled',true); // Desactivar botón.
                var url;

                if(save_method == 'add') {
                    url = "<?php echo site_url('index.php/Paneles/ajax_add')?>";
                } else {
                    url = "<?php echo site_url('index.php/Paneles/ajax_update')?>";
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

            function editar_panel(iId)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo site_url('index.php/Paneles/ajax_edit/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="iId"]').val(data.iId);
                        $('[name="sNombre"]').val(data.sNombre); 
                        $('[name="iCasillas"]').val(data.iCasillas);
                        $('[name="iId_Universidad"]').val(data.iId_Universidad);
                        $('[name="iId_Titulacion"]').val(data.iId_Titulacion); 
                        $('[name="iId_Asignatura"]').val(data.iId_Asignatura);
                        //$("#bActivo").prop("checked", false);
                        if (data.bActivo == 1) $("#bActivo").prop("checked", true);
                        $('[name="bActivo"]').val(data.bActivo);
                        
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Editar alumno'); // Set title to Bootstrap modal title                            
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        bootbox.alert('Ocurrió un error mientras se intentaba editar el alumno.');
                    }
                });
            }


            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }


            function eliminar_todos(pregunta) {
                alert(pregunta);
                bootbox.confirm("¿Estás seguro/a que quieres eliminar los alumnos seleccionados? Recuerde que si existen dependencias, no podrá eliminarse el registro.",

                function(result) {
                    if (result == true) {
                        $.ajax({
                            url : "<?php echo site_url('index.php/Alumnos/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.usuario:checked').serialize(),
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

            function borrar_panel(iId)
            {
                bootbox.confirm("¿Estás seguro/a que desea eliminar este panel? Debe saber que si el panel está asociado a una partida, no podrá borrarlo a efectos de estadísticas. Para proceder, tendrá que borrar manualmente las partidas.", 
                function(result){ 
                    if (result == true) {
                        // AJAX borra los datos de la base de datos.
                        $.ajax({
                            url : "<?php echo site_url('index.php/Paneles/ajax_delete')?>/"+iId,
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
                                bootbox.alert('Error al eliminar el profesor. Asegúrese que no participa en una o más partidas e inténtelo más tarde.');
                            }
                        });
                    } 
                });
            }


            function borrar_curso(iId)
            {
                bootbox.confirm("¿Estás seguro/a que desea eliminar este curso?", 
                function(result){ 
                    if (result == true) {
                        $.ajax({
                            url : "<?php echo site_url('index.php/Alumnos/ajax_delete_curso')?>/"+iId,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    //$('#modal_form_cursos').modal('hide');
                                    bootbox.alert("Operación realizada con éxito.");
                                    reload_table_cursos();
                                } else {
                                    bootbox.alert({
                                        message: data.error_string
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                bootbox.alert('Error al eliminar el curso.');
                            }
                        });
                    } 
                });
            }

            // Para recargar titulaciones

            function cargar_titulaciones(iId)
            {  
                var iId_Universidad = $("#universidades option:selected").attr("value");
                $.get("<?php echo site_url('index.php/Alumnos/ajax_recarga_titulaciones')?>",
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

                $.get("<?php echo site_url('index.php/Alumnos/ajax_recarga_asignaturas')?>",
                    {"titulacion":iId_Titulacion}, function(data) {
                        var asignaturas = "";
                        var asignatura = JSON.parse(data);
                        for (datos in asignatura.asignaturas) {
                            asignaturas += '<option value="'+asignatura.asignaturas[datos].iId+'">'+
                            asignatura.asignaturas[datos].sNombre+'</option>';
                        }
                        $('select#asignaturas').html(asignaturas);
                    });
            }
        </script>

        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Alta de alumno</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="iId"/> 
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('Nombre * '); ?>
                                        <input name="sNombre" placeholder="Nombre" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Nº de casillas * '); ?>
                                        <input name="iCasillas" placeholder="Casillas" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Universidad *</label>
                                    <div class="col-md-9">
                                        <?php $atributos = 'class=form-control id="universidades" onChange="cargar_titulaciones();"'; ?>
                                        <?=form_dropdown('iId_Universidad', $universidades, '', $atributos); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Titulación *</label>
                                    <div class="col-md-9">
                                        <?php $atributos2 = 'class=form-control id="titulaciones"
                                        onChange="cargar_asignaturas();"'; ?>
                                        <?=form_dropdown('iId_Titulacion', $titulaciones, '', $atributos2); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label col-md-3">Asignatura *</label>
                                    <div class="col-md-9">
                                        <?php $atributos3 = 'class=form-control id="asignaturas"'; ?>
                                        <?=form_dropdown('iId_Asignatura', $asignaturas, '', $atributos3); ?>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            
                                <input type="checkbox" id="bActivo" name="bActivo[]" value="1">&nbsp;Activo

                            
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
