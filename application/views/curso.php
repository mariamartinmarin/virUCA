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
                                    <li><a href="#">Curso</a></li>
                                    <li class="active">Gestión de Curso Académico</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Gestión de Curso Académico</h2>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container">

                    <?php if ($titulaciones != "" && $asignaturas != "") { ?>

                    <button class="btn btn-success" onclick="add_curso()">
                        <i class="glyphicon glyphicon-plus"></i> Curso
                    </button>
                    <button class="btn btn-warning" onclick="eliminar_todos($(curso))">
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
                        <th>Curso</th>
                        <th>Universidad</th>
                        <th>Titulación</th>
                        <th>Asignatura</th>
                        <th style="width:200px;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Curso</th>
                            <th>Universidad</th>
                            <th>Titulación</th>
                            <th>Asignatura</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    </table>
                
                    <?php

                    } else {
                    ?>
                    <div class="alert alert-success">
                    Recuerda que para poder dar de alta un <b>Curso Académico</b> es necesario que existan tanto <b>Asignaturas</b> como <b>Titulaciones</b>
                    </div>
                    <?php 
                    }
                    ?>
                    
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
                                "search": "Buscar curso: ",
                                "lengthMenu": "Mostrando _MENU_ cursos por página.",
                                "loadingRecords": "Cargando cursos",
                                "processing": "Cargando cursos",
                                "zeroRecords": "No se han encontrado registros",
                                "emptyTable": "No hay cursos disponibles",
                                "info": "Mostrando _START_ de _END_ cursos, de un total de _TOTAL_",
                                "infoEmpty": "Mostrando 0 de 0 cursos",
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
                                "url": "<?php echo site_url('index.php/Curso/ajax_list')?>",
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

                    function add_curso()
                    {
                        save_method = 'add';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        $('#modal_form').modal('show'); // show bootstrap modal
                        $('.modal-title').text('Añadir curso'); // Set Title to Bootstrap modal title
                    }

                    function editar_curso(iId)
                    {
                        save_method = 'update';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string

                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('index.php/Curso/ajax_edit/')?>/" + iId,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {

                                $('[name="iId"]').val(data.iId);
                                $('[name="sCurso"]').val(data.sCurso);                                
                                $('[name="iId_Titulacion"]').val(data.iId_Titulacion);
                                $('[name="iId_Asignatura"]').val(data.iId_Asignatura);
                                $('[name="iId_Universidad"]').val(data.iId_Universidad);
                                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Editar curso'); // Set title to Bootstrap modal title

                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                bootbox.alert('Ocurrió un error mientras se intentaba editar el curso.');
                            }
                        });
                    }

                    function reload_table()
                    {
                        table.ajax.reload(null,false); //reload datatable ajax 
                    }

                    function eliminar_todos(curso) {
                        bootbox.confirm("¿Estás seguro/a que quieres eliminar los cursos? Recuerde que si existen dependencias, no podrá eliminarse el registro.",

                        function(result) {
                            if (result == true) {
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Curso/ajax_delete_todos')?>/",
                                    type : "POST",
                                    dataType : "JSON",
                                    data : $('.curso:checked').serialize(),
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
                            url = "<?php echo site_url('index.php/Curso/ajax_add')?>";
                        } else {
                            url = "<?php echo site_url('index.php/Curso/ajax_update')?>";
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

                    function borrar_curso(iId)
                    {
                        bootbox.confirm("¿Estás seguro/a que desea eliminar este curso?", 
                        function(result){ 
                            if (result == true) {
                                // AJAX borra los datos de la base de datos.
                                $.ajax({
                                    url : "<?php echo site_url('index.php/Curso/ajax_delete')?>/"+iId,
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
                                        bootbox.alert('Error al eliminar el curso. Inténtelo más tarde.');
                                    }
                                });
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
                                <h3 class="modal-title">Alta de curso académico</h3>
                            </div>
                            <div class="modal-body form">
                                <form action="#" id="form" class="form-horizontal">
                                    <input type="hidden" value="" name="iId"/> 
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Curso académico</label>
                                            <div class="col-md-9">
                                                <input name="sCurso" placeholder="Curso Académico" class="form-control" type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Universidad</label>
                                            <div class="col-md-9">
                                                <?=form_dropdown('iId_Universidad', $universidades, '', 'class=form-control'); ?>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Titulación</label>
                                            <div class="col-md-9">
                                                <?=form_dropdown('iId_Titulacion', $titulaciones, '', 'class=form-control'); ?>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Asignatura</label>
                                            <div class="col-md-9">
                                                <?=form_dropdown('iId_Asignatura', $asignaturas, '', 'class=form-control'); ?>
                                                <span class="help-block"></span>
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
