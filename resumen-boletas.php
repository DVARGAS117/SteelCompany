<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
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
                                <h4 class="mb-sm-0">Enviar Resumenes de Boletas Electronicas a Sunat</h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a class='btn btn-danger waves-effect waves-light' data-bs-toggle='modal' data-bs-target='#bs-example-modal-xl' data-remote='enviar-resumen-boletas-sunat.php' data-sb-backdrop='static' data-sb-keyboard='false' title="Enviar Resumen de Boletas a Sunat">
                                            Enviar Resumen Boletas <i class="mdi mdi-check-network ms-2"></i>
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
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive wrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Ruc Emisor</th>
                                                <th>Tipo</th>
                                                <th>Doc.</th>
                                                <th>Cliente</th>
                                                <th>Msj. Sunat</th>
                                                <th>Hash CPE</th>
                                                <th>Tipo</th>
                                                <th>XML</th>
                                                <th>CDR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM documentos_electronicos ORDER BY doc DESC");
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $id_doc             = $fconsul['id_doc'];
                                                $ruc                = $fconsul['ruc'];
                                                $obs                = $fconsul['obs'];
                                                $url_xml            = $fconsul['url_xml'];
                                                $hash_cpe           = $fconsul['hash_cpe'];
                                                $hash_cdr           = $fconsul['hash_cdr'];
                                                $msj_sunat          = $fconsul['msj_sunat'];
                                                $ruta_cdr           = $fconsul['ruta_cdr'];
                                                $tipo               = $fconsul['tipo'];
                                                $doc                = $fconsul['doc'];
                                                $cliente            = $fconsul['cliente'];
                                                $tipo1              = $fconsul['tipo1'];
                                                if ($tipo1 == '3') {
                                                    $xtipo1         = "Beta";
                                                } else {
                                                    $xtipo1         = "Produccion";
                                                }
                                                /***********************************************/
                                                $mum++;
                                            ?>
                                                <tr>

                                                    <td><?= $ruc ?></td>
                                                    <td><?= $tipo ?></td>
                                                    <td><?= $doc ?></td>
                                                    <td><?= $cliente ?></td>
                                                    <td><?= $msj_sunat ?></td>
                                                    <td><?= $hash_cpe ?></td>
                                                    <td><?= $xtipo1 ?></td>
                                                    <td>
                                                        <!--  -->
                                                        <a href="api/<?= $url_xml ?>" class="btn btn-soft-success btn-sm" title="Descargar XML">
                                                            XML
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="api/<?= $ruta_cdr ?>" class="btn btn-soft-success btn-sm" title="Descargar XML">
                                                            CDR
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Enviar Resumenes de Boletas a Sunat</h5>
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
            var myModal = document.getElementById('bs-example-modal-xl')
            myModal.addEventListener('hidden.bs.modal', function(event) {
                location.reload();
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
    </script>
</body>

</html>