<?php
require('../../config/conexion.php');
require("../../config/inicializar-datos.php");
require('../../config/EnLetras.php');
/************************************************/
$id_factura         = $_POST['id_factura'];
//$id_factura         = 3;
/************************************************/
include "../url_api/url.php";
$ruta               = "$url/api_facturacion/factura.php";
/************************************************/
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
$sqlSecuencia       = mysqli_query($conexion, "SELECT * FROM secuencia_envios_resboleta");
$fsecuencia         = mysqli_fetch_array($sqlSecuencia);
$secuencia          = $fsecuencia['secuencia'] + 1;
$sqlActSecuencia    = mysqli_query($conexion, "UPDATE secuencia_envios_resboleta SET secuencia='$secuencia'");
/************************************************/
$sqlRegtVentas      = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$fregven            = mysqli_fetch_array($sqlRegtVentas);
$codigo_compro      = $fregven['codigo_compro'];
/************ Datos del Cliente ****************/
$ruc_empresa        = $fregven['numero_documento'];
$razon_social       = $fregven['razon_social'];
$direccion_empresa  = $fregven['direccion_empresa'];
/************ Datos de Factura ****************/
$serie              = $fregven['serie'];
$num_comprobante    = $fregven['num_comprobante'];
$fecha_registro     = $fregven['fecha_registro'];
/************************************************/
$totalGrabadas          = 0;
$totalIgv               = 0;
$totalGeneral           = 0;
$MtoImportVenta         = 0;
$sqlDetalles            = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
while ($filaDet         = mysqli_fetch_array($sqlDetalles)) {
    $cantidad           = $filaDet['cantidad'];
    $precio_unitario    = $filaDet['precio'];
    $total              = $filaDet['precio_con_igv'];
    $totalGrabadas      = ($totalGrabadas + $filaDet['precio_sin_igv']);
    $totalIgv           = ($totalIgv + $filaDet['igv']);
    $MtoImportVenta     = ($MtoImportVenta + $filaDet['precio_con_igv']);
}
$V                    = new EnLetras();
$totaLetras            = strtoupper($V->ValorEnLetras($MtoImportVenta, "SOLES"));
/************************************************/
/************************************************/
$data    = '{';
$data  .= '	
    "tipo_operacion"				: "0101",
    "total_gravadas"               	: "' . round($totalGrabadas, 2) . '",
    "total_inafecta"                : "0",
    "total_exoneradas"				: "0",
    "total_gratuitas"			    : "0",
    "total_exportacion"		    	: "0",
    "total_descuento"	    		: "0",
    "sub_total"              		: "' . round($totalGrabadas, 2) . '",
    "porcentaje_igv"                : "18.00",
    "total_igv"                     : "' . round($totalIgv, 2) . '",
    "total_isc"                   	: "0",
    "total_otr_imp"                 : "0",
    "total"                  		: "' . round($MtoImportVenta, 2) . '",
	"total_letras"              	: "' . $totaLetras . '",
    "nro_guia_remision"             : "",
    "cod_guia_remision"             : "",
    "nro_otr_comprobante"           : "",
    "serie_comprobante"             : "' . $serie . '",
    "numero_comprobante"            : "' . $num_comprobante . '",
    "fecha_comprobante"             : "' . $fecha_registro . '",
    "fecha_vto_comprobante"         : "' . date('Y-m-d') . '",
    "cod_tipo_documento"            : "01",
	"cod_moneda"                    : "PEN",
	
	"cliente_numerodocumento"       : "' . $ruc_empresa . '",
    "cliente_nombre"                : "' . $razon_social . '",
    "cliente_tipodocumento"         : "6",
	"cliente_direccion"             : "' . $direccion_empresa . '",
	"cliente_pais"         			: "PE",
	"cliente_ciudad"				: "Lima",
    "cliente_codigoubigeo"          : "",
    "cliente_departamento"          : "",
    "cliente_provincia"         	: "",
    "cliente_distrito"              : "",
		
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
$sqlDetalles                = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
$totalProd                  = mysqli_num_rows($sqlDetalles);
while ($filaDet             = mysqli_fetch_array($sqlDetalles)) {
    $producto               = $filaDet['producto'];
    $cantidad               = $filaDet['cantidad'];
    $precio                 = $filaDet['precio'];
    $setMtoImpVenta         = $filaDet['precio_con_igv'];
    $setValorVenta          = $filaDet['precio_sin_igv'];
    $setTotalImpuestos      = $filaDet['igv'];
    $preciouni_conigv       = ($setMtoImpVenta / $cantidad);
    $preciouni_sinigv       = ($setValorVenta / $cantidad);
    $num++;
    $cod_prod               = "PRO-$num";
    /************************************************/
    /************************************************/
    $data    .= '
		{
		"txtITEM"          			: ' . ($i + 1) . ',
		"txtUNIDAD_MEDIDA_DET"      : "NIU",
		"txtCANTIDAD_DET"           : "' . $cantidad . '",
		"txtPRECIO_DET"             : "' . round($preciouni_conigv, 2) . '",
		"txtSUB_TOTAL_DET"          : "' . round($setValorVenta, 2) . '",
		"txtPRECIO_TIPO_CODIGO"     : "01",
		"txtIGV"                 	: "' . round($setTotalImpuestos, 2) . '",
		"txtISC"                  	: "0",
		"txtIMPORTE_DET"            : "' . round($setValorVenta, 2) . '",
		"txtCOD_TIPO_OPERACION"     : "10",
		"txtCODIGO_DET"             : "' . $cod_prod . '",
		"txtDESCRIPCION_DET"   		: "' . $producto . '",
		"txtPRECIO_SIN_IGV_DET"  	: "' . round($preciouni_sinigv, 5) . '"
		}';
    $i++;
    if ($i < $totalProd) {
        $data .= ',';
    }
}
$data .= '
  ]
}';
/***************************************************/
/***************************************************/
$token = ''; //en caso quieras utilizar algún token generado desde tu sistema
/***************************************************/
/***************************************************/
$data_json = $data;
/***************************************************/
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
/***************************************************/
/***************************************************/
$rutaXML        = $response['url_xml'];
$rutaCDR        = $response['ruta_cdr'];
$fecha_envio    = date('Y-m-d H:i:s');
/***************************************************/
/***************************************************/
$cod_msj_sunat  = $response['cod_msj_sunat'];
$msj            = $response['msj_sunat'];
$msj_sunat      = 'ha sido aceptada';
$msj_resul      = strpos($msj, $msj_sunat);
/***************************************************/
/***************************************************/
if ($msj_resul == true && $response['hash_cpe'] != '' && $response['hash_cdr'] != '') {
    $sqlActRegVentas = mysqli_query($conexion, "UPDATE factura SET fecha_enviosunat='$fecha_envio', ruta_xml='$rutaXML', ruta_cdr='$rutaCDR', estado='Enviado' WHERE id_factura='$id_factura'");
}
/***************************************************/
/***************************************************/
$salidaJson    = array(
    "respuesta"         => $response['respuesta'],
    "mensaje"           => $response['msj_sunat'],
    "resultadosunat"    => $resultadoSunat
);
echo json_encode($salidaJson);
