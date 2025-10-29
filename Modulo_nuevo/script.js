// Almacenamiento local
let transacciones = JSON.parse(localStorage.getItem('transacciones')) || [];
let cuotas = JSON.parse(localStorage.getItem('cuotas')) || [];

// Navegación entre vistas
document.querySelectorAll('.nav-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetView = btn.dataset.view;

        // Actualizar botones activos
        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Actualizar vistas
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById(targetView).classList.add('active');

        // Actualizar contenido según la vista
        if (targetView === 'dashboard') {
            actualizarDashboard();
        } else if (targetView === 'alertas') {
            actualizarAlertas();
        }
    });
});

// Mostrar/ocultar campo de fraccionamiento
document.getElementById('categoria').addEventListener('change', (e) => {
    const fracGroup = document.getElementById('fraccionamiento-group');
    if (e.target.value === 'fraccionamiento') {
        fracGroup.style.display = 'block';
    } else {
        fracGroup.style.display = 'none';
    }
});

// Manejo del formulario
document.getElementById('transaction-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const numCuotas = parseInt(document.getElementById('num-cuotas').value) || 1;
    const montoTotal = parseFloat(document.getElementById('monto').value);
    const fechaPrimera = document.getElementById('fecha-vencimiento').value;
    const frecuencia = document.getElementById('frecuencia-cuotas').value;

    const nuevaTransaccion = {
        id: Date.now(),
        tipo: document.getElementById('tipo').value,
        clasificacion: document.getElementById('clasificacion').value,
        ruc: document.getElementById('ruc').value,
        razonSocial: document.getElementById('razon-social').value,
        concepto: document.getElementById('concepto').value,
        montoTotal: montoTotal,
        numCuotas: numCuotas,
        montoCuota: numCuotas > 1 ? (montoTotal / numCuotas) : montoTotal,
        frecuenciaCuotas: frecuencia,
        fechaPrimeraCuota: fechaPrimera,
        fechaVencimiento: fechaPrimera,
        categoria: document.getElementById('categoria').value,
        numResolucion: document.getElementById('num-resolucion').value,
        notas: document.getElementById('notas').value,
        fechaRegistro: new Date().toISOString()
    };

    transacciones.push(nuevaTransaccion);
    localStorage.setItem('transacciones', JSON.stringify(transacciones));

    // Generar cuotas si es más de 1
    if (numCuotas > 1) {
        generarCuotas(nuevaTransaccion);
    } else {
        // Si es una sola cuota, también la registramos
        const cuotaUnica = {
            id: Date.now(),
            transaccionId: nuevaTransaccion.id,
            numeroCuota: 1,
            totalCuotas: 1,
            monto: montoTotal,
            fechaVencimiento: fechaPrimera,
            pagada: false,
            concepto: nuevaTransaccion.concepto,
            razonSocial: nuevaTransaccion.razonSocial,
            tipo: nuevaTransaccion.tipo,
            clasificacion: nuevaTransaccion.clasificacion
        };
        cuotas.push(cuotaUnica);
        localStorage.setItem('cuotas', JSON.stringify(cuotas));
    }

    // Mensaje de éxito
    if (numCuotas > 1) {
        alert(`✅ Transacción guardada exitosamente con ${numCuotas} cuotas generadas`);
    } else {
        alert('✅ Transacción guardada exitosamente');
    }

    // Limpiar formulario
    e.target.reset();
    document.getElementById('num-cuotas').value = 1;

    // Ir al dashboard
    document.querySelector('[data-view="dashboard"]').click();
});

// Generar cuotas para una transacción
function generarCuotas(transaccion) {
    const { id, montoTotal, numCuotas, fechaPrimeraCuota, frecuenciaCuotas, concepto, razonSocial, tipo, clasificacion } = transaccion;
    const montoCuota = montoTotal / numCuotas;

    for (let i = 0; i < numCuotas; i++) {
        const fechaVencimiento = calcularFechaCuota(fechaPrimeraCuota, i, frecuenciaCuotas);

        const cuota = {
            id: Date.now() + i,
            transaccionId: id,
            numeroCuota: i + 1,
            totalCuotas: numCuotas,
            monto: montoCuota,
            fechaVencimiento: fechaVencimiento,
            pagada: false,
            concepto: concepto,
            razonSocial: razonSocial,
            tipo: tipo,
            clasificacion: clasificacion
        };

        cuotas.push(cuota);
    }

    localStorage.setItem('cuotas', JSON.stringify(cuotas));
}

