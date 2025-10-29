<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
$id_factura     = $_POST['id_factura'];
$sqlVaciarTabla = mysqli_query($conexion, "TRUNCATE TABLE tmp_ventas");
/*****************************************************/
/*****************************************************/
$session_id     = session_id();
$sqlDetalleFact = mysqli_query($conexion, "SELECT * FROM detalle_factura WHERE id_factura='$id_factura'");
while ($ffact   = mysqli_fetch_array($sqlDetalleFact)) {
    $producto   = $ffact['producto'];
    $serie      = $ffact['serie'];
    $cantidad   = $ffact['cantidad'];
    $precio     = $ffact['precio'];
    /*************************************************/
    $sqlProductos   = mysqli_query($conexion, "SELECT cod_producto FROM productos WHERE nombre_producto='$producto'");
    $fprod          = mysqli_fetch_array($sqlProductos);
    $cod_producto   = $fprod['cod_producto'];
    /*************************************************/
    $insert_tmp     = mysqli_query($conexion, "INSERT INTO tmp_ventas (
    cod_producto,
    cantidad_tmp,
    precio_tmp,
    session_id,
    tienda
    )VALUES(
    '$cod_producto',
    '$cantidad',
    '$precio',
    '$session_id',
    '$xTienda')");
}
/*****************************************************/
/*****************************************************/
if (isset($_GET['id'])) {
    $id_tmp = intval($_GET['id']);
    $sqlEliminar = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE id_tmp='$id_tmp'");
}
/*****************************************************/
/*****************************************************/
?>
<table id='datatable-buttons' class='table table-striped table-bordered dt-responsive nowrap' style='border-collapse: collapse; border-spacing: 0; width: 100%;'>
    <thead>
        <tr>
            <th width='62%'>Producto</th>
            <th width='10%'>Cantidad</th>
            <th width='10%'>Precio s/.</th>
            <th width='15%'>Total s/.</th>
            <th width='3%'></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sumador_total  = 0;
        $sqlListado     = mysqli_query($conexion, "SELECT * FROM tmp_ventas WHERE session_id='$session_id' ORDER BY id_tmp ASC");
        while ($flist   = mysqli_fetch_array($sqlListado)) {
            $id_tmp         = $flist['id_tmp'];
            $id             = $flist['cod_producto'];
            $cantidad       = $flist['cantidad_tmp'];
            $precio_venta   = $flist['precio_tmp'];
            if ($id > 0 and is_numeric(($id))) {
                $sqlProductos       = mysqli_query($conexion, "SELECT nombre_producto, codigo FROM productos WHERE cod_producto='$id'");
                $filap              = mysqli_fetch_array($sqlProductos);
                $nombre_producto    = $filap['nombre_producto'];
                $codigo             = $filap['codigo'];
            }
            /**********************************************************/
            /**********************************************************/
            $precio_venta_f         = number_format($precio_venta, 2);
            $precio_venta_r         = str_replace(",", "", $precio_venta_f);
            $precio_total           = ($precio_venta_r * $cantidad);
            $precio_total_f         = number_format($precio_total, 2);
            $precio_total_r         = str_replace(",", "", $precio_total_f);
            $sumador_total          = ($sumador_total + $precio_total_r);
            /**********************************************************/
            /**********************************************************/
        ?>
            <tr>
                <td><?= $nombre_producto ?></td>
                <td>
                    <textarea name="cantidad_tmp-<?= $id_tmp ?>" id="cantidad_tmp_<?= $id_tmp ?>" class="form-control input cantidades" style="height: 38px;"><?= $cantidad ?></textarea>
                </td>
                <td>
                    <textarea name="precio_tmp-<?= $id_tmp ?>" id="cantidad_tmp_<?= $id_tmp ?>" class="form-control input precios" style="height: 38px;"><?= $precio_venta_f ?></textarea>
                </td>
                <td>
                    <input type="text" readonly value="<?= $precio_total_r ?>" class="form-control monto total" size="10" style="width: 100%;">
                </td>
                <td>
                    <a class="btn btn-danger waves-effect waves-light eliminarpro" onclick="eliminar('<?= $id_tmp ?>')">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </td>
            </tr>
        <?php
        }
        $subtotal       = number_format($sumador_total, 2, '.', '');
        $total_factura  = $subtotal / 1.18;
        $total_igv      = $total_factura * 0.18
        ?>
        <tr>
            <td colspan="3" align="right">TOTAL FACTURA s/.</td>
            <td align="center">
                <input type="text" class="form-control text-right totales" id="subtotal" readonly value="<?= $subtotal ?>" size="10">
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right">TRANSFERENCIAS/VISA s/.</td>
            <td align="center">
                <input type="text" name="pago_transferencia" id="pago_transferencia" class="form-control text-right" placeholder="0.00" size="10">
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right">PAGO FALTANTE s/.</td>
            <td align="center">
                <input type="text" name="pago_faltante" id="pago_faltante" class="form-control text-right faltante" readonly placeholder="0.00" value="<?= $subtotal ?>" size="10">
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right">PAGO EFECTIVO s/.</td>
            <td align="center">
                <input type="text" name="pago_efectivo" id="pago_efectivo" class="form-control text-right" placeholder="0.00" size="10">
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right">VUELVO s/.</td>
            <td align="center">
                <input type="text" name="pago_vuelto" id="pago_vuelto" class="form-control text-right" placeholder="0.00" size="10">
            </td>
            <td></td>
        </tr>
    </tbody>
