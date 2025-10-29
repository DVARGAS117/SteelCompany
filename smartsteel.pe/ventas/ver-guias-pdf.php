<?php
require_once('tcpdf_include.php');
require("../config/conexion.php");
require("../config/inicializar-datos.php");
require("../config/EnLetras.php");
date_default_timezone_set('America/Lima');
/*************************************************************/
/*********************  CREAR FACTURA   **********************/
/*************************************************************/
$id_guia            = $_REQUEST['id_guia'];
/*************************************************************/
/*************************************************************/
$nommes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
/*************************************************************/
/*************************************************************/
$sqlFactura         = mysqli_query($conexion, "SELECT * FROM guias_remision WHERE id_guia='$id_guia'");
$rw_factura         = mysqli_fetch_array($sqlFactura);
$id_factura         = $rw_factura['id_factura'];
$num_guia           = $rw_factura['num_guia'];
$serie              = $rw_factura['serie'];
$codigo_compro      = $rw_factura['codigo_compro'];
$fecha_registro     = $rw_factura['fecha_registro'];
$peso               = $rw_factura['peso'] . 'Kg.';
$numero_paquetes    = $rw_factura['numero_paquetes'];
$motivo_traslado    = $rw_factura['motivo_traslado'];
$fecha_traslado     = date('d-m-Y', strtotime($rw_factura['fecha_traslado']));
$fecha_llegada      = date('d-m-Y', strtotime($rw_factura['fecha_llegada']));
if ($codigo_compro == '09') {
    $documento      = "Guía de Remisión";
}
/****************************************************/
$sqlDatosFact       = mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$ffact              = mysqli_fetch_array($sqlDatosFact);
$razon_social       = $ffact['razon_social'];
$direccion_empresa  = $ffact['direccion_empresa'];
$numero_documento   = $ffact['numero_documento'];
/****************************************************/
$imgQR             = "<img src='qr/$codigo_compro-$serie-$num_guia.png' width='100' height='100'>";
/****************************************************/
$resultDate     = 0;
$resultDate     = strtotime($fecha_registro);
$diasemana         = date("w", $resultDate);
$dia             = date("d", $resultDate);
$mes             = date("n", $resultDate);
$anio             = date("Y", $resultDate);
$fecha_emision     = 'Fecha Emisión : ' . $dia . ' ' . $nommes[$mes - 1] . ' del ' . $anio;
/*************************************************************/
/*********************     CREAR PDF    **********************/
/*************************************************************/
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($xRazonSocial);
$pdf->SetTitle($serie . '-' . $num_guia);
$pdf->SetSubject('GUIA DE REMISION');
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
if ($codigo_compro == '09') {
    $html .= '	
		<tr>
			<td><p><strong>Cliente :</strong> ' . $razon_social . '</p></td>
		</tr>
		<tr>
			<td><p><strong>RUC/DNI :</strong> ' . $numero_documento . '</p></td>
			</tr>		
		<tr>
			<td><p><strong>Direccion :</strong> ' . $direccion_empresa . '</p></td>
		</tr>';
}
$html .= '			
	    </table>	
	  </td>
      <td width="20%">&nbsp;</td>
      <td width="35%">
		<div style="border: 1px solid #000;">
			<h1 style="text-align: center; font-size: 16px; margin: 0; display: block; line-height: 25px;">RUC : ' . $xRucEmpresa . '</h1>
			<h2 style="text-align: center; font-size: 16px; margin: 0; display: block; background-color:#cccccc; line-height: 25px;">' . $documento . '</h2>
			<h3 style="text-align: center; font-size: 11px; margin: 0; display: block; line-height: 25px;">' . $serie . '-' . $num_guia . '</h3>
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
$sqlDetalleFacts    = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
while ($fDetFac        = mysqli_fetch_array($sqlDetalleFacts)) {
    if ($fDetFac['num_documento_ser'] != '') {
        $producto    = $fDetFac['producto'] . '<br>' . $fDetFac['num_documento_ser'];
    } else {
        $producto    = $fDetFac['producto'];
    }
    $cantidad        = $fDetFac['cantidad'];
    $precio            = number_format($fDetFac['precio'], 2);
    $totalprod        = number_format(($precio * $cantidad), 2);
    /**************************************************/
    $subtotal        += $totalprod;
    /**************************************************/
    $html .= '	
		<tr>
		<td>' . $cantidad . '</td>
		<td>' . $producto . '</td>
		<td style="text-align: right">S/. ' . $precio . '</td>
		<td style="text-align: right">S/. ' . $totalprod . '</td>
		</tr>';
}
$V            = new EnLetras();
$con_letra    = strtoupper($V->ValorEnLetras($subtotal, "soles"));

$html .=
    '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
					<tr>
						<td style="text-align: right" width="85%">IMPORTE TOTAL :</td>
						<td style="text-align: right" width="15%"><strong>S/. ' . number_format($subtotal, 2) . '</strong></td>
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
				<p style="text-align: center">PESO : ' . $peso . '</p>
                <p style="text-align: center">Nº PAQUETES : ' . $numero_paquetes . '</p>
                <p style="text-align: center">MOTIVO TRASLADO : ' . $motivo_traslado . '</p>
                <p style="text-align: center">FECHA TRASLADO : ' . $fecha_traslado . '</p>
                <p style="text-align: center">FECHA LLEGADA : ' . $fecha_llegada . '</p>
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
$pdf->Output($xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_guia . '.pdf', 'I');
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'APPFACT2022/img-apps/pdf/' . $xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_guia . '.pdf', 'F');
$nombrePDF = $xRucEmpresa . '-' . $codigo_compro . '-' . $serie . '-' . $num_guia . '.pdf';
$sqlActualizarFact = mysqli_query($conexion, "UPDATE guias_remision SET pdf='$nombrePDF' WHERE id_guia='$id_guia'");
