<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
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
    <!-- Dropzone Css -->
    <link href="assets/libs/dropzone/dropzone.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                                <h4 class="mb-sm-0">Generar Resumen de Ventas para Sunat</h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="dashboard.php" class="btn btn-success waves-effect waves-light">
                                            <i class="ri-check-line align-middle me-2"></i> Volver
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <form action="" name="fapps" id="fapps" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3 row">
                                            <label for="ruc" class="col-md-2 col-form-label">Fecha Inicio</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="ruc" class="col-md-2 col-form-label">Fecha Final</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="fecha_final" id="fecha_final">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                                    <i class="ri-check-line align-middle me-2"></i> GENERAR RESUMEN
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </form>
                </div> <!-- container-fluid -->
            </div>
            <!-- ============================================================== -->
            <!-- ===================   PIEPAGINA APP ========================== -->
            <!-- ============================================================== -->
            <?php require("config/piepagina.php"); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- jquery dropzone -->
    <script src="assets/libs/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            $("#benviar").click(function() {
                if ($("#fecha_inicio").val() == '') {
                    alert("Seleccionar fecha de inicio");
                    $("#fecha_inicio").focus();
                    return false;
                }
                if ($("#fecha_final").val() == '') {
                    alert("Seleccionar fecha de final");
                    $("#fecha_final").focus();
                    return false;
                }
                document.fapps.action = "exportar-resumen-ventas-sunat.php";
                document.fapps.submit();
            })
        })
    </script>
</body>

</html>