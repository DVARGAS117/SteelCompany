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
                                <h4 class="mb-sm-0">Enviar Guías de Remisión a Sunat</h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a class="btn btn-danger waves-effect waves-light" onclick="javascript:consultaVCP()">
                                            Validar Guias <i class="mdi mdi-check-network ms-2"></i>
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
                                                <th>Fecha</th>
                                                <th>Guía</th>
                                                <th>Cliente</th>
                                                <th>Doc.</th>
                                                <th>F. Envio Sunat</th>
                                                <th width="7%">XML</th>
                                                <th width="7%">CDR</th>
                                                <th>Enviar</th>
                                                <th width="10%">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM guias_remision ORDER BY fecha_registro DESC");
                                            while ($fconsul         = mysqli_fetch_array($sqlConsulta)) {
                                                $id_guia            = $fconsul['id_guia'];
                                                $id_factura         = $fconsul['id_factura'];
                                                $codigo_compro      = $fconsul['codigo_compro'];
                                                $num_guia           = $fconsul['serie'] . '-' . $fconsul['num_guia'];
                                                $fecha_registro     = date('d-m-Y', strtotime($fconsul['fecha_registro']));
                                                $fecha_enviosunat   = $fconsul['fecha_enviosunat'];
                                                $ruta_xml           = $fconsul['ruta_xml'];
                                                $ruta_cdr           = $fconsul['ruta_cdr'];
                                                /***********************************************/
                                                $sqlFacturas        = mysqli_query($conexion, "SELECT razon_social, serie, num_comprobante FROM factura WHERE id_factura='$id_factura'");
                                                $ffact              = mysqli_fetch_array($sqlFacturas);
                                                $razon_social       = $ffact['razon_social'];
                                                $documentoGuia      = $ffact['serie'] . '-' . $ffact['num_comprobante'];
                                                /***********************************************/
                                                if ($ruta_xml) {
                                                    $descargarxml   = "
                                                    <a href='api/$ruta_xml' target='_blank' class='btn btn-primary btn-sm' title='Descargar XML'>
                                                        <i class='mdi mdi-download'></i> XML
                                                    </a>";
                                                } else {
                                                    $descargarxml   = "";
                                                }
                                                /***********************************************/
                                                if ($ruta_cdr) {
                                                    $descargarcdr   = "
                                                    <a href='api/$ruta_cdr' target='_blank' class='btn btn-primary btn-sm' title='Descargar XML'>
                                                        <i class='mdi mdi-download'></i> CDR
                                                    </a>";
                                                } else {
                                                    $descargarcdr   = "";
                                                }
                                                /***********************************************/
                                                if ($fconsul['estado'] == 'Por Enviar') {
                                                    $estado         = "
                                                    <a href='#' class='badge rounded-pill bg-danger' data-bs-toggle='modal' data-bs-target='#bs-example-modal-xl' data-remote='enviar-guias-remision-sunat.php?id_guia=$id_guia' data-sb-backdrop='static' data-sb-keyboard='false'>
                                                        Enviar a Sunat<i class='ri-send-plane-fill align-middle ms-2'></i>
                                                    </a>";
                                                } else {
                                                    $estado         = "
                                                    <span class='badge rounded-pill bg-success'>
                                                        Aceptado <i class='ri-check-line align-middle ms-2'></i>
                                                    </span>";
                                                }
                                                /***********************************************/
                                            ?>
                                                <tr>
                                                    <td><?= $fecha_registro ?></td>
                                                    <td><?= $num_guia ?></td>
                                                    <td><?= $razon_social ?></td>
                                                    <td><?= $documentoGuia ?></td>
                                                    <td><?= $fecha_enviosunat ?></td>
                                                    <td><?= $descargarxml ?></td>
                                                    <td><?= $descargarcdr ?></td>
                                                    <td><?= $estado ?></td>
                                                    <td>
                                                        <a class='btn btn-soft-success btn-sm' data-bs-toggle='modal' data-bs-target='#bs-example-modal-xl' data-remote='enviar-pdfxmlguia-clientes.php?id_guia=<?= $id_guia ?>' data-sb-backdrop='static' data-sb-keyboard='false' title="Enviar Documentos a Cliente">
                                                            <i class='ri-mail-send-fill align-middle'></i>
                                                        </a>
                                                        <!--  -->
                                                        <a class="btn btn-soft-danger btn-sm imprimirPDF" title="Crear/Ver PDF">
                                                            <i class="ri-file-pdf-fill align-middle"></i>
                                                            <input type="hidden" name="id_guia" value="<?= $id_guia ?>" class="codimprimir">
                                                        </a>
                                                        <!--  -->
                                                        <a class="btn btn-soft-success btn-sm" data-bs-toggle='modal' data-bs-target='#bs-example-modal-xl' data-remote='mod-estado-guia.php?id_guia=<?= $id_guia ?>' data-sb-backdrop='static' data-sb-keyboard='false' title="Editar Estado de Guía">
                                                            <i class="ri-edit-2-fill align-middle"></i>
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Enviar Guías de Remisión Electronica a Sunat</h5>
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
    <script src="assets/js/VentanaCentrada.js"></script>

    <script>
        $(function() {
            var myModal = document.getElementById('bs-example-modal-xl')
            myModal.addEventListener('hidden.bs.modal', function(event) {
                location.reload();
            })
            /**************************************************/
            /**************************************************/
            $(document).on("click", ".imprimirPDF", function() {
                var id_guia = $(".codimprimir", this).val();
                VentanaCentrada('ventas/ver-guias-pdf.php?id_guia=' + id_guia, 'Guia Remision', '', '1024', '768', 'true');
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
        /*******************************************************/
        /*********          EJECUTAR VALIDADOR   ***************/
        /*******************************************************/
        function consultaVCP() {
            window.open("http://www.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm", "msg1", "toolbar=no,top=0,left=0,location=0,directories=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=1024, height=500")
            window.open("/mensajes/agosto/2018/aviso-ti-030818.html", "msg2", "toolbar=no,location=no,top=90,left=170,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no, width=508, height=265")
        }

        function consultaVADCP() {
            window.open("http://www.sunat.gob.pe/ol-ti-itconsverixml/ConsVeriXml.htm", "msg1", "toolbar=no,top=0,left=0,location=0,directories=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=1024, height=500")
            window.open("/mensajes/agosto/2018/aviso-ti-030818.html", "msg2", "toolbar=no,location=no,top=90,left=170,directories=no,status=yes,menubar=no,scrollbars=no,resizable=no, width=508, height=265")
        }
    </script>
</body>

</html>