# DOCUMENTO DE DESCUBRIMIENTOS - MÓDULO INGRESOS Y EGRESOS
## Análisis para Implementación en Proyecto SmartSteel

---

## 📋 INFORMACIÓN GENERAL DEL PROYECTO

**Fecha de Análisis:** 28 de octubre de 2025  
**Analista:** GitHub Copilot  
**Objetivo:** Integrar módulo de Ingresos y Egresos al sistema actual de SmartSteel

---

## 🎯 ALCANCE DEL NUEVO MÓDULO (Según Documentación)

### Funcionalidades Requeridas:

1. **Registro Detallado de Transacciones**
   - Ingresos: Facturas de venta con RUC, detalle, monto y fecha de cobro
   - Egresos: Facturas de compra, servicios básicos, planillas, fraccionamientos SUNAT, créditos
   
2. **Clasificación Empresarial vs Personal**
   - Campo obligatorio para separar movimientos

3. **Sistema de Cuotas**
   - Soporte para pagos/cobros en múltiples cuotas
   - Frecuencias: Mensual, Quincenal, Semanal, Personalizado
   - Generación automática de fechas de vencimiento

4. **Sistema de Alertas**
   - Notificaciones con 2-3 días de anticipación
   - Integración con campana de alertas existente
   - Filtros por período (próximos 3 días, 7 días, quincena, mes)

5. **Dashboard de Resumen**
   - Resumen mensual de movimientos
   - Saldo neto (Ingresos - Egresos)
   - Desglose por tipo (Empresarial/Personal)
   - Gráficos de barras
   - Lista de últimas transacciones
   - Sección de cuotas pendientes con estados visuales

---

## 🔍 FASE 1: ANÁLISIS DE DOCUMENTACIÓN BASE

### ✅ DESCUBRIMIENTO 1.1 - Documentos Revisados

**README.md:**
- Proyecto actual es una maqueta funcional en HTML/CSS/JS vanilla
- Usa LocalStorage para persistencia
- Incluye datos de ejemplo
- Sin dependencias externas
- Diseño responsive

**MODULO.md:**
- Especificaciones funcionales del módulo
- Énfasis en separación Empresarial/Personal
- Requisito de alertas automáticas
- Dashboard con reportes visuales
- Nota: Fase posterior podría incluir detracciones/retenciones (no prioritario)

### 📊 Estado Actual:
- ✅ Maqueta funcional completada
- ⏳ Pendiente: Análisis de proyecto principal (SmartSteel)
- ⏳ Pendiente: Análisis de estructura de BD
- ⏳ Pendiente: Análisis de módulos EMPRESA y MANTENIMIENTO

---

## � FASE 2: ANÁLISIS DEL MÓDULO EMPRESA

### ✅ DESCUBRIMIENTO 2.1 - Estructura de Base de Datos

**Archivo Analizado:** `smartsteel.pe/config/conexion.php`

**Conexión a BD:**
- Motor: MySQL/MySQLi
- Base de datos: `roque192_XXNEO2050`
- Charset: UTF8
- Método: mysqli_connect (procedimental)

**Tabla Identificada: `empresa`**

Campos detectados en la tabla `empresa` (desde datos-empresa.php):
- `id_empresa` - ID único de empresa
- `ruc` - RUC de la empresa
- `razon_social` - Razón social
- `nombre_comercial` - Nombre comercial
- `icono_web` - Icono del sitio
- `logo_app` - Logo de la aplicación
- `logo_movil` - Logo móvil
- `logo_documentos` - Logo para facturas/boletas
- `imagen_fondo` - Imagen de fondo del index
- `direccion` - Dirección física
- `Departamento` - ID del departamento
- `Provincia` - ID de la provincia
- `Distrito` - ID del distrito
- `codigoUbigeo` - Código de ubigeo
- `codigoLocal` - Código del local
- `telefono` - Teléfono
- `movil` - Móvil
- `email` - Email
- `tipo` - Tipo de ambiente (1=Producción, 3=Beta)
- `usuario_sol` - Usuario SOL (SUNAT)
- `clave_sol` - Clave SOL
- `certificado` - Certificado PFX para facturación electrónica
- `clave_certificado` - Clave del certificado
- `ruta_api` - Ruta de la API
- `clave_borrar` - Clave para borrar registros

