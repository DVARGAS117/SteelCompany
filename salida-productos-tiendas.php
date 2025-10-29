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
    <!-- Dropzone Css -->
    <link href="assets/libs/dropzone/dropzone.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Subir Excel CSV</label>
                            <div class="col-md-10">
                                <div id="csvProductosSalida" class="dropzone"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <p>Descargar plantilla Excel CSV <a href="img-apps/stocksalidacsv/plantilla-salida-productos.csv">AQUI</a> para llenar la informacion.<br>
                                    Los datos de las columnas con <strong>codigo, stock_salida</strong></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ASIGNAR PRODUCTOS A TIENDA
                                </button>
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="archivocsv" id="archivocsv">
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
    <!-- jquery dropzone -->
    <script src="assets/libs/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            $("#benviar").click(function() {
                if ($("#cod_puntoventa_destino").val() == 0) {
                    alert("Falta seleccionar destino");
                    $("#cod_puntoventa_destino").focus();
                    return false;
                }
                if ($("#archivocsv").val() == '') {
                    alert("Falta subir el archivo CSV");
                    $("#archivocsv").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#modulo").val('asignarStockTiendas');
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
                            alert("Los productos se asignaron con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos, no se completo el proceso.");
                        }
                    }
                })
            })
        })
        /**************************************************/
        /***********   Dropzone Subir Excel CSV  **********/
        /**************************************************/
        var pdfImagenes = new Dropzone("#csvProductosSalida", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*,application/pdf,.xlsx,.csv,.mp4",
            maxFiles: 1,
            maxFilesize: 250, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
            createImageThumbnails: true,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            addRemoveLinks: true,
            timeout: 180000,
            dictRemoveFileConfirmation: "¿Estas Seguro?", // ask before removing file
            dictFileTooBig: "El archivo es muy grande ({{filesize}}mb). El tamaño máximo permitido es {{maxFilesize}}mb",
            dictInvalidFileType: "Tipo de archivo invalido",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Borrar",
            dictMaxFilesExceeded: "Solo {{maxFiles}} archivos están permitidos",
            dictDefaultMessage: "Arrastra el Excel CSV aquí para subirlos"
        });
        pdfImagenes.on("addedfile", function(file) {
            console.log(file.name);
            var nomimg = file.name;
            document.getElementById("archivocsv").value = nomimg;
        });
        pdfImagenes.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        pdfImagenes.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "stockSalida");
        });
        pdfImagenes.on("error", function(file, response) {
            console.log(response);
        });
    </script>
</body>

</html>