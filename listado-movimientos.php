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

    <style>
        /* Estilos para mejorar el scroll horizontal del DataTable */
        .dataTables_wrapper .dataTables_scroll {
            overflow-x: auto;
        }

        .dataTables_wrapper .dataTables_scrollHead,
        .dataTables_wrapper .dataTables_scrollBody {
            overflow: visible;
        }

        .dataTables_wrapper table.dataTable {
            width: 100% !important;
            margin: 0 auto;
        }

        /* Asegurar que la tabla no se comprima */
        #datatable-buttons {
            min-width: 1400px;
            table-layout: auto !important;
        }

        /* Botones del DataTable */
        .dt-buttons {
            margin-bottom: 15px;
        }
    </style>

</head>

<body data-sidebar="dark">

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
                                <h4 class="mb-sm-0">Listado de Movimientos Financieros</h4>
                                <!-- **************************************** -->
                                <div class="page-title-right">
                                    <div class="button-items">
                                        <a href="registrar-movimiento.php?sub_modulo=Registrar Movimiento" class="btn btn-primary waves-effect waves-light">
                                            Nuevo Movimiento <i class="ri-add-line align-middle ms-2"></i>
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
                                    <div style="overflow-x: auto;">
                                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width='8%'>Fecha</th>
                                                    <th width='8%'>Tipo</th>
                                                    <th width='10%'>Clasificación</th>
                                                    <th width='10%'>RUC</th>
                                                    <th>Razón Social</th>
                                                    <th>Concepto</th>
                                                    <th width='10%'>Categoría</th>
                                                    <th width='10%'>Monto Total</th>
                                                    <th width='8%'>Cuotas</th>
                                                    <th width='8%'>Estado</th>
                                                    <th width='10%'>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlConsulta = mysqli_query($conexion, "SELECT * FROM ingresos_egresos ORDER BY fecha_creacion DESC");
                                                while ($fmov = mysqli_fetch_array($sqlConsulta)) {
                                                    $id_movimiento = $fmov['id_movimiento'];
                                                    $tipo = $fmov['tipo'];
                                                    $clasificacion = $fmov['clasificacion'];
                                                    $ruc = $fmov['ruc'];
                                                    $razon_social = $fmov['razon_social'];
                                                    $concepto = $fmov['concepto'];
                                                    $categoria = $fmov['categoria'];
                                                    $monto_total = $fmov['monto_total'];
                                                    $numero_cuotas = $fmov['numero_cuotas'];
                                                    $fecha_primera_cuota = $fmov['fecha_primera_cuota'];

                                                    // Badge para tipo
                                                    if ($tipo == 'INGRESO') {
                                                        $badge_tipo = "<span class='badge rounded-pill bg-success'>INGRESO</span>";
                                                    } else {
                                                        $badge_tipo = "<span class='badge rounded-pill bg-danger'>EGRESO</span>";
                                                    }

                                                    // Badge para clasificación
                                                    if ($clasificacion == 'EMPRESARIAL') {
                                                        $badge_clas = "<span class='badge rounded-pill bg-primary'>EMPRESARIAL</span>";
                                                    } else {
                                                        $badge_clas = "<span class='badge rounded-pill bg-info'>PERSONAL</span>";
                                                    }

                                                    // Badge para estado
                                                    if ($fmov['estado'] == 'A') {
                                                        $badge_estado = "<span class='badge rounded-pill bg-success'>Activo</span>";
                                                    } else {
                                                        $badge_estado = "<span class='badge rounded-pill bg-secondary'>Inactivo</span>";
                                                    }

                                                    // Formato de fecha
                                                    $fecha_formateada = date('d/m/Y', strtotime($fecha_primera_cuota));

                                                    // RUC y Razón social
                                                    $ruc_display = !empty($ruc) ? $ruc : '-';
                                                    $razon_display = !empty($razon_social) ? $razon_social : '-';
                                                    $concepto_corto = strlen($concepto) > 50 ? substr($concepto, 0, 50) . '...' : $concepto;
                                                    $categoria_display = !empty($categoria) ? str_replace('_', ' ', $categoria) : '-';
                                                ?>
                                                    <tr>
                                                        <td><?= $fecha_formateada ?></td>
                                                        <td><?= $badge_tipo ?></td>
                                                        <td><?= $badge_clas ?></td>
                                                        <td><?= $ruc_display ?></td>
                                                        <td><?= $razon_display ?></td>
                                                        <td title="<?= $concepto ?>"><?= $concepto_corto ?></td>
                                                        <td><?= $categoria_display ?></td>
                                                        <td>S/ <?= number_format($monto_total, 2) ?></td>
                                                        <td align="center"><?= $numero_cuotas ?></td>
                                                        <td><?= $badge_estado ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-outline-info btn-sm" onclick="verCuotas(<?= $id_movimiento ?>)" title="Ver Cuotas">
                                                                <i class="ri-list-check align-middle"></i>
                                                            </button>
                                                            <!--
                                                        <a href="" class="btn btn-outline-danger btn-sm borrarReg">
                                                            <i class="ri-delete-bin-fill align-middle"></i>
                                                            <input type="hidden" name="codborrar" value="<?= $id_movimiento ?>" class="codborrar">
                                                        </a>
                                                        -->
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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

        <!-- ============================================================== -->

        <!-- End Page-content -->

        <!-- Modal -->

        <div class="modal fade bs-example-modal-xl" id="bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-xl">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="myExtraLargeModalLabel">MODAL</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <p>...</p>

                    </div>

                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->

        </div><!-- /.modal -->

        <!-- ============================================================== -->

    </div>

    <!-- END layout-wrapper -->



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

    <!-- App js -->

    <script src="assets/js/app.js"></script>

    <script>
        // Reinicializar DataTable con configuración personalizada para scroll horizontal
        $(document).ready(function() {
            // Destruir la inicialización anterior si existe
            if ($.fn.DataTable.isDataTable('#datatable-buttons')) {
                $('#datatable-buttons').DataTable().destroy();
            }

            // Inicializar con configuración personalizada
            $('#datatable-buttons').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'colvis',
                        text: 'Columnas Visibles',
                        columns: ':not(.no-export)'
                    },
                    'copy',
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        },
                        customize: function(doc) {
                            // Ajustar el título
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                            // Ajustar márgenes para mejor aprovechamiento
                            doc.pageMargins = [20, 20, 20, 20];

                            // Reducir tamaño de fuente para que quepa más
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 9,
                                color: 'white',
                                fillColor: '#4e73df'
                            };
                            doc.defaultStyle.fontSize = 8;

                            // Título del documento
                            doc.content[0].text = 'Listado de Movimientos Financieros';
                            doc.content[0].style = 'header';
                            doc.content[0].alignment = 'center';
                            doc.content[0].margin = [0, 0, 0, 10];
                        }
                    },
                    'print'
                ],
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: true,
                paging: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                order: [
                    [0, 'desc']
                ], // Ordenar por fecha descendente
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros coincidentes",
                    emptyTable: "No hay datos disponibles en la tabla",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    },
                    buttons: {
                        colvis: 'Seleccionar Columnas',
                        colvisRestore: 'Restaurar'
                    }
                },
                columnDefs: [{
                        targets: 0,
                        width: "100px"
                    }, // Fecha
                    {
                        targets: 1,
                        width: "100px"
                    }, // Tipo
                    {
                        targets: 2,
                        width: "120px"
                    }, // Clasificación
                    {
                        targets: 3,
                        width: "110px"
                    }, // RUC
                    {
                        targets: 4,
                        width: "200px"
                    }, // Razón Social
                    {
                        targets: 5,
                        width: "250px"
                    }, // Concepto
                    {
                        targets: 6,
                        width: "150px"
                    }, // Categoría
                    {
                        targets: 7,
                        width: "120px"
                    }, // Monto
                    {
                        targets: 8,
                        width: "80px",
                        className: 'text-center'
                    }, // Cuotas
                    {
                        targets: 9,
                        width: "100px"
                    }, // Estado
                    {
                        targets: 10,
                        width: "100px",
                        className: 'no-export',
                        orderable: false
                    } // Acción
                ]
            });
        });

        // Función para ver cuotas de un movimiento
        function verCuotas(id_movimiento) {
            // Aquí se podría abrir un modal con las cuotas
            alert('Funcionalidad de ver cuotas en desarrollo. ID: ' + id_movimiento);
        }

        // Script para eliminar registro (comentado para evitar eliminaciones accidentales)
        /*
        $(document).on('click', '.borrarReg', function() {
            var id_movimiento = $('.codborrar', this).val();
            var datosEnviar = {
                'id_movimiento': id_movimiento,
                'modulo': "MovimientosFinancieros"
            }
            var r = confirm("¿Seguro que desea borrar el movimiento? Esto eliminará también todas las cuotas asociadas.");
            if (r == true) {
                $.ajax({
                    data: datosEnviar,
                    url: 'config/proceso-eliminar.php',
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        var resultado = data.resultado;
                        if (resultado == 'SI') {
                            location.reload();
                        }
                    }
                })
            }
        })
        */

        //Carga dinamica de modal
        $('#bs-example-modal-xl').on('show.bs.modal', function(e) {
            var remoteURL = $(e.relatedTarget).data('remote');
            $(this).find('.modal-body').load(remoteURL);
        })
    </script>



</body>



</html>