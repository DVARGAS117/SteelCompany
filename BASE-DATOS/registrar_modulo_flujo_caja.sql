-- ============================================================
-- SCRIPT PARA REGISTRAR MÓDULO FLUJO DE CAJA EN EL SISTEMA
-- ============================================================
-- Fecha: 29 de octubre de 2025
-- Descripción: Inserta el módulo "Flujo de Caja" con sus submenús
-- ============================================================

-- PASO 1: Insertar el módulo principal
-- Nota: Ajustar el 'orden' según los módulos existentes

INSERT INTO modulos (nombre_modulo, icono, orden, estado) 
VALUES ('Flujo de Caja', 'ri-money-dollar-circle-line', 3, 'A');

-- Obtener el ID del módulo recién insertado
SET @cod_modulo = LAST_INSERT_ID();

-- PASO 2: Insertar los submenús

-- Submenú: Dashboard Financiero
INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) 
VALUES (@cod_modulo, 'Dashboard Financiero', 'dashboard-ingresos-egresos.php', 'A');

-- Submenú: Registrar Movimiento
INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) 
VALUES (@cod_modulo, 'Registrar Movimiento', 'registrar-movimiento.php', 'A');

-- Submenú: Listado de Movimientos
INSERT INTO sub_modulos (cod_modulo, sub_modulo, enlace, estado) 
VALUES (@cod_modulo, 'Listado de Movimientos', 'listado-movimientos.php', 'A');

-- ============================================================
-- PASO 3: Asignar permisos al usuario administrador
-- ============================================================
-- IMPORTANTE: Reemplazar 'X' con el cod_personal del usuario admin
-- Para ver usuarios: SELECT cod_personal, nombres FROM personal WHERE estado='A';

-- Ejemplo para cod_personal = 1 (ajustar según tu BD)
-- Descomentar y ejecutar las siguientes líneas:

/*
SET @cod_personal_admin = 1; -- CAMBIAR POR EL ID DEL ADMIN

-- Obtener los IDs de los submenús recién creados
SET @submodulo_dashboard = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'dashboard-ingresos-egresos.php' LIMIT 1);
SET @submodulo_registrar = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'registrar-movimiento.php' LIMIT 1);
SET @submodulo_listado = (SELECT cod_submodulo FROM sub_modulos WHERE enlace = 'listado-movimientos.php' LIMIT 1);

-- Asignar permisos completos al Dashboard
INSERT INTO accesos_usuarios (cod_personal, cod_modulo, cod_submodulo, modulo, insertar, editar, eliminar, consultar)
VALUES (@cod_personal_admin, @cod_modulo, @submodulo_dashboard, 'Dashboard Financiero', 'SI', 'SI', 'SI', 'SI');

-- Asignar permisos completos a Registrar Movimiento
INSERT INTO accesos_usuarios (cod_personal, cod_modulo, cod_submodulo, modulo, insertar, editar, eliminar, consultar)
VALUES (@cod_personal_admin, @cod_modulo, @submodulo_registrar, 'Registrar Movimiento', 'SI', 'SI', 'SI', 'SI');

-- Asignar permisos completos a Listado de Movimientos
INSERT INTO accesos_usuarios (cod_personal, cod_modulo, cod_submodulo, modulo, insertar, editar, eliminar, consultar)
VALUES (@cod_personal_admin, @cod_modulo, @submodulo_listado, 'Listado de Movimientos', 'SI', 'SI', 'SI', 'SI');
*/

-- ============================================================
-- VERIFICACIÓN
-- ============================================================

-- Ver el módulo creado
SELECT * FROM modulos WHERE nombre_modulo = 'Flujo de Caja';

-- Ver los submenús creados
SELECT sm.* 
FROM sub_modulos sm
INNER JOIN modulos m ON sm.cod_modulo = m.cod_modulo
WHERE m.nombre_modulo = 'Flujo de Caja';

-- Ver los permisos asignados (descomentar después de asignar permisos)
/*
SELECT au.*, p.nombres
FROM accesos_usuarios au
INNER JOIN personal p ON au.cod_personal = p.cod_personal
INNER JOIN modulos m ON au.cod_modulo = m.cod_modulo
WHERE m.nombre_modulo = 'Flujo de Caja';
*/

-- ============================================================
-- NOTAS IMPORTANTES
-- ============================================================
-- 1. Ajustar el campo 'orden' en la tabla modulos según necesidad
-- 2. Reemplazar @cod_personal_admin con el ID real del administrador
-- 3. Si hay más usuarios que necesitan acceso, replicar los INSERT de accesos_usuarios
-- 4. El icono 'ri-money-dollar-circle-line' es de Remix Icons (ya incluido en el proyecto)
-- ============================================================
