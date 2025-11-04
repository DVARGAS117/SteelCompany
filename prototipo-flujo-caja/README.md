# 💰 PROTOTIPO - MÓDULO FLUJO DE CAJA

## 📋 Descripción

Este es un **prototipo funcional** del módulo de Flujo de Caja para el sistema SmartSteel. Utiliza datos temporales almacenados en el navegador (localStorage) para demostrar todas las funcionalidades sin necesidad de base de datos o backend.

## 🎯 Propósito

- **Demostración visual** del módulo completo
- **Pruebas de funcionalidad** sin afectar datos reales
- **Presentación a clientes/stakeholders**
- **Validación de UX/UI** antes de la implementación final

## ✨ Características Implementadas

### 1. Dashboard Financiero
- ✅ Visualización de Ingresos, Egresos y Saldo Neto
- ✅ Filtros por Cuenta (Todas/Empresarial/Personal) y Mes
- ✅ Gráfico de barras por clasificación
- ✅ Últimas transacciones registradas
- ✅ Cuotas pendientes con alertas de vencimiento
- ✅ Funcionalidad de marcar cuotas como pagadas

### 2. Registrar Movimiento
- ✅ Formulario completo con validaciones
- ✅ Tipos: Ingreso/Egreso
- ✅ Clasificación: Empresarial/Personal
- ✅ Autocompletado de RUC (simulado)
- ✅ Pago único o en cuotas
- ✅ Frecuencias: Mensual/Quincenal/Semanal/Personalizado
- ✅ Categorías predefinidas
- ✅ Campo especial para Fraccionamiento SUNAT
- ✅ Generación automática de cuotas

### 3. Listado de Movimientos
- ✅ Tabla DataTable con búsqueda y paginación
- ✅ Exportación a Excel, PDF, CSV
- ✅ Visualización completa de todos los movimientos
- ✅ Modal para ver cuotas de cada movimiento
- ✅ Marcar cuotas como pagadas desde el listado

## 🚀 Instalación y Uso

### Opción 1: Servidor Web Local (Recomendado)

1. Copiar la carpeta `prototipo-flujo-caja` a tu servidor web:
   ```
   c:\xampp\htdocs\smartsteel.pe\prototipo-flujo-caja
   ```

2. Abrir en el navegador:
   ```
   http://localhost/smartsteel.pe/prototipo-flujo-caja/
   ```

### Opción 2: Abrir Directamente

También puedes abrir el archivo `index.html` directamente en el navegador, pero algunas funcionalidades pueden estar limitadas.

## 📊 Datos de Ejemplo

El prototipo incluye 5 movimientos de ejemplo:

1. **Venta de vigas de acero** - Ingreso Empresarial (S/ 15,000 - 3 cuotas)
2. **Compra de materia prima** - Egreso Empresarial (S/ 8,500 - 2 cuotas)
3. **Pago de luz** - Egreso Empresarial (S/ 1,250 - 1 cuota)
4. **Venta de tubos** - Ingreso Empresarial (S/ 12,800 - 4 cuotas)
5. **Préstamo personal** - Egreso Personal (S/ 3,000 - 6 cuotas)

### RUCs de Prueba para Autocompletado

- **20123456789** → ACEROS DEL PERÚ S.A.C.
- **20987654321** → CONSTRUCTORA LOS ANDES E.I.R.L.
- **20555666777** → INMOBILIARIA PACIFIC S.A.
- **20111222333** → INDUSTRIAS METALÚRGICAS S.A.
- **20444555666** → COMERCIAL FERRETEK S.A.C.

## 🔄 Almacenamiento de Datos

Los datos se almacenan en **localStorage** del navegador con la clave `datosFlujoCaja`.

### Para reiniciar los datos:
1. Abre la consola del navegador (F12)
2. Ejecuta: `localStorage.removeItem('datosFlujoCaja')`
3. Recarga la página

### Para ver los datos actuales:
```javascript
console.log(JSON.parse(localStorage.getItem('datosFlujoCaja')));
```

## 🎨 Tecnologías Utilizadas

- **HTML5** - Estructura
- **CSS3** - Estilos personalizados
- **Bootstrap 5.3** - Framework CSS
- **JavaScript (Vanilla)** - Lógica del frontend
- **jQuery 3.7** - Para DataTables
- **DataTables** - Tablas interactivas
- **Remix Icons** - Iconografía
- **localStorage** - Persistencia temporal de datos

## 📦 Estructura de Archivos

```
prototipo-flujo-caja/
├── index.html                      # Página de inicio
├── dashboard.html                  # Dashboard financiero
├── registrar-movimiento.html       # Formulario de registro
├── listado-movimientos.html        # Tabla de movimientos
├── README.md                       # Este archivo
└── assets/
    ├── css/
    │   └── styles.css             # Estilos personalizados
    └── js/
        ├── datos-temporales.js    # Manejo de datos en localStorage
        ├── dashboard.js           # Lógica del dashboard
        ├── registrar-movimiento.js # Lógica del formulario
        └── listado-movimientos.js  # Lógica de la tabla
```

## ⚠️ Limitaciones

Este es un **prototipo** y tiene las siguientes limitaciones:

- ❌ No hay autenticación ni sesiones
- ❌ No hay validación de permisos
- ❌ Los datos se pierden al limpiar el navegador
- ❌ No hay conexión a base de datos real
- ❌ No hay integración con SUNAT
- ❌ No hay reportes avanzados
- ❌ No hay auditoría de cambios

## 🔐 Seguridad

**IMPORTANTE:** Este prototipo NO debe usarse en producción. Es solo para demostración y pruebas.

## 📞 Soporte

Para implementar este módulo en el sistema real con base de datos, contacta al equipo de desarrollo.

## 📝 Notas para Desarrolladores

### Para integrar al sistema real:

1. Reemplazar `datos-temporales.js` con llamadas AJAX a PHP
2. Implementar endpoints en `config/` para:
   - `obtener-datos-dashboard.php`
   - `proceso-guardar.php` (módulo MovimientosFinancieros)
   - `marcar-cuota-pagada.php`
   - `buscar-ruc.php`
3. Agregar validaciones de sesión y permisos
4. Implementar manejo de errores robusto
5. Agregar logging y auditoría

### Estructura de datos esperada:

**Tabla: ingresos_egresos**
- id_movimiento (PK)
- fecha_creacion
- tipo (INGRESO/EGRESO)
- clasificacion (EMPRESARIAL/PERSONAL)
- ruc
- razon_social
- concepto
- categoria
- monto_total
- numero_cuotas
- frecuencia_cuotas
- fecha_primera_cuota
- numero_resolucion
- notas
- estado

**Tabla: cuotas_movimientos**
- id_cuota (PK)
- id_movimiento (FK)
- numero_cuota
- monto_cuota
- fecha_vencimiento
- estado (PENDIENTE/PAGADA)
- fecha_pago
- fecha_creacion

## 🎉 ¡Disfruta del Prototipo!

Este prototipo demuestra todas las funcionalidades principales del módulo de Flujo de Caja de forma visual e interactiva.

---
**Versión:** 1.0  
**Fecha:** 29 de octubre de 2025  
**Desarrollado para:** SmartSteel.pe
