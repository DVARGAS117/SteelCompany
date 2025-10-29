<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$id_guia            = $_REQUEST['id_guia'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM guias_remision WHERE id_guia='$id_guia'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$id_factura         = $fcons['id_factura'];
$pdf                = $fcons['pdf'];
$ruta_xml           = $fcons['ruta_xml'];
/*********************************************/
$sqlConusCli        = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$fconsc             = mysqli_fetch_array($sqlConusCli);
$razon_social       = $fconsc['razon_social'];
$email_cliente      = $fconsc['email_cliente'];
if ($email_cliente == '' or !(validar_email($email_cliente))) {
    $mensaje       .= "ERROR: El documento no tiene un email valido. Modificar el email<br>";
}
if ($pdf == '') {
    $mensaje       .= "ERROR: El documento no tiene generado el pdf. Cierre la ventana y genere el PDF<br>";
}
if ($ruta_xml == '') {
    $mensaje       .= "ERROR: El documento no tiene generado el XML. Cierre la ventana y envie el documento a Sunat";
}
/**************************************************/
function validar_email($email)
{
    return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
}
/**************************************************/
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Razon Social del Cliente</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="razon_social" id="razon_social" value="<?= $razon_social ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email Cliente</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email_cliente" id="email_cliente" value="<?= $email_cliente ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">PDF a Enviar</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="pdf" id="pdf" value="<?= $pdf ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">XML a Enviar</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="ruta_xml" id="ruta_xml" value="<?= $ruta_xml ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <div id="mensaje"><?= $mensaje ?></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="ri-send-plane-fill align-middle me-2"></i> ENVIAR A CLIENTE
                                </button>
                                <input type="hidden" name="id_guia" id="id_guia" value="<?= $id_guia ?>">
                                <input type="hidden" name="razon_social" id="razon_social" value="<?= $razon_social ?>">
                                <input type="hidden" name="proceso" id="proceso">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
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
                $("#proceso").val("EnviarPDFXMLGuiaEmail");
                datosEnviar = $("#fapps").serialize();
                if ($("#email_cliente").val() == '') {
                    alert("Es necesario ingresar un email válido");
                    $("#email_cliente").focus();
                    return false
                }
                if ($("#dpf").val() == '') {
                    alert("Es necesario generar el PDF antes de enviar");
                    $("#pdf").focus();
                    return false
                }
                if ($("#ruta_xml").val() == '') {
                    alert("Es necesario enviar documento a Sunat para generar el XML");
                    $("#ruta_xml").focus();
                    return false
                }
                var r = confirm("¿Seguro que desea enviar los documentos al cliente?");
                if (r == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: "config/procesos-fact.php",
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {
                            $("#mensaje").html("<i class='mdi mdi-clock-outline align-middle me-2'></i> ENVIANDO PDF Y XML");
                        },
                        success: function(data) {
                            var respuesta = data.respuesta;
                            if (respuesta == 'SI') {
                                $("#mensaje").html("<i class='far fa-smile'></i> El PDF y XML se enviaron correctamente");
                                setTimeout(function() {
                                    location.reload();
                                }, 3000)
                            } else {
                                $("#mensaje").html("<i class='far fa-frown'></i> No se pudo enviar el PDF y XML");
                                setTimeout(function() {
                                    location.reload();
                                }, 3000)
                            }
                        }
                    })
                }
                return false
            })
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>