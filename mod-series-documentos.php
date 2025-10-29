<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_serie          = $_REQUEST['cod_serie'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE cod_serie='$cod_serie'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$cod_serie          = $fcons['cod_serie'];
$codigo_compro      = $fcons['codigo_compro'];
$serie              = $fcons['serie'];
$cod_puntoventa     = $fcons['cod_puntoventa'];
$num_inicial        = $fcons['num_inicial'];
$num_actual         = $fcons['num_actual'];
$estado             = $fcons['estado'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("config/cabecera-web.php"); ?>
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

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" name="fapps" id="fapps">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Documento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="codigo_compro" id="codigo_compro">
                                    <?php
                                    if ($codigo_compro == '') {
                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                        $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE estado='A'");
                                        while ($fdocs = mysqli_fetch_array($sqlDocumentos)) {
                                            $codigo_compro  = $fdocs['codigo_compro'];
                                            $descripcion    = $fdocs['descripcion'];
                                            echo "<option value='$codigo_compro'>$descripcion</option>";
                                        }
                                    } else {
                                        $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE codigo_compro='$codigo_compro'");
                                        while ($fdocs = mysqli_fetch_array($sqlDocumentos)) {
                                            $codigo_compro  = $fdocs['codigo_compro'];
                                            $descripcion    = $fdocs['descripcion'];
                                            echo "<option value='$codigo_compro'>$descripcion</option>";
                                        }
                                        $sqlDocumentos = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE codigo_compro!='$codigo_compro'");
                                        while ($fdocs = mysqli_fetch_array($sqlDocumentos)) {
                                            $codigo_compro  = $fdocs['codigo_compro'];
                                            $descripcion    = $fdocs['descripcion'];
                                            echo "<option value='$codigo_compro'>$descripcion</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Serie Documento</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="serie" id="serie" value="<?= $serie ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Punto de Venta</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_puntoventa" id="cod_puntoventa">
                                    <?php
                                    if ($cod_puntoventa == 0 or $cod_puntoventa == '') {
                                        echo "<option value='0'>Seleccionar Punto de Venta</option>";
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A' AND alias!='AL'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    } else {
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                        /*****/
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa!='$cod_puntoventa' AND alias!='AL'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Inicial</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="num_inicial" id="num_inicial" value="<?= $num_inicial ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Actual</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="num_actual" id="num_actual" value="<?= $num_actual ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Estado</label>
                            <div class="col-md-10">
                                <input <?php if ($estado == 'A') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="estado" value="A"> Activo
                                <input <?php if ($estado == 'I') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="estado" value="I"> Inactivo
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ACTUALIZAR SERIE
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_serie" id="cod_serie" value="<?= $cod_serie ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    </p>
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
    <script>
        $(function() {
            $("#benviar").click(function() {
                if ($("#codigo_compro").val() == 0) {
                    alert("Falta seleccionar la tipo de documento");
                    $("#codigo_compro").focus();
                    return false;
                }
                if ($("#serie").val() == '') {
                    alert("Falta ingresar la serie");
                    $("#serie").focus();
                    return false;
                }
                if ($("#cod_puntoventa").val() == 0) {
                    alert("Falta seleccionar punto de venta");
                    $("#cod_puntoventa").focus();
                    return false;
                }
                if ($("#num_inicial").val() == '') {
                    alert("Falta ingresar numero inicial");
                    $("#num_inicial").focus();
                    return false;
                }
                if ($("#num_actual").val() == '') {
                    alert("Falta ingresar numero actual");
                    $("#num_actual").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('ActualizarSeries');
                $("#modulo").val('SeriesDocumentos');
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/proceso-guardar.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").html("PROCESANDO...");
                    },
                    success: function(data) {
                        var respuesta = data.respuesta;
                        if (respuesta == 'SI') {
                            alert("La serie se registro con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos pero la serie ya existe.");
                        }
                    }
                })
            })
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>