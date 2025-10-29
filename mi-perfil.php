<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
/**********************************************/
/************** Consulta de Datos *************/
/**********************************************/
$sqlConsulta    = mysqli_query($conexion, "SELECT cod_personal, nombres, cod_tipodoc, num_documento, email, movil, imagen FROM personal WHERE cod_personal='$xCodPer'");
$fpersonal      = mysqli_fetch_array($sqlConsulta);
$cod_personal   = $fpersonal['cod_personal'];
$nombres        = $fpersonal['nombres'];
$cod_tipodoc    = $fpersonal['cod_tipodoc'];
$num_documento  = $fpersonal['num_documento'];
$email          = $fpersonal['email'];
$movil          = $fpersonal['movil'];
$imagen         = $fpersonal['imagen'];
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
    <!-- Dropzone Css -->
    <link href="assets/libs/dropzone/dropzone.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                                <h4 class="mb-sm-0">Bienvenidos a Tu Peril <?= $xNombres ?></h4>

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
                                            <label class="col-md-2 col-form-label">Nombres</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="nombres" id="nombres" value="<?= $nombres; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Tipo de Documento</label>
                                            <div class="col-md-10">
                                                <select class="form-select" name="cod_tipodoc" id="cod_tipodoc">
                                                    <?php
                                                    if ($cod_tipodoc == 0 or $cod_tipodoc == '') {
                                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                                        $sqlDocs = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad");
                                                        while ($fdoc = mysqli_fetch_array($sqlDocs)) {
                                                            $xcod_tipodoc = $fdoc['cod_tipodoc'];
                                                            $descripcion = $fdoc['descripcion'];
                                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                                        }
                                                    } else {
                                                        $sqlDocs = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc='$cod_tipodoc'");
                                                        while ($fdoc = mysqli_fetch_array($sqlDocs)) {
                                                            $xcod_tipodoc = $fdoc['cod_tipodoc'];
                                                            $descripcion = $fdoc['descripcion'];
                                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                                        }
                                                        $sqlDocs = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc!='$cod_tipodoc'");
                                                        while ($fdoc = mysqli_fetch_array($sqlDocs)) {
                                                            $xcod_tipodoc = $fdoc['cod_tipodoc'];
                                                            $descripcion = $fdoc['descripcion'];
                                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Numero Documento</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="num_documento" id="num_documento" value="<?= $num_documento; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Email</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="email" id="email" value="<?= $email; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Telefono/Movil</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="movil" id="movil" value="<?= $movil; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Subir Imagen Perfil</label>
                                            <div class="col-md-10">
                                                <div id="imgPerfil" class="dropzone"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="imagen" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="imagen" id="imagen" value="<?= $imagen ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <input type="button" class="btn btn-success waves-effect waves-light" value="ACTUALIZAR DATOS" id="benviar">
                                                <input type="hidden" name="cod_personal" value="<?= $cod_personal ?>">
                                                <input type="hidden" name="proceso" id="proceso">
                                                <input type="hidden" name="modulo" id="modulo">
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
    <!-- jquery dropzone -->
    <script src="assets/libs/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            /**********************************************/
            /************* Enviar Actualizar **************/
            /**********************************************/
            $("#benviar").click(function() {
                $("#proceso").val("ActualizarPerfil");
                $("#modulo").val("Perfil");
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/proceso-guardar.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").val("PROCESANDO");
                    },
                    success: function(data) {
                        var respuesta = data.respuesta;
                        if (respuesta == 'SI') {
                            location.reload();
                        }
                    }
                })
            })

        })
        //**************************************************/
        /********  Dropzone Subir Imagen Perfil   *********/
        /**************************************************/
        var pdfImagenes = new Dropzone("#imgPerfil", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*,application/pdf,.xlsx,.csv,.mp4",
            maxFiles: 2,
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
            dictDefaultMessage: "Arrastra la imagen JPG aquí."
        });
        pdfImagenes.on("addedfile", function(file) {
            console.log(file.name);
            var nomimg = file.name;
            document.getElementById("imagen").value = nomimg;
        });
        pdfImagenes.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        pdfImagenes.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "imgPerfil");
        });
        pdfImagenes.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        var images = [
            <?php
            $sqlImagen          = mysqli_query($conexion, "SELECT imagen FROM personal WHERE cod_personal='$cod_personal'");
            while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                $imagen         = $fimg['imagen'];
                $obj["name"]    = $imagen;
                $obj["size"]    = filesize("img-apps/personal/" . $imagen);
                echo "
            {
                name: '" . $obj["name"] . "',
                url: 'img-apps/personal/" . $obj["name"] . "',
                size: '" . $obj["size"] . "'
            },";
            }
            ?>
        ]
        for (let i = 0; i < images.length; i++) {
            let img = images[i];
            var mockFile = {
                name: img.name,
                size: img.size,
                url: img.url
            };
            pdfImagenes.emit("addedfile", mockFile);
            pdfImagenes.emit("thumbnail", mockFile, img.url);
            pdfImagenes.emit("complete", mockFile);
            var existingFileCount = 1;
            pdfImagenes.options.maxFiles = pdfImagenes.options.maxFiles - existingFileCount;
            pdfImagenes.options.createImageThumbnails = true;
        }
    </script>
</body>

</html>