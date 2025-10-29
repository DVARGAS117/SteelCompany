<?php
require('../../config/conexion.php');
require("../../config/inicializar-datos.php");
require('../../config/EnLetras.php');
/************************************************/
$id_factura				= $_POST['id_factura'];
//$id_factura				= 5;
/************************************************/
include "../url_api/url.php";
$ruta 					= "$url/api_facturacion/notacredito.php";
/************************************************/
date_default_timezone_set('America/Lima');
/************************************************/
$sqlxEmpresa        	= mysqli_query($conexion, "SELECT * FROM empresa");
$xefila             	= mysqli_fetch_array($sqlxEmpresa);
$xeruc              	= $xefila['ruc'];
$xerazon            	= $xefila['razon_social'];
$xenomcom           	= $xefila['nombre_comercial'];
$xedireccion        	= $xefila['direccion'];
$xdepartamento      	= $xefila['Departamento'];
$xprovincia         	= $xefila['Provincia'];
$xdistrito          	= $xefila['Distrito'];
$xcodigoubigeo      	= $xefila['codigoUbigeo'];
$xcodigolocal       	= $xefila['codigoLocal'];
$xeussol            	= $xefila['usuario_sol'];
$xeclasol           	= $xefila['clave_sol'];
/************************************************/
$sqlSecuencia			= mysqli_query($conexion, "SELECT * FROM secuencia_envios_resboleta");
$fsecuencia				= mysqli_fetch_array($sqlSecuencia);
$secuencia				= $fsecuencia['secuencia'] + 1;
$sqlActSecuencia		= mysqli_query($conexion, "UPDATE secuencia_envios_resboleta SET secuencia='$secuencia'");
/************************************************/
$sqlRegtVentas			= mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$fregven 				= mysqli_fetch_array($sqlRegtVentas);
$codigo_compro			= $fregven['codigo_compro'];
$documento				= $fregven['numero_documento'];
$nombre_cliente			= $fregven['razon_social'];
$serie					= $fregven['serie'];
$num_comprobante		= $fregven['num_comprobante'];
$fecha_registro			= $fregven['fecha_registro'];
$doc_modificado			= $fregven['doc_modificado'];
$cod_tipo_motivo		= $fregven['cod_tipo_motivo'];
$cod_compro_mod 		= $fregven['cod_tipo_compro_modif'];
if ($cod_compro_mod == '03') {
	$tipo_doc_cliente	= '1';
} else {
	$tipo_doc_cliente	= '6';
}
/************************************************/
/************************************************/
$sqlMotivoCredt			= mysqli_query($conexion, "SELECT * FROM motivo_nota_credito WHERE cod_motivo='$cod_tipo_motivo'");
$fmcre					= mysqli_fetch_array($sqlMotivoCredt);
$codigo_motivo			= $fmcre['codigo'];
$motivoNotCre			= $fmcre['descripcion'];
/************************************************/
/************************************************/
$totalGrabadas 			= 0;
$totalIgv				= 0;
$totalGeneral			= 0;
$sqlDetalles			= mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
while ($filaDet			= mysqli_fetch_array($sqlDetalles)) {
	$cantidad			= $filaDet['cantidad'];
	$precio_unitario	= $filaDet['precio'];
	$setTotalImpuestos	= $filaDet['igv'];
	$setValorVenta		= $filaDet['precio_sin_igv'];
	$setMtoImpVenta		= $filaDet['precio_con_igv'];
	/*****/
	$totalGrabadas		= ($totalGrabadas + $setValorVenta);
	$totalIgv			= ($totalIgv + $setTotalImpuestos);
	$totalGeneral		= ($totalGeneral + $setMtoImpVenta);
}
$V					= new EnLetras();
$totaLetras			= strtoupper($V->ValorEnLetras($totalGeneral, "SOLES"));
/************************************************/
$data	= '{';
$data  .= '
	"total_gravadas"               	: "' . round($totalGrabadas, 2) . '",
    "porcentaje_igv"                : "18.00",
    "total_igv"                     : "' . round($totalIgv, 2) . '",
    "total"                  		: "' . round($totalGeneral, 2) . '",
    "serie_comprobante"             : "' . $serie . '",
    "numero_comprobante"            : "' . $num_comprobante . '",
    "fecha_comprobante"             : "' . $fecha_registro . '",
    "cod_tipo_documento"            : "07",
	"cod_moneda"                    : "PEN",
	"total_letras"              	: "' . $totaLetras . '",
	
	"tipo_comprobante_modifica" 	: "' . $cod_compro_mod . '",
	"nro_documento_modifica" 		: "' . $doc_modificado . '",
	"cod_tipo_motivo" 				: "' . $codigo_motivo . '",
	"descripcion_motivo" 			: "' . $motivoNotCre . '",
	
    "cliente_numerodocumento"       : "' . $documento . '",
    "cliente_nombre"                : "' . $nombre_cliente . '",
    "cliente_tipodocumento"         : "' . $tipo_doc_cliente . '",
	
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
	$num++;
	$cod_producto		= "P" . $num;
	/************************************************************/
	$cantidad			= $filaDet['cantidad'];
	$setMtoImpVenta		= $filaDet['precio_con_igv'];
	$setValorVenta		= $filaDet['precio_sin_igv'];
	$setTotalImpuestos	= $filaDet['igv'];
	$preciouni_conigv   = ($setMtoImpVenta / $cantidad);
	$preciouni_sinigv   = ($setValorVenta / $cantidad);
	$data	.= '
			{
			"txtITEM"          			: ' . ($i + 1) . ',
			"txtUNIDAD_MEDIDA_DET"      : "NIU",
			"txtCANTIDAD_DET"           : "' . $cantidad . '",
			"txtPRECIO_DET"             : "' . round($preciouni_sinigv, 2) . '",
			"txtSUB_TOTAL_DET"          : "' . round($setValorVenta, 2) . '",
			"txtPRECIO_TIPO_CODIGO"     : "01",
			"txtIGV"                 	: "' . round($setTotalImpuestos, 2) . '",
			"txtISC"                  	: "0",
			"txtIMPORTE_DET"            : "' . round($setValorVenta, 2) . '",
			"txtCOD_TIPO_OPERACION"     : "10",
			"txtCODIGO_DET"             : "' . $cod_producto . '",
			"txtDESCRIPCION_DET"   		: "' . $nombre_producto . '",
			"txtPRECIO_SIN_IGV_DET"  	: "' . round($preciouni_sinigv, 2) . '"
			}';
	$i++;
	if ($i < $totalProd) {
		$data .= ',';
	}
}

