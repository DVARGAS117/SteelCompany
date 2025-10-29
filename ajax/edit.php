<?php
require("../config/conexion.php");
require("../config/inicializar-datos.php");
$proceso        = $_POST['proceso'];
if ($proceso == 'EditarSalidaStock') {
    $value      = $_POST['value'];
    $field      = $_POST['field'];
    $porciones  = explode("-", $field);
    $data1      = $porciones[0];
    $id_tmp     = $porciones[1];
    if ($value > 0) {
        $sqlActualizar = mysqli_query($conexion, "UPDATE tmp_salidastock SET $data1='$value' WHERE id_tmp='$id_tmp'");
    }
}
/***************************************************/
/***************************************************/
if ($proceso == 'EditarFactura') {
    sleep(1);
    $data       = $_POST['value'];
    $field      = $_POST['field'];
    $porciones  = explode("-", $field);
    $data1      = $porciones[0]; //Nombre Campo
    $data2      = $porciones[1]; //id_tmp
    if ($data > 0) {
        $sqlActualizar = mysqli_query($conexion, "UPDATE tmp_ventas SET $data1='$data' WHERE id_tmp='$data2'");
        echo $data;
    }
}
