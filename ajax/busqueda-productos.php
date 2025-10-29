<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
$q      = $_POST['palabra'];
echo "
<table id='datatable-buttons' class='table table-striped table-bordered dt-responsive nowrap' style='border-collapse: collapse; border-spacing: 0; width: 100%;'>
    <thead>
        <tr>
            <th width='48%'>Producto</th>
            <th width='8%'>S. Actual</th>
            <th width='8%'>P. Unit</th>
            <th width='8%'>P. Cuart</th>
            <th width='8%'>P. Mayor</th>
            <th width='7%'>Cant</th>
            <th width='8%'>P. Venta</th>
            <th width='5%'></th>
        </tr>
    </thead>
    <tbody>";
if (strlen($q) >= 1) {
    $sqlBusqueda    = mysqli_query($conexion, "SELECT cod_producto, codigo, nombre_producto, stock_actual FROM stock_locales WHERE cod_puntoventa='$xTienda' AND (nombre_producto LIKE '%$q%' OR codigo LIKE '%$q%') LIMIT 10");
    $numRes         = mysqli_num_rows($sqlBusqueda);
    if ($numRes > 0) {
        while ($fbus = mysqli_fetch_array($sqlBusqueda)) {
            $c_p             = $fbus['cod_producto'];
            $codigo          = $fbus['codigo'];
            $nombre_producto = $fbus['nombre_producto'];
            $stock_actual    = $fbus['stock_actual'];
            /*****************************************************/
            $sqlProductos    = mysqli_query($conexion, "SELECT precio_unitario, precio_cuarto, precio_mayor FROM productos WHERE cod_producto='$c_p'");
            $fprods          = mysqli_fetch_array($sqlProductos);
            $p_unit          = $fprods['precio_unitario'];
            $p_cuar          = $fprods['precio_cuarto'];
            $p_may           = $fprods['precio_mayor'];
            /*****************************************************/
            $i++;
?>
            <tr>
                <td><?= $nombre_producto ?><br><?= $codigo ?></td>
                <td><?= $stock_actual ?></td>
                <td>s/. <?= $p_unit ?></td>
                <td>s/. <?= $p_cuar ?></td>
                <td>s/. <?= $p_may ?></td>
                <td>
                    <input type="text" id="cant_<?= $c_p ?>" data="<?= $stock_actual ?>" value="1" onfocus="this.value=''" onblur="if(this.value==''){this.value='1'}" class="form-control">
                </td>
                <td>
                    <input type="text" id="precio_<?= $c_p ?>" value="<?= $p_unit ?>" onfocus="this.value=''" onblur="if(this.value==''){this.value='<?= $p_unit ?>'}" class="form-control">
                </td>
                <td>
                    <a class="btn btn-primary waves-effect waves-light agregar">
                        <i class="mdi mdi-plus-thick"></i>
                        <input type="hidden" class="cod_prod" value="<?= $c_p ?>">
                        <input type="hidden" class="stock" value="<?= $stock_actual ?>">
                    </a>
                </td>
            </tr>
        <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="8" align="center">¡Lo sentimos, no existe el producto en la tienda!</td>
        </tr>
<?php
    }
}
?>
</tbody>
</table>
<script>
    $(function() {
        /****************************************************/
        /****************************************************/
        $(".agregar").click(function() {
            var cod_prod = $(".cod_prod", this).val();
            var stock = parseInt($(".stock", this).val());
            var cant = parseInt($("#cant_" + cod_prod).val());
            var precio = parseFloat($("#precio_" + cod_prod).val());
            if (precio <= 0) {
                alert("Error el precio no puede ser meno o igua a cero");
                return false
            }
            if (cant > stock) {
                alert("La cantidad excede al stock");
                $("#cant_" + cod_prod).focus();
                return false
            } else {
                agregar(cod_prod, cant, precio);
            }
        })
    })
</script>