// Registrar Movimiento
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-movimiento');
    const habilitarCuotas = document.getElementById('habilitar_cuotas');
    const cuotasRow = document.getElementById('cuotas-row');
    const fechaPagoUnicoRow = document.getElementById('fecha-pago-unico-row');
    const categoria = document.getElementById('categoria');
    const resolucionGroup = document.getElementById('resolucion-group');
    const rucInput = document.getElementById('ruc');
    const razonSocialInput = document.getElementById('razon_social');
    const clasificacion = document.getElementById('clasificacion');

    // Manejar checkbox de cuotas
    habilitarCuotas.addEventListener('change', function () {
        if (this.checked) {
            cuotasRow.style.display = 'flex';
            fechaPagoUnicoRow.style.display = 'none';
            document.getElementById('numero_cuotas').value = 2;
        } else {
            cuotasRow.style.display = 'none';
            fechaPagoUnicoRow.style.display = 'flex';
            document.getElementById('numero_cuotas').value = 1;
        }
    });

    // Mostrar/ocultar campo de resolución
    categoria.addEventListener('change', function () {
        if (this.value === 'FRACCIONAMIENTO_SUNAT') {
            resolucionGroup.style.display = 'block';
        } else {
            resolucionGroup.style.display = 'none';
        }
    });

    // Autocompletar RUC (simulado)
    rucInput.addEventListener('blur', function () {
        const ruc = this.value.trim();
        if (ruc === '') {
            razonSocialInput.value = '';
            return;
        }

        // Simular búsqueda de RUC
        const datos = obtenerDatosTemporales();
        const movimientoExistente = datos.movimientos.find(m => m.ruc === ruc);

        if (movimientoExistente) {
            razonSocialInput.value = movimientoExistente.razon_social;
        } else {
            // RUCs de ejemplo para demostración
            const ejemplosRUC = {
                '20123456789': 'ACEROS DEL PERÚ S.A.C.',
                '20987654321': 'CONSTRUCTORA LOS ANDES E.I.R.L.',
                '20555666777': 'INMOBILIARIA PACIFIC S.A.',
                '20111222333': 'INDUSTRIAS METALÚRGICAS S.A.',
                '20444555666': 'COMERCIAL FERRETEK S.A.C.'
            };

            if (ejemplosRUC[ruc]) {
                razonSocialInput.value = ejemplosRUC[ruc];
            }
        }
    });

    // Enviar formulario
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const clasificacionVal = clasificacion.value;
        const rucVal = rucInput.value.trim();
        const razonSocialVal = razonSocialInput.value.trim();

        // Validación: Si es empresarial, RUC y razón social son obligatorios
        if (clasificacionVal === 'EMPRESARIAL') {
            if (rucVal === '') {
                alert('Para transacciones empresariales, el RUC es obligatorio.');
                rucInput.focus();
                return;
            }
            if (razonSocialVal === '') {
                alert('La razón social no puede estar vacía para transacciones empresariales.');
                razonSocialInput.focus();
                return;
            }
        }

        // Recopilar datos del formulario
        const datos = obtenerDatosTemporales();

        const nuevoMovimiento = {
            id: datos.nextId++,
            fecha_creacion: new Date().toISOString().split('T')[0],
            tipo: document.getElementById('tipo').value,
            clasificacion: clasificacionVal,
            ruc: rucVal,
            razon_social: razonSocialVal,
            concepto: document.getElementById('concepto').value,
            categoria: categoria.value,
            monto_total: parseFloat(document.getElementById('monto_total').value),
            numero_cuotas: habilitarCuotas.checked ? parseInt(document.getElementById('numero_cuotas').value) : 1,
            frecuencia_cuotas: habilitarCuotas.checked ? document.getElementById('frecuencia_cuotas').value : 'MENSUAL',
            fecha_primera_cuota: habilitarCuotas.checked
                ? document.getElementById('fecha_primera_cuota').value
                : document.getElementById('fecha_pago_unico').value,
            numero_resolucion: document.getElementById('numero_resolucion').value,
            notas: document.getElementById('notas').value,
            estado: 'A'
        };

        // Agregar movimiento
        datos.movimientos.push(nuevoMovimiento);

        // Generar cuotas
        const cuotas = generarCuotas(nuevoMovimiento);
        datos.cuotas.push(...cuotas);

        // Guardar
        guardarDatosTemporales(datos);

        alert('Movimiento guardado exitosamente.');

        // Redirigir al listado
        window.location.href = 'listado-movimientos.html';
    });

    // Establecer fecha mínima como hoy
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_pago_unico').value = hoy;
    document.getElementById('fecha_primera_cuota').value = hoy;
});
