<?php
require('../../config/conexion.php');
require("../../config/inicializar-datos.php");
require('../../config/EnLetras.php');
/************************************************/
$fecha_registro         = $_POST['fecha'];
$serie                  = $_POST['serie'];
/************************************************/
/* $fecha_registro         = '2022-04-15';
$serie                  = 'BB01'; */
/************************************************/
include "../url_api/url.php";
$ruta = "$url/api_facturacion/resumen_boletas.php";
/************************************************/
date_default_timezone_set('America/Lima');
/************************************************/
$sqlxEmpresa            = mysqli_query($conexion, "SELECT * FROM empresa");
$xefila                 = mysqli_fetch_array($sqlxEmpresa);
$xeruc                  = $xefila['ruc'];
$xerazon                = $xefila['razon_social'];
$xenomcom               = $xefila['nombre_comercial'];
$xedireccion            = $xefila['direccion'];
$xdepartamento          = $xefila['Departamento'];
$xprovincia             = $xefila['Provincia'];
$xdistrito              = $xefila['Distrito'];
$xcodigoubigeo          = $xefila['codigoUbigeo'];
$xcodigolocal           = $xefila['codigoLocal'];
$xeussol                = $xefila['usuario_sol'];
$xeclasol               = $xefila['clave_sol'];
/************************************************/
$sqlSecuencia           = mysqli_query($conexion, "SELECT * FROM secuencia_envios_resboleta");
$fsecuencia             = mysqli_fetch_array($sqlSecuencia);
$secuencia              = $fsecuencia['secuencia'] + 1;
$sqlActSecuencia        = mysqli_query($conexion, "UPDATE secuencia_envios_resboleta SET secuencia='$secuencia'");
/************************************************/
$data = '{';
$data .= '
  "codigo"					            : "RC",
  "serie"					              : "' . date('Ymd') . '",
  "secuencia"				            : "' . $secuencia . '",
  "fecha_referencia"		        : "' . $fecha_registro . '",
  "fecha_documento"			        : "' . date('Y-m-d') . '", 

  "emisor"		: {
    "ruc"					              : "' . $xeruc . '",
    "tipo_doc"				          : "6",
    "nom_comercial"			        : "' . $xenomcom . '",
    "razon_social"			        : "' . $xerazon . '",
    "codigo_ubigeo"			        : "' . $xcodigoubigeo . '",
    "codigo_local"              : "' . $xcodigolocal . '",
    "direccion"				          : "' . $xedireccion . '",
    "direccion_departamento"    : "' . $xdepartamento . '",
    "direccion_provincia"	      : "' . $xprovincia . '",
    "direccion_distrito"	      : "' . $xdistrito . '",
    "direccion_codigopais"	    : "PE",
    "usuariosol"			          : "MODDATOS",
    "clavesol"				          : "moddatos"
  },

  "detalle"		: [';

$i = 0;
$sqlVentas                  = mysqli_query($conexion, "SELECT id_factura, doc_modificado, cod_tipo_compro_modif, codigo_compro, serie, num_comprobante, numero_documento FROM factura WHERE fecha_registro='$fecha_registro' AND serie='$serie' AND estado='Por Enviar' ORDER BY num_comprobante ASC");
$totalBoletas               = mysqli_num_rows($sqlVentas);
while ($fila                = mysqli_fetch_array($sqlVentas)) {
  $id_factura               = $fila['id_factura'];
  $doc_modificado           = '0';
  $cod_compro_mod           = '0';
  $codigo_compro            = $fila['codigo_compro'];
  if ($codigo_compro == '07') {
    $doc_modificado         = $fila['doc_modificado'];
    $cod_compro_mod         = $fila['cod_tipo_compro_modif'];
  }
  $serie                    = $fila['serie'];
  $num_comprobante          = $fila['num_comprobante'];
  $num_serie                = $serie . '-' . $num_comprobante;
  if ($fila['numero_documento'] != '') {
    $dni_cliente            = $fila['numero_documento'];
  } else {
    $dni_cliente            = '00000000';
  }
  /**************************************************/
  /**************************************************/
  $totInafectos             = 0;
  $total                    = 0;
  $totalGrabadas            = 0;
  $totalIgv                 = 0.00;
  $MtoImportVenta           = 0;
  $sqlDetalles              = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
  while ($filaDet           = mysqli_fetch_array($sqlDetalles)) {
    $cantidad               = $filaDet['cantidad'];
    $totalGrabadas          = ($totalGrabadas + $filaDet['precio_sin_igv']);
    $totalIgv               = ($totalIgv + $filaDet['igv']);
    $MtoImportVenta         = ($MtoImportVenta + $filaDet['precio_con_igv']);
  }
  $data .= '
		{
		  "ITEM"				        : "' . ($i + 1) . '",
		  "TIPO_COMPROBANTE"	  : "' . $codigo_compro . '",
		  "NRO_COMPROBANTE"		  : "' . $num_serie . '",
		  "NRO_DOCUMENTO"		    : "' . $dni_cliente . '",
		  "TIPO_DOCUMENTO"		  : "1",
		  "NRO_COMPROBANTE_REF"	: "' . $doc_modificado . '",
		  "TIPO_COMPROBANTE_REF": "' . $cod_compro_mod . '",
		  "STATUS"				      : "1",
		  "COD_MONEDA"			    : "PEN",
		  "TOTAL"				        : "' . round($MtoImportVenta, 2) . '",
		  "GRAVADA"				      : "' . round($totalGrabadas, 2) . '",
		  "EXONERADO"			      : "0",
		  "INAFECTO"			      : "0",
		  "EXPORTACION"			    : "0",
		  "GRATUITAS"			      : "0",
		  "MONTO_CARGO_X_ASIG"	: "0",
		  "CARGO_X_ASIGNACION"	: "0",
		  "ISC"					        : "0",
		  "IGV"					        : "' . round($totalIgv, 2) . '",
		  "OTROS"				        : "0"
		}';
  $i++;
  if ($i < $totalBoletas) {
    $data .= ',';
  }
}
$data .= '
  ]
}';
//Invocamos el servicio
$token = ''; //en caso quieras utilizar algún token generado desde tu sistema

