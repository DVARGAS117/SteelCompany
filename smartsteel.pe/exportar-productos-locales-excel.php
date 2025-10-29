<?php
require("config/conexion.php");
/***********************************************/
/***********************************************/
$nombreExcel = "reporte-productos-locales-" . date('d-m-Y-His') . ".xls";
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
$cod_puntoventa     = $_POST['cod_puntoventa'];
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
    <title>Reporte Productos <?= $nombre_puntoventa ?></title>
</head>

<body>
    <h1>Reporte de Productos del Local <?= $nombre_puntoventa ?></h1>
    <p>FECHA : <?= $fecha_reporte; ?><br>
        RUC : <?= $xeruc ?><br>
        RAZON SOCIAL : <?= $xerazon ?></p>
    <!-- ****************************************************** -->
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <th>Nº</th>
            <th>Punto Venta</th>
            <th>Fecha Entrada</th>
            <th>Código</th>
            <th>Nombre Producto</th>
            <th align="right">Stock Ingresado</th>
            <th align="right">Stock Actual</th>
            <th align="right">Total Ventas</th>
        </tr>
        <?php
        $sqlConsulta                = mysqli_query($conexion, "SELECT * FROM stock_locales WHERE cod_puntoventa='$cod_puntoventa'");

        $numRes                     = mysqli_num_rows($sqlConsulta);
        if ($numRes > 0) {
            while ($fconst = mysqli_fetch_array($sqlConsulta)) {
                $cod_puntoventa     = $fconst['cod_puntoventa'];
                $fecha_entrada      = date('d-m-Y', strtotime($fconst['fecha_entrada']));
                $codigo             = $fconst['codigo'];
                $nombre_producto    = $fconst['nombre_producto'];
                $stock_ingresado    = $fconst['stock_ingresado'];
                $stock_actual       = $fconst['stock_actual'];
                $total_ventas       = $fconst['total_ventas'];
                /*****************************************************/
                $sqlPuntoVenta      = mysqli_query($conexion, "SELECT * FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
                $pventa             = mysqli_fetch_array($sqlPuntoVenta);
                $nombre_puntoventa  = $pventa['nombre_puntoventa'];
                /*****************************************************/
                $num++;
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $nombre_puntoventa ?></td>
                    <td><?= $fecha_entrada ?></td>
                    <td><?= $codigo ?></td>
                    <td><?= $nombre_producto ?></td>
                    <td align="right"><?= $stock_ingresado ?></td>
                    <td align="right"><?= $stock_actual ?></td>
                    <td align="right"><?= $total_ventas ?></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="12" align="center">¡ERROR! Lo sentimos pero no encontramos datos para la consulta</td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>