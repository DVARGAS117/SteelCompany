<?php
require("conexion.php");

header('Content-Type: application/json');

$cuenta = isset($_POST['cuenta']) ? $_POST['cuenta'] : 'todas';
$mes = isset($_POST['mes']) ? $_POST['mes'] : date('Y-m');

// Extraer año y mes
list($anio, $numMes) = explode('-', $mes);

// ============================================================
// CÁLCULO DE INGRESOS Y EGRESOS BASADO EN CUOTAS PAGADAS
// ============================================================
// IMPORTANTE: Solo se cuentan las cuotas con estado = 'PAGADA'
// No importa si la fecha ya pasó, el monto solo afecta cuando se marca como pagada
// ============================================================

// Construir filtro de clasificación
$filtroClasificacion = '';
if ($cuenta !== 'todas') {
    $filtroClasificacion = " AND m.clasificacion = '$cuenta'";
}

// Calcular INGRESOS (suma de cuotas PAGADAS de tipo INGRESO)
$sqlIngresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
                FROM cuotas_movimientos c
                INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                WHERE m.tipo = 'INGRESO'
                  AND c.estado = 'PAGADA'
                  AND YEAR(c.fecha_pago) = $anio
                  AND MONTH(c.fecha_pago) = $numMes
                  AND m.estado = 'A'
                  $filtroClasificacion";

$resultIngresos = mysqli_query($conexion, $sqlIngresos);
$rowIngresos = mysqli_fetch_assoc($resultIngresos);
$totalIngresos = floatval($rowIngresos['total']);

// Calcular EGRESOS (suma de cuotas PAGADAS de tipo EGRESO)
$sqlEgresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
               FROM cuotas_movimientos c
               INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
               WHERE m.tipo = 'EGRESO'
                 AND c.estado = 'PAGADA'
                 AND YEAR(c.fecha_pago) = $anio
                 AND MONTH(c.fecha_pago) = $numMes
                 AND m.estado = 'A'
                 $filtroClasificacion";

$resultEgresos = mysqli_query($conexion, $sqlEgresos);
$rowEgresos = mysqli_fetch_assoc($resultEgresos);
$totalEgresos = floatval($rowEgresos['total']);

// Calcular SALDO NETO
$saldoNeto = $totalIngresos - $totalEgresos;

// ============================================================
// DESGLOSE POR CLASIFICACIÓN (EMPRESARIAL Y PERSONAL)
// ============================================================

// Solo calcular desglose si el filtro es "todas"
$empresarial = 0;
$personal = 0;

if ($cuenta === 'todas') {
    // Calcular neto EMPRESARIAL (ingresos - egresos)
    $sqlEmpresarialIngresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
                               FROM cuotas_movimientos c
                               INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                               WHERE m.tipo = 'INGRESO'
                                 AND m.clasificacion = 'EMPRESARIAL'
                                 AND c.estado = 'PAGADA'
                                 AND YEAR(c.fecha_pago) = $anio
                                 AND MONTH(c.fecha_pago) = $numMes
                                 AND m.estado = 'A'";

    $sqlEmpresarialEgresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
                              FROM cuotas_movimientos c
                              INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                              WHERE m.tipo = 'EGRESO'
                                AND m.clasificacion = 'EMPRESARIAL'
                                AND c.estado = 'PAGADA'
                                AND YEAR(c.fecha_pago) = $anio
                                AND MONTH(c.fecha_pago) = $numMes
                                AND m.estado = 'A'";

    $resultEmpIng = mysqli_query($conexion, $sqlEmpresarialIngresos);
    $rowEmpIng = mysqli_fetch_assoc($resultEmpIng);
    $empresarialIngresos = floatval($rowEmpIng['total']);

    $resultEmpEgr = mysqli_query($conexion, $sqlEmpresarialEgresos);
    $rowEmpEgr = mysqli_fetch_assoc($resultEmpEgr);
    $empresarialEgresos = floatval($rowEmpEgr['total']);

    $empresarial = $empresarialIngresos - $empresarialEgresos;

    // Calcular neto PERSONAL (ingresos - egresos)
    $sqlPersonalIngresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
                            FROM cuotas_movimientos c
                            INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                            WHERE m.tipo = 'INGRESO'
                              AND m.clasificacion = 'PERSONAL'
                              AND c.estado = 'PAGADA'
                              AND YEAR(c.fecha_pago) = $anio
                              AND MONTH(c.fecha_pago) = $numMes
                              AND m.estado = 'A'";

    $sqlPersonalEgresos = "SELECT COALESCE(SUM(c.monto_cuota), 0) as total
                           FROM cuotas_movimientos c
                           INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                           WHERE m.tipo = 'EGRESO'
                             AND m.clasificacion = 'PERSONAL'
                             AND c.estado = 'PAGADA'
                             AND YEAR(c.fecha_pago) = $anio
                             AND MONTH(c.fecha_pago) = $numMes
                             AND m.estado = 'A'";

    $resultPersIng = mysqli_query($conexion, $sqlPersonalIngresos);
    $rowPersIng = mysqli_fetch_assoc($resultPersIng);
    $personalIngresos = floatval($rowPersIng['total']);

    $resultPersEgr = mysqli_query($conexion, $sqlPersonalEgresos);
    $rowPersEgr = mysqli_fetch_assoc($resultPersEgr);
    $personalEgresos = floatval($rowPersEgr['total']);

    $personal = $personalIngresos - $personalEgresos;
} else {
    // Si hay filtro específico, mostrar solo ese
    if ($cuenta === 'EMPRESARIAL') {
        $empresarial = $saldoNeto;
    } else {
        $personal = $saldoNeto;
    }
}