</table>
<script>
    $(function() {
        /***************************************************/
        /***************************************************/
        $(".precios, .cantidades").keyup(function() {
            $("#pago_transferencia").val('');
            $("#pago_efectivo").val('');
            $("#pago_faltante").val($("#subtotal").val());
            $("#pago_vuelto").val('');
        })
        /***************************************************/
        /***************************************************/
        $("#pago_transferencia").keyup(function() {
            $("#pago_efectivo").val('');
            $("#pago_vuelto").val('');
            var subtotal = $("#subtotal").val();
            var p_transf = $(this).val();
            if (p_transf == 0 || p_transf == '') {
                $("#pago_faltante").val(subtotal);
            } else {
                var p_faltan = parseFloat(subtotal - p_transf);
                $("#pago_faltante").val(p_faltan);
            }
        })
        /***************************************************/
        /***************************************************/
        $("#pago_efectivo").keyup(function() {
            var p_efect = $(this).val();
            var p_falta = $("#pago_faltante").val();
            var p_vuelto = parseFloat(p_efect - p_falta);
            if (p_efect == 0 || p_efect == '') {
                $("#pago_vuelto").val('');
            } else {
                $("#pago_vuelto").val(p_vuelto);
            }
        })
        /***************************************************/
        /***************************************************/
        $("textarea").blur(function() {
            var field = $(this);
            field.css("backgorund-color", "#D0F5A9");
            var datosEnvar = {
                value: $(this).val(),
                field: $(this).attr('name'),
                proceso: "EditarFactura"
            }
            //alert("value :" + datosEnvar.value + " field :" + datosEnvar.field + " proceso :" + datosEnvar.proceso)
            $.ajax({
                type: "POST",
                url: "ajax/edit.php",
                data: datosEnvar
            })
        })
    })
    /*****************************************************/
    /*****************************************************/
    var input = document.querySelectorAll(".input");
    input.forEach(function(e) {
        e.addEventListener("click", multiplica);
        e.addEventListener("keyup", multiplica);
        e.addEventListener("focus", multiplica);
    })
    /*****************************************************/
    /*****************************************************/
    function multiplica() {
        var tr = this.closest("tr");
        var total = 1;
        var inputs = tr.querySelectorAll(".input");
        inputs.forEach(function(e) {
            total *= e.value;
        })
        tr.querySelector(".total").value = total.toFixed(2)
        calcularTotal(this.closest("table"));
    }
    /*****************************************************/
    /*****************************************************/
    function calcularTotal(e) {
        var total = 0;
        var total1 = 0;
        var totales = e.querySelectorAll(".total");
        totales.forEach(function(e) {
            total += parseFloat(e.value);
            total1 += parseFloat(e.value);
        })
        e.getElementsByClassName("totales")[0].value = total.toFixed(2);
        $("#pago_faltante").val(total.toFixed(2));
    }
</script>