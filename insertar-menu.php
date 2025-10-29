<?php
require("config/conexion.php");

// Obtener el siguiente orden para el módulo
$sqlOrden = "SELECT MAX(orden) as max_orden FROM modulos";
$resultOrden = mysqli_query($conexion, $sqlOrden);
$rowOrden = mysqli_fetch_assoc($resultOrden);
$siguienteOrden = ($rowOrden['max_orden'] ?? 0) + 1;

// Insertar módulo
$sqlModulo = "INSERT INTO modulos (nombre_modulo, icono, orden, estado) VALUES ('Flujo de Caja', 'ri-money-dollar-circle-line', $siguienteOrden, 'A')";
echo "Insertando módulo...<br>";
if (mysqli_query($conexion, $sqlModulo)) {
    $idModulo = mysqli_insert_id($conexion);
    echo "✅ Módulo insertado con ID: $idModulo<br>";

    // Insertar submenús
    $subMenus = [
        ['Dashboard Financiero', 'dashboard-ingresos-egresos.php'],
        ['Registrar Movimiento', 'registrar-movimiento.php'],
        ['Listado de Movimientos', 'listado-movimientos.php'],
        ['Alertas de Pagos', 'alertas-pagos.php'],
        ['Cuotas Pendientes', 'cuotas-pendientes.php']
    ];

    foreach ($subMenus as $subMenu) {
        $sqlSub = "INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) VALUES ($idModulo, '{$subMenu[0]}', '{$subMenu[1]}', 'A')";
        if (mysqli_query($conexion, $sqlSub)) {
            echo "✅ Submenú '{$subMenu[0]}' insertado<br>";
        } else {
            echo "❌ Error insertando submenú '{$subMenu[0]}': " . mysqli_error($conexion) . "<br>";
        }
    }
} else {
    echo "❌ Error insertando módulo: " . mysqli_error($conexion) . "<br>";
}

echo "<br>Proceso completado.";
