<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
?>
<!doctype html>
<html lang="en">

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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Registrar Movimiento Financiero</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Registrar Movimiento</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Nuevo Movimiento</h4>
                                </div>
                                <div class="card-body">
                                    <form id="fapps" method="post" action="javascript:void(0);">
                                        <input type="hidden" name="proceso" value="RegistrarMovimiento">
                                        <input type="hidden" name="modulo" value="MovimientosFinancieros">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tipo" class="form-label">Tipo de Transacción <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="tipo" name="tipo" required>
                                                        <option value="">Seleccionar...</option>
                                                        <option value="INGRESO">Ingreso (Venta/Cobro)</option>
                                                        <option value="EGRESO">Egreso (Compra/Gasto/Pago)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="clasificacion" class="form-label">Clasificación <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="clasificacion" name="clasificacion" required>
                                                        <option value="">Seleccionar...</option>
                                                        <option value="EMPRESARIAL">Empresarial</option>
                                                        <option value="PERSONAL">Personal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="ruc" class="form-label">RUC Cliente/Proveedor</label>
                                                    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="20123456789" maxlength="11">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="razon_social" class="form-label">Razón Social</label>
                                                    <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre o razón social">
                                                    <small class="form-text text-muted">Se autocompleta al ingresar el RUC</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="concepto" class="form-label">Concepto/Detalle <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="concepto" name="concepto" placeholder="Descripción del producto o servicio" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="monto_total" class="form-label">Monto Total (S/) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="monto_total" name="monto_total" step="0.01" placeholder="0.00" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label d-block">&nbsp;</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="habilitar_cuotas" name="habilitar_cuotas">
                                                        <label class="form-check-label" for="habilitar_cuotas">
                                                            Pago en cuotas
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="cuotas-row" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="numero_cuotas" class="form-label">Número de Cuotas</label>
                                                    <input type="number" class="form-control" id="numero_cuotas" name="numero_cuotas" min="1" value="1" placeholder="1" disabled>
                                                    <small class="form-text text-muted">Ingrese el número total de cuotas</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="frecuencia_cuotas" class="form-label">Frecuencia de Cuotas</label>
                                                    <select class="form-select" id="frecuencia_cuotas" name="frecuencia_cuotas" disabled>
                                                        <option value="MENSUAL">Mensual</option>
                                                        <option value="QUINCENAL">Quincenal</option>
                                                        <option value="SEMANAL">Semanal</option>
                                                        <option value="PERSONALIZADO">Personalizado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="fecha_primera_cuota" class="form-label">Fecha 1ra Cuota <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="fecha_primera_cuota" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="fecha-pago-unico-row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="fecha_pago_unico" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="fecha_pago_unico" name="fecha_primera_cuota" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="frecuencia-row-old" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="frecuencia_cuotas_old" class="form-label">Frecuencia de Cuotas</label>
                                                    <select class="form-select" id="frecuencia_cuotas_old" name="frecuencia_cuotas_old">
                                                        <option value="MENSUAL">Mensual</option>
                                                        <option value="QUINCENAL">Quincenal</option>
                                                        <option value="SEMANAL">Semanal</option>
                                                        <option value="PERSONALIZADO">Personalizado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="categoria" class="form-label">Categoría</label>
                                                    <select class="form-select" id="categoria" name="categoria">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="VENTA">Venta</option>
                                                        <option value="SERVICIO">Servicio</option>
                                                        <option value="COMPRA">Compra</option>
                                                        <option value="SERVICIOS_BASICOS">Servicio Básico (Luz, Agua, etc.)</option>
                                                        <option value="PLANILLA">Planilla</option>
                                                        <option value="FRACCIONAMIENTO_SUNAT">Fraccionamiento SUNAT</option>
                                                        <option value="CREDITO">Crédito</option>
                                                        <option value="OTROS">Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="resolucion-group" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="numero_resolucion" class="form-label">Número de Resolución</label>
                                                    <input type="text" class="form-control" id="numero_resolucion" name="numero_resolucion" placeholder="Número de resolución SUNAT">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="notas" class="form-label">Notas Adicionales</label>
                                            <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Información adicional..."></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="A">Activo</option>
                                                <option value="I">Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
                                            <a href="listado-movimientos.php?sub_modulo=Listado de Movimientos" class="btn btn-secondary ms-2">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require("config/piepagina.php"); ?>

    </div>
    <!-- end main content-->
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
            // Manejar checkbox de cuotas
            $('#habilitar_cuotas').on('change', function() {
                if ($(this).is(':checked')) {
                    // Mostrar campos de cuotas
                    $('#cuotas-row').show();
                    $('#fecha-pago-unico-row').hide();

                    // Habilitar campos de cuotas
                    $('#numero_cuotas').prop('disabled', false).val(2);
                    $('#frecuencia_cuotas').prop('disabled', false);
                    $('#fecha_primera_cuota').prop('disabled', false).prop('required', true);

                    // Ajustar el name y required del input de fecha
                    $('#fecha_primera_cuota').attr('name', 'fecha_primera_cuota');
                    $('#fecha_pago_unico').removeAttr('name').prop('required', false);
                } else {
                    // Ocultar campos de cuotas
                    $('#cuotas-row').hide();
                    $('#fecha-pago-unico-row').show();

                    // Deshabilitar campos de cuotas
                    $('#numero_cuotas').prop('disabled', true).val(1);
                    $('#frecuencia_cuotas').prop('disabled', true);
                    $('#fecha_primera_cuota').prop('disabled', true).prop('required', false);

                    // Ajustar el name y required del input de fecha
                    $('#fecha_pago_unico').attr('name', 'fecha_primera_cuota').prop('required', true);
                    $('#fecha_primera_cuota').removeAttr('name');
                }
            });

            // Mostrar/ocultar frecuencia cuando hay más de 1 cuota (ya no se usa, pero lo dejamos por compatibilidad)
            $('#numero_cuotas').on('change', function() {
                // Ya no hace nada porque la frecuencia siempre está visible cuando hay cuotas habilitadas
            });

            // Mostrar/ocultar campo de resolución para fraccionamiento
            $('#categoria').on('change', function() {
                if ($(this).val() === 'FRACCIONAMIENTO_SUNAT') {
                    $('#resolucion-group').show();
                } else {
                    $('#resolucion-group').hide();
                }
            });

            // Autocompletar RUC
            $('#ruc').on('blur', function() {
                var ruc = $(this).val().trim();
                console.log('RUC ingresado:', ruc);

                if (ruc === '') {
                    $('#razon_social').val('');
                    return;
                }

                console.log('Enviando petición AJAX para RUC:', ruc);

                $.ajax({
                    url: 'config/buscar-ruc.php',
                    type: 'POST',
                    data: {
                        ruc: ruc
                    },
                    success: function(response) {
                        console.log('Respuesta recibida:', response);

                        // jQuery ya parsea automáticamente el JSON
                        if (response.success) {
                            $('#razon_social').val(response.razon_social);
                            console.log('Razón social actualizada:', response.razon_social);
                        } else {
                            alert('El RUC ingresado no existe en la base de datos.');
                            $('#razon_social').val('');
                            $('#ruc').focus();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en AJAX:', status, error);
                        console.error('Respuesta del servidor:', xhr.responseText);
                        alert('Error al consultar el RUC.');
                    }
                });
            });

            // Validación y envío del formulario
            $('#fapps').on('submit', function(e) {
                e.preventDefault();

                var clasificacion = $('#clasificacion').val();
                var ruc = $('#ruc').val().trim();
                var razon_social = $('#razon_social').val().trim();

                // Validación: Si es empresarial, RUC y razón social son obligatorios
                if (clasificacion === 'EMPRESARIAL') {
                    if (ruc === '') {
                        alert('Para transacciones empresariales, el RUC es obligatorio.');
                        $('#ruc').focus();
                        return;
                    }
                    if (razon_social === '') {
                        alert('La razón social no puede estar vacía para transacciones empresariales.');
                        $('#razon_social').focus();
                        return;
                    }
                }

                // IMPORTANTE: Habilitar campos deshabilitados antes de enviar
                // Los campos disabled no se envían en el formulario
                $('#numero_cuotas').prop('disabled', false);
                $('#frecuencia_cuotas').prop('disabled', false);
                $('#fecha_primera_cuota').prop('disabled', false);

                // Enviar formulario
                $.ajax({
                    url: 'config/proceso-guardar.php?sub_modulo=Registrar Movimiento',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log('Respuesta del guardado:', response);

                        // Manejar respuesta (puede ser objeto o string con warnings)
                        var data = response;
                        if (typeof response === 'string') {
                            // Extraer JSON si viene mezclado con warnings
                            var jsonMatch = response.match(/\{.*\}/);
                            if (jsonMatch) {
                                data = JSON.parse(jsonMatch[0]);
                            }
                        }

                        if (data.respuesta === 'SI') {
                            alert('Movimiento guardado exitosamente.');
                            location.reload();
                        } else {
                            alert('Error al guardar el movimiento: ' + (data.mensaje || 'Error desconocido'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en guardado:', status, error);
                        console.error('Respuesta del servidor:', xhr.responseText);
                        alert('Error en la solicitud.');
                    }
                });
            });
        });
    </script>

</body>

</html>