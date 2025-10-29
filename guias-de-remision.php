<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
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
                                <h4 class="mb-sm-0">Listado de Guias de Remision</h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="registrar-guia-remision.php" class="btn btn-primary waves-effect waves-light">
                                            Registrar Nueva Guia <i class="ri-folder-add-fill align-middle ms-2"></i>
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
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive wrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Guia</th>
                                                <th>Cliente</th>
                                                <th>Nº Fact/Bol</th>
                                                <th>Estado</th>
                                                <th width="8%">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($xCargo == 'Super Administrador') {
                                                $sqlConsulta        = mysqli_query($conexion, "SELECT * FROM guias_remision");
                                            } else {
                                                $sqlConsulta        = mysqli_query($conexion, "SELECT * FROM guias_remision WHERE cod_puntoventa='$xTienda'");
                                            }
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $id_guia            = $fconsul['id_guia'];
                                                $id_factura         = $fconsul['id_factura'];
                                                $codigo_compro      = $fconsul['codigo_compro'];
                                                $num_guia           = $fconsul['serie'] . '-' . $fconsul['num_guia'];
                                                $fecha_registro     = date('d-m-Y', strtotime($fconsul['fecha_registro']));
                                                if ($fconsul['estado'] == 'Enviado') {
                                                    $estado = "<span class='badge rounded-pill bg-success'>Enviado</span>";
                                                } else {
                                                    $estado = "<span class='badge rounded-pill bg-danger'>Falta Enviar</span>";
                                                }
                                                /***********************************************/
                                                $sqlFacturas    = mysqli_query($conexion, "SELECT razon_social, serie, num_comprobante FROM factura WHERE id_factura='$id_factura'");
                                                $ffact          = mysqli_fetch_array($sqlFacturas);
                                                $razon_social   = $ffact['razon_social'];
                                                $docGuia        = $ffact['serie'] . '-' . $ffact['num_comprobante'];
                                                /***********************************************/
                                            ?>
                                                <tr>
                                                    <td><?= $fecha_registro ?></td>
                                                    <td><?= $num_guia ?></td>
                                                    <td><?= $razon_social ?></td>
                                                    <td><?= $docGuia ?></td>
                                                    <td><?= $estado ?></td>
                                                    <td>
                                                        <a class="btn btn-outline-success btn-sm imprimirTicket" title="Imprimir Ticket">
                                                            <i class="ri-printer-fill align-middle"></i>
                                                            <input type="hidden" name="id_guia" value="<?= $id_guia ?>" class="codimprimir">
                                                        </a>
                                                        <!--  -->
                                                        <a class="btn btn-outline-danger btn-sm imprimirPDF" title="Imprimir PDF">
                                                            <i class="ri-file-pdf-fill align-middle"></i>
                                                            <input type="hidden" name="id_guia" value="<?= $id_guia ?>" class="codimprimir">
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
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
    <!-- END layout-wrapper -->
    <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Registrar/Editar/Subir Productos</h5>
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
    <script src="assets/js/VentanaCentrada.js"></script>

    <script>
        $(function() {
            /**************************************************/
            /**************************************************/
            $(document).on("click", ".imprimirTicket", function() {
                var id_guia = $(".codimprimir", this).val();
                VentanaCentrada('ventas/ver-ticket-guia.php?id_guia=' + id_guia, 'Factura', '', '1024', '768', 'true');
            })
            $(document).on("click", ".imprimirPDF", function() {
                var id_guia = $(".codimprimir", this).val();
                VentanaCentrada('ventas/ver-guias-pdf.php?id_guia=' + id_guia, 'Factura', '', '1024', '768', 'true');
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
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>