<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$id_factura         = $_REQUEST['id_factura'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$id_factura         = $fcons['id_factura'];
$codigo_compro      = $fcons['codigo_compro'];
$fecha_registro     = date('d-m-Y', strtotime($fcons['fecha_registro']));
$serie              = $fcons['serie'] . '-' . $fcons['num_comprobante'];
if ($codigo_compro == '01') {
    $documento      = "Factura";
}
if ($codigo_compro == '07') {
    $documento      = "Nota De Credito";
}
$monto_total        = "S/." . number_format($fcons['total_monto'], 2);
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Documento a Enviar</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="documento" id="documento" value="<?= $documento ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Fecha Registro</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="fecha_registro" id="fecha_registro" value="<?= $fecha_registro ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Serie</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="serie" id="serie" value="<?= $serie ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Monto Total</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="monto_total" id="monto_total" value="<?= $monto_total ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> ENVIAR A SUNAT AHORA
                                </button>
                                <input type="hidden" name="id_factura" id="id_factura" value="<?= $id_factura ?>">
                                <input type="hidden" name="codigo_compro" id="codigo_compro" value="<?= $codigo_compro ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <div id="resultado"></div>
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
                var linkurl = "";
                var id_factura = $("#id_factura").val();
                var codigo_compro = $("#codigo_compro").val();
                if (codigo_compro == '01') {
                    linkurl = "api/api_ejemplos/envio_data_factura_cpw.php";
                }
                if (codigo_compro == '07') {
                    linkurl = "api/api_ejemplos/envio_data_nota_credito_cpw.php";
                }
                var datosEnviar = {
                    'id_factura': id_factura
                }
                var r = confirm("¿Seguro que deseas enviar la Factura/Nota de Credito?");
                if (r == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: linkurl,
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {
                            $("#benviar").html("<i class='mdi mdi-clock-outline align-middle me-2'></i> Enviando Factura a Sunat...");
                        },
                        success: function(data) {
                            var respuesta = data.respuesta;
                            var mensaje = data.mensaje;
                            var reshtml = data.resultadosunat;
                            $("#resultado").html(reshtml);
                            $("#benviar").html("<i class='mdi mdi-emoticon-happy-outline align-middle me-2'></i> PROCESO FINALIZADO");
                        }
                    })
                }
                return false;
            })
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>