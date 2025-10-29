<?php
require("conexion.php");
require("inicializar-datos.php");
$proceso        = $_POST['proceso'];
$cod_acceso     = $_POST['cod_acceso'];
/*************************************************************/
/************  CAMBIAR ESTADO DE CHECKBOX  *******************/
/*************************************************************/
switch($proceso){
    case 'Consultar':
        if ($_POST['consultar'] == 'NO') {
            $consultar = 'SI';
        } else {
            $consultar = 'NO';
        }
        $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET consultar='$consultar' WHERE cod_acceso='$cod_acceso'");
        $resultado  = "SI";
        $salidaJson = array("resultado" => $resultado);
        echo json_encode($salidaJson);
    break;
    case 'Insertar':
        if ($_POST['insertar'] == 'NO') {
            $insertar = 'SI';
        } else {
            $insertar = 'NO';
        }
        $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET insertar='$insertar' WHERE cod_acceso='$cod_acceso'");
        $resultado  = "SI";
        $salidaJson = array("resultado" => $resultado);
        echo json_encode($salidaJson);
    break;
    case 'Editar':
        if ($_POST['editar'] == 'NO') {
            $editar = 'SI';
        } else {
            $editar = 'NO';
        }
        $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET editar='$editar' WHERE cod_acceso='$cod_acceso'");
        $resultado  = "SI";
        $salidaJson = array("resultado" => $resultado);
        echo json_encode($salidaJson);
    break;
    case 'Eliminar':
        if ($_POST['eliminar'] == 'NO') {
            $eliminar = 'SI';
        } else {
            $eliminar = 'NO';
        }
        $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET eliminar='$eliminar' WHERE cod_acceso='$cod_acceso'");
        $resultado  = "SI";
        $salidaJson = array("resultado" => $resultado);
        echo json_encode($salidaJson);
    break;
}
// if ($_POST['consultar'] == 'NO') {
//     $consultar = 'SI';
// } else {
//     $consultar = 'NO';
// }
// if ($_POST['insertar'] == 'NO') {
//     $insertar = 'SI';
// } else {
//     $insertar = 'NO';
// }
// if ($_POST['editar'] == 'NO') {
//     $editar = 'SI';
// } else {
//     $editar = 'NO';
// }
// if ($_POST['eliminar'] == 'NO') {
//     $eliminar = 'SI';
// } else {
//     $eliminar = 'NO';
// }
/*************************************************************/
/************  ACTUALIZAR ESTADO EN BASE DATOS ***************/
/*************************************************************/
// if ($proceso == 'Consultar') {
//     $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET consultar='$consultar' WHERE cod_acceso='$cod_acceso'");
//     $resultado  = "SI";
//     $salidaJson = array("resultado" => $resultado);
//     echo json_encode($salidaJson);
// }
/*************************************************************/
// if ($proceso == 'Insertar') {
//     $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET insertar='$insertar' WHERE cod_acceso='$cod_acceso'");
//     $resultado  = "SI";
//     $salidaJson = array("resultado" => $resultado);
//     echo json_encode($salidaJson);
// }
/*************************************************************/
// if ($proceso == 'Editar') {
//     $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET editar='$editar' WHERE cod_acceso='$cod_acceso'");
//     $resultado  = "SI";
//     $salidaJson = array("resultado" => $resultado);
//     echo json_encode($salidaJson);
// }
/*************************************************************/
// if ($proceso == 'Eliminar') {
//     $sqlActualizar = mysqli_query($conexion, "UPDATE accesos_usuarios SET eliminar='$eliminar' WHERE cod_acceso='$cod_acceso'");
//     $resultado  = "SI";
//     $salidaJson = array("resultado" => $resultado);
//     echo json_encode($salidaJson);
// }
/*************************************************************/
