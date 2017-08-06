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
        <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css?id=2">   
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
                            <li><a href="#">Ayuda</a></li>
                            <li><a href="#">Peticiones</a></li>
                            <li class="active"><strong>Gestión de Peticiones</strong></li>
                        </ul>
                    </div>
                </div>
                </div>

                <div class="container">
                <!-- AJAX -->

                    <button class="btn btn-success" onclick="add_peticion()">
                        <i class="glyphicon glyphicon-plus"></i> Peticion
                    </button>
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
                        <th>Activa</th>                      
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Petición</th> 
                            <th>Activa</th>                     
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
                    "search": "Buscar peticiones: ",
                    "lengthMenu": "Mostrando _MENU_ tipos por página.",
                    "loadingRecords": "Cargando tipos de peticiones",
                    "processing": "Cargando tipos de peticiones",
                    "zeroRecords": "No se han encontrado registros",
                    "emptyTable": "No hay tipos de peticiones disponibles",
                    "info": "Mostrando _START_ de _END_ tipos, de un total de _TOTAL_",
                    "infoEmpty": "Mostrando 0 de 0 tipos de peticiones",
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
                    "url": "<?php echo site_url('index.php/Tipopeticion/ajax_list')?>",
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
        });

        function add_peticion()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Añadir tipo de petición'); // Set Title to Bootstrap modal title
        }

        function editar_peticion(iId)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error strin
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('index.php/Tipopeticion/ajax_edit/')?>/" + iId,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="iId"]').val(data.iId);
                    $('[name="sPeticion"]').val(data.sPeticion_lista);
                    $('[name="sRequerimientos"]').val(data.sRequerimientos);
                    if (data.bActiva == 1) $("#bActiva").prop("checked", true);
                    $('[name="bActiva"]').val(data.bActiva);
                    
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Editar tipo de petición'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal("Oops! algo no fue bien ...", "Ocurrió un problema mientras se editaba la petición.", "warning");
                }
            });
        }
        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

        function eliminar_todos(peticion) {
            swal({
                title: "¿Estás seguro/a?",
                text: "Si borras todas las peticiones, se borrarán todas las solicitudes asociadas!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Borrar",
                cancelButtonText: "No, dejarlo como está",
                closeOnConfirm: false
                },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Tipopeticion/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.peticion:checked').serialize(),
                            success: function(data) {
                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    swal("Bien!", "Se han eliminado los tipos de peticiones solicitadas", "success");
                                    reload_table();
                                } else {
                                        bootbox.alert({
                                            message: data.error_string
                                        });
                                    } 
                                },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Error al eliminar el registro. Inténtelo más tarde.", "warning");
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
                url = "<?php echo site_url('index.php/Tipopeticion/ajax_add')?>";
            } else {
                url = "<?php echo site_url('index.php/Tipopeticion/ajax_update')?>";
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
                    swal("Oops! algo no fue bien ...", "Se ha producido un error al tratar de actualizar el registro.", "warning");
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled',false); 
                }
            });
        }

        function borrar_peticion(iId)
        {

            swal({
                title: "¿Estás seguro/a?",
                text: "Si borras todas las peticiones, se borrarán todas las solicitudes asociadas!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Borrar",
                cancelButtonText: "No, dejarlo como está",
                closeOnConfirm: false
                },
                    function(){
                    // AJAX borra los datos de la base de datos.
                    $.ajax({
                        url : "<?php echo site_url('index.php/Tipopeticion/ajax_delete')?>/"+iId,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            if(data.status) //if success close modal and reload ajax table
                            {
                                $('#modal_form').modal('hide');
                                reload_table();
                                swal("Eliminados!", "Se han eliminado los tipos de peticiones solicitados", "success");
                            } else {
                                bootbox.alert({
                                    message: data.error_string
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal("Oops! algo no fue bien", "No se ha podido eliminar la petición.", "warning");
                        }
                    });
                }
            );
        }





    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Alta de tipo de petición</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="iId"/> 
                        <div class="form-body">                            
                            <div class="form-group">
                                <div class="col-md-12">
                                    <?=form_label('Petición * '); ?>
                                    <input name="sPeticion" placeholder="Petición" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="col-md-12">
                                    <?=form_label('Requerimientos '); ?>
                                    <textarea class="form-control" name="sRequerimientos" placeholder="Requerimientos (si hay)" rows="5"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <input type="checkbox" id="bActiva" name="bActiva[]" value="1">&nbsp;Activa

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

               


    <!-- Libs -->
    <script src="<?=base_url()?>vendor/jquery.appear.js"></script>
    <script src="<?=base_url()?>vendor/jquery.easing.js"></script>
    <script src="<?=base_url()?>vendor/jquery.cookie.js"></script>
        
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
