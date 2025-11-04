// Dashboard - Flujo de Caja
document.addEventListener('DOMContentLoaded', function () {
    cargarDatosDashboard();

    // Event listeners para filtros
    document.getElementById('cuenta-filter').addEventListener('change', cargarDatosDashboard);
    document.getElementById('mes-filter').addEventListener('change', cargarDatosDashboard);

    // Event delegation para marcar cuotas como pagadas
    document.getElementById('cuotas-pendientes').addEventListener('click', function (e) {
        if (e.target.closest('.marcar-pagada')) {
            const btn = e.target.closest('.marcar-pagada');
            const idCuota = parseInt(btn.dataset.id);
            marcarCuotaComoPagada(idCuota);
        }
    });
});

function cargarDatosDashboard() {
    const cuenta = document.getElementById('cuenta-filter').value;
    const mes = document.getElementById('mes-filter').value;

    // Extraer año y mes
    const [anio, numMes] = mes.split('-');

    const datos = obtenerDatosTemporales();

    // Filtrar por clasificación
    let movimientosFiltrados = datos.movimientos;
    if (cuenta !== 'todas') {
        movimientosFiltrados = movimientosFiltrados.filter(m => m.clasificacion === cuenta);
    }

    // Calcular ingresos y egresos basados en cuotas PAGADAS
    let totalIngresos = 0;
    let totalEgresos = 0;

    datos.cuotas.forEach(cuota => {
        if (cuota.estado === 'PAGADA' && cuota.fecha_pago) {
            const [anioCuota, mesCuota] = cuota.fecha_pago.split('-');

            if (anioCuota === anio && mesCuota === numMes) {
                const movimiento = datos.movimientos.find(m => m.id === cuota.id_movimiento);
                if (movimiento && movimiento.estado === 'A') {
                    // Verificar filtro de clasificación
                    if (cuenta === 'todas' || movimiento.clasificacion === cuenta) {
                        if (movimiento.tipo === 'INGRESO') {
                            totalIngresos += cuota.monto_cuota;
                        } else {
                            totalEgresos += cuota.monto_cuota;
                        }
                    }
                }
            }
        }
    });

    const saldoNeto = totalIngresos - totalEgresos;

    // Actualizar tarjetas
    document.getElementById('total-ingresos').textContent = 'S/ ' + formatearNumero(totalIngresos);
    document.getElementById('total-egresos').textContent = 'S/ ' + formatearNumero(totalEgresos);
    document.getElementById('saldo-neto').textContent = 'S/ ' + formatearNumero(saldoNeto);

    // Cambiar color del saldo
    const saldoElement = document.getElementById('saldo-neto');
    const saldoCard = saldoElement.closest('.card');
    if (saldoNeto >= 0) {
        saldoCard.classList.remove('bg-danger');
        saldoCard.classList.add('bg-success');
    } else {
        saldoCard.classList.remove('bg-success');
        saldoCard.classList.add('bg-danger');
    }

    // Calcular desglose por clasificación
    let empresarial = 0;
    let personal = 0;

    if (cuenta === 'todas') {
        // Calcular empresarial
        datos.cuotas.forEach(cuota => {
            if (cuota.estado === 'PAGADA' && cuota.fecha_pago) {
                const [anioCuota, mesCuota] = cuota.fecha_pago.split('-');
                if (anioCuota === anio && mesCuota === numMes) {
                    const movimiento = datos.movimientos.find(m => m.id === cuota.id_movimiento);
                    if (movimiento && movimiento.estado === 'A' && movimiento.clasificacion === 'EMPRESARIAL') {
                        if (movimiento.tipo === 'INGRESO') {
                            empresarial += cuota.monto_cuota;
                        } else {
                            empresarial -= cuota.monto_cuota;
                        }
                    } else if (movimiento && movimiento.estado === 'A' && movimiento.clasificacion === 'PERSONAL') {
                        if (movimiento.tipo === 'INGRESO') {
                            personal += cuota.monto_cuota;
                        } else {
                            personal -= cuota.monto_cuota;
                        }
                    }
                }
            }
        });
    } else {
        // Si hay filtro específico
        if (cuenta === 'EMPRESARIAL') {
            empresarial = saldoNeto;
        } else {
            personal = saldoNeto;
        }
    }

    actualizarGraficoBarra(empresarial, personal);
    actualizarUltimasTransacciones(movimientosFiltrados);
    actualizarCuotasPendientes(cuenta);
}

