<?php

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
$xDireccion         = $xfempresa['direccion'];
$xDepartamento      = $xfempresa['Departamento'];
$xProvincia         = $xfempresa['Provincia'];
$xDistrito          = $xfempresa['Distrito'];
$xCodigoUbigeo      = $xfempresa['codigoUbigeo'];
$xCodigoLocal       = $xfempresa['codigoLocal'];
$xTelefono          = $xfempresa['telefono'];
$xMmovil            = $xfempresa['movil'];
$xEmail             = $xfempresa['email'];
$xTipo              = $xfempresa['tipo'];
$xUsuarioSol        = $xfempresa['usuario_sol'];
$xClaveSol          = $xfempresa['clave_sol'];
$xCertificado       = $xfempresa['certificado'];
$xClaveCertificado  = $xfempresa['clave_certificado'];
$xRutaApi           = $xfempresa['ruta_api'];
$xClaveBorrar       = $xfempresa['clave_borrar'];
