<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_personal       = $_REQUEST['cod_personal'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM personal WHERE cod_personal='$cod_personal'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$cod_personal       = $fcons['cod_personal'];
$cod_puntoventa     = $fcons['cod_puntoventa'];
$nombres            = $fcons['nombres'];
$cod_tipodoc        = $fcons['cod_tipodoc'];
$num_documento      = $fcons['num_documento'];
$email              = $fcons['email'];
$movil              = $fcons['movil'];
$cargo              = $fcons['cargo'];
$area_trabajo       = $fcons['area_trabajo'];
$fecha_ingreso      = $fcons['fecha_ingreso'];
$imagen             = $fcons['imagen'];
$accesos            = $fcons['accesos'];
$estado             = $fcons['estado'];
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
                            <label class="col-md-2 col-form-label">Punto de Venta</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_puntoventa" id="cod_puntoventa">
                                    <?php
                                    if ($cod_puntoventa == 0 or $cod_puntoventa == '') {
                                        echo "<option value='0'>Seleccionar Punto de Venta</option>";
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    } else {
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                        /*****/
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa!='$cod_puntoventa'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa    = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombres</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombres" id="nombres" value="<?= $nombres ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Documento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_tipodoc" id="cod_tipodoc">
                                    <?php
                                    if ($cod_tipodoc == 0 or $cod_tipodoc == '') {
                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad");
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc   = $tdoc['cod_tipodoc'];
                                            $descripcion    = $tdoc['descripcion'];
                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                        }
                                    } else {
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc='$cod_tipodoc'");
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc   = $tdoc['cod_tipodoc'];
                                            $descripcion    = $tdoc['descripcion'];
                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                        }
                                        /*******/
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc!='$cod_tipodoc'");
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc   = $tdoc['cod_tipodoc'];
                                            $descripcion    = $tdoc['descripcion'];
                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Documento</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="num_documento" id="num_documento" value="<?= $num_documento ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" value="<?= $email ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Movil</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="movil" id="movil" value="<?= $movil ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Cargo</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cargo" id="cargo">
                                    <?php
                                    if ($cargo == '') {
                                        echo "<option value='0'>Seleccionar Cargo</option>";
                                        $sqlCargos = mysqli_query($conexion, "SELECT * FROM cargos_personal WHERE estado='A'");
                                        while ($fcarg = mysqli_fetch_array($sqlCargos)) {
                                            $xcargo    = $fcarg['cargo'];
                                            echo "<option value='$xcargo'>$xcargo</option>";
                                        }
                                    } else {
                                        $sqlCargos = mysqli_query($conexion, "SELECT * FROM cargos_personal WHERE cargo='$cargo'");
                                        while ($fcarg = mysqli_fetch_array($sqlCargos)) {
                                            $xcargo    = $fcarg['cargo'];
                                            echo "<option value='$xcargo'>$xcargo</option>";
                                        }
                                        /*******/
                                        $sqlCargos = mysqli_query($conexion, "SELECT * FROM cargos_personal WHERE cargo!='$cargo'");
                                        while ($fcarg = mysqli_fetch_array($sqlCargos)) {
                                            $xcargo    = $fcarg['cargo'];
                                            echo "<option value='$xcargo'>$xcargo</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Area Trabajo</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="area_trabajo" id="area_trabajo" value="<?= $area_trabajo ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Fecha Ingreso</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="fecha_ingreso" id="fecha_ingreso" value="<?= $fecha_ingreso ?>">
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Usuario</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="usuario" id="usuario">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Clave/Contraseña</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password" name="clave" id="clave">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Accesos</label>
                            <div class="col-md-10">
                                <input <?php if ($accesos == 'SI') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="accesos" value="SI"> Si, Todos Los Módulos
                                <input <?php if ($accesos == 'NO') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="accesos" value="NO"> No, Solo Algunos Módulos
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Seleccionar Modulos</label>
                            <div class="col-md-10">
                                <select class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Seleccionar Modulos ..." name="modulos[]" id="modulos">
                                    <?php
                                    $sqlSubModulos = mysqli_query($conexion, "SELECT * FROM sub_modulos as s, accesos_usuarios as a WHERE s.cod_submodulo=a.cod_submodulo AND a.cod_personal='$cod_personal'");
                                    while ($fsmods = mysqli_fetch_array($sqlSubModulos)) {
                                        $cod_submodulo  = $fsmods['cod_submodulo'];
                                        $cod_modulo     = $fsmods['cod_modulo'];
                                        $sub_modulo     = $fsmods['sub_modulo'];
                                        /******************************************/
                                        $sqlModulos     = mysqli_query($conexion, "SELECT nombre_modulo FROM modulos WHERE cod_modulo='$cod_modulo'");
                                        $fmods          = mysqli_fetch_array($sqlModulos);
                                        $nombre_modulo  = $fmods['nombre_modulo'];
                                        /******************************************/
                                        echo "<option value='$cod_submodulo|$cod_modulo|$sub_modulo' selected>$nombre_modulo - $sub_modulo</option>";
                                    }
                                    $sqlSubModulos = mysqli_query($conexion, "SELECT * FROM sub_modulos WHERE estado='A' ORDER BY cod_modulo ASC");
                                    while ($fsmods = mysqli_fetch_array($sqlSubModulos)) {
                                        $cod_submodulo  = $fsmods['cod_submodulo'];
                                        $cod_modulo     = $fsmods['cod_modulo'];
                                        $sub_modulo     = $fsmods['sub_modulo'];
                                        /******************************************/
                                        $sqlModulos     = mysqli_query($conexion, "SELECT nombre_modulo FROM modulos WHERE cod_modulo='$cod_modulo'");
                                        $fmods          = mysqli_fetch_array($sqlModulos);
                                        $nombre_modulo  = $fmods['nombre_modulo'];
                                        /******************************************/
                                        echo "<option value='$cod_submodulo|$cod_modulo|$sub_modulo'>$nombre_modulo - $sub_modulo</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Estado</label>
                            <div class="col-md-10">
                                <input <?php if ($estado == 'A') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="estado" value="A"> Activo
                                <input <?php if ($estado == 'I') {
                                            echo 'checked=\"checked\"';
                                        } ?> type="radio" name="estado" value="I"> Inactivo
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ACTUALIZAR PERSONAL
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_personal" id="cod_personal" value="<?= $cod_personal ?>">
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
    <!-- plugins -->
    <script src="assets/libs/select2/js/select2.min.js"></script>

    <!-- init js -->
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- jquery dropzone -->
    <script src="assets/libs/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            $("input:radio[name=accesos]").click(function() {
                var Accesos = $('input:radio[name=accesos]:checked').val();
                if (Accesos == 'NO') {
                    $('#modulos option').removeAttr("selected")
                }
            });
            $("#benviar").click(function() {
                if ($("#cod_puntoventa").val() == 0) {
                    alert("Falta seleccionar el punto de venta");
                    $("#cod_puntoventa").focus();
                    return false;
                }
                if ($("#nombres").val() == '') {
                    alert("Falta ingresar nombres");
                    $("#nombres").focus();
                    return false;
                }
                if ($("#cod_tipodoc").val() == 0) {
                    alert("Falta seleccionar el tipo documento");
                    $("#cod_tipodoc").focus();
                    return false;
                }
                if ($("#num_documento").val() == '') {
                    alert("Falta ingresar numero de documento");
                    $("#num_documento").focus();
                    return false;
                }
                if ($("#email").val() == '') {
                    alert("Falta ingresar el email");
                    $("#email").focus();
                    return false;
                }
                if ($("#movil").val() == '') {
                    alert("Falta ingresar el movil");
                    $("#movil").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('ActualizarPersonal');
                $("#modulo").val('Personal');
                var datosEnviar = $("#fapps").serialize();
                $.ajax({
                    data: datosEnviar,
                    url: "config/proceso-guardar.php",
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#benviar").html("PROCESANDO...");
                        setTimeout(function() {
                            location.reload();
                        }, 5000)
                    },
                    success: function(data) {
                        var respuesta = data.respuesta;
                        if (respuesta == 'SI') {
                            alert("Los datos se actualizaron con exito.");
                            location.reload();
                        }
                    }
                })
            })
        })
        /**************************************************/
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