// Calcular fecha de cuota según frecuencia
function calcularFechaCuota(fechaInicial, numeroCuota, frecuencia) {
    const fecha = new Date(fechaInicial);

    switch (frecuencia) {
        case 'mensual':
            fecha.setMonth(fecha.getMonth() + numeroCuota);
            break;
        case 'quincenal':
            fecha.setDate(fecha.getDate() + (numeroCuota * 15));
            break;
        case 'semanal':
            fecha.setDate(fecha.getDate() + (numeroCuota * 7));
            break;
        case 'personalizado':
            // Por defecto mensual si es personalizado
            fecha.setMonth(fecha.getMonth() + numeroCuota);
            break;
    }

    return fecha.toISOString().split('T')[0];
}

// Actualizar Dashboard
function actualizarDashboard() {
    const mesSeleccionado = document.getElementById('mes-filter').value;
    const cuentaSeleccionada = document.getElementById('cuenta-filter').value;
    const [year, month] = mesSeleccionado.split('-');

    // Filtrar transacciones del mes y cuenta
    let transaccionesMes = transacciones.filter(t => {
        const fecha = new Date(t.fechaRegistro);
        const mesMatch = fecha.getFullYear() == year && (fecha.getMonth() + 1) == month;
        const cuentaMatch = cuentaSeleccionada === 'todas' || t.clasificacion === cuentaSeleccionada;
        return mesMatch && cuentaMatch;
    });

    // Calcular totales
    const ingresos = transaccionesMes
        .filter(t => t.tipo === 'ingreso')
        .reduce((sum, t) => sum + (t.montoTotal || t.monto || 0), 0);

    const egresos = transaccionesMes
        .filter(t => t.tipo === 'egreso')
        .reduce((sum, t) => sum + (t.montoTotal || t.monto || 0), 0);

    const saldo = ingresos - egresos;

    // Actualizar cards
    document.getElementById('total-ingresos').textContent = `S/ ${ingresos.toFixed(2)}`;
    document.getElementById('total-egresos').textContent = `S/ ${egresos.toFixed(2)}`;
    document.getElementById('saldo-neto').textContent = `S/ ${saldo.toFixed(2)}`;

    // Calcular por clasificación (solo si es "todas")
    if (cuentaSeleccionada === 'todas') {
        const empresarial = transaccionesMes
            .filter(t => t.clasificacion === 'empresarial' && t.tipo === 'egreso')
            .reduce((sum, t) => sum + (t.montoTotal || t.monto || 0), 0);

        const personal = transaccionesMes
            .filter(t => t.clasificacion === 'personal' && t.tipo === 'egreso')
            .reduce((sum, t) => sum + (t.montoTotal || t.monto || 0), 0);

        const totalEgresos = empresarial + personal;
        const porcEmpresarial = totalEgresos > 0 ? (empresarial / totalEgresos * 100) : 0;
        const porcPersonal = totalEgresos > 0 ? (personal / totalEgresos * 100) : 0;

        // Actualizar gráfico de barras
        document.getElementById('bar-empresarial').style.width = `${porcEmpresarial}%`;
        document.getElementById('bar-personal').style.width = `${porcPersonal}%`;
        document.getElementById('val-empresarial').textContent = `S/ ${empresarial.toFixed(2)}`;
        document.getElementById('val-personal').textContent = `S/ ${personal.toFixed(2)}`;
    } else {
        // Si hay filtro, mostrar solo la cuenta seleccionada
        const totalFiltrado = egresos;
        document.getElementById('bar-empresarial').style.width = cuentaSeleccionada === 'empresarial' ? '100%' : '0%';
        document.getElementById('bar-personal').style.width = cuentaSeleccionada === 'personal' ? '100%' : '0%';
        document.getElementById('val-empresarial').textContent = cuentaSeleccionada === 'empresarial' ? `S/ ${totalFiltrado.toFixed(2)}` : 'S/ 0.00';
        document.getElementById('val-personal').textContent = cuentaSeleccionada === 'personal' ? `S/ ${totalFiltrado.toFixed(2)}` : 'S/ 0.00';
    }

    // Mostrar últimas transacciones
    mostrarUltimasTransacciones(transaccionesMes);

    // Mostrar cuotas pendientes
    mostrarCuotasPendientes(cuentaSeleccionada);
}

