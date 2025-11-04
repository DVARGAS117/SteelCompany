<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
?>
<!doctype html>
<html lang="es">

<head>
    <?php require("config/cabecera-web.php"); ?>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .cuota-card {
            border-left: 4px solid;
            margin-bottom: 10px;
        }

        .cuota-vencida {
            border-left-color: #f46a6a;
            background-color: #fff5f5;
        }

        .cuota-proxima {
            border-left-color: #f1b44c;
            background-color: #fffbf0;
        }

        .cuota-normal {
            border-left-color: #50a5f1;
            background-color: #f0f8ff;
        }

        .cuota-pagada {
            border-left-color: #34c38f;
            background-color: #f0fff4;
        }

        .bar-chart {
            margin-top: 20px;
        }

        .bar-item {
            margin-bottom: 15px;
        }

        .bar-wrapper {
            background-color: #e9ecef;
            height: 30px;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .bar {
            height: 100%;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            padding-left: 10px;
            color: white;
            font-weight: bold;
        }

        .bar-empresarial {
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
        }

        .bar-personal {
            background: linear-gradient(90deg, #1cc88a 0%, #13855c 100%);
        }

        .bar-label {
            display: inline-block;
            width: 100px;
            font-weight: 500;
        }

        .bar-value {
            display: inline-block;
            margin-left: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php require("config/cabecera.php"); ?>
        <?php require("config/barra-navegacion.php"); ?>

        <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Título de página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Dashboard - Flujo de Caja</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Flujo de Caja</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cuenta-filter" class="form-label">Cuenta:</label>
                            <select id="cuenta-filter" class="form-select">
                                <option value="todas">Todas las Cuentas</option>
                                <option value="EMPRESARIAL">Solo Empresarial</option>
                                <option value="PERSONAL">Solo Personal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="mes-filter" class="form-label">Mes:</label>
                            <select id="mes-filter" class="form-select">
                                <?php
                                // Generar últimos 6 meses
                                for ($i = 0; $i < 6; $i++) {
                                    $fecha = date('Y-m', strtotime("-$i months"));
                                    $nombreMes = strftime('%B %Y', strtotime($fecha . '-01'));
                                    $selected = ($i == 0) ? 'selected' : '';
                                    echo "<option value='$fecha' $selected>" . ucfirst($nombreMes) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tarjetas de resumen -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Ingresos Totales</p>
                                            <h4 class="mb-0" id="total-ingresos">S/ 0.00</h4>
                                        </div>
                                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="ri-arrow-down-circle-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Egresos Totales</p>
                                            <h4 class="mb-0" id="total-egresos">S/ 0.00</h4>
                                        </div>
                                        <div class="avatar-sm rounded-circle bg-danger align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-danger">
                                                <i class="ri-arrow-up-circle-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Saldo Neto</p>
                                            <h4 class="mb-0" id="saldo-neto">S/ 0.00</h4>
                                        </div>
                                        <div class="avatar-sm rounded-circle bg-success align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-success">
                                                <i class="ri-wallet-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico y últimas transacciones -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Desglose por Clasificación</h4>
                                    <div class="bar-chart">
                                        <div class="bar-item">
                                            <span class="bar-label">Empresarial</span>
                                            <div class="bar-wrapper">
                                                <div class="bar bar-empresarial" style="width: 0%" id="bar-empresarial"></div>
                                            </div>
                                            <span class="bar-value" id="val-empresarial">S/ 0.00</span>
                                        </div>
                                        <div class="bar-item">
                                            <span class="bar-label">Personal</span>
                                            <div class="bar-wrapper">
                                                <div class="bar bar-personal" style="width: 0%" id="bar-personal"></div>
                                            </div>
                                            <span class="bar-value" id="val-personal">S/ 0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Últimas Transacciones</h4>
                                    <div id="recent-transactions" style="max-height: 300px; overflow-y: auto;">
                                        <p class="text-muted text-center">Cargando...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cuotas Pendientes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Cuotas Pendientes - Próximos Pagos/Cobros</h4>
                                    <div id="cuotas-pendientes">
                                        <p class="text-muted text-center">Cargando cuotas...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php require("config/piepagina.php"); ?>

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
    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Cargar datos iniciales
            cargarDatosDashboard();

            // Recargar al cambiar filtros
            $('#cuenta-filter, #mes-filter').on('change', function() {
                cargarDatosDashboard();
            });

            function cargarDatosDashboard() {
                var cuenta = $('#cuenta-filter').val();
                var mes = $('#mes-filter').val();

                $.ajax({
                    url: 'config/obtener-datos-dashboard.php',
                    type: 'POST',
                    data: {
                        cuenta: cuenta,
                        mes: mes
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log('Datos recibidos:', data);

                        // Actualizar tarjetas
                        $('#total-ingresos').text('S/ ' + formatNumber(data.total_ingresos));
                        $('#total-egresos').text('S/ ' + formatNumber(data.total_egresos));
                        $('#saldo-neto').text('S/ ' + formatNumber(data.saldo_neto));

                        // Actualizar color del saldo
                        if (data.saldo_neto >= 0) {
                            $('#saldo-neto').removeClass('text-danger').addClass('text-success');
                        } else {
                            $('#saldo-neto').removeClass('text-success').addClass('text-danger');
                        }

                        // Actualizar gráfico de barras
                        actualizarGraficoBarra(data);

                        // Actualizar últimas transacciones
                        actualizarUltimasTransacciones(data.ultimas_transacciones);

                        // Actualizar cuotas pendientes
                        actualizarCuotasPendientes(data.cuotas_pendientes);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar datos:', error);
                        console.error('Respuesta:', xhr.responseText);
                    }
                });
            }

            function actualizarGraficoBarra(data) {
                var maxValor = Math.max(data.empresarial, data.personal, 1);

                var porcentajeEmpresarial = (data.empresarial / maxValor) * 100;
                var porcentajePersonal = (data.personal / maxValor) * 100;

                $('#bar-empresarial').css('width', porcentajeEmpresarial + '%');
                $('#bar-personal').css('width', porcentajePersonal + '%');

                $('#val-empresarial').text('S/ ' + formatNumber(data.empresarial));
                $('#val-personal').text('S/ ' + formatNumber(data.personal));
            }

            function actualizarUltimasTransacciones(transacciones) {
                var html = '';

                if (transacciones.length === 0) {
                    html = '<p class="text-muted text-center">No hay transacciones registradas</p>';
                } else {
                    transacciones.forEach(function(t) {
                        var badgeTipo = t.tipo === 'INGRESO' ?
                            '<span class="badge bg-success">Ingreso</span>' :
                            '<span class="badge bg-danger">Egreso</span>';

                        html += '<div class="d-flex mb-3 pb-3 border-bottom">';
                        html += '<div class="flex-grow-1">';
                        html += '<h6 class="mb-1">' + t.razon_social + ' ' + badgeTipo + '</h6>';
                        html += '<p class="text-muted mb-0">' + t.concepto + '</p>';
                        html += '<small class="text-muted">' + t.fecha + '</small>';
                        html += '</div>';
                        html += '<div class="flex-shrink-0">';
                        html += '<h5 class="mb-0">S/ ' + formatNumber(t.monto_total) + '</h5>';
                        html += '</div>';
                        html += '</div>';
                    });
                }

                $('#recent-transactions').html(html);
            }

            function actualizarCuotasPendientes(cuotas) {
                var html = '';

                if (cuotas.length === 0) {
                    html = '<p class="text-muted text-center">No hay cuotas pendientes</p>';
                } else {
                    cuotas.forEach(function(c) {
                        var claseCuota = 'cuota-normal';
                        var iconoEstado = 'ri-time-line';
                        var textoEstado = 'Pendiente';

                        if (c.dias_restantes <= 0) {
                            claseCuota = 'cuota-vencida';
                            iconoEstado = 'ri-alarm-warning-line';
                            textoEstado = 'Vencida';
                        } else if (c.dias_restantes <= 3) {
                            claseCuota = 'cuota-proxima';
                            iconoEstado = 'ri-error-warning-line';
                            textoEstado = 'Próximo';
                        }

                        var badgeTipo = c.tipo === 'INGRESO' ?
                            '<span class="badge bg-success">Cobro</span>' :
                            '<span class="badge bg-danger">Pago</span>';

                        html += '<div class="card cuota-card ' + claseCuota + ' mb-2">';
                        html += '<div class="card-body p-3">';
                        html += '<div class="d-flex align-items-center">';
                        html += '<div class="flex-shrink-0 me-3">';
                        html += '<i class="' + iconoEstado + ' font-size-24"></i>';
                        html += '</div>';
                        html += '<div class="flex-grow-1">';
                        html += '<h6 class="mb-1">' + c.razon_social + ' ' + badgeTipo + '</h6>';
                        html += '<p class="text-muted mb-0">' + c.concepto + ' - Cuota ' + c.numero_cuota + '/' + c.total_cuotas + '</p>';
                        html += '<small class="text-muted">Vence: ' + c.fecha_vencimiento + ' (' + textoEstado;
                        if (c.dias_restantes > 0) {
                            html += ' en ' + c.dias_restantes + ' días';
                        }
                        html += ')</small>';
                        html += '</div>';
                        html += '<div class="flex-shrink-0 text-end">';
                        html += '<h5 class="mb-2">S/ ' + formatNumber(c.monto_cuota) + '</h5>';
                        html += '<button class="btn btn-sm btn-success marcar-pagada" data-id="' + c.id_cuota + '">';
                        html += '<i class="ri-check-line"></i> Marcar Pagada';
                        html += '</button>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                }

                $('#cuotas-pendientes').html(html);
            }

            // Marcar cuota como pagada
            $(document).on('click', '.marcar-pagada', function() {
                var idCuota = $(this).data('id');
                var boton = $(this);

                if (!confirm('¿Confirma que esta cuota ha sido pagada/recibida?')) {
                    return;
                }

                boton.prop('disabled', true).html('<i class="ri-loader-4-line"></i> Procesando...');

                $.ajax({
                    url: 'config/marcar-cuota-pagada.php',
                    type: 'POST',
                    data: {
                        id_cuota: idCuota
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Cuota marcada como pagada exitosamente.');
                            cargarDatosDashboard();
                        } else {
                            alert('Error: ' + response.mensaje);
                            boton.prop('disabled', false).html('<i class="ri-check-line"></i> Marcar Pagada');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Respuesta:', xhr.responseText);
                        alert('Error al marcar la cuota como pagada.');
                        boton.prop('disabled', false).html('<i class="ri-check-line"></i> Marcar Pagada');
                    }
                });
            });

            function formatNumber(num) {
                return parseFloat(num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        });
    </script>

</body>

</html>