function actualizarGraficoBarra(empresarial, personal) {
    const maxValor = Math.max(Math.abs(empresarial), Math.abs(personal), 1);

    const porcentajeEmpresarial = (Math.abs(empresarial) / maxValor) * 100;
    const porcentajePersonal = (Math.abs(personal) / maxValor) * 100;

    document.getElementById('bar-empresarial').style.width = porcentajeEmpresarial + '%';
    document.getElementById('bar-personal').style.width = porcentajePersonal + '%';

    document.getElementById('val-empresarial').textContent = 'S/ ' + formatearNumero(empresarial);
    document.getElementById('val-personal').textContent = 'S/ ' + formatearNumero(personal);
}

function actualizarUltimasTransacciones(movimientos) {
    const container = document.getElementById('recent-transactions');

    // Ordenar por fecha descendente y tomar los últimos 10
    const ultimos = movimientos
        .filter(m => m.estado === 'A')
        .sort((a, b) => new Date(b.fecha_creacion) - new Date(a.fecha_creacion))
        .slice(0, 10);

    if (ultimos.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">No hay transacciones registradas</p>';
        return;
    }

    let html = '';
    ultimos.forEach(t => {
        const badgeTipo = t.tipo === 'INGRESO'
            ? '<span class="badge bg-success">Ingreso</span>'
            : '<span class="badge bg-danger">Egreso</span>';

        html += `
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                    <h6 class="mb-1">${t.razon_social || 'Sin especificar'} ${badgeTipo}</h6>
                    <p class="text-muted mb-0">${t.concepto}</p>
                    <small class="text-muted">${formatearFechaDisplay(t.fecha_creacion)}</small>
                </div>
                <div class="flex-shrink-0">
                    <h5 class="mb-0">S/ ${formatearNumero(t.monto_total)}</h5>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

function actualizarCuotasPendientes(cuenta) {
    const datos = obtenerDatosTemporales();
    const container = document.getElementById('cuotas-pendientes');

    // Filtrar cuotas pendientes
    let cuotasPendientes = datos.cuotas.filter(c => c.estado === 'PENDIENTE');

    // Aplicar filtro de clasificación
    if (cuenta !== 'todas') {
        cuotasPendientes = cuotasPendientes.filter(c => {
            const movimiento = datos.movimientos.find(m => m.id === c.id_movimiento);
            return movimiento && movimiento.clasificacion === cuenta;
        });
    }

    // Ordenar por fecha de vencimiento
    cuotasPendientes.sort((a, b) => new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento));

    // Tomar las primeras 20
    cuotasPendientes = cuotasPendientes.slice(0, 20);

    if (cuotasPendientes.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">No hay cuotas pendientes</p>';
        return;
    }

    let html = '';
    cuotasPendientes.forEach(c => {
        const movimiento = datos.movimientos.find(m => m.id === c.id_movimiento);
        if (!movimiento || movimiento.estado !== 'A') return;

        const diasRestantes = calcularDiasRestantes(c.fecha_vencimiento);

        let claseCuota = 'cuota-normal';
        let iconoEstado = 'ri-time-line';
        let textoEstado = 'Pendiente';

        if (diasRestantes <= 0) {
            claseCuota = 'cuota-vencida';
            iconoEstado = 'ri-alarm-warning-line';
            textoEstado = 'Vencida';
        } else if (diasRestantes <= 3) {
            claseCuota = 'cuota-proxima';
            iconoEstado = 'ri-error-warning-line';
            textoEstado = 'Próximo';
        }

        const badgeTipo = movimiento.tipo === 'INGRESO'
            ? '<span class="badge bg-success">Cobro</span>'
            : '<span class="badge bg-danger">Pago</span>';

        html += `
            <div class="card cuota-card ${claseCuota} mb-2">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="${iconoEstado}" style="font-size: 24px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${movimiento.razon_social || 'Sin especificar'} ${badgeTipo}</h6>
                            <p class="text-muted mb-0">${movimiento.concepto} - Cuota ${c.numero_cuota}/${movimiento.numero_cuotas}</p>
                            <small class="text-muted">Vence: ${formatearFechaDisplay(c.fecha_vencimiento)} (${textoEstado}${diasRestantes > 0 ? ' en ' + diasRestantes + ' días' : ''})</small>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h5 class="mb-2">S/ ${formatearNumero(c.monto_cuota)}</h5>
                            <button class="btn btn-sm btn-success marcar-pagada" data-id="${c.id_cuota}">
                                <i class="ri-check-line"></i> Marcar Pagada
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

function marcarCuotaComoPagada(idCuota) {
    if (!confirm('¿Confirma que esta cuota ha sido pagada/recibida?')) {
        return;
    }

    const resultado = marcarCuotaPagada(idCuota);

    if (resultado.success) {
        alert('Cuota marcada como pagada exitosamente.');
        cargarDatosDashboard();
    } else {
        alert('Error: ' + resultado.mensaje);
    }
}
