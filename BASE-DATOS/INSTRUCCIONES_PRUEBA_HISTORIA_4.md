# INSTRUCCIONES DE PRUEBA - HISTORIA 4
## Módulo Flujo de Caja - Guardado Directo en Base de Datos

**Fecha:** 29 de octubre de 2025  
**Historia de Usuario:** Desarrollador - Guardado directo en base de datos  
**Estado:** ✅ **COMPLETADO Y APROBADO**

---

## 🎉 RESULTADO FINAL - HISTORIA 4 COMPLETADA

### ✅ Estado: **APROBADO - TODAS LAS PRUEBAS EXITOSAS**

**Fecha de Completado:** 29 de octubre de 2025  
**Probado por:** Usuario del sistema  
**Resultado:** Todos los criterios de aceptación cumplidos

### 📊 Resumen de Funcionalidades Implementadas:

1. ✅ **Autocompletado de RUC:**
   - El sistema consulta la tabla `clientes` correctamente
   - La razón social se autocompleta al ingresar RUC válido
   - Maneja correctamente RUCs inexistentes

2. ✅ **Sistema de Cuotas con Checkbox:**
   - Checkbox "Pago en cuotas" habilita/deshabilita campos dinámicamente
   - Validación `required` se mueve correctamente entre campos
   - Campos deshabilitados se habilitan antes del submit (fix para envío de formulario)
   - Pago único (sin checkbox): 1 cuota automática
   - Pago en cuotas (con checkbox): N cuotas con frecuencia seleccionada

3. ✅ **Generación Automática de Cuotas:**
   - Cuota única: Se crea automáticamente con monto total
   - Múltiples cuotas: División correcta del monto (monto_total / numero_cuotas)
   - Cálculo de fechas funciona perfectamente:
     - MENSUAL: +1 mes entre cuotas
     - QUINCENAL: +15 días entre cuotas
     - SEMANAL: +7 días entre cuotas

4. ✅ **Guardado en Base de Datos:**
   - Tabla `ingresos_egresos`: Guardado correcto de todos los campos
   - Tabla `cuotas_movimientos`: Generación automática con relación FK
   - Manejo correcto de valores NULL para campos opcionales
   - `frecuencia_cuotas` por defecto: 'UNICO' si no se especifica

5. ✅ **Validaciones:**
   - Transacciones EMPRESARIALES requieren RUC y razón social
   - Transacciones PERSONAL permiten campos vacíos
   - Mensajes de error claros y precisos
   - Prevención de envío con campos required ocultos (fix aplicado)

6. ✅ **Interfaz de Usuario:**
   - Formulario con estructura HTML completa (doctype, head, body)
   - Bootstrap 5 aplicado correctamente
   - Checkbox intuitivo para habilitar cuotas
   - Campos se muestran/ocultan dinámicamente sin problemas

7. ✅ **Manejo de Respuestas AJAX:**
   - Extracción correcta de JSON aunque vengan warnings PHP
   - Mensajes de éxito y error apropiados
   - Recarga automática después de guardado exitoso

### 🐛 Bugs Corregidos Durante Implementación:

1. ❌→✅ Base de datos incorrecta (roque192_XXNEO2050 → smartsteel)
2. ❌→✅ HTML sin estructura completa (faltaban tags html, head, body)
3. ❌→✅ Campo `razon_social` con atributo `readonly` (bloqueaba jQuery)
4. ❌→✅ JSON parsing con warnings PHP mezclados
5. ❌→✅ Campos `disabled` no se enviaban en formulario
6. ❌→✅ Campo `fecha_pago_unico` con `required` impedía submit cuando estaba oculto

### 📈 Pruebas Realizadas con Éxito:

- ✅ Guardado de movimiento EMPRESARIAL con RUC existente (20102881690 - DEXIM S.R.L.)
- ✅ Generación de 3 cuotas mensuales (movimiento id_4: 1000.00 c/u, fechas: 29/oct, 29/nov, 29/dic)
- ✅ Guardado de movimiento PERSONAL sin RUC
- ✅ Autocompletado de razón social funciona perfectamente
- ✅ Checkbox de cuotas habilita/deshabilita campos correctamente
- ✅ Validación de campos required según estado del checkbox

### 💾 Registros de Prueba en BD:

```sql
-- Movimientos de prueba guardados exitosamente:
id_movimiento=1: INGRESO/EMPRESARIAL - RUC 20102881690 - 1 cuota
id_movimiento=2: INGRESO/EMPRESARIAL - RUC 20102881690 - 1 cuota  
id_movimiento=3: INGRESO/EMPRESARIAL - RUC 20102881690 - 1 cuota
id_movimiento=4: EGRESO/EMPRESARIAL - RUC 20102881690 - 3 cuotas (MENSUAL)
```