**Tablas Relacionadas de Ubigeo:**
- `ubigeo_departamentos` (id, name)
- `ubigeo_provincias` (id, name, department_id)
- `ubigeo_distritos` (id, name, province_id)

### ✅ DESCUBRIMIENTO 2.2 - Patrón de Desarrollo del Módulo EMPRESA

**Archivo Analizado:** `smartsteel.pe/datos-empresa.php`

**Patrón Arquitectónico Identificado:**

1. **Estructura del Archivo:**
   - Encabezado PHP con requires necesarios
   - Consulta de datos de BD
   - Asignación de variables PHP
   - Sección HTML con estructura de página completa
   - JavaScript inline para funcionalidad

2. **Archivos de Configuración Requeridos:**
   ```php
   require("config/conexion.php");           // Conexión a BD
   require("config/inicializar-datos.php");  // Inicialización de sesión/datos
   require("config/permisos.php");           // Sistema de permisos
   require("config/cabecera-web.php");       // Meta tags y CSS
   require("config/cabecera.php");           // Header/Top bar
   require("config/barra-navegacion.php");   // Menú lateral
   require("config/piepagina.php");          // Footer
   ```

3. **Sistema de Permisos:**
   - Variable `$accesoEdit` controla si se muestra el botón de guardar
   - Valores: 'SI' / 'NO'

4. **Librería CSS/JS Utilizadas:**
   - Bootstrap (bootstrap.min.css/js)
   - DataTables (para listados)
   - Dropzone (para carga de archivos)
   - jQuery
   - MetisMenu (para menús)
   - SimpleBa (scrollbars)
   - Node-waves (efectos)
   - Iconos: icons.min.css

5. **Patrón de Guardado (AJAX):**
   ```javascript
   $("#proceso").val('ActualizarEmpresa');
   $("#modulo").val('Empresa');
   var datosEnviar = $("#fapps").serialize();
   $.ajax({
       data: datosEnviar,
       url: "config/proceso-guardar.php",  // Archivo central de guardado
       type: "POST",
       dataType: "json",
       success: function(data) {
           if (data.respuesta == 'SI') {
               alert("Los datos de la empresa se actualizaron con exito.");
               location.reload();
           }
       }
   })
   ```

6. **Campos Ocultos para Control:**
   - `id_empresa` - ID del registro
   - `proceso` - Nombre del proceso (Ej: ActualizarEmpresa)
   - `modulo` - Nombre del módulo (Ej: Empresa)

7. **Patrón de Carga Dinámica (Selects):**
   - Los selects dependientes (Departamento → Provincia → Distrito) usan AJAX
   - Archivo: `config/procesos-fact.php`
   - Envía: id del departamento/provincia + proceso
   - Retorna: JSON con HTML de opciones

8. **Gestión de Archivos (Dropzone):**
   - Múltiples instancias de Dropzone en la misma página
   - URL de carga: `config/subirArchivos.php`
   - Parámetro adicional: `proceso` (Ej: "logoApp", "pfxCertificado")
   - Almacenamiento del nombre en campo hidden

**Observaciones Importantes:**
- El sistema usa un único archivo para guardar (`proceso-guardar.php`) 
- Se diferencia por los campos `proceso` y `modulo`
- No usa prepared statements (vulnerabilidad SQL Injection)
- Usa alerts de JavaScript nativos (no Sweetalert u otra librería)
- El reload después de guardar recarga toda la página

---

## � FASE 3: ANÁLISIS DEL ARCHIVO CENTRAL DE GUARDADO

### ✅ DESCUBRIMIENTO 3.1 - Archivo `proceso-guardar.php`

**Archivo Analizado:** `smartsteel.pe/config/proceso-guardar.php` (2807 líneas)

**Arquitectura del Sistema de Guardado:**

