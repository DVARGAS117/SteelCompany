// DATOS TEMPORALES - SIMULACIÓN DE BASE DE DATOS
// Estos datos se pierden al recargar la página

// Función para obtener datos del localStorage o inicializar
function obtenerDatosTemporales() {
    let datos = localStorage.getItem('datosFlujoCaja');
    if (datos) {
        return JSON.parse(datos);
    } else {
        // Datos de ejemplo iniciales
        return {
            movimientos: [
                {
                    id: 1,
                    fecha_creacion: '2025-10-15',
                    tipo: 'INGRESO',
                    clasificacion: 'EMPRESARIAL',
                    ruc: '20123456789',
                    razon_social: 'ACEROS DEL PERÚ S.A.C.',
                    concepto: 'Venta de vigas de acero estructural',
                    categoria: 'VENTA',
                    monto_total: 15000.00,
                    numero_cuotas: 3,
                    frecuencia_cuotas: 'MENSUAL',
                    fecha_primera_cuota: '2025-10-30',
                    notas: 'Cliente preferencial',
                    estado: 'A'
                },
                {
                    id: 2,
                    fecha_creacion: '2025-10-18',
                    tipo: 'EGRESO',
                    clasificacion: 'EMPRESARIAL',
                    ruc: '20987654321',
                    razon_social: 'CONSTRUCTORA LOS ANDES E.I.R.L.',
                    concepto: 'Compra de materia prima - láminas de acero',
                    categoria: 'COMPRA',
                    monto_total: 8500.00,
                    numero_cuotas: 2,
                    frecuencia_cuotas: 'QUINCENAL',
                    fecha_primera_cuota: '2025-10-25',
                    notas: '',
                    estado: 'A'
                },
                {
                    id: 3,
                    fecha_creacion: '2025-10-20',
                    tipo: 'EGRESO',
                    clasificacion: 'EMPRESARIAL',
                    ruc: '',
                    razon_social: 'Luz del Sur',
                    concepto: 'Pago de energía eléctrica - Octubre 2025',
                    categoria: 'SERVICIOS_BASICOS',
                    monto_total: 1250.00,
                    numero_cuotas: 1,
                    frecuencia_cuotas: 'MENSUAL',
                    fecha_primera_cuota: '2025-10-28',
                    notas: 'Pago mensual de servicio',
                    estado: 'A'
                },
                {
                    id: 4,
                    fecha_creacion: '2025-10-22',
                    tipo: 'INGRESO',
                    clasificacion: 'EMPRESARIAL',
                    ruc: '20555666777',
                    razon_social: 'INMOBILIARIA PACIFIC S.A.',
                    concepto: 'Venta de tubos y conexiones metálicas',
                    categoria: 'VENTA',
                    monto_total: 12800.00,
                    numero_cuotas: 4,
                    frecuencia_cuotas: 'MENSUAL',
                    fecha_primera_cuota: '2025-11-05',
                    notas: 'Proyecto Torre Azul',
                    estado: 'A'
                },
                {
                    id: 5,
                    fecha_creacion: '2025-10-25',
                    tipo: 'EGRESO',
                    clasificacion: 'PERSONAL',
                    ruc: '',
                    razon_social: 'Préstamo Personal',
                    concepto: 'Cuota mensual de préstamo personal',
                    categoria: 'CREDITO',
                    monto_total: 3000.00,
                    numero_cuotas: 6,
                    frecuencia_cuotas: 'MENSUAL',
                    fecha_primera_cuota: '2025-11-01',
                    notas: 'Banco Continental',
                    estado: 'A'
                }
            ],
            cuotas: [],
            nextId: 6
        };
    }
}

// Función para guardar datos en localStorage
function guardarDatosTemporales(datos) {
    localStorage.setItem('datosFlujoCaja', JSON.stringify(datos));
}