// ============================================================
// ÚLTIMAS TRANSACCIONES (últimos 10 movimientos)
// ============================================================

$sqlUltimas = "SELECT m.*, DATE_FORMAT(m.fecha_creacion, '%d/%m/%Y') as fecha
               FROM ingresos_egresos m
               WHERE m.estado = 'A'
                 $filtroClasificacion
               ORDER BY m.fecha_creacion DESC
               LIMIT 10";

$resultUltimas = mysqli_query($conexion, $sqlUltimas);
$ultimasTransacciones = array();

while ($row = mysqli_fetch_assoc($resultUltimas)) {
    $ultimasTransacciones[] = array(
        'id_movimiento' => $row['id_movimiento'],
        'tipo' => $row['tipo'],
        'clasificacion' => $row['clasificacion'],
        'razon_social' => $row['razon_social'] ? $row['razon_social'] : 'Sin especificar',
        'concepto' => $row['concepto'],
        'monto_total' => $row['monto_total'],
        'fecha' => $row['fecha']
    );
}

// ============================================================
// CUOTAS PENDIENTES (próximas a vencer)
// ============================================================

$sqlCuotasPendientes = "SELECT 
                            c.id_cuota,
                            c.numero_cuota,
                            c.monto_cuota,
                            c.fecha_vencimiento,
                            m.tipo,
                            m.clasificacion,
                            m.razon_social,
                            m.concepto,
                            m.numero_cuotas as total_cuotas,
                            DATEDIFF(c.fecha_vencimiento, CURDATE()) as dias_restantes
                        FROM cuotas_movimientos c
                        INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
                        WHERE c.estado = 'PENDIENTE'
                          AND m.estado = 'A'
                          $filtroClasificacion
                        ORDER BY c.fecha_vencimiento ASC
                        LIMIT 20";

$resultCuotas = mysqli_query($conexion, $sqlCuotasPendientes);
$cuotasPendientes = array();

while ($row = mysqli_fetch_assoc($resultCuotas)) {
    $cuotasPendientes[] = array(
        'id_cuota' => $row['id_cuota'],
        'numero_cuota' => $row['numero_cuota'],
        'total_cuotas' => $row['total_cuotas'],
        'monto_cuota' => $row['monto_cuota'],
        'fecha_vencimiento' => date('d/m/Y', strtotime($row['fecha_vencimiento'])),
        'dias_restantes' => intval($row['dias_restantes']),
        'tipo' => $row['tipo'],
        'clasificacion' => $row['clasificacion'],
        'razon_social' => $row['razon_social'] ? $row['razon_social'] : 'Sin especificar',
        'concepto' => $row['concepto']
    );
}

// ============================================================
// RESPUESTA JSON
// ============================================================

$response = array(
    'success' => true,
    'total_ingresos' => $totalIngresos,
    'total_egresos' => $totalEgresos,
    'saldo_neto' => $saldoNeto,
    'empresarial' => $empresarial,
    'personal' => $personal,
    'ultimas_transacciones' => $ultimasTransacciones,
    'cuotas_pendientes' => $cuotasPendientes
);

echo json_encode($response);
