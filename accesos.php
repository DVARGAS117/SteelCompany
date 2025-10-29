<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$xcod_personal  = $_REQUEST['cod_personal'];
$sqlPersonal    = mysqli_query($conexion, "SELECT nombres FROM personal WHERE cod_personal='$xcod_personal'");
$fper           = mysqli_fetch_array($sqlPersonal);
$nomper         = $fper['nombres'];
?>
<!doctype html>
<html lang="en">

<head>

    <?php require("config/cabecera-web.php"); ?>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- ===================   CABECERA APP  ========================== -->
        <!-- ============================================================== -->
        <?php require("config/cabecera.php"); ?>
        <!-- ============================================================== -->
        <!-- ===================        MENU APP   ======================== -->
        <!-- ============================================================== -->
        <?php require("config/barra-navegacion.php"); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Administrar Accesos para <span style="color: red;"><?= $nomper ?></span></h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="personal.php?sub_modulo=Personal" class="btn btn-primary waves-effect waves-light">
                                            <i class="ri-arrow-left-circle-fill align-middle ms-2"></i>
                                            Regresar a Personal
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tbl-accesos" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width='2%'>Nº</th>
                                                <th>Nombre Modulo</th>
                                                <th width='5%'>Consultar</th>
                                                <th width='5%'>Crear/Insertar</th>
                                                <th width='5%'>Editar</th>
                                                <th width='5%'>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $numm = 0;
                                            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM accesos_usuarios as a, sub_modulos as m WHERE a.cod_personal='$xcod_personal' AND a.modulo=m.sub_modulo ORDER BY cod_acceso ASC");
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $cod_acceso         = $fconsul['cod_acceso'];
                                                $modulo             = $fconsul['modulo'];
                                                $insertar           = $fconsul['insertar'];
                                                $editar             = $fconsul['editar'];
                                                $eliminar           = $fconsul['eliminar'];
                                                $consultar          = $fconsul['consultar'];
                                                if ($insertar == 'SI') {
                                                    $actinst        = 'checked="checked"';
                                                } else {
                                                    $actinst        = '';
                                                }
                                                if ($editar == 'SI') {
                                                    $actedit        = 'checked="checked"';
                                                } else {
                                                    $actedit        = '';
                                                }
                                                if ($eliminar == 'SI') {
                                                    $actelim        = 'checked="checked"';
                                                } else {
                                                    $actelim        = '';
                                                }
                                                if ($consultar == 'SI') {
                                                    $actconsul      = 'checked="checked"';
                                                } else {
                                                    $actconsul      = '';
                                                }
                                                $numm++;
                                                /********************************************/
                                                echo "
                                                <tr>
                                                    <td>$numm</td>
                                                    <td>$modulo</td>
                                                    <td>
                                                        <a class='cambiarConsulta'>
                                                            <input type='hidden' name='cod_acceso' value='$cod_acceso' class='cod_acceso'>
                                                            <input type='checkbox' name='checkconsultar' value='$consultar' class='checkconsultar' $actconsul> $consultar
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class='cambiarInsertar'>
                                                            <input type='hidden' name='cod_acceso' value='$cod_acceso' class='cod_acceso'>
                                                            <input type='checkbox' name='checkinsertar' value='$insertar' class='checkinsertar' $actinst> $insertar
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class='cambiarEditar'>
                                                            <input type='hidden' name='cod_acceso' value='$cod_acceso' class='cod_acceso'>
                                                            <input type='checkbox' name='checkeditar' value='$editar' class='checkeditar' $actedit> $editar
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class='cambiarEliminar'>
                                                            <input type='hidden' name='cod_acceso' value='$cod_acceso' class='cod_acceso'>
                                                            <input type='checkbox' name='checkeliminar' value='$eliminar' class='checkeliminar' $actelim> $eliminar
                                                        </a>
                                                    </td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- ============================================================== -->
            <!-- ===================   PIEPAGINA APP ========================== -->
            <!-- ============================================================== -->
            <?php require("config/piepagina.php"); ?>
        </div>
        <!-- end main content-->

    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(
            function(){
                var a = $("#tbl-accesos").DataTable({
                    paging: false,
                    lengthChange:!1,
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    },
                    buttons:["copy","excel","pdf","colvis"]
                });
                a.buttons().container().appendTo("#tbl-accesos_wrapper .col-md-6:eq(0)"),$(".dataTables_length select").addClass("form-select form-select-sm"),$("#selection-datatable").DataTable({
                    select:{
                        style:"multi"
                    },
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }
                }),$("#key-datatable").DataTable({
                    keys:!0,
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }
                }),a.buttons().container().appendTo("#tbl-accesos_wrapper .col-md-6:eq(0)"),$(".dataTables_length select").addClass("form-select form-select-sm"),$("#alternative-page-datatable").DataTable({
                    pagingType:"full_numbers",
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),$(".dataTables_length select").addClass("form-select form-select-sm")
                    }
                }),$("#scroll-vertical-datatable").DataTable({
                    scrollY:"350px",
                    scrollCollapse:!0,
                    paging:!1,
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }
                }),$("#complex-header-datatable").DataTable({
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),$(".dataTables_length select").addClass("form-select form-select-sm")
                    },
                    columnDefs:[{
                        visible:!1,
                        targets:-1
                    }]
                }),$("#state-saving-datatable").DataTable({
                    stateSave:!0,
                    language:{
                        paginate:{
                            previous:"<i class='mdi mdi-chevron-left'>",
                            next:"<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback:function(){
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),$(".dataTables_length select").addClass("form-select form-select-sm")
                    }
                });
                /**************************************************/
                /**************************************************/
                $('.cambiarConsulta').on('click', function() {
                    var datosEnviar = {
                        'cod_acceso': $('.cod_acceso', this).val(),
                        'consultar': $('.checkconsultar', this).val(),
                        'proceso': "Consultar"
                    }
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/accesos.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                location.reload();
                            }
                        }
                    });
                });
                /**************************************************/
                /**************************************************/
                $('.cambiarInsertar').on('click', function() {
                    var datosEnviar = {
                        'cod_acceso': $('.cod_acceso', this).val(),
                        'insertar': $('.checkinsertar', this).val(),
                        'proceso': "Insertar"
                    }
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/accesos.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                location.reload();
                            }
                        }
                    });
                });
                /**************************************************/
                /**************************************************/
                $('.cambiarEditar').on('click', function() {
                    var datosEnviar = {
                        'cod_acceso': $('.cod_acceso', this).val(),
                        'editar': $('.checkeditar', this).val(),
                        'proceso': "Editar"
                    }
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/accesos.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                location.reload();
                            }
                        }
                    });
                });
                /**************************************************/
                /**************************************************/
                $('.cambiarEliminar').on('click', function() {
                    var datosEnviar = {
                        'cod_acceso': $('.cod_acceso', this).val(),
                        'eliminar': $('.checkeliminar', this).val(),
                        'proceso': "Eliminar"
                    }
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/accesos.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                location.reload();
                            }
                        }
                    });
                });
            });
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>