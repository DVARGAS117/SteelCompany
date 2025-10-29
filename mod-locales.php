<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_puntoventa     = $_REQUEST['cod_puntoventa'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
$floc               = mysqli_fetch_array($sqlConuslta);
$cod_puntoventa     = $floc['cod_puntoventa'];
$nombre_puntoventa  = $floc['nombre_puntoventa'];
$alias              = $floc['alias'];
$direccion          = $floc['direccion'];
$telefono           = $floc['telefono'];
$email              = $floc['email'];
$estado             = $floc['estado'];
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Punto de Venta</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombre_puntoventa" id="nombre_puntoventa" value="<?= $nombre_puntoventa ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Alias</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="alias" id="alias" value="<?= $alias ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="direccion" id="direccion" value="<?= $direccion ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Telefono</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="telefono" id="telefono" value="<?= $telefono ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" value="<?= $email ?>">
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
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ACTUALIZAR PUNTO VENTA
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_puntoventa" id="cod_puntoventa" value="<?= $cod_puntoventa ?>">
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
                if ($("#nombre_puntoventa").val() == '') {
                    alert("Falta ingresar nombre del local");
                    $("#nombre_puntoventa").focus();
                    return false;
                }
                if ($("#alias").val() == '') {
                    alert("Falta ingresar alias del local");
                    $("#alias").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('ActualizarPuntoVenta');
                $("#modulo").val('PuntoVenta');
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
                            alert("El punto de venta se actualizo con exito.");
                            location.reload();
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