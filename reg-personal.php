<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
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
                                    <option value="0">Seleccionar Punto de Venta</option>
                                    <?php
                                    $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombres</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombres" id="nombres">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Documento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_tipodoc" id="cod_tipodoc">
                                    <option value="0">Seleccionar Tipo Documento</option>
                                    <?php
                                    $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad");
                                    while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                        $cod_tipodoc    = $tdoc['cod_tipodoc'];
                                        $descripcion    = $tdoc['descripcion'];
                                        echo "<option value='$cod_tipodoc'>$descripcion</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Documento</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="num_documento" id="num_documento">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Movil</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="movil" id="movil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Cargo</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cargo" id="cargo">
                                    <option value="0">Seleccionar Cargo</option>
                                    <?php
                                    $sqlCargos = mysqli_query($conexion, "SELECT * FROM cargos_personal WHERE estado='A'");
                                    while ($fcarg = mysqli_fetch_array($sqlCargos)) {
                                        $cargo    = $fcarg['cargo'];
                                        echo "<option value='$cargo'>$cargo</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Area Trabajo</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="area_trabajo" id="area_trabajo">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Fecha Ingreso</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="fecha_ingreso" id="fecha_ingreso">
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
                                <input class="form-control" type="text" name="imagen" id="imagen">
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
                                <input type="radio" name="accesos" value="SI" checked> Si, Todos Los Módulos
                                <input type="radio" name="accesos" value="NO"> No, Solo Algunos Módulos
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Seleccionar Modulos</label>
                            <div class="col-md-10">
                                <select class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Seleccionar Modulos ..." name="modulos[]" id="modulos">
                                    <?php
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
                                <input type="radio" name="estado" value="A" checked> Activo
                                <input type="radio" name="estado" value="I"> Inactivo
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> REGISTRAR PERSONAL
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
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
                $("#proceso").val('RegistrarPersonal');
                $("#modulo").val('Personal');
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
                            alert("El personal se registro con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos pero en nombre ya existe.");
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
    </script>
</body>

</html>