//codificamos la data
$data_json = $data;
/******************************************************************************/
/**********************  Mostrar Datos a Enviar en Json  **********************/
/******************************************************************************/
//echo $data_json;
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ruta);
curl_setopt(
  $ch,
  CURLOPT_HTTPHEADER,
  array(
    'Authorization: Token token="' . $token . '"',
    'Content-Type: application/json',
  )
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta  = curl_exec($ch);
curl_close($ch);

$response = json_decode($respuesta, true);
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/* echo "=========== DATA RETORNO =============== ";
echo "<br>respuesta			: " . $response['respuesta'];
echo "<br>url_xml			: $url/" . $response['url_xml'];
echo "<a href=$url/" . $response['url_xml'] . " download=xml>Descargar XML</a>";
echo "<br>hash_cpe			: " . $response['hash_cpe'];
echo "<br>hash_cdr			: " . $response['hash_cdr'];
echo "<br>msj_sunat			: " . $response['msj_sunat'];
echo "<br>cod_msj_sunat		: " . $response['cod_msj_sunat'];
echo "<br>mensaje			: " . $response['mensaje'];
echo "<br>ruta_cdr			: $url/" . $response['ruta_cdr'];
echo "<a href=$url/" . $response['ruta_cdr'] . " download=xml>Descargar CDR</a>";
echo "<br>ruta_pdf	: " . $response['ruta_pdf'];
echo "<br>Servidor sunat	: " . $response['ruta_ws'] . '<br>'; */
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
$resultadoSunat = "
===================== DATA RETORNO SUNAT =====================<br>
RESPUESTA	:  " . $response['respuesta'] . "<br>
URL XML		: $url/" . $response['url_xml'] . "<br>
<a href=$url/" . $response['url_xml'] . " download=xml>Descargar XML</a><br>
HASH_CPE	: " . $response['hash_cpe'] . "<br>
HASF_CDR	: " . $response['hash_cdr'] . "<br>
MSJ_SUNAT	: " . $response['msj_sunat'] . "<br>
COD_MSJ_SUNAT	: " . $response['cod_msj_sunat'] . "<br>
MENSAJE	: " . $response['mensaje'] . "<br>
RUTA CDR	: $url/" . $response['ruta_cdr'] . "<br>
<a href=$url/" . $response['ruta_cdr'] . " download=xml>Descargar CDR</a>
RUTA PDF	: " . $response['ruta_pdf'] . "<br>
SERVIDOR SUNAT	:" . $response['ruta_ws'] . "<br>";
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
$rutaXML          = $response['url_xml'];
$rutaCDR          = $response['ruta_cdr'];
$fecha_envio      = date('Y-m-d H:i:s');
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
$msj              = $response['msj_sunat'];
$msj_sunat        = 'ha sido aceptado';
$msj_resul        = strpos($msj, $msj_sunat);
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
if ($msj_resul == true && $response['hash_cpe'] != '' && $response['hash_cdr'] != '') {
  $sqlActRegVentas = mysqli_query($conexion, "UPDATE factura SET fecha_enviosunat='$fecha_envio', estado='Enviado' WHERE fecha_registro='$fecha_registro' AND serie='$serie' AND (codigo_compro='03' OR codigo_compro='07')");
}
$salidaJson    = array(
  "respuesta"  => $response['respuesta'],
  "mensaje"       => $response['msj_sunat'],
  "resultadosunat" => $resultadoSunat
);
echo json_encode($salidaJson);
