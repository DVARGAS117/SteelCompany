<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$sqlVerificarCaja = mysqli_query($conexion, "SELECT cod_apertura FROM apertura_cajas WHERE (fecha_creacion='$fechaAtual' AND cod_puntoventa='$xTienda') OR estado='Aperturado' AND cod_puntoventa='$xTienda'");
$numCajaAper = mysqli_num_rows($sqlVerificarCaja);
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
                        <?php
                        if ($numCajaAper == 0) {
                        ?>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Fecha de Apertura</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="fecha_creacion" id="fecha_creacion" value="<?= date('d-m-Y') ?>" readonly>
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Moneda 50 Centimos</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="cincuenta_centimos" id="cincuenta_centimos">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_cincuenta" id="total_cincuenta" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Moneda 1 Sol</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="un_sol" id="un_sol">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_unsol" id="total_unsol" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Moneda 2 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="dos_soles" id="dos_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_dossoles" id="total_dossoles" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Moneda 5 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="cinco_soles" id="cinco_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_cincosoles" id="total_cincosoles" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Billete 10 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="diez_soles" id="diez_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_diezsoles" id="total_diezsoles" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Billete 20 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="veinte_soles" id="veinte_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_veintesoles" id="total_veintesoles" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Billete 50 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="cincuenta_soles" id="cincuenta_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_cincuentasoles" id="total_cincuentasoles" value="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Billete 100 Soles</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="cien_soles" id="cien_soles">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="total_ciensoles" id="total_ciensoles" value="0.00">
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Total Apertura</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="totaldinero" id="totaldinero" placeholder="0.00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                        <i class="mdi mdi-content-save align-middle me-2"></i> APERTURAR CAJA
                                    </button>
                                    <input type="hidden" name="proceso" id="proceso">
                                    <input type="hidden" name="modulo" id="modulo">
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <p class="text-danger text-center h4">Hay cajas aperturadas anteriormente o talvez hoy ya se aperturo la caja</p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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
                $("#proceso").val('RegistrarAperturaCaja');
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
                            alert("La caja se aperturo con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos la caja ya existe.");
                        }
                    }
                })
            })
            /*******************************************/
            /***  Calcular Dinero Segun Denominacion ***/
            /*******************************************/
            $("#cincuenta_centimos").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 500);
                var total = (subtotal / 1000);
                $("#total_cincuenta").val(total + ' Soles');
                totalDinero();
            })
            $("#un_sol").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 1000);
                var total = (subtotal / 1000);
                $("#total_unsol").val(total + ' Soles');
                totalDinero();
            })
            $("#dos_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 2000);
                var total = (subtotal / 1000);
                $("#total_dossoles").val(total + ' Soles');
                totalDinero();
            })
            $("#cinco_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 5000);
                var total = (subtotal / 1000);
                $("#total_cincosoles").val(total + ' Soles');
                totalDinero();
            })
            $("#diez_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 10000);
                var total = (subtotal / 1000);
                $("#total_diezsoles").val(total + ' Soles');
                totalDinero();
            })
            $("#veinte_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 20000);
                var total = (subtotal / 1000);
                $("#total_veintesoles").val(total + ' Soles');
                totalDinero();
            })
            $("#cincuenta_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 50000);
                var total = (subtotal / 1000);
                $("#total_cincuentasoles").val(total + ' Soles');
                totalDinero();
            })
            $("#cien_soles").keyup(function(e) {
                var moneda = $(this).val();
                var subtotal = (moneda * 100000);
                var total = (subtotal / 1000);
                $("#total_ciensoles").val(total + ' Soles');
                totalDinero();
            })
        });
        /***********************************************/
        /********    Funcion Sumatoria Totales   *******/
        /***********************************************/
        function totalDinero() {
            var total_cincuenta = parseFloat($("#total_cincuenta").val());
            var total_unsol = parseFloat($("#total_unsol").val());
            var total_dossoles = parseFloat($("#total_dossoles").val());
            var total_cincosoles = parseFloat($("#total_cincosoles").val());
            var total_diezsoles = parseFloat($("#total_diezsoles").val());
            var total_veintesoles = parseFloat($("#total_veintesoles").val());
            var total_cincuentasoles = parseFloat($("#total_cincuentasoles").val());
            var total_ciensoles = parseFloat($("#total_ciensoles").val());
            var total_dinero = (total_cincuenta + total_unsol + total_dossoles + total_cincosoles + total_diezsoles + total_veintesoles + total_cincuentasoles + total_ciensoles);
            $("#totaldinero").val(total_dinero + " Soles");
        }
    </script>
</body>

</html>