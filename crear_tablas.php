<?php
require("config/conexion.php");

// SQL para crear tabla ingresos_egresos
$sql_ingresos_egresos = "
CREATE TABLE IF NOT EXISTS `ingresos_egresos` (
  `id_movimiento` INT AUTO_INCREMENT PRIMARY KEY,
  `tipo` ENUM('INGRESO', 'EGRESO') NOT NULL,
  `clasificacion` ENUM('EMPRESARIAL', 'PERSONAL') NOT NULL,
  `ruc` VARCHAR(11),
  `razon_social` VARCHAR(255),
  `concepto` TEXT NOT NULL,
  `monto_total` DECIMAL(10,2) NOT NULL,
  `numero_cuotas` INT DEFAULT 1,
  `frecuencia_cuotas` ENUM('UNICO', 'MENSUAL', 'QUINCENAL', 'SEMANAL', 'PERSONALIZADO') DEFAULT 'UNICO',
  `fecha_primera_cuota` DATE NOT NULL,
  `categoria` VARCHAR(100) NOT NULL,
  `numero_resolucion` VARCHAR(50) NULL,
  `notas` TEXT,
  `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_personal` INT,
  `estado` CHAR(1) DEFAULT 'A',
  INDEX `idx_tipo_clasificacion` (`tipo`, `clasificacion`),
  INDEX `idx_fecha` (`fecha_primera_cuota`),
  INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

// SQL para crear tabla cuotas_movimientos
$sql_cuotas = "
CREATE TABLE IF NOT EXISTS `cuotas_movimientos` (
  `id_cuota` INT AUTO_INCREMENT PRIMARY KEY,
  `id_movimiento` INT NOT NULL,
  `numero_cuota` INT NOT NULL,
  `monto_cuota` DECIMAL(10,2) NOT NULL,
  `fecha_vencimiento` DATE NOT NULL,
  `fecha_pago` DATE NULL,
  `estado` ENUM('PENDIENTE', 'PAGADA', 'VENCIDA') DEFAULT 'PENDIENTE',
  `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_movimiento` (`id_movimiento`),
  INDEX `idx_estado` (`estado`),
  INDEX `idx_fecha_vencimiento` (`fecha_vencimiento`),
  FOREIGN KEY (`id_movimiento`) REFERENCES `ingresos_egresos`(`id_movimiento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

echo "Creando tabla ingresos_egresos...<br>";
if (mysqli_query($conexion, $sql_ingresos_egresos)) {
    echo "✅ Tabla ingresos_egresos creada exitosamente.<br>";
} else {
    echo "❌ Error creando tabla ingresos_egresos: " . mysqli_error($conexion) . "<br>";
}

echo "Creando tabla cuotas_movimientos...<br>";
if (mysqli_query($conexion, $sql_cuotas)) {
    echo "✅ Tabla cuotas_movimientos creada exitosamente.<br>";
} else {
    echo "❌ Error creando tabla cuotas_movimientos: " . mysqli_error($conexion) . "<br>";
}

echo "<br>Proceso completado.";
