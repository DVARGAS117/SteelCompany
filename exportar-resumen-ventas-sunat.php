<?php
require("config/conexion.php");
/***********************************************/
/***********************************************/
$nombreExcel = "reporte-ventas-sunat" . date('d-m-Y-His') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$nombreExcel\"");
/***********************************************/
/***********************************************/
$sqlxEmpresa        = mysqli_query($conexion, "SELECT * FROM empresa");
$xefila             = mysqli_fetch_array($sqlxEmpresa);
$xeruc              = $xefila['ruc'];
$xerazon            = $xefila['razon_social'];
$xenomcom           = $xefila['nombre_comercial'];
$xedireccion        = $xefila['direccion'];
/***********************************************/
/***********************************************/
$fecha_inicio       = $_POST['fecha_inicio'];
$fecha_final        = $_POST['fecha_final'];
/***********************************************/
/***********************************************/
$nommes             = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$diasemana          = date("w", strtotime($fecha_final));
$dia                = date("d", strtotime($fecha_final));
$mes                = date("n", strtotime($fecha_final));
$anio               = date("Y", strtotime($fecha_final));
$fecha_reporte      = $nommes[$mes - 1] . ' del ' . $anio;
/***********************************************/
/***********************************************/
function ceroizquierda($valor, $longitud)
{
    $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
    return $res;
}
/***********************************************/
/***********************************************/
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte para Sunat</title>
</head>

