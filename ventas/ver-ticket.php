<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
require("../config/EnLetras.php");
date_default_timezone_set('America/Lima');
/****************************************************************************/
/****************************************************************************/
$id_factura 	= $_REQUEST['id_factura'];
$sqlVerificar 	= mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$numFact		= mysqli_num_rows($sqlVerificar);
if ($numFact == 0) {
	echo "
	<script>
		alert('Factura no encontrada');
		window.close();
	</script>";
	exit;
}
$sqlFactura 	= mysqli_query($conexion, "SELECT * FROM factura WHERE id_factura='$id_factura'");
$rw_factura 	= mysqli_fetch_array($sqlFactura);
$id_factura 	= $rw_factura['id_factura'];
$serie 			=  $rw_factura['serie'];
$num_comprobante = $rw_factura['num_comprobante'];
$codigo_compro 	=  $rw_factura['codigo_compro'];
$cod_tipodoc 	=  $rw_factura['cod_tipodoc'];
$fecha_registro	=  $rw_factura['fecha_registro'];
if ($codigo_compro == '01') {
	$documento 	= "Factura Electronica";
	$tipo_doc	= "RUC";
}
if ($codigo_compro == '03') {
	$documento 	= "Boleta Venta Electronica";
	$tipo_doc	= "DNI";
}
if ($codigo_compro == '07' and $cod_tipodoc == '1') {
	$documento 	= "Nota Credido Electronica";
	$tipo_doc	= "RUC";
}
if ($codigo_compro == '07' and $cod_tipodoc == '2') {
	$documento 	= "Nota Credido Electronica";
	$tipo_doc	= "DNI";
}
if ($codigo_compro == '100') {
	$documento 	= "Nota de Ventas";
}
$razon_social		=  $rw_factura['razon_social'];
$direccion_empresa	=  $rw_factura['direccion_empresa'];
$numero_documento	=  $rw_factura['numero_documento'];
$cod_puntoventa		=  $rw_factura['cod_puntoventa'];
$total_grabadas		=  $rw_factura['total_grabadas'];
$total_igv			=  $rw_factura['total_igv'];
$total_monto		=  $rw_factura['total_monto'];
$forma_pago			=  $rw_factura['forma_pago'];
$cod_tipo_motivo 	=  $rw_factura['cod_tipo_motivo'];
/****************************************************/
$sqlMotivoNc		= mysqli_query($conexion, "SELECT descripcion FROM motivo_nota_credito WHERE codigo='$cod_tipo_motivo'");
$fncred 			= mysqli_fetch_array($sqlMotivoNc);
$motivoNotaCredito 	= $fncred['descripcion'];
/****************************************************/
?>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href="css/ticket.css" rel="stylesheet" type="text/css">
	<script>
		function printPantalla() {
			document.getElementById('cuerpoPagina').style.marginRight = "0";
			document.getElementById('cuerpoPagina').style.marginTop = "1";
			document.getElementById('cuerpoPagina').style.marginLeft = "1";
			document.getElementById('cuerpoPagina').style.marginBottom = "0";
			document.getElementById('botonPrint').style.display = "none";
			window.print()
		}
	</script>
</head>

