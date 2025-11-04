# ==================================================
# Script PowerShell para exportar Base de Datos
# Módulo: Flujo de Caja
# ==================================================

# Configuración
$fecha = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
$nombreArchivo = "backup_modulo_flujo_caja_$fecha.sql"
$rutaExportacion = "BASE-DATOS\$nombreArchivo"

# Datos de conexión (ajustar si es necesario)
$servidor = "localhost"
$usuario = "root"
$password = ""
$baseDatos = "smartsteel"

# Ruta de mysqldump (ajustar según tu instalación de XAMPP)
$mysqldump = "C:\xampp\mysql\bin\mysqldump.exe"

# Verificar que mysqldump existe
if (-Not (Test-Path $mysqldump)) {
    Write-Host "❌ Error: No se encontró mysqldump en $mysqldump" -ForegroundColor Red
    Write-Host "Por favor, ajusta la ruta en el script" -ForegroundColor Yellow
    exit 1
}

# Crear carpeta BASE-DATOS si no existe
if (-Not (Test-Path "BASE-DATOS")) {
    New-Item -ItemType Directory -Path "BASE-DATOS" | Out-Null
}

Write-Host "📦 Exportando esquema de base de datos..." -ForegroundColor Cyan
Write-Host ""

# Construir comando
$tablas = "ingresos_egresos cuotas_movimientos"

if ($password -eq "") {
    # Sin contraseña
    $comando = "& `"$mysqldump`" -h $servidor -u $usuario --no-tablespaces --add-drop-table --complete-insert $baseDatos $tablas > `"$rutaExportacion`""
} else {
    # Con contraseña
    $comando = "& `"$mysqldump`" -h $servidor -u $usuario -p$password --no-tablespaces --add-drop-table --complete-insert $baseDatos $tablas > `"$rutaExportacion`""
}

# Ejecutar exportación
try {
    Invoke-Expression $comando
    
    if (Test-Path $rutaExportacion) {
        $tamanio = (Get-Item $rutaExportacion).Length
        $tamanioKB = [math]::Round($tamanio / 1KB, 2)
        
        Write-Host "✅ Exportación exitosa!" -ForegroundColor Green
        Write-Host ""
        Write-Host "📄 Archivo: $nombreArchivo" -ForegroundColor White
        Write-Host "📁 Ubicación: $rutaExportacion" -ForegroundColor White
        Write-Host "📊 Tamaño: $tamanioKB KB" -ForegroundColor White
        Write-Host ""
        Write-Host "🎯 Tablas exportadas:" -ForegroundColor Cyan
        Write-Host "   - ingresos_egresos" -ForegroundColor Gray
        Write-Host "   - cuotas_movimientos" -ForegroundColor Gray
        Write-Host ""
    } else {
        Write-Host "❌ Error: No se pudo crear el archivo de exportación" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Error durante la exportación: $_" -ForegroundColor Red
}

Write-Host ""
Write-Host "Presiona cualquier tecla para salir..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
