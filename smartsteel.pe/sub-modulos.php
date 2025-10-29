<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
$xcod_modulo    = $_REQUEST['cod_modulo'];
$xsqlModulos    = mysqli_query($conexion, "SELECT nombre_modulo FROM modulos WHERE cod_modulo='$xcod_modulo'");
$xfmods         = mysqli_fetch_array($xsqlModulos);
$xnombre_modulo = $xfmods['nombre_modulo'];
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
                                <h4 class="mb-sm-0">Administrar Sub Módulos de <span style="color: red;"><?= $xnombre_modulo ?></span></h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="modulos.php?sub_modulo=Modulos de Sistema" class="btn btn-primary waves-effect waves-light">
                                            <i class="ri-arrow-left-circle-fill align-middle ms-2"></i>
                                            Regresar a Modulos
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" name="fapps" id="fapps" method="post">
                                        <div class="mb-3 row">
                                            <label for="ruc" class="col-md-2 col-form-label">Sub Modulo</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="sub_modulo" id="sub_modulo">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="razon_social" class="col-md-2 col-form-label">Enlace</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="enlace" id="enlace">
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
                                                    <i class="ri-check-line align-middle me-2"></i> GUARDAR SUB MODULO
                                                </button>
                                                <input type="hidden" name="cod_modulo" id="cod_modulo" value="<?= $xcod_modulo ?>">
                                                <input type="hidden" name="proceso" id="proceso">
                                                <input type="hidden" name="modulo" id="modulo">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Listado de Sub opciones -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="2%">Nº</th>
                                                <th>Nombre de Sub Modulo</th>
                                                <th width="10%">Enlace</th>
                                                <th width="5%">Estado</th>
                                                <th width="5%">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM sub_modulos WHERE cod_modulo='$xcod_modulo'");
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $cod_submodulo      = $fconsul['cod_submodulo'];
                                                $sub_modulo         = $fconsul['sub_modulo'];
                                                $enlace             = $fconsul['enlace'];
                                                if ($fconsul['estado'] == 'A') {
                                                    $estado = "<span class='badge rounded-pill bg-success'>Activo</span>";
                                                } else {
                                                    $estado = "<span class='badge rounded-pill bg-danger'>Inactivo</span>";
                                                }
                                                /*************************************************/
                                                /*************************************************/
                                                $num++;
                                            ?>
                                                <tr>
                                                    <td><?= $num ?></td>
                                                    <td><?= $sub_modulo ?></td>
                                                    <td><?= $enlace ?></td>
                                                    <td><?= $estado ?></td>
                                                    <td>
                                                        <a href="" class="btn btn-outline-danger btn-sm borrarReg">
                                                            <i class="ri-delete-bin-fill align-middle"></i>
                                                            <input type="hidden" name="codborrar" value="<?= $cod_submodulo ?>" class="codborrar">
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

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
    <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Registrar/Editar Módulos del Sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script>
        $(function() {
            $("#benviar").click(function() {
                if ($("#sub_modulo").val() == '') {
                    alert("Falta ingresar sub modulo");
                    $("#sub_modulo").focus();
                    return false;
                }
                if ($("#enlace").val() == '') {
                    alert("Falta ingresar el enlace");
                    $("#enlace").focus();
                    return false;
                }
                /*******************************************/
                /*******************************************/
                $("#proceso").val('RegistrarSubModulo');
                $("#modulo").val('SubModulo');
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
                            alert("El sub modulo se registro con exito.");
                            $("#sub_modulo").val('');
                            $("#enlace").val('');
                            location.reload();
                        } else {
                            alert("Lo sentimos pero el sub modulo ya existe.");
                        }
                    }
                })
            })
            /**************************************************/
            /**************************************************/
            $(document).on('click', '.borrarReg', function() {
                var cod_submodulo = $('.codborrar', this).val();
                var datosEnviar = {
                    'cod_submodulo': cod_submodulo,
                    'modulo': "SubModulos"
                }
                var r = confirm("¿Seguro que desea borrar el registro?");
                if (r == true) {
                    $.ajax({
                        data: datosEnviar,
                        url: 'config/proceso-eliminar.php',
                        type: 'POST',
                        dataType: 'json',
                        success: function(datos) {
                            if (datos.resultado == 'SI') {
                                alert("El registro se borró satisfactoriamente");
                                location.reload();
                            }
                        }
                    })
                }
                return false;
            })
            /**************************************************/
            /**************************************************/
            var remoto_href = '';
            jQuery('body').on('click', '[data-bs-toggle="modal"]', function() {
                if (remoto_href != jQuery(this).data("remote")) {
                    remoto_href = jQuery(this).data("remote");
                    jQuery(jQuery(this).data("bs-target")).find('.modal-body').empty();
                    jQuery(jQuery(this).data("bs-target") + ' .modal-body').load(remoto_href);
                    //$("#bs-example-modal-xl .modal-body").load(remoto_href);
                }
                return false
            });
        })
        /**************************************************/
        /**************************************************/
    </script>
</body>

</html>