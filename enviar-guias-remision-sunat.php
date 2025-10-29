<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$id_guia            = $_REQUEST['id_guia'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM guias_remision WHERE id_guia='$id_guia'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$id_guia            = $fcons['id_guia'];
$id_factura         = $fcons['id_factura'];
$codigo_compro      = $fcons['codigo_compro'];
$fecha_registro     = date('d-m-Y', strtotime($fcons['fecha_registro']));
$serie              = $fcons['serie'] . '-' . $fcons['num_guia'];
if ($codigo_compro == '09') {
    $documento      = "Guía de Remisión";
}
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
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> ENVIAR A SUNAT AHORA
                                </button>
                                <input type="hidden" name="id_guia" id="id_guia" value="<?= $id_guia ?>">
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
                var id_guia = $("#id_guia").val();
                var linkurl = "api/api_ejemplos/envio_data_guia_remision_cpw.php";
                var datosEnviar = {
                    'id_guia': id_guia
                }
                var r = confirm("¿Seguro que deseas enviar la Guía de Remisión?");
                if (r == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: linkurl,
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {
                            $("#benviar").html("<i class='mdi mdi-clock-outline align-middle me-2'></i> Enviando Guía de Remisión a Sunat...");
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