<?php
// Iniciar sesión y conexión
require("../config/conexion.php");
require("../config/inicializar-datos.php");

// Verificar que se recibió el ID del movimiento
if (!isset($_POST['id_movimiento']) || empty($_POST['id_movimiento'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de movimiento no proporcionado'
    ]);
    exit;
}

$id_movimiento = intval($_POST['id_movimiento']);

// Obtener información del movimiento principal
$sqlMovimiento = "SELECT * FROM ingresos_egresos WHERE id_movimiento = $id_movimiento";
$resultMovimiento = mysqli_query($conexion, $sqlMovimiento);

if (!$resultMovimiento || mysqli_num_rows($resultMovimiento) == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Movimiento no encontrado'
    ]);
    exit;
}

$movimiento = mysqli_fetch_assoc($resultMovimiento);

// Obtener las cuotas asociadas al movimiento
$sqlCuotas = "SELECT * FROM cuotas_movimientos 
              WHERE id_movimiento = $id_movimiento 
              ORDER BY numero_cuota ASC";
$resultCuotas = mysqli_query($conexion, $sqlCuotas);

$cuotas = [];
while ($cuota = mysqli_fetch_assoc($resultCuotas)) {
    $cuotas[] = $cuota;
}

// Preparar respuesta
$response = [
    'success' => true,
    'movimiento' => $movimiento,
    'cuotas' => $cuotas
];

echo json_encode($response);
?>