// Mostrar últimas transacciones
function mostrarUltimasTransacciones(transaccionesMes) {
    const container = document.getElementById('recent-transactions');

    if (transaccionesMes.length === 0) {
        container.innerHTML = '<p class="empty-state">No hay transacciones registradas</p>';
        return;
    }

    // Ordenar por fecha (más reciente primero)
    const ultimas = transaccionesMes
        .sort((a, b) => new Date(b.fechaRegistro) - new Date(a.fechaRegistro))
        .slice(0, 10);

    container.innerHTML = ultimas.map(t => {
        const monto = t.montoTotal || t.monto || 0;
        const cuotasInfo = (t.numCuotas && t.numCuotas > 1) ? `<span>📊 ${t.numCuotas} cuotas de S/ ${(monto / t.numCuotas).toFixed(2)}</span>` : '';

        return `
            <div class="transaction-item ${t.tipo}">
                <div class="transaction-header">
                    <span class="transaction-concepto">${t.concepto}</span>
                    <span class="transaction-monto ${t.tipo}">
                        ${t.tipo === 'ingreso' ? '+' : '-'} S/ ${monto.toFixed(2)}
                    </span>
                </div>
                <div class="transaction-details">
                    <span class="transaction-badge badge-${t.clasificacion}">${t.clasificacion}</span>
                    ${t.razonSocial ? `<span>📄 ${t.razonSocial}</span>` : ''}
                    ${t.categoria ? `<span>🏷️ ${t.categoria}</span>` : ''}
                    ${cuotasInfo}
                    <span>📅 ${new Date(t.fechaRegistro).toLocaleDateString('es-PE')}</span>
                </div>
            </div>
        `;
    }).join('');
}

// Mostrar cuotas pendientes en el dashboard
function mostrarCuotasPendientes(cuentaFiltro = 'todas') {
    const container = document.getElementById('cuotas-pendientes');
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    // Filtrar cuotas no pagadas y aplicar filtro de cuenta
    let cuotasPendientes = cuotas.filter(c => {
        const cuentaMatch = cuentaFiltro === 'todas' || c.clasificacion === cuentaFiltro;
        return !c.pagada && cuentaMatch;
    }).sort((a, b) => new Date(a.fechaVencimiento) - new Date(b.fechaVencimiento));

    // Limitar a las próximas 15 cuotas
    cuotasPendientes = cuotasPendientes.slice(0, 15);

    if (cuotasPendientes.length === 0) {
        container.innerHTML = '<p class="empty-state">No hay cuotas pendientes</p>';
        return;
    }

    container.innerHTML = cuotasPendientes.map(c => {
        const fechaVenc = new Date(c.fechaVencimiento);
        fechaVenc.setHours(0, 0, 0, 0);
        const diasRestantes = Math.ceil((fechaVenc - hoy) / (1000 * 60 * 60 * 24));

        let estadoClass = '';
        let estadoTexto = '';

        if (diasRestantes < 0) {
            estadoClass = 'vencida';
            estadoTexto = `⚠️ Vencida hace ${Math.abs(diasRestantes)} días`;
        } else if (diasRestantes <= 3) {
            estadoClass = 'proxima';
            estadoTexto = `🔔 Vence en ${diasRestantes} ${diasRestantes === 1 ? 'día' : 'días'}`;
        } else {
            estadoTexto = `📅 ${fechaVenc.toLocaleDateString('es-PE')}`;
        }

        return `
            <div class="cuota-item ${estadoClass}">
                <div class="cuota-header">
                    <span class="cuota-numero">Cuota ${c.numeroCuota}/${c.totalCuotas} - ${c.concepto}</span>
                    <span class="cuota-monto">S/ ${c.monto.toFixed(2)}</span>
                </div>
                <div class="cuota-fecha">${estadoTexto}</div>
                ${c.razonSocial ? `<div class="cuota-concepto">📄 ${c.razonSocial}</div>` : ''}
                <div class="cuota-actions">
                    <button class="btn-cuota btn-pagar" onclick="marcarCuotaPagada(${c.id})">✓ Marcar Pagada</button>
                </div>
            </div>
        `;
    }).join('');
}

