<?php
require_once('tcpdf_include.php');
require("../config/conexion.php");
require("../config/inicializar-datos.php");
require("../config/EnLetras.php");
date_default_timezone_set('America/Lima');
/*************************************************************/
/*********************  CREAR FACTURA   **********************/
/*************************************************************/
$id_factura		= $_REQUEST['id_factura'];
/*************************************************************/
/*************************************************************/
$nommes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
/*************************************************************/
/*************************************************************/
$sqlFactura		= mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$rw_factura		= mysqli_fetch_array($sqlFactura);
$id_factura		= $rw_factura['id_factura'];
$num_comprobante = str_pad($rw_factura['num_comprobante'], 8, "0", STR_PAD_LEFT);
$num_comp		= $rw_factura['num_comprobante'];
$serie			= $rw_factura['serie'];
$codigo_compro	= $rw_factura['codigo_compro'];
$fecha_registro	= $rw_factura['fecha_registro'];
$cod_tipodoc 	= $rw_factura['cod_tipodoc'];
if ($codigo_compro == '01') {
	$doc		= "Factura electronica";
	$tipo_doc	= "RUC";
}
if ($codigo_compro == '03') {
	$doc		= "Boleta de Venta Electronica";
	$tipo_doc	= "DNI";
}
if ($codigo_compro == '07' and $cod_tipodoc = 1) {
	$doc 		= "Nota Credido Electronica";
	$tipo_doc	= "RUC";
}
if ($codigo_compro == '07' and $cod_tipodoc = 2) {
	$doc 		= "Nota Credido Electronica";
	$tipo_doc	= "DNI";
}
if ($codigo_compro == '100') {
	$doc 		= "Nota de Ventas";
}
$nombre_cliente		= $rw_factura['razon_social'];
$direccion_cliente 	= $rw_factura['direccion_empresa'];
$documento 			= $rw_factura['numero_documento'];
$xcod_puntoven		= $rw_factura['cod_puntoventa'];
$total_grabadas		= $rw_factura['total_grabadas'];
$total_igv			= $rw_factura['total_igv'];
$total_monto		= $rw_factura['total_monto'];
$forma_pago			= $rw_factura['forma_pago'];
/*************************************************************/
$imgQR 			= "<img src='qr/$serie-$num_comp.png' width='100' height='100'>";
/*************************************************************/
$resultDate 	= 0;
$resultDate 	= strtotime($fecha_registro);
$diasemana 		= date("w", $resultDate);
$dia 			= date("d", $resultDate);
$mes 			= date("n", $resultDate);
$anio 			= date("Y", $resultDate);
$fecha_emision 	= 'Fecha Emisión : ' . $dia . ' ' . $nommes[$mes - 1] . ' del ' . $anio;
/*************************************************************/
/*********************     CREAR PDF    **********************/
/*************************************************************/
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($xRazonSocial);
$pdf->SetTitle($serie . '-' . $num_comprobante);
$pdf->SetSubject('COMPROBANTE DE PAGO');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/spa.php')) {
	require_once(dirname(__FILE__) . '/lang/spa.php');
	$pdf->setLanguageArray($l);
}
// Configurar Tipografia
$pdf->SetFont('dejavusans', '', 8);
// Agregar Pagina
$pdf->AddPage();
/*********************************************************/
$html .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="45%">
		<p style="text-align: center; margin:0;">
		<img src="imagenes/logo-ticket.png" width="215" height="82" alt="CPW Training Center"/>
		</p>
        <p style="text-align: center; font-size: 9px; margin: 0; font-weight: bold;">
        ' . $xRazonSocial . '<br>
		RUC: ' . $xRucEmpresa . '<br>
		' . $xDirecEmpre . '<br>
		Teléfonos : ' . $xTelefEmpre . '<br>
		Email : ' . $xEmailEmpre . '</p>
		<table width="100%" border="0" cellspacing="0" cellpadding="1">';
