<?php
require("conexion.php");
session_start();
if (isset($_POST['proceso'])) {
    $proceso            = $_POST['proceso'];
    if ($proceso == 'IniciarProceso') {
        $usuario                    = sha1($_POST['usuario']);
        $clave                      = sha1($_POST['clave']);
        $sqlPersonal                = mysqli_query($conexion, "SELECT * FROM personal WHERE usuario='$usuario' AND clave='$clave' AND estado='A'");
        $numPer                     = mysqli_num_rows($sqlPersonal);
        if ($numPer > 0) {
            $fpers                  = mysqli_fetch_array($sqlPersonal);
            $xCodPer                = $fpers['cod_personal'];
            $xNombres               = $fpers['nombres'];
            $xEmail                 = $fpers['email'];
            $xTienda                = $fpers['cod_puntoventa'];
            $xCargo                 = $fpers['cargo'];
            if ($fpers['imagen'] == '') {
                $xImagen            = "default.png";
            } else {
                $xImagen            = $fpers['imagen'];
            }
            $_SESSION['xCodPer']    = $xCodPer;
            $_SESSION['xNombres']   = $xNombres;
            $_SESSION['xEmail']     = $xEmail;
            $_SESSION['xTienda']    = $xTienda;
            $_SESSION['xCargo']     = $xCargo;
            $_SESSION['xImagen']    = $xImagen;
            $respuesta              = "SI";
        } else {
            $respuesta              = "NO";
        }
    }
    $salidaJson     = array("respuesta" => $respuesta);
    echo json_encode($salidaJson);
} else {
    header("location:../seguridad.php");
}
