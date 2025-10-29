<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_apertura       = $_REQUEST['cod_apertura'];
$sqlCajas           = mysqli_query($conexion, "SELECT cod_puntoventa FROM apertura_cajas WHERE cod_apertura='$cod_apertura'");
$fcajas             = mysqli_fetch_array($sqlCajas);
$cod_puntoventa     = $fcajas['cod_puntoventa'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- plugin css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">

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
                            <label for="example-text-input" class="col-md-2 col-form-label">Fecha de Cierra</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="fecha_cierre" id="fecha_cierre" value="<?= date('d-m-Y') ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Punto de Venta</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_puntoventa" id="cod_puntoventa">
                                    <?php
                                    if ($xCargo == 'Super Administrador') {
                                        echo "<option value='0'>Seleccionar Punto de Venta</option>";
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
                                    } else {
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$xTienda'");
                                    }
                                    while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                        $cod_puntoventa     = $pventa['cod_puntoventa'];
                                        $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                        echo "<option value='$cod_puntoventa'>$nombre_puntoventa</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Estado</label>
                            <div class="col-md-10">
                                <input type="radio" name="estado" value="Aperturado" checked> Aperturado
                                <input type="radio" name="estado" value="Cerrado"> Cerrado
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> CERRAR CAJA
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_apertura" value="<?= $cod_apertura ?>">
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

    <!-- plugins -->
    <script src="assets/libs/select2/js/select2.min.js"></script>

    <!-- init js -->
    <script src="assets/js/pages/form-advanced.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        $(function() {
            $("#benviar").click(function() {
                if ($("#cod_puntoventa").val() == 0) {
                    alert("Falta seleccionar el punto de venta");
                    $("#cod_puntoventa").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('CerrarAperturaCaja');
                $("#modulo").val('Cajas');
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
                            alert("La caja se cerró con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos la caja no cerror.");
                        }
                    }
                })
            })
        });
    </script>
</body>

</html>