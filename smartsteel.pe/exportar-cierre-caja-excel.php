<?php
require("config/conexion.php");
/***********************************************/
/***********************************************/
$nombreExcel = "reporte-cierre-caja-" . date('d-m-Y-His') . ".xls";
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
$cod_puntoventa     = $_REQUEST['cod_puntoventa'];
$cod_apertura       = $_REQUEST['cod_apertura'];
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
$sqlPuntoVenta      = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
$pventa             = mysqli_fetch_array($sqlPuntoVenta);
$nombre_puntoventa  = $pventa['nombre_puntoventa'];
/***********************************************/
/***********************************************/
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte Cierre de Caja</title>
</head>

<body>
    <h1>Reporte Cierre de Caja del Local <?= $nombre_puntoventa ?></h1>
    <p>FECHA : <?= $fecha_reporte; ?><br>
        RUC : <?= $xeruc ?><br>
        RAZON SOCIAL : <?= $xerazon ?></p>
    <!-- ****************************************************** -->
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <th bgcolor="#e1e1e1">Nº</th>
            <th bgcolor="#e1e1e1">Documento</th>
            <th bgcolor="#e1e1e1">Serie</th>
            <th bgcolor="#e1e1e1">Fecha Registro</th>
            <th bgcolor="#e1e1e1">Cliente</th>
            <th bgcolor="#e1e1e1">Total</th>
            <th bgcolor="#e1e1e1">Asesor Ventas</th>
        </tr>
        <?php
        $sqlConsulta                = mysqli_query($conexion, "SELECT * FROM factura WHERE cod_apertura='$cod_apertura' AND cod_puntoventa='$cod_puntoventa' ORDER BY fecha_registro DESC");
        $numRes                     = mysqli_num_rows($sqlConsulta);
        if ($numRes > 0) {
            while ($fconst = mysqli_fetch_array($sqlConsulta)) {
                $codigo_compro      = $fconst['codigo_compro'];
                $serie              = $fconst['serie'] . '-' . str_pad($fconst['num_comprobante'], 8, "0", STR_PAD_LEFT);
                $fecha_registro     = date('d-m-Y', strtotime($fconst['fecha_registro']));
                $razon_social       = $fconst['razon_social'];
                $total_monto        = $fconst['total_monto'];
                $cod_personal       = $fconst['cod_personal'];
                /*****************************************************/
                $sqlDocumento       = mysqli_query($conexion, "SELECT * FROM tipo_documento WHERE codigo_compro='$codigo_compro'");
                $fdoc               = mysqli_fetch_array($sqlDocumento);
                $documento          = $fdoc['descripcion'];
                /*****************************************************/
                $sqlPersonal        = mysqli_query($conexion, "SELECT * FROM personal WHERE cod_personal='$cod_personal'");
                $fper               = mysqli_fetch_array($sqlPersonal);
                $asesor_ventas      = $fper['nombres'];
                /*****************************************************/
                if ($codigo_compro == '07') {
                    $totalNotasCredito +=  $total_monto;
                } else {
                    $totalVentas +=  $total_monto;
                }
                $num++;
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $documento ?></td>
                    <td><?= $serie ?></td>
                    <td><?= $fecha_registro ?></td>
                    <td><?= $razon_social ?></td>
                    <td align="right">s/. <?= number_format($total_monto, 2) ?></td>
                    <td><?= $asesor_ventas ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="5" bgcolor="#e1e1e1">TOTAL VENTAS</td>
                <td align="right" bgcolor="#e1e1e1">s/. <?= number_format($totalVentas, 2) ?></td>
                <td bgcolor="#e1e1e1"></td>
            </tr>
            <tr>
                <td colspan="5" bgcolor="#e1e1e1">TOTAL NOTAS DE CREDITO</td>
                <td align="right" bgcolor="#e1e1e1">s/. <?= number_format($totalNotasCredito, 2) ?></td>
                <td bgcolor="#e1e1e1" </td>
            </tr>
            <tr>
                <td colspan="5" bgcolor="#e1e1e1">TOTAL GENERAL</td>
                <td align="right" bgcolor="#e1e1e1">s/. <?= number_format($totalVentas - $totalNotasCredito, 2) ?></td>
                <td bgcolor="#e1e1e1"></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="7" align="center">¡ERROR! Lo sentimos pero no encontramos datos para la consulta</td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>