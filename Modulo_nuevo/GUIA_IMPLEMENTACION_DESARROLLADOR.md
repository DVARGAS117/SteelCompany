# GUÍA DE IMPLEMENTACIÓN - MÓDULO INGRESOS Y EGRESOS
## Documento para Desarrollador - Proyecto SmartSteel

**Fecha:** 28 de octubre de 2025  
**Proyecto:** Integración de Módulo de Gestión de Ingresos y Egresos  
**Maqueta funcional:** Completada (HTML/CSS/JS)

---

## 1. STACK TECNOLÓGICO DEL PROYECTO

### Backend
- **Lenguaje:** PHP (versión procedimental, sin POO)
- **Base de datos:** MySQL - BD: `roque192_XXNEO2050`
- **Conexión:** MySQLi (procedimental)
- **Charset:** UTF8

### Frontend
- **HTML5** con PHP embebido
- **CSS Framework:** Bootstrap
- **JavaScript:** jQuery + AJAX
- **Librerías adicionales:**
  - DataTables (listados con búsqueda y exportación)
  - Dropzone (carga de archivos)
  - SimpleBa (scrollbars personalizados)
  - Remix Icons (iconografía)

### Arquitectura
- Aplicación monolítica con archivos PHP
- Un archivo centralizado de guardado: `config/proceso-guardar.php`
- Un archivo centralizado de eliminación: `config/proceso-eliminar.php`
- Sistema de módulos y submenús dinámicos con permisos

---

## 2. ESTRUCTURA DE BASE DE DATOS REQUERIDA

### Tabla Principal: `ingresos_egresos`

