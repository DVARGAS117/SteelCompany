<?php
require("config/conexion.php");
/***********************************************/
/***********************************************/
$nombreExcel = "reporte-productos-almacen-" . date('d-m-Y-His') . ".xls";
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
$tipo_reporte       = $_POST['tipo_reporte'];
$cod_categoria      = $_POST['cod_categoria'];
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
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte Productos Almacen</title>
</head>

<body>
    <h1>REPORTE DE PRODUCTOS DEL ALMACEN</h1>
    <p>FECHA : <?= $fecha_reporte; ?><br>
        RUC : <?= $xeruc ?><br>
        RAZON SOCIAL : <?= $xerazon ?></p>
    <!-- ****************************************************** -->
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <th>Nº</th>
            <th>Fecha Creacion</th>
            <th>Categoria</th>
            <th>Marca</th>
            <th>Código</th>
            <th>Nombre Producto</th>
            <th>Un. Medida</th>
            <th align="right">Stock Actual</th>
            <th align="right">Precio Unitario</th>
            <th align="right">Precio Cuarto</th>
            <th align="right">Precio Mayor</th>
            <th>Estado</th>
        </tr>
        <?php
        if ($tipo_reporte == 'Todos') {
            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM productos");
        } else {
            $sqlConsulta            = mysqli_query($conexion, "SELECT * FROM productos WHERE cod_categoria='$cod_categoria'");
        }
        $numRes         = mysqli_num_rows($sqlConsulta);
        if ($numRes > 0) {
            while ($fconst = mysqli_fetch_array($sqlConsulta)) {
                $fecha_creacion     = date('d-m-Y', strtotime($fconst['fecha_creacion']));
                $cod_categoria      = $fconst['cod_categoria'];
                $cod_marca          = $fconst['cod_marca'];
                $codigo             = $fconst['codigo'];
                $nombre_producto    = $fconst['nombre_producto'];
                $unidad_medida      = $fconst['unidad_medida'];
                $stock_actual       = $fconst['stock_actual'];
                $precio_unitario    = $fconst['precio_unitario'];
                $precio_cuarto      = $fconst['precio_cuarto'];
                $precio_mayor       = $fconst['precio_mayor'];
                if ($fconst['estado'] == 'A') {
                    $estado         = "Activo";
                } else {
                    $estado         = "Inactivo";
                }
                /*****************************************************/
                $sqlCategorias      = mysqli_query($conexion, "SELECT * FROM categoria_productos WHERE cod_categoria='$cod_categoria'");
                $fcats              = mysqli_fetch_array($sqlCategorias);
                $categoria          = $fcats['categoria'];
                /*****************************************************/
                $sqlMarcas          = mysqli_query($conexion, "SELECT * FROM marcas WHERE cod_marca='$cod_marca'");
                $fmarc              = mysqli_fetch_array($sqlMarcas);
                $marca              = $fmarc['marca'];
                /*****************************************************/
                $num++;
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $fecha_creacion ?></td>
                    <td><?= $categoria ?></td>
                    <td><?= $marca ?></td>
                    <td><?= $codigo ?></td>
                    <td><?= $nombre_producto ?></td>
                    <td><?= $unidad_medida ?></td>
                    <td align="right"><?= $stock_actual ?></td>
                    <td align="right">s/. <?= $precio_unitario ?></td>
                    <td align="right">s/. <?= $precio_cuarto ?></td>
                    <td align="right">s/. <?= $precio_mayor ?></td>
                    <td><?= $estado ?></td>
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