<body>
    <h1>REGISTRO DE VENTAS E INGRESOS (FORMATO 14.1)</h1>
    <p>EJERCICIO : <?= $fecha_reporte; ?><br>
        RUC : <?= $xeruc ?><br>
        RAZON SOCIAL : <?= $xerazon ?></p>
    <!-- ****************************************************** -->
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td rowspan="3" valign="middle" bgcolor="#E1E1E1"><strong>Loc.</strong></td>
                <td rowspan="3" valign="middle" bgcolor="#E1E1E1"><strong>Fecha Emision<br>
                        Comprobante</strong></td>
                <td rowspan="3" valign="middle" bgcolor="#E1E1E1"><strong>Fecha Vcto.<br>
                        y/o Pago</strong></td>
                <td colspan="3" align="center" bgcolor="#E1E1E1"><strong>Comprobante de Pago</strong></td>
                <td colspan="3" align="center" bgcolor="#E1E1E1"><strong>Información Del Cliente</strong></td>
                <td rowspan="3" align="left" valign="middle" bgcolor="#E1E1E1"><strong>Base<br>
                        Imponible</strong></td>
                <td colspan="2" align="center" bgcolor="#E1E1E1"><strong>Importe Total de Operacion</strong></td>
                <td rowspan="3" align="right" valign="middle" bgcolor="#E1E1E1"><strong>IGV
                        y/o<br>
                        IPM</strong></td>
                <td rowspan="3" align="right" valign="middle" bgcolor="#E1E1E1"><strong>Importe <br>
                        Total<br>
                        Comprobante</strong></td>
                <td rowspan="3" align="right" valign="middle" bgcolor="#E1E1E1"><strong>Tipo de<br>
                        Cambio</strong></td>
                <td colspan="4" rowspan="2" align="center" valign="middle" bgcolor="#E1E1E1">Referencia de Comprobante de Pago</td>
            </tr>
            <tr>
                <td rowspan="2" align="left" bgcolor="#E1E1E1"><strong>Tipo Doc</strong></td>
                <td rowspan="2" align="left" bgcolor="#E1E1E1"><strong>Serie</strong></td>
                <td rowspan="2" align="left" bgcolor="#E1E1E1"><strong>Número</strong></td>
                <td colspan="2" align="center" bgcolor="#E1E1E1"><strong>Documento Identidad</strong></td>
                <td rowspan="2" align="center" bgcolor="#E1E1E1"><strong>Apellidos Nombres<br>
                        ó Razón Social</strong></td>
                <td rowspan="2" valign="middle" bgcolor="#E1E1E1"><strong>Exonerada</strong></td>
                <td rowspan="2" valign="middle" bgcolor="#E1E1E1"><strong>Inafecta</strong></td>
            </tr>
            <tr>
                <td bgcolor="#E1E1E1"><strong>Tipo</strong></td>
                <td bgcolor="#E1E1E1"><strong>Número</strong></td>
                <td align="center" valign="middle" bgcolor="#E1E1E1">F. Pago</td>
                <td align="center" valign="middle" bgcolor="#E1E1E1">Tipo</td>
                <td align="center" valign="middle" bgcolor="#E1E1E1">Serie</td>
                <td align="center" valign="middle" bgcolor="#E1E1E1">Número</td>
            </tr>
            <!-- ********************************************************** -->
            <!-- **************  CREACION REPORTE FACTURAS **************** -->
            <!-- ********************************************************** -->
            <?php
            $sqlListado         = mysqli_query($conexion, "SELECT * FROM factura WHERE fecha_registro>='$fecha_inicio' AND fecha_registro<='$fecha_final' AND codigo_compro='01' ORDER BY serie, num_comprobante ASC");
            $numFact            = 0;
            $totalFacturas      = 0;
            $totalIgv           = 0;
            $totalBase          = 0;
            while ($fila        = mysqli_fetch_array($sqlListado)) {
                $id_factura     = $fila['id_factura'];
                $fecha_registro = date('d-m-Y', strtotime($fila['fecha_registro']));
                $codigo_compro  = $fila['codigo_compro'];
                $serie          = $fila['serie'];
                $documento      = $fila['numero_documento'];
                if ($serie      == 'FF01') {
                    $local      = '001';
                }
                if ($serie      == 'FF02') {
                    $local      = '002';
                }
                if ($serie      == 'FF03') {
                    $local      = '003';
                }
                $nombre_cliente = utf8_encode($fila['razon_social']);
                $compro         = '&nbsp;01';
                $tipoDoc        = '&nbsp;06';
                $num_comprobante  = ceroizquierda($fila['num_comprobante'], 8);
                $numFact++;
                /**************************************************************/
                /*****************  DETALLE DE FACTURAS  **********************/
                /**************************************************************/
                $baseDisponible = 0;
                $totalImpuestos = 0;
                $importeTotal   = 0;
                $sqlDetalles    = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
                while ($filaDet  = mysqli_fetch_array($sqlDetalles)) {
                    $setValorVenta      = $filaDet['precio_sin_igv'];
                    $setTotalImpuestos  = $filaDet['igv'];
                    $setMtoImpVenta     = $filaDet['precio_con_igv'];
                    /**********************************************************/
                    $baseDisponible     = ($baseDisponible + $setValorVenta);
                    $totalImpuestos     = ($totalImpuestos + $setTotalImpuestos);
                    $importeTotal       = ($importeTotal + $setMtoImpVenta);
                }
                /**************************************************************/
                $totalBase              = ($totalBase + $baseDisponible);
                $totalIgv               = ($totalIgv + $totalImpuestos);
                $totalFacturas          = ($totalFacturas + $importeTotal);
                /**************************************************************/
            ?>
                <tr>
                    <td align="left"><?= $local ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td align="left"><?= $compro ?></td>
                    <td align="left"><?= $serie ?></td>
                    <td align="left"><?= $num_comprobante ?></td>
                    <td align="left"><?= $tipoDoc ?></td>
                    <td align="left"><?= $documento ?></td>
                    <td align="left"><?= $nombre_cliente ?></td>
                    <td align="left"><?= number_format($baseDisponible, 2) ?></td>
                    <td>0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;"><?= number_format($totalImpuestos, 2) ?></td>
                    <td style="text-align: right;"><?= number_format($importeTotal, 2) ?></td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1"><strong>(<?= $numFact ?>) Facturas</strong></td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1"><strong><?= number_format($totalFacturas, 2) ?></strong></td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <!-- ********************************************************** -->
            <!-- **************  CREACION REPORTE BOLETAS  **************** -->
            <!-- ********************************************************** -->
            <?php
            $sqlListado         = mysqli_query($conexion, "SELECT * FROM factura WHERE fecha_registro>='$fecha_inicio' AND fecha_registro<='$fecha_final' AND codigo_compro='03' ORDER BY serie, num_comprobante ASC");
            $numBol             = 0;
            $totalBoletas       = 0;
            $totalIgv           = 0;
            $totalBase          = 0;
            while ($fila        = mysqli_fetch_array($sqlListado)) {
                $id_factura     = $fila['id_factura'];
                $fecha_registro = date('d-m-Y', strtotime($fila['fecha_registro']));
                $codigo_compro  = $fila['codigo_compro'];
                $serie          = $fila['serie'];
                $documento      = $fila['numero_documento'];
                if ($serie      == 'BB01') {
                    $local      = '001';
                }
                if ($serie      == 'BB02') {
                    $local      = '002';
                }
                if ($serie      == 'BB03') {
                    $local      = '003';
                }
                $nombre_cliente = utf8_encode($fila['razon_social']);
                $compro         = '&nbsp;01';
                $tipoDoc        = '&nbsp;06';
                $num_comprobante  = ceroizquierda($fila['num_comprobante'], 8);
                $numBol++;
                /**************************************************************/
                /*****************  DETALLE DE FACTURAS  **********************/
                /**************************************************************/
                $baseDisponible = 0;
                $totalImpuestos = 0;
                $importeTotal   = 0;
                $sqlDetalles    = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
                while ($filaDet  = mysqli_fetch_array($sqlDetalles)) {
                    $setValorVenta      = $filaDet['precio_sin_igv'];
                    $setTotalImpuestos  = $filaDet['igv'];
                    $setMtoImpVenta     = $filaDet['precio_con_igv'];
                    /**********************************************************/
                    $baseDisponible     = ($baseDisponible + $setValorVenta);
                    $totalImpuestos     = ($totalImpuestos + $setTotalImpuestos);
                    $importeTotal       = ($importeTotal + $setMtoImpVenta);
                }
                /**************************************************************/
                $totalBase              = ($totalBase + $baseDisponible);
                $totalIgv               = ($totalIgv + $totalImpuestos);
                $totalBoletas           = ($totalBoletas + $importeTotal);
                /**************************************************************/
            ?>
                <tr>
                    <td align="left"><?= $local ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td align="left"><?= $compro ?></td>
                    <td align="left"><?= $serie ?></td>
                    <td align="left"><?= $num_comprobante ?></td>
                    <td align="left"><?= $tipoDoc ?></td>
                    <td align="left"><?= $documento ?></td>
                    <td align="left"><?= $nombre_cliente ?></td>
                    <td align="left"><?= number_format($baseDisponible, 2) ?></td>
                    <td>0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;"><?= number_format($totalImpuestos, 2) ?></td>
                    <td style="text-align: right;"><?= number_format($importeTotal, 2) ?></td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1"><strong>(<?= $numBol ?>) Facturas</strong></td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1"><strong><?= number_format($totalBoletas, 2) ?></strong></td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <!-- ********************************************************** -->
            <!-- ********  CREACION REPORTE NOTAS DE CREDITO    *********** -->
            <!-- ********************************************************** -->
            <?php
            $sqlListado         = mysqli_query($conexion, "SELECT * FROM factura WHERE fecha_registro>='$fecha_inicio' AND fecha_registro<='$fecha_final' AND codigo_compro='07' ORDER BY serie, num_comprobante ASC");
            $numNota            = 0;
            $totalNotaCredito   = 0;
            $totalIgv           = 0;
            $totalBase          = 0;
            while ($fila        = mysqli_fetch_array($sqlListado)) {
                $id_factura     = $fila['id_factura'];
                $fecha_registro = date('d-m-Y', strtotime($fila['fecha_registro']));
                $codigo_compro  = $fila['codigo_compro'];
                $serie          = $fila['serie'];
                $documento      = $fila['numero_documento'];
                if ($serie      == 'BB01' || $serie      == 'FF01') {
                    $local      = '001';
                }
                if ($serie      == 'BB02' || $serie      == 'FF02') {
                    $local      = '002';
                }
                if ($serie      == 'BB03' || $serie      == 'FF03') {
                    $local      = '003';
                }
                $doc_moficado   = explode("-", $fila['doc_modificado']);
                $serieMod       = $doc_moficado[0];
                $numMod         = $doc_moficado[1];
                $tipo_doc_modif = $fila['cod_tipo_compro_modif'];
                $doc_tipodoc    = $fila['doc_tipodoc'];
                /*************************************************************/
                $sqlFechDoc     = mysqli_query($conexion, "SELECT fecha_registro FROM factura WHERE serie='$serieMod' AND num_comprobante='$numMod' AND cod_tipo_compro_modif='$tipo_doc_modif'");
                $ffechas        = mysqli_fetch_array($sqlFechDoc);
                $fecha_doc_mod  = $ffechas['fecha_registro'];
                /*************************************************************/
                $nombre_cliente = utf8_encode($fila['razon_social']);
                if ($doc_tipodoc == '1') {
                    $compro         = '&nbsp;07';
                    $tipoDoc        = '&nbsp;06';
                }
                if ($doc_tipodoc == '2') {
                    $compro         = '&nbsp;07';
                    $tipoDoc        = '&nbsp;01';
                }
                $num_comprobante  = ceroizquierda($fila['num_comprobante'], 8);
                $numNota++;
                /**************************************************************/
                /*****************  DETALLE DE FACTURAS  **********************/
                /**************************************************************/
                $baseDisponible = 0;
                $totalImpuestos = 0;
                $importeTotal   = 0;
                $sqlDetalles    = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
                while ($filaDet  = mysqli_fetch_array($sqlDetalles)) {
                    $setValorVenta      = $filaDet['precio_sin_igv'];
                    $setTotalImpuestos  = $filaDet['igv'];
                    $setMtoImpVenta     = $filaDet['precio_con_igv'];
                    /**********************************************************/
                    $baseDisponible     = ($baseDisponible + $setValorVenta);
                    $totalImpuestos     = ($totalImpuestos + $setTotalImpuestos);
                    $importeTotal       = ($importeTotal + $setMtoImpVenta);
                }
                /**************************************************************/
                $totalBase              = ($totalBase + $baseDisponible);
                $totalIgv               = ($totalIgv + $totalImpuestos);
                $totalNotaCredito       = ($totalNotaCredito + $importeTotal);
                /**************************************************************/
            ?>
                <tr>
                    <td align="left"><?= $local ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td align="left"><?= $compro ?></td>
                    <td align="left"><?= $serie ?></td>
                    <td align="left"><?= $num_comprobante ?></td>
                    <td align="left"><?= $tipoDoc ?></td>
                    <td align="left"><?= $documento ?></td>
                    <td align="left"><?= $nombre_cliente ?></td>
                    <td align="left"><?= number_format($baseDisponible, 2) ?></td>
                    <td>0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;"><?= number_format($totalImpuestos, 2) ?></td>
                    <td style="text-align: right;"><?= number_format($importeTotal, 2) ?></td>
                    <td align="right">&nbsp;</td>
                    <td align="right"><?= $fecha_doc_mod ?></td>
                    <td align="right"><?= $tipo_doc_modif ?></td>
                    <td align="right"><?= $serieMod ?></td>
                    <td align="right"><?= $numMod ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1"><strong>(<?= $numNota ?>) Notas de Credito</strong></td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1">0.00</td>
                <td bgcolor="#E1E1E1"><strong></strong></td>
                <td bgcolor="#E1E1E1"><strong><?= number_format($totalNotaCredito, 2) ?></strong></td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
                <td bgcolor="#E1E1E1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <!-- ********************************************************** -->
            <!-- ********************************************************** -->
        </tbody>
    </table>
    <h2>Totales</h2>
    <table width="50%" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td><strong>Total Facturas</strong></td>
                <td>0</td>
                <td align="right"><strong>S/. <?= number_format($totalFacturas, 2) ?></strong></td>
            </tr>
            <tr>
                <td><strong>Total Boletas</strong></td>
                <td>0</td>
                <td align="right"><strong>S/. <?= number_format($totalBoletas, 2) ?></strong></td>
            </tr>
            <tr>
                <td><strong>Total Nota Credito</strong></td>
                <td>0</td>
                <td align="right"><strong>S/. <?= number_format($totalNotaCredito, 2) ?></strong></td>
            </tr>
            <tr>
                <td><strong>Total General</strong></td>
                <td>0</td>
                <td align="right"><strong>S/. <?= number_format(($totalFacturas + $totalBoletas - $totalNotaCredito), 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>