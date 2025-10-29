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
                                <?php
                                if ($xCargo == 'Super Administrador') {
                                    echo '<h4 class="mb-sm-0">Administrar Productos</h4>';
                                } else {
                                    echo "<h4 class='mb-sm-0'>Productos Asignado a <span style='color:red'>$xNombreTienda<span></h4>";
                                }
                                ?>

                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="ingreso-productos-almacen.php" data-sb-backdrop="static" data-sb-keyboard="false">
                                            Subir Productos <i class=" ri-cloud-fill align-middle ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="reg-productos.php" data-sb-backdrop="static" data-sb-keyboard="false">
                                            Nuevo Producto <i class="ri-folder-add-fill align-middle ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php
                    if ($xCargo == 'Super Administrador') {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>Stock Actual</th>
                                                    <th>P. Unitario</th>
                                                    <th>P. Cuarto</th>
                                                    <th>P. Mayor</th>
                                                    <th>Estado</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM productos");
                                                while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                    $cod_producto       = $fconsul['cod_producto'];
                                                    $codigo             = $fconsul['codigo'];
                                                    $nombre_producto    = $fconsul['nombre_producto'];
                                                    $stock_actual       = $fconsul['stock_actual'];
                                                    $precio_unitario    = "s/. " . number_format($fconsul['precio_unitario'], 2);
                                                    $precio_cuarto      = "s/. " . number_format($fconsul['precio_cuarto'], 2);
                                                    $precio_mayor       = "s/. " . number_format($fconsul['precio_mayor'], 2);
                                                    if ($fconsul['estado'] == 'A') {
                                                        $estado = "<span class='badge rounded-pill bg-success'>Activo</span>";
                                                    } else {
                                                        $estado = "<span class='badge rounded-pill bg-danger'>Inactivo</span>";
                                                    }
                                                ?>
                                                    <tr>

                                                        <td><?= $codigo ?></td>
                                                        <td><?= $nombre_producto ?></td>
                                                        <td><?= $stock_actual ?></td>
                                                        <td><?= $precio_unitario ?></td>
                                                        <td><?= $precio_cuarto ?></td>
                                                        <td><?= $precio_mayor ?></td>
                                                        <td><?= $estado ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-remote="mod-productos.php?cod_producto=<?= $cod_producto ?>" data-sb-backdrop="static" data-sb-keyboard="false">
                                                                <i class="ri-edit-fill align-middle"></i>
                                                            </a>
                                                            <!--  -->
                                                            <a href="" class="btn btn-outline-danger btn-sm borrarReg">
                                                                <i class="ri-delete-bin-fill align-middle"></i>
                                                                <input type="hidden" name="codborrar" value="<?= $cod_producto ?>" class="codborrar">
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
                    <?php
                    } else {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>P. Unitario</th>
                                                    <th>P. Cuarto</th>
                                                    <th>P. Mayor</th>
                                                    <th>S. Total</th>
                                                    <th>S. Actual</th>
                                                    <th>T. Ventas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM stock_locales WHERE cod_puntoventa='$xTienda'");
                                                while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                    $cod_producto       = $fconsul['cod_producto'];
                                                    $codigo             = $fconsul['codigo'];
                                                    $nombre_producto    = $fconsul['nombre_producto'];
                                                    $stock_ingresado    = $fconsul['stock_ingresado'];
                                                    $stock_actual       = $fconsul['stock_actual'];
                                                    $total_ventas       = $fconsul['total_ventas'];
                                                    /**************************************************/
                                                    $sqlProductos       = mysqli_query($conexion, "SELECT precio_unitario, precio_cuarto, precio_mayor FROM productos WHERE cod_producto='$cod_producto'");
                                                    $fprods             = mysqli_fetch_array($sqlProductos);
                                                    $precio_unitario    = "s/. " . number_format($fprods['precio_unitario'], 2);
                                                    $precio_cuarto      = "s/. " . number_format($fprods['precio_cuarto'], 2);
                                                    $precio_mayor       = "s/. " . number_format($fprods['precio_mayor'], 2);
                                                    /**************************************************/
                                                ?>
                                                    <tr>

                                                        <td><?= $codigo ?></td>
                                                        <td><?= $nombre_producto ?></td>
                                                        <td><?= $precio_unitario ?></td>
                                                        <td><?= $precio_cuarto ?></td>
                                                        <td><?= $precio_mayor ?></td>
                                                        <td><?= $stock_ingresado ?></td>
                                                        <td><?= $stock_actual ?></td>
                                                        <td><?= $total_ventas ?></td>
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
                    <?php
                    }
                    ?>
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
    <script>
        $(function() {
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