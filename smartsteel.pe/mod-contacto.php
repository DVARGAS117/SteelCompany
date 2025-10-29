<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$cod_contacto = $_REQUEST['cod_contacto'] ?? '';
$cod_contacto = intval($cod_contacto);
$query_1 = "SELECT * FROM clientes_contactos WHERE cod_contacto = ".$cod_contacto;
$sqlConsulta1 = mysqli_query($conexion, $query_1);
$rs_1 = mysqli_fetch_array($sqlConsulta1, MYSQLI_ASSOC);
$cod_cliente    = $rs_1['cod_cliente'] ?? '';
$cod_cliente = intval($cod_cliente);
$query_2 = "SELECT * FROM clientes WHERE cod_cliente = ".$cod_cliente;
$sqlConsulta2   = mysqli_query($conexion, $query_2);
$rs_2 = mysqli_fetch_array($sqlConsulta2, MYSQLI_ASSOC);
$nombreCliente = $rs_2['nombres'];
$id_tipo_contacto = $rs_1['id_tipo_contacto'];
$persona_contacto = $rs_1['persona_contacto'];
$id_tipo_telefonia = $rs_1['id_tipo_telefonia'];
$numero_telefono = $rs_1['numero_telefono'];
$email = $rs_1['email'];
$estado = $rs_1['estado'];
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

    <!-- New DataTables -->
    <link href="assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/js/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />   
</head>

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" name="fapps" id="fapps">
                        <div class="mb-3 row">
                            <?php echo '<h3>'.$nombreCliente.'</h3>'; ?>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Contacto</label>
                            <div class="col-md-10">
                                <select class="form-select" name="id_tipo_contacto" id="id_tipo_contacto">
                                    <option value="0">Seleccionar Tipo Contato</option>
                                    <?php
                                    if ($id_tipo_contacto == '' or $id_tipo_contacto == null or $id_tipo_contacto == 'null') {
                                        $sqlTipoCont = mysqli_query($conexion, "SELECT * FROM tipo_contactos");
                                        while ($row = mysqli_fetch_array($sqlTipoCont, MYSQLI_ASSOC)) {
                                            if ($id_tipo_contacto == $row['id_tipo_contacto']) {
                                                echo "<option value='".$row['id_tipo_contacto']."' selected>".$row['tipo_contacto']."</option>";
                                            } else {
                                                echo "<option value='".$row['id_tipo_contacto']."'>".$row['tipo_contacto']."</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre del Contacto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="persona_contacto" id="persona_contacto" maxlength="255" value="<?php echo $persona_contacto; ?>" onkeypress="return validarle(event);">
                            </div>
                        </div>
                        <!-- <div class="mb-3 row">
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
                                <input class="form-control" type="text" name="numero_telefono" id="numero_telefono" maxlength="9" onkeypress="return validarnu(event);">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" maxlength="30" onkeyup="javascript:validateMail('email','emailOK_1');">
                                <span id="emailOK_1"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Estado</label>
                            <div class="col-md-10">
                                <input type="radio" name="estado" value="A" checked> Activo
                                <input type="radio" name="estado" value="I"> Inactivo
                            </div>
                        </div> -->
                        <div class="mb-3 row">
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> REGISTRAR CONTACTO
                                </button>
                                <input type="hidden" name="proceso" id="proceso">
                                <input type="hidden" name="modulo" id="modulo">
                                <input type="hidden" name="cod_cliente" id="cod_cliente" value="<?= $cod_cliente ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- apexcharts js -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    
    <!-- New DataTables -->
    <script src="assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatables/dataTables.buttons.min.js"></script>

    <!-- jquery.vectormap map -->
    <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="assets/js/pages/dashboard.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/general.js"></script>

    <script>

    </script>
</body>

</html>