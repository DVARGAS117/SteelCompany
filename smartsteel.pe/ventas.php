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
                                <h4 class="mb-sm-0">Listado de Ventas Diarias</h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="registrar-ventas.php" class="btn btn-primary waves-effect waves-light">
                                            Registrar Ventas <i class="ri-folder-add-fill align-middle ms-2"></i>
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
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Tienda</th>
                                                <th>Cliente</th>
                                                <th>Tipo</th>
                                                <th>Comprobante</th>
                                                <th>Monto Total</th>
                                                <th>Estado</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($xCargo == 'Super Administrador') {
                                                $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM factura");
                                            } else {
                                                $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM factura WHERE cod_puntoventa='$xTienda '");
                                            }
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $id_factura         = $fconsul['id_factura'];
                                                $codigo_compro      = $fconsul['codigo_compro'];
                                                $comprobante        = $fconsul['serie'] . '-' . $fconsul['num_comprobante'];
                                                $fecha_registro     = date('d-m-Y', strtotime($fconsul['fecha_registro']));
                                                $razon_social       = substr($fconsul['razon_social'], 0, 40) . '.';
                                                $total_monto        = "s/. " . number_format($fconsul['total_monto'], 2);
                                                $cod_puntoventa     = $fconsul['cod_puntoventa'];
                                                if ($fconsul['estado'] == 'Enviado') {
                                                    $estado = "<span class='badge rounded-pill bg-success'>Enviado</span>";
                                                } else {
                                                    $estado = "<span class='badge rounded-pill bg-danger'>Falta Enviar</span>";
                                                }
                                                /***********************************************/
                                                $sqlTienda      = mysqli_query($conexion, "SELECT nombre_puntoventa FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
                                                $ftienda        = mysqli_fetch_array($sqlTienda);
                                                $tienda         = $ftienda['nombre_puntoventa'];
                                                /***********************************************/
                                                $sqlTipoDoc     = mysqli_query($conexion, "SELECT descripcion FROM tipo_documento WHERE codigo_compro='$codigo_compro'");
                                                $fdoc           = mysqli_fetch_array($sqlTipoDoc);
                                                $tipo_compro    = $fdoc['descripcion']
                                                /***********************************************/
                                            ?>
                                                <tr>

                                                    <td><?= $fecha_registro ?></td>
                                                    <td><?= $tienda ?></td>
                                                    <td><?= $razon_social ?></td>
                                                    <td><?= $tipo_compro ?></td>
                                                    <td><?= $comprobante ?></td>
                                                    <td><?= $total_monto ?></td>
                                                    <td><?= $estado ?></td>
                                                    <td>
                                                        <a class="btn btn-outline-success btn-sm imprimirTicket" title="Imprimir Ticket">
                                                            <i class="ri-printer-fill align-middle"></i>
                                                            <input type="hidden" name="id_factura" value="<?= $id_factura ?>" class="codimprimir">
                                                        </a>
                                                        <!--  -->
                                                        <a class="btn btn-outline-danger btn-sm imprimirPDF" title="Imprimir PDF">
                                                            <i class="ri-file-pdf-fill align-middle"></i>
                                                            <input type="hidden" name="id_factura" value="<?= $id_factura ?>" class="codimprimir">
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
                var id_factura = $(".codimprimir", this).val();
                VentanaCentrada('ventas/ver-ticket.php?id_factura=' + id_factura, 'Factura', '', '1024', '768', 'true');
            })
            $(document).on("click", ".imprimirPDF", function() {
                var id_factura = $(".codimprimir", this).val();
                VentanaCentrada('ventas/ver-facturas-pdf.php?id_factura=' + id_factura, 'Factura', '', '1024', '768', 'true');
            })
            /**************************************************/
            /**************************************************/
            $(document).on('click', '.borrarReg', function() {
                var cod_producto = $('.codborrar', this).val();
                var datosEnviar = {
                    'cod_producto': cod_producto,
                    'modulo': "Productos"
                }
                var r = confirm("¿Seguro que desea borrar el registro?");
                if (r == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/proceso-eliminar.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                alert("El registro se borró satisfactoriamente");
                                location.reload();
                            }
                        }
                    })
                }
                return false;
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