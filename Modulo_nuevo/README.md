# Módulo de Gestión de Ingresos y Egresos - Maqueta

Esta es una maqueta funcional del módulo de gestión de ingresos y egresos con funcionalidades básicas implementadas.

## Archivos del Proyecto

- `index.html` - Estructura HTML con las tres vistas principales
- `styles.css` - Estilos y diseño responsive
- `script.js` - Lógica de la aplicación y manejo de datos

## Características Implementadas

### 1. Dashboard 📊
- Tarjetas con resumen de ingresos, egresos y saldo neto
- **Filtro por cuenta**: Ver todas, solo empresarial o solo personal
- Filtro por mes
- Gráfico de barras mostrando desglose por tipo (Empresarial vs Personal)
- Lista de últimas transacciones con detalles
- **Nueva sección de cuotas pendientes** con estado visual (vencida, próxima, normal)
- Posibilidad de marcar cuotas como pagadas directamente desde el dashboard
- Actualización automática al agregar nuevas transacciones

### 2. Registro de Transacciones 📝
- Formulario completo para registrar ingresos y egresos
- **Sistema de cuotas**: Soporte para pagos/cobros en múltiples cuotas
- Campos para:
  - Tipo de transacción (Ingreso/Egreso)
  - Clasificación (Empresarial/Personal)
  - RUC y Razón Social del cliente/proveedor
  - Concepto detallado
  - **Monto total y número de cuotas**
  - **Frecuencia de cuotas** (Mensual, Quincenal, Semanal, Personalizado)
  - Fecha de primera cuota/pago
  - Categoría (Venta, Servicio, Compra, Servicios básicos, Planilla, Fraccionamiento SUNAT, Crédito, Otros)
  - Número de resolución (para fraccionamientos SUNAT)
  - Notas adicionales
- Validación de campos requeridos
- **Generación automática de cuotas** con fechas calculadas según frecuencia
- Guardado en almacenamiento local (LocalStorage)

### 3. Sistema de Alertas 🔔
- Visualización de pagos pendientes
- Filtros por período:
  - Próximos 3 días
  - Próximos 7 días
  - Esta quincena
  - Este mes
- Alertas con código de colores según urgencia:
  - Rojo: 2 días o menos
  - Naranja: 3-7 días
- Detalles completos de cada pago pendiente

## Cómo Usar

1. Abre el archivo `index.html` en tu navegador web
2. La aplicación viene con datos de ejemplo pre-cargados
3. Navega entre las diferentes secciones usando los botones del menú superior

### Navegación
- **Dashboard**: Vista principal con resumen y gráficos
- **Registrar Transacción**: Formulario para agregar nuevas transacciones
- **Alertas**: Listado de pagos pendientes y recordatorios

## Características Técnicas

- **Almacenamiento**: Utiliza LocalStorage del navegador para persistir datos
- **Responsive**: Diseño adaptable a dispositivos móviles y tablets
- **Sin dependencias**: Desarrollado con HTML, CSS y JavaScript vanilla (sin frameworks)
- **Datos de ejemplo**: Se cargan automáticamente para demostración

## Datos de Ejemplo Incluidos

La aplicación incluye 6 transacciones de ejemplo con cuotas:
1. Ingreso por venta empresarial (S/ 6,000) - **3 cuotas mensuales**
2. Egreso por servicio de luz (S/ 450) - Pago único
3. Egreso personal - Universidad (S/ 4,000) - **5 cuotas mensuales**
4. Egreso empresarial - Fraccionamiento SUNAT (S/ 14,400) - **12 cuotas mensuales**
5. Ingreso por servicios (S/ 3,500) - Pago único
6. Egreso personal - Préstamo (S/ 12,000) - **12 cuotas mensuales**

## Nuevas Funcionalidades Agregadas ⭐

### Sistema de Cuotas
- Registra transacciones con múltiples cuotas (pagos parciales)
- Calcula automáticamente las fechas de vencimiento según la frecuencia seleccionada
- Divide el monto total entre el número de cuotas
- Visualiza todas las cuotas pendientes en el dashboard
- Marca cuotas individuales como pagadas
- Código de colores para identificar cuotas vencidas, próximas o normales

### Filtro de Cuenta en Dashboard
- **Todas las Cuentas**: Vista consolidada de ingresos y egresos empresariales y personales
- **Solo Empresarial**: Filtra únicamente transacciones empresariales
- **Solo Personal**: Filtra únicamente transacciones personales
- El filtro afecta todos los cálculos, gráficos y listas del dashboard
- Permite enfocarse en un tipo de cuenta específico para mejor análisis

## Próximas Mejoras Sugeridas

- Base de datos real (MySQL, PostgreSQL, etc.)
- Backend con API REST
- Exportación de reportes a PDF/Excel
- Gráficos más avanzados (líneas, tortas)
- Sistema de usuarios y autenticación
- Recordatorios por email o notificaciones
- Integración con SUNAT para validación de RUC
- Cálculo automático de impuestos y retenciones
- Módulo de conciliación bancaria

## Notas

- Los datos se almacenan en el navegador (LocalStorage)
- Para limpiar los datos, abre la consola del navegador y ejecuta: `localStorage.clear()`
- La maqueta es totalmente funcional para pruebas y demostración

---

Desarrollado para el control de flujo de caja empresarial y personal.
