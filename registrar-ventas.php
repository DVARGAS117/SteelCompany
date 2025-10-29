<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
$sqlConsulta        = mysqli_query($conexion, "SELECT * FROM empresa");
$fila               = mysqli_fetch_array($sqlConsulta);
$id_empresa         = $fila['id_empresa'];
$ruc                = $fila['ruc'];
$razon_social       = $fila['razon_social'];
$nombre_comercial   = $fila['nombre_comercial'];
$direccion          = $fila['direccion'];
$telefono           = $fila['telefono'];
$movil              = $fila['movil'];
$email              = $fila['email'];
$tipo               = $fila['tipo'];
$usuario_sol        = $fila['usuario_sol'];
$clave_sol          = $fila['clave_sol'];
$certificado        = $fila['certificado'];
$clave_certificado  = $fila['clave_certificado'];
$clave_borrar       = $fila['clave_borrar'];
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
                                <h4 class="mb-sm-0">Generar Boletas/Facturas</h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="ventas.php" class="btn btn-success waves-effect waves-light">
                                            <i class="ri-arrow-left-circle-fill align-middle me-2"></i> Ver Ventas Diarias
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
                                        <?php
                                        if ($xNumCaja > 0) {
                                        ?>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    Tipo de Documento
                                                    <select class="form-select" name="codigo_compro" id="codigo_compro">
                                                        <option value="0">Tipo de Documento</option>
                                                        <?php
                                                        $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE estado='A' AND (codigo_compro='03' OR codigo_compro='01' OR codigo_compro='100')");
                                                        while ($fdocs = mysqli_fetch_array($sqlDocumentos)) {
                                                            $codigo_compro  = $fdocs['codigo_compro'];
                                                            $descripcion    = $fdocs['descripcion'];
                                                            echo "<option value='$codigo_compro'>$descripcion</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    Serie/Número
                                                    <div class="mb-3 row">
                                                        <div class="col-md-6">
                                                            <select class="form-select" name="serie" id="serie">
                                                                <option value="0">Serie</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" placeholder="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Fecha de Venta
                                                    <input class="form-control" type="text" name="fecha_registro" id="fecha_registro" value="<?= date('d-m-Y') ?>" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3 row">
                                                        <div class="col-md-8">
                                                            Nº RUC/DNI
                                                            <input class="form-control" type="text" name="numero_documento" id="numero_documento">
                                                        </div>
                                                        <div class="col-md-4">
                                                            Buscar
                                                            <a class="btn btn-success waves-effect waves-light" id="bbuscar">
                                                                <i class="mdi mdi-account-search"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    Razon Socal/Nombre Cliente
                                                    <input class="form-control" type="text" name="razon_social" id="razon_social">
                                                </div>
                                                <div class="col-md-3">
                                                    Dirección
                                                    <input class="form-control" type="text" name="direccion_empresa" id="direccion_empresa">
                                                </div>
                                                <div class="col-md-3">
                                                    Email Cliente
                                                    <input class="form-control" type="text" name="email_cliente" id="email_cliente">
                                                </div>
                                                <div class="col-md-3">
                                                    Forma de Pago
                                                    <select class="form-select" name="forma_pago" id="forma_pago">
                                                        <option value="Contado">Al Contado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    Observaciones Adicional
                                                    <input class="form-control" type="text" name="observacion" id="observacion">
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-sb-backdrop="static" data-sb-keyboard="false" id="bbuscar">
                                                        Agregar Producto <i class="ri-folder-add-fill align-middle ms-2"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-12">
                                                    <div id="resultados" style="margin-top: 10px; width: 100%;"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                                        <i class="ri-printer-fill align-middle me-2"></i> IMPRIMIR TIKECT
                                                    </button>
                                                    <input type="hidden" name="proceso" id="proceso">
                                                    <input type="hidden" name="tipo_impresion" id="tipo_impresion">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-success waves-effect waves-light" id="benviarpdf">
                                                        <i class="mdi mdi-file-pdf align-middle me-2"></i> IMPRIMIR DPF&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="bcancelar">
                                                        <i class="ri-delete-back-2-fill align-middle me-2"></i> CANCELAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </button>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="mb-3 row">
                                                <div class="col-md-12">
                                                    <p class="text-danger text-center h4"><i class="ri-key-fill align-middle me-2"></i> No hay caja aperturada para esta tienda..</p>
                                                    <div class="text-center">
                                                        <a href="cajas.php?sub_modulo=Apertura Caja" class="btn btn-primary waves-effect waves-light">
                                                            <i class="ri-key-fill align-middle me-2"></i> Aperturar Caja
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
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
    <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Buscar y Agregar Productos al Facturador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <input class="form-control" type="search" name="caja_busqueda" id="caja_busqueda" placeholder="Buscar producto por nombre o código">
                        </div>
                        <div class="col-md-12">
                            <div id="mostrarproductos" style="margin-top: 10px;">
                            </div>
                        </div>
                    </div>
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
    <script src="assets/js/VentanaCentrada.js"></script>

    <script>
        $(function() {
            /************************************************************/
            /************************************************************/
            $("#bs-example-modal-xl").on("hidden.bs.modal", function() {
                $("#caja_busqueda").val('');
                $("#mostrarproductos").html('');
            })
            /************************************************************/
            /************************************************************/
            agregar(0, 0, 0);
            /************************************************************/
            /************************************************************/
            $("#bbuscar").click(function() {
                var num_doc = $("#numero_documento").val();
                var codigo_compro = $("#codigo_compro").val();
                if (codigo_compro == '01') {
                    tipo_doc = '06';
                }
                if (codigo_compro == '03' | codigo_compro == '100') {
                    tipo_doc = '01';
                }
                if (codigo_compro == '0') {
                    alert("Seleccionar Tipo de Documento");
                    $("#codigo_compro").focus();
                    return false;
                }
                if (num_doc == '') {
                    alert("Ingrese el Nº de Documento");
                    $("#numero_documento").focus();
                    return false;
                }
                if (tipo_doc == '06' && ($("#numero_documento").val().length > 11 || $("#numero_documento").val().length < 11)) {
                    alert("El RUC Debe Tener 11 Digitos");
                    $("#numero_documento").focus();
                    return false;
                }
                if (tipo_doc == '01' && ($("#numero_documento").val().length > 8 || $("#numero_documento").val().length < 8)) {
                    alert("El DNI Debe Tener 8 Digitos");
                    $("#numero_documento").focus();
                    return false;
                }
                var datosEnviar = {
                    'tipo_doc': tipo_doc,
                    'num_doc': num_doc,
                    'proceso': 'BuscarCliente'
                }
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviar,
                    dataType: "json",
                    beforeSend: function() {
                        $("#bbuscar").html('<i class="dripicons-clock"></i>');
                    },
                    success: function(data) {
                        $("#razon_social").val(data.nombre_cliente);
                        $("#direccion_empresa").val(data.direcion_cliente);
                        $("#email_cliente").val(data.email_cliente);
                        $("#bbuscar").html('<i class="mdi mdi-account-search"></i>');
                    }
                })
            })
            /************************************************************/
            /************************************************************/
            $("#codigo_compro").change(function() {
                var codigo = $(this).val();
                $("#num_comprobante").val('');
                var datosEnviados = {
                    'codigo_compro': codigo,
                    'proceso': "BuscarSeriesNum"
                };
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviados,
                    dataType: "json",
                    success: function(data) {
                        $("#serie").html(data.resultado);
                        $("#num_comprobante").val(data.num_compro);
                    }
                });
            })
            /************************************************************/
            /************************************************************/
            $("#caja_busqueda").focus();
            $("#mostrarproductos").hide();
            /************************************************************/
            /************************************************************/
            $("#caja_busqueda").keyup(function(e) {
                if (e.which == 13) {
                    BuscarProductos();
                    return false;
                }
                if ($(this).val() == '') {
                    $("#mostrarproductos").hide();
                    return false;
                }
            })
            /************************************************************/
            /************************************************************/
            function BuscarProductos() {
                var texto = $("#caja_busqueda").val();
                var datosEnviar = {
                    'palabra': texto
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/busqueda-productos.php",
                    data: datosEnviar,
                    cache: false,
                    success: function(datos) {
                        $("#mostrarproductos").html(datos).show()
                    }
                })
            }
            /************************************************************/
            /************************************************************/
            $("#bcancelar").click(function() {
                var datosEnviar = {
                    'proceso': 'CancelarSesionVentas'
                }
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviar,
                    success: function(datos) {
                        location.reload()
                    }
                })
            })
        })
        /****************************************************************/
        /****************************************************************/
        function agregar(cod_prod, cant, precio) {
            var datosEnviar = {
                'cod_producto': cod_prod,
                'cantidad': cant,
                'precio': precio
            }
            $.ajax({
                type: "POST",
                url: "ajax/agregar-facturacion.php",
                data: datosEnviar,
                beforeSend: function() {
                    $("#resultados").html("Cargando productos...")
                },
                success: function(datos) {
                    $("#resultados").html(datos);
                }
            })
        }
        /****************************************************************/
        /****************************************************************/
        function eliminar(id) {
            var datosEnviar = {
                'id': id
            }
            $.ajax({
                type: "GET",
                url: "ajax/agregar-facturacion.php",
                data: datosEnviar,
                beforeSend: function() {
                    $("#resultados").html("Cargando productos...")
                },
                success: function(datos) {
                    $("#resultados").html(datos);
                }
            })
        }
        /****************************************************************/
        /****************************************************************/
        $("#benviar, #benviarpdf").click(function() {
            var resproductos = $("#resultados").children().length;
            var valorBoton = $(this).attr('id');
            $("#tipo_impresion").val(valorBoton);
            if ($("#codigo_compro").val() == 0) {
                alert("Seleccionar Tipo de Documento");
                $("#codigo_compro").focus();
                return false
            }
            if ($("#serie").val() == 0) {
                alert("Seleccionar Serie de Documento");
                $("#serie").focus();
                return false
            }
            if ($("#num_comprobante").val() == '') {
                alert("Ingrese Numero de Documento");
                $("#num_comprobante").focus();
                return false
            }
            if ($("#codigo_compro").val() == '01') {
                if ($("#numero_documento").val() == '') {
                    alert("Ingrese Numero de RUC");
                    $("#numero_documento").focus();
                    return false
                }
                if ($("#razon_social").val() == '') {
                    alert("Ingrese Razon Social");
                    $("#razon_social").focus();
                    return false
                }
                if ($("#direccion_empresa").val() == '') {
                    alert("Ingrese Direccion");
                    $("#direccion_empresa").focus();
                    return false
                }
            }
            /* if (resproductos == 2) {
                alert("Falta Ingresar Productos");
                return false
            } */
            grabarPago();
        });
        /****************************************************************/
        /****************************************************************/
        function grabarPago() {
            $("#proceso").val("VentaProductos");
            var datosEnviar = $("#fapps").serialize();
            VentanaCentrada('ventas/guardar-factura.php?' + datosEnviar, "Factura", '1024', '768', 'true');
            location.href = "ventas.php";
        }
    </script>
</body>

</html>