// Función para generar cuotas de un movimiento
function generarCuotas(movimiento) {
    const cuotas = [];
    const montoCuota = movimiento.monto_total / movimiento.numero_cuotas;
    let fechaActual = new Date(movimiento.fecha_primera_cuota);

    for (let i = 1; i <= movimiento.numero_cuotas; i++) {
        const fechaVencimiento = new Date(fechaActual);

        cuotas.push({
            id_cuota: Date.now() + i,
            id_movimiento: movimiento.id,
            numero_cuota: i,
            monto_cuota: parseFloat(montoCuota.toFixed(2)),
            fecha_vencimiento: formatearFecha(fechaVencimiento),
            estado: 'PENDIENTE',
            fecha_pago: null,
            fecha_creacion: new Date().toISOString()
        });

        // Calcular siguiente fecha según frecuencia
        switch (movimiento.frecuencia_cuotas) {
            case 'MENSUAL':
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                break;
            case 'QUINCENAL':
                fechaActual.setDate(fechaActual.getDate() + 15);
                break;
            case 'SEMANAL':
                fechaActual.setDate(fechaActual.getDate() + 7);
                break;
        }
    }

    return cuotas;
}

// Función para formatear fecha a YYYY-MM-DD
function formatearFecha(fecha) {
    const año = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, '0');
    const dia = String(fecha.getDate()).padStart(2, '0');
    return `${año}-${mes}-${dia}`;
}

// Función para formatear fecha a DD/MM/YYYY
function formatearFechaDisplay(fechaStr) {
    if (!fechaStr) return '-';
    const partes = fechaStr.split('-');
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

// Función para calcular días restantes
function calcularDiasRestantes(fechaVencimiento) {
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    const vencimiento = new Date(fechaVencimiento);
    vencimiento.setHours(0, 0, 0, 0);
    const diferencia = vencimiento - hoy;
    return Math.ceil(diferencia / (1000 * 60 * 60 * 24));
}

// Función para formatear números con 2 decimales y separadores
function formatearNumero(numero) {
    return parseFloat(numero).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Función para obtener todas las cuotas de un movimiento
function obtenerCuotasMovimiento(idMovimiento) {
    const datos = obtenerDatosTemporales();
    return datos.cuotas.filter(c => c.id_movimiento === idMovimiento);
}

// Función para marcar cuota como pagada
function marcarCuotaPagada(idCuota) {
    const datos = obtenerDatosTemporales();
    const cuota = datos.cuotas.find(c => c.id_cuota === idCuota);

    if (!cuota) {
        return { success: false, mensaje: 'Cuota no encontrada' };
    }

    if (cuota.estado === 'PAGADA') {
        return { success: false, mensaje: 'Esta cuota ya fue registrada como pagada' };
    }

    cuota.estado = 'PAGADA';
    cuota.fecha_pago = formatearFecha(new Date());

    guardarDatosTemporales(datos);

    return { success: true, mensaje: 'Cuota marcada como pagada exitosamente' };
}

// Inicializar cuotas al cargar
function inicializarCuotas() {
    const datos = obtenerDatosTemporales();

    // Solo generar cuotas si no existen
    if (datos.cuotas.length === 0) {
        datos.movimientos.forEach(mov => {
            const cuotas = generarCuotas(mov);
            datos.cuotas.push(...cuotas);
        });

        // Marcar algunas cuotas como pagadas para demostración
        if (datos.cuotas.length > 0) {
            // Marcar la primera cuota del primer movimiento como pagada
            if (datos.cuotas[0]) {
                datos.cuotas[0].estado = 'PAGADA';
                datos.cuotas[0].fecha_pago = '2025-10-30';
            }
            // Marcar la primera cuota del segundo movimiento como pagada
            if (datos.cuotas[3]) {
                datos.cuotas[3].estado = 'PAGADA';
                datos.cuotas[3].fecha_pago = '2025-10-25';
            }
        }

        guardarDatosTemporales(datos);
    }
}

// Inicializar al cargar el script
inicializarCuotas();