Todas las cuotas generadas correctamente con fechas calculadas automáticamente.

---

## 📋 RESUMEN DE IMPLEMENTACIÓN

Se ha completado la implementación básica de la **Historia 4** que incluye:

### ✅ Archivos Creados/Modificados:

1. **`BASE-DATOS/modulo_flujo_caja.sql`** - Script SQL completo con:
   - Tabla `ingresos_egresos` (movimientos principales)
   - Tabla `cuotas_movimientos` (cuotas por movimiento)
   - Scripts de inserción de módulo y submenús
   - Relaciones y constraints

2. **`config/buscar-ruc.php`** - Ya existía, valida RUC contra tabla `clientes`

3. **`registrar-movimiento.php`** - Ya existía, formulario completo con:
   - Validación de RUC obligatorio para transacciones empresariales
   - Autocompletado de razón social desde BD
   - Validación de campos requeridos
   - Generación de cuotas

4. **`config/proceso-guardar.php`** - Ya existía, agregado:
   - Bloque para módulo `MovimientosFinancieros`
   - Proceso `RegistrarMovimiento`
   - Generación automática de cuotas según frecuencia
   - Función auxiliar `calcularSiguienteFecha()`

5. **`listado-movimientos.php`** - Nuevo archivo creado:
   - DataTable con exportación a Excel/PDF
   - Visualización de todos los movimientos
   - Badges de color para tipo, clasificación y estado
   - Botón para ver cuotas (pendiente de implementar)

---

## 🔧 PASOS PARA EJECUTAR LA PRUEBA

### PASO 1: Ejecutar Scripts SQL

1. Abrir phpMyAdmin o cualquier cliente MySQL
2. Seleccionar la base de datos: `roque192_XXNEO2050`
3. Ejecutar el archivo: `BASE-DATOS/modulo_flujo_caja.sql`
4. Verificar que se crearon:
   - ✅ Tabla `ingresos_egresos`
   - ✅ Tabla `cuotas_movimientos`
   - ✅ Módulo "Flujo de Caja" en tabla `modulos`
   - ✅ 5 submenús en tabla `sub_modulos`

**Query de verificación:**
```sql
-- Verificar módulo
SELECT * FROM modulos WHERE nombre_modulo = 'Flujo de Caja';

-- Verificar submenús
SELECT * FROM sub_modulos WHERE cod_modulo = (SELECT cod_modulo FROM modulos WHERE nombre_modulo = 'Flujo de Caja');

-- Verificar tablas
SHOW TABLES LIKE '%ingresos%';
SHOW TABLES LIKE '%cuotas%';
```

---

### PASO 2: Asignar Permisos al Usuario

1. Ir al módulo de **Personal/Usuarios** en el sistema
2. Editar el usuario de prueba
3. Asignar permisos completos (insertar, editar, eliminar, consultar) para:
   - Dashboard Financiero
   - Registrar Movimiento
   - Listado de Movimientos
   - Alertas de Pagos
   - Cuotas Pendientes

**O ejecutar SQL manualmente:**
```sql
-- Reemplazar [ID_USUARIO] y [ID_MODULO] con los valores correctos
SET @id_usuario = [ID_USUARIO];
SET @id_modulo = (SELECT cod_modulo FROM modulos WHERE nombre_modulo = 'Flujo de Caja');

-- Obtener IDs de submenús
SET @id_dashboard = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'dashboard-ingresos-egresos.php');
SET @id_registrar = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'registrar-movimiento.php');
SET @id_listado = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'listado-movimientos.php');
SET @id_alertas = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'alertas-pagos.php');
SET @id_cuotas = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'cuotas-pendientes.php');

-- Insertar permisos
INSERT INTO accesos_usuarios (cod_personal, cod_modulo, cod_submodulo, modulo, insertar, editar, eliminar, consultar) VALUES
(@id_usuario, @id_modulo, @id_registrar, 'Registrar Movimiento', 'SI', 'SI', 'SI', 'SI'),
(@id_usuario, @id_modulo, @id_listado, 'Listado de Movimientos', 'SI', 'SI', 'SI', 'SI');
```

---

### PASO 3: Verificar que el Módulo Aparece en el Menú

1. Iniciar sesión en el sistema SmartSteel
2. Verificar que en el menú lateral aparece **"Flujo de Caja"** con el icono 💰
3. Al expandir debe mostrar 5 opciones:
   - Dashboard Financiero
   - Registrar Movimiento
   - Listado de Movimientos
   - Alertas de Pagos
   - Cuotas Pendientes

