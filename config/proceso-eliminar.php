<?php
require("conexion.php");
require("inicializar-datos.php");
$modulo     = $_POST['modulo'];
/***************************************************************/
/******************** BORRAR PUNTOS DE VENTA *******************/
/***************************************************************/
if ($modulo == 'PuntoVenta') {
    $cod_puntoventa     = $_POST['cod_puntoventa'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM puntos_ventas WHERE cod_puntoventa='$cod_puntoventa'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       BORRAR PERSONAL     ****************/
/***************************************************************/
if ($modulo == 'Personal') {
    $cod_personal       = $_POST['cod_personal'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM personal WHERE cod_personal='$cod_personal'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       BORRAR CATEGORIA    ****************/
/***************************************************************/
if ($modulo == 'Categorias') {
    $cod_categoria      = $_POST['cod_categoria'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM categoria_productos WHERE cod_categoria='$cod_categoria'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       BORRAR MARCAS       ****************/
/***************************************************************/
if ($modulo == 'Marcas') {
    $cod_marca          = $_POST['cod_marca'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM marcas WHERE cod_marca='$cod_marca'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       BORRAR PRODUCTOS    ****************/
/***************************************************************/
if ($modulo == 'Productos') {
    $cod_producto       = $_POST['cod_producto'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM productos WHERE cod_producto='$cod_producto'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       SERIE DOCUMENTOS    ****************/
/***************************************************************/
if ($modulo == 'SeriesDocumento') {
    $cod_serie       = $_POST['cod_serie'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM serie_documentos WHERE cod_serie='$cod_serie'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/********************       TIPO DOCUMENTOS     ****************/
/***************************************************************/
if ($modulo == 'TipoDocumento') {
    $cod_tipo_compro    = $_POST['cod_tipo_compro'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM tipo_documento WHERE cod_tipo_compro='$cod_tipo_compro'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/*******************      TIPO NOTA CREDITO     ****************/
/***************************************************************/
if ($modulo == 'TipoNotaCredito') {
    $cod_motivo         = $_POST['cod_motivo'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM motivo_nota_credito WHERE cod_motivo='$cod_motivo'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/*******************      CLIENTES              ****************/
/***************************************************************/
if ($modulo == 'Clientes') {
    $cod_cliente        = $_POST['cod_cliente'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM clientes WHERE cod_cliente='$cod_cliente'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/*******************       CARGOS               ****************/
/***************************************************************/
if ($modulo == 'Cargos') {
    $cod_cargo          = $_POST['cod_cargo'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM cargos_personal WHERE cod_cargo='$cod_cargo'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/*******************       MODULOS              ****************/
/***************************************************************/
if ($modulo == 'Modulos') {
    $cod_modulo         = $_POST['cod_modulo'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM modulos WHERE cod_modulo='$cod_modulo'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
/***************************************************************/
/*******************      SUB MODULOS           ****************/
/***************************************************************/
if ($modulo == 'SubModulos') {
    $cod_submodulo         = $_POST['cod_submodulo'];
    $sqlEliminar        = mysqli_query($conexion, "DELETE FROM sub_modulos WHERE cod_submodulo='$cod_submodulo'");
    $resultado          = "SI";
    $salidaJson         = array("resultado" => $resultado);
    echo json_encode($salidaJson);
}
