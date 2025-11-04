# 📤 INSTRUCCIONES PARA SUBIR EL PROTOTIPO

## 🎯 Objetivo
Este documento explica cómo subir el prototipo a un servidor web para que sea accesible desde cualquier lugar.

---

## 📁 Archivos a Subir

Debes subir **toda la carpeta** `prototipo-flujo-caja` con su contenido:

```
prototipo-flujo-caja/
├── .htaccess
├── index.html
├── dashboard.html
├── registrar-movimiento.html
├── listado-movimientos.html
├── README.md
├── GUIA_RAPIDA.md
└── assets/
    ├── css/
    │   └── styles.css
    └── js/
        ├── datos-temporales.js
        ├── dashboard.js
        ├── registrar-movimiento.js
        └── listado-movimientos.js
```

---

## 🌐 Opción 1: Subir a Hosting con cPanel

### Pasos:

1. **Conectarse a cPanel**
   - Accede a tu cuenta de hosting
   - Ingresa al File Manager (Administrador de Archivos)

2. **Navegar a la carpeta correcta**
   - Ve a `public_html` o la carpeta raíz de tu dominio
   - Si tienes un subdominio, navega a esa carpeta

3. **Subir la carpeta**
   - Opción A: Comprimir la carpeta `prototipo-flujo-caja` en ZIP
   - Subir el archivo ZIP
   - Extraer en el servidor
   
   - Opción B: Subir directamente usando File Manager
   - Subir todos los archivos manteniendo la estructura

4. **Verificar permisos**
   - Asegúrate de que los archivos tengan permisos 644
   - Las carpetas deben tener permisos 755

5. **Acceder al prototipo**
   ```
   https://tudominio.com/prototipo-flujo-caja/
   ```

---

## 🔒 Opción 2: Subir vía FTP

### Requisitos:
- Cliente FTP (FileZilla, WinSCP, etc.)
- Credenciales FTP de tu hosting

### Pasos con FileZilla:

1. **Conectar al servidor**
   - Host: ftp.tudominio.com
   - Usuario: tu_usuario_ftp
   - Contraseña: tu_contraseña
   - Puerto: 21 (o el que te proporcione tu hosting)

2. **Navegar a la carpeta correcta**
   - Lado derecho (servidor): `/public_html/`
   - Lado izquierdo (local): Busca la carpeta `prototipo-flujo-caja`

3. **Subir la carpeta completa**
   - Arrastra la carpeta desde el panel local al servidor
   - Espera a que termine la transferencia
   - Verifica que se haya subido todo

4. **Acceder**
   ```
   https://tudominio.com/prototipo-flujo-caja/
   ```

---

## 🚀 Opción 3: Subir a GitHub Pages (Gratis)

### Ventaja: Hosting gratuito de GitHub

### Pasos:

1. **Crear repositorio en GitHub**
   - Ve a github.com
   - Clic en "New repository"
   - Nombre: `prototipo-flujo-caja`
   - Tipo: Public
   - Crear repositorio

2. **Subir archivos**
   - Opción A: Usando Git desde línea de comandos
   ```bash
   cd prototipo-flujo-caja
   git init
   git add .
   git commit -m "Prototipo Flujo de Caja"
   git branch -M main
   git remote add origin https://github.com/TU_USUARIO/prototipo-flujo-caja.git
   git push -u origin main
   ```
   
   - Opción B: Arrastrando archivos directamente en GitHub.com

3. **Activar GitHub Pages**
   - Ve a Settings del repositorio
   - Busca la sección "Pages"
   - Source: Deploy from a branch
   - Branch: main
   - Folder: / (root)
   - Save

4. **Acceder**
   ```
   https://TU_USUARIO.github.io/prototipo-flujo-caja/
   ```

---

## 🔐 Opción 4: Proteger con Contraseña (Opcional)

Si quieres que el prototipo requiera contraseña:

### Método 1: .htaccess (Apache)

1. Crear archivo `.htpasswd`:
   ```bash
   htpasswd -c .htpasswd usuario
   ```
   Ingresar contraseña cuando se solicite

2. Modificar `.htaccess`:
   ```apache
   AuthType Basic
   AuthName "Acceso Restringido - Prototipo"
   AuthUserFile /ruta/completa/al/.htpasswd
   Require valid-user
   ```

### Método 2: Usar servicio gratuito
- Netlify (con protección por contraseña)
- Vercel (con autenticación básica)

---

## ✅ Verificación Post-Subida

Después de subir, verifica:

1. ✅ La página de inicio carga correctamente
2. ✅ Los estilos CSS se aplican
3. ✅ Los menús de navegación funcionan
4. ✅ El dashboard muestra datos
5. ✅ El formulario permite registrar movimientos
6. ✅ La tabla se visualiza correctamente
7. ✅ Los botones de exportar funcionan
8. ✅ localStorage funciona (los datos persisten)

### Checklist de Prueba:
- [ ] Acceder a index.html
- [ ] Navegar a dashboard.html
- [ ] Ver cuotas pendientes
- [ ] Marcar una cuota como pagada
- [ ] Ir a registrar-movimiento.html
- [ ] Crear un nuevo movimiento
- [ ] Verificar que aparece en listado-movimientos.html
- [ ] Exportar a Excel
- [ ] Abrir modal de cuotas
- [ ] Cerrar sesión y verificar que datos persisten

---

## 🌍 Compartir el Prototipo

Una vez subido, puedes compartir la URL:

```
📧 Email de ejemplo:

Asunto: Prototipo - Módulo Flujo de Caja

Hola,

Te comparto el link al prototipo funcional del módulo de Flujo de Caja:

🔗 https://tudominio.com/prototipo-flujo-caja/

Credenciales (si aplica):
Usuario: demo
Contraseña: demo123

Características principales:
✅ Dashboard con filtros en tiempo real
✅ Registro de ingresos/egresos
✅ Gestión de cuotas
✅ Exportación a Excel/PDF

Los datos son temporales y se reinician al limpiar el navegador.

Saludos,
[Tu nombre]
```

---

## 📱 Responsive / Mobile

El prototipo es **responsive** y funciona en:
- ✅ Desktop (1920px+)
- ✅ Laptop (1366px+)
- ✅ Tablet (768px+)
- ✅ Mobile (320px+)

---

## 🔧 Troubleshooting

### Error: "Cannot read property..."
- Verifica que todos los archivos JS se hayan subido
- Revisa la consola del navegador (F12)

### Estilos no se aplican
- Verifica que la carpeta `assets/css/` exista
- Comprueba que el archivo `styles.css` esté presente

### DataTable no funciona
- Verifica conexión a Internet (usa CDNs)
- Revisa que jQuery esté cargando correctamente

### localStorage no funciona
- Algunos navegadores bloquean localStorage en HTTPS mixto
- Asegúrate de que el sitio use HTTPS completo

---

## 📊 Estadísticas de Uso (Opcional)

Si quieres trackear uso del prototipo, puedes agregar:

**Google Analytics:**
Agregar al `<head>` de cada archivo HTML:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=TU_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'TU_ID');
</script>
```

---

## 🎉 ¡Listo!

Ahora tienes el prototipo accesible desde cualquier lugar. Puedes compartirlo con:
- Clientes
- Stakeholders
- Equipo de desarrollo
- Testing/QA

**Recuerda:** Este es un prototipo, NO usar en producción.

---

## 📞 Soporte

Para dudas sobre la subida o configuración, contacta al equipo de desarrollo.

**Fecha:** 29 de octubre de 2025  
**Versión:** 1.0
