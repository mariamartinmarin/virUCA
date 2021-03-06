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
        <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.css">   
        <link rel="stylesheet" href="<?=base_url('js/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?=base_url()?>css/theme.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-elements.css">
        <link rel="stylesheet" href="<?=base_url()?>css/theme-blog.css">
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
                            <li class="active"><strong>Gestión de Universidades</strong></li>
                        </ul>
                    </div>
                </div>
                </div>

                <div class="container">
                <!-- AJAX -->

                    <button class="btn btn-success" onclick="add_universidad()">
                        <i class="glyphicon glyphicon-plus"></i> Universidad
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(universidad))">
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
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Fax</th>
                        <th>Provincia</th>
                        <th style="width:200px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Fax</th>
                            <th>Provincia</th>
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
                    "search": "Buscar universidades: ",
                    "lengthMenu": "Mostrando _MENU_ universidades por página.",
                    "loadingRecords": "Cargando universidades",
                    "processing": "Cargando universidades",
                    "zeroRecords": "No se han encontrado registros",
                    "emptyTable": "No hay universidades disponibles",
                    "info": "Mostrando _START_ de _END_ universidades, de un total de _TOTAL_",
                    "infoEmpty": "Mostrando 0 de 0 universidades",
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
                    "url": "<?php echo site_url('index.php/Universidad/ajax_list')?>",
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

        function add_universidad()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Añadir universidad'); // Set Title to Bootstrap modal title
        }

        function editar_universidad(iId)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error strin
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('index.php/Universidad/ajax_edit/')?>/" + iId,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="iId"]').val(data.iId);
                    $('[name="sUniversidad"]').val(data.sUniversidad);
                    $('[name="sDireccion"]').val(data.sDireccion);
                    $('[name="sCP"]').val(data.sCP);
                    $('[name="sLocalidad"]').val(data.sLocalidad);
                    $('[name="sProvincia"]').val(data.sProvincia);
                    $('[name="sPais"]').val(data.sPais);
                    $('[name="nTelefono"]').val(data.nTelefono);
                    $('[name="nFax"]').val(data.nFax);
                    $('[name="sWeb"]').val(data.sWeb);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Editar universidad'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal("Oops! algo no fue bien ...", "Ocurrió un problema mientras se editaba la universidad.", "warning");
                }
            });
        }

        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

        function eliminar_todos(universidad) {
             swal({
                    title: "¿Estás seguro/a?",
                    text: "¿Desea eliminar las universidades señaladas?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Universidad/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.universidad:checked').serialize(),
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
                                swal("Oops! algo no fue bien ...", "No se han podido eliminar todos los registros. Inténtelo más tarde.", "warning");
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
                url = "<?php echo site_url('index.php/Universidad/ajax_add')?>";
            } else {
                url = "<?php echo site_url('index.php/Universidad/ajax_update')?>";
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
                    swal("Oops! algo no fue bien ...", "Se ha producido un error al intentar añadir/modificar el registro.", "warning");
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled',false); 
                }
            });
        }

        function borrar_universidad(iId)
        {
            swal({
                    title: "¿Estás seguro/a?",
                    text: "¿Desea eliminar la universidad?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Universidad/ajax_delete')?>/"+iId,
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
                                swal("Oops! algo no fue bien ...", "No se ha podido eliminar la universidad. Inténtelo más tarde.", "warning");
                            }
                        });
                    });
            } 
           
    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Alta de universidad</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="iId"/> 
                        <div class="form-body">                            
                            <div class="form-group">
                                <div class="col-md-12">
                                    <?=form_label('Universidad * '); ?>
                                    <input tabindex="1" name="sUniversidad" placeholder="Universidad" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <?=form_label('Dirección '); ?>
                                    <input tabindex="2" name="sDireccion" placeholder="Dirección" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-6">
                                    <?=form_label('Código postal  '); ?>
                                    <input tabindex="3" name="sCP" placeholder="Código postal" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <?=form_label('Localidad'); ?>
                                    <input tabindex="4" name="sLocalidad" placeholder="Localidad" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-6">
                                    <?=form_label('Provincia'); ?>
                                    <input tabindex="5" name="sProvincia" placeholder="Provincia" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <?=form_label('País '); ?>
                                    <input tabindex="6" name="sPais" placeholder="País" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>                               
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <?=form_label('Teléfono * '); ?>
                                    <input tabindex="7" name="nTelefono" placeholder="Teléfono" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-6">
                                    <?=form_label('Fax  '); ?>
                                    <input tabindex="8" name="nFax" placeholder="Fax" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <?=form_label('Web  '); ?>
                                    <input tabindex="9" name="sWeb" placeholder="http://" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button tabindex="10" type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button tabindex="11" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
    <!-- AJAX -->

               


    <!-- Libs -->
        
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
