// Listado de Movimientos
let tablaMovimientos;
let modalVerCuotas;

document.addEventListener('DOMContentLoaded', function () {
    modalVerCuotas = new bootstrap.Modal(document.getElementById('modalVerCuotas'));
    cargarMovimientos();

    // Event delegation para ver cuotas
    document.getElementById('tbody-movimientos').addEventListener('click', function (e) {
        if (e.target.closest('.btn-ver-cuotas')) {
            const idMovimiento = parseInt(e.target.closest('.btn-ver-cuotas').dataset.id);
            verCuotas(idMovimiento);
        }
    });

    // Event delegation para marcar cuotas como pagadas desde el modal
    document.getElementById('tbody-cuotas').addEventListener('click', function (e) {
        if (e.target.closest('.marcar-pagada-modal')) {
            const idCuota = parseInt(e.target.closest('.marcar-pagada-modal').dataset.id);
            marcarCuotaComoPagada(idCuota);
        }
    });
});

function cargarMovimientos() {
    const datos = obtenerDatosTemporales();
    const tbody = document.getElementById('tbody-movimientos');

    // Ordenar por fecha descendente
    const movimientosOrdenados = datos.movimientos
        .filter(m => m.estado === 'A')
        .sort((a, b) => new Date(b.fecha_creacion) - new Date(a.fecha_creacion));

    let html = '';
    movimientosOrdenados.forEach(mov => {
        // Badge para tipo
        const badgeTipo = mov.tipo === 'INGRESO'
            ? '<span class="badge bg-success">INGRESO</span>'
            : '<span class="badge bg-danger">EGRESO</span>';

        // Badge para clasificación
        const badgeClasif = mov.clasificacion === 'EMPRESARIAL'
            ? '<span class="badge bg-primary">EMPRESARIAL</span>'
            : '<span class="badge bg-info">PERSONAL</span>';

        // Badge para estado
        const badgeEstado = mov.estado === 'A'
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-secondary">Inactivo</span>';

        const rucDisplay = mov.ruc || '-';
        const razonDisplay = mov.razon_social || '-';
        const conceptoCorto = mov.concepto.length > 50
            ? mov.concepto.substring(0, 50) + '...'
            : mov.concepto;
        const categoriaDisplay = mov.categoria
            ? mov.categoria.replace(/_/g, ' ')
            : '-';

        html += `
            <tr>
                <td>${formatearFechaDisplay(mov.fecha_creacion)}</td>
                <td>${badgeTipo}</td>
                <td>${badgeClasif}</td>
                <td>${rucDisplay}</td>
                <td>${razonDisplay}</td>
                <td title="${mov.concepto}">${conceptoCorto}</td>
                <td>${categoriaDisplay}</td>
                <td>S/ ${formatearNumero(mov.monto_total)}</td>
                <td class="text-center">${mov.numero_cuotas}</td>
                <td>${badgeEstado}</td>
                <td>
                    <button class="btn btn-sm btn-outline-info btn-ver-cuotas" data-id="${mov.id}" title="Ver Cuotas">
                        <i class="ri-list-check"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;

    // Inicializar o actualizar DataTable
    if ($.fn.DataTable.isDataTable('#tabla-movimientos')) {
        tablaMovimientos.destroy();
    }

    tablaMovimientos = $('#tabla-movimientos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: 'Copiar',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'csv',
                text: 'CSV',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'excel',
                text: 'Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'landscape',
                pageSize: 'A4',
                className: 'btn btn-danger btn-sm',
                customize: function (doc) {
                    doc.content[0].text = 'Listado de Movimientos Financieros';
                    doc.content[0].alignment = 'center';
                    doc.styles.tableHeader = {
                        bold: true,
                        fontSize: 9,
                        color: 'white',
                        fillColor: '#0d6efd'
                    };
                    doc.defaultStyle.fontSize = 8;
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-info btn-sm'
            }
        ],
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        order: [[0, 'desc']],
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
            }
        },
        columnDefs: [
            { targets: 10, orderable: false }
        ]
    });
}

function verCuotas(idMovimiento) {
    const datos = obtenerDatosTemporales();
    const movimiento = datos.movimientos.find(m => m.id === idMovimiento);

    if (!movimiento) {
        alert('Movimiento no encontrado');
        return;
    }

    // Mostrar información del movimiento
    const badgeTipo = movimiento.tipo === 'INGRESO'
        ? '<span class="badge bg-success">INGRESO</span>'
        : '<span class="badge bg-danger">EGRESO</span>';

    const infoHtml = `
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="mb-2">${movimiento.razon_social || 'Sin especificar'} ${badgeTipo}</h6>
                <p class="mb-1"><strong>Concepto:</strong> ${movimiento.concepto}</p>
                <p class="mb-1"><strong>Monto Total:</strong> S/ ${formatearNumero(movimiento.monto_total)}</p>
                <p class="mb-0"><strong>Total de Cuotas:</strong> ${movimiento.numero_cuotas}</p>
            </div>
        </div>
    `;

    document.getElementById('info-movimiento').innerHTML = infoHtml;

    // Cargar cuotas
    const cuotas = obtenerCuotasMovimiento(idMovimiento);
    const tbodyCuotas = document.getElementById('tbody-cuotas');

    let htmlCuotas = '';
    cuotas.forEach(cuota => {
        const badgeEstado = cuota.estado === 'PAGADA'
            ? '<span class="badge bg-success">PAGADA</span>'
            : '<span class="badge bg-warning text-dark">PENDIENTE</span>';

        const fechaPago = cuota.fecha_pago ? formatearFechaDisplay(cuota.fecha_pago) : '-';

        htmlCuotas += `
            <tr>
                <td>${cuota.numero_cuota}/${movimiento.numero_cuotas}</td>
                <td>${formatearFechaDisplay(cuota.fecha_vencimiento)}</td>
                <td>S/ ${formatearNumero(cuota.monto_cuota)}</td>
                <td>${badgeEstado}</td>
                <td>${fechaPago}</td>
                <td>
                    ${cuota.estado === 'PENDIENTE'
                ? `<button class="btn btn-sm btn-success marcar-pagada-modal" data-id="${cuota.id_cuota}">
                               <i class="ri-check-line"></i> Marcar Pagada
                           </button>`
                : '<span class="text-muted">-</span>'
            }
                </td>
            </tr>
        `;
    });

    tbodyCuotas.innerHTML = htmlCuotas;

    // Mostrar modal
    modalVerCuotas.show();
}

function marcarCuotaComoPagada(idCuota) {
    if (!confirm('¿Confirma que esta cuota ha sido pagada/recibida?')) {
        return;
    }

    const resultado = marcarCuotaPagada(idCuota);

    if (resultado.success) {
        alert('Cuota marcada como pagada exitosamente.');

        // Recargar la tabla del modal
        const datos = obtenerDatosTemporales();
        const cuota = datos.cuotas.find(c => c.id_cuota === idCuota);
        if (cuota) {
            verCuotas(cuota.id_movimiento);
        }

        // Actualizar tabla principal (opcional, por si tienen cambios visuales)
        cargarMovimientos();
    } else {
        alert('Error: ' + resultado.mensaje);
    }
}
