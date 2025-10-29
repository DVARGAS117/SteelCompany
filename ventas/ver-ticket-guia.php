<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
require("../config/EnLetras.php");
date_default_timezone_set('America/Lima');
/****************************************************************************/
/****************************************************************************/
$id_guia        = $_REQUEST['id_guia'];
$sqlVerificar   = mysqli_query($conexion, "SELECT * FROM guias_remision WHERE id_guia='$id_guia'");
$numFact        = mysqli_num_rows($sqlVerificar);
if ($numFact == 0) {
    echo "
	<script>
		alert('Guia no encontrada');
		window.close();
	</script>";
    exit;
}
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
$fecha_traslado     = $rw_factura['fecha_traslado'];
$fecha_llegada      = $rw_factura['fecha_llegada'];
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
                    echo "
                    <strong>RUC : $xRucEmpresa</strong><br>
                    $xDirecEmpre<br>
                    Telefono : $xTelefEmpre<br>
                    Email : $xEmailEmpre";
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <strong style="font-size: 16px; font-weight: 600;">
                        <?php
                        echo $documento . "<br>";
                        echo $serie . '-' . str_pad($num_guia, 8, "0", STR_PAD_LEFT);
                        ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
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
                    <td>RUC/DNI : $numero_documento</td>
                </tr>";
            }
            if ($direccion_empresa != '') {
                echo "
                <tr>					
                    <td>DIRECCION : $direccion_empresa</td>
                </tr>";
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
            $sqlDetalleFact     = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
            while ($fDetFac     = mysqli_fetch_array($sqlDetalleFact)) {
                $producto       = $fDetFac['producto'];
                $cantidad       = $fDetFac['cantidad'];
                $precio         = $fDetFac['precio'];
                $totalProduct   = ($cantidad * $precio);
                $subTotal      += $totalProduct;
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
            <tr>
                <td colspan="3" align="right">IMPORTE TOTAL :</td>
                <td align="right">s/. <?= number_format($subTotal, 2) ?></td>
            </tr>
            <tr>
                <td colspan="4">==================================================</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    PESO : <?= $peso ?><br>
                    Nº PAQUETES : <?= $numero_paquetes ?><br>
                    MOTIVO TRASLADO : <?= $motivo_traslado ?><br>
                    FECHA TRASALADO : <?= $fecha_traslado ?><br>
                    FECHA LLEGADA : <?= $fecha_llegada ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">==================================================</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <img src="qr/<?= $codigo_compro . '-' . $serie . '-' . $num_guia . '.png'; ?>" alt="" width="100" height="100">
                </td>
            </tr>
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