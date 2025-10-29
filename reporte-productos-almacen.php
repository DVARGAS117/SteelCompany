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

</head>

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" name="fapps" id="fapps" method="POST">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tipo de Reporte</label>
                            <div class="col-md-10">
                                <input type="radio" name="tipo_reporte" value="Todos"> Todos
                                <input type="radio" name="tipo_reporte" value="Categoria"> Por Categoria
                            </div>
                        </div>
                        <div class="mb-3 row txtcategoria">
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
                            <label for="exampleDataList" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="benviar">
                                    <i class="mdi mdi-content-save align-middle me-2"></i> GENERAR REPORTES
                                </button>
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
            $(".txtcategoria").hide();
            $('input[name="tipo_reporte"]').click(function() {
                var tipo_reporte = $('input[name="tipo_reporte"]:checked').val();
                if (tipo_reporte == 'Categoria') {
                    $(".txtcategoria").show();
                } else {
                    $(".txtcategoria").hide();
                }
            })
            /*******************************************/
            /*******************************************/
            $("#benviar").click(function() {
                if (!$('input[name="tipo_reporte"]').is(':checked')) {
                    alert("Seleccionar el tipo de reporte");
                    $('input[name="tipo_reporte"]').focus();
                    return false;
                }
                var tipo_reporte = $('input[name="tipo_reporte"]:checked').val();
                if (tipo_reporte == 'Categoria') {
                    if ($("#cod_categoria").val() == 0) {
                        alert("Falta seleccionar la categoria");
                        $("#cod_categoria").focus();
                        return false;
                    }
                }
                document.fapps.action = "exportar-productos-almacen-excel.php";
                document.fapps.submit();
                /*******************************************/
                /*******************************************/
            })
        })
    </script>
</body>

</html>