---

### PASO 4: Registrar Movimiento con RUC Existente (SCENARIO 1)

**Objetivo:** Validar que el sistema autocompleta la razón social desde la BD

1. Ir a: **Flujo de Caja > Registrar Movimiento**
2. Llenar el formulario:
   - **Tipo:** Ingreso
   - **Clasificación:** EMPRESARIAL
   - **RUC:** [Ingresar un RUC que exista en la tabla `clientes`]
   - Al salir del campo RUC, debe autocompletarse **Razón Social**
   - **Concepto:** "Venta de productos de prueba"
   - **Monto Total:** 1000.00
   - **Número de Cuotas:** 3
   - **Frecuencia:** Mensual
   - **Fecha 1ra Cuota:** [Fecha actual]
   - **Categoría:** VENTA
   - **Estado:** Activo

3. Click en **"Guardar Movimiento"**
4. Debe mostrar: "Movimiento guardado exitosamente"
5. La página se recarga

**✅ Criterios de aceptación:**
- El RUC válido autocompleta la razón social
- El movimiento se guarda correctamente
- Se generan 3 cuotas automáticamente

---

### PASO 5: Verificar en Base de Datos

Ejecutar queries de verificación:

```sql
-- Ver el movimiento registrado
SELECT * FROM ingresos_egresos ORDER BY id_movimiento DESC LIMIT 1;

-- Ver las cuotas generadas
SELECT * FROM cuotas_movimientos 
WHERE id_movimiento = (SELECT MAX(id_movimiento) FROM ingresos_egresos)
ORDER BY numero_cuota;

-- Verificar que las fechas de cuotas son correctas (cada mes)
SELECT 
    numero_cuota,
    monto_cuota,
    fecha_vencimiento,
    DATEDIFF(fecha_vencimiento, LAG(fecha_vencimiento) OVER (ORDER BY numero_cuota)) as dias_diferencia
FROM cuotas_movimientos 
WHERE id_movimiento = (SELECT MAX(id_movimiento) FROM ingresos_egresos);
```

**✅ Criterios de aceptación:**
- Existe 1 registro en `ingresos_egresos`
- Existen 3 registros en `cuotas_movimientos`
- El monto de cada cuota es 1000/3 = 333.33
- La diferencia entre fechas es aproximadamente 30 días

---

### PASO 6: Visualizar en Listado

1. Ir a: **Flujo de Caja > Listado de Movimientos**
2. Debe aparecer el movimiento recién registrado en la tabla
3. Verificar que se muestran:
   - ✅ Fecha correcta
   - ✅ Badge verde "INGRESO"
   - ✅ Badge azul "EMPRESARIAL"
   - ✅ RUC ingresado
   - ✅ Razón social autocompletada
   - ✅ Concepto
   - ✅ Categoría: VENTA
   - ✅ Monto: S/ 1,000.00
   - ✅ Cuotas: 3
   - ✅ Estado: Activo

**✅ Criterios de aceptación:**
- El movimiento aparece en el listado
- Todos los datos se visualizan correctamente
- Los badges tienen los colores apropiados

---

### PASO 7: Registrar Movimiento con RUC Inexistente (SCENARIO 2)

**Objetivo:** Validar que el sistema bloquea el guardado si el RUC no existe

1. Ir a: **Flujo de Caja > Registrar Movimiento**
2. Llenar el formulario:
   - **Tipo:** Egreso
   - **Clasificación:** EMPRESARIAL
   - **RUC:** 12345678901 (RUC inexistente)
   - Al salir del campo RUC, debe mostrar: "El RUC ingresado no existe en la base de datos"
   - El campo **Razón Social** queda vacío

3. Intentar guardar sin llenar Razón Social
4. Debe mostrar: "La razón social no puede estar vacía para transacciones empresariales"

**✅ Criterios de aceptación:**
- El sistema detecta que el RUC no existe
- El sistema no permite guardar sin razón social en transacciones empresariales
- Se muestra mensaje de error apropiado

---

### PASO 8: Registrar Movimiento Personal (Sin RUC)

**Objetivo:** Validar que se pueden registrar movimientos personales sin RUC

1. Ir a: **Flujo de Caja > Registrar Movimiento**
2. Llenar el formulario:
   - **Tipo:** Egreso
   - **Clasificación:** PERSONAL
   - **RUC:** [Dejar vacío]
   - **Razón Social:** [Dejar vacío o poner nombre personal]
   - **Concepto:** "Pago de universidad"
   - **Monto Total:** 2000.00
   - **Número de Cuotas:** 5
   - **Frecuencia:** Mensual
   - **Fecha 1ra Cuota:** [Fecha actual]
   - **Categoría:** OTROS
   - **Estado:** Activo