$data .= '
  ]
}';

//Invocamos el servicio
$token = ''; //en caso quieras utilizar algún token generado desde tu sistema

$data_json = $data;

/***************************************************/
/*********** Mostrar Json en Pantalla **************/
/***************************************************/
//echo $data_json;
/***************************************************/
/***************************************************/
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
/***************************************************/
/***************************************************/
/* echo "=========== DATA RETORNO =============== ";
echo "<br /><br />respuesta	: " . $response['respuesta'];
echo "<br /><br />url_xml	:$url/" . $response['url_xml'];
echo "<a href=$url/" . $response['url_xml'] . " download=xml>Descargar XML</a>";
echo "<br /><br />hash_cpe	: " . $response['hash_cpe'];
echo "<br /><br />hash_cdr	: " . $response['hash_cdr'];
echo "<br /><br />msj_sunat	: " . $response['msj_sunat'];
echo "<br /><br />cod_msj_sunat	: " . $response['cod_msj_sunat'];
echo "<br /><br />mensaje	: " . $response['mensaje'];
echo "<br /><br />ruta_cdr	: $url/" . $response['ruta_cdr'];
echo "<a href=$url/" . $response['ruta_cdr'] . " download=xml>Descargar CDR</a>";
echo "<br /><br />ruta_pdf	: " . $response['ruta_pdf'];
echo "<br /><br />Nombre Servidor Sunat	:" . $response['ruta_ws']; */
/***************************************************/
/***************************************************/
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
$rutaXML		= $response['url_xml'];
$rutaCDR		= $response['ruta_cdr'];
$fecha_envio	= date('Y-m-d H:i:s');
/******************************************************/
$cod_msj_sunat	= $response['cod_msj_sunat'];
$msj 			= $response['msj_sunat'];
$msj_sunat  	= 'ha sido aceptada';
$msj_resul		= strpos($msj, $msj_sunat);
/******************************************************/
if ($msj_resul == true && $response['hash_cpe'] != '' && $response['hash_cdr'] != '') {
	$sqlActRegVentas = mysqli_query($conexion, "UPDATE factura SET fecha_enviosunat='$fecha_envio', ruta_xml='$rutaXML', ruta_cdr='$rutaCDR', estado='Enviado' WHERE id_factura='$id_factura'");
}
/******************************************************/
$salidaJson	= array(
	"respuesta"  => $response['respuesta'],
	"mensaje"  	 => $response['msj_sunat'],
	"resultadosunat" => $resultadoSunat
);
echo json_encode($salidaJson);
