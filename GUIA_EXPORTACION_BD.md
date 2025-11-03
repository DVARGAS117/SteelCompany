# 📦 Guía de Exportación de Esquema de Base de Datos

## Objetivo
Exportar el esquema actualizado de las tablas del módulo **Flujo de Caja** para tener un respaldo y poder trabajar de manera tranquila.

---

## 🔧 Método 1: Script PHP (Más Fácil)

### Pasos:
1. **Abre tu navegador**
2. **Accede a**: `http://localhost/smartsteel.pe/exportar-esquema-bd.php`
3. **Espera** a que se genere el archivo
4. **Descarga** el archivo SQL generado
5. ✅ **Listo!** El archivo está en `BASE-DATOS/backup_modulo_flujo_caja_FECHA.sql`

### Ventajas:
- ✅ Interfaz visual amigable
- ✅ No requiere conocimientos técnicos
- ✅ Descarga directa desde el navegador
- ✅ Muestra información detallada

---

## 🔧 Método 2: Script PowerShell (Más Rápido)

### Pasos:
1. **Abre PowerShell** en la carpeta del proyecto:
   ```powershell
   cd C:\xampp\htdocs\smartsteel.pe
   ```

2. **Ejecuta el script**:
   ```powershell
   .\exportar-esquema.ps1
   ```

3. ✅ **Listo!** El archivo se guarda en `BASE-DATOS/backup_modulo_flujo_caja_FECHA.sql`

### Ventajas:
- ✅ Más rápido
- ✅ Usa mysqldump (herramienta oficial de MySQL)
- ✅ Mejor para backups automatizados

### Nota:
Si te sale error de "ejecución de scripts deshabilitada", ejecuta primero:
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

---

## 🔧 Método 3: phpMyAdmin (Manual)

### Pasos:
1. **Accede a phpMyAdmin**: `http://localhost/phpmyadmin`
2. **Selecciona** la base de datos `smartsteel`
3. **Marca** las tablas:
   - ✅ `ingresos_egresos`
   - ✅ `cuotas_movimientos`
4. **Abajo de la tabla**, selecciona: "Exportar" en el menú desplegable
5. **Configuración**:
   - Formato: **SQL**
   - ✅ Estructura
   - ✅ Datos
   - ✅ DROP TABLE
6. **Presiona "Continuar"**
7. ✅ Se descarga el archivo `.sql`

---

## 🔧 Método 4: Línea de Comandos MySQL

### Comando:
```bash
cd C:\xampp\mysql\bin

mysqldump -u root --no-tablespaces --add-drop-table --complete-insert smartsteel ingresos_egresos cuotas_movimientos > C:\xampp\htdocs\smartsteel.pe\BASE-DATOS\backup.sql
```

### Si tienes contraseña:
```bash
mysqldump -u root -p --no-tablespaces --add-drop-table --complete-insert smartsteel ingresos_egresos cuotas_movimientos > C:\xampp\htdocs\smartsteel.pe\BASE-DATOS\backup.sql
```

---

## 📋 Tablas que se Exportan

### `ingresos_egresos`
- Tabla principal de movimientos financieros
- Campos: id_movimiento, tipo, clasificacion, ruc, razon_social, concepto, monto_total, etc.

### `cuotas_movimientos`
- Tabla de cuotas asociadas a cada movimiento
- Campos: id_cuota, id_movimiento, numero_cuota, monto_cuota, fecha_vencimiento, fecha_pago, estado, etc.

---

## 🔄 Cómo Importar el Archivo Exportado

### Opción A: phpMyAdmin
1. Abre phpMyAdmin
2. Selecciona la base de datos `smartsteel`
3. Ve a la pestaña "Importar"
4. Selecciona el archivo `.sql`
5. Click en "Continuar"

### Opción B: Línea de comandos
```bash
cd C:\xampp\mysql\bin
mysql -u root smartsteel < C:\xampp\htdocs\smartsteel.pe\BASE-DATOS\backup.sql
```

---

## ⚠️ Recomendaciones

1. **Hacer backup regularmente**: Exporta el esquema después de cada cambio importante
2. **Nombrar con fecha**: Los scripts ya incluyen fecha y hora en el nombre
3. **Guardar en repositorio**: Agrega el archivo al repositorio Git
4. **Verificar antes de importar**: Revisa que el archivo SQL no tenga errores
5. **Probar en entorno de desarrollo**: Antes de aplicar en producción

---

## 📝 Contenido del Backup

El archivo SQL incluye:
- ✅ Comandos `DROP TABLE IF EXISTS`
- ✅ Comandos `CREATE TABLE` con estructura completa
- ✅ Comandos `INSERT` con todos los datos actuales
- ✅ Comentarios explicativos
- ✅ Configuración de charset y collation

---

## 🎯 ¿Cuál método usar?

| Método | Velocidad | Facilidad | Recomendado para |
|--------|-----------|-----------|------------------|
| Script PHP | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Usuarios sin experiencia técnica |
| Script PowerShell | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | Usuarios que usan terminal |
| phpMyAdmin | ⭐⭐ | ⭐⭐⭐⭐ | Exportación manual ocasional |
| Línea de comandos | ⭐⭐⭐⭐⭐ | ⭐⭐ | Usuarios avanzados, automatización |

---

## 💡 Mi Recomendación

**Para tu caso (necesitas trabajar tranquilo con el esquema actualizado):**

1. **Usa el Script PHP** (exportar-esquema-bd.php)
   - Es el más fácil
   - Te muestra todo visualmente
   - Descarga directa

2. **Guarda el archivo** en la carpeta `BASE-DATOS/`

3. **Agrégalo al repositorio Git**:
   ```bash
   git add BASE-DATOS/backup_modulo_flujo_caja_*.sql
   git commit -m "Backup de esquema actualizado del módulo Flujo de Caja"
   ```

4. Ahora tendrás el esquema actualizado y podrás trabajar tranquilo 😊

---

## 🆘 Soporte

Si tienes problemas con algún método, revisa:
- ✅ Que XAMPP esté corriendo (Apache y MySQL)
- ✅ Que las tablas existan en la base de datos
- ✅ Que tengas permisos de escritura en la carpeta `BASE-DATOS/`
- ✅ Que la ruta de mysqldump sea correcta (para PowerShell)
