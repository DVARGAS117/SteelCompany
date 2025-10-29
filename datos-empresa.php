<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
$sqlConsulta        = mysqli_query($conexion, "SELECT * FROM empresa");
$fila               = mysqli_fetch_array($sqlConsulta);
$id_empresa         = $fila['id_empresa'];
$ruc                = $fila['ruc'];
$razon_social       = $fila['razon_social'];
$nombre_comercial   = $fila['nombre_comercial'];
$icono_web          = $fila['icono_web'];
$logo_app           = $fila['logo_app'];
$logo_movil         = $fila['logo_movil'];
$logo_documentos    = $fila['logo_documentos'];
$imagen_fondo       = $fila['imagen_fondo'];
$direccion          = $fila['direccion'];
$Departamento       = $fila['Departamento'];
$Provincia          = $fila['Provincia'];
$Distrito           = $fila['Distrito'];
$codigoUbigeo       = $fila['codigoUbigeo'];
$codigoLocal        = $fila['codigoLocal'];
$telefono           = $fila['telefono'];
$movil              = $fila['movil'];
$email              = $fila['email'];
$tipo               = $fila['tipo'];
$usuario_sol        = $fila['usuario_sol'];
$clave_sol          = $fila['clave_sol'];
$certificado        = $fila['certificado'];
$clave_certificado  = $fila['clave_certificado'];
$ruta_api           = $fila['ruta_api'];
$clave_borrar       = $fila['clave_borrar'];
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
                                <h4 class="mb-sm-0">Datos de Empresa</h4>

                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="dashboard.php" class="btn btn-success waves-effect waves-light">
                                            <i class="ri-check-line align-middle me-2"></i> Volver
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
                                            <label for="ruc" class="col-md-2 col-form-label">RUC</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="ruc" id="ruc" value="<?= $ruc ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="razon_social" class="col-md-2 col-form-label">Razon Social</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="razon_social" id="razon_social" value="<?= $razon_social ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="nombre_comercial" class="col-md-2 col-form-label">Nombre Comercial</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="nombre_comercial" id="nombre_comercial" value="<?= $nombre_comercial ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Icono</label>
                                            <div class="col-md-10">
                                                <div id="iconApp" class="dropzone"></div>
                                                <input type="hidden" name="icono_web" id="icono_web" value="<?= $icono_web ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Logo App</label>
                                            <div class="col-md-10">
                                                <div id="logoApp" class="dropzone"></div>
                                                <input type="hidden" name="logo_app" id="logo_app" value="<?= $logo_app ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Logo App Movil</label>
                                            <div class="col-md-10">
                                                <div id="logoAppMov" class="dropzone"></div>
                                                <input type="hidden" name="logo_movil" id="logo_movil" value="<?= $logo_movil ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Logo Fact/Boletas</label>
                                            <div class="col-md-10">
                                                <div id="logoDocument" class="dropzone"></div>
                                                <input type="hidden" name="logo_documentos" id="logo_documentos" value="<?= $logo_documentos ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Imagen Fondo Index</label>
                                            <div class="col-md-10">
                                                <div id="imgFondo" class="dropzone"></div>
                                                <input type="hidden" name="imagen_fondo" id="imagen_fondo" value="<?= $imagen_fondo ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="direccion" class="col-md-2 col-form-label">Direccion</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="direccion" id="direccion" value="<?= $direccion ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Departamento</label>
                                            <div class="col-md-10">
                                                <select class="form-select" name="Departamento" id="Departamento">
                                                    <?php
                                                    if ($Departamento == '') {
                                                        echo "<option value='0'>Seleccionar Departamento</option>";
                                                        $sqlDepart          = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
                                                        while ($fdepa       = mysqli_fetch_array($sqlDepart)) {
                                                            $xidDepart      = $fdepa['id'];
                                                            $xDepartamento  = $fdepa['name'];
                                                            echo "<option value='$xidDepart'>$xDepartamento</option>";
                                                        }
                                                    } else {
                                                        $sqlDepart          = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos WHERE id='$Departamento'");
                                                        while ($fdepa       = mysqli_fetch_array($sqlDepart)) {
                                                            $xidDepart      = $fdepa['id'];
                                                            $xDepartamento  = $fdepa['name'];
                                                            echo "<option value='$xidDepart'>$xDepartamento</option>";
                                                        }
                                                        $sqlDepart          = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos WHERE id!='$Departamento'");
                                                        while ($fdepa       = mysqli_fetch_array($sqlDepart)) {
                                                            $xidDepart      = $fdepa['id'];
                                                            $xDepartamento  = $fdepa['name'];
                                                            echo "<option value='$xidDepart'>$xDepartamento</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Provincia</label>
                                            <div class="col-md-10">
                                                <select class="form-select" name="Provincia" id="Provincia">
                                                    <?php
                                                    if ($Provincia == '') {
                                                        echo "<option value='0'>Seleccionar Provincia</option>";
                                                        $sqlProvin          = mysqli_query($conexion, "SELECT * FROM ubigeo_provincias");
                                                        while ($fprov       = mysqli_fetch_array($sqlProvin)) {
                                                            $xidProvincia   = $fprov['id'];
                                                            $xProvincia     = $fprov['name'];
                                                            echo "<option value='$xidProvincia'>$xProvincia</option>";
                                                        }
                                                    } else {
                                                        $sqlProvin          = mysqli_query($conexion, "SELECT * FROM ubigeo_provincias WHERE id='$Provincia' AND department_id='$Departamento'");
                                                        while ($fprov       = mysqli_fetch_array($sqlProvin)) {
                                                            $xidProvincia   = $fprov['id'];
                                                            $xProvincia     = $fprov['name'];
                                                            echo "<option value='$xidProvincia'>$xProvincia</option>";
                                                        }
                                                        $sqlProvin          = mysqli_query($conexion, "SELECT * FROM ubigeo_provincias WHERE id!='$Provincia' AND department_id='$Departamento'");
                                                        while ($fprov       = mysqli_fetch_array($sqlProvin)) {
                                                            $xidProvincia   = $fprov['id'];
                                                            $xProvincia     = $fprov['name'];
                                                            echo "<option value='$xidProvincia'>$xProvincia</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Distrito</label>
                                            <div class="col-md-10">
                                                <select class="form-select" name="Distrito" id="Distrito">
                                                    <?php
                                                    if ($Distrito == '') {
                                                        echo "<option value='0'>Seleccionar Distrito</option>";
                                                        $sqlDistri          = mysqli_query($conexion, "SELECT * FROM ubigeo_distritos WHERE id='$Distrito'");
                                                        while ($fdist       = mysqli_fetch_array($sqlDistri)) {
                                                            $xidDistrito    = $fdist['id'];
                                                            $xDistrito      = $fdist['name'];
                                                            echo "<option value='$xidDistrito'>$xDistrito</option>";
                                                        }
                                                    } else {
                                                        $sqlDistri          = mysqli_query($conexion, "SELECT * FROM ubigeo_distritos WHERE id='$Distrito' AND province_id='$Provincia'");
                                                        while ($fdist       = mysqli_fetch_array($sqlDistri)) {
                                                            $xidDistrito    = $fdist['id'];
                                                            $xDistrito      = $fdist['name'];
                                                            echo "<option value='$xidDistrito'>$xDistrito</option>";
                                                        }
                                                        $sqlDistri          = mysqli_query($conexion, "SELECT * FROM ubigeo_distritos WHERE id!='$Distrito' AND province_id='$Provincia'");
                                                        while ($fdist       = mysqli_fetch_array($sqlDistri)) {
                                                            $xidDistrito    = $fdist['id'];
                                                            $xDistrito      = $fdist['name'];
                                                            echo "<option value='$xidDistrito'>$xDistrito</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="codigoUbigeo" class="col-md-2 col-form-label">Ubigeo</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="codigoUbigeo" id="codigoUbigeo" value="<?= $codigoUbigeo ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="codigoUbigeo" class="col-md-2 col-form-label">Codigo Local</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="codigoLocal" id="codigoLocal" value="<?= $codigoLocal ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="telefono" class="col-md-2 col-form-label">Telefono</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="telefono" id="telefono" value="<?= $telefono ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="movil" class="col-md-2 col-form-label">Movil</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="movil" id="movil" value="<?= $movil ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="email" class="col-md-2 col-form-label">Email</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="email" id="email" value="<?= $email ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-form-label">Tipo</label>
                                            <div class="col-md-10">
                                                <input <?php if ($tipo == '1') {
                                                            echo 'checked=\"checked\"';
                                                        } ?> type="radio" name="tipo" value="1"> Producción
                                                <input <?php if ($tipo == '3') {
                                                            echo 'checked=\"checked\"';
                                                        } ?> type="radio" name="tipo" value="3"> Beta
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="usuario_sol" class="col-md-2 col-form-label">Usuario Sol</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="usuario_sol" id="usuario_sol" value="<?= $usuario_sol ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="clave_sol" class="col-md-2 col-form-label">Clave Sol</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave_sol" id="clave_sol" value="<?= $clave_sol ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Certificado PFX</label>
                                            <div class="col-md-10">
                                                <div id="pfxCertificado" class="dropzone"></div>
                                                <input type="hidden" name="certificado" id="certificado" value="<?= $certificado ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="clave_certificado" class="col-md-2 col-form-label">Clave Certificado</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave_certificado" id="clave_certificado" value="<?= $clave_certificado ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="clave_certificado" class="col-md-2 col-form-label">Ruta Api</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="ruta_api" id="ruta_api" value="<?= $ruta_api ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="clave_borrar" class="col-md-2 col-form-label">Clave Borrar</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password" name="clave_borrar" id="clave_borrar" value="<?= $clave_borrar ?>">
                                            </div>
                                        </div>
                                        <?php
                                        if ($accesoEdit == 'SI') {
                                        ?>
                                            <div class="mb-3 row">
                                                <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                                        <i class="ri-check-line align-middle me-2"></i> GUARDAR CAMBIOS
                                                    </button>
                                                    <input type="hidden" name="id_empresa" id="id_empresa" value="<?= $id_empresa ?>">
                                                    <input type="hidden" name="proceso" id="proceso">
                                                    <input type="hidden" name="modulo" id="modulo">
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
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
            /************************************************************/
            /************************************************************/
            $("#Departamento").change(function() {
                var datosEnviar = {
                    'id': $(this).val(),
                    'proceso': 'Provincia'
                }
                $.ajax({
                    data: datosEnviar,
                    url: 'config/procesos-fact.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(datos) {
                        $("#Provincia").html(datos.resultado);
                    }
                })
            })
            $("#Provincia").change(function() {
                var datosEnviar = {
                    'id': $(this).val(),
                    'proceso': 'Distrito'
                }
                $.ajax({
                    data: datosEnviar,
                    url: 'config/procesos-fact.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(datos) {
                        $("#Distrito").html(datos.resultado);
                    }
                })
            })
            /************************************************************/
            /************************************************************/
            $("#benviar").click(function() {
                $("#proceso").val('ActualizarEmpresa');
                $("#modulo").val('Empresa');
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
                            alert("Los datos de la empresa se actualizaron con exito.");
                            location.reload();
                        }
                    }
                })
            })
        })
        /**************************************************/
        /********  Dropzone Subir Icono Empresa    ********/
        /**************************************************/
        var iconApp = new Dropzone("#iconApp", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: ".ico",
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
            dictDefaultMessage: "Arrastra el icono con extension ico aquí"
        });
        iconApp.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("icono_web").value = nompfx;
        });
        iconApp.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        iconApp.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "logoApp");
        });
        iconApp.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        <?php
        $sqlImagen                  = mysqli_query($conexion, "SELECT icono_web FROM empresa WHERE id_empresa='$id_empresa'");
        $numImg                     = mysqli_num_rows($sqlImagen);
        if ($numImg > 0 and $icono_web != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                    $imagen         = $fimg['icono_web'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("assets/images/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'assets/images/" . $obj["name"] . "',
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
                iconApp.emit("addedfile", mockFile);
                iconApp.emit("thumbnail", mockFile, img.url);
                iconApp.emit("complete", mockFile);
                var existingFileCount = 1;
                iconApp.options.maxFiles = iconApp.options.maxFiles - existingFileCount;
                iconApp.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
        /**************************************************/
        /********  Dropzone Subir Logo Empresa     ********/
        /**************************************************/
        var logoApp = new Dropzone("#logoApp", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*,application/pdf,.xlsx,.csv,.mp4,.pfx",
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
            dictDefaultMessage: "Arrastra el logo PNG 215x80px. aquí"
        });
        logoApp.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("logo_app").value = nompfx;
        });
        logoApp.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        logoApp.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "logoApp");
        });
        logoApp.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        <?php
        $sqlImagen                  = mysqli_query($conexion, "SELECT logo_app FROM empresa WHERE id_empresa='$id_empresa'");
        $numImg                     = mysqli_num_rows($sqlImagen);
        if ($numImg > 0 and $logo_app != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                    $imagen         = $fimg['logo_app'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("assets/images/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'assets/images/" . $obj["name"] . "',
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
                logoApp.emit("addedfile", mockFile);
                logoApp.emit("thumbnail", mockFile, img.url);
                logoApp.emit("complete", mockFile);
                var existingFileCount = 1;
                logoApp.options.maxFiles = logoApp.options.maxFiles - existingFileCount;
                logoApp.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
        /**************************************************/
        /********  Dropzone Subir Logo Movil       ********/
        /**************************************************/
        var logoAppMov = new Dropzone("#logoAppMov", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*",
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
            dictDefaultMessage: "Arrastra el logo PNG, JPG 110x55px. aquí"
        });
        logoAppMov.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("logo_movil").value = nompfx;
        });
        logoAppMov.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        logoAppMov.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "logoApp");
        });
        logoAppMov.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        <?php
        $sqlImagen                  = mysqli_query($conexion, "SELECT logo_movil FROM empresa WHERE id_empresa='$id_empresa'");
        $numImg                     = mysqli_num_rows($sqlImagen);
        if ($numImg > 0 and $logo_movil != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                    $imagen         = $fimg['logo_movil'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("assets/images/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'assets/images/" . $obj["name"] . "',
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
                logoAppMov.emit("addedfile", mockFile);
                logoAppMov.emit("thumbnail", mockFile, img.url);
                logoAppMov.emit("complete", mockFile);
                var existingFileCount = 1;
                logoAppMov.options.maxFiles = logoAppMov.options.maxFiles - existingFileCount;
                logoAppMov.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
        /**************************************************/
        /****  Dropzone Subir Logo Facturas/Boletas  ******/
        /**************************************************/
        var logoDocument = new Dropzone("#logoDocument", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*",
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
            dictDefaultMessage: "Arrastra el logo PNG 215x80px. aquí"
        });
        logoDocument.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("logo_documentos").value = nompfx;
        });
        logoDocument.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        logoDocument.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "logoDocument");
        });
        logoDocument.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        <?php
        $sqlImagen                  = mysqli_query($conexion, "SELECT logo_documentos FROM empresa WHERE id_empresa='$id_empresa'");
        $numImg                     = mysqli_num_rows($sqlImagen);
        if ($numImg > 0 and $logo_documentos != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                    $imagen         = $fimg['logo_documentos'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("ventas/imagenes/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'ventas/imagenes/" . $obj["name"] . "',
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
                logoDocument.emit("addedfile", mockFile);
                logoDocument.emit("thumbnail", mockFile, img.url);
                logoDocument.emit("complete", mockFile);
                var existingFileCount = 1;
                logoDocument.options.maxFiles = logoDocument.options.maxFiles - existingFileCount;
                logoDocument.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
        /**************************************************/
        /****   Dropzone Subir Imagen Fondo Index    ******/
        /**************************************************/
        var imgFondo = new Dropzone("#imgFondo", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*",
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
            dictDefaultMessage: "Arrastra el logo JPG 1900x900px. aquí"
        });
        imgFondo.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("imagen_fondo").value = nompfx;
        });
        imgFondo.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        imgFondo.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "logoApp");
        });
        imgFondo.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR IMAGENES *************************/
        /**********************************************************************/
        <?php
        $sqlImagen                  = mysqli_query($conexion, "SELECT imagen_fondo FROM empresa WHERE id_empresa='$id_empresa'");
        $numImg                     = mysqli_num_rows($sqlImagen);
        if ($numImg > 0 and $imagen_fondo != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlImagen)) {
                    $imagen         = $fimg['imagen_fondo'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("assets/images/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'assets/images/" . $obj["name"] . "',
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
                imgFondo.emit("addedfile", mockFile);
                imgFondo.emit("thumbnail", mockFile, img.url);
                imgFondo.emit("complete", mockFile);
                var existingFileCount = 1;
                imgFondo.options.maxFiles = imgFondo.options.maxFiles - existingFileCount;
                imgFondo.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
        /**************************************************/
        /********  Dropzone Subir Certificado PFX  ********/
        /**************************************************/
        var pfxCertificado = new Dropzone("#pfxCertificado", {
            url: "config/subirArchivos.php",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            acceptedFiles: "image/*,application/pdf,.xlsx,.csv,.mp4,.pfx",
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
            dictDefaultMessage: "Arrastra el Certificado PFX aquí"
        });
        pfxCertificado.on("addedfile", function(file) {
            console.log(file.name);
            var nompfx = file.name;
            document.getElementById("certificado").value = nompfx;
        });
        pfxCertificado.on("removedfile", function(file) {
            console.log(file.name);
        });
        //Agregue más datos para enviar junto con el archivo como datos POST. (Opcional)
        pfxCertificado.on("sending", function(file, xhr, formData) {
            formData.append("proceso", "pfxCertificado");
        });
        pfxCertificado.on("error", function(file, response) {
            console.log(response);
        });
        /**********************************************************************/
        /********************* RUTINA CARGAR CERTIFICADO  *********************/
        /**********************************************************************/
        <?php
        $sqlCertificado         = mysqli_query($conexion, "SELECT certificado FROM empresa WHERE id_empresa='$id_empresa'");
        $numCerti               = mysqli_num_rows($sqlCertificado);
        if ($numCerti > 0 and $certificado != '') {
        ?>
            var images = [
                <?php
                while ($fimg        = mysqli_fetch_array($sqlCertificado)) {
                    $imagen         = $fimg['certificado'];
                    $obj["name"]    = $imagen;
                    $obj["size"]    = filesize("api/archivos_xml_sunat/certificados/beta/" . $imagen);
                    echo "
                    {
                    name: '" . $obj["name"] . "',
                    url: 'api/archivos_xml_sunat/certificados/beta" . $obj["name"] . "',
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
                pfxCertificado.emit("addedfile", mockFile);
                pfxCertificado.emit("thumbnail", mockFile, img.url);
                pfxCertificado.emit("complete", mockFile);
                var existingFileCount = 1;
                pfxCertificado.options.maxFiles = pfxCertificado.options.maxFiles - existingFileCount;
                pfxCertificado.options.createImageThumbnails = true;
            }
        <?php
        }
        ?>
    </script>
</body>

</html>