<body id="cuerpoPagina">
	<div class="zona_impresion">
		<!-- ************************************************************** -->
		<!-- ************* 		DISEÑO DE TICKET AQUI     ***************** -->
		<!-- ************************************************************** -->
		<table border="0" align="center" width="360">
			<!-- ********************************************************** -->
			<!-- ************* 		  CABECERA DE TICKET      ************* -->
			<!-- ********************************************************** -->
			<tr>
				<td align="center">
					<img src="imagenes/logo-ticket.png" alt="CPW Training Center" width="215" height="82">
				</td>
			</tr>
			<tr>
				<td align="center">
					<?php
					if ($codigo_compro == '01' || $codigo_compro == '03' || $codigo_compro == '07') {
						echo "
						<strong>RUC : $xRucEmpresa</strong><br>
						$xDirecEmpre<br>
						Telefono : $xTelefEmpre<br>
						Email : $xEmailEmpre";
					} else {
						echo "						
						$xDirecEmpre<br>
						Telefono : $xTelefEmpre";
					}
					?>
				</td>
			</tr>
			<tr>
				<td align="center">
					<strong style="font-size: 16px; font-weight: 600;">
						<?php
						echo $documento . "<br>";
						echo $serie . '-' . str_pad($num_comprobante, 8, "0", STR_PAD_LEFT);
						?>
					</strong>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<?php
			if ($codigo_compro == '01' || $codigo_compro == '03') {
			?>
				<tr>
					<td><?= "FECHA : " . date('d/m/Y', strtotime($fecha_registro)); ?></td>
				</tr>
				<?php
				if ($razon_social != '') {
					echo "
					<tr>					
						<td>CLIENTE : $razon_social</td>
					</tr>";
				}
				if ($numero_documento != '') {
					echo "
					<tr>					
						<td>$tipo_doc : $numero_documento</td>
					</tr>";
				}
				if ($direccion_empresa != '') {
					echo "
					<tr>					
						<td>DIRECCION : $direccion_empresa</td>
					</tr>";
				}
				echo "
				<tr>
					<td>FORMA PAGO : $forma_pago</td>
				</tr>";
				?>
			<?php
			} else if ($codigo_compro == '07') {
			?>
				<tr>
					<td><?= "FECHA : " . date('d/m/Y', strtotime($fecha_registro)); ?></td>
				</tr>
				<?php
				if ($razon_social != '') {
					echo "
					<tr>					
						<td>CLIENTE : $razon_social</td>
					</tr>";
				}
				if ($numero_documento != '') {
					echo "
					<tr>					
						<td>$tipo_doc : $numero_documento</td>
					</tr>";
				}
				if ($direccion_empresa != '') {
					echo "
					<tr>					
						<td>DIRECCION : $direccion_empresa</td>
					</tr>";
				}
				if ($motivoNotaCredito  != '') {
					echo "
					<tr>					
						<td>MOTIVO : $motivoNotaCredito </td>
					</tr>";
				}
				?>
			<?php
			} else {
			?>
				<tr>
					<td><?= "FECHA : " . date('d/m/Y', strtotime($fecha_registro)); ?></td>
				</tr>
				<tr>
					<td><?= "FORMA PAGO : " . $forma_pago ?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td></td>
			</tr>
		</table>
		<!-- ********************************************************** -->
		<!-- ************* 	    CCONTENIDO DE TICKET      ************* -->
		<!-- ********************************************************** -->
		<table border="0" align="center" width='360'>
			<tr>
				<td colspan="4">==================================================</td>
			</tr>
			<tr>
				<td>
					<strong>
						C.
					</strong>
				</td>
				<td>
					<strong>
						DESCRIP.
					</strong>
				</td>
				<td align="right">
					<strong>
						P. UNIT
					</strong>
				</td>
				<td align="right">
					<strong>
						TOTAL
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="4">==================================================</td>
			</tr>
			<?php
			$sqlDetalleFact 	= mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
			while ($fDetFac		= mysqli_fetch_array($sqlDetalleFact)) {
				$producto 		= $fDetFac['producto'];
				$cantidad 		= $fDetFac['cantidad'];
				$precio 		= $fDetFac['precio'];
				$totalProduct	= ($cantidad * $precio);
				$subTotal 	   += $totalProduct;
				$suma++;
			?>
				<tr>
					<td><?= $cantidad ?></td>
					<td><?= $producto ?></td>
					<td align="right"><?= $precio ?></td>
					<td align="right"><?= $totalProduct ?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="4">==================================================</td>
			</tr>
			<!-- ********************************************************** -->
			<!-- ************* 	    PIE DE PAGINA DE TICKET     *********** -->
			<!-- ********************************************************** -->
			<?php
			if ($codigo_compro == '01' || $codigo_compro == '03' || $codigo_compro == '07') {
			?>
				<tr>
					<td colspan="3" align="right">SUB TOTAL :</td>
					<td align="right">s/. <?= number_format($subTotal, 2) ?></td>
				</tr>
				<tr>
					<td colspan="3" align="right">TOTAL GRABADAS :</td>
					<td align="right">s/. <?= number_format($total_grabadas, 2) ?></td>
				</tr>
				<tr>
					<td colspan="3" align="right">IVG :</td>
					<td align="right">s/. <?= number_format($total_igv, 2) ?></td>
				</tr>
				<tr>
					<td colspan="3" align="right">IMP. TOTAL :</td>
					<td align="right">s/. <?= number_format($total_monto, 2) ?></td>
				</tr>
			<?php
			} else {
			?>
				<tr>
					<td colspan="3" align="right">IMP. TOTAL :</td>
					<td align="right">s/. <?= number_format($total_monto, 2) ?></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="4">==================================================</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php
					$V 		= new EnLetras();
					$con_letra = strtoupper($V->ValorEnLetras($total_monto, "soles"));
					echo "<strong>SON : " . $con_letra . '</strong>';
					?>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<img src="qr/<?= $codigo_compro . '-' . $serie . '-' . $num_comprobante . '.png'; ?>" alt="" width="100" height="100">
				</td>
			</tr>
			<?php
			if ($codigo_compro == '01' || $codigo_compro == '03' || $codigo_compro == '07') {
			?>
				<tr>
					<td colspan="4" align="center">
						Autorizado mediante Resolución de Intendencia Nº 032-005 Representacion impresa de la <?= $documento ?>.
						Consulte su documento electrónico en htts://www.sunat.gob.pe
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						Nº de Articulos : <?= $suma ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<strong>¡Gracias por su compra!</strong>
					</td>
				</tr>
			<?php
			} else {
			?>
				<tr>
					<td colspan="4" align="center">
						Nº de Articulos : <?= $suma ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<strong>¡Comprobante, canjeable por una boleta o factura!</strong>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
		</table>
		<!-- ************************************************************** -->
		<!-- ************************************************************** -->
	</div>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<div style="margin-left:245px;">
		<a href="#" id="botonPrint" onClick="printPantalla();">
			<img src="imagenes/printer.png" border="0" style="cursor:pointer" title="Imprimir">
		</a>
	</div>
</body>

</html>