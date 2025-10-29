<?php
session_start();
$xCodPer    = $_SESSION['xCodPer'];
$xNombres   = $_SESSION['xNombres'];
$xEmail     = $_SESSION['xEmail'];
$xTienda    = $_SESSION['xTienda'];
$xCargo     = $_SESSION['xCargo'];
$xImagen    = $_SESSION['xImagen'];
/******************************************************/
/******************************************************/
$sqlTienda          = mysqli_query($conexion, "SELECT nombre_puntoventa, direccion FROM puntos_ventas WHERE cod_puntoventa='$xTienda'");
$xftienda           = mysqli_fetch_array($sqlTienda);
$xNombreTienda      = $xftienda['nombre_puntoventa'];
$xDireccionTienda   = $xftienda['direccion'];
/******************************************************/
/******************************************************/
$sqlEmpresa         = mysqli_query($conexion, "SELECT * FROM empresa");
$xfempresa          = mysqli_fetch_array($sqlEmpresa);
$xRucEmpresa        = $xfempresa['ruc'];
$xRazonSocial       = $xfempresa['razon_social'];
$xNombreComercial   = $xfempresa['nombre_comercial'];
$xIconoWeb          = $xfempresa['icono_web'];
$xLogoApp           = $xfempresa['logo_app'];
$xLogoMovil         = $xfempresa['logo_movil'];
$xLogoDoc           = $xfempresa['logo_documentos'];
$xImagenFondo       = $xfempresa['imagen_fondo'];
$xDirecEmpre        = $xfempresa['direccion'];
$xDepartamento      = $xfempresa['Departamento'];
$xProvincia         = $xfempresa['Provincia'];
$xDistrito          = $xfempresa['Distrito'];
$xCodigoUbigeo      = $xfempresa['codigoUbigeo'];
$xCodigoLocal       = $xfempresa['codigoLocal'];
$xTelefEmpre        = $xfempresa['telefono'];
$xMovil             = $xfempresa['movil'];
$xEmailEmpre        = $xfempresa['email'];
$xTipo              = $xfempresa['tipo'];
$xUsuarioSol        = $xfempresa['usuario_sol'];
$xClaveSol          = $xfempresa['clave_sol'];
$xCertificado       = $xfempresa['certificado'];
$xClaveCertificado  = $xfempresa['clave_certificado'];
$xRutaApi           = $xfempresa['ruta_api'];
$xClaveBorrar       = $xfempresa['clave_borrar'];
/******************************************************/
/******************************************************/
$fechaAtual         = date('Y-m-d');
$sqlCajas           = mysqli_query($conexion, "SELECT * FROM apertura_cajas WHERE cod_puntoventa='$xTienda' AND fecha_creacion='$fechaAtual' AND estado='Aperturado'");
$xNumCaja           = mysqli_num_rows($sqlCajas);
$xfCaja             = mysqli_fetch_array($sqlCajas);
$xCodAperturaCaja   = $xfCaja['cod_apertura'];
if ($xNumCaja >= 1) {
    $NombreCaja     = $xfCaja['nombre_caja'] . ' Aperturado';
} else {
    $NombreCaja     = 'Falta Aperturar Caja';
}
/******************************************************/
/******************************************************/
if ($xCodPer == '' or $xCodPer == 0) {
    header("location: seguridad.php");
}
/******************************************************/
/******************************************************/
