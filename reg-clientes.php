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
                            <label for="example-text-input" class="col-md-2 col-form-label">Razon Social</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombres" id="nombres">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre Comercial</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombre_comercial" id="nombre_comercial">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Giro de Negocio</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_giro_negocio" id="id_giro_negocio">
                                    <option value="0">Seleccionar Giro del Negocio</option>
                                    <?php
                                    $sqlTipoGiro            = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios");
                                    while ($tgiro           = mysqli_fetch_array($sqlTipoGiro)) {
                                        $id_giro_negocio    = $tgiro['id_giro_negocio'];
                                        $nombre_giro        = $tgiro['nombre_giro'];
                                        echo "<option value='$id_giro_negocio'>$nombre_giro</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Web Site</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="website" id="website">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Dirección</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_direccion" id="id_tipo_direccion">
                                    <option value="0">Seleccionar Tipo de Dirección</option>
                                    <?php
                                    $sqlTipoDire            = mysqli_query($conexion, "SELECT * FROM tipo_direccion");
                                    while ($tdire           = mysqli_fetch_array($sqlTipoDire)) {
                                        $id_tipo_direccion  = $tdire['id_tipo_direccion'];
                                        $tipo_direccion     = $tdire['tipo_direccion'];
                                        echo "<option value='$id_tipo_direccion'>$tipo_direccion</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="direccion" id="direccion">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Referencia</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="referencia" id="referencia">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Departamento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="Departamento" id="Departamento">
                                    <?php
                                    echo "<option value='0'>Seleccionar Departamento</option>";
                                    $sqlDepart          = mysqli_query($conexion, "SELECT * FROM ubigeo_departamentos");
                                    while ($fdepa       = mysqli_fetch_array($sqlDepart)) {
                                        $xidDepart      = $fdepa['id'];
                                        $xDepartamento  = $fdepa['name'];
                                        echo "<option value='$xidDepart'>$xDepartamento</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Provincia</label>
                            <div class="col-md-10">
                                <select class="form-select" name="Provincia" id="Provincia">
                                    <option value='0'>Seleccionar Provincia</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Distrito</label>
                            <div class="col-md-10">
                                <select class="form-select" name="Distrito" id="Distrito">
                                    <option value='0'>Seleccionar Distrito</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Contacto</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_contacto" id="id_tipo_contacto">
                                    <option value="0">Seleccionar Tipo Contato</option>
                                    <?php
                                    $sqlTipoCont            = mysqli_query($conexion, "SELECT * FROM tipo_contactos");
                                    while ($tcont           = mysqli_fetch_array($sqlTipoCont)) {
                                        $id_tipo_contacto   = $tcont['id_tipo_contacto'];
                                        $tipo_contacto      = $tcont['tipo_contacto'];
                                        echo "<option value='$id_tipo_contacto'>$tipo_contacto</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre del Contacto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="persona_contacto" id="persona_contacto">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Telefonía</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_telefonia" id="id_tipo_telefonia">
                                    <option value="0">Seleccionar Tipo de Telefonía</option>
                                    <?php
                                    $sqlTipoTelf            = mysqli_query($conexion, "SELECT * FROM tipo_telefonia");
                                    while ($ttelf           = mysqli_fetch_array($sqlTipoTelf)) {
                                        $id_tipo_telefonia  = $ttelf['id_tipo_telefonia'];
                                        $tipo_telefonia     = $ttelf['tipo_telefonia'];
                                        echo "<option value='$id_tipo_telefonia'>$tipo_telefonia</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Telefono</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="numero_telefono" id="numero_telefono">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email">
                            </div>
                        </div> -->
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
                                    <i class="mdi mdi-content-save align-middle me-2"></i> REGISTRAR CLIENTE
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
    <script src="assets/js/app.js"></script>

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
                if ($("#direccion").val() == '') {
                    alert("Falta ingresar direccion");
                    $("#direccion").focus();
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
                /*******************************************/
                /*******************************************/
                $("#proceso").val('RegistrarClientes');
                $("#modulo").val('Clientes');
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
                            alert("El cliente se registro con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos pero en cliente ya existe.");
                        }
                    }
                });
            })
        })
    </script>
</body>

</html>