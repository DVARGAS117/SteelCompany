# ==================================================
# Script de Sincronización de Base de Datos
# Servidor → Local
# ==================================================

Write-Host "╔════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   SINCRONIZAR BD: SERVIDOR → LOCAL            ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

# Configuración Local
$mysqlLocal = "C:\xampp\mysql\bin\mysql.exe"
$usuarioLocal = "root"
$passwordLocal = ""
$baseDatosLocal = "smartsteel"

# Verificar que MySQL existe
if (-Not (Test-Path $mysqlLocal)) {
    Write-Host "❌ Error: No se encontró MySQL en $mysqlLocal" -ForegroundColor Red
    Write-Host "Por favor, ajusta la ruta en el script" -ForegroundColor Yellow
    Read-Host "Presiona Enter para salir"
    exit 1
}

# Solicitar ruta del archivo SQL del servidor
Write-Host "📁 Ingresa la ruta del archivo SQL descargado del servidor:" -ForegroundColor Yellow
Write-Host "   (Ejemplo: C:\Users\TuUsuario\Downloads\backup_servidor.sql)" -ForegroundColor Gray
Write-Host ""
$archivoSQL = Read-Host "Ruta del archivo"

# Verificar que el archivo existe
if (-Not (Test-Path $archivoSQL)) {
    Write-Host ""
    Write-Host "❌ Error: No se encontró el archivo en la ruta especificada" -ForegroundColor Red
    Write-Host ""
    Read-Host "Presiona Enter para salir"
    exit 1
}

# Confirmar acción
Write-Host ""
Write-Host "⚠️  ADVERTENCIA:" -ForegroundColor Yellow
Write-Host "   Esto REEMPLAZARÁ los datos actuales en tu base de datos local" -ForegroundColor Yellow
Write-Host "   Base de datos: $baseDatosLocal" -ForegroundColor White
Write-Host ""
$confirmacion = Read-Host "¿Continuar? (S/N)"

if ($confirmacion -ne "S" -and $confirmacion -ne "s") {
    Write-Host ""
    Write-Host "❌ Operación cancelada" -ForegroundColor Red
    Read-Host "Presiona Enter para salir"
    exit 0
}

Write-Host ""
Write-Host "📦 Importando base de datos..." -ForegroundColor Cyan
Write-Host ""

# Construir comando
if ($passwordLocal -eq "") {
    $comando = "cmd /c `"$mysqlLocal`" -u $usuarioLocal $baseDatosLocal < `"$archivoSQL`" 2>&1"
} else {
    $comando = "cmd /c `"$mysqlLocal`" -u $usuarioLocal -p$passwordLocal $baseDatosLocal < `"$archivoSQL`" 2>&1"
}

# Ejecutar importación
try {
    $resultado = Invoke-Expression $comando
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Base de datos sincronizada exitosamente!" -ForegroundColor Green
        Write-Host ""
        Write-Host "📊 Tu base de datos local ahora está actualizada con los datos del servidor" -ForegroundColor White
        Write-Host ""
    } else {
        Write-Host "❌ Error durante la importación:" -ForegroundColor Red
        Write-Host $resultado -ForegroundColor Yellow
        Write-Host ""
    }
} catch {
    Write-Host "❌ Error: $_" -ForegroundColor Red
    Write-Host ""
}

Write-Host ""
Write-Host "Presiona cualquier tecla para salir..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