1. **Estructura General:**
   - Archivo único que maneja TODOS los procesos de INSERT/UPDATE/DELETE
   - Recibe parámetro `$_POST['modulo']` para identificar el módulo
   - Usa condicionales `if ($modulo == 'NombreModulo')` para cada módulo
   - No usa programación orientada a objetos (excepto clase `helper`)

2. **Módulos Implementados en proceso-guardar.php:**
   - Perfil (ActualizarPerfil)
   - Clave (ActualizarClave) - usa SHA1 para passwords
   - Empresa (ActualizarEmpresa)
   - PuntoVenta (Registrar/Actualizar)
   - Personal (Registrar/Actualizar) - incluye sistema de accesos
   - Categorias (Registrar/Actualizar)
   - Marcas (Registrar/Actualizar)
   - Producto (Registrar/Actualizar)
   - productosAlmacen (carga CSV)
   - asignarStockTiendas (carga CSV + movimientos)
   - SeriesDocumentos (Registrar/Actualizar)
   - TipoDocumento (Registrar/Actualizar)
   - NotaCredito (Registrar/Actualizar)
   - Clientes (Registrar/Actualizar/Eliminar) - usa clase helper
   - Y muchos más...

3. **Patrón de Respuesta JSON:**
   ```php
   $salidaJson = array("respuesta" => $respuesta);
   echo json_encode($salidaJson);
   ```
   - `$respuesta` puede ser: 'SI' / 'NO'
   - Algunos módulos más nuevos usan estructura extendida con clase helper:
     ```php
     $data_out['success'] = $success;
     $data_out['mensaje'] = $mensaje;
     $data_out['tipo'] = $tipo;  // 'success' / 'error'
     ```

4. **Sistema de Validación de Duplicados:**
   - Antes de INSERT, se hace SELECT para verificar si ya existe
   - Ejemplo patrón:
     ```php
     $sqlVerificar = mysqli_query($conexion, "SELECT cod_categoria FROM categoria_productos WHERE categoria='$categoria'");
     $numres = mysqli_num_rows($sqlVerificar);
     if ($numres == 0) {
         // INSERTAR
         $respuesta = 'SI';
     } else {
         $respuesta = 'NO';
     }
     ```

5. **Campos de Auditoría:**
   - `fecha_creacion` - se llena con `date('Y-m-d H:i:s')`
   - `fecha_actualizacion` - se actualiza en cada UPDATE
   - `cod_personal` - ID del usuario que realiza la acción (desde `$xCodPer`)

6. **Sistema de Permisos (Módulos Avanzados):**
   - Variables: `$can_insert`, `$can_update`, `$can_delete`
   - Se valida antes de ejecutar la consulta
   - Retorna mensaje de error si no tiene permisos

7. **Gestión de Archivos CSV:**
   - Algunos módulos permiten carga masiva por CSV
   - Lee archivo línea por línea con `fgets()`
   - Separa datos con `explode(";", $xDatos)`
   - Hace INSERT o UPDATE dependiendo si existe el registro

**Tabla de Módulos de Mantenimiento Identificados:**
- Categorías (categoria_productos)
- Marcas (marcas)
- Productos (productos)
- Series Documentos (serie_documentos)
- Tipo Documento (tipo_documento)
- Motivo Nota Crédito (motivo_nota_credito)
- Clientes (clientes)
- Puntos de Venta (puntos_ventas)
- Personal (personal + accesos_usuarios)

**Observación de Seguridad:**
- ⚠️ **CRÍTICO**: No usa prepared statements, vulnerable a SQL Injection
- ⚠️ Usa SHA1 para contraseñas (obsoleto, debería ser bcrypt/argon2)
- ⚠️ No sanitiza entradas antes de insertar en BD

---

## � FASE 4: ANÁLISIS DE MÓDULOS DE MANTENIMIENTO

### ✅ DESCUBRIMIENTO 4.1 - Patrón de Módulo de Mantenimiento

**Archivos Analizados:** 
- `smartsteel.pe/categorias.php` (Listado)
- `smartsteel.pe/reg-categorias.php` (Formulario Registro)
- `smartsteel.pe/mod-categorias.php` (Formulario Edición - similar a registro)

