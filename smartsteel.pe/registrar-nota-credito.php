<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
?>
<!doctype html>
<html lang="en">

<head>
    <!-- plugin css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">

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
                                <h4 class="mb-sm-0">Generar Notas de Credito</h4>

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
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                ¿Para quien es la Nota de Credito?
                                                <select class="form-select select2" name="documento" id="documento">
                                                    <option value="0">Select. Boleta/Factura</option>
                                                    <?php
                                                    $sqlFacturas = mysqli_query($conexion, "SELECT id_factura, serie, num_comprobante FROM factura WHERE estado='Enviado' AND (codigo_compro='01' OR codigo_compro='03')");
                                                    while ($ffacts  = mysqli_fetch_array($sqlFacturas)) {
                                                        $id_factura = $ffacts['id_factura'];
                                                        $serie      = $ffacts['serie'] . '-' . $ffacts['num_comprobante'];
                                                        echo "<option value='$id_factura'>$serie</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                Tipo de Documento
                                                <select class="form-select" name="codigo_compro" id="codigo_compro">
                                                    <?php
                                                    $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE estado='A' AND codigo_compro='07'");
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
                                                Fecha de Registro
                                                <input class="form-control" type="text" name="fecha_registro" id="fecha_registro" value="<?= date('d-m-Y') ?>" readonly>
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
                                                <input type="hidden" name="numero_documento" id="numero_documento">
                                            </div>
                                            <div class="col-md-3">
                                                Email Cliente
                                                <input class="form-control" type="text" name="email_cliente" id="email_cliente">
                                            </div>
                                            <div class="col-md-3">
                                                Tipo Documento
                                                <input class="form-control" type="text" name="tipo_documento" id="tipo_documento">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Documento a Modificar
                                                <input class="form-control" type="text" name="doc_modificado" id="doc_modificado">
                                            </div>
                                            <div class="col-md-3">
                                                Motivo Nota de Credito
                                                <select class="form-select" name="cod_tipo_motivo" id="cod_tipo_motivo">
                                                    <option value="0">Seleccionar Motivo</option>
                                                    <?php
                                                    $sqlMotivoNCre      = mysqli_query($conexion, "SELECT * FROM motivo_nota_credito");
                                                    while ($fmnc        = mysqli_fetch_array($sqlMotivoNCre)) {
                                                        $codigo         = $fmnc['codigo'];
                                                        $descripcion    = $fmnc['descripcion'];
                                                        echo "<option value='$codigo'>$descripcion</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                Observaciones Adicionales
                                                <input class="form-control" type="text" name="observacion" id="observacion">
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
                                                <input type="hidden" name="modulo" id="modulo">
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
    <!-- plugins -->
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <!-- init js -->
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/VentanaCentrada.js"></script>

    <script>
        $(function() {
            /************************************************************/
            /************************************************************/
            $("#documento").change(function() {
                if ($("#documento").val() == 0) {
                    alert("Seleccionar Documento a Buscar");
                    $("#documento").focus();
                    return false;
                }
                realizarBusquedaDoc();
            })
            /************************************************************/
            /************************************************************/
            function realizarBusquedaDoc() {
                var documento = $("#documento").val();
                var codigo_compro = $("#codigo_compro").val();
                var datosEnviar = {
                    'documento': documento,
                    'codigo_compro': codigo_compro,
                    'proceso': "BuscarDocumentoNC"
                };
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviar,
                    dataType: "json",
                    success: function(data) {
                        $("#razon_social").val(data.razon_social);
                        $("#direccion_empresa").val(data.direccion_empresa);
                        $("#numero_documento").val(data.numero_documento);
                        $("#email_cliente").val(data.email_cliente);
                        $("#tipo_documento").val(data.tipo_documento);
                        $("#doc_modificado").val(data.num_doc_modi);
                        $("#serie").html(data.resserie);
                        $("#num_comprobante").val(data.num_compro);
                    }
                })
                cargarProductos(documento);
            }
            /************************************************************/
            /************************************************************/
            function cargarProductos(id_factura) {
                var id_factura = id_factura;
                var datosEnviar = {
                    'id_factura': id_factura
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/cargar-factura.php",
                    data: datosEnviar,
                    beforeSend: function() {
                        $("#resultados").html("Cargando datos...");
                    },
                    success: function(data) {
                        $("#resultados").html(data);
                    }
                })
                return false;
            }
            /************************************************************/
            /************************************************************/
            agregar(0, 0, 0);
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
            if ($("#fecha_registro").val() == '') {
                alert("Ingrese Fecha de Registro");
                $("#fecha_registro").focus();
                return false
            }
            if ($("#tipo_documento").val() == '') {
                alert("Ingrese Tipo Documento Nota de Credito");
                $("#tipo_documento").focus();
                return false
            }
            if ($("#doc_modificado").val() == '') {
                alert("Ingrese Serie del Documento a Modificar");
                $("#doc_modificado").focus();
                return false
            }
            if ($("#cod_tipo_motivo").val() == 0) {
                alert("Seleccionar Motivo de Nota Credito");
                $("#cod_tipo_motivo").focus();
                return false
            }
            grabarNotaCredido();
        });
        /****************************************************************/
        /****************************************************************/
        function grabarNotaCredido() {
            $("#proceso").val("grabarNotaCreditos");
            var datosEnviar = $("#fapps").serialize();
            VentanaCentrada('ventas/guardar-factura.php?' + datosEnviar, "Factura", '1024', '768', 'true');
            location.href = "ventas.php";
        }
    </script>
</body>

</html>