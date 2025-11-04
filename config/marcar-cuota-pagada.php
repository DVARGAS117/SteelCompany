<?php
require("conexion.php");

header('Content-Type: application/json');

$id_cuota = isset($_POST['id_cuota']) ? intval($_POST['id_cuota']) : 0;

if ($id_cuota == 0) {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'ID de cuota no proporcionado'
    ));
    exit;
}

// Verificar si la cuota existe y su estado actual
$sqlVerificar = "SELECT estado FROM cuotas_movimientos WHERE id_cuota = $id_cuota";
$resultado = mysqli_query($conexion, $sqlVerificar);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'La cuota no existe'
    ));
    exit;
}

$cuota = mysqli_fetch_assoc($resultado);

// Validar que no esté ya pagada
if ($cuota['estado'] === 'PAGADA') {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'Esta cuota ya fue registrada como pagada anteriormente'
    ));
    exit;
}

// Actualizar el estado de la cuota a PAGADA
$fecha_pago = date('Y-m-d');
$fecha_actualizacion = date('Y-m-d H:i:s');

$sqlActualizar = "UPDATE cuotas_movimientos 
                  SET estado = 'PAGADA', 
                      fecha_pago = '$fecha_pago',
                      fecha_actualizacion = '$fecha_actualizacion'
                  WHERE id_cuota = $id_cuota";

if (mysqli_query($conexion, $sqlActualizar)) {
    echo json_encode(array(
        'success' => true,
        'mensaje' => 'Cuota marcada como pagada exitosamente'
    ));
} else {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'Error al actualizar la cuota: ' . mysqli_error($conexion)
    ));
}
