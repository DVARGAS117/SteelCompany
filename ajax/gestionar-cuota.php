<?php
// Iniciar sesión y conexión
require("../config/conexion.php");
require("../config/inicializar-datos.php");

// Verificar que se recibieron los datos necesarios
if (!isset($_POST['accion']) || !isset($_POST['id_cuota'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$accion = $_POST['accion'];
$id_cuota = intval($_POST['id_cuota']);
$fecha_actualizacion = date('Y-m-d H:i:s');
$cod_personal = $_SESSION['cod_personal'];

// Obtener información de la cuota actual
$sqlCuota = "SELECT c.*, m.monto_total 
             FROM cuotas_movimientos c
             INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
             WHERE c.id_cuota = $id_cuota";
$resultCuota = mysqli_query($conexion, $sqlCuota);

if (!$resultCuota || mysqli_num_rows($resultCuota) == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Cuota no encontrada'
    ]);
    exit;
}

$cuotaActual = mysqli_fetch_assoc($resultCuota);
$id_movimiento = $cuotaActual['id_movimiento'];

switch ($accion) {
    case 'editar':
        // Editar el monto de la cuota
        if (!isset($_POST['nuevo_monto']) || empty($_POST['nuevo_monto'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Nuevo monto no proporcionado'
            ]);
            exit;
        }
        
        $nuevo_monto = floatval($_POST['nuevo_monto']);
        
        if ($nuevo_monto <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'El monto debe ser mayor a cero'
            ]);
            exit;
        }
        
        // Actualizar el monto de la cuota
        $sqlUpdate = "UPDATE cuotas_movimientos 
                      SET monto_cuota = $nuevo_monto,
                          fecha_actualizacion = '$fecha_actualizacion',
                          cod_personal = $cod_personal
                      WHERE id_cuota = $id_cuota";
        
        if (mysqli_query($conexion, $sqlUpdate)) {
            // Calcular el nuevo monto total sumando todas las cuotas
            $sqlSumaCuotas = "SELECT SUM(monto_cuota) as total_cuotas 
                             FROM cuotas_movimientos 
                             WHERE id_movimiento = $id_movimiento";
            $resultSuma = mysqli_query($conexion, $sqlSumaCuotas);
            $suma = mysqli_fetch_assoc($resultSuma);
            $nuevo_monto_total = $suma['total_cuotas'];
            
            // Actualizar el monto total del movimiento
            $sqlUpdateMovimiento = "UPDATE ingresos_egresos 
                                   SET monto_total = $nuevo_monto_total,
                                       fecha_actualizacion = '$fecha_actualizacion'
                                   WHERE id_movimiento = $id_movimiento";
            mysqli_query($conexion, $sqlUpdateMovimiento);
            
            echo json_encode([
                'success' => true,
                'message' => 'Monto de cuota actualizado correctamente',
                'nuevo_monto_total' => $nuevo_monto_total
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar la cuota: ' . mysqli_error($conexion)
            ]);
        }
        break;
        
    case 'pagar':
        // Marcar cuota como pagada
        if ($cuotaActual['estado'] == 'PAGADA') {
            echo json_encode([
                'success' => false,
                'message' => 'Esta cuota ya está marcada como pagada'
            ]);
            exit;
        }
        
        $fecha_pago = date('Y-m-d');
        
        $sqlUpdate = "UPDATE cuotas_movimientos 
                      SET estado = 'PAGADA',
                          fecha_pago = '$fecha_pago',
                          fecha_actualizacion = '$fecha_actualizacion',
                          cod_personal = $cod_personal
                      WHERE id_cuota = $id_cuota";
        
        if (mysqli_query($conexion, $sqlUpdate)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cuota marcada como pagada correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar la cuota: ' . mysqli_error($conexion)
            ]);
        }
        break;
        
    case 'revertir':
        // Revertir cuota pagada a pendiente
        if ($cuotaActual['estado'] != 'PAGADA') {
            echo json_encode([
                'success' => false,
                'message' => 'Solo se pueden revertir cuotas pagadas'
            ]);
            exit;
        }
        
        // Verificar si está vencida
        $fecha_actual = date('Y-m-d');
        $estado_nuevo = ($cuotaActual['fecha_vencimiento'] < $fecha_actual) ? 'VENCIDA' : 'PENDIENTE';
        
        $sqlUpdate = "UPDATE cuotas_movimientos 
                      SET estado = '$estado_nuevo',
                          fecha_pago = NULL,
                          fecha_actualizacion = '$fecha_actualizacion',
                          cod_personal = $cod_personal
                      WHERE id_cuota = $id_cuota";
        
        if (mysqli_query($conexion, $sqlUpdate)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cuota revertida a estado ' . $estado_nuevo . ' correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al revertir la cuota: ' . mysqli_error($conexion)
            ]);
        }
        break;
        
    case 'eliminar':
        // Eliminar cuota
        $sqlDelete = "DELETE FROM cuotas_movimientos WHERE id_cuota = $id_cuota";
        
        if (mysqli_query($conexion, $sqlDelete)) {
            // Calcular el nuevo monto total sumando las cuotas restantes
            $sqlSumaCuotas = "SELECT SUM(monto_cuota) as total_cuotas, COUNT(*) as total_cuotas_restantes
                             FROM cuotas_movimientos 
                             WHERE id_movimiento = $id_movimiento";
            $resultSuma = mysqli_query($conexion, $sqlSumaCuotas);
            $suma = mysqli_fetch_assoc($resultSuma);
            $nuevo_monto_total = $suma['total_cuotas'] ?? 0;
            $cuotas_restantes = $suma['total_cuotas_restantes'];
            
            // Actualizar el movimiento principal
            $sqlUpdateMovimiento = "UPDATE ingresos_egresos 
                                   SET monto_total = $nuevo_monto_total,
                                       numero_cuotas = $cuotas_restantes,
                                       fecha_actualizacion = '$fecha_actualizacion'
                                   WHERE id_movimiento = $id_movimiento";
            mysqli_query($conexion, $sqlUpdateMovimiento);
            
            echo json_encode([
                'success' => true,
                'message' => 'Cuota eliminada correctamente',
                'nuevo_monto_total' => $nuevo_monto_total,
                'cuotas_restantes' => $cuotas_restantes
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar la cuota: ' . mysqli_error($conexion)
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Acción no válida'
        ]);
        break;
}
?>
