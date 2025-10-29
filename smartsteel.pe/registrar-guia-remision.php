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
                                <h4 class="mb-sm-0">Generar Guia de Remision</h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="guias-de-remision.php" class="btn btn-success waves-effect waves-light">
                                            <i class="ri-arrow-left-circle-fill align-middle me-2"></i> Volver a Guias
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
                                                ¿Para quien es la Guia?
                                                <select class="form-select select2" name="documento" id="documento">
                                                    <option value="0">Select. Boleta/Factura</option>
                                                    <?php
                                                    $sqlFacturas = mysqli_query($conexion, "SELECT id_factura, serie, num_comprobante FROM factura WHERE codigo_compro='01' OR codigo_compro='03'");
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
                                                    $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE estado='A' AND codigo_compro='09' AND cod_puntoventa='$xTienda'");
                                                    while ($fdocs = mysqli_fetch_array($sqlDocumentos)) {
                                                        $codigo     = $fdocs['codigo_compro'];
                                                        $serie      = $fdocs['serie'];
                                                        /**********************************************/
                                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT descripcion FROM tipo_documento WHERE codigo_compro='$codigo'");
                                                        $ftipodoc   = mysqli_fetch_array($sqlTipoDoc);
                                                        $descripcion = $ftipodoc['descripcion'];
                                                        /**********************************************/
                                                        echo "<option value='$codigo-$serie'>$descripcion</option>";
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
                                                        <input class="form-control" type="text" name="num_guia" id="num_guia" placeholder="0" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                Fecha de Registro
                                                <input class="form-control" type="text" name="fecha_registro" id="fecha_registro" value="<?= date('d-m-Y') ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- ************************* -->
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Razon Socal/Nombre Cliente
                                                <input class="form-control" type="text" name="razon_social" id="razon_social">
                                            </div>
                                            <div class="col-md-3">
                                                RUC/DNI
                                                <input class="form-control" type="text" name="numero_documento" id="numero_documento">
                                            </div>
                                            <div class="col-md-3">
                                                Fecha Inicio Traslado
                                                <input class="form-control" type="date" name="fecha_traslado" id="fecha_traslado" value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                Motivo de Traslado
                                                <select class="form-select" name="motivo_traslado" id="motivo_traslado">
                                                    <option value="0">Seleccionar Motivo</option>
                                                    <?php
                                                    $sqlMotTraslado = mysqli_query($conexion, "SELECT * FROM motivo_traslado_guias WHERE estado='A'");
                                                    while ($ftras   = mysqli_fetch_array($sqlMotTraslado)) {
                                                        $codigo         = $ftras['codigo'];
                                                        $descripcion    = $ftras['descripcion'];
                                                        echo "<option value='$codigo-$descripcion'>$descripcion</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- ************************* -->
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Direccion de Partida
                                                <input class="form-control" type="text" name="direccion_partida" id="direccion_partida" value="<?= $xDireccionTienda ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 row">
                                                    <div class="col-md-9">
                                                        Ubigeo Origen
                                                        <input class="form-control" type="text" name="ubigeo_partida" id="ubigeo_partida">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <br>
                                                        <a class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" id="bubigeopartida">
                                                            <i class="mdi mdi-account-search"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                Peso en Kilogramos
                                                <input class="form-control" type="text" name="peso" id="peso" value="1">
                                            </div>
                                            <div class="col-md-3">
                                                Nro. de Paquetes
                                                <input class="form-control" type="text" name="numero_paquetes" id="numero_paquetes" value="1">
                                            </div>
                                        </div>
                                        <!-- ************************* -->
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Ruc Transporte
                                                <input class="form-control" type="text" name="nro_documento_transporte" id="nro_documento_transporte">
                                            </div>
                                            <div class="col-md-3">
                                                Razon Social Transporte
                                                <input class="form-control" type="text" name="razon_social_transporte" id="razon_social_transporte">
                                            </div>
                                            <div class="col-md-3">
                                                Tipo de Trasporte
                                                <select class="form-select" name="codtipo_transportista" id="codtipo_transportista">
                                                    <option value="01">Transporte Publico</option>
                                                    <option value="02">Transporte Privado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                Direccion o Punto de LLegada
                                                <input class="form-control" type="text" name="domicilio_llegada" id="domicilio_llegada">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Contacto en Punto de LLegada
                                                <input class="form-control" type="text" name="contacto_llegada" id="contacto_llegada">
                                            </div>
                                            <div class="col-md-3">
                                                Telefono en Punto de LLegada
                                                <input class="form-control" type="text" name="telefono_llegada" id="telefono_llegada">
                                            </div>
                                            <div class="col-md-3">
                                                Fecha de LLegada
                                                <input class="form-control" type="date" name="fecha_llegada" id="fecha_llegada" value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 row">
                                                    <div class="col-md-9">
                                                        Ubigeo Destino
                                                        <input class="form-control" type="text" name="ubigeo_destino" id="ubigeo_destino">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <br>
                                                        <a class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" id="bubigeodestino">
                                                            <i class="mdi mdi-account-search"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                Vehiculo Marca y Nro.Placa
                                                <input class="form-control" type="text" name="vehiculo" id="vehiculo">
                                            </div>
                                            <div class="col-md-3">
                                                Nro. Certificado Inscripcion
                                                <input class="form-control" type="text" name="certificado_inscripcion" id="certificado_inscripcion">
                                            </div>
                                            <div class="col-md-3">
                                                Licencia del Conductor
                                                <input class="form-control" type="text" name="licencia_conductor" id="licencia_conductor">
                                            </div>
                                            <div class="col-md-3">
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Agregar Ubigeo Origen/Destino</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Departamento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="IdDepartamento" id="IdDepartamento">
                                    <option value="0">Seleccionar Departamento</option>
                                    <?php
                                    $sqlDepart          = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
                                    while ($fdepa       = mysqli_fetch_array($sqlDepart)) {
                                        $IdDepartamento = $fdepa['id'];
                                        $Departamento   = $fdepa['name'];
                                        echo "<option value='$IdDepartamento'>$Departamento</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Provincia</label>
                            <div class="col-md-10">
                                <select class="form-select" name="IdProvincia" id="IdProvincia">
                                    <option value="0">Seleccionar Provincia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Distrito</label>
                            <div class="col-md-10">
                                <select class="form-select" name="IdDistrito" id="IdDistrito">
                                    <option value="0">Seleccionar Distrito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <button type="button" class="btn btn-success waves-effect waves-light" id="basignarubigeo">
                                <i class="mdi mdi-content-save align-middle me-2"></i> ASIGNAR UBIGEO
                            </button>
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
            $("#IdDepartamento").change(function() {
                var datosEnviar = {
                    'id': $(this).val(),
                    'proceso': 'Provincia'
                }
                $.ajax({
                    data: datosEnviar,
                    url: 'config/procesos-fact.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(datos) {
                        $("#IdProvincia").html(datos.resultado);
                    }
                })
            })
            $("#IdProvincia").change(function() {
                var datosEnviar = {
                    'id': $(this).val(),
                    'proceso': 'Distrito'
                }
                $.ajax({
                    data: datosEnviar,
                    url: 'config/procesos-fact.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(datos) {
                        $("#IdDistrito").html(datos.resultado);
                    }
                })
            })
            /************************************************************/
            /************************************************************/
            var valorubigeo = "";
            $("#bubigeopartida").click(function() {
                valorubigeo = "ubigeoPartida";
            })
            $("#bubigeodestino").click(function() {
                valorubigeo = "ubigeoDestino";
            })
            $("#basignarubigeo").click(function() {
                if ($("#IdDepartamento").val() == 0) {
                    alert("Seleccionar Departamento");
                    $("#IdDepartamento").focus();
                    return false;
                }
                if ($("#IdProvincia").val() == 0) {
                    alert("Seleccionar Provincia");
                    $("#IdProvincia").focus();
                    return false;
                }
                if ($("#IdDistrito").val() == 0) {
                    alert("Seleccionar Distrito");
                    $("#IdDistrito").focus();
                    return false;
                }
                if (valorubigeo == 'ubigeoPartida') {
                    var ubigeo_partida = $("#IdDistrito").val();
                    $("#ubigeo_partida").val(ubigeo_partida);
                    $("#IdDepartamento").val(0);
                    $("#IdProvincia").val(0);
                    $("#IdDistrito").val(0);
                    $("#bs-example-modal-xl").modal('hide');
                }
                if (valorubigeo == 'ubigeoDestino') {
                    var ubigeo_destino = $("#IdDistrito").val();
                    $("#ubigeo_destino").val(ubigeo_destino);
                    $("#IdDepartamento").val(0);
                    $("#IdProvincia").val(0);
                    $("#IdDistrito").val(0);
                    $("#bs-example-modal-xl").modal('hide');
                }
            })
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
                    'proceso': "BuscarDocumentoGR"
                };
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviar,
                    dataType: "json",
                    success: function(data) {
                        $("#razon_social").val(data.razon_social);
                        $("#domicilio_llegada").val(data.direccion_empresa);
                        $("#numero_documento").val(data.numero_documento);
                        $("#contacto_llegada").val(data.razon_social);
                        $("#serie").html(data.resserie);
                        $("#num_guia").val(data.num_compro);
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
            if ($("#num_guia").val() == '') {
                alert("Ingrese Numero de Guia");
                $("#num_guia").focus();
                return false
            }
            if ($("#fecha_traslado").val() == '') {
                alert("Ingrese Fecha de Traslado");
                $("#fecha_traslado").focus();
                return false
            }
            if ($("#motivo_traslado").val() == 0) {
                alert("Seleccionar Motivo Traslado");
                $("#motivo_traslado").focus();
                return false
            }
            if ($("#direccion_partida").val() == '') {
                alert("Ingrese Direccion de Partida");
                $("#direccion_partida").focus();
                return false
            }
            if ($("#ubigeo_partida").val() == '') {
                alert("Ingrese Ubigeo de Partida");
                $("#ubigeo_partida").focus();
                return false
            }
            if ($("#peso").val() == '') {
                alert("Ingrese el Peso");
                $("#peso").focus();
                return false
            }
            if ($("#numero_paquetes").val() == '') {
                alert("Ingrese Numero de Paquetes");
                $("#numero_paquetes").focus();
                return false
            }
            if ($("#domicilio_llegada").val() == 0) {
                alert("Ingrese Domicilio de Llegada");
                $("#domicilio_llegada").focus();
                return false
            }
            if ($("#ubigeo_destino").val() == '') {
                alert("Ingrese Ubigeo de Destino");
                $("#ubigeo_destino").focus();
                return false
            }
            grabarGuiaRemision();
        });
        /****************************************************************/
        /****************************************************************/
        function grabarGuiaRemision() {
            $("#proceso").val("grabarGuiaRemision");
            var datosEnviar = $("#fapps").serialize();
            VentanaCentrada('ventas/guardar-factura.php?' + datosEnviar, "Factura", '1024', '768', 'true');
            location.href = "guias-de-remision.php";
        }
    </script>
</body>

</html>