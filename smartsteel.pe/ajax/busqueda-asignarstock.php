<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
$q      = $_POST['palabra'];
echo "
<table id='datatable-buttons' class='table table-striped table-bordered dt-responsive nowrap' style='border-collapse: collapse; border-spacing: 0; width: 100%;'>
    <thead>
        <tr>
            <th width='60%'>Producto</th>
            <th width='15%'>Codigo</th>
            <th width='10%'>S. Actual</th>
            <th width='10%'>S. Salida</th>
            <th width='5%'></th>
        </tr>
    </thead>
    <tbody>";
if (strlen($q) >= 1) {
    $sqlBusqueda    = mysqli_query($conexion, "SELECT cod_producto, codigo, nombre_producto, stock_actual FROM productos WHERE nombre_producto LIKE '%$q%' OR codigo LIKE '%$q%' LIMIT 10");
    $numRes         = mysqli_num_rows($sqlBusqueda);
    if ($numRes > 0) {
        while ($fbus = mysqli_fetch_array($sqlBusqueda)) {
            $c_p             = $fbus['cod_producto'];
            $codigo          = $fbus['codigo'];
            $nombre_producto = $fbus['nombre_producto'];
            $stock_actual    = $fbus['stock_actual'];
            $i++;
?>
            <tr>
                <td><?= $nombre_producto ?></td>
                <td><?= $codigo ?></td>
                <td><?= $stock_actual ?></td>
                <td>
                    <input type="text" id="cant_<?= $c_p ?>" value="1" onfocus="this.value=''" onblur="if(this.value==''){this.value='1'}" class="form-control">
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
            <td colspan="4">¡Lo sentimos, no se encontro el producto en stock!</td>
        </tr>
<?php
    }
}
?>
</tbody>
</table>
<script>
    $(function() {
        $(".agregar").click(function() {
            var cod_prod = $(".cod_prod", this).val();
            var stock = parseInt($(".stock", this).val());
            var cant = parseInt($("#cant_" + cod_prod).val());
            if (cant > stock) {
                alert("La cantidad excede al stock");
                $("#cant_" + cod_prod).focus();
                return false
            }
            agregar2(cod_prod, cant);
        })
    })
</script>