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
                            <label class="col-md-2 col-form-label">Categoria</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_categoria" id="cod_categoria">
                                    <option value="0">Seleccionar Categoria</option>
                                    <?php
                                    $sqlCategorias = mysqli_query($conexion, "SELECT * FROM categoria_productos WHERE estado='A'");
                                    while ($fcats = mysqli_fetch_array($sqlCategorias)) {
                                        $cod_categoria     = $fcats['cod_categoria'];
                                        $categoria  = $fcats['categoria'];
                                        echo "<option value='$cod_categoria'>$categoria</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Marca</label>
                            <div class="col-md-10">
                                <select class="form-select" name="cod_marca" id="cod_marca">
                                    <option value="0">Seleccionar Marca</option>
                                    <?php
                                    $sqlMarcas      = mysqli_query($conexion, "SELECT * FROM marcas WHERE estado='A'");
                                    while ($fmarc   = mysqli_fetch_array($sqlMarcas)) {
                                        $cod_marca  = $fmarc['cod_marca'];
                                        $marca      = $fmarc['marca'];
                                        echo "<option value='$cod_marca'>$marca</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Codigo Producto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="codigo" id="codigo">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre Producto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nombre_producto" id="nombre_producto">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Unidad Medida</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="unidad_medida" id="unidad_medida">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Stock Actual</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="stock_actual" id="stock_actual">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Stock Minimo</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="stock_minimo" id="stock_minimo">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Precio Unitario</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="precio_unitario" id="precio_unitario">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Precio Cuarto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="precio_cuarto" id="precio_cuarto">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Precio Mayor</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="precio_mayor" id="precio_mayor">
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
                                    <i class="mdi mdi-content-save align-middle me-2"></i> REGISTRAR PRODUCTO
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
            $("#benviar").click(function() {
                if ($("#cod_categoria").val() == 0) {
                    alert("Falta seleccionar la categoria");
                    $("#cod_categoria").focus();
                    return false;
                }
                if ($("#cod_marca").val() == 0) {
                    alert("Falta seleccionar la marca");
                    $("#cod_marca").focus();
                    return false;
                }
                if ($("#codigo").val() == '') {
                    alert("Falta ingresar codigo producto");
                    $("#codigo").focus();
                    return false;
                }
                if ($("#nombre_producto").val() == '') {
                    alert("Falta ingresar nombre producto");
                    $("#nombre_producto").focus();
                    return false;
                }
                if ($("#stock_actual").val() == '') {
                    alert("Falta ingresar stock actual");
                    $("#stock_actual").focus();
                    return false;
                }
                if ($("#precio_unitario").val() == '') {
                    alert("Falta ingresar precio unitario");
                    $("#precio_unitario").focus();
                    return false;
                }
                if ($("#precio_cuarto").val() == '') {
                    alert("Falta ingresar precio cuarto");
                    $("#precio_cuarto").focus();
                    return false;
                }
                if ($("#precio_mayor").val() == '') {
                    alert("Falta ingresar precio mayor");
                    $("#precio_mayor").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('RegistrarProducto');
                $("#modulo").val('Producto');
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
                            alert("El producto se registro con exito.");
                            location.reload();
                        } else {
                            alert("Lo sentimos pero el producto ya existe.");
                        }
                    }
                })
            })
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>