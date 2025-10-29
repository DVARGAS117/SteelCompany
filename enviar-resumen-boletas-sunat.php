<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Seleccionar Serie</label>
                            <div class="col-md-10">
                                <select class="form-select" name="serie" id="serie">
                                    <option value="0">Seleccionar Serie</option>
                                    <?php
                                    $sqlDocumentos  = mysqli_query($conexion, "SELECT * FROM serie_documentos WHERE codigo_compro='03' AND estado='A'");
                                    while ($fdocs   = mysqli_fetch_array($sqlDocumentos)) {
                                        $serie      = $fdocs['serie'];
                                        echo "<option value='$serie'>$serie</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Seleccionar Fecha</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="fecha" id="fecha">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> BUSCAR BOLETAS
                                </button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="bresumen">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> ENVIAR RESUMEN
                                </button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="bexportar">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> EXPORTAR EXCEL
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
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
            $("#bresumen").hide();
            $("#bexportar").hide();
            /*************************************************/
            $("#benviar").click(function() {
                if ($("#serie").val() == 0) {
                    alert("Seleccionar Serie de Boleta");
                    $("#serie").focus();
                    return false;
                }
                if ($("#fecha").val() == '') {
                    alert("Ingresa Fecha Registro");
                    $("#fecha").focus();
                    return false;
                }
                $("#proceso").val("buscarBoletasVenta");
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/procesos-fact.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#resultado").html("<i class='mdi mdi-clock-outline align-middle me-2' style='color:#4DD765; font-size:24px'></i> Procesando busqueda...");
                    },
                    success: function(data) {
                        var valor = data.resultado;
                        var result = data.encontro;
                        $("#resultado").html(valor);
                        if (result == 'SI') {
                            $("#bresumen").show();
                            $("#bexportar").show();
                            $("#benviar").hide();
                        }
                    }
                })
            })
            /*************************************************/
            $("#bresumen").click(function() {
                var datosEnviar = $("#fapps").serialize();
                var e = confirm("¿Seguro que desea enviar el resumen?");
                if (e == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: "api/api_ejemplos/resumen_boletas_cpw.php",
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {
                            $("#resultado").html("<i class='mdi mdi-clock-outline align-middle me-2' style='color:#4DD765; font-size:24px'></i> Enviando Resumen...");
                        },
                        success: function(data) {
                            var respueta = data.respuesta;
                            var mensaje = data.mensaje;
                            var reshtl = data.resultadosunat;
                            $("#resultado").html(reshtl);
                            $("#bresumen").show();
                            $("#benviar").html('PROCESO FINALIZADO');
                        }
                    })
                }
                return false;
            })
            /*************************************************/

            /*************************************************/
        })
    </script>
</body>

</html>