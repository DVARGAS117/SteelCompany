<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_cliente        = $_REQUEST['cod_cliente'];
$sqlConuslta        = mysqli_query($conexion, "SELECT * FROM clientes WHERE cod_cliente='$cod_cliente'");
$fcons              = mysqli_fetch_array($sqlConuslta);
$cod_cliente        = $fcons['cod_cliente'];
$cod_puntoventa     = $fcons['cod_puntoventa'];
$nombres            = $fcons['nombres'];
$nombre_comercial   = $fcons['nombre_comercial'];
$id_giro_negocio    = $fcons['id_giro_negocio'];
$website            = $fcons['website'];
$Departamento       = $fcons['IdDepartamento'];
$Provincia          = $fcons['IdProvincia'];
$Distrito           = $fcons['IdDistrito'];
$id_tipo_direccion  = $fcons['id_tipo_direccion'];
$direccion          = $fcons['direccion'];
$referencia         = $fcons['referencia'];
$id_tipo_contacto   = $fcons['id_tipo_contacto'];
$persona_contacto   = $fcons['persona_contacto'];
$id_tipo_telefonia  = $fcons['id_tipo_telefonia'];
$numero_telefono    = $fcons['numero_telefono'];
$cod_tipodoc        = $fcons['cod_tipodoc'];
$num_documento      = $fcons['num_documento'];
$email              = $fcons['email'];
$estado             = $fcons['estado'];
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
                                    <?php
                                    if ($cod_puntoventa == '' or $cod_puntoventa == '') {
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE estado='A'");
                                        echo "<option value='0'>Seleccionar Punto de Venta</option>";
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa        = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa      = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    } else {
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa        = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa      = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                        $sqlPuntoVenta = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa!='$cod_puntoventa'");
                                        while ($pventa = mysqli_fetch_array($sqlPuntoVenta)) {
                                            $xcod_puntoventa        = $pventa['cod_puntoventa'];
                                            $nombre_puntoventa      = $pventa['nombre_puntoventa'];
                                            echo "<option value='$xcod_puntoventa'>$nombre_puntoventa</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Documento</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_tipodoc" id="cod_tipodoc">
                                    <?php
                                    if ($cod_tipodoc == '' or $cod_tipodoc == '') {
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad");
                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc       = $tdoc['cod_tipodoc'];
                                            $descripcion        = $tdoc['descripcion'];
                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                        }
                                    } else {
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc='$cod_tipodoc'");
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc       = $tdoc['cod_tipodoc'];
                                            $descripcion        = $tdoc['descripcion'];
                                            echo "<option value='$xcod_tipodoc'>$descripcion</option>";
                                        }
                                        $sqlTipoDoc = mysqli_query($conexion, "SELECT * FROM tipos_documentos_identidad WHERE cod_tipodoc!='$cod_tipodoc'");
                                        while ($tdoc = mysqli_fetch_array($sqlTipoDoc)) {
                                            $xcod_tipodoc       = $tdoc['cod_tipodoc'];
                                            $descripcion        = $tdoc['descripcion'];
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
                                <input class="form-control" type="text" name="num_documento" id="num_documento" value="<?= $num_documento; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Razon Social</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombres" id="nombres" value="<?= $nombres; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre Comercial</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombre_comercial" id="nombre_comercial" value="<?= $nombre_comercial; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Giro de Negocio</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_giro_negocio" id="id_giro_negocio">
                                    <?php
                                    if ($id_giro_negocio == '' or $id_giro_negocio == '') {
                                        $sqlTipoGiro            = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios");
                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                        while ($tgiro           = mysqli_fetch_array($sqlTipoGiro)) {
                                            $xid_giro_negocio   = $tgiro['id_giro_negocio'];
                                            $nombre_giro        = $tgiro['nombre_giro'];
                                            echo "<option value='$xid_giro_negocio'>$nombre_giro</option>";
                                        }
                                    } else {
                                        $sqlTipoGiro            = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios WHERE id_giro_negocio='$id_giro_negocio'");
                                        while ($tgiro           = mysqli_fetch_array($sqlTipoGiro)) {
                                            $xid_giro_negocio   = $tgiro['id_giro_negocio'];
                                            $nombre_giro        = $tgiro['nombre_giro'];
                                            echo "<option value='$xid_giro_negocio'>$nombre_giro</option>";
                                        }
                                        $sqlTipoGiro            = mysqli_query($conexion, "SELECT * FROM tipo_giro_negocios WHERE id_giro_negocio!='$id_giro_negocio'");
                                        while ($tgiro           = mysqli_fetch_array($sqlTipoGiro)) {
                                            $xid_giro_negocio   = $tgiro['id_giro_negocio'];
                                            $nombre_giro        = $tgiro['nombre_giro'];
                                            echo "<option value='$xid_giro_negocio'>$nombre_giro</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Web Site</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="website" id="website" value="<?= $website; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Direccion</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_direccion" id="id_tipo_direccion">
                                    <?php
                                    if ($id_tipo_direccion == 0 or $id_tipo_direccion == '') {
                                        $sqlTipoDire            = mysqli_query($conexion, "SELECT * FROM tipo_direccion");
                                        echo "<option value='0'>Seleccionar Tipo Documento</option>";
                                        while ($tdire           = mysqli_fetch_array($sqlTipoDire)) {
                                            $xid_tipo_direccion = $tdire['id_tipo_direccion'];
                                            $tipo_direccion     = $tdire['tipo_direccion'];
                                            echo "<option value='$xid_tipo_direccion'>$tipo_direccion</option>";
                                        }
                                    } else {
                                        $sqlTipoDire            = mysqli_query($conexion, "SELECT * FROM tipo_direccion WHERE id_tipo_direccion='$id_tipo_direccion'");
                                        while ($tdire           = mysqli_fetch_array($sqlTipoDire)) {
                                            $xid_tipo_direccion = $tdire['id_tipo_direccion'];
                                            $tipo_direccion     = $tdire['tipo_direccion'];
                                            echo "<option value='$xid_tipo_direccion'>$tipo_direccion</option>";
                                        }
                                        $sqlTipoDire            = mysqli_query($conexion, "SELECT * FROM tipo_direccion WHERE id_tipo_direccion!='$id_tipo_direccion'");
                                        while ($tdire           = mysqli_fetch_array($sqlTipoDire)) {
                                            $xid_tipo_direccion = $tdire['id_tipo_direccion'];
                                            $tipo_direccion     = $tdire['tipo_direccion'];
                                            echo "<option value='$xid_tipo_direccion'>$tipo_direccion</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="direccion" id="direccion" value="<?= $direccion; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Referencia</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="referencia" id="referencia" value="<?= $referencia; ?>">
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
                            <label class="col-md-2 col-form-label">Tipo de Contacto</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_contacto" id="id_tipo_contacto">
                                    <?php
                                    if ($id_tipo_contacto == '' or $id_tipo_contacto == 0) {
                                        $sqlTipoCont            = mysqli_query($conexion, "SELECT * FROM tipo_contactos");
                                        echo "<option value='0'>Seleccionar Tipo Contato</option>";
                                        while ($tcont           = mysqli_fetch_array($sqlTipoCont)) {
                                            $xid_tipo_contacto  = $tcont['id_tipo_contacto'];
                                            $tipo_contacto      = $tcont['tipo_contacto'];
                                            echo "<option value='$xid_tipo_contacto'>$tipo_contacto</option>";
                                        }
                                    } else {
                                        $sqlTipoCont            = mysqli_query($conexion, "SELECT * FROM tipo_contactos WHERE id_tipo_contacto='$id_tipo_contacto'");
                                        while ($tcont           = mysqli_fetch_array($sqlTipoCont)) {
                                            $xid_tipo_contacto  = $tcont['id_tipo_contacto'];
                                            $tipo_contacto      = $tcont['tipo_contacto'];
                                            echo "<option value='$xid_tipo_contacto'>$tipo_contacto</option>";
                                        }
                                        $sqlTipoCont            = mysqli_query($conexion, "SELECT * FROM tipo_contactos WHERE id_tipo_contacto!='$id_tipo_contacto'");
                                        while ($tcont           = mysqli_fetch_array($sqlTipoCont)) {
                                            $xid_tipo_contacto  = $tcont['id_tipo_contacto'];
                                            $tipo_contacto      = $tcont['tipo_contacto'];
                                            echo "<option value='$xid_tipo_contacto'>$tipo_contacto</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre del Contacto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="persona_contacto" id="persona_contacto" value="<?= $persona_contacto; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Telefonia</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_telefonia" id="id_tipo_telefonia">
                                    <?php
                                    if ($id_tipo_telefonia == '' or $id_tipo_telefonia == 0) {
                                        $sqlTipoTelf            = mysqli_query($conexion, "SELECT * FROM tipo_telefonia");
                                        echo "<option value='0'>Seleccionar Tipo Telefonia</option>";
                                        while ($ttelf           = mysqli_fetch_array($sqlTipoTelf)) {
                                            $xid_tipo_telefonia = $ttelf['id_tipo_telefonia'];
                                            $tipo_telefonia     = $ttelf['tipo_telefonia'];
                                            echo "<option value='$xid_tipo_telefonia'>$tipo_telefonia</option>";
                                        }
                                    } else {
                                        $sqlTipoTelf            = mysqli_query($conexion, "SELECT * FROM tipo_telefonia WHERE id_tipo_telefonia='$id_tipo_telefonia'");
                                        while ($ttelf           = mysqli_fetch_array($sqlTipoTelf)) {
                                            $xid_tipo_telefonia = $ttelf['id_tipo_telefonia'];
                                            $tipo_telefonia     = $ttelf['tipo_telefonia'];
                                            echo "<option value='$xid_tipo_telefonia'>$tipo_telefonia</option>";
                                        }
                                        $sqlTipoTelf            = mysqli_query($conexion, "SELECT * FROM tipo_telefonia WHERE id_tipo_telefonia!='$id_tipo_telefonia'");
                                        while ($ttelf           = mysqli_fetch_array($sqlTipoTelf)) {
                                            $xid_tipo_telefonia = $ttelf['id_tipo_telefonia'];
                                            $tipo_telefonia     = $ttelf['tipo_telefonia'];
                                            echo "<option value='$xid_tipo_telefonia'>$tipo_telefonia</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Numero Telefono</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="numero_telefono" id="numero_telefono" value="<?= $numero_telefono; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" value="<?= $email; ?>">
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
                                    <i class="mdi mdi-content-save align-middle me-2"></i> ACTUALIZAR CLIENTE
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_cliente" value="<?= $cod_cliente ?>">
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
                $("#proceso").val('ActualizarClientes');
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
                            alert("El cliente se actualizo con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos pero en cliente ya existe.");
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>