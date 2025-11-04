<?php

/**
 * Script para exportar el esquema de la base de datos
 * Uso: Acceder desde el navegador a este archivo
 * Genera un archivo SQL con la estructura y datos de las tablas
 */

// Configuración de la base de datos
require("config/conexion.php");

// Nombre de la base de datos
$database = 'smartsteel';

// Tablas específicas a exportar (del módulo Flujo de Caja)
$tablasExportar = [
    'ingresos_egresos',
    'cuotas_movimientos'
];

// Nombre del archivo de salida
$fecha = date('Y-m-d_H-i-s');
$nombreArchivo = "backup_modulo_flujo_caja_{$fecha}.sql";

// Función para exportar tablas
function exportarTablas($conexion, $database, $tablas, $nombreArchivo)
{
    $contenidoSQL = "";
    $contenidoSQL .= "-- =====================================================\n";
    $contenidoSQL .= "-- BACKUP DE BASE DE DATOS - MÓDULO FLUJO DE CAJA\n";
    $contenidoSQL .= "-- Base de datos: {$database}\n";
    $contenidoSQL .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
    $contenidoSQL .= "-- =====================================================\n\n";
    $contenidoSQL .= "USE {$database};\n\n";

    foreach ($tablas as $tabla) {
        // Verificar si la tabla existe
        $checkTable = mysqli_query($conexion, "SHOW TABLES LIKE '{$tabla}'");
        if (mysqli_num_rows($checkTable) == 0) {
            $contenidoSQL .= "-- ADVERTENCIA: La tabla '{$tabla}' no existe en la base de datos\n\n";
            continue;
        }

        $contenidoSQL .= "-- =====================================================\n";
        $contenidoSQL .= "-- Tabla: {$tabla}\n";
        $contenidoSQL .= "-- =====================================================\n\n";

        // DROP TABLE
        $contenidoSQL .= "DROP TABLE IF EXISTS `{$tabla}`;\n\n";

        // CREATE TABLE
        $resultCreate = mysqli_query($conexion, "SHOW CREATE TABLE `{$tabla}`");
        if ($resultCreate) {
            $row = mysqli_fetch_array($resultCreate);
            $contenidoSQL .= $row[1] . ";\n\n";
        }

        // INSERT DATA
        $result = mysqli_query($conexion, "SELECT * FROM `{$tabla}`");
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            $contenidoSQL .= "-- Insertando {$numRows} registros en {$tabla}\n";

            while ($row = mysqli_fetch_assoc($result)) {
                $contenidoSQL .= "INSERT INTO `{$tabla}` (";

                // Nombres de columnas
                $columnas = array_keys($row);
                $contenidoSQL .= "`" . implode("`, `", $columnas) . "`";

                $contenidoSQL .= ") VALUES (";

                // Valores
                $valores = [];
                foreach ($row as $valor) {
                    if ($valor === null) {
                        $valores[] = "NULL";
                    } else {
                        $valores[] = "'" . mysqli_real_escape_string($conexion, $valor) . "'";
                    }
                }
                $contenidoSQL .= implode(", ", $valores);

                $contenidoSQL .= ");\n";
            }
            $contenidoSQL .= "\n";
        } else {
            $contenidoSQL .= "-- No hay datos en la tabla {$tabla}\n\n";
        }
    }

    // Guardar archivo
    $rutaArchivo = __DIR__ . "/BASE-DATOS/" . $nombreArchivo;

    // Crear directorio si no existe
    if (!is_dir(__DIR__ . "/BASE-DATOS/")) {
        mkdir(__DIR__ . "/BASE-DATOS/", 0777, true);
    }

    $archivo = fopen($rutaArchivo, 'w');
    if ($archivo) {
        fwrite($archivo, $contenidoSQL);
        fclose($archivo);
        return [
            'success' => true,
            'archivo' => $nombreArchivo,
            'ruta' => $rutaArchivo,
            'tamanio' => filesize($rutaArchivo)
        ];
    } else {
        return [
            'success' => false,
            'error' => 'No se pudo crear el archivo'
        ];
    }
}

// Ejecutar exportación
$resultado = exportarTablas($conexion, $database, $tablasExportar, $nombreArchivo);

// Cerrar conexión
mysqli_close($conexion);

// Mostrar resultado
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Esquema BD</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 40px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">
            <i class="ri-database-2-line"></i> Exportación de Base de Datos
        </h2>

        <?php if ($resultado['success']): ?>
            <div class="alert alert-success">
                <h4 class="alert-heading">✅ Exportación Exitosa</h4>
                <hr>
                <p><strong>Archivo generado:</strong> <?= $resultado['archivo'] ?></p>
                <p><strong>Ubicación:</strong> BASE-DATOS/<?= $resultado['archivo'] ?></p>
                <p><strong>Tamaño:</strong> <?= number_format($resultado['tamanio'] / 1024, 2) ?> KB</p>
                <hr>
                <div class="d-grid gap-2">
                    <a href="BASE-DATOS/<?= $resultado['archivo'] ?>"
                        class="btn btn-primary"
                        download>
                        <i class="ri-download-line"></i> Descargar Archivo SQL
                    </a>
                    <a href="listado-movimientos.php" class="btn btn-secondary">
                        Volver al Listado de Movimientos
                    </a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <strong>Tablas Exportadas</strong>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <?php foreach ($tablasExportar as $tabla): ?>
                            <li><?= $tabla ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-danger">
                <h4 class="alert-heading">❌ Error en la Exportación</h4>
                <p><?= $resultado['error'] ?></p>
            </div>
        <?php endif; ?>

        <div class="card mt-4">
            <div class="card-header bg-warning">
                <strong>⚠️ Información Importante</strong>
            </div>
            <div class="card-body">
                <ul>
                    <li>Este script exporta <strong>estructura y datos</strong> de las tablas del módulo Flujo de Caja</li>
                    <li>El archivo se guarda en la carpeta <code>BASE-DATOS/</code></li>
                    <li>Incluye comandos DROP TABLE para limpiar antes de importar</li>
                    <li>Para importar: Usar phpMyAdmin o comando MySQL</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>