if ($codigo_compro == '01') {
	$html .= '	
		<tr>
			<td><p><strong>Cliente :</strong> ' . $nombre_cliente . '</p></td>
		</tr>
		<tr>
			<td><p><strong>' . $tipo_doc . ' :</strong> ' . $documento . '</p></td>
			</tr>		
		<tr>
			<td><p><strong>Direccion :</strong> ' . $direccion_cliente . '</p></td>
		</tr>			
		<tr>
			<td><p><strong>Forma Pago	:</strong> ' . $forma_pago . '</p></td>
		</tr>';
}
if ($codigo_compro == '03') {
	$html .= '	
		<tr>
			<td><p><strong>Cliente :</strong> ' . $nombre_cliente . '</p></td>
		</tr>
		<tr>
			<td><p><strong>' . $tipo_doc . ' :</strong> ' . $documento . '</p></td>
		</tr>
		<tr>
			<td><p><strong>Forma Pago	:</strong> ' . $forma_pago . '</p></td>
		</tr>';
}
if ($codigo_compro == '07') {
	$html .= '	
		<tr>
			<td><p><strong>Cliente :</strong> ' . $nombre_cliente . '</p></td>
		</tr>
		<tr>
			<td><p><strong>' . $tipo_doc . ' :</strong> ' . $documento . '</p></td>
		</tr>					
		<tr>
			<td><p><strong>Direccion :</strong> ' . $direccion_cliente . '</p></td>
		</tr>
		<tr>
			<td><p><strong>Motivo de Nota Credito :</strong> ' . $motivoNotaCredito . '</p></td>
			</tr>
		<tr>
			<td><p><strong>Documento Modificado	:</strong>' . $doc_modificado . '</p></td>
		</tr>';
}
if ($codigo_compro == '100') {
	$html .= '	
		<tr>
			<td><p><strong>Fecha Emision :</strong> ' . date('d-m-Y', strtotime($fecha_registro)) . '</p></td>
		</tr>
		<tr>
			<td><p><strong>Forma Pago	:</strong> Contado</p></td>
		</tr>';
}
$html .= '			
	    </table>	
	  </td>
      <td width="20%">&nbsp;</td>
      <td width="35%">
		<div style="border: 1px solid #000;">
			<h1 style="text-align: center; font-size: 16px; margin: 0; display: block; line-height: 25px;">RUC : ' . $xRucEmpresa . '</h1>
			<h2 style="text-align: center; font-size: 16px; margin: 0; display: block; background-color:#cccccc; line-height: 25px;">' . $doc . '</h2>
			<h3 style="text-align: center; font-size: 11px; margin: 0; display: block; line-height: 25px;">' . $serie . '-' . $num_comprobante . '</h3>
		</div>
		<p style="text-align: center;"><strong>' . $fecha_emision . '</strong></p>
	  </td>
    </tr>
  </tbody>
</table>
<br><br>
<table width="100%" border="1" cellpadding="6">
	<tr bgcolor="#e5e5e5">
	  <th width="10%" style="text-align: center;"><strong>CANT.</strong> </th>
	  <th width="60%" style="text-align: center;"><strong>DESCRIPCION</strong> </th>
	  <th width="15%" style="text-align: center;"><strong>P. UNIT.</strong> </th>
	  <th width="15%" style="text-align: center;"><strong>IMPORTE</strong> </th>
	</tr>';
$sqlDetalleFacts	= mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
while ($fDetFac		= mysqli_fetch_array($sqlDetalleFacts)) {
	if ($fDetFac['num_documento_ser'] != '') {
		$producto	= $fDetFac['producto'] . '<br>' . $fDetFac['num_documento_ser'];
	} else {
		$producto	= $fDetFac['producto'];
	}
	$cantidad		= $fDetFac['cantidad'];
	$precio			= number_format($fDetFac['precio'], 2);
	$totalprod		= number_format(($precio * $cantidad), 2);
	/**************************************************/
	$subtotal		+= $totalprod;
	/**************************************************/
	$html .= '	
		<tr>
		<td>' . $cantidad . '</td>
		<td>' . $producto . '</td>
		<td style="text-align: right">S/. ' . $precio . '</td>
		<td style="text-align: right">S/. ' . $totalprod . '</td>
		</tr>';
}
$V			= new EnLetras();
$con_letra	= strtoupper($V->ValorEnLetras($total_monto, "soles"));

$html .=
	'</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
					<tr>
						<td style="text-align: right" width="85%">SUB TOTAL :</td>
						<td style="text-align: right" width="15%"><strong>S/. ' . number_format($subtotal, 2) . '</strong></td>
					</tr>
					<tr>
						<td style="text-align: right" width="85%">OP. GRAVADAS :</td>
						<td style="text-align: right" width="15%"><strong>S/. ' . number_format($total_grabadas, 2) . '</strong></td>
					</tr>
					<tr>
						<td style="text-align: right" width="85%">I.G.V. :</td>
						<td style="text-align: right" width="15%"><strong>S/. ' . number_format($total_igv, 2) . '</strong></td>
					</tr>
					<tr>
						<td style="text-align: right" width="85%">TOTAL IMPORTE :</td>
						<td style="text-align: right" width="15%"><strong>S/. ' . number_format(($total_monto), 2) . '</strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<h4 style="text-align: center">SON : ' . $con_letra . '</h4>
				<h3 style="text-align: center">CANCELADO</h3>
				<p style="text-align: center">' . $fecha_emision . '</p>
				' . $imgQR . '<br>
				<p style="text-align: center">Autorizado mediante Resolución de Intendencia Nº 032-005 Representacion impresa de la ' . $doc . '
				Consulte su documento electrónico en htts://www.sunat.gob.pe</p>
			</td>		
		</tr>
	</table>';
/*********************************************************/
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
$pdf->Output($xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_comprobante . '.pdf', 'I');
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'APPFACT2022/img-apps/pdf/' . $xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_comprobante . '.pdf', 'F');
$nombrePDF = $xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_comprobante . '.pdf';
$sqlActualizarFact = mysqli_query($conexion, "UPDATE factura SET pdf='$nombrePDF' WHERE id_factura='$id_factura'");