**Estructura Estándar de Listado (categorias.php):**

1. **Encabezado y Estructura:**
   ```php
   require("config/conexion.php");
   require("config/inicializar-datos.php");
   // NO require permisos en listado
   ```

2. **Título de Página con Botón de Acción:**
   - H4 con título del módulo
   - Botón "Nueva Categoria" que abre modal
   - Modal con atributos:
     - `data-bs-toggle="modal"`
     - `data-bs-target="#bs-example-modal-xl"`
     - `data-remote="reg-categorias.php"` (carga archivo PHP)
     - `data-sb-backdrop="static"`
     - `data-sb-keyboard="false"`

3. **DataTable para Listado:**
   - ID: `datatable-buttons`
   - Clases: `table table-striped table-bordered dt-responsive nowrap`
   - Configuración: exportar a Excel, PDF, imprimir
   - Columnas: Datos + Estado + Acción

4. **Badges para Estados:**
   ```php
   if ($fconsul['estado'] == 'A') {
       $estado = "<span class='badge rounded-pill bg-success'>Activo</span>";
   } else {
       $estado = "<span class='badge rounded-pill bg-danger'>Inactivo</span>";
   }
   ```

5. **Botones de Acción:**
   - **Editar:** Abre modal con `mod-categorias.php?cod_categoria=X`
     - Clase: `btn btn-outline-success btn-sm`
     - Icono: `ri-edit-fill`
   - **Eliminar:** Clase `borrarReg` con campo hidden `codborrar`
     - Clase: `btn btn-outline-danger btn-sm`
     - Icono: `ri-delete-bin-fill`

6. **JavaScript de Eliminación:**
   ```javascript
   $(document).on('click', '.borrarReg', function() {
       var cod_categoria = $('.codborrar', this).val();
       var datosEnviar = {
           'cod_categoria': cod_categoria,
           'modulo': "Categorias"
       }
       var r = confirm("¿Seguro que desea borrar el registro?");
       if (r == true) {
           $.ajax({
               url: 'config/proceso-eliminar.php',
               // ...
           })
       }
   })
   ```

7. **Carga Dinámica de Modal:**
   - jQuery carga contenido del archivo PHP en `.modal-body`
   - Permite registrar y editar sin recargar página

**Estructura de Formulario de Registro (reg-categorias.php):**

1. **No tiene layout completo:**
   - Solo tiene el `<body>` sin header/sidebar
   - Se carga dentro del modal

2. **Formulario con ID `fapps`:**
   - Campos del módulo
   - Radio buttons para Estado (A=Activo, I=Inactivo)
   - Campos hidden: `proceso` y `modulo`

3. **Validación JavaScript:**
   ```javascript
   $("#benviar").click(function() {
       if ($("#categoria").val() == '') {
           alert("Falta ingresar categoria");
           $("#categoria").focus();
           return false;
       }
       $("#proceso").val('RegistrarCategorias');
       $("#modulo").val('Categorias');
       // AJAX a proceso-guardar.php
   })
   ```

4. **Respuesta del AJAX:**
   ```javascript
   success: function(data) {
       var respuesta = data.respuesta;
       if (respuesta == 'SI') {
           alert("La categoia se registro con exito.");
           location.reload();
       } else {
           alert("Lo sentimos pero la categoria ya existe.");
       }
   }
   ```

**Archivo de Eliminación (`proceso-eliminar.php`):**
- Similar a `proceso-guardar.php`
- Recibe módulo y ID del registro
- Ejecuta DELETE en la tabla correspondiente
- Retorna JSON con `resultado: 'SI'/'NO'`

---

## 🔍 FASE 5: ANÁLISIS DEL SISTEMA DE NOTIFICACIONES

### ✅ DESCUBRIMIENTO 5.1 - Campana de Notificaciones Actual

**Archivo Analizado:** `smartsteel.pe/config/cabecera.php`

**Sistema de Notificaciones Existente:**

1. **Ubicación:** Header principal (top bar derecha)

