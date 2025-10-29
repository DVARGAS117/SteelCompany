# PRUEBAS - HISTORIA 2: MARCADO DE CUOTAS EN DASHBOARD

**Fecha:** 29 de octubre de 2025  
**Issue:** #2 - Usuario operativo - Marcado de cuotas en dashboard  
**Branch:** testing

---

## 🎯 OBJETIVO DE LA HISTORIA

Permitir marcar cuotas individuales como pagadas/recibidas directamente desde el dashboard, para que el sistema actualice el saldo según el avance real.

**REGLA CLAVE:** El monto solo se refleja en el saldo cuando la cuota se marca como PAGADA, sin importar si la fecha ya pasó.

---

## 📋 CRITERIOS DE ACEPTACIÓN

### ✅ Scenario 1: Marcar cuota como pagada (ingreso o egreso parcial)

**Given:** Una transacción registrada con varias cuotas pendientes  
**When:** El usuario marca una cuota específica como pagada o recibida desde el dashboard  
**Then:** El sistema actualiza el estado de esa cuota y refleja ese ingreso/egreso en los saldos y reportes

### ✅ Scenario 2: Error al marcar una cuota ya pagada

**Given:** Una cuota previamente marcada como pagada  
**When:** El usuario intenta marcarla nuevamente como pagada  
**Then:** El sistema debe impedir la acción e informar que la cuota ya fue registrada como pagada

---

## 📁 ARCHIVOS CREADOS/MODIFICADOS

1. **dashboard-ingresos-egresos.php**
   - Dashboard principal con filtros por cuenta y mes
   - Tarjetas de resumen (Ingresos, Egresos, Saldo Neto)
   - Gráfico de barras por clasificación
   - Lista de últimas transacciones
   - Sección de cuotas pendientes con botón "Marcar Pagada"

2. **config/obtener-datos-dashboard.php**
   - Calcula ingresos y egresos basado SOLO en cuotas PAGADAS
   - Usa `YEAR(c.fecha_pago)` y `MONTH(c.fecha_pago)` para el filtro mensual
   - Filtra por clasificación (Empresarial/Personal/Todas)
   - Retorna JSON con todos los datos del dashboard

