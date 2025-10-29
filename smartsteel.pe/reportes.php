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
                                <h4 class="mb-sm-0">Generar Reportes Generales</h4>

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
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title mb-4"><i class="ri-printer-line"></i> Reporte de Productos</h4>
                                    <div class="button-items">
                                        <div class="d-grid">
                                            <a class="btn btn-success btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="reporte-productos-almacen.php" data-sb-backdrop="static" data-sb-keyboard="false">Productos Almacen</a>
                                            <a class="btn btn-success btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="reporte-productos-locales.php" data-sb-backdrop="static" data-sb-keyboard="false">Productos Locales</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title mb-4"><i class="ri-printer-line"></i> Reporte Ingresos y Salidas</h4>
                                    <div class="button-items">
                                        <div class="d-grid">
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Reporte Ingresos</a>
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Reporte Salidas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title mb-4"><i class="ri-printer-line"></i> Reporte de Ventas</h4>
                                    <div class="button-items">
                                        <div class="d-grid">
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Reporte Ventas</a>
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Apertura de Cajas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title mb-4"><i class="ri-printer-line"></i> Reportes Varios</h4>
                                    <div class="button-items">
                                        <div class="d-grid">
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Reporte Personal</a>
                                            <a href="#" type="button" class="btn btn-success btn-sm waves-effect waves-light">Reporte Clientes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Generar Reportes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

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
        /**************************************************/
        /**************************************************/
        var remoto_href = '';
        jQuery('body').on('click', '[data-bs-toggle="modal"]', function() {
            if (remoto_href != jQuery(this).data("remote")) {
                remoto_href = jQuery(this).data("remote");
                jQuery(jQuery(this).data("bs-target")).find('.modal-body').empty();
                jQuery(jQuery(this).data("bs-target") + ' .modal-body').load(remoto_href);
                //$("#bs-example-modal-xl .modal-body").load(remoto_href);
            }
            return false
        });
    </script>
</body>

</html>