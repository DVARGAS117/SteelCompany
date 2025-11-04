# Documentación - Gestión de Detalle de Cuotas

## Descripción General
Funcionalidad implementada para permitir la gestión individual de cuotas en el módulo de Flujo de Caja. Permite visualizar, editar, pagar, revertir y eliminar cuotas de forma independiente.

## Fecha de Implementación
2 de noviembre de 2025

## Rama de Desarrollo
`feature/gestion-detalle-cuotas`

---

## Archivos Modificados/Creados

### 1. **ajax/obtener-cuotas-movimiento.php** (NUEVO)
- **Propósito**: Obtener información del movimiento y sus cuotas asociadas
- **Método**: POST
- **Parámetros de entrada**:
  - `id_movimiento` (int): ID del movimiento a consultar
- **Respuesta JSON**:
  ```json
  {
    "success": true/false,
    "message": "Mensaje de error (si aplica)",
    "movimiento": { objeto con datos del movimiento },
    "cuotas": [ array con las cuotas ]
  }
  ```

### 2. **ajax/gestionar-cuota.php** (NUEVO)
- **Propósito**: Gestionar operaciones sobre cuotas individuales
- **Método**: POST
- **Acciones disponibles**:

#### a) Editar Monto (`accion: 'editar'`)
- **Parámetros**:
  - `id_cuota` (int): ID de la cuota
  - `nuevo_monto` (decimal): Nuevo monto a asignar
- **Comportamiento**:
  - Actualiza el monto de la cuota específica
  - Recalcula el `monto_total` del movimiento sumando todas las cuotas
  - Actualiza `fecha_actualizacion` y `cod_personal`
- **Advertencia**: Muestra mensaje indicando que el monto total variará

#### b) Pagar Cuota (`accion: 'pagar'`)
- **Parámetros**:
  - `id_cuota` (int): ID de la cuota
- **Comportamiento**:
  - Cambia estado de la cuota a `PAGADA`
  - Registra `fecha_pago` con la fecha actual
  - Valida que la cuota no esté ya pagada

#### c) Revertir Pago (`accion: 'revertir'`)
- **Parámetros**:
  - `id_cuota` (int): ID de la cuota
- **Comportamiento**:
  - Cambia estado de `PAGADA` a `PENDIENTE` o `VENCIDA`
  - Evalúa la fecha de vencimiento vs fecha actual para determinar el nuevo estado
  - Limpia el campo `fecha_pago` (NULL)
  - Solo permite revertir cuotas con estado `PAGADA`

#### d) Eliminar Cuota (`accion: 'eliminar'`)
- **Parámetros**:
  - `id_cuota` (int): ID de la cuota
- **Comportamiento**:
  - Elimina físicamente la cuota de la base de datos
  - Recalcula el `monto_total` del movimiento con las cuotas restantes
  - Actualiza el `numero_cuotas` del movimiento
  - Advierte que el monto total y número de cuotas cambiarán

### 3. **listado-movimientos.php** (MODIFICADO)
- **Cambios principales**:
  - Agregado SweetAlert2 para confirmaciones y alertas
  - Implementado modal principal `#modalCuotas` para mostrar cuotas
  - Implementado modal secundario `#modalEditarCuota` para editar montos
  - Función JavaScript `verCuotas(id_movimiento)` ahora funcional
  - Nuevas funciones JavaScript:
    - `cargarInfoMovimiento()`: Muestra datos del movimiento en el modal
    - `cargarCuotas()`: Renderiza la tabla de cuotas
    - `abrirModalEditarCuota()`: Abre modal de edición
    - `confirmarEditarCuota()`: Valida y confirma edición con advertencia
    - `editarCuota()`: Ejecuta la edición vía AJAX
    - `pagarCuota()`: Marca cuota como pagada
    - `revertirCuota()`: Revierte cuota pagada
    - `eliminarCuota()`: Elimina cuota con confirmación

---

## Funcionalidades Implementadas

### 1. Visualización de Cuotas
- Al presionar el botón "Ver Cuotas" en la columna "Acción":
  - Se abre un modal XL con información completa
  - Muestra datos del movimiento principal (tipo, clasificación, RUC, razón social, concepto, categoría, monto total)
  - Lista todas las cuotas en una tabla con:
    - Número de cuota
    - Monto individual
    - Fecha de vencimiento
    - Fecha de pago (si aplica)
    - Estado (PENDIENTE/PAGADA/VENCIDA)
    - Botones de acción según el estado

### 2. Editar Monto de Cuota
- Botón "Editar" disponible para todas las cuotas
- Abre modal secundario con:
  - Input para nuevo monto
  - Visualización del monto actual
  - Advertencia clara sobre recálculo del monto total
- Confirmación adicional mediante SweetAlert2
- Si la suma de cuotas no coincide con el monto original, muestra advertencia
- Usuario decide si continuar o mantener valores

### 3. Pagar Cuota
- Botón "Pagar" solo visible en cuotas PENDIENTE o VENCIDA
- Confirmación mediante SweetAlert2
- Marca la cuota como PAGADA con fecha actual
- Actualiza visualmente el estado en la tabla

### 4. Revertir Pago
- Botón "Revertir" solo visible en cuotas PAGADAS
- Confirmación mediante SweetAlert2
- Vuelve la cuota a estado PENDIENTE o VENCIDA según fecha
- Limpia la fecha de pago

### 5. Eliminar Cuota
- Botón "Eliminar" disponible para todas las cuotas
- Doble confirmación:
  1. Advertencia sobre recálculo de monto total y número de cuotas
  2. Confirmación final de eliminación
- Elimina físicamente la cuota
- Actualiza automáticamente el movimiento principal

---

## Validaciones Implementadas

