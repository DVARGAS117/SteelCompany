<?php
require("conexion.php");

header('Content-Type: application/json');

$ruc = trim($_POST['ruc']);

if (empty($ruc)) {
    echo json_encode(array('success' => false, 'mensaje' => 'RUC no proporcionado'));
    exit;
}

// Consultar en tabla clientes
$sql = "SELECT nombres FROM clientes WHERE num_documento = '$ruc' AND estado = 'A' LIMIT 1";
$resultado = mysqli_query($conexion, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    echo json_encode(array(
        'success' => true,
        'razon_social' => $fila['nombres']
    ));
} else {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'RUC no encontrado en la base de datos'
    ));
}
