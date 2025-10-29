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
                            <label for="example-text-input" class="col-md-2 col-form-label">Origen</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_puntoventa_origen" id="cod_puntoventa_origen">
                                    <?php
                                    $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A' AND alias='AL'");
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Destino</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_puntoventa_destino" id="cod_puntoventa_destino">
                                    <option value='0'>Seleccionar Punto Venta</option>
                                    <?php
                                    $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A' AND alias!='AL'");
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
                            <div class="col-md-12">
                                Buscar Productos
                                <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="Buscar por nombre o codigo de producto">
                            </div>
                            <div class="col-md-12">
                                <div id="display" style="margin-top: 10px;"></div>
                            </div>
                            <div class="col-md-12">
                                <div id="resultados" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ASIGNAR PRODUCTOS A TIENDA
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="bcancelar">
                                    <i class="mdi mdi-delete align-middle me-2"></i> CANCELAR OPERACION
                                </button>
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
            $("#caja_busqueda").focus();
            $("#display").hide();
            /************************************************/
            /************************************************/
            $("#caja_busqueda").keypress(function(e) {
                if (e.which == 13) {
                    var texto = $(this).val();
                    var dataString = "palabra=" + texto;
                    if ($(this).val() == '') {
                        $("#display").hide();
                        return false;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "ajax/busqueda-asignarstock.php",
                            data: dataString,
                            cache: false,
                            success: function(html) {
                                $("#display").html(html).show();
                            }
                        })
                    }
                    return false;
                }
            })
            /************************************************/
            /************************************************/
            $("#bcancelar").click(function() {
                var proceso = "CancelarSesionSalida";
                var datosEnviar = {
                    proceso: proceso
                }
                $.ajax({
                    type: "POST",
                    url: "config/procesos-fact.php",
                    data: datosEnviar,
                    success: function(datos) {
                        parent.location.reload();
                    }
                })
            })
            /************************************************/
            /************************************************/
            $("#benviar").click(function() {
                var productos = $("#resultados").children().length;
                if ($("#cod_puntoventa_destino").val() == 0) {
                    alert("Falta seleccionar destino");
                    $("#cod_puntoventa_destino").focus();
                    return false;
                }
                if (productos == 0) {
                    alert("Falta asignar productos a la guia de salida");
                    $("#caja_busqueda").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('asignarStockTiendas');
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/procesos-fact.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").html("PROCESANDO...");
                    },
                    success: function(data) {
                        var respuesta = data.respuesta;
                        if (respuesta == 'SI') {
                            alert("Los productos se asignaron en forma correcta");
                            parent.location.reload();
                        }
                    }
                })
            })
            /********************************************/
            /********************************************/
            $(document).on("click", ".agregar, .eliminarpro", function(e) {
                e.preventDefault();
            })
        })
        /************************************************/
        /************************************************/
        function agregar2(cod_prod, cant) {
            var cod_prod = cod_prod;
            var cant = cant;
            var datosEnviar = {
                cod_producto: cod_prod,
                cantidad: cant
            }
            $.ajax({
                type: "POST",
                url: "ajax/agregar-salidastock.php",
                data: datosEnviar,
                beforeSend: function() {
                    $("#resultados").html("Cargando...");
                },
                success: function(datos) {
                    $("#resultados").html(datos);
                }
            })
            document.getElementById("caja_busqueda").value = "";
            $("#cajabusqueda").focus();
            $("#display").hide();
            return false;
        }
        /************************************************/
        /************************************************/
        function eliminar(id) {
            $.ajax({
                type: "GET",
                url: "ajax/agregar-salidastock.php",
                data: "id=" + id,
                beforeSend: function() {
                    $("#resultados").html("Cargando...");
                },
                success: function(datos) {
                    $("#resultados").html(datos);
                }
            })
        }
    </script>
</body>

</html>