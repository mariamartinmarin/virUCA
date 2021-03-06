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

        <!-- Libs CSS -->
        <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
       
        <link rel="stylesheet" href="<?=base_url('js/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/theme.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-elements.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-shop.css">

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
                            <li class="active"><strong>Gestión de Asignaturas</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

                <div class="container">

                    <button class="btn btn-success" onclick="add_asignatura()">
                        <i class="glyphicon glyphicon-plus"></i> Asignatura
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(asignatura))">
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
                        <th>Asignatura</th>
                        <th>Titulación</th>
                        <th>Universidad</th>
                        <th style="width:200px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Asignatura</th>
                            <th>Titulación</th>
                            <th>Universidad</th>
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
                                "search": "Buscar asignatura: ",
                                "lengthMenu": "Mostrando _MENU_ asignaturas por página.",
                                "loadingRecords": "Cargando asignaturas",
                                "processing": "Cargando asignaturas",
                                "zeroRecords": "No se han encontrado registros",
                                "emptyTable": "No hay asignaturas disponibles",
                                "info": "Mostrando _START_ de _END_ asignaturas, de un total de _TOTAL_",
                                "infoEmpty": "Mostrando 0 de 0 asignaturas",
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
                                "url": "<?php echo site_url('index.php/Asignatura/ajax_list')?>",
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

                    function add_asignatura()
                    {
                        save_method = 'add';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        $('#modal_form').modal('show'); // show bootstrap modal
                        $('.modal-title').text('Añadir asignatura'); // Set Title to Bootstrap modal title
                         $.ajax({
                            url : "<?php echo site_url('index.php/Asignatura/ajax_obtener_universidad/')?>/",
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                cargar_titulaciones(data.iId_Universidad);
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaba insertar la asignatura. Inténtelo más tarde.", "warning");
                            }
                        });
                    }

                    function editar_asignatura(iId)
                    {
                        save_method = 'update';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string

                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('index.php/Asignatura/ajax_edit/')?>/" + iId,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                $('[name="iId"]').val(data.iIdAsignatura);
                                $('[name="sNombre"]').val(data.sNombre);  
                                                              
                                $('[name="iId_Titulacion"]').val(data.iId_Titulacion);
                                $('[name="iId_Universidad"]').val(data.iId_Universidad);
                                cargar_titulaciones_aux(data.iId_Universidad, data.iId_Titulacion);
                                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Editar asignatura'); // Set title to Bootstrap modal title
                                

                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaba editar la asignatura. Inténtelo más tarde.", "warning");
                            }
                        });
                    }

                    function reload_table()
                    {
                        table.ajax.reload(null,false); //reload datatable ajax 
                    }

                    function eliminar_todos(asignatura) {
                        swal({
                            title: "¿Estás seguro/a?",
                            text: "¿Desea eliminar las asignaturas señaladas? Debe saber que hay asignaturas que no podrán eliminarse dado que tienen dependencias.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Borrar",
                            cancelButtonText: "No, dejarlo como está",
                            closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Asignatura/ajax_delete_todos')?>/",
                                    type : "POST",
                                    dataType : "JSON",
                                    data : $('.asignatura:checked').serialize(),
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
                                        swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaba eliminar los registros. Asegúrese que ha marcado alguno y que no existen dependencias.", "warning");
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
                            url = "<?php echo site_url('index.php/Asignatura/ajax_add')?>";
                        } else {
                            url = "<?php echo site_url('index.php/Asignatura/ajax_update')?>";
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
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error al intentar modificar/añadir el registro. Inténtelo más tarde.", "warning");
                                $('#btnSave').text('Guardar');
                                $('#btnSave').attr('disabled',false); 

                            }
                        });
                    }

                    function borrar_asignatura(iId)
                    {
                        swal({
                            title: "¿Estás seguro/a?",
                            text: "Desea eliminar esta asignatura?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Borrar",
                            cancelButtonText: "No, dejarlo como está",
                            closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Asignatura/ajax_delete')?>/"+iId,
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
                                        swal("Oops! algo no fue bien ...", "Ocurrió un error al intentar eliminar la asignatura. Inténtelo más tarde.", "warning");
                                    }
                                });
                            }); 
                    }

                    function cargar_titulaciones(iId)
                    {  
                        var iId_Universidad = $("#universidades option:selected").attr("value");
                        $.get("<?php echo site_url('index.php/Asignatura/ajax_recarga_titulaciones')?>",
                            {"universidad":iId_Universidad}, function(data) {
                                var titulaciones = "";
                                var titulacion = JSON.parse(data);
                                for (datos in titulacion.titulaciones) {
                                    titulaciones += '<option value="'+titulacion.titulaciones[datos].iId+'">'+
                                    titulacion.titulaciones[datos].sTitulacion+'</option>';
                                }
                                $('select#titulaciones').html(titulaciones);
                            });
                    } 
                    function cargar_titulaciones_aux(iId_Universidad, iId_Titulacion)
                    {  
                        var iId_Universidad = $("#universidades option:selected").attr("value");
                        $.get("<?php echo site_url('index.php/Asignatura/ajax_recarga_titulaciones')?>",
                            {"universidad":iId_Universidad}, function(data) {
                                var titulaciones = "";
                                var titulacion = JSON.parse(data);
                                for (datos in titulacion.titulaciones) {
                                    if (titulacion.titulaciones[datos].iId == iId_Titulacion)
                                        titulaciones += '<option value="'+titulacion.titulaciones[datos].iId+'" selected>'+
                                        titulacion.titulaciones[datos].sTitulacion+'</option>';
                                    else
                                        titulaciones += '<option value="'+titulacion.titulaciones[datos].iId+'">'+
                                        titulacion.titulaciones[datos].sTitulacion+'</option>';
                                }
                                $('select#titulaciones').html(titulaciones);
                            });
                    }

                     function cargar_asignaturas(iId)
                    {  
                        var iId_Titulacion = $("#titulaciones option:selected").attr("value");
                        $.get("<?php echo site_url('index.php/Asignatura/ajax_recarga_asignaturas')?>",
                            {"titulacion":iId_Titulacion}, function(data) {
                                var asignaturas = "";
                                var titulacion = JSON.parse(data);
                                for (datos in titulacion.titulaciones) {
                                    titulaciones += '<option value="'+titulacion.titulaciones[datos].iId+'">'+
                                    titulacion.titulaciones[datos].sTitulacion+'</option>';
                                }
                                $('select#titulaciones').html(titulaciones);
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
                                <form action="#" id="form" class="form-horizontal">
                                    <input type="hidden" value="" name="iId"/> 
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Asignatura *</label>
                                            <div class="col-md-9">
                                                <input name="sNombre" placeholder="Asignatura" class="form-control" type="text">
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
                                                 <?php $atributos2 = 'class=form-control id="titulaciones"'; ?>
                                                <?=form_dropdown('iId_Titulacion', $titulaciones, '', $atributos2); ?>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- End Bootstrap modal -->

                <!-- AJAX -->
                   
                    
                <hr class="short">
                    
            </div>
            <?php $this->load->view('footer');?>
        </div>

     
        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        
        <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
            $('body').css({'overflow':'visible'});
        })
        </script>
    
        
        <!-- Custom JS -->
        <script src="<?=base_url()?>js/custom.js"></script>



    </body>
</html>