// Marcar cuota como pagada
function marcarCuotaPagada(cuotaId) {
    const cuota = cuotas.find(c => c.id === cuotaId);
    if (cuota) {
        cuota.pagada = true;
        cuota.fechaPago = new Date().toISOString();
        localStorage.setItem('cuotas', JSON.stringify(cuotas));
        actualizarDashboard();
        alert('✅ Cuota marcada como pagada');
    }
}

// Actualizar Alertas
function actualizarAlertas() {
    const periodo = document.getElementById('periodo-filter').value;
    const hoy = new Date();
    let fechaLimite = new Date();

    // Calcular fecha límite según período
    switch (periodo) {
        case 'proximos-3':
            fechaLimite.setDate(hoy.getDate() + 3);
            break;
        case 'proximos-7':
            fechaLimite.setDate(hoy.getDate() + 7);
            break;
        case 'quincena':
            fechaLimite.setDate(hoy.getDate() + 15);
            break;
        case 'mes':
            fechaLimite.setMonth(hoy.getMonth() + 1);
            break;
    }

    // Filtrar transacciones con fecha de vencimiento
    const alertas = transacciones.filter(t => {
        if (!t.fechaVencimiento || t.tipo !== 'egreso') return false;
        const fechaVenc = new Date(t.fechaVencimiento);
        return fechaVenc >= hoy && fechaVenc <= fechaLimite;
    }).sort((a, b) => new Date(a.fechaVencimiento) - new Date(b.fechaVencimiento));

    const container = document.getElementById('alerts-list');

    if (alertas.length === 0) {
        container.innerHTML = '<p class="empty-state">No hay pagos pendientes en este período</p>';
        return;
    }

    container.innerHTML = alertas.map(t => {
        const fechaVenc = new Date(t.fechaVencimiento);
        const diasRestantes = Math.ceil((fechaVenc - hoy) / (1000 * 60 * 60 * 24));
        const urgencia = diasRestantes <= 2 ? 'urgente' : 'proximo';

        return `
            <div class="alert-item ${urgencia}">
                <div class="alert-header">
                    <span class="alert-title">
                        ${urgencia === 'urgente' ? '🚨' : '⚠️'} ${t.concepto}
                    </span>
                    <span class="alert-date">
                        ${fechaVenc.toLocaleDateString('es-PE')} 
                        (${diasRestantes} ${diasRestantes === 1 ? 'día' : 'días'})
                    </span>
                </div>
                <div class="alert-details">
                    ${t.razonSocial ? `<div>📄 ${t.razonSocial}</div>` : ''}
                    ${t.categoria ? `<div>🏷️ ${t.categoria}</div>` : ''}
                    ${t.notas ? `<div>📝 ${t.notas}</div>` : ''}
                </div>
                <div class="alert-monto">Monto: S/ ${t.monto.toFixed(2)}</div>
            </div>
        `;
    }).join('');
}

// Event listeners para filtros
document.getElementById('mes-filter').addEventListener('change', actualizarDashboard);
document.getElementById('cuenta-filter').addEventListener('change', actualizarDashboard);
document.getElementById('periodo-filter').addEventListener('change', actualizarAlertas);

// Cargar datos de ejemplo si no hay transacciones
if (transacciones.length === 0) {
    cargarDatosEjemplo();
}