```sql
CREATE TABLE `ingresos_egresos` (
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
  `fecha_creacion` DATETIME,
  `fecha_actualizacion` DATETIME,
  `cod_personal` INT,
  `estado` CHAR(1) DEFAULT 'A',
  INDEX `idx_tipo_clasificacion` (`tipo`, `clasificacion`),
  INDEX `idx_fecha` (`fecha_primera_cuota`),
  INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

**Categorías válidas:** 'VENTA', 'SERVICIO', 'COMPRA', 'SERVICIOS_BASICOS', 'PLANILLA', 'FRACCIONAMIENTO_SUNAT', 'CREDITO', 'OTROS'

### Tabla de Cuotas: `cuotas_movimientos`

```sql
CREATE TABLE `cuotas_movimientos` (
  `id_cuota` INT AUTO_INCREMENT PRIMARY KEY,
  `id_movimiento` INT NOT NULL,
  `numero_cuota` INT NOT NULL,
  `monto_cuota` DECIMAL(10,2) NOT NULL,
  `fecha_vencimiento` DATE NOT NULL,
  `fecha_pago` DATE NULL,
  `estado` ENUM('PENDIENTE', 'PAGADA', 'VENCIDA') DEFAULT 'PENDIENTE',
  `fecha_creacion` DATETIME,
  `fecha_actualizacion` DATETIME,
  `cod_personal` INT,
  FOREIGN KEY (`id_movimiento`) REFERENCES `ingresos_egresos`(`id_movimiento`) ON DELETE CASCADE,
  INDEX `idx_fecha_vencimiento` (`fecha_vencimiento`),
  INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

---

## 3. INTEGRACIÓN AL SISTEMA DE MENÚ

### Paso 1: Registrar Módulo en BD

Insertar en tabla `modulos`:
```sql
INSERT INTO modulos (nombre_modulo, icono, orden, estado) 
VALUES ('Flujo de Caja', 'ri-money-dollar-circle-line', [SIGUIENTE_ORDEN], 'A');
```

### Paso 2: Crear Submenús

Insertar en tabla `sub_modulos`:
```sql
INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) VALUES
([ID_MODULO_CREADO], 'Dashboard Financiero', 'dashboard-ingresos-egresos.php', 'A'),
([ID_MODULO_CREADO], 'Registrar Movimiento', 'registrar-movimiento.php', 'A'),
([ID_MODULO_CREADO], 'Listado de Movimientos', 'listado-movimientos.php', 'A'),
([ID_MODULO_CREADO], 'Alertas de Pagos', 'alertas-pagos.php', 'A'),
([ID_MODULO_CREADO], 'Cuotas Pendientes', 'cuotas-pendientes.php', 'A');
```

### Paso 3: Asignar Permisos

En tabla `accesos_usuarios`, asignar a los usuarios correspondientes con permisos de insertar, editar, eliminar, consultar.

---

## 4. ARCHIVOS PHP A CREAR

### 4.1. Vista Dashboard: `dashboard-ingresos-egresos.php`

**Estructura:**
```php
<?php
require("config/conexion.php");
require("config/inicializar-datos.php");
require("config/permisos.php");
require("config/cabecera-web.php");
require("config/cabecera.php");
require("config/barra-navegacion.php");
?>

<!-- Contenido HTML del Dashboard -->
<div class="row">
    <!-- Tarjetas resumen: Ingresos, Egresos, Saldo -->
    <!-- Filtros: Mes y Clasificación (Todas/Empresarial/Personal) -->
    <!-- Gráfico de barras -->
    <!-- Lista de últimas transacciones -->
    <!-- Sección de cuotas pendientes próximas -->
</div>

<?php require("config/piepagina.php"); ?>
```

**Funcionalidad:**
- Consultar resumen mensual de ingresos/egresos con filtro de clasificación
- Mostrar saldo neto (Ingresos - Egresos)
- Listar últimos 10 movimientos
- Mostrar cuotas pendientes próximas (próximos 7 días)
- Gráfico de barras con desglose por clasificación

### 4.2. Formulario de Registro: `registrar-movimiento.php`

**Estructura:** Página completa con header/sidebar

**Formulario (`<form id="fapps">`):**
- Tipo (radio: Ingreso/Egreso)
- Clasificación (select: Empresarial/Personal)
- RUC + botón buscar (AJAX para obtener razón social)
- Razón Social (autollenado o manual)
- Concepto (textarea)
- Categoría (select)
- Monto Total
- Número de Cuotas (default 1)
- Frecuencia (select: mostrar solo si cuotas > 1)
- Fecha Primera Cuota
- Número Resolución (visible solo si categoría = Fraccionamiento SUNAT)
- Notas
- Estado (radio: Activo/Inactivo)
- Campos hidden: `id_movimiento`, `proceso`, `modulo`

**JavaScript:**
- Validación de campos requeridos
- Cálculo automático de monto por cuota (monto_total / numero_cuotas)
- AJAX para guardar: `proceso-guardar.php` con proceso `RegistrarMovimiento` o `ActualizarMovimiento`
- Recargar página con `location.reload()` tras éxito

### 4.3. Listado: `listado-movimientos.php`

**Estructura:**
- DataTable con columnas: Fecha, Tipo, Clasificación, RUC, Razón Social, Concepto, Categoría, Monto Total, Cuotas, Estado, Acciones
- Botón superior: "Nuevo Movimiento" → redirige a `registrar-movimiento.php`
- Filtros: Por mes, por tipo, por clasificación
- Badges: Verde (Activo), Rojo (Inactivo)
- Botones de acción:
  - Editar (abre modal o redirige a formulario con parámetro `?id_movimiento=X`)
  - Ver Cuotas (abre modal con listado de cuotas)
  - Eliminar (clase `borrarReg`)

### 4.4. Vista de Alertas: `alertas-pagos.php`

**Estructura:**
- Filtros: Próximos 3 días, 7 días, esta quincena, este mes
- Listado de cuotas pendientes ordenadas por fecha de vencimiento
- Código de colores:
  - Rojo: Vencidas o ≤ 2 días
  - Naranja: 3-7 días
  - Azul: > 7 días
- Botón por cuota: "Marcar como Pagada"

### 4.5. Gestión de Cuotas: `cuotas-pendientes.php`

**Estructura:**
- DataTable con todas las cuotas
- Filtros: Estado (Pendiente/Pagada/Vencida), Período
- Columnas: Nº Cuota, Movimiento, RUC/Razón Social, Monto, Fecha Vencimiento, Estado, Acciones
- Acción: Registrar Pago (abre modal con fecha de pago y monto real)

### 4.6. Modales Auxiliares

**Modal para Ver Cuotas:** `modal-ver-cuotas.php?id_movimiento=X`
- Carga dinámica en modal
- Listado de todas las cuotas del movimiento
- Estado de cada cuota

**Modal para Registrar Pago:** `modal-registrar-pago.php?id_cuota=X`
- Fecha de pago
- Confirmar monto
- Botón guardar (AJAX)

---

## 5. LÓGICA DE PROCESO-GUARDAR.PHP

Agregar al archivo `config/proceso-guardar.php` los siguientes bloques:

### Bloque 1: Registrar Movimiento
```php
if ($modulo == 'MovimientosFinancieros') {
    $proceso = $_POST['proceso'];
    
    if ($proceso == 'RegistrarMovimiento') {
        // 1. Validar permisos ($can_insert)
        // 2. Recibir datos del POST
        // 3. Insertar en tabla ingresos_egresos
        // 4. Obtener id_movimiento (mysqli_insert_id)
        // 5. SI numero_cuotas > 1:
        //    - Calcular monto_cuota = monto_total / numero_cuotas
        //    - Generar fechas según frecuencia
        //    - Insertar en cuotas_movimientos
        // 6. Retornar JSON {"respuesta": "SI"/"NO"}
    }
    
    if ($proceso == 'ActualizarMovimiento') {
        // Similar a registrar, pero con UPDATE
        // Recalcular cuotas si cambió monto o frecuencia
    }
}
```

### Bloque 2: Registrar Pago de Cuota
```php
if ($modulo == 'PagoCuota') {
    // 1. Recibir id_cuota y fecha_pago
    // 2. UPDATE cuotas_movimientos SET estado='PAGADA', fecha_pago=X
    // 3. Retornar JSON
}
```

**Cálculo de Fechas de Cuotas:**
- MENSUAL: Sumar 1 mes a fecha_primera_cuota con `DATE_ADD`
- QUINCENAL: Sumar 15 días
- SEMANAL: Sumar 7 días
- PERSONALIZADO: Solicitar días entre cuotas

---

## 6. LÓGICA DE PROCESO-ELIMINAR.PHP

Agregar bloque:
```php
if ($modulo == 'MovimientosFinancieros') {
    $id_movimiento = $_POST['id_movimiento'];
    // DELETE en ingresos_egresos
    // Las cuotas se eliminan por CASCADE
    // Retornar {"resultado": "SI"/"NO"}
}
```

---

## 7. INTEGRACIÓN CON CAMPANA DE NOTIFICACIONES

### Archivo a Modificar: `config/cabecera.php`

**Crear archivo AJAX:** `config/obtener-notificaciones-cuotas.php`

```php
<?php
require("conexion.php");
session_start();
$cod_personal = $_SESSION['cod_personal'];

// Consulta: Cuotas pendientes próximas 7 días
$sql = "SELECT c.id_cuota, c.numero_cuota, c.monto_cuota, c.fecha_vencimiento,
               m.tipo, m.clasificacion, m.razon_social, m.concepto,
               DATEDIFF(c.fecha_vencimiento, CURDATE()) as dias_restantes
        FROM cuotas_movimientos c
        INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
        WHERE c.estado = 'PENDIENTE' 
        AND c.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
        AND m.estado = 'A'
        ORDER BY c.fecha_vencimiento ASC
        LIMIT 10";

$resultado = mysqli_query($conexion, $sql);

$notificaciones = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    // Determinar clase de urgencia
    if ($row['dias_restantes'] <= 2) {
        $clase = 'bg-danger';
        $icono = 'ri-alarm-warning-line';
    } elseif ($row['dias_restantes'] <= 7) {
        $clase = 'bg-warning';
        $icono = 'ri-time-line';
    }
    
    $notificaciones[] = array(
        'id' => $row['id_cuota'],
        'titulo' => ($row['tipo'] == 'INGRESO' ? 'Cobro' : 'Pago') . ' pendiente',
        'mensaje' => $row['razon_social'] . ' - ' . substr($row['concepto'], 0, 40),
        'monto' => 'S/ ' . number_format($row['monto_cuota'], 2),
        'tiempo' => 'Vence en ' . $row['dias_restantes'] . ' días',
        'clase' => $clase,
        'icono' => $icono,
        'enlace' => 'alertas-pagos.php'
    );
}

echo json_encode($notificaciones);
?>
```

**JavaScript en cabecera.php:**
```javascript
<script>
function cargarNotificacionesCuotas() {
    $.ajax({
        url: 'config/obtener-notificaciones-cuotas.php',
        type: 'GET',
        dataType: 'json',
        success: function(notificaciones) {
            var html = '';
            if (notificaciones.length > 0) {
                $('#noti-dot').show(); // Mostrar badge rojo
                $.each(notificaciones, function(i, noti) {
                    html += '<a href="' + noti.enlace + '" class="text-reset notification-item">';
                    html += '<div class="d-flex">';
                    html += '<div class="flex-shrink-0 me-3">';
                    html += '<span class="avatar-title ' + noti.clase + ' rounded-circle">';
                    html += '<i class="' + noti.icono + '"></i></span></div>';
                    html += '<div class="flex-grow-1">';
                    html += '<h6 class="mb-1">' + noti.titulo + '</h6>';
                    html += '<p class="mb-1">' + noti.mensaje + '</p>';
                    html += '<p class="mb-0"><b>' + noti.monto + '</b> - ' + noti.tiempo + '</p>';
                    html += '</div></div></a>';
                });
            } else {
                $('#noti-dot').hide();
                html = '<div class="p-3 text-center">No hay pagos pendientes próximos</div>';
            }
            $('#lista-notificaciones-cuotas').html(html);
        }
    });
}

// Cargar al inicio
$(document).ready(function() {
    cargarNotificacionesCuotas();
    // Recargar cada 5 minutos
    setInterval(cargarNotificacionesCuotas, 300000);
});
</script>
```

**Modificar HTML del dropdown de notificaciones:**
- Agregar `<div id="lista-notificaciones-cuotas"></div>`
- Agregar `<span id="noti-dot" class="noti-dot" style="display:none;"></span>`

---

## 8. PROCESO DE ACTUALIZACIÓN AUTOMÁTICA DE ESTADOS

**Crear archivo CRON:** `config/actualizar-estados-cuotas.php`

```php
<?php
require("conexion.php");

// Actualizar cuotas vencidas
$sql = "UPDATE cuotas_movimientos 
        SET estado = 'VENCIDA' 
        WHERE estado = 'PENDIENTE' 
        AND fecha_vencimiento < CURDATE()";
mysqli_query($conexion, $sql);

echo "Estados actualizados: " . mysqli_affected_rows($conexion) . " cuotas";
?>
```

**Configurar en Cron del servidor:**
```bash
0 1 * * * /usr/bin/php /ruta/al/proyecto/config/actualizar-estados-cuotas.php
```
(Ejecutar diariamente a la 1:00 AM)

---

## 9. CONSIDERACIONES DE SEGURIDAD

⚠️ **IMPORTANTE:** El proyecto actual NO usa prepared statements. Mantener consistencia:

```php
// Patrón actual del proyecto
$concepto = $_POST['concepto'];
$monto = $_POST['monto_total'];
$sql = "INSERT INTO ingresos_egresos (concepto, monto_total) VALUES ('$concepto', '$monto')";
```

**Recomendación (opcional):** Aplicar `mysqli_real_escape_string()` para campos de texto:
```php
$concepto = mysqli_real_escape_string($conexion, $_POST['concepto']);
```

---

## 10. QUERIES SQL ÚTILES

### Dashboard - Resumen Mensual
```sql
SELECT 
    tipo,
    clasificacion,
    SUM(monto_total) as total
FROM ingresos_egresos
WHERE MONTH(fecha_primera_cuota) = [MES]
  AND YEAR(fecha_primera_cuota) = [AÑO]
  AND estado = 'A'
GROUP BY tipo, clasificacion
```

### Cuotas Pendientes con Alerta
```sql
SELECT 
    c.*,
    m.tipo, m.clasificacion, m.razon_social, m.concepto,
    DATEDIFF(c.fecha_vencimiento, CURDATE()) as dias_restantes
FROM cuotas_movimientos c
INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
WHERE c.estado = 'PENDIENTE'
  AND c.fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL [DIAS] DAY)
  AND m.estado = 'A'
ORDER BY c.fecha_vencimiento ASC
```

### Últimos Movimientos
```sql
SELECT * FROM ingresos_egresos
WHERE estado = 'A'
ORDER BY fecha_creacion DESC
LIMIT 10
```

---

## 11. FORMATO DE RESPUESTAS JSON

**Estándar del proyecto:**
```json
{
    "respuesta": "SI"
}
```

**Para operaciones con más detalle:**
```json
{
    "success": true,
    "mensaje": "Movimiento registrado con éxito. Se generaron 12 cuotas.",
    "tipo": "success",
    "id_movimiento": 45
}
```

---

## 12. CHECKLIST DE IMPLEMENTACIÓN

### Base de Datos
- [ ] Crear tabla `ingresos_egresos`
- [ ] Crear tabla `cuotas_movimientos`
- [ ] Insertar módulo en tabla `modulos`
- [ ] Insertar submenús en tabla `sub_modulos`
- [ ] Asignar permisos en tabla `accesos_usuarios`

### Archivos PHP
- [ ] `dashboard-ingresos-egresos.php`
- [ ] `registrar-movimiento.php`
- [ ] `listado-movimientos.php`
- [ ] `alertas-pagos.php`
- [ ] `cuotas-pendientes.php`
- [ ] `modal-ver-cuotas.php`
- [ ] `modal-registrar-pago.php`

### Archivos AJAX
- [ ] `config/obtener-notificaciones-cuotas.php`
- [ ] `config/buscar-ruc.php` (opcional, si se requiere integración SUNAT)

### Archivos de Proceso
- [ ] Agregar bloque en `config/proceso-guardar.php` para módulo `MovimientosFinancieros`
- [ ] Agregar bloque en `config/proceso-eliminar.php`
- [ ] Crear `config/actualizar-estados-cuotas.php` (CRON)

### Integración
- [ ] Modificar `config/cabecera.php` para cargar notificaciones de cuotas
- [ ] Configurar CRON para actualización automática de estados
- [ ] Pruebas de permisos por usuario

---

## 13. NOTAS FINALES

### Patrón de URLs con Submenú
Todos los archivos del módulo deben incluir parámetro en URL:
```
dashboard-ingresos-egresos.php?sub_modulo=DashboardFinanciero
registrar-movimiento.php?sub_modulo=RegistrarMovimiento
```
Esto es necesario para que `permisos.php` funcione correctamente.

### Variables de Sesión Disponibles
```php
$xCodPer          // ID del usuario actual
$xNombres         // Nombre del usuario
$xTienda          // ID punto de venta
$xNombreTienda    // Nombre del local
$xRucEmpresa      // RUC de la empresa
```

### Librerías CSS/JS Ya Cargadas
- Bootstrap 5
- jQuery 3.x
- DataTables
- Remix Icons
- SimpleBa
No es necesario incluir nuevamente en las vistas.

---

**Documento preparado para iniciar desarrollo.**  
**Cualquier duda sobre estructura o patrón, revisar módulo de Categorías como referencia.**
