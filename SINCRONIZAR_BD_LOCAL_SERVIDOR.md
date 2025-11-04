# 🔄 Guía: Sincronizar BD Local con Servidor

## Tu Situación
- ✅ Proyecto descargado y funcionando en local
- ❌ Base de datos local desactualizada (antigua)
- 🎯 Necesitas actualizar tu BD local con la del servidor

---

## 🚀 Solución Rápida (Recomendada)

### **Paso 1: Exportar desde el Servidor**

#### Si tienes acceso a phpMyAdmin del servidor:
1. Accede a: `https://tudominio.com/phpmyadmin` (o la URL que uses)
2. Usuario y contraseña del servidor
3. Selecciona la BD: `smartsteel`
4. Click en **"Exportar"**
5. **Método**: Rápido
6. **Formato**: SQL
7. Click **"Continuar"**
8. Se descarga: `smartsteel.sql`

#### Si tienes acceso SSH:
```bash
# Conectar al servidor
ssh usuario@servidor.com

# Exportar la base de datos completa
mysqldump -u usuario_bd -p smartsteel > smartsteel_backup.sql

# Salir de SSH
exit

# En tu PC local, descargar el archivo
scp usuario@servidor.com:~/smartsteel_backup.sql C:\Users\TuUsuario\Downloads\
```

---

### **Paso 2: Importar en tu Local**

#### **Opción A: Usar el Script PowerShell** ⭐ (MÁS FÁCIL)

1. **Guarda el archivo** del servidor en tu PC (ejemplo: Downloads)

2. **Abre PowerShell** en la carpeta del proyecto:
   ```powershell
   cd C:\xampp\htdocs\smartsteel.pe
   ```

3. **Ejecuta el script**:
   ```powershell
   .\sincronizar-bd-servidor.ps1
   ```

4. **Ingresa la ruta** del archivo descargado:
   ```
   C:\Users\TuUsuario\Downloads\smartsteel.sql
   ```

5. **Confirma** con `S`

6. ✅ **Listo!** Tu BD local está actualizada

#### **Opción B: phpMyAdmin Local**

1. Abre: `http://localhost/phpmyadmin`
2. Selecciona la BD: `smartsteel`
3. Pestaña: **"Importar"**
4. **Examinar**: Selecciona el archivo descargado
5. Click: **"Continuar"**
6. ✅ Listo!

#### **Opción C: Línea de Comandos**

```bash
# Abrir CMD o PowerShell
cd C:\xampp\mysql\bin

# Importar (sin contraseña)
mysql -u root smartsteel < "C:\Users\TuUsuario\Downloads\smartsteel.sql"

# O con contraseña
mysql -u root -p smartsteel < "C:\Users\TuUsuario\Downloads\smartsteel.sql"
```

---

## ⚠️ Consideraciones Importantes

### **Antes de Importar:**

1. **Haz Backup** de tu BD local actual (por si acaso):
   ```powershell
   cd C:\xampp\mysql\bin
   mysqldump -u root smartsteel > C:\backup_local_antiguo.sql
   ```

2. **Asegúrate** de que XAMPP esté corriendo (Apache y MySQL)

3. **Cierra** cualquier conexión activa a la BD

### **Después de Importar:**

1. **Verifica** que las tablas estén correctas:
   - En phpMyAdmin: Revisa que existan las tablas
   - Especialmente: `ingresos_egresos` y `cuotas_movimientos`

2. **Prueba** el proyecto:
   - Abre: `http://localhost/smartsteel.pe/listado-movimientos.php`
   - Verifica que carguen los datos

---

## 🔄 Sincronización Solo del Módulo Flujo de Caja

Si **solo necesitas actualizar** las tablas del módulo nuevo:

### **En el Servidor (phpMyAdmin):**
1. Selecciona **solo estas tablas**:
   - ✅ `ingresos_egresos`
   - ✅ `cuotas_movimientos`
2. Marca las tablas
3. En el menú desplegable de abajo: **"Exportar"**
4. Descarga el archivo

### **En Local (phpMyAdmin):**
1. Antes de importar, **elimina** las tablas antiguas (si existen):
   ```sql
   DROP TABLE IF EXISTS cuotas_movimientos;
   DROP TABLE IF EXISTS ingresos_egresos;
   ```
2. Luego **importa** el archivo del servidor
3. ✅ Solo se actualizan esas tablas, el resto queda igual

---

## 📋 Checklist

Marca lo que vayas completando:

- [ ] Acceder al servidor (phpMyAdmin o SSH)
- [ ] Exportar la base de datos `smartsteel`
- [ ] Descargar el archivo `.sql` a tu PC
- [ ] Hacer backup de tu BD local (opcional pero recomendado)
- [ ] Verificar que XAMPP esté corriendo
- [ ] Importar el archivo en tu BD local
- [ ] Verificar que las tablas estén correctas
- [ ] Probar que el módulo funcione
- [ ] ✅ ¡Trabajar tranquilo con BD actualizada!

---

## 🆘 Problemas Comunes

### **"Access denied" al importar**
- Verifica usuario/contraseña de MySQL local
- Por defecto XAMPP: usuario=`root`, password=(vacío)

### **"Table already exists"**
- El archivo SQL debe tener `DROP TABLE IF EXISTS`
- O elimina las tablas manualmente antes de importar

### **"Timeout" al importar archivo grande**
- Aumenta el `max_execution_time` en php.ini
- O importa por línea de comandos (es más rápido)

### **"No se encontró el archivo"**
- Verifica la ruta completa del archivo
- En Windows usa: `C:\Users\...` (con `\` o `/`)

---

## 💡 Recomendación Final

**Para tu caso específico:**

1. **Exporta la BD completa del servidor** (phpMyAdmin → Exportar → Rápido)
2. **Usa el script PowerShell** `sincronizar-bd-servidor.ps1` (es lo más fácil)
3. **Verifica** que todo funcione
4. A partir de ahora **trabaja tranquilo** con tu BD actualizada

**Tiempo estimado:** 5-10 minutos ⏱️

---

## 🎯 Después de Sincronizar

Una vez que tengas la BD actualizada:

1. **Continúa trabajando** en tu rama `feature/gestion-detalle-cuotas`
2. **Haz commits** de tus cambios
3. **Prueba todo** localmente antes de subir al servidor
4. Cuando esté listo: **Merge a desarrollo** y luego **deploy al servidor**

¡Ahora sí puedes trabajar tranquilo! 😊
