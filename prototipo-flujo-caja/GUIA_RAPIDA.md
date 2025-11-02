# 🚀 GUÍA RÁPIDA DE USO

## Acceso al Prototipo

**URL Local:**
```
http://localhost/smartsteel.pe/prototipo-flujo-caja/
```

**O si tienes un puerto específico:**
```
http://localhost:8080/smartsteel.pe/prototipo-flujo-caja/
```

---

## 📱 Navegación Rápida

### Página de Inicio
- Presenta el módulo y opciones principales
- Enlace directo al Dashboard y Registro

### Dashboard Financiero
**Ruta:** `dashboard.html`

**Funcionalidades:**
1. Ver resumen de Ingresos, Egresos y Saldo Neto
2. Filtrar por cuenta (Todas/Empresarial/Personal)
3. Filtrar por mes
4. Ver gráfico comparativo
5. Ver últimas transacciones
6. **Marcar cuotas pendientes como pagadas**

**Cómo marcar una cuota como pagada:**
- Busca la sección "Cuotas Pendientes"
- Clic en botón verde "Marcar Pagada"
- Confirma la acción
- Los datos del dashboard se actualizan automáticamente

### Registrar Movimiento
**Ruta:** `registrar-movimiento.html`

**Pasos:**
1. Seleccionar Tipo (Ingreso/Egreso)
2. Seleccionar Clasificación (Empresarial/Personal)
3. Ingresar RUC (opcional, se autocompleta razón social)
4. Ingresar Concepto del movimiento
5. Ingresar Monto Total
6. **Opcional:** Marcar "Pago en cuotas" y configurar:
   - Número de cuotas
   - Frecuencia (Mensual/Quincenal/Semanal)
   - Fecha de primera cuota
7. Seleccionar Categoría
8. Agregar notas adicionales (opcional)
9. Clic en "Guardar Movimiento"

**RUCs de prueba para autocompletado:**
- 20123456789 → ACEROS DEL PERÚ S.A.C.
- 20987654321 → CONSTRUCTORA LOS ANDES E.I.R.L.
- 20555666777 → INMOBILIARIA PACIFIC S.A.

### Listado de Movimientos
**Ruta:** `listado-movimientos.html`

**Funcionalidades:**
1. Ver tabla completa de movimientos
2. Buscar por cualquier campo
3. Ordenar por columnas
4. **Exportar a Excel, PDF, CSV**
5. Ver cuotas de cada movimiento (botón con ícono de lista)
6. Marcar cuotas como pagadas desde el modal

**Cómo ver cuotas de un movimiento:**
- Clic en el botón azul con ícono de lista (📋)
- Se abre modal con todas las cuotas
- Puedes marcar cuotas como pagadas desde aquí

---

## 🎯 Flujo de Trabajo Recomendado

### Para Demostración Completa:

1. **Inicio** → `index.html`
   - Mostrar la página de bienvenida

2. **Dashboard** → `dashboard.html`
   - Mostrar las tarjetas de resumen
   - Cambiar filtros para ver actualizaciones en tiempo real
   - Mostrar gráfico de barras
   - Scroll hacia abajo para ver cuotas pendientes
   - **DEMO:** Marcar una cuota como pagada y ver cómo actualiza el dashboard

3. **Registrar Movimiento** → `registrar-movimiento.html`
   - Llenar formulario completo
   - **DEMO 1:** Crear movimiento empresarial con RUC
   - **DEMO 2:** Crear movimiento con cuotas (activar checkbox)
   - Guardar y ver redirección automática

4. **Listado** → `listado-movimientos.html`
   - Mostrar el movimiento recién creado
   - Usar búsqueda para filtrar
   - **DEMO:** Exportar a Excel o PDF
   - Abrir modal de cuotas
   - Marcar cuota como pagada desde el modal

---

## 💡 Casos de Uso Demostrativos

### Caso 1: Venta Empresarial con Cuotas
```
Tipo: INGRESO
Clasificación: EMPRESARIAL
RUC: 20111222333
Concepto: Venta de estructuras metálicas
Monto: S/ 20,000.00
Cuotas: 5 cuotas mensuales
```

### Caso 2: Gasto Personal
```
Tipo: EGRESO
Clasificación: PERSONAL
Sin RUC
Concepto: Pago de préstamo personal
Monto: S/ 2,500.00
Pago único
```

### Caso 3: Fraccionamiento SUNAT
```
Tipo: EGRESO
Clasificación: EMPRESARIAL
RUC: (vacío o de SUNAT)
Concepto: Pago fraccionado de impuestos
Categoría: FRACCIONAMIENTO_SUNAT
Número Resolución: RES-2025-0001234
Monto: S/ 15,000.00
Cuotas: 12 cuotas mensuales
```

---

## 🔄 Reiniciar Datos

Si deseas volver a los datos de ejemplo originales:

1. Abre la consola del navegador (F12)
2. Ve a la pestaña "Console"
3. Ejecuta:
   ```javascript
   localStorage.removeItem('datosFlujoCaja');
   ```
4. Recarga la página (F5)

---

## ⚡ Atajos de Teclado

- **F5** → Recargar página
- **F12** → Abrir consola de desarrollo
- **Ctrl + F** → Buscar en DataTable

---

## 🎨 Características Visuales

### Códigos de Color:

- **Azul** → Empresarial
- **Cyan** → Personal
- **Verde** → Ingresos / Pagado / Activo
- **Rojo** → Egresos / Vencido
- **Amarillo** → Próximo a vencer (≤3 días)

### Estados de Cuotas:

- 🟢 **Verde** → Pagada
- 🟡 **Amarillo** → Pendiente (próxima a vencer)
- 🔴 **Rojo** → Vencida
- 🔵 **Azul** → Pendiente (normal)

---

## 📊 Datos Incluidos

El prototipo viene con **5 movimientos** y **16 cuotas** de ejemplo:

1. Venta de vigas (3 cuotas) - 1 pagada
2. Compra de materia prima (2 cuotas) - 1 pagada
3. Pago de luz (1 cuota)
4. Venta de tubos (4 cuotas)
5. Préstamo personal (6 cuotas)

---

## 🐛 Troubleshooting

### Los datos no se guardan
- Verifica que el navegador permita localStorage
- Revisa la consola de errores (F12)

### El autocompletado de RUC no funciona
- Solo funcionan los RUCs de prueba listados arriba
- Puedes escribir la razón social manualmente

### La tabla no se muestra correctamente
- Recarga la página
- Verifica que JavaScript esté habilitado

---

## 📞 Contacto

Para preguntas sobre la implementación real del módulo, contacta al equipo de desarrollo.

---

**¡Disfruta demostrando el prototipo! 🚀**
