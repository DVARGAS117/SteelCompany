<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
$session_id     = session_id();
if (isset($_POST['cod_producto'])) {
    $id         = $_POST['cod_producto'];
}
if (isset($_POST['cantidad'])) {
    $cantidad   = $_POST['cantidad'];
}
/*****************************************************/
/*****************************************************/
if (!empty($id) and ($cantidad > 0)) {
    $sqlVerificar   = mysqli_query($conexion, "SELECT COUNT(*) AS numrows FROM tmp_salidastock WHERE cod_producto='$id' AND session_id='$session_id'");
    $fila           = mysqli_fetch_array($sqlVerificar);
    $numrows        = $fila['numrows'];
    if ($numrows == 0) {
        $sqlInsertar = mysqli_query($conexion, "INSERT INTO tmp_salidastock (
        cod_producto,
        cantidad_tmp,
        session_id
        )VALUES(
        '$id',
        '$cantidad',
        '$session_id')");
    } else {
        $sqlActualizar = mysqli_query($conexion, "UPDATE tmp_salidastock SET cantidad_tmp=(cantidad_tmp+$cantidad) WHERE session_id='$session_id' AND cod_producto='$id'");
    }
}
/*****************************************************/
/*****************************************************/
if (isset($_GET['id'])) {
    $id_tmp = intval($_GET['id']);
    $sqlEliminar = mysqli_query($conexion, "DELETE FROM tmp_salidastock WHERE id_tmp='$id_tmp'");
}
/*****************************************************/
/*****************************************************/
?>
<table id='datatable-buttons' class='table table-striped table-bordered dt-responsive nowrap' style='border-collapse: collapse; border-spacing: 0; width: 100%;'>
    <thead>
        <tr>
            <th width='75%'>Producto</th>
            <th width='10%'>Codigo</th>
            <th width='10%'>Cantidad</th>
            <th width='5%'></th>
        </tr>
    </thead>
    <tbody <?php
            $sumador_total  = 0;
            $sqlListado     = mysqli_query($conexion, "SELECT * FROM tmp_salidastock WHERE tmp_salidastock.session_id='$session_id' ORDER BY id_tmp ASC");
            while ($flist   = mysqli_fetch_array($sqlListado)) {
                $id_tmp         = $flist['id_tmp'];
                $id             = $flist['cod_producto'];
                $cantidad       = $flist['cantidad_tmp'];
                if ($id > 0 and is_numeric(($id))) {
                    $sqlProductos       = mysqli_query($conexion, "SELECT nombre_producto,codigo FROM productos WHERE cod_producto='$id'");
                    $filap              = mysqli_fetch_array($sqlProductos);
                    $nombre_producto    = $filap['nombre_producto'];
                    $codigo             = $filap['codigo'];
                }
            ?> <tr>
        <td><?= $nombre_producto ?></td>
        <td><?= $codigo ?></td>
        <td>
            <textarea name="cantidad_tmp-<?= $id_tmp ?>" id="cantidad_tmp_<?= $id_tmp ?>" class="form-control" style="height: 38px;"><?= $cantidad ?></textarea>
        </td>
        <td>
            <a class="btn btn-primary waves-effect waves-light eliminarpro" onclick="eliminar('<?= $id_tmp ?>')">
                <i class="mdi mdi-delete"></i>
            </a>
        </td>
        </tr>
    <?php
            }
    ?>
    </tbody>
</table>
<script>
    $(function() {
        $("textarea").blur(function() {
            var field = $(this);
            field.css("backgorund-color", "#D0F5A9");
            var datosEnvar = {
                value: $(this).val(),
                field: $(this).attr('name'),
                proceso: "EditarSalidaStock"
            }
            //alert("value :" + datosEnvar.value + " fiel :" + datosEnvar.field + " proceso :" + datosEnvar.proceso)
            $.ajax({
                type: "POST",
                url: "ajax/edit.php",
                data: datosEnvar
            })
        })
    })
</script>