### Backend (PHP)
1. **Editar Monto**:
   - Valida que el nuevo monto sea mayor a 0
   - Valida que exista el ID de cuota
   - Recalcula y actualiza el monto total automáticamente

2. **Pagar Cuota**:
   - Valida que la cuota no esté ya pagada
   - Registra fecha de pago actual

3. **Revertir Cuota**:
   - Solo permite revertir cuotas con estado PAGADA
   - Determina automáticamente nuevo estado según fecha de vencimiento

4. **Eliminar Cuota**:
   - Recalcula monto total con cuotas restantes
   - Actualiza el número de cuotas del movimiento

### Frontend (JavaScript)
1. Validación de montos positivos en modal de edición
2. Confirmaciones con SweetAlert2 antes de cada acción destructiva
3. Advertencias claras sobre cambios en el monto total
4. Feedback visual inmediato después de cada operación

---

## Advertencias y Mensajes al Usuario

### 1. Al Editar Monto
```
⚠️ Advertencia: Al modificar el monto de esta cuota, 
el monto total del movimiento será recalculado automáticamente.

¿Desea continuar?
[Cancelar] [Sí, continuar]
```

### 2. Al Eliminar Cuota
```
⚠️ ¿Eliminar cuota?

Al eliminar esta cuota:
- El número total de cuotas se reducirá
- El monto total del movimiento será recalculado

¿Desea continuar?
[Cancelar] [Sí, eliminar]
```

### 3. Cuando No Coincide el Monto Total
```
⚠️ El monto de las cuotas no corresponde con el monto total original.

Monto original: S/ X,XXX.XX
Suma de cuotas: S/ Y,YYY.YY

¿Desea continuar con el cambio? El monto total se actualizará.
[Mantener original] [Continuar]
```

---

## Base de Datos

### Tablas Involucradas

#### `ingresos_egresos`
- Campos actualizados por esta funcionalidad:
  - `monto_total`: Se recalcula al editar o eliminar cuotas
  - `numero_cuotas`: Se actualiza al eliminar cuotas
  - `fecha_actualizacion`: Se actualiza en cada cambio

#### `cuotas_movimientos`
- Campos actualizados:
  - `monto_cuota`: Editable
  - `fecha_pago`: Se registra al pagar, se limpia al revertir
  - `estado`: PENDIENTE → PAGADA → PENDIENTE/VENCIDA
  - `fecha_actualizacion`: Se actualiza en cada cambio
  - `cod_personal`: Registra quién hizo el cambio

---

## Flujos de Trabajo

### Flujo: Pago Parcial
**Escenario**: Cliente debía pagar S/ 500 pero solo pagó S/ 400

1. Usuario abre detalle de cuotas del movimiento
2. Click en "Editar" en la cuota correspondiente
3. Cambia monto de S/ 500 a S/ 400
4. Sistema advierte que monto total cambiará
5. Usuario confirma
6. Click en "Pagar" para marcar como pagada
7. Cuota queda como PAGADA con S/ 400
8. Monto total del movimiento se ajusta automáticamente

### Flujo: Corrección de Error
**Escenario**: Se marcó como pagada por error

1. Usuario abre detalle de cuotas
2. Identifica la cuota marcada incorrectamente
3. Click en "Revertir"
4. Sistema solicita confirmación
5. Usuario confirma
6. Cuota vuelve a estado PENDIENTE o VENCIDA
7. Fecha de pago se limpia

---

## Tecnologías Utilizadas

- **Backend**: PHP + MySQL
- **Frontend**: 
  - HTML5
  - CSS3 (Bootstrap 5)
  - JavaScript (jQuery)
  - SweetAlert2 para alertas y confirmaciones
- **Iconos**: RemixIcon
- **DataTables**: Para la tabla principal de movimientos

---

## Consideraciones de Seguridad

1. **Validación de Sesión**: Todos los archivos AJAX verifican sesión activa
2. **Validación de Datos**: Validación en cliente y servidor
3. **SQL Injection**: Uso de variables escapadas y conversiones de tipo
4. **Auditoría**: Se registra `cod_personal` y `fecha_actualizacion` en cada cambio

---

## Mejoras Futuras Sugeridas

1. **Historial de Cambios**: Tabla de auditoría para registrar todos los cambios en cuotas
2. **Notificaciones**: Enviar notificaciones cuando se modifiquen cuotas
3. **Validación de Suma**: Opción para forzar que la suma de cuotas coincida con el total
4. **Agregar Cuotas**: Permitir agregar nuevas cuotas a un movimiento existente
5. **Exportación**: Exportar detalle de cuotas a Excel/PDF
6. **Comentarios**: Permitir agregar comentarios/notas a cada cambio de cuota

---

## Pruebas Recomendadas

### Casos de Prueba

1. **Test 1**: Editar monto de cuota y verificar recálculo de total
2. **Test 2**: Marcar varias cuotas como pagadas
3. **Test 3**: Revertir una cuota pagada
4. **Test 4**: Eliminar una cuota y verificar actualización de total y número
5. **Test 5**: Editar cuota con monto inválido (negativo, cero)
6. **Test 6**: Intentar pagar una cuota ya pagada
7. **Test 7**: Intentar revertir una cuota no pagada
8. **Test 8**: Verificar que los cambios se reflejen en la tabla principal

---

## Notas de Implementación

- La funcionalidad está completamente integrada con el sistema existente
- No se requieren cambios en la estructura de la base de datos
- Compatible con el diseño y estilo actual del sistema
- Usa las mismas convenciones de código del proyecto
- Los cambios son retrocompatibles

---

## Autor
Implementado en la rama `feature/gestion-detalle-cuotas`

## Fecha
2 de noviembre de 2025