function cargarDatosEjemplo() {
    const ejemplos = [
        {
            id: 1,
            tipo: 'ingreso',
            clasificacion: 'empresarial',
            ruc: '20123456789',
            razonSocial: 'ABC Distribuidores S.A.C.',
            concepto: 'Venta de productos octubre',
            montoTotal: 6000,
            numCuotas: 3,
            montoCuota: 2000,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-10-30',
            fechaVencimiento: '2025-10-30',
            categoria: 'venta',
            numResolucion: '',
            notas: 'Pago en 3 cuotas mensuales',
            fechaRegistro: '2025-10-15T10:00:00'
        },
        {
            id: 2,
            tipo: 'egreso',
            clasificacion: 'empresarial',
            ruc: '20987654321',
            razonSocial: 'Servicios Electricos del Sur',
            concepto: 'Pago de luz - Octubre',
            montoTotal: 450,
            numCuotas: 1,
            montoCuota: 450,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-10-30',
            fechaVencimiento: '2025-10-30',
            categoria: 'servicio-basico',
            numResolucion: '',
            notas: 'Recibo N° 123456',
            fechaRegistro: '2025-10-20T14:30:00'
        },
        {
            id: 3,
            tipo: 'egreso',
            clasificacion: 'personal',
            ruc: '',
            razonSocial: 'Universidad Nacional',
            concepto: 'Pago mensualidad universidad',
            montoTotal: 4000,
            numCuotas: 5,
            montoCuota: 800,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-11-05',
            fechaVencimiento: '2025-11-05',
            categoria: 'otros',
            numResolucion: '',
            notas: 'Ciclo 2025-II - 5 cuotas mensuales',
            fechaRegistro: '2025-10-25T09:00:00'
        },
        {
            id: 4,
            tipo: 'egreso',
            clasificacion: 'empresarial',
            ruc: '',
            razonSocial: 'SUNAT',
            concepto: 'Fraccionamiento tributario',
            montoTotal: 14400,
            numCuotas: 12,
            montoCuota: 1200,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-09-01',
            fechaVencimiento: '2025-09-01',
            categoria: 'fraccionamiento',
            numResolucion: 'RES-2025-001234',
            notas: 'Fraccionamiento a 12 meses',
            fechaRegistro: '2025-08-15T08:00:00'
        },
        {
            id: 5,
            tipo: 'ingreso',
            clasificacion: 'empresarial',
            ruc: '20456789123',
            razonSocial: 'Comercial Lopez E.I.R.L.',
            concepto: 'Venta de servicios - contrato mensual',
            montoTotal: 3500,
            numCuotas: 1,
            montoCuota: 3500,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-10-22',
            fechaVencimiento: '2025-10-22',
            categoria: 'servicio',
            numResolucion: '',
            notas: 'Pago al contado',
            fechaRegistro: '2025-10-22T16:00:00'
        },
        {
            id: 6,
            tipo: 'egreso',
            clasificacion: 'personal',
            ruc: '',
            razonSocial: 'Banco de Crédito',
            concepto: 'Préstamo personal',
            montoTotal: 12000,
            numCuotas: 12,
            montoCuota: 1000,
            frecuenciaCuotas: 'mensual',
            fechaPrimeraCuota: '2025-10-15',
            fechaVencimiento: '2025-10-15',
            categoria: 'credito',
            numResolucion: '',
            notas: 'Crédito personal a 12 meses',
            fechaRegistro: '2025-09-15T10:00:00'
        }
    ];

    transacciones = ejemplos;
    localStorage.setItem('transacciones', JSON.stringify(transacciones));

    // Generar cuotas para las transacciones de ejemplo
    cuotas = [];
    ejemplos.forEach(t => {
        if (t.numCuotas > 1) {
            for (let i = 0; i < t.numCuotas; i++) {
                const fechaVencimiento = calcularFechaCuota(t.fechaPrimeraCuota, i, t.frecuenciaCuotas);
                const fechaVenc = new Date(fechaVencimiento);
                const hoy = new Date();

                // Marcar como pagadas las cuotas anteriores al mes actual
                const pagada = fechaVenc < new Date('2025-10-01');

                cuotas.push({
                    id: Date.now() + (t.id * 100) + i,
                    transaccionId: t.id,
                    numeroCuota: i + 1,
                    totalCuotas: t.numCuotas,
                    monto: t.montoCuota,
                    fechaVencimiento: fechaVencimiento,
                    pagada: pagada,
                    concepto: t.concepto,
                    razonSocial: t.razonSocial,
                    tipo: t.tipo,
                    clasificacion: t.clasificacion
                });
            }
        } else {
            // Cuota única
            cuotas.push({
                id: Date.now() + (t.id * 100),
                transaccionId: t.id,
                numeroCuota: 1,
                totalCuotas: 1,
                monto: t.montoTotal,
                fechaVencimiento: t.fechaPrimeraCuota,
                pagada: new Date(t.fechaPrimeraCuota) < new Date('2025-10-28'),
                concepto: t.concepto,
                razonSocial: t.razonSocial,
                tipo: t.tipo,
                clasificacion: t.clasificacion
            });
        }
    });

    localStorage.setItem('cuotas', JSON.stringify(cuotas));
}// Inicializar dashboard
actualizarDashboard();
