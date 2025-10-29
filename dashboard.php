<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
?>
<!doctype html>
<html lang="en">

<!-- CPW Training Center-->

<head>
    <?php require("config/cabecera-web.php"); ?>
    <!-- App favicon -->
    <?php
    if ($xIconoWeb == '') {
        echo '
        <link rel="shortcut icon" href="assets/images/favicon.ico">';
    } else {
        echo '
        <link rel="shortcut icon" href="assets/images/' . $xIconoWeb . '">';
    }
    ?>
    <!-- jvectormap -->
    <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Escritorio</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $xNombreComercial ?></a></li>
                                        <li class="breadcrumb-item active">Escritorio</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- ******************************************************** -->
                    <!-- ******************************************************** -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <a href="cajas.php">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light rounded-circle text-success font-size-30">
                                                        <i class="mdi mdi-cash-register"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-light">Módulo Ventas</p>
                                                <h5 class="mb-3 text-light">Aperturar Caja</h5>
                                                <p class="text-truncate mb-0 text-light">Abrir Caja <i class="ri-arrow-right-circle-fill align-bottom ms-1"></i></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <a href="registrar-ventas.php">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light rounded-circle text-success font-size-30">
                                                        <i class="ri-printer-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-light">Modulo Ventas</p>
                                                <h5 class="mb-3 text-light">Facturas/Boletas</h5>
                                                <p class="text-truncate mb-0 text-light">Registrar Ventas <i class="ri-arrow-right-circle-fill align-bottom ms-1"></i></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <a href="registrar-nota-credito.php">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light rounded-circle text-success font-size-30">
                                                        <i class="ri-newspaper-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-light">Modulo Ventas</p>
                                                <h5 class="mb-3 text-light">Notas Crédito</h5>
                                                <p class="text-truncate mb-0 text-light">Registrar N. Credito <i class="ri-arrow-right-circle-fill align-bottom ms-1"></i></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <a href="facturas-electronicas.php">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light rounded-circle text-success font-size-30">
                                                        <i class="ri-wifi-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-light">Envios a Sunat</p>
                                                <h5 class="mb-3 text-light">Fact. Electrónicas</h5>
                                                <p class="text-truncate mb-0 text-light">Enviar Facturas <i class="ri-arrow-right-circle-fill align-bottom ms-1"></i></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ******************************************************** -->
                    <!-- ******************************************************** -->
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title">Ventas Realizadas</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                                    ALL
                                                </button>
                                                <button type="button" class="btn btn-soft-primary btn-sm">
                                                    1M
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                                    6M
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm active">
                                                    1Y
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div id="mixed-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                                <!-- end card-body -->

                                <div class="card-body border-top">
                                    <div class="text-muted text-center">
                                        <div class="row">
                                            <div class="col-4 border-end">
                                                <div>
                                                    <p class="mb-2"><i class="mdi mdi-circle font-size-12 text-primary me-1"></i> Expenses</p>
                                                    <h5 class="font-size-16 mb-0">$ 8,524 <span class="text-success font-size-12"><i class="mdi mdi-menu-up font-size-14 me-1"></i>1.2 %</span></h5>
                                                </div>
                                            </div>
                                            <div class="col-4 border-end">
                                                <div>
                                                    <p class="mb-2"><i class="mdi mdi-circle font-size-12 text-light me-1"></i> Maintenance</p>
                                                    <h5 class="font-size-16 mb-0">$ 8,524 <span class="text-success font-size-12"><i class="mdi mdi-menu-up font-size-14 me-1"></i>2.0 %</span></h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="mb-2"><i class="mdi mdi-circle font-size-12 text-danger me-1"></i> Profit</p>
                                                    <h5 class="font-size-16 mb-0">$ 8,524 <span class="text-success font-size-12"><i class="mdi mdi-menu-up font-size-14 me-1"></i>0.4 %</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!--  -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex  align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title">Tipo de Documentos</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <select class="form-select form-select-sm mb-0 my-n1">
                                                <option value="MAY" selected="">May</option>
                                                <option value="AP">April</option>
                                                <option value="MA">March</option>
                                                <option value="FE">February</option>
                                                <option value="JA">January</option>
                                                <option value="DE">December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <div id="radialBar-chart" class="apex-charts" dir="ltr"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-primary font-size-18">
                                                        <i class="ri ri-newspaper-line text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Facturas</h5>
                                                <p class="text-muted mb-0">125 Total</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-info font-size-18">
                                                        <i class="ri ri-newspaper-line text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Boletas</h5>
                                                <p class="text-muted mb-0">112 Total</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="social-source text-center mt-3">
                                                <div class="avatar-xs mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-danger font-size-18">
                                                        <i class="ri ri-newspaper-line text-white"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15">Notas Venta</h5>
                                                <p class="text-muted mb-0">104 Total</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                    <!-- ******************************************************** -->
                    <!-- ******************************************************** -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Ultimas Ventas</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheckall">
                                                            <label class="form-check-label" for="customCheckall"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">Clientes</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Tienda</th>
                                                    <th scope="col">Comprobante</th>
                                                    <th scope="col">Monto Total</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($xCargo == 'Super Administrador') {
                                                    $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM factura WHERE codigo_compro!='100' ORDER BY fecha_registro DESC LIMIT 10");
                                                } else {
                                                    $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM factura WHERE codigo_compro!='100' AND  cod_puntoventa='$xTienda' ORDER BY fecha_registro DESC LIMIT 10");
                                                }
                                                while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                    $id_factura         = $fconsul['id_factura'];
                                                    $codigo_compro      = $fconsul['codigo_compro'];
                                                    $comprobante        = $fconsul['serie'] . '-' . $fconsul['num_comprobante'];
                                                    $fecha_registro     = date('d-m-Y', strtotime($fconsul['fecha_registro']));
                                                    $razon_social       = substr($fconsul['razon_social'], 0, 40) . '.';
                                                    $numero_documento   = $fconsul['numero_documento'];
                                                    $total_monto        = "s/. " . number_format($fconsul['total_monto'], 2);
                                                    $cod_puntoventa     = $fconsul['cod_puntoventa'];
                                                    if ($fconsul['estado'] == 'Enviado') {
                                                        $estado = "<i class='mdi mdi-checkbox-blank-circle text-success me-1'></i> Enviado";
                                                    } else {
                                                        $estado = "<i class='mdi mdi-checkbox-blank-circle text-danger me-1'></i> Por Enviar";
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
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-1 font-size-12"><?= $numero_documento ?></p>
                                                            <h5 class="font-size-15 mb-0"><?= $razon_social ?></h5>
                                                        </td>
                                                        <td><?= $fecha_registro ?></td>
                                                        <td><?= $tienda ?></td>
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
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
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

    <!-- apexcharts js -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- jquery.vectormap map -->
    <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

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
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

<!-- CWP Training Center -->

</html>