3. **config/marcar-cuota-pagada.php**
   - Valida que la cuota exista
   - Verifica que NO esté ya pagada (criterio de aceptación #2)
   - Actualiza estado a 'PAGADA' y registra fecha_pago
   - Retorna JSON con success/error

4. **BASE-DATOS/registrar_modulo_flujo_caja.sql**
   - Script SQL para registrar el módulo en el sistema
   - Inserta módulo "Flujo de Caja" con ícono
   - Crea 3 submenús (Dashboard, Registrar, Listado)

---

## 🔍 LÓGICA CLAVE IMPLEMENTADA

### Cálculo de Saldos (obtener-datos-dashboard.php)

```sql
-- INGRESOS: Solo cuotas PAGADAS de tipo INGRESO
SELECT COALESCE(SUM(c.monto_cuota), 0) as total
FROM cuotas_movimientos c
INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
WHERE m.tipo = 'INGRESO'
  AND c.estado = 'PAGADA'  -- ← CRUCIAL
  AND YEAR(c.fecha_pago) = $anio
  AND MONTH(c.fecha_pago) = $numMes
```

**Importante:**
- Se usa `fecha_pago` (no `fecha_vencimiento`) para el filtro mensual
- Solo cuenta cuotas con estado = 'PAGADA'
- Si la cuota está PENDIENTE aunque la fecha haya pasado, NO afecta el saldo

### Validación de Cuota Ya Pagada (marcar-cuota-pagada.php)

```php
// Verificar estado actual
$sqlVerificar = "SELECT estado FROM cuotas_movimientos WHERE id_cuota = $id_cuota";
$cuota = mysqli_fetch_assoc($resultado);

if ($cuota['estado'] === 'PAGADA') {
    echo json_encode(array(
        'success' => false,
        'mensaje' => 'Esta cuota ya fue registrada como pagada anteriormente'
    ));
    exit;
}
```

---

## 🧪 PASOS PARA PROBAR

### Preparación:

1. **Registrar el módulo en BD:**
   ```bash
   # Ejecutar en phpMyAdmin o MySQL Workbench
   # Archivo: BASE-DATOS/registrar_modulo_flujo_caja.sql
   
   # IMPORTANTE: Antes de ejecutar, descomentar y ajustar:
   # SET @cod_personal_admin = 1; -- Cambiar por tu ID de usuario
   ```

2. **Verificar que existan transacciones con cuotas:**
   ```sql
   SELECT * FROM ingresos_egresos;
   SELECT * FROM cuotas_movimientos WHERE estado = 'PENDIENTE';
   ```

### Prueba 1: Verificar que el saldo NO incluya cuotas pendientes

1. Acceder al dashboard: `dashboard-ingresos-egresos.php`
2. Verificar las tarjetas de resumen
3. Confirmar que los montos mostrados corresponden SOLO a cuotas PAGADAS
4. Verificar con SQL:
   ```sql
   -- Esto debe coincidir con lo mostrado en el dashboard
   SELECT SUM(monto_cuota) FROM cuotas_movimientos 
   WHERE estado = 'PAGADA' 
   AND YEAR(fecha_pago) = 2025 
   AND MONTH(fecha_pago) = 10;
   ```

### Prueba 2: Marcar una cuota como pagada

1. En el dashboard, ubicar la sección "Cuotas Pendientes"
2. Identificar una cuota con estado PENDIENTE
3. Hacer clic en el botón "Marcar Pagada"
4. Confirmar la acción en el diálogo
5. **Resultado esperado:**
   - Mensaje: "Cuota marcada como pagada exitosamente"
   - El dashboard se recarga automáticamente
   - Los totales se actualizan incluyendo esa cuota
   - La cuota desaparece de la lista de pendientes

### Prueba 3: Intentar marcar una cuota ya pagada (Criterio #2)

1. Obtener el ID de una cuota ya PAGADA:
   ```sql
   SELECT id_cuota FROM cuotas_movimientos WHERE estado = 'PAGADA' LIMIT 1;
   ```
2. Intentar marcarla nuevamente usando la consola del navegador:
   ```javascript
   $.post('config/marcar-cuota-pagada.php', {id_cuota: 123}, function(data) {
       console.log(data);
   });
   ```
3. **Resultado esperado:**
   ```json
   {
       "success": false,
       "mensaje": "Esta cuota ya fue registrada como pagada anteriormente"
   }
   ```

### Prueba 4: Verificar filtros

1. Cambiar filtro de cuenta a "Solo Empresarial"
2. Verificar que solo muestre movimientos empresariales
3. Cambiar filtro de mes
4. Verificar que los cálculos cambien correctamente

### Prueba 5: Verificar el gráfico de barras

1. Cambiar a filtro "Todas las Cuentas"
2. Verificar que el gráfico muestre:
   - Barra azul (Empresarial) con el saldo neto empresarial
   - Barra verde (Personal) con el saldo neto personal
3. Los porcentajes deben ser proporcionales al valor mayor

---

## 🔬 CONSULTAS SQL ÚTILES PARA VERIFICACIÓN

### Ver todas las cuotas de un movimiento
```sql
SELECT 
    c.*,
    m.concepto,
    m.razon_social,
    m.tipo
FROM cuotas_movimientos c
INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
WHERE m.id_movimiento = [ID];
```

### Ver cuotas pendientes de este mes
```sql
SELECT 
    c.id_cuota,
    c.numero_cuota,
    c.monto_cuota,
    c.fecha_vencimiento,
    c.estado,
    m.concepto,
    DATEDIFF(c.fecha_vencimiento, CURDATE()) as dias_restantes
FROM cuotas_movimientos c
INNER JOIN ingresos_egresos m ON c.id_movimiento = m.id_movimiento
WHERE c.estado = 'PENDIENTE'
ORDER BY c.fecha_vencimiento ASC;
```

### Ver resumen de pagos por mes
```sql
SELECT 
    YEAR(fecha_pago) as anio,
    MONTH(fecha_pago) as mes,
    COUNT(*) as total_cuotas,
    SUM(monto_cuota) as monto_total
FROM cuotas_movimientos
WHERE estado = 'PAGADA'
GROUP BY YEAR(fecha_pago), MONTH(fecha_pago)
ORDER BY anio DESC, mes DESC;
```

---

## ✅ CHECKLIST DE PRUEBAS

- [ ] Dashboard carga correctamente
- [ ] Filtros funcionan (Cuenta y Mes)
- [ ] Tarjetas muestran valores correctos (solo cuotas PAGADAS)
- [ ] Gráfico de barras se actualiza con los filtros
- [ ] Últimas transacciones se muestran correctamente
- [ ] Cuotas pendientes aparecen con colores según urgencia (rojo/naranja/azul)
- [ ] Botón "Marcar Pagada" funciona
- [ ] Al marcar una cuota, el saldo se actualiza inmediatamente
- [ ] No se puede marcar una cuota ya pagada (muestra error)
- [ ] La fecha_pago se registra correctamente en BD
- [ ] Los montos NO se afectan hasta marcar como PAGADA

---

## 🐛 POSIBLES PROBLEMAS Y SOLUCIONES

### Error: "No se puede cargar el dashboard"
- Verificar que las tablas `ingresos_egresos` y `cuotas_movimientos` existan
- Revisar la consola del navegador (F12) para ver errores AJAX
- Verificar que el archivo `config/obtener-datos-dashboard.php` tenga permisos de lectura

### Error: "Cuota no se marca como pagada"
- Verificar que el `id_cuota` sea correcto
- Revisar la consola del navegador para ver la respuesta del servidor
- Verificar que la tabla `cuotas_movimientos` tenga los campos `fecha_pago` y `fecha_actualizacion`

### Los saldos no coinciden
- Ejecutar las queries SQL manualmente para verificar
- Revisar el filtro de mes (debe usar `fecha_pago`, no `fecha_vencimiento`)
- Verificar que solo cuente cuotas con estado = 'PAGADA'

---

## 📊 RESULTADOS ESPERADOS

Al finalizar las pruebas, el sistema debe cumplir:

✅ **Criterio 1 cumplido:** Se pueden marcar cuotas como pagadas y el saldo se actualiza inmediatamente  
✅ **Criterio 2 cumplido:** No se pueden marcar cuotas ya pagadas (muestra mensaje de error)  
✅ **Lógica clave:** Los montos SOLO afectan el saldo cuando la cuota está marcada como PAGADA, sin importar la fecha de vencimiento

---

## 🚀 PRÓXIMOS PASOS

Una vez aprobada esta historia, se puede continuar con:
- **Historia 3:** Sistema responsive y sin datos ficticios
- Integración de alertas en la campana de notificaciones
- Módulo de reportes en PDF/Excel

---

**Documento de pruebas para Historia 2 - Issue #2**  
**Estado:** ✅ Implementado - Pendiente de pruebas
