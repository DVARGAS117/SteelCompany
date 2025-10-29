<?php
require('../../config/conexion.php');
require("../../config/inicializar-datos.php");
require('../../config/EnLetras.php');
/************************************************/
$id_guia			= $_POST['id_guia'];
//$id_guia	= 1;
/************************************************/
include "../url_api/url.php";
$ruta = "$url/api_facturacion/guia_remision.php";
date_default_timezone_set('America/Lima');
/************************************************/
$sqlxEmpresa        = mysqli_query($conexion, "SELECT * FROM empresa");
$xefila             = mysqli_fetch_array($sqlxEmpresa);
$xeruc              = $xefila['ruc'];
$xerazon            = $xefila['razon_social'];
$xenomcom           = $xefila['nombre_comercial'];
$xedireccion        = $xefila['direccion'];
$xdepartamento      = $xefila['Departamento'];
$xprovincia         = $xefila['Provincia'];
$xdistrito          = $xefila['Distrito'];
$xcodigoubigeo      = $xefila['codigoUbigeo'];
$xcodigolocal       = $xefila['codigoLocal'];
$xeussol            = $xefila['usuario_sol'];
$xeclasol           = $xefila['clave_sol'];
/************************************************/
$sqlSecuencia		= mysqli_query($conexion, "SELECT * FROM secuencia_envios_resboleta");
$fsecuencia			= mysqli_fetch_array($sqlSecuencia);
$secuencia			= $fsecuencia['secuencia'] + 1;
$sqlActSecuencia 	= mysqli_query($conexion, "UPDATE secuencia_envios_resboleta SET secuencia='$secuencia'");
/************************************************/
$sqlGuias					= mysqli_query($conexion, "SELECT * FROM guias_remision WHERE id_guia='$id_guia'");
$fguias						= mysqli_fetch_array($sqlGuias);
$id_factura					= $fguias['id_factura'];
$serie						= $fguias['serie'];
$num_guia					= $fguias['num_guia'];
$fecha_registro				= $fguias['fecha_registro'];
$codmotivo_traslado 		= $fguias['codmotivo_traslado'];
$motivo_traslado 			= $fguias['motivo_traslado'];
$peso 						= $fguias['peso'];
$numero_paquetes 			= $fguias['numero_paquetes'];
$codtipo_transportista 		= $fguias['codtipo_transportista'];
$nro_coumento_transporte 	= $fguias['nro_documento_transporte'];
$razon_social_transporte 	= $fguias['razon_social_transporte'];
$ubigeo_destino 			= $fguias['ubigeo_destino'];
$dir_destino				= $fguias['domicilio_llegada'];
$ubigeo_partida				= $fguias['ubigeo_partida'];
$dir_partida				= $fguias['direccion_partida'];
/***********************************************/
$sqlFactura					= mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$ffact						= mysqli_fetch_array($sqlFactura);
$num_documento				= $ffact['numero_documento'];
$nombre_cliente				= $ffact['razon_social'];
$cod_tipodoc				= $ffact['cod_tipodoc'];
if ($cod_tipodoc == 1) {
	$cliente_tipodocumento	= 6;
}
if ($cod_tipodoc == 2) {
	$cliente_tipodocumento	= 1;
}
/***********************************************/
$data	= '{';
$data  .= '
	"serie_comprobante"				: "' . $serie . '",
	"numero_comprobante"            : "' . $num_guia . '",
	"fecha_comprobante"             : "' . $fecha_registro . '",
	"cod_tipo_documento"            : "09",
	"nota"							: "Transporte de mercaderias",
	"codmotivo_traslado"			: "' . $codmotivo_traslado . '",
	"motivo_traslado"				: "' . $motivo_traslado . '",
	"peso"							: "' . number_format($peso, 2) . '",
	"numero_paquetes"				: "' . $numero_paquetes . '",
	"codtipo_transportista"			: "01",
	"tipo_documento_transporte"		: "6",
	"nro_documento_transporte"		: "' . $nro_coumento_transporte . '",
	"razon_social_transporte"		: "' . $razon_social_transporte . '",
	"ubigeo_destino"				: "' . $ubigeo_destino . '",
	"dir_destino"					: "' . $dir_destino . '",
	"ubigeo_partida"				: "' . $ubigeo_partida . '",
	"dir_partida"					: "' . $dir_partida . '",
	
	"cliente_numerodocumento"       : "' . $num_documento . '",
	"cliente_nombre"                : "' . $nombre_cliente . '",
	"cliente_tipodocumento"         : "' . $cliente_tipodocumento . '",

	"emisor"		: {
        "ruc"					    : "' . $xeruc . '",
        "tipo_doc"				    : "6",
        "nom_comercial"			    : "' . $xenomcom . '",
        "razon_social"			    : "' . $xerazon . '",
        "codigo_ubigeo"			    : "' . $xcodigoubigeo . '",
        "codigo_local"              : "' . $xcodigolocal . '",
        "direccion"				    : "' . $xedireccion . '",
        "direccion_departamento"    : "' . $xdepartamento . '",
        "direccion_provincia"	    : "' . $xprovincia . '",
        "direccion_distrito"	    : "' . $xdistrito . '",
        "direccion_codigopais"	    : "PE",
        "usuariosol"			    : "MODDATOS",
        "clavesol"				    : "moddatos"
	},

	"detalle" : [';
$i = 0;
$sqlDetalles			= mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
$totalProd				= mysqli_num_rows($sqlDetalles);
while ($filaDet			= mysqli_fetch_array($sqlDetalles)) {
	$nombre_producto	= $filaDet['producto'];
	$cantidad			= $filaDet['cantidad'];
	/*************** Extraer Nombre de Producto **************/
	$sqlProductos		= mysqli_query($conexion, "SELECT codigo FROM productos WHERE nombre_producto='$nombre_producto'");
	$fprod				= mysqli_fetch_array($sqlProductos);
	$cod_prod			= $fprod['codigo'];
	/************************************************/
	/************************************************/
	$data	.= '
			{
			"ITEM"          		: "' . ($i + 1) . '",
			"PESO"      			: "' . $cantidad . '",
			"NUMERO_ORDEN"          : "1",
			"DESCRIPCION"           : "' . $nombre_producto . '",
			"CODIGO_PRODUCTO"       : "' . $cod_prod . '"
			}';
	$i++;
	if ($i < $totalProd) {
		$data .= ',';
	}
}
$data .= '
	]
}';
/******************************************************/
/************** Invocamos el servicio *****************/
/******************************************************/
$token = ''; //en caso quieras utilizar algún token generado desde tu sistema
/******************************************************/
/******************************************************/
$data_json = $data;
/******************************************************/
/***************** 		VER JSON 		***************/
/******************************************************/
//echo $data_json;
/******************************************************/
/******************************************************/
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
/******************************************************/
/******************************************************/
/* echo "=========== DATA RETORNO =============== ";
echo "<br /><br />respuesta	: " . $response['respuesta'];
echo "<br /><br />url_xml	: $url/" . $response['url_xml'];
echo "<a href=$url/" . $response['url_xml'] . " download=xml>Descargar XML</a>";
echo "<br /><br />hash_cpe	: " . $response['hash_cpe'];
echo "<br /><br />hash_cdr	: " . $response['hash_cdr'];
echo "<br /><br />msj_sunat	: " . $response['msj_sunat'];
echo "<br /><br />ruta_cdr	: $url/" . $response['ruta_cdr'];
echo "<a href=$url/" . $response['ruta_cdr'] . " download=xml>Descargar CDR</a>";
echo "<br /><br />ruta_pdf	: " . $response['ruta_pdf']; */
/******************************************************/
/******************************************************/
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
/******************************************************/
/******************************************************/
$rutaXML		= $response['url_xml'];
$rutaCDR		= $response['ruta_cdr'];
$fecha_envio	= date('Y-m-d H:i:s');
/******************************************************/
$cod_msj_sunat	= $response['cod_msj_sunat'];
$msj 			= $response['msj_sunat'];
$msj_sunat  	= 'ha sido aceptado';
$msj_resul		= strpos($msj, $msj_sunat);
/******************************************************/
/******************************************************/
if ($msj_resul == true && $response['hash_cpe'] != '' && $response['hash_cdr'] != '') {
	$sqlActRegGuias = mysqli_query($conexion, "UPDATE guias_remision SET fecha_enviosunat='$fecha_envio', ruta_xml='$rutaXML', ruta_cdr='$rutaCDR', estado='Enviado' WHERE id_guia='$id_guia'");
}
/******************************************************/
/******************************************************/
$salidaJson	= array(
	"respuesta"  => $response['respuesta'],
	"mensaje"  	 => $response['msj_sunat'],
	"resultadosunat" => $resultadoSunat
);
echo json_encode($salidaJson);