2. **Estructura HTML:**
   ```html
   <div class="dropdown d-inline-block">
       <button class="btn header-item noti-icon waves-effect" 
               id="page-header-notifications-dropdown">
           <i class="ri-notification-3-line"></i>
           <span class="noti-dot"></span>  <!-- Badge rojo de alerta -->
       </button>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
           <!-- Lista de notificaciones -->
       </div>
   </div>
   ```

3. **Contenido del Dropdown:**
   - Título: "Notificaciones"
   - Link: "View All" (derecha)
   - `data-simplebar` con `max-height: 230px` (scroll)
   - Botón inferior: "View More..."

4. **Estructura de Notificación Individual:**
   ```html
   <a href="#" class="text-reset notification-item">
       <div class="d-flex">
           <div class="flex-shrink-0 me-3">
               <div class="avatar-xs">
                   <span class="avatar-title bg-primary rounded-circle">
                       <i class="ri-shopping-cart-line"></i>
                   </span>
               </div>
           </div>
           <div class="flex-grow-1">
               <h6 class="mb-1">Título de la Notificación</h6>
               <div class="font-size-12 text-muted">
                   <p class="mb-1">Descripción del mensaje</p>
                   <p class="mb-0">
                       <i class="mdi mdi-clock-outline"></i> 3 min ago
                   </p>
               </div>
           </div>
       </div>
   </a>
   ```

5. **Clases de Color para Avatar (según tipo):**
   - `bg-primary` - Azul (general)
   - `bg-success` - Verde (éxito/completado)
   - `bg-danger` - Rojo (urgente/vencido)
   - `bg-warning` - Amarillo (advertencia)

6. **Estado Actual:**
   - Las notificaciones son estáticas (hardcoded)
   - No hay consultas dinámicas a BD
   - El punto rojo `noti-dot` siempre visible

**Conclusión:**
- Estructura HTML ya existe y está lista
- Se debe implementar consultas AJAX para cargar notificaciones dinámicas
- Ideal para integrar alertas de cuotas pendientes

---

## � FASE 6: ANÁLISIS DE SISTEMA DE MENÚ Y PERMISOS

### ✅ DESCUBRIMIENTO 6.1 - Sistema de Menú Dinámico

**Archivo Analizado:** `smartsteel.pe/config/barra-navegacion.php`

**Estructura del Menú:**

1. **Tablas Involucradas:**
   - `modulos` - Módulos principales (nivel 1)
   - `sub_modulos` - Submódulos (nivel 2)
   - `accesos_usuarios` - Permisos por usuario

2. **Campos de la tabla `modulos`:**
   - `cod_modulo` - ID del módulo
   - `nombre_modulo` - Nombre mostrado en menú
   - `icono` - Clase de icono (Ej: mdi mdi-cog-outline)
   - `orden` - Orden de aparición
   - `estado` - A=Activo, I=Inactivo

3. **Campos de la tabla `sub_modulos`:**
   - `cod_submodulo` - ID del submódulo
   - `cod_modulo` - FK al módulo padre
   - `sub_modulo` - Nombre del submódulo
   - `enlace` - Archivo PHP de destino
   - `estado` - A=Activo, I=Inactivo

4. **Campos de la tabla `accesos_usuarios`:**
   - `cod_personal` - ID del usuario
   - `cod_modulo` - ID del módulo
   - `cod_submodulo` - ID del submódulo
   - `modulo` - Nombre del módulo (redundante)
   - `insertar` - SI/NO
   - `editar` - SI/NO
   - `eliminar` - SI/NO
   - `consultar` - SI/NO

5. **Lógica de Construcción del Menú:**
   ```php
   // 1. Obtener módulos activos ordenados
   SELECT * FROM modulos WHERE estado='A' ORDER BY orden ASC
   
   // 2. Verificar si usuario tiene acceso al módulo
   SELECT * FROM accesos_usuarios 
   WHERE cod_modulo='X' AND cod_personal='Y' 
   AND (consultar='SI' OR insertar='SI' OR editar='SI' OR eliminar='SI')
   
   // 3. Si tiene acceso, obtener submódulos
   SELECT * FROM sub_modulos WHERE cod_modulo='X'
   
   // 4. Verificar acceso a cada submódulo
   SELECT * FROM accesos_usuarios 
   WHERE cod_modulo='X' AND cod_personal='Y' AND modulo='SubModulo' 
   AND (consultar='SI' OR insertar='SI' OR editar='SI' OR eliminar='SI')
   ```

