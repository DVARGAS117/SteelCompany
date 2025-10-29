<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$sqlConsulta    = mysqli_query($conexion, "SELECT cod_personal, nombres FROM personal WHERE cod_personal='$xCodPer'");
$fila           = mysqli_fetch_array($sqlConsulta);
$cod_personal   = $fila['cod_personal'];
$nombres        = $fila['nombres'];
?>
<!doctype html>
<html lang="en">

<head>
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
                                <h4 class="mb-sm-0">Cambiar Contraseña de <?= $xNombres ?></h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="dashboard.php" class="btn btn-success waves-effect waves-light">
                                            <i class="mdi mdi-home-variant-outline"></i> Volver
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
                                            <label class="col-md-2 col-form-label">Nombre del Personal</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="nombres" id="nombres" value="<?= $nombres ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Ingrese Contraseña Actual</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave_actual" id="clave_actual">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Ingresar Contraseña</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave" id="clave">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Confirmar Contraseña</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave2" id="clave2">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <input type="button" class="btn btn-success waves-effect waves-light" value="ACTUALIZAR CONTRASEÑA" id="benviar">
                                                <input type="hidden" name="proceso" id="proceso">
                                                <input type="hidden" name="modulo" id="modulo">
                                                <input type="hidden" name="cod_personal" id="cod_personal" value="<?= $cod_personal ?>">
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

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>
    <script>
        $(function() {
            $("#clave_actual").keypress(function(e) {
                if (e.which == 13) {
                    ValidarGenerarClave();
                    return false;
                }
            })
            $("#clave").keypress(function(e) {
                if (e.which == 13) {
                    ValidarGenerarClave();
                    return false;
                }
            })
            $("#clave2").keypress(function(e) {
                if (e.which == 13) {
                    ValidarGenerarClave();
                    return false;
                }
            })
            $("#benviar").click(function() {
                ValidarGenerarClave();
                return false;
            })

            function ValidarGenerarClave() {
                if ($("#clave_actual").val() == '') {
                    alert("Ingresar Constraseña Actual");
                    $("#clave_actual").focus();
                    return false;
                }
                if ($("#clave").val() == '' || $("#clave").val().length < 6) {
                    alert("Ingresar Minimo 6 Caracteres");
                    $("#clave").focus();
                    return false;
                }
                if ($("#clave2").val() == '' || $("#clave2").val().length < 6) {
                    alert("Debe Confirmar la Clave");
                    $("#clave2").focus();
                    return false;
                }
                if ($("#clave").val() != $("#clave2").val()) {
                    alert("Las Claves No Son Iguales");
                    $("#clave2").focus();
                    return false;
                }
                ActualizarClave();
            }

            function ActualizarClave() {
                $("#proceso").val('ActualizarClave');
                $("#modulo").val('Clave');
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/proceso-guardar.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").val("PROCESANDO...");
                    },
                    success: function(data) {
                        var respuesta = data.respuesta;
                        if (respuesta == 'SI') {
                            alert("Su contraseña se reestablecio con exito!!");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            alert("Su contraseña actual no coincide!!");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    }
                })
            }
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>