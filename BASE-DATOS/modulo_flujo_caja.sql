-- =====================================================
-- SCRIPT DE BASE DE DATOS
-- MÓDULO: FLUJO DE CAJA (INGRESOS Y EGRESOS)
-- Proyecto: SmartSteel
-- Fecha: 29 de octubre de 2025
-- Base de datos: smartsteel
-- =====================================================

USE smartsteel;

-- =====================================================
-- TABLA 1: ingresos_egresos
-- Descripción: Tabla principal para registrar todos los movimientos financieros
-- =====================================================

CREATE TABLE IF NOT EXISTS `ingresos_egresos` (
  `id_movimiento` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del movimiento',
  `tipo` ENUM('INGRESO', 'EGRESO') NOT NULL COMMENT 'Tipo de movimiento',
  `clasificacion` ENUM('EMPRESARIAL', 'PERSONAL') NOT NULL COMMENT 'Clasificación del movimiento',
  `ruc` VARCHAR(11) DEFAULT NULL COMMENT 'RUC del cliente/proveedor (desde tabla clientes)',
  `razon_social` VARCHAR(255) DEFAULT NULL COMMENT 'Razón social (autocompletada desde clientes)',
  `concepto` TEXT NOT NULL COMMENT 'Descripción del movimiento',
  `monto_total` DECIMAL(10,2) NOT NULL COMMENT 'Monto total del movimiento',
  `numero_cuotas` INT(11) DEFAULT 1 COMMENT 'Número de cuotas para el pago',
  `frecuencia_cuotas` ENUM('UNICO', 'MENSUAL', 'QUINCENAL', 'SEMANAL', 'PERSONALIZADO') DEFAULT 'UNICO' COMMENT 'Frecuencia de las cuotas',
  `fecha_primera_cuota` DATE NOT NULL COMMENT 'Fecha de la primera cuota o pago único',
  `categoria` VARCHAR(100) NOT NULL COMMENT 'Categoría del movimiento',
  `numero_resolucion` VARCHAR(50) DEFAULT NULL COMMENT 'Número de resolución (fraccionamientos SUNAT)',
  `notas` TEXT DEFAULT NULL COMMENT 'Notas adicionales',
  `fecha_creacion` DATETIME NOT NULL COMMENT 'Fecha de registro',
  `fecha_actualizacion` DATETIME DEFAULT NULL COMMENT 'Fecha de última actualización',
  `cod_personal` INT(11) NOT NULL COMMENT 'Usuario que registró el movimiento',
  `estado` CHAR(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  PRIMARY KEY (`id_movimiento`),
  INDEX `idx_tipo_clasificacion` (`tipo`, `clasificacion`),
  INDEX `idx_fecha` (`fecha_primera_cuota`),
  INDEX `idx_estado` (`estado`),
  INDEX `idx_ruc` (`ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla principal de movimientos de ingresos y egresos';

-- =====================================================
-- TABLA 2: cuotas_movimientos
-- Descripción: Tabla para gestionar las cuotas de cada movimiento
-- =====================================================

CREATE TABLE IF NOT EXISTS `cuotas_movimientos` (
  `id_cuota` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la cuota',
  `id_movimiento` INT(11) NOT NULL COMMENT 'FK a ingresos_egresos',
  `numero_cuota` INT(11) NOT NULL COMMENT 'Número de cuota (1, 2, 3...)',
  `monto_cuota` DECIMAL(10,2) NOT NULL COMMENT 'Monto de la cuota',
  `fecha_vencimiento` DATE NOT NULL COMMENT 'Fecha de vencimiento de la cuota',
  `fecha_pago` DATE DEFAULT NULL COMMENT 'Fecha real de pago (NULL si pendiente)',
  `estado` ENUM('PENDIENTE', 'PAGADA', 'VENCIDA') DEFAULT 'PENDIENTE' COMMENT 'Estado de la cuota',
  `fecha_creacion` DATETIME NOT NULL COMMENT 'Fecha de creación',
  `fecha_actualizacion` DATETIME DEFAULT NULL COMMENT 'Fecha de actualización',
  `cod_personal` INT(11) NOT NULL COMMENT 'Usuario que creó/actualizó la cuota',
  PRIMARY KEY (`id_cuota`),
  FOREIGN KEY (`id_movimiento`) REFERENCES `ingresos_egresos`(`id_movimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_movimiento` (`id_movimiento`),
  INDEX `idx_fecha_vencimiento` (`fecha_vencimiento`),
  INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de cuotas por movimiento';

-- =====================================================
-- COMENTARIOS SOBRE CATEGORÍAS VÁLIDAS
-- =====================================================
-- Las categorías válidas para el campo 'categoria' son:
-- - VENTA
-- - SERVICIO
-- - COMPRA
-- - SERVICIOS_BASICOS
-- - PLANILLA
-- - FRACCIONAMIENTO_SUNAT
-- - CREDITO
-- - OTROS

-- =====================================================
-- PASO 3: INSERTAR MÓDULO EN EL SISTEMA
-- =====================================================
-- Este script obtiene automáticamente el siguiente orden disponible

-- Obtener el siguiente número de orden
SET @siguiente_orden = (SELECT COALESCE(MAX(orden), 0) + 1 FROM modulos);

-- Insertar módulo principal
INSERT INTO modulos (nombre_modulo, icono, orden, estado) 
VALUES ('Flujo de Caja', 'ri-money-dollar-circle-line', @siguiente_orden, 'A');

-- Obtener el ID del módulo recién creado
SET @id_modulo = LAST_INSERT_ID();

-- =====================================================
-- PASO 4: INSERTAR SUBMENÚS DEL MÓDULO
-- =====================================================

INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) VALUES
(@id_modulo, 'Dashboard Financiero', 'dashboard-ingresos-egresos.php', 'A'),
(@id_modulo, 'Registrar Movimiento', 'registrar-movimiento.php', 'A'),
(@id_modulo, 'Listado de Movimientos', 'listado-movimientos.php', 'A'),
(@id_modulo, 'Alertas de Pagos', 'alertas-pagos.php', 'A'),
(@id_modulo, 'Cuotas Pendientes', 'cuotas-pendientes.php', 'A');

-- =====================================================
-- VERIFICACIÓN DE INSTALACIÓN
-- =====================================================
-- Para verificar que todo se instaló correctamente, ejecutar:
-- SELECT * FROM modulos WHERE nombre_modulo = 'Flujo de Caja';
-- SELECT * FROM sub_modulos WHERE cod_modulo = @id_modulo;

-- =====================================================
-- NOTAS IMPORTANTES:
-- =====================================================
-- 1. El campo 'ruc' hace referencia a clientes.num_documento
--    pero NO se crea FK para permitir transacciones personales
--    sin cliente asociado
-- 
-- 2. El campo 'razon_social' se autocompleta desde clientes.nombres
--    al seleccionar un RUC, pero puede editarse manualmente
-- 
-- 3. La relación entre ingresos_egresos y cuotas_movimientos
--    usa CASCADE para eliminar automáticamente las cuotas
--    cuando se elimina un movimiento
-- 
-- 4. El sistema de cuotas permite:
--    - Pagos únicos (numero_cuotas = 1)
--    - Múltiples cuotas con diferentes frecuencias
--    - Seguimiento individual de cada cuota
-- 
-- 5. Los estados de cuotas se actualizan:
--    - PENDIENTE: Cuota no pagada antes de vencimiento
--    - PAGADA: Cuota pagada (fecha_pago != NULL)
--    - VENCIDA: Cuota no pagada después de vencimiento
--      (actualización mediante CRON diario)
--
-- 6. PERMISOS: Los permisos para cada usuario deben asignarse
--    manualmente en la tabla 'accesos_usuarios' o mediante
--    el módulo de administración de usuarios del sistema
-- =====================================================

-- Fin del script
