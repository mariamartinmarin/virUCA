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
                            <li><a href="#">Configuración</a></li>
                            <li class="active"><strong>Gestión de Accesos al Sistema</strong></li>
                        </ul>
                    </div>
                </div>
                </div>
               
                <div class="container">
                    <button class="btn btn-warning" onclick="eliminar_todos($(acceso))">
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
                        <th>Nombre completo</th>
                        <th>Fecha de acceso</th>
                        <th>IP</th>
                        <th style="width:200px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre completo</th>
                            <th>Fecha de acceso</th>
                            <th>IP</th>
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
                        "search": "Buscar acceso: ",
                        "lengthMenu": "Mostrando _MENU_ registros por página.",
                        "loadingRecords": "Cargando registros",
                        "processing": "Cargando registros",
                        "zeroRecords": "No se han encontrado registros",
                        "emptyTable": "No hay registros disponibles",
                        "info": "Mostrando _START_ de _END_ registros, de un total de _TOTAL_",
                        "infoEmpty": "Mostrando 0 de 0 titulaciones",
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
                        "url": "<?php echo site_url('index.php/Accesos/ajax_list')?>",
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

            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }

            function eliminar_todos(acceso) {
                swal({
                    title: "¿Estás seguro/a?",
                    text: "¿Estás seguro/a que quieres eliminar los accesos señalados? En caso afirmativo, debe saber que se perderá cualquier tipo de rastro en el sistema del acceso de los usuarios seleccionados al mismo.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Accesos/ajax_delete_todos')?>/",
                            type : "POST",
                            dataType : "JSON",
                            data : $('.acceso:checked').serialize(),
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

            function borrar_acceso(iId)
            {
                 swal({
                    title: "¿Estás seguro/a?",
                    text: "¿Estás seguro/a que desea eliminar este acceso? En caso afirmativo, debe saber que se perderá cualquier tipo de rastro en el sistema del acceso de este usuario al mismo.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Borrar",
                    cancelButtonText: "No, dejarlo como está",
                    closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url : "<?php echo site_url('index.php/Accesos/ajax_delete')?>/"+iId,
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
                                swal("Oops! algo no fue bien ...", "Ha ocurrido un error mientras se intentaba eliminar el registro. Asegúrese que ha marcado alguno.", "warning");
                            }
                        });
                    }); 
            }
        </script>

              

        <!-- Libs -->
        
        <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        
        <script type="text/javascript">
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
            $('body').css({'overflow':'visible'});
        })
        </script>
        

    </body>
</html>
