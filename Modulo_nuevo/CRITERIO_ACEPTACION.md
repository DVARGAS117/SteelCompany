# Historias de Usuario y Criterios de Aceptación

## Historia 1: Responsable de compliance - Registro con RUC y razón social

**Historia de Usuario:**  
Como responsable de compliance, quiero ingresar el RUC en cada registro de transacción, para que el sistema consulte automáticamente la base de datos de empresas y complete la razón social, asegurando que el registro quede correctamente identificado y facilitando futuras integraciones con SUNAT u organismos externos. Solo si el ingreso o egreso es en cuenta personal, el campo de RUC y razón social puede quedar vacío. 

**Criterios de Aceptación:**  
### Scenario: Registro exitoso con RUC existente  
- Given que el usuario ingresa un RUC válido  
- When registra una nueva transacción  
- Then el sistema debe consultar la base de datos, mostrar automáticamente la razón social asociada y guardar el registro correctamente  

### Scenario: Registro con RUC inexistente  
- Given que el usuario ingresa un RUC que no existe en la base de datos  
- When intenta registrar una transacción  
- Then el sistema debe mostrar un mensaje indicando que el RUC no existe y bloquear el guardado del registro  

---

## Historia 2: Usuario operativo - Marcado de cuotas en dashboard

**Historia de Usuario:**  
Como usuario operativo, quiero marcar cuotas individuales como pagadas, recibidas o pendientes directamente desde el dashboard, para que el sistema actualice el saldo según el avance real. Si una transacción se ingresó en 3 cuotas, el dinero solo se refleja en el saldo conforme cada cuota se marca como pagada o recibida, aplicando esto tanto para ingresos como egresos y manteniendo el seguimiento detallado de lo realmente cobrado o pagado.

**Criterios de Aceptación:**  
### Scenario: Marcar cuota como pagada (ingreso o egreso parcial)  
- Given una transacción registrada con varias cuotas pendientes  
- When el usuario marca una cuota específica como pagada o recibida desde el dashboard  
- Then el sistema actualiza el estado de esa cuota y refleja ese ingreso/egreso en los saldos y reportes  

### Scenario: Error al marcar una cuota ya pagada  
- Given una cuota previamente marcada como pagada  
- When el usuario intenta marcarla nuevamente como pagada  
- Then el sistema debe impedir la acción e informar que la cuota ya fue registrada como pagada  

---

## Historia 3: Nuevo usuario - Datos de ejemplo y sistema responsive

**Historia de Usuario:**  
El sistema nunca debe mostrar datos ficticios; únicamente debe visualizar datos verdaderos existentes en la fuente real, y si no hay datos disponibles, no se muestra ningún ejemplo ni información dummy.

**Criterios de Aceptación:**  
### Scenario: Visualización con datos reales  
- Given que existen transacciones cargadas en la fuente de datos real  
- When el usuario accede como nuevo usuario en cualquier dispositivo  
- Then el sistema muestra la información de esas transacciones con diseño responsive  

### Scenario: Visualización sin datos  
- Given que no existen transacciones cargadas en la fuente de datos real  
- When el usuario accede como nuevo usuario  
- Then el sistema no debe mostrar ninguna transacción de ejemplo ni información ficticia  

---

## Historia 4: Desarrollador - Guardado directo en base de datos

**Historia de Usuario:**  
Como desarrollador, quiero que los datos de movimientos (ingresos y egresos) se guarden directamente en la base de datos real existente (donde ya se almacenan los RUC y razones sociales), de modo que se puedan registrar y actualizar todos estos movimientos en la base principal, garantizando escalabilidad y migración seguras y facilitando la integración futura con consultas y actualizaciones centralizadas.

**Criterios de Aceptación:**  
### Scenario: Guardado exitoso de nuevo movimiento  
- Given la interfaz de captura de movimientos (ingreso/egreso)  
- When se registra un nuevo movimiento con datos completos y válidos  
- Then el sistema debe guardar el movimiento en la base de datos principal y hacerlo disponible para consultas y reportes inmediatos  

### Scenario: Actualización de base de datos con nuevos registros  
- Given que existe una base de datos con tabla de movimientos  
- When el sistema guarda nuevos movimientos  
- Then los registros de movimientos deben agregarse y poder consultarse correctamente junto a los RUC y razones sociales existentes  

### Scenario: Error en guardado por datos incompletos  
- Given que el usuario intenta guardar un movimiento con campos obligatorios vacíos  
- When presiona el botón de guardar  
- Then el sistema debe impedir el guardado y mostrar un mensaje de error solicitando completar los campos esenciales  

---

## Historias adicionales (Resumen)

- Como administrador empresarial, quiero registrar ingresos y egresos con detalles para controlar y proyectar el flujo de caja.  
- Como usuario, quiero marcar cada transacción como empresarial o personal para separar finanzas.  
- Como responsable de pagos, quiero alertas anticipadas para evitar multas.  
- Como analista financiero, quiero dashboard con resúmenes mensuales para toma de decisiones.  
- Como usuario frecuente, quiero registro en cuotas con fechas automáticas para manejo cómodo.  
- Como usuario avanzado, quiero filtros por tipo cuenta y período para análisis específico.

(Estas últimas pueden desarrollarse con criterios similares según se requiera.)

---

Este archivo puede usarse directamente para gestión ágil y como documentación funcional para el equipo de desarrollo.