3. Click en **"Guardar Movimiento"**
4. Debe guardarse correctamente SIN validar RUC

**✅ Criterios de aceptación:**
- El movimiento personal se guarda sin RUC
- Se generan 5 cuotas correctamente
- Aparece en el listado con badge "PERSONAL"

---

## 📊 CRITERIOS DE ACEPTACIÓN - HISTORIA 4

### Scenario: Guardado exitoso de nuevo movimiento
- ✅ **Given:** La interfaz de captura de movimientos
- ✅ **When:** Se registra un movimiento con datos completos y válidos
- ✅ **Then:** El sistema guarda en la BD principal y está disponible inmediatamente

### Scenario: Actualización de base de datos con nuevos registros
- ✅ **Given:** Existe una BD con tabla de movimientos
- ✅ **When:** El sistema guarda nuevos movimientos
- ✅ **Then:** Los registros se agregan y consultan junto con RUC/razón social existentes

### Scenario: Error en guardado por datos incompletos
- ✅ **Given:** Usuario intenta guardar con campos obligatorios vacíos
- ✅ **When:** Presiona botón de guardar
- ✅ **Then:** Sistema impide guardado y muestra mensaje de error

---

## 🔍 QUERIES ÚTILES PARA DEBUGGING

```sql
-- Ver todos los movimientos registrados
SELECT 
    id_movimiento,
    tipo,
    clasificacion,
    ruc,
    razon_social,
    concepto,
    monto_total,
    numero_cuotas,
    fecha_primera_cuota,
    categoria,
    estado
FROM ingresos_egresos
ORDER BY fecha_creacion DESC;

-- Ver todas las cuotas con su movimiento
SELECT 
    m.id_movimiento,
    m.tipo,
    m.razon_social,
    c.numero_cuota,
    c.monto_cuota,
    c.fecha_vencimiento,
    c.estado as estado_cuota
FROM ingresos_egresos m
INNER JOIN cuotas_movimientos c ON m.id_movimiento = c.id_movimiento
ORDER BY m.id_movimiento, c.numero_cuota;

-- Verificar permisos de usuario
SELECT 
    u.nombres,
    m.nombre_modulo,
    sm.sub_modulo,
    a.insertar,
    a.editar,
    a.eliminar,
    a.consultar
FROM accesos_usuarios a
INNER JOIN personal u ON a.cod_personal = u.cod_personal
INNER JOIN modulos m ON a.cod_modulo = m.cod_modulo
INNER JOIN sub_modulos sm ON a.cod_submodulo = sm.cod_submodulo
WHERE m.nombre_modulo = 'Flujo de Caja'
ORDER BY u.nombres, sm.sub_modulo;

-- Limpiar datos de prueba (si es necesario)
DELETE FROM cuotas_movimientos WHERE id_movimiento IN (SELECT id_movimiento FROM ingresos_egresos WHERE concepto LIKE '%prueba%');
DELETE FROM ingresos_egresos WHERE concepto LIKE '%prueba%';
```

---

## ⚠️ NOTAS IMPORTANTES

1. **El RUC debe existir en la tabla `clientes`** para que autocomplete la razón social
2. **Para transacciones EMPRESARIALES**, el RUC y razón social son obligatorios
3. **Para transacciones PERSONAL**, el RUC puede quedar vacío
4. **Las cuotas se generan automáticamente** según la frecuencia seleccionada
5. **El sistema calcula automáticamente** el monto de cada cuota (monto_total / numero_cuotas)

---

## 📁 ARCHIVOS RELACIONADOS

- `BASE-DATOS/modulo_flujo_caja.sql` - Script de creación de tablas y menú
- `registrar-movimiento.php` - Formulario de registro
- `config/buscar-ruc.php` - Validación de RUC
- `config/proceso-guardar.php` - Lógica de guardado (línea 2708)
- `listado-movimientos.php` - Visualización de movimientos

---

## 🎯 PRÓXIMOS PASOS

Una vez completadas las pruebas de la Historia 4:
- ✅ Verificar que todos los criterios de aceptación se cumplen
- ✅ Documentar cualquier bug encontrado
- ✅ Solicitar aprobación para pasar a Historia 1, 2 o 3

---

**Documento preparado para pruebas de integración.**  
**Cualquier problema reportar inmediatamente para corrección.**
