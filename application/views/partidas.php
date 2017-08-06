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
                            <li><a href="#">Juego</a></li>
                            <li class="active"><strong>Gestión de Partidas</strong></li>
                        </ul>
                    </div>
                </div>
                </div>
               
                <div class="container">
                    <button class="btn btn-success" onclick="add_partida()">
                        <i class="glyphicon glyphicon-plus"></i> Partida
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(partida))">
                        <i class="glyphicon glyphicon-trash"></i> Eliminar todas
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
                        <th>Fecha</th>
                        <th>Nº Grupos</th>
                        <th>Panel</th>
                        <th>Propietario</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Nº Grupos</th>
                            <th>Panel</th>
                            <th>Propietario</th>
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
                        "search": "Buscar partida: ",
                        "lengthMenu": "Mostrando _MENU_ partidas por página.",
                        "loadingRecords": "Cargando partidas",
                        "processing": "Cargando partidas",
                        "zeroRecords": "No se han encontrado partidas",
                        "emptyTable": "No hay partidas disponibles",
                        "info": "Partidas del _START_ al _END_, (total de _TOTAL_)",
                        "sInfoFiltered":   "",
                        "infoEmpty": "Mostrando 0 de 0 partidas",
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
                        "url": "<?php echo site_url('index.php/Partidas/ajax_list')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ -1, 0,4, 5 ], //last column
                        "orderable": false, //set not orderable
                    },
                    ],

                });
            });


            function add_partida()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Crear partida'); // Set Title to Bootstrap modal title
            }

            function ver_clasificacion(iId_Panel, iId_Partida) {
                var url = "<?=base_url("index.php/jugar/")?>" + iId_Panel + "/" + iId_Partida;
                window.location.href = url;
            }

            function ver_directo(iId_Panel, iId_Partida) {
                var url = "<?=base_url("index.php/jugar/")?>" + iId_Panel + "/" + iId_Partida;
                window.location.href = url;
            }

            function jugar_partida(iId_Panel, iId_Partida) {
                var url = "<?=base_url("index.php/jugar/")?>" + iId_Panel + "/" + iId_Partida;
                window.location.href = url;   
            }

             function save()
            {
                $('#btnSave').text('guardando ...'); // Cambiar valor del texto
                $('#btnSave').attr('disabled',true); // Desactivar botón.
                var url;

                if(save_method == 'add') {
                    url = "<?php echo site_url('index.php/Partidas/ajax_add')?>";
                } else {
                    url = "<?php echo site_url('index.php/Partidas/ajax_update')?>";
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
                        swal("Oops! algo no fue bien ...", "Ocurrió un error mientras se trataba de añadir/eliminar el registro.", "warning");
                        $('#btnSave').text('Guardar');
                        $('#btnSave').attr('disabled',false); 
                    }
                });
            }

            function editar_partida(iId)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo site_url('index.php/Partidas/ajax_edit/')?>" + iId,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="iId"]').val(data.iId);
                        $('[name="sPartida"]').val(data.sPartida); 
                        $('[name="nGrupos"]').val(data.nGrupos);
                        $('[name="iId_Panel"]').val(data.iId_Panel);
                        
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Editar partida'); // Set title to Bootstrap modal title                            
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                         swal("Oops! algo no fue bien ...", "Ocurrió un error mientras se intentaba editar la partida. Inténtelo más tarde.", "warning");
                    }
                });
            }

            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }


            function eliminar_todos(pregunta) {
                swal({
                title: "¿Estás seguro/a?",
                text: "¿Desea eliminar el panel? Si el panel participa en alguna partida, no podrá eliminarlo.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Borrar",
                cancelButtonText: "No, dejarlo como está",
                closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url : "<?php echo site_url('index.php/Partidas/ajax_delete_todos')?>/",
                        type : "POST",
                        dataType : "JSON",
                        data : $('.partida:checked').serialize(),
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
                            swal("Oops! algo no fue bien ...", "Ocurrió un error mientras se intentaban eliminar los registros. Asegúrese que ha marcado algún registro.", "warning");
                        }
                    });
                });
            }

            function borrar_partida(iId)
            {
                swal({
                title: "¿Estás seguro/a?",
                text: "¿Estás seguro/a que desea eliminar este partida? Al borrar las partidas, eliminará el registro estadístico de dicha partida en el sistema.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Borrar",
                cancelButtonText: "No, dejarlo como está",
                closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url : "<?php echo site_url('index.php/Partidas/ajax_delete')?>/"+iId,
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
                                swal("Oops! algo no ha ido bien ...", data.error_string, "warning");                             }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error al intentar eliminar la partida. Inténtelo más tarde.", "warning");
                            }
                        });
                    }); 
            }


            
        </script>

        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Crear partida</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="iId"/> 
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <?=form_label('Nombre * '); ?>
                                        <input name="sPartida" placeholder="Nombre" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <?=form_label('Nº de grupos * '); ?>
                                        <input name="nGrupos" placeholder="Grupos" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-9">
                                        <?=form_label('Panel * '); ?>
                                        <?php $atributos = 'class=form-control id="paneles"'; ?>
                                        <?=form_dropdown('iId_Panel', $paneles, '', $atributos); ?>
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

        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        
        <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
            $('body').css({'overflow':'visible'});
        })
        </script>
        
    </body>
</html>