6. **URL de Submódulos:**
   - Formato: `enlace.php?sub_modulo=NombreSubModulo`
   - Ejemplo: `categorias.php?sub_modulo=Categorias`
   - El parámetro `sub_modulo` se usa en `permisos.php`

### ✅ DESCUBRIMIENTO 6.2 - Sistema de Inicialización

**Archivo Analizado:** `smartsteel.pe/config/inicializar-datos.php`

**Variables de Sesión Disponibles:**

1. **Usuario Actual:**
   - `$xCodPer` - ID del personal
   - `$xNombres` - Nombre completo
   - `$xEmail` - Email
   - `$xTienda` - ID punto de venta
   - `$xCargo` - Cargo del usuario
   - `$xImagen` - Foto de perfil

2. **Punto de Venta:**
   - `$xNombreTienda` - Nombre del local
   - `$xDireccionTienda` - Dirección del local

3. **Datos de Empresa:**
   - `$xRucEmpresa`, `$xRazonSocial`, `$xNombreComercial`
   - `$xIconoWeb`, `$xLogoApp`, `$xLogoMovil`, `$xLogoDoc`
   - `$xDirecEmpre`, `$xTelefEmpre`, `$xEmailEmpre`
   - `$xDepartamento`, `$xProvincia`, `$xDistrito`, `$xCodigoUbigeo`
   - Datos SUNAT: `$xUsuarioSol`, `$xClaveSol`, `$xCertificado`

4. **Sistema de Caja:**
   - `$xNumCaja` - Contador de cajas aperturadas hoy
   - `$xCodAperturaCaja` - ID de caja activa
   - `$NombreCaja` - Estado de caja (Aperturado/Falta Aperturar)

5. **Seguridad:**
   - Valida que `$xCodPer` exista, sino redirige a `seguridad.php`

### ✅ DESCUBRIMIENTO 6.3 - Sistema de Permisos

**Archivo Analizado:** `smartsteel.pe/config/permisos.php`

**Variables de Permisos Generadas:**

1. **Formato String (para mostrar/ocultar botones):**
   - `$accesoInsert` - 'SI' / 'NO'
   - `$accesoEdit` - 'SI' / 'NO'
   - `$accesoElim` - 'SI' / 'NO'
   - `$accesoConsultar` - 'SI' / 'NO'

2. **Formato Boolean (para validaciones en proceso-guardar.php):**
   - `$can_insert` - true / false
   - `$can_update` - true / false
   - `$can_delete` - true / false
   - `$can_select` - true / false

3. **Uso en Vistas:**
   ```php
   <?php if ($accesoEdit == 'SI') { ?>
       <button>GUARDAR CAMBIOS</button>
   <?php } ?>
   ```

4. **Uso en Controladores:**
   ```php
   if ($can_insert) {
       // Ejecutar INSERT
   } else {
       $mensaje = 'No tiene permisos para Registrar';
   }
   ```

**Requisito para permisos.php:**
- El parámetro `$_REQUEST['sub_modulo']` debe existir en la URL
- Sin este parámetro, los permisos no funcionan

---

## 🔄 PRÓXIMOS PASOS:
1. ✅ Examinar estructura de base de datos
2. ✅ Analizar módulo EMPRESA
3. ✅ Analizar archivo `proceso-guardar.php`
4. ✅ Analizar módulos de MANTENIMIENTO
5. ✅ Analizar sistema de alertas/notificaciones actual
6. ✅ Revisar estructura del menú y navegación
7. ✅ Analizar archivos de inicialización y permisos
8. ⏳ Crear documento final con guía de implementación

---

*Documento en construcción - Análisis completo, proceder a documento final*
