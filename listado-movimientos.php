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

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

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

        <!-- Modal para ver cuotas -->
        <div class="modal fade" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="modalCuotasLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalCuotasLabel">
                            <i class="ri-list-check align-middle me-2"></i>Detalle de Cuotas del Movimiento
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Información del movimiento principal -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Información del Movimiento</h5>
                                <div class="row" id="infoMovimiento">
                                    <!-- Se llenará dinámicamente con JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de cuotas -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Listado de Cuotas</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="tablaCuotas">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="8%">N° Cuota</th>
                                                <th width="15%">Monto</th>
                                                <th width="15%">Fecha Vencimiento</th>
                                                <th width="15%">Fecha Pago</th>
                                                <th width="12%">Estado</th>
                                                <th width="35%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuotasBody">
                                            <!-- Se llenará dinámicamente con JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar monto de cuota -->
        <div class="modal fade" id="modalEditarCuota" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="ri-edit-line align-middle me-2"></i>Editar Monto de Cuota
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            <i class="ri-alert-line align-middle me-2"></i>
                            <strong>Advertencia:</strong> Al modificar el monto de esta cuota, el monto total del movimiento será recalculado automáticamente.
                        </div>
                        <input type="hidden" id="editarIdCuota">
                        <div class="mb-3">
                            <label for="editarMontoCuota" class="form-label">Nuevo Monto de la Cuota</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control" id="editarMontoCuota" step="0.01" min="0.01" required>
                            </div>
                            <div class="form-text">Ingrese el nuevo monto para esta cuota</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monto Actual:</label>
                            <p class="fw-bold" id="montoActualCuota">S/ 0.00</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-warning" onclick="confirmarEditarCuota()">
                            <i class="ri-save-line align-middle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        // Variable global para almacenar el ID del movimiento actual
        let movimientoActualId = null;

        // Función para ver cuotas de un movimiento
        function verCuotas(id_movimiento) {
            movimientoActualId = id_movimiento;

            // Realizar petición AJAX para obtener las cuotas
            $.ajax({
                url: 'ajax/obtener-cuotas-movimiento.php',
                type: 'POST',
                data: {
                    id_movimiento: id_movimiento
                },
                dataType: 'json',
                beforeSend: function() {
                    // Mostrar loading
                    $('#infoMovimiento').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
                    $('#cuotasBody').html('<tr><td colspan="6" class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>');
                },
                success: function(response) {
                    if (response.success) {
                        cargarInfoMovimiento(response.movimiento);
                        cargarCuotas(response.cuotas);
                        $('#modalCuotas').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo cargar la información del movimiento'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error completo:', xhr);
                    console.error('Status:', status);
                    console.error('Error:', error);
                    console.error('Response Text:', xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'Error al cargar las cuotas.<br><small>Revise la consola para más detalles.</small>',
                        footer: '<small>Status: ' + status + '</small>'
                    });
                }
            });
        }

        // Función para cargar la información del movimiento principal
        function cargarInfoMovimiento(movimiento) {
            const badgeTipo = movimiento.tipo === 'INGRESO' ?
                '<span class="badge bg-success">INGRESO</span>' :
                '<span class="badge bg-danger">EGRESO</span>';

            const badgeClasif = movimiento.clasificacion === 'EMPRESARIAL' ?
                '<span class="badge bg-primary">EMPRESARIAL</span>' :
                '<span class="badge bg-info">PERSONAL</span>';

            const rucDisplay = movimiento.ruc || 'N/A';
            const razonDisplay = movimiento.razon_social || 'N/A';
            const fecha = new Date(movimiento.fecha_primera_cuota).toLocaleDateString('es-PE');

            let html = `
                <div class="col-md-6">
                    <p><strong>Tipo:</strong> ${badgeTipo}</p>
                    <p><strong>Clasificación:</strong> ${badgeClasif}</p>
                    <p><strong>RUC:</strong> ${rucDisplay}</p>
                    <p><strong>Razón Social:</strong> ${razonDisplay}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Concepto:</strong> ${movimiento.concepto}</p>
                    <p><strong>Categoría:</strong> ${movimiento.categoria.replace(/_/g, ' ')}</p>
                    <p><strong>Monto Total:</strong> <span class="text-primary fw-bold">S/ ${parseFloat(movimiento.monto_total).toFixed(2)}</span></p>
                    <p><strong>Fecha Inicial:</strong> ${fecha}</p>
                </div>
            `;

            $('#infoMovimiento').html(html);
        }

        // Función para cargar las cuotas en la tabla
        function cargarCuotas(cuotas) {
            if (cuotas.length === 0) {
                $('#cuotasBody').html('<tr><td colspan="6" class="text-center">No hay cuotas registradas</td></tr>');
                return;
            }

            let html = '';
            cuotas.forEach(function(cuota) {
                const fechaVenc = new Date(cuota.fecha_vencimiento).toLocaleDateString('es-PE');
                const fechaPago = cuota.fecha_pago ? new Date(cuota.fecha_pago).toLocaleDateString('es-PE') : '-';

                let badgeEstado = '';
                switch (cuota.estado) {
                    case 'PAGADA':
                        badgeEstado = '<span class="badge bg-success">PAGADA</span>';
                        break;
                    case 'VENCIDA':
                        badgeEstado = '<span class="badge bg-danger">VENCIDA</span>';
                        break;
                    case 'PENDIENTE':
                        badgeEstado = '<span class="badge bg-warning">PENDIENTE</span>';
                        break;
                }

                // Botones de acción según el estado
                let botones = '';

                // Botón editar (siempre disponible)
                botones += `<button type="button" class="btn btn-sm btn-warning" onclick="abrirModalEditarCuota(${cuota.id_cuota}, ${cuota.monto_cuota})" title="Editar Monto">
                    <i class="ri-edit-line"></i> Editar
                </button> `;

                // Botón pagar (solo si no está pagada)
                if (cuota.estado !== 'PAGADA') {
                    botones += `<button type="button" class="btn btn-sm btn-success" onclick="pagarCuota(${cuota.id_cuota})" title="Marcar como Pagada">
                        <i class="ri-money-dollar-circle-line"></i> Pagar
                    </button> `;
                }

                // Botón revertir (solo si está pagada)
                if (cuota.estado === 'PAGADA') {
                    botones += `<button type="button" class="btn btn-sm btn-info" onclick="revertirCuota(${cuota.id_cuota})" title="Revertir a Pendiente">
                        <i class="ri-arrow-go-back-line"></i> Revertir
                    </button> `;
                }

                // Botón eliminar (siempre disponible)
                botones += `<button type="button" class="btn btn-sm btn-danger" onclick="eliminarCuota(${cuota.id_cuota})" title="Eliminar Cuota">
                    <i class="ri-delete-bin-line"></i> Eliminar
                </button>`;

                html += `
                    <tr>
                        <td class="text-center">${cuota.numero_cuota}</td>
                        <td>S/ ${parseFloat(cuota.monto_cuota).toFixed(2)}</td>
                        <td>${fechaVenc}</td>
                        <td>${fechaPago}</td>
                        <td>${badgeEstado}</td>
                        <td>${botones}</td>
                    </tr>
                `;
            });

            $('#cuotasBody').html(html);
        }

        // Función para abrir modal de edición de cuota
        function abrirModalEditarCuota(idCuota, montoActual) {
            $('#editarIdCuota').val(idCuota);
            $('#editarMontoCuota').val(montoActual);
            $('#montoActualCuota').text('S/ ' + parseFloat(montoActual).toFixed(2));
            $('#modalEditarCuota').modal('show');
        }

        // Función para confirmar edición de cuota
        function confirmarEditarCuota() {
            const idCuota = $('#editarIdCuota').val();
            const nuevoMonto = parseFloat($('#editarMontoCuota').val());

            if (!nuevoMonto || nuevoMonto <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Monto inválido',
                    text: 'Por favor, ingrese un monto válido mayor a cero'
                });
                return;
            }

            Swal.fire({
                title: '¿Confirmar cambio de monto?',
                html: `Al modificar el monto de esta cuota, el <strong>monto total del movimiento será recalculado</strong>.<br><br>¿Desea continuar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    editarCuota(idCuota, nuevoMonto);
                }
            });
        }

        // Función para editar monto de cuota
        function editarCuota(idCuota, nuevoMonto) {
            $.ajax({
                url: 'ajax/gestionar-cuota.php',
                type: 'POST',
                data: {
                    accion: 'editar',
                    id_cuota: idCuota,
                    nuevo_monto: nuevoMonto
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modalEditarCuota').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Recargar las cuotas
                        verCuotas(movimientoActualId);
                        // Actualizar la tabla principal
                        setTimeout(() => location.reload(), 2100);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la solicitud'
                    });
                }
            });
        }

        // Función para marcar cuota como pagada
        function pagarCuota(idCuota) {
            Swal.fire({
                title: '¿Marcar como pagada?',
                text: 'Esta acción marcará la cuota como pagada con la fecha actual.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, marcar como pagada',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'ajax/gestionar-cuota.php',
                        type: 'POST',
                        data: {
                            accion: 'pagar',
                            id_cuota: idCuota
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                // Recargar las cuotas
                                verCuotas(movimientoActualId);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al procesar la solicitud'
                            });
                        }
                    });
                }
            });
        }

        // Función para revertir cuota pagada
        function revertirCuota(idCuota) {
            Swal.fire({
                title: '¿Revertir pago?',
                text: 'Esta acción marcará la cuota nuevamente como pendiente o vencida según su fecha.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, revertir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'ajax/gestionar-cuota.php',
                        type: 'POST',
                        data: {
                            accion: 'revertir',
                            id_cuota: idCuota
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                // Recargar las cuotas
                                verCuotas(movimientoActualId);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al procesar la solicitud'
                            });
                        }
                    });
                }
            });
        }

        // Función para eliminar cuota
        function eliminarCuota(idCuota) {
            Swal.fire({
                title: '¿Eliminar cuota?',
                html: 'Al eliminar esta cuota:<br>- El número total de cuotas se reducirá<br>- El monto total del movimiento será recalculado<br><br>¿Desea continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'ajax/gestionar-cuota.php',
                        type: 'POST',
                        data: {
                            accion: 'eliminar',
                            id_cuota: idCuota
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                // Recargar las cuotas
                                verCuotas(movimientoActualId);
                                // Actualizar la tabla principal
                                setTimeout(() => location.reload(), 2100);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al procesar la solicitud'
                            });
                        }
                    });
                }
            });
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