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
        <link rel="stylesheet" href="<?=base_url()?>js/sweetalert/sweetalert.css">

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


                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li><a href="#">Usuarios</a></li>
                                <li class="active"><strong>Gestión de profesores</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
               
                <div class="container">

                    <button class="btn btn-success" onclick="add_profesor()">
                        <i class="glyphicon glyphicon-plus"></i> Profesor
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(usuario))">
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
                        <th>Apellidos</th>
                        <th>Rol</th>
                        <th>E-mail</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Rol</th>
                            <th>E-mail</th>
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
        <script src="<?=base_url()?>js/sweetalert/sweetalert.min.js"></script>

        <script type="text/javascript">
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
                        "search": "Buscar profesor: ",
                        "lengthMenu": "Mostrando _MENU_ profesores por página.",
                        "loadingRecords": "Cargando profesores",
                        "processing": "Cargando profesores",
                        "zeroRecords": "No se han encontrado profesores",
                        "emptyTable": "No hay profesores disponibles",
                        "info": "Mostrando profesores desde el _START_ hasta el _END_, de un total de _TOTAL_",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "infoEmpty": "Mostrando 0 de 0 profesores",
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
                        "url": "<?php echo site_url('index.php/Usuarios/ajax_list')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ -1,0,3 ], //last column
                        "orderable": false, //set not orderable
                    },
                    ],

                });
            });

            function add_profesor()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('#modal_form').modal('show'); // show bootstrap modal
                $("#sUsuario").prop("disabled", false);
                $('.modal-title').text('Añadir profesor'); // Set Title to Bootstrap modal title
            }

            function editar_cursos(iId)
            {
                save_method = 'update';
                $('#form_cursos')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo site_url('index.php/Usuarios/ajax_edit_cursos/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {

                        $('[name="iId_Usuario"]').val(data.iId);
                        $('[name="sNombre"]').val(data.sNombre); 
                        $('[name="sApellidos"]').val(data.sApellidos);
                        cargar_titulaciones();
                        $('#modal_form_cursos').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Editar cursos'); // Set title to Bootstrap modal title   

                        

                        table_cursos = $('#table_cursos').DataTable({ 
                        "bDestroy" : true,
                        "language": {                                                               
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "search": "Buscar curso: ",
                            "lengthMenu": "Mostrando _MENU_ cursos por página.",
                            "loadingRecords": "Cargando cursos",
                            "processing": "Cargando cursos",
                            "zeroRecords": "No se han encontrado cursos",
                            "emptyTable": "No hay cursos disponibles",
                            "info": "Cursos del _START_ hasta el _END_, (total de _TOTAL_)",
                            "sInfoFiltered":   "",
                            "infoEmpty": "Mostrando 0 de 0 profesores",
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
                            "url": "<?php echo site_url('index.php/Usuarios/ajax_list_cursos/')?>" + 
                            data.iId,
                            "type": "POST"
                        },

                        //Set column definition initialisation properties.
                        "columnDefs": [
                        { 
                            "targets": [ -1 ], //last column
                            "orderable": false, //set not orderable
                        },],
                        });
                        // Fin datatables para cursos  
                                              
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Oops! algo no fue bien ...", "Ocurrió un problema mientras se editaban los cursos.", "warning");
                    }
                });
            }

            function editar_usuario(iId)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo site_url('index.php/Usuarios/ajax_edit/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="iId"]').val(data.iId);
                        $('[name="sNombre"]').val(data.sNombre); 
                        $('[name="sApellidos"]').val(data.sApellidos);
                        $('[name="sUsuario"]').val(data.sUsuario);
                        $('[name="sPassword"]').val(data.sPassword); 
                        $('[name="sEmail"]').val(data.sEmail);
                        $("#sUsuario").prop("disabled", true);
                        $("#iAdmin").prop("checked", false);
                        $("#bActivo").prop("checked", false);
                        $("#bBloqueado").prop("checked", false);
                        if (data.iAdmin == 1) $("#iAdmin").prop("checked", true);
                        if (data.bActivo == 1) $("#bActivo").prop("checked", true);
                        if (data.bBloqueado == 1) $("#bBloqueado").prop("checked", true); 
                        $('[name="iAdmin"]').val(data.iAdmin);
                        $('[name="bActivo"]').val(data.bActivo);
                        $('[name="bBloqueado"]').val(data.bBloqueado);  

                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Editar profesor'); // Set title to Bootstrap modal title                            
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                       swal("Oops! algo no fue bien ...", "Ocurrió un problema mientras se editaba el usuario.", "warning");
                    }
                });
            }


            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }

            function reload_table_cursos()
            {
                table_cursos.ajax.reload(null,false); //reload datatable ajax 
            }

            function eliminar_todos(pregunta) {
                swal({
                    title: "¿Estás seguro/a?",
                    text: "Si existen dependencias, no podrá eliminarse el registro.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Preguntas/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.usuario:checked').serialize(),
                            success: function(data) {

                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    swal("Bien!", "Operación realizada con éxito", "success");
                                    reload_table();

                                } else {
                                    swal("Oops! algo no ha ido bien ...", data.error_string, "warning");
                                } 
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "No se han podido eliminar algunos o todos los registros. Asegúrese que ha señalado algún registro.", "warning");
                            }
                        });
                    });
            }

            function save()
            {
                $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                $('#btnSave').attr('disabled',true); // Desactivar botón.
                var url;

                if(save_method == 'add') {
                    url = "<?php echo site_url('index.php/Usuarios/ajax_add')?>";
                } else {
                    url = "<?php echo site_url('index.php/Usuarios/ajax_update')?>";
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
                            swal("Bien!", "Operación realizada con éxito", "success");
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
                        swal("Oops! algo no fue bien ...", "No se ha podido actualizar el registro. Inténtelo más tarde.", "warning");
                        $('#btnSave').text('Guardar');
                        $('#btnSave').attr('disabled',false); 
                    }
                });
            }

            function save_cursos()
            {
                $('#btnSaveCursos').text('guardando ...'); // Cambiar valor del texto
                $('#btnSaveCursos').attr('disabled',true); // Desactivar botón.
                var url;
                var iId_Usuario = $('#iId_Usuario').val();
                url = "<?php echo site_url('index.php/Usuarios/ajax_add_curso/')?>"+iId_Usuario,

                // AJAX añade datos a la base de datos.
                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#form_cursos').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status) //if success close modal and reload ajax table
                        {
                            //$('#modal_form').modal('hide');
                            swal("Bien!", "Operación realizada con éxito", "success");
                            reload_table_cursos();
                        }
                        else
                        {
                            for (var i = 0; i < data.inputerror.length; i++) 
                            {
                                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                            }
                        }
                        $('#btnSaveCursos').text('Guardar');
                        $('#btnSaveCursos').attr('disabled',false); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Oops! algo no fue bien ...", "No se ha podido actualizar el registro. Inténtelo más tarde.", "warning");
                        $('#btnSaveCursos').text('Guardar');
                        $('#btnSaveCursos').attr('disabled',false); 
                    }
                });
            }

            function borrar_usuario(iId)
            {
                swal({
                    title: "¿Estás seguro/a?",
                    text: "Debe saber, que si el profesor está asociado a una o más partidas, no podrá ser eliminado.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){                
                        $.ajax({
                            url : "<?php echo site_url('index.php/Usuarios/ajax_delete')?>/"+iId,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    swal("Bien!", "Operación realizada con éxito", "success");
                                    reload_table();
                                } else {
                                    swal("Bien!", data.error_string, "success");
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "No se ha podido eliminar el profesor, asegúrese que no participa en ninguna partida antes de volver a intentarlo.", "warning");
                            }
                        });
                    });
            } 
              


            function borrar_curso(iId)
            {
                swal({
                    title: "¿Estás seguro/a?",
                    text: "¿Desea eliminar este curso realmente?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){ 
                        $.ajax({
                            url : "<?php echo site_url('index.php/Usuarios/ajax_delete_curso')?>/"+iId,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    //$('#modal_form_cursos').modal('hide');
                                    swal("Bien!", "Operación realizada con éxito", "success");
                                    reload_table_cursos();
                                } else {
                                    swal("Bien!", data.error_string, "success");
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "No hemos podido eliminar el curso, inténtelo más tarde.", "warning");
                            }
                        });
                    });
            } 

            // Para recargar titulaciones

            function cargar_titulaciones(iId)
            {  
                var iId_Universidad = $("#universidades option:selected").attr("value");
                $.get("<?php echo site_url('index.php/Usuarios/ajax_recarga_titulaciones')?>",
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
                $.get("<?php echo site_url('index.php/Usuarios/ajax_recarga_asignaturas')?>",
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

        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Alta de profesor</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="iId"/> 
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('Nombre * '); ?>
                                        <input tabindex="1" name="sNombre" placeholder="Nombre" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Apellidos * '); ?>
                                        <input tabindex="2" name="sApellidos" placeholder="Apellidos" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('Usuario * '); ?>
                                        <input tabindex="3" id="sUsuario" name="sUsuario" placeholder="Nombre de usuario" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Contraseña * '); ?>
                                        <input tabindex="4" name="sPassword" placeholder="Contraseña" class="form-control" type="password">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?=form_label('E-mail * '); ?>
                                        <input tabindex="5" name="sEmail" placeholder="Correo Electrónico" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                        
                                <input tabindex="6" type="checkbox" id="iAdmin" 
                                    name="iAdmin[]" value="0">&nbsp;Hacer administrador
                                <input tabindex="7" type="checkbox" id="bActivo" name="bActivo[]" value="1">&nbsp;Activo
                                <input tabindex="8" type="checkbox" id="bBloqueado" name="bBloqueado[]" value="2">&nbsp;Bloqueado

                            
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

        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form_cursos" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Añadir curso</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form_cursos" class="form-horizontal">
                            <input type="hidden" name="csrf" value="<?php echo $this->session->userdata('token');?>">
                            <input type="hidden" value="" id="iId_Usuario" name="iId_Usuario"/> 
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <?=form_label('Nombre'); ?>
                                        <input name="sNombre" class="form-control" disabled="true">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <?=form_label('Apellidos'); ?>
                                        <input name="sApellidos" class="form-control" disabled="true">
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

                                </form>

                                <!-- Tabla de cursos -->
                                <button class="btn btn-default" onclick="reload_table_cursos()">
                                <i class="glyphicon glyphicon-refresh"></i> Refrescar
                                </button>

                                <br />
                                <br />

                                <table id="table_cursos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Universidad</th>
                                    <th>Titulación</th>
                                    <th>Asignatura</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                                <tfoot>
                                    <tr>
                                    <th>Universidad</th>
                                    <th>Titulación</th>
                                    <th>Asignatura</th>
                                    <th>Acción</th>
                                    </tr>
                                </tfoot>
                                </table>

                                <!-- Fin de la tabla de cursos -->

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <sub><b>*</b> Datos obligatorios.</sub>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSaveCursos" onclick="save_cursos()" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
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
