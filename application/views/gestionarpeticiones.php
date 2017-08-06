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
                            <li><a href="#">Curso</a></li>
                            <li class="active"><strong>Gestión de Peticiones de los Usuarios</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

                <div class="container">
                    

                     <button class="btn btn-warning" onclick="eliminar_todos($(peticion))">
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
                        <th>Petición</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Atendida</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Petición</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Atendida</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    </table>

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
                                "search": "Buscar petición: ",
                                "lengthMenu": "Mostrando _MENU_ peticiones por página.",
                                "loadingRecords": "Cargando peticiones",
                                "processing": "Cargando peticiones",
                                "zeroRecords": "No se han encontrado registros",
                                "emptyTable": "No hay peticiones disponibles",
                                "info": "Mostrando _START_ de _END_ peticiones, de un total de _TOTAL_",
                                "infoEmpty": "Mostrando 0 de 0 peticiones",
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
                                "url": "<?php echo site_url('index.php/Gestionarpeticiones/ajax_list')?>",
                                "type": "POST"
                            },

                            //Set column definition initialisation properties.
                            "columnDefs": [
                            { 
                                "targets": [ -1, 0 ], //last column
                                "orderable": false, //set not orderable
                            },
                            ],

                        });

                        //set input/textarea/select event when change value, remove class error and remove text help block 
                        $("input").change(function(){
                            $(this).parent().parent().removeClass('has-error');
                            $(this).next().empty();
                        });                       

                    });

                    function ver_respuesta(iId)
                    {
                        $('#form_respuesta')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string

                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('index.php/Gestionarpeticiones/ajax_edit/')?>/" + iId,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                // $('[name="sRespuesta"]').prop("disabled", true);
                                $('[name="sRespuesta"]').val(data.sRespuesta);
                                html = "<b><i>Atendida el:</i></b> "+ data.dFecha_Respuesta;
                                if (data.bLeido == 1)
                                    html += "<br><i>(Leída por el usuario)</i>";

                                $('#dFecha_Respuesta').html(html);
                                $('#modal_form_respuesta').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Ver respuesta'); // Set title to Bootstrap modal title
                                $('#btnSave_respuesta').attr('disabled',true); // Desactivar botón.
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaban recuperar los datos. Inténtelo más tarde.", "warning");
                            }
                        });
                    }

                    function ver_peticion(iId)
                    {
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string

                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('index.php/Gestionarpeticiones/ajax_edit/')?>/" + iId,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                $('[name="iId_Peticion"]').val(data.iId_Peticion);
                                cargar_requerimiento();
                                $('[name="iId_Peticion"]').prop("disabled", true);
                                $('[name="sAsunto"]').val(data.sAsunto);  
                                $('[name="sPeticion"]').val(data.sPeticion); 
                               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Ver petición'); // Set title to Bootstrap modal title
                                $('#btnSave').attr('disabled',true); // Desactivar botón.
                                

                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaban recuperar los datos. Inténtelo más tarde.", "warning");
                            }
                        });
                    }

                    function responder_peticion(iId)
                    {
                        $('#form_respuesta')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('index.php/Gestionarpeticiones/ajax_edit_respuesta/')?>" + iId,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {

                            $('[name="iId_Solicitud"]').val(data.iId);  
                            $('#btnSave_respuesta').attr('disabled',false);
                            $('#modal_form_respuesta').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Enviar respuesta'); // Set title to Bootstrap modal title                     
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaban recuperar los datos. Inténtelo más tarde.", "warning");
                            }
                        });
                    }

                    function add_peticion()
                    {
                        save_method = 'add';
                        $('#form')[0].reset(); // reset form on modals
                        $("#tipospeticiones").prop("disabled", false);
                        $('#btnSave').attr('disabled',false); 
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        cargar_requerimiento();
                        $('#modal_form').modal('show'); // show bootstrap modal
                        $('.modal-title').text('Añadir titulación'); // Set Title to Bootstrap modal title
                    }


                    function reload_table()
                    {
                        table.ajax.reload(null,false); //reload datatable ajax 
                    }

                    function save()
                    {
                        $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                        $('#btnSave').attr('disabled',true); // Desactivar botón.
                        var url;
                         url = "<?php echo site_url('index.php/Gestionarpeticiones/ajax_add')?>";
                        
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
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error al intentar modificar/añadir el registro. Inténtelo más tarde.", "warning");
                                $('#btnSave').text('Guardar');
                                $('#btnSave').attr('disabled',false); 

                            }
                        });
                    } 

                    function save_respuesta()
                    {
                        $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                        $('#btnSave').attr('disabled',true); // Desactivar botón.
                        var url;
                         url = "<?php echo site_url('index.php/Gestionarpeticiones/ajax_add_respuesta')?>";
                        
                        // AJAX añade datos a la base de datos.

                        $.ajax({
                            url : url,
                            type: "POST",
                            data: $('#form_respuesta').serialize(),
                            dataType: "JSON",
                            success: function(data)
                            {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form_respuesta').modal('hide');
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
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error al intentar modificar/añadir el registro. Inténtelo más tarde.", "warning");
                                $('#btnSave').text('Guardar');
                                $('#btnSave').attr('disabled',false); 

                            }
                        });
                    } 

                    function borrar_peticion(iId)
                    {
                        swal({
                            title: "¿Estás seguro/a?",
                            text: "¿Estás seguro/a que desea eliminar esta petición? Si lo hace, dicha petición quedará sin resolver y el usuario afectado no podrá resolver su incidencia, de no haberlo hecho antes de ejecutar esta acción.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Borrar",
                            cancelButtonText: "No, dejarlo como está",
                            closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Gestionarpeticiones/ajax_delete')?>/"+iId,
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
                                            swal("Oops! algo no ha ido bien ...", data.error_string, "warning");
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {
                                        swal("Oops! algo no fue bien ...", "Ha ocurrido un error al intentar eliminar la petición. Inténtelo más tarde.", "warning");
                                    }
                                });
                            }); 
                    }

                    function eliminar_todos(pregunta) {
                        swal({
                            title: "¿Estás seguro/a?",
                            text: "¿Estás seguro/a que quieres eliminar las peticiones señaladas? Si borras estas peticiones, asegúrese que hayan sido satisfechas, de lo contrario, el usuario quedará con la incidencia sin resolver.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Borrar",
                            cancelButtonText: "No, dejarlo como está",
                            closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Gestionarpeticiones/ajax_delete_todos')?>/",
                                    type : "POST",
                                    dataType : "JSON",
                                    data : $('.peticion:checked').serialize(),
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
                                        swal("Oops! algo no fue bien ...", "Error al eliminar el registro. Asegúrese que ha señalado algún registro.", "warning");
                                    }
                                });
                            });
                    }


                    function cargar_requerimiento()
                    {  
                        var iId_Peticion = $("#tipospeticiones option:selected").attr("value");
                        $.get("<?php echo site_url('index.php/Gestionarpeticiones/ajax_recarga_requerimiento')?>",
                            {"peticion":iId_Peticion}, function(data) {
                                var resultado = JSON.parse(data);
                                for (datos in resultado.peticion) {
                                    if (resultado.peticion[datos].sRequerimientos != "")
                                        $('#sRequerimiento').html(resultado.peticion[datos].sRequerimientos);
                                    else 
                                        $('#sRequerimiento').html("Sin requerimientos especiales.");
                                }
                            });
                    }                        
                </script>

                <!-- Bootstrap modal -->
                <div class="modal fade" id="modal_form" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Alta de asignatura</h3>
                            </div>
                            <div class="modal-body form">
                                <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                                    <input type="hidden" value="" name="iId"/> 
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tipo *</label>
                                            <div class="col-md-9">
                                             <?php $atributos = 'class=form-control id="tipospeticiones" onChange="cargar_requerimiento();"'; ?>
                                            <?=form_dropdown('iId_Peticion', $tipospeticiones, '', $atributos); ?>
                                            <span class="help-block"></span>
                                        </div>
                                     </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><strong>Requerimientos</strong></label>
                                            <div class="col-md-9">
                                                <div id="sRequerimiento"></div>
                                                
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Asunto *</label>
                                            <div class="col-md-9">
                                                <input name="sAsunto" placeholder="Asunto" class="form-control" type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Su petición *</label>
                                            <div class="col-md-9">
                                                <textarea name="sPeticion" class="form-control" placeholder="Texto de la solicitud aquí"></textarea>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                                                                                                                              
                                         <div class="form-group">
                                            <div class="col-md-9">
                                                <sub><b>*</b> Datos obligatorios.</sub>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>


                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- End Bootstrap modal -->

                <!-- Bootstrap modal para responder -->
                <div class="modal fade" id="modal_form_respuesta" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Alta de asignatura</h3>
                            </div>
                            <div class="modal-body form">
                                <form action="#" id="form_respuesta" class="form-horizontal" enctype="multipart/form-data">
                                    <input type="hidden" value="" name="iId_Solicitud"/> 
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Respuesta *</label>
                                            <div class="col-md-9">
                                                <textarea name="sRespuesta" class="form-control" placeholder="Texto de la respusta aquí" rows="5"></textarea>
                                                <span class="help-block"></span><br>
                                                <div id="dFecha_Respuesta"></div>
                                            </div>
                                        </div>                                                                                             
                                         <div class="form-group">
                                            <div class="col-md-9">
                                                <sub><b>*</b> Datos obligatorios.</sub> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave_respuesta" onclick="save_respuesta()" class="btn btn-primary">Responder</button>
                                <button type="button" id="btnCancel_respuesta" class="btn btn-danger" data-dismiss="modal">Salir</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- End Bootstrap modal -->

               
                   
                    
                <hr class="short">
                    
            </div>
            <?php $this->load->view('footer');?>
        </div>

        <!-- Libs -->
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
        
        <!-- Theme Initializer -->
        <script src="<?=base_url()?>js/theme.plugins.js"></script>
        <script src="<?=base_url()?>js/theme.js"></script>
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>